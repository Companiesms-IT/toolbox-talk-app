<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AcknowledgedStatusRequest;
use App\Http\Requests\API\AssignedToolboxTalkRequest;
use App\Http\Requests\API\CheckVideoPdfStatusRequest;
use App\Http\Requests\API\CheckVideoPdfsFileStatusRequest;
use App\Http\Requests\API\AttemptQuestionsRequest;
use Illuminate\Http\Request;

use App\Models\ToolboxTalk;
use App\Models\User;
use App\Models\AssignToolboxTalk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Question;
use App\Models\Option;
use App\Models\ResourceVideoLink;
use App\Models\MediaFile;
use Yajra\DataTables\DataTables;
use App\Rules\ResourceUrl;
use App\Http\Requests\API\CreateToolboxTalkRequest;
use App\Http\Requests\API\GetAssignToMeDetailRequest;
use App\Http\Requests\API\UpdateQuestionsRequest;
use App\Http\Requests\API\ExportToolboxTalkPdfRequest;
use App\Http\Requests\API\UpdateAttachmentRequest;
use App\Http\Requests\API\DeleteToolboxTalkRequest;
use App\Http\Requests\API\DeleteUrlAndPdfRequest;
use App\Http\Requests\API\DeleteUpdateCmsLibraryRequest;
use App\Http\Requests\API\GetQuestionOptionsRequest;
use App\Http\Resources\API\GetQuestionOptionsResource;
use App\Http\Resources\API\ToolBoxDetailsResource;
use App\Http\Resources\API\GetAuthUserAssignDetailsResource;
use App\Models\AttemptQuestion;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Support\Facades\Log;
use App\Rules\ExistsOrSoftDeletedRequest;
use App\Http\Resources\API\GetAllAssignedByMeTalksResource;
use App\Http\Resources\API\GetAllCmsLibraryTalksResource;
use App\Http\Resources\API\GetAllCreatedByMeTalksResource;
use App\Http\Resources\API\AttemptQuestionsResource;
use App\Traits\CommonFunctionalityTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class ToolboxTalkController extends Controller
{
    use CommonFunctionalityTrait;
    
    public function createToolboxtalk(CreateToolboxTalkRequest $request){
        try {
            $authUserId = Auth::user()->id ?? '4392';
            DB::beginTransaction();
            $user = User::find(1);
            if (!$user->hasPermissionTo('Creator')) {
                return response()->json([
                    'message' => "You do not have permission to access Create Toolbox Talk feature!",
                ], 200);
            } 
            // if (isset($request->due_date) && !empty($request->due_date)) {
            //     $date = Carbon::createFromFormat('d-m-Y', $request->due_date);
            //     $formattedDate = $date->format('Y-m-d H:i:s');
            // } else {
            //     $formattedDate = null;
            // }
            $toolboxTalk = ToolboxTalk::create([
                'title' => $request->title,
                // 'video_url' => $request->resource_url ?  $request->resource_url : '',
                'user_id' => $authUserId,
                'number_of_questions_to_ask' => isset($request->attemptQuestions) && !empty($request->attemptQuestions) ? $request->attemptQuestions : null,
                'number_of_correct_answer_to_pass' => isset($request->number_of_correct_answer_to_pass) && !empty($request->number_of_correct_answer_to_pass) ? $request->number_of_correct_answer_to_pass : null,
                'is_library' => $request->isLibrary,
                'due_date' => $request->due_date,
                'description' => $request->description ? $request->description : '',
            ]);
            
            $resourceUrl = null;
            $resourceUrlDataWithKey = [];
            $filePath = null;
            $fileData = [];
            $resourceUrlData = [];
           
            if (!empty($request->resource_url)) {
                if (strpos($request->resource_url, ',') !== false) {
                    $resourceUrlData = explode(',', $request->resource_url);
                    if(count($resourceUrlData)  > 0){
                        $i=0;
                        foreach ($resourceUrlData as $url) {
                            $resourceUrlDataWithKey[$i]['video_url'] = $url;
                            $resourceUrlDataWithKey[$i]['toolbox_talk_id'] = $toolboxTalk->id;
                            $i++;
                        }
                    } 
                } else {
                         $resourceUrlDataWithKey[0]['video_url'] = $request->resource_url;
                         $resourceUrlDataWithKey[0]['toolbox_talk_id'] = $toolboxTalk->id;
                }
                
                if($resourceUrlDataWithKey){
                        ResourceVideoLink::insert($resourceUrlDataWithKey); 
                        $toolboxTalk->update(['updated_at' => Carbon::now()]);
                }
            } else if(!empty($request->pdf_file) && count($request->pdf_file) > 0){ 
                $i=0;
                foreach ($request->file('pdf_file') as $file) {
                    $fileName = 'toolbox_talk_' . $toolboxTalk->id . rand(10,100) . time() . '.pdf';
                    $filePath = $file->storeAs('toolbox_talks', $fileName, 'public');
                    $fileData[$i]['file_name'] =  $fileName ;
                    $fileData[$i]['file_path'] = 'storage/'.$filePath;
                    $fileData[$i]['toolbox_talk_id'] = $toolboxTalk->id;
                    $i++;
                } 
                if(count($fileData) > 0){
                    MediaFile::insert($fileData);
                    $toolboxTalk->update(['updated_at' => Carbon::now()]);
                }
            }
            
            if(isset($request->questions) && !empty($request->questions) && ($request->questions != null || $request->questions != '')){
                $questions = json_decode($request->questions, true);
                if(count($questions) < $request->attemptQuestions){
                    return response()->json([
                        'message' => "The number of questios asked must be less than or the same as the amount of questions added!",
                    ], 200);
                }
                if($request->attemptQuestions < $request->numberOfCorrectAnswer){
                    return response()->json([
                        'message' => "The number of correct answer to pass must be less than or the same as the amount of ask questios!",
                    ], 200);
                }
                if (!is_array($questions)) {
                    return response()->json(['error' => 'Invalid questions format'], 400);
                }
                foreach ($questions as $questionData) {
                    $question = $toolboxTalk->questions()->create([
                        'name' => $questionData['text'],
                        'toolbox_talk_id' => $toolboxTalk->id,
                    ]);
                    foreach ($questionData['options'] as $index => $optionName) {
                        $question->options()->create([
                            'name' => $optionName,
                            'correct_answer' => ($index+1 == $questionData['correctAnswer']) ? '1' : '0',  // Check if it's the correct answer
                            'question_id' => $question->id,
                        ]);
                    }
                }
                $toolboxTalk->update(['updated_at' => Carbon::now()]);
            }
            
            //new fresh code 
            if ($request->isLibrary == "1") {
                $toolboxTalk->update(['status' => '0', 'is_created' => '1', 'updated_at' => Carbon::now()]);
            } 
            else if ($request->isLibrary == "2" || $request->isLibrary == "3") {
                $selectUserDetail = json_decode($request->select_user_detail);
                if (!is_array($selectUserDetail)) {
                    return response()->json(['error' => 'Invalid user details format'], 400);
                }
                if (empty($selectUserDetail)) {
                    return response()->json(['error' => 'No user details provided'], 400);
                }
                $toolBoxTalkID = $toolboxTalk->id;
                $dueDateWithoutFormat = $request->due_date;
                $dataToInsert = array_map(function ($userDetail) use ($toolBoxTalkID, $dueDateWithoutFormat) {
                    return [
                        'user_id' => $userDetail->select_user_id,
                        'user_name' => $userDetail->user_name,
                        'toolbox_talk_id' => $toolBoxTalkID,
                        'due_date' => $dueDateWithoutFormat,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }, $selectUserDetail);
                AssignToolboxTalk::insert($dataToInsert);
                $toolboxTalk->update(['status' => '1', 'is_created' => '1', 'updated_at' => Carbon::now()]);
            }
            
            DB::commit();
            return response()->json(['msg' => 'Toolbox Talk created successfully', 'data' => $toolboxTalk], 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to create Toolbox Talk: ' . $e->getMessage()], 500);
        }
    }

    /** Get roles and permissions */
    public function getRolesPermissions() {
        try {
            $roles = Role::get();
            $permissions = Permission::get();
            $users = User::where('id', '!=', "1")->orderBy('id', 'DESC')->get();
            return response()->json([
                'roles' => $roles,
                'permissions' => $permissions,
                'users' => $users   
            ]);
        }
        catch(Exception $e){
            return response()->json(['error' => 'Failed to fetch Toolbox Talks: ' . $e->getMessage()], 500);
        }
    }

    /** Assign Toolbox Talk */
    public function assignToolboxTalk(AssignedToolboxTalkRequest $request) {
        try{
            $toolboxTalk = ToolboxTalk::withTrashed()->find($request->toolbox_talk_id);
            if (!$toolboxTalk) {
                return response()->json(['error' => 'Toolbox Talk not found'], 404);
            }
            if($toolboxTalk->status == 1){
                return response()->json(['message' => 'Toolbox has already been assigned'], 409);
            }
            DB::beginTransaction();
            if ((isset($request->selectAll) && $request->selectAll == 'true') || ((isset($request->selectDept) && $request->selectDept == 'true') 
                && (isset($request->selectRole) && $request->selectRole == 'true')) || (isset($request->selectUser) && $request->selectUser == 'true')) {
                $dataToInsert = [];
                $due_date = $request->due_date ? $request->due_date : null;
                User::chunk(100, function ($allUsers) use ($toolboxTalk, &$dataToInsert, &$due_date) {
                    foreach ($allUsers as $userData) {
                        $dataToInsert[] = [
                            'toolbox_talk_id' => $toolboxTalk->id,
                            'due_date' => $due_date ?? null,
                            'user_id' => $userData->id,
                            'created_at' => now(), 
                            'updated_at' => now(), 
                        ];
                    }
                });
                if (!empty($dataToInsert)) {
                    AssignToolboxTalk::insert($dataToInsert);
                    $toolboxTalk->update(['status' => '1']);
                }
            }else if ((isset($request->roles) && !empty($request->roles)) && (isset($request->permissions) && !empty($request->permissions))) {
                $roles = json_decode($request->roles);
                foreach ($roles as $key => $role) {
                    $roleData = Role::find($role);
                    $usersWithRole = User::role($roleData->name)->with(['roles', 'permissions'])->get();
                    $filteredUsers = $usersWithRole->filter(function ($user) use ($request) {
                        return $user->hasAnyPermission(json_decode($request->permissions));
                    });
                    $dataToInsert = [];
                    if ($filteredUsers->isNotEmpty()) {
                        foreach ($filteredUsers as $filter) {
                            $dataToInsert[] = [
                                'role_id' => $roleData->id,
                                'permission_id' => $filter->permissions[0]->id,
                                'toolbox_talk_id' => $toolboxTalk->id,
                                'due_date' => $request->due_date ? $request->due_date : null,
                                'user_id' => $filter->id,
                                'created_at' => now(), 
                                'updated_at' => now(),
                            ];
                        }
                        if (!empty($dataToInsert)) {
                            AssignToolboxTalk::insert($dataToInsert);
                            $toolboxTalk->update(['status' => '1']);
                        }
                    }
                }
                
            } else if (isset($request->roles) && !empty($request->roles)) {
                $roles = json_decode($request->roles);
                foreach ($roles as $key => $role) {
                    $roleData = Role::find($role);
                    $usersWithRole = User::role($roleData->name)->get();
                    $dataToInsert = [];
                    if ($usersWithRole->isNotEmpty()) {
                        foreach ($usersWithRole as $filter) {
                            $dataToInsert[] = [
                                'role_id' => $roleData->id,
                                'toolbox_talk_id' => $toolboxTalk->id,
                                'due_date' => $request->due_date ? $request->due_date : null,
                                'user_id' => $filter->id,
                                'created_at' => now(), 
                                'updated_at' => now(),
                            ];
                        }
                        if (!empty($dataToInsert)) {
                            AssignToolboxTalk::insert($dataToInsert);
                            $toolboxTalk->update(['status' => '1']);
                        }
                    }
                }
                
            } else if (isset($request->permissions) && !empty($request->permissions)) {
                $permissions = json_decode($request->permissions);
                $dataToInsert = [];
                foreach ($permissions as $permissionId) {
                    $getPermission = Permission::find($permissionId);
                    if ($getPermission) {
                        $usersWithPermission = User::permission($getPermission->name)->with('permissions')->get();
                        if ($usersWithPermission->isNotEmpty()) {
                            foreach ($usersWithPermission as $filter) {
                                $dataToInsert[] = [
                                    'permission_id' => $filter->permissions[0]->id, 
                                    'toolbox_talk_id' => $toolboxTalk->id,
                                    'due_date' => $request->due_date ? $request->due_date : null,
                                    'user_id' => $filter->id,
                                    'created_at' => now(), 
                                    'updated_at' => now(), 
                                ];
                            }
                        }
                    }
                }
                if (!empty($dataToInsert)) {
                    AssignToolboxTalk::insert($dataToInsert);
                    $toolboxTalk->update(['status' => '1']);
                }
            } else if (isset($request->users) && !empty($request->users)) {
                $usersDecode = json_decode($request->users);
                $dataToInsert = [];
                foreach ($usersDecode as $userId) {
                    $getUser = User::with('roles')->find($userId);
                    if ($getUser) { 
                        $dataToInsert[] = [
                            'toolbox_talk_id' => $toolboxTalk->id,
                            'due_date' => $request->due_date ? $request->due_date : null,
                            'user_id' => $getUser->id,
                            'created_at' => now(), 
                            'updated_at' => now(), 
                        ];
                    }
                }
                if (!empty($dataToInsert)) {
                    AssignToolboxTalk::insert($dataToInsert);
                    $toolboxTalk->update(['status' => '1']);
                }
            }
            DB::commit();
            return response()->json(['msg' => 'Toolbox Talk has been assigned successfully'], 201);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['error' => 'Failed to assign Toolbox Talks: ' . $e->getMessage()], 500);
        }   
        
    }

    // Get Details 
    public function toolboxTalkDetails(Request $req, $id){
        try{
            if(isset($id) && !empty($id)){
                $talkDetails = ToolboxTalk::withTrashed()->with('questions', 'getAssignedUsers', 'getCreatedByUser', 'resourceUrlData', 'attachmentsPdfData')->findOrFail($id);
                return response()->json([
                    'talkDetails'  => new ToolBoxDetailsResource($talkDetails),
                    'status'       => 200,
                ]); 
            } else {
                return response()->json(['msg' => 'Id not found !!']);
            }
        }catch(Exception $e){
            return response()->json(['error' => 'Failed to fetch Toolbox Talk Details: ' . $e->getMessage()], 500);
        }
    }
    
    
    //Get assigned to me toolbox detail 
    public function assignedToMeDetail(GetAssignToMeDetailRequest $req) {
        $loggedinuser = 4392;
         try{
            $getAssignToMeTalks = AssignToolboxTalk::where('user_id', $loggedinuser)->where('toolbox_talk_id', $req->toolbox_talk_id)->with('getToolboxTalk')->first();
            // dd($getAssignToMeTalks , "dsl;fkdsl;fk;l");
            if(!empty($getAssignToMeTalks)){
                return response()->json([
                    'status'                   => 200,
                    'msg'                      => 'Successfully fetched Toolbox Talks that are assigned to you.',
                    'assignToMeToolboxTalks'   => new GetAuthUserAssignDetailsResource($getAssignToMeTalks),
                ]);
            } else {
                return response()->json([
                    'status'                   => 404,
                    'msg'                      => 'Data not found!'
                ]);
            }

        } catch(Exception $e){
            return response()->json(['error' => 'Failed to fetch Toolbox Talk Details: ' . $e->getMessage()], 500);
        }
    }
    
    
    // Delete single talk
    public function deleteVideoUrlOrAttachments(DeleteUrlAndPdfRequest $req){
        try {
            $toolboxTalk = ToolboxTalk::withTrashed()->find($req->toolbox_talk_id);
            if(!empty($toolboxTalk) && isset($req->attachment_id) && is_array($req->attachment_id)){
                $filesToDelete = MediaFile::whereIn('id', $req->attachment_id)->where('toolbox_talk_id', $req->toolbox_talk_id)->get();
                $deletedFiles = [];
                foreach ($filesToDelete as $file) {
                    $filePath = storage_path('app/public/toolbox_talks/'.$file->file_name);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                        $deletedFiles[] = $file->id;
                    }
                }
                if(count($deletedFiles) > 0){
                    $deleted = MediaFile::whereIn('id', $deletedFiles)->forceDelete();
                    if($deleted){
                        return response()->json([
                            'message' => 'Attachment is deleted successfully.',
                        ], 200);
                    }
                } else {
                    return response()->json([
                        'message' => 'Something went wrong!',
                    ], 409);
                }
            } else {
                return response()->json([
                        'message' => 'Data not found!.',
                ], 404);
            }
            
        } catch (Exception $e) {
            return response()->json(['error' => 'Toolbox Talk not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete Toolbox Talk: ' . $e->getMessage()], 500);
        }
    }

    // Delete Selected Talks
    public function deleteSelectedTalks(Request $request){
        try {   
            $toolboxTalk_ids = json_decode($request->toolboxTalk_ids);
            $toolboxTalk_ids = $toolboxTalk_ids;
            if (isset($toolboxTalk_ids) && !empty($toolboxTalk_ids)){
                foreach ($toolboxTalk_ids as $key => $toolboxTalk_id) {
                    $talk = ToolboxTalk::withTrashed()->findOrFail($toolboxTalk_id);
                    if(!empty($talk)){
                        $getQuestionId = Question::where('toolbox_talk_id', $talk['id'])->first();
                        $deletedVideoLinks = ResourceVideoLink::where('toolbox_talk_id', $talk['id'])->delete();
                        $deletedPdfAttachments = MediaFile::where('toolbox_talk_id', $talk['id'])->delete();
                        $deletedQuestions = Question::where('toolbox_talk_id', $talk['id'])->delete();
                        $deletedOptions = Option::where('question_id',  $getQuestionId)->delete();
                        $deletedAssignToolbox = AssignToolboxTalk::where('toolbox_talk_id', $talk['id'])->delete();
                        $deletedAtttemtQuestion = AttemptQuestion::where('toolbox_talk_id', $talk['id'])->delete();
                        $deletedToolBox = $talk->delete();
                    } else {
                        return response()->json([
                            'status'   => 404,
                            'msg'  => 'No data found of toolbox',
                            ]);
                    }
                }
                return response()->json(['message' => 'Selected Toolbox Talk have been deleted successfully'], 200);
            } else{
                return response()->json(['error' => 'Please select at least one toolbox talk.'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete selected Toolbox Talks: ' . $e->getMessage()], 500);
        }
    }

    // Assigned Test API
    public function updateNewAssignedToolboxTalk(AssignedToolboxTalkRequest $request){
        
        try{
            $toolboxTalk = ToolboxTalk::withTrashed()->with('getAssignedUsers')->findOrFail($request->toolbox_talk_id);
            if($toolboxTalk->status == 1 && $request->isLibrary ==1 ){
                return response()->json([
                    'msg' => 'Toolbox talk already assigned.'
                ], 409);
            }
          
            DB::beginTransaction();
            $dataToInsert = array();
            //new fresh code 
            if ($request->isLibrary == "1") {
                $toolboxTalk->update(['status' => '0', 'is_created' => '1', 'updated_at' => Carbon::now()]);
            } else if ($request->isLibrary == "2" || $request->isLibrary == "3") {
                $selectUserDetail = json_decode($request->select_user_detail);
                if (!is_array($selectUserDetail)) {
                    return response()->json(['error' => 'Invalid user details format'], 400);
                }
                if (empty($selectUserDetail)) {
                    return response()->json(['error' => 'No user details provided'], 400);
                }
                $toolBoxTalkID = $toolboxTalk->id;
                $dataToInsert = array_map(function ($userDetail) use ($toolBoxTalkID) {
                    return [
                        'user_id' => $userDetail->select_user_id,
                        'user_name' => $userDetail->user_name,
                        'toolbox_talk_id' => $toolBoxTalkID,
                        // 'due_date' => $formattedDate,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }, $selectUserDetail);
                AssignToolboxTalk::insert($dataToInsert);
                $toolboxTalk->update(['status' => '1', 'is_created' => '1', 'updated_at' => Carbon::now()]);
            }
            
            
            DB::commit();
            return response()->json(['msg' => 'Toolbox talk has been assigned successfully'], 201);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['error' => 'Failed to assign Toolbox Talks: ' . $e->getMessage()], 500);
        } 
    }
    
    // Update Attachments
    public function updateAttachmentsPdfUrl(UpdateAttachmentRequest $req)
    {
        try {
            $toolboxTalk = ToolboxTalk::withTrashed()->find($req->toolbox_talk_id);
            if (!empty($req->resource_url)) {
                // ResourceVideoLink::where('toolbox_talk_id', $req->toolbox_talk_id)->update(['video_url' => $req->resource_url]);
                ResourceVideoLink::updateOrCreate(
                    ['toolbox_talk_id' => $req->toolbox_talk_id], // Conditions to find the record
                    ['video_url' => $req->resource_url] // Data to update or create
                );
                $toolboxTalk->update(['updated_at' => Carbon::now()]);
            }
            
            if(!empty($toolboxTalk)){
                $fileData = [];
                if(!empty($req->pdf_file) && count($req->pdf_file) > 0){ 
                    $i=0;
                    foreach ($req->file('pdf_file') as $file) {
                        $fileName = 'toolbox_talk_' . $toolboxTalk->id . rand(10,100). time() . '.pdf';
                        $filePath = $file->storeAs('toolbox_talks', $fileName, 'public');
                        $fileData[$i]['file_name'] =  $fileName ;
                        $fileData[$i]['file_path'] = 'storage/'.$filePath;
                        $fileData[$i]['toolbox_talk_id'] = $toolboxTalk->id;
                        $i++;
                    } 
                    if(count($fileData) > 0){
                        MediaFile::insert($fileData);
                        $toolboxTalk->update(['updated_at' => Carbon::now()]);
                    }
                   
                }
                
            }
            return response()->json(['message' => 'Attachments updated successfully.', 'Updated Toolbox Talk' => $toolboxTalk], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    // Update Questions 
    public function updateQuestions(UpdateQuestionsRequest $request){
        try {
            $toolbox_talk_id = $request->toolbox_talk_id;
            $toolboxTalk = ToolboxTalk::withTrashed()->findOrFail($toolbox_talk_id);
            if(isset($request->questions) && !empty($request->questions)) {
                $questions = json_decode($request->questions, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return response()->json(['error' => 'Invalid JSON format for questions'], 400);
                }
                $checkUpdated = $toolboxTalk->update(['number_of_questions_to_ask' => $request->attemptQuestions, 'number_of_correct_answer_to_pass' => $request->number_of_correct_answer_to_pass]);
                foreach($questions as $question) {
                    Log::info('Processing question ID: ' . $question['id']);
                    $quest = $toolboxTalk->questions()->find($question['id']);
                    if ($quest) {
                        $quest->update([
                            "name" => $question['name']
                        ]);
                        foreach($question['options'] as $option) {
                            $optiondata = $quest->options()->find($option['id']);
                            if ($optiondata) {
                                $optiondata->update([
                                    "name" => $option['name'],
                                    "correct_answer" => $option['correct_answer']
                                ]);
                            } else {
                                return response()->json(['error' => 'Option not found for question ID ' . $quest->id], 404);
                            }
                        }
                    } else {
                        Log::warning('Question not found for ID: ' . $question['id'] . ' in ToolboxTalk ID: ' . $toolboxTalk->id);
                        return response()->json(['error' => 'Question not found for ID ' . $question['id']], 404);
                    }
                }
                $toolboxTalk->update(['updated_at' => Carbon::now()]);
            }
            if($toolboxTalk) {
                if(isset($request->new_questions)&& !empty($request->new_questions)) {
                    $questions_decode = json_decode($request->new_questions, true); 
                    $checkUpdated = $toolboxTalk->update(['number_of_questions_to_ask' => $request->attemptQuestions, 'number_of_correct_answer_to_pass' => $request->number_of_correct_answer_to_pass]);
                    foreach ($questions_decode as $new_question) {
                        $new_add_question = $toolboxTalk->questions()->create([
                            'name' => $new_question['name'],
                            'toolbox_talk_id' => $toolboxTalk->id,
                        ]);
                        foreach ($new_question['options'] as $index => $optiond) {
                            $new_add_question->options()->create([
                                'name' => $optiond,
                                'correct_answer' => (++$index == $new_question['correctAnswer']) ? '1' : '0',  
                                'question_id' => $new_add_question->id,
                            ]);
                        }
                    }
                    $toolboxTalk->update(['updated_at' => Carbon::now()]);
                }
            }
            return response()->json(['message' => 'Questions updated successfully.', 'Toolbox Talk' => $toolboxTalk], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    // Apply filters
    public function applyFiltersTalks(Request $request){;
        $validatedData = $request->validate([
            'start_due_date' => 'required|date',
            'end_due_date' => 'required|date|after_or_equal:start_due_date',
        ]);
        $startDueDate = $validatedData['start_due_date'];
        $endDueDate = $validatedData['end_due_date'];
        try {
            $user_id = Auth::user()->id ?? '4392';
            $toolboxTalks = ToolboxTalk::where('user_id', $user_id)->whereBetween('due_date', [$startDueDate, $endDueDate])->get();
            $toolboxTalksWithStats = $toolboxTalks->map(function ($talk) {
                $totalUsers = $talk->getAssignRole->count();
                $completedUsers = $talk->getAssignRole->where('status', '2')->count();
                $assignedUsers = $talk->getAssignRole->where('status', '1')->count();
                return [
                    'id' => $talk->id,
                    'title' => $talk->title,
                    'status' => $talk->status,
                    'is_library' => $talk->is_library,
                    'description' => $talk->description,
                    'due_date' => $talk->due_date,
                    'created_at' => $talk->created_at,
                    'total_users' => $totalUsers,
                    'completed_users' => $completedUsers,
                    'assigned_users' => $assignedUsers,
                    'get_assign_role' => $talk->getAssignRole,
                ];
            });
            return response()->json([
                'msg' => 'Toolbox Talks fetched successfully',
                'toolboxTalks' => $toolboxTalksWithStats
            ], 200); 
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch Toolbox Talks:' . $e->getMessage()
            ], 500);
        }
    }

    // Export PDF Toolbox
    public function exportToolboxPdf(ExportToolboxTalkPdfRequest $request)
    {
        try {
            $toolbox_talk_id = $request->toolbox_talk_id;
            if (!empty($toolbox_talk_id)) {
                $toolboxTalk = ToolboxTalk::withTrashed()->with(['questions.options'])->findOrFail($toolbox_talk_id);
                $data = [
                    'title' => $toolboxTalk->title,
                    'video_url' => $toolboxTalk->video_url,
                    'number_of_questions_to_ask' => $toolboxTalk->number_of_questions_to_ask,
                    'number_of_correct_answer_to_pass' => $toolboxTalk->number_of_correct_answer_to_pass,
                    'due_date' => $toolboxTalk->due_date,
                    'description' => $toolboxTalk->description,
                    'file' => $toolboxTalk->file,
                    'questions' => $toolboxTalk->questions,
                ];
                $pdf = PDF::loadView('pdf_view', $data);
                $pdfString = $pdf->output(); 
                $base64Pdf = base64_encode($pdfString);
                return response()->json([
                    'message' => 'PDF generated successfully!',
                    'pdf' => $base64Pdf,
                ], 200);
            } else {
                return response()->json([
                    'message' => "Id is required!",
                ], 500);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Failed to Export Toolbox Talk PDF:' . $e->getMessage()
            ], 500);
        }
    }

    // Attempt Questions
    public function attemptQuestions(AttemptQuestionsRequest $request)
    {
        $authUser = Auth::user()->id ?? '4392';
        try {
            // Decode the questions from JSON format
            $questions = json_decode($request->questions, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json(['error' => 'Invalid questions format.'], 400);
            }
            $toolboxTalk = ToolboxTalk::withTrashed()->find($request->toolbox_talk_id);
            $assignToolboxTalk = AssignToolboxTalk::where('toolbox_talk_id', $request->toolbox_talk_id)
                ->where('user_id', $authUser)
                ->first();
            if ($assignToolboxTalk && $assignToolboxTalk->result == 'passed') {
                return response()->json(['message' => 'You have already passed this assessment and cannot attempt it again.'], 403);
            }
            $correctCount = 0;
            $attempts = [];
            foreach ($questions as $questionData) {
                if (!isset($questionData['question_id']) || !isset($questionData['answer'])) {
                    return response()->json(['warning' => 'Each question must have an ID and an answer.'], 400);
                }

                $question = Question::find($questionData['question_id']);
                if (!$question || $question->toolbox_talk_id !== (int)$request->toolbox_talk_id) {
                    return response()->json(['error' => 'One or more questions do not belong to the specified toolbox talk.'], 403);
                }
                $correctAnswer = $question->options()->where('correct_answer', '1')->first();
                $isCorrect = ($correctAnswer && $questionData['answer'] == (string)$correctAnswer->id) ? 1 : 2;

                $attemptQuestion = AttemptQuestion::create([
                    'user_id' => $authUser,
                    'question_id' => $questionData['question_id'],
                    'toolbox_talk_id' => $request->toolbox_talk_id,
                    'answer' => $questionData['answer'],
                    'is_correct' => $isCorrect,
                    'attempt_count' => !empty($assignToolboxTalk) ? ($assignToolboxTalk->attempt_count + 1) : 1
                ]);

                if ($isCorrect === 1) {
                    $correctCount++;
                }
                $attempts[] = $attemptQuestion;
            }

            if ($correctCount >= $toolboxTalk->number_of_correct_answer_to_pass) {
                $result = 'passed';
                if ($assignToolboxTalk) {
                    $assignToolboxTalk->update([
                        'status' => 3,
                        'result' => 'passed',
                        'attempt_count' => !empty($assignToolboxTalk) ? ($assignToolboxTalk->attempt_count + 1) : 1,
                        'date_time' => now()
                    ]);
                }
            } else {
                $result = 'failed';
                if ($assignToolboxTalk) {
                    $assignToolboxTalk->update([
                        'status' => 3,
                        'result' => 'failed',
                        'attempt_count' => !empty($assignToolboxTalk) ? ($assignToolboxTalk->attempt_count + 1) : 1,
                        'date_time' => now()
                    ]);
                }
            }

            return response()->json([
                'message' => 'Questions attempted successfully.',
                'data' => AttemptQuestionsResource::collection($attempts),
                'result' => [
                    'correct_count' => $correctCount,
                    'status' => $result,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while processing your request.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    // Update existing ing Questions Private Methods
    private function updateExistingQuestions($toolboxTalk, $request)
    {
        if(isset($request->questions)&& !empty($request->questions)) {
            $questions = json_decode($request->questions, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json(['error' => 'Invalid JSON format for questions'], 400);
            }
            foreach($questions as $question) {
                Log::info('Processing question ID: ' . $question['id']);
                $quest = $toolboxTalk->questions()->find($question['id']);
                if ($quest) {
                    $quest->update([
                        "name" => $question['name']
                    ]);
                    foreach($question['options'] as $option) {
                        $optiondata = $quest->options()->find($option['id']);
                        if ($optiondata) {
                            $optiondata->update([
                                "name" => $option['name'],
                                "correct_answer" => $option['correct_answer']
                            ]);
                        } else {
                            return response()->json(['error' => 'Option not found for question ID ' . $quest->id], 404);
                        }
                    }
                } else {
                    Log::warning('Question not found for ID: ' . $question['id'] . ' in ToolboxTalk ID: ' . $toolboxTalk->id);
                    return response()->json(['error' => 'Question not found for ID ' . $question['id']], 404);
                }
            }

        }
    }

    // Add new Questions Private method
    private function addNewQuestions($toolboxTalk, $request)
    {
        if(isset($request->new_questions)&& !empty($request->new_questions)) {
            $questions_decode = json_decode($request->new_questions, true); 
            foreach ($questions_decode as $new_question) {
                $new_add_question = $toolboxTalk->questions()->create([
                    'name' => $new_question['name'],
                    'toolbox_talk_id' => $toolboxTalk->id,
                ]);
                foreach ($new_question['options'] as $index => $optiond) {
                    $new_add_question->options()->create([
                        'name' => $optiond,
                        'correct_answer' => (++$index == $new_question['correctAnswer']) ? '1' : '0',  
                        'question_id' => $new_add_question->id,
                    ]);
                }
            }
        }
    }

    // Private Assigned Method
    private function assignNewToolboxTalk($toolboxTalk, $request)
    {
        if ((isset($request->selectAll) && $request->selectAll == 'true') || ((isset($request->selectDept) && $request->selectDept == 'true') 
            && (isset($request->selectRole) && $request->selectRole == 'true')) || (isset($request->selectUser) && $request->selectUser == 'true')) {
            $dataToInsert = [];
            $due_date = $request->due_date ? $request->due_date : null;
            User::chunk(100, function ($allUsers) use ($toolboxTalk, &$dataToInsert, &$due_date) {
                foreach ($allUsers as $userData) {
                    $dataToInsert[] = [
                        'toolbox_talk_id' => $toolboxTalk->id,
                        'due_date' => $due_date ?? null,
                        'user_id' => $userData->id,
                        'created_at' => now(), 
                        'updated_at' => now(), 
                    ];
                }
            });
            if (!empty($dataToInsert)) {
                AssignToolboxTalk::insert($dataToInsert);
                $toolboxTalk->update(['status' => '1']);
            }
        } else if ((isset($request->roles) && !empty($request->roles)) && (isset($request->permissions) && !empty($request->permissions))) {
            $roles = json_decode($request->roles);
            foreach ($roles as $key => $role) {
                $roleData = Role::find($role);
                $usersWithRole = User::role($roleData->name)->with(['roles', 'permissions'])->get();
                $filteredUsers = $usersWithRole->filter(function ($user) use ($request) {
                    return $user->hasAnyPermission(json_decode($request->permissions));
                });
                $dataToInsert = [];
                if ($filteredUsers->isNotEmpty()) {
                    foreach ($filteredUsers as $filter) {
                        $dataToInsert[] = [
                            'role_id' => $roleData->id,
                            'permission_id' => $filter->permissions[0]->id,
                            'toolbox_talk_id' => $toolboxTalk->id,
                            'due_date' => $request->due_date ? $request->due_date : null,
                            'user_id' => $filter->id,
                            'created_at' => now(), 
                            'updated_at' => now(),
                        ];
                    }
                    if (!empty($dataToInsert)) {
                        AssignToolboxTalk::insert($dataToInsert);
                        $toolboxTalk->update(['status' => '1']);
                    }
                }
            }
            
        } else if (isset($request->roles) && !empty($request->roles)) {
            $roles = json_decode($request->roles);
            foreach ($roles as $key => $role) {
                $roleData = Role::find($role);
                $usersWithRole = User::role($roleData->name)->get();
                $dataToInsert = [];
                if ($usersWithRole->isNotEmpty()) {
                    foreach ($usersWithRole as $filter) {
                        $dataToInsert[] = [
                            'role_id' => $roleData->id,
                            'toolbox_talk_id' => $toolboxTalk->id,
                            'due_date' => $request->due_date ? $request->due_date : null,
                            'user_id' => $filter->id,
                            'created_at' => now(), 
                            'updated_at' => now(),
                        ];
                    }
                    if (!empty($dataToInsert)) {
                        AssignToolboxTalk::insert($dataToInsert);
                        $toolboxTalk->update(['status' => '1']);
                    }
                }
            }
            
        } else if (isset($request->permissions) && !empty($request->permissions)) {
            $permissions = json_decode($request->permissions);
            $dataToInsert = [];
            foreach ($permissions as $permissionId) {
                $getPermission = Permission::find($permissionId);
                if ($getPermission) {
                    $usersWithPermission = User::permission($getPermission->name)->with('permissions')->get();
                    if ($usersWithPermission->isNotEmpty()) {
                        foreach ($usersWithPermission as $filter) {
                            $dataToInsert[] = [
                                'permission_id' => $filter->permissions[0]->id, 
                                'toolbox_talk_id' => $toolboxTalk->id,
                                'due_date' => $request->due_date ? $request->due_date : null,
                                'user_id' => $filter->id,
                                'created_at' => now(), 
                                'updated_at' => now(), 
                            ];
                        }
                    }
                }
            }
            if (!empty($dataToInsert)) {
                AssignToolboxTalk::insert($dataToInsert);
                $toolboxTalk->update(['status' => '1']);
            }
        } else if (isset($request->users) && !empty($request->users)) {
            $usersDecode = json_decode($request->users);
            $dataToInsert = [];
            foreach ($usersDecode as $userId) {
                $getUser = User::with('roles')->find($userId);
                if ($getUser) { 
                    $dataToInsert[] = [
                        'toolbox_talk_id' => $toolboxTalk->id,
                        'due_date' => $request->due_date ? $request->due_date : null,
                        'user_id' => $getUser->id,
                        'created_at' => now(), 
                        'updated_at' => now(), 
                    ];
                }
            }
            if (!empty($dataToInsert)) {
                AssignToolboxTalk::insert($dataToInsert);
                $toolboxTalk->update(['status' => '1']);
            }
        }
    }
    
    public function deleteQuestionPerToolboxTalk($id){
        try {
            $deleteQuestion = Question::where('id', $id)->with('options')->first();
            if(!empty($deleteQuestion)){
                $deletedQuestion = $deleteQuestion->delete();
                if($deletedQuestion ){
                    $deleteQuestion->options()->delete();
                }
                return response()->json(['message' => 'Question is deleted successfully!'], 200);
            } else {
                return response()->json(['message' => 'Data not found'], 404);
            }
            
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    
    public function deleteSelectedCmsLibrary(DeleteUpdateCmsLibraryRequest $req)
    {
        try {
            $getToolboxTalk = ToolboxTalk::withTrashed()->whereIn('id', $req->toolbox_talk_id)->update(['is_library_deleted' => 1]);
            if ($getToolboxTalk) {
                return response()->json(['message' => 'Toolbox talk library is deleted successfully!'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    
   // Get Toolbox Talks data
    public function createdByMeTalks(Request $req)
    {
        try {
            $filter = $this->filterRequestData($req);
            $user_id = Auth::user()->id ?? '4392';
            $toolboxTalks = GetAllCreatedByMeTalksResource::collection(ToolboxTalk::searchingCreatedByAndLibraryFilter($req)->where('user_id', $user_id)->withCount('getAssignedUsers', 'getCountCompleted')->where('deleted_at', null)->orderBy($filter['sortBy'], $filter['sortOrder'])->paginate($filter['showPage']))->response()->getData(true);
            return response()->json([
                'msg'          => 'Toolbox Talks fetched successfully',
                'count'        => count($toolboxTalks),
                'toolboxTalks' => $toolboxTalks
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch Toolbox Talks: ' . $e->getMessage()
            ], 500);
        }
    }

    public function assignToMeToolboxTalks(Request $req)
    {
        $user_id = Auth::user()->id ?? 4392; // this is auth user id
        $filter = $this->filterRequestData($req);
        try {
            if (isset($user_id) && !empty($user_id)) {
                $getAssignToMeTalks = GetAllAssignedByMeTalksResource::collection(AssignToolboxTalk::searchingAssignedMeFilter($req)->where('user_id', $user_id)->with('getToolboxTalk')->withCount('getToolboxTalk')->where('deleted_at', null)->orderBy($filter['sortBy'], $filter['sortOrder'])->paginate($filter['showPage']))->response()->getData(true);
                // $getAssignToMeTalks = GetAllAssignedByMeTalksResource::collection(AssignToolboxTalk::searchingAssignedMeFilter($req)->where('user_id', $user_id)->with('getTestToolboxTalk')->withCount('getToolboxTalk')->where('deleted_at', null)->orderBy($filter['sortBy'], $filter['sortOrder'])->paginate($filter['showPage']))->response()->getData(true);
                if (count($getAssignToMeTalks) > 0) {
                    return response()->json([
                        'status'                   => 200,
                        'msg'                      => 'Successfully fetched Toolbox Talks that are assigned to you.',
                        'assignToMeToolboxTalks'   => $getAssignToMeTalks,
                    ]);
                } else {
                    return response()->json([
                        'status'                   => 404,
                        'msg'                      => 'Data not found!'
                    ]);
                }
            } else {
                return response()->json([
                    'msg' => 'User ID is required.',
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => 'An error occurred while fetching the data.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function companyLibraryToolboxTalks(Request $req)
    {
        $user_id = Auth::user()->id ?? '4392';
        $filter = $this->filterRequestData($req);
        try {
            $cmsLibraryToolboxTalks = GetAllCmsLibraryTalksResource::collection(ToolboxTalk::searchingCreatedByAndLibraryFilter($req)->where('user_id', $user_id)->where('is_library_deleted', '!=', "1")->with('getCreatedByUser')->withCount('attachmentsPdfData')->withCount('attachmentsVideosData')->where('deleted_at', null)->where(function ($query) {
                $query->where('is_library', '1')->orWhere('is_library', 2);
            })->orderBy($filter['sortBy'], $filter['sortOrder'])->paginate(20))->response()->getData(true);
            
            return response()->json([
                'msg'           => 'Company Toolbox Talks Talks fetched successfully.',
                'count'         => count($cmsLibraryToolboxTalks),
                'toolboxTalks'  => $cmsLibraryToolboxTalks
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch Library Toolbox Talks: ' . $e->getMessage()
            ], 500);
        }
    }
    // end get data
    
    public function updateVideoPdfsStatus(CheckVideoPdfStatusRequest $req)
    {
        $authUser = Auth::user()->id ?? '4392';
        if ($req->type == 'Video') {
            $updateStatus = tap(ResourceVideoLink::where('id', $req->video_id))->update(['video_status' => $req->status, 'video_state' => 'Completed', 'user_id' => $authUser, 'toolbox_talk_id' => $req->toolbox_talk_id])->first();
        } else {
            $updateStatus = tap(MediaFile::where('id', $req->file_id))->update(['media_files' => $req->status, 'file_state' => 'Completed', 'user_id' => $authUser, 'toolbox_talk_id' => $req->toolbox_talk_id])->first();
        }
        if ($updateStatus) {
            return response()->json([
                'status' => 200,
                'data'   => $updateStatus,
                'msg'    => $req->type . ' has been completed successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 409,
                'msg'    => 'Something went wrong'
            ]);
        }
    }
    
    
    public function getOnlyQuestionOptions(GetQuestionOptionsRequest $req)
    {
        $getQuestionOptions = ToolboxTalk::where('id', $req->toolbox_talk_id)->with('questionsOptions')->first();
        if (!empty($getQuestionOptions)) {
            return response()->json([
                'msg'                => 'Toolbox Talks questions and options data has been fetched successfully.',
                'data'               => new GetQuestionOptionsResource($getQuestionOptions)
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'msg'    => 'Data not found!'
            ]);
        }
    }
    
    //Video or attachement status
    public function videoPdfsStatus(CheckVideoPdfsFileStatusRequest $req)
    {
        $authUser = Auth::user()->id ?? '4392';
        $videostatus = ResourceVideoLink::where('toolbox_talk_id', $req->toolbox_talk_id)->where('user_id', $authUser)->first();
        $filestatus1 = MediaFile::where('toolbox_talk_id', $req->toolbox_talk_id)->where('user_id', $authUser)->get();
        $filestatus2 = MediaFile::where('toolbox_talk_id', $req->toolbox_talk_id)->where('user_id', $authUser)->where('file_status', 1)->get();
        if (!empty($videostatus) && ($videostatus != null || $videostatus != '')) {
            return response()->json([
                'status' => 200,
                'vorfstatus'   => $videostatus->video_status == 1 ? 1 : 2
            ]);
        } else if (!empty($filestatus1) && count($filestatus1) > 0) {
            return response()->json([
                'status' => 200,
                'vorfstatus'   => count($filestatus1) == count($filestatus2) ? 1 : 2
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'vorfstatus'   => 3
            ]);
        }
    }
    
    public function acknowledgedStatus(AcknowledgedStatusRequest $req)
    {
        try {
            $authUserId = Auth::user()->id ?? '4392';
            $updateAcknowledged = AssignToolboxTalk::where('toolbox_talk_id', $req->toolbox_talk_id)->where('user_id', $authUserId)->update(['status' => 2, 'date_time' => now()]);
            if ($updateAcknowledged) {
                return response()->json([
                    'message' => 'AssignToolBox acknowledged successfully!',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Something went wrong!',
                ], 409);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch Library Toolbox Talks',
            ], 500);
        }
    }
}
