<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AcknowledgedStatusRequest;
use App\Http\Requests\API\AssignedToolboxTalkRequest;
use App\Http\Requests\API\CheckVideoPdfStatusRequest;
use App\Http\Requests\API\CheckVideoPdfsFileStatusRequest;
use App\Http\Requests\API\AttemptQuestionsRequest;
use App\Http\Requests\API\UpdateContentToolboxRequest;
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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Rules\ExistsOrSoftDeletedRequest;
use App\Http\Resources\API\GetAllAssignedByMeTalksResource;
use App\Http\Resources\API\GetAllCmsLibraryTalksResource;
use App\Http\Resources\API\GetAllCreatedByMeTalksResource;
use App\Http\Resources\API\AttemptQuestionsResource;
use App\Traits\CommonFunctionalityTrait;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ToolboxTalkCSVExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SendEmailNotification;


class ToolboxTalkController extends Controller
{
    use CommonFunctionalityTrait;


    /**
     * Create a toolbox talk.
     *
     * This endpoint creates a toolbox. In this API when we create a toolbox talk then we need to choose one option from dropdown 'Send', 'Save in library' OR 'Send & Save'. If we choose 'Send' OR 'Send & Save' then we always need to select any role or departments or attendees or permissions and also 'Video URL Link' OR 'Upload PDF file'. And if we choose Save in Library then we don't need to select any users from ( roles, departments, permissions, attendees) and not need to put any 'Video URL Link' OR 'Upload PDF file'. The param name of dropdown list for 'Send' OR 'Save in library' OR 'Send & Save' is 'isLibrary' param.
     *
     * @bodyParam title string required. The title of the toolbox talk.
     * @bodyParam select_user_detail json array with some keys (objects). The users selected from dropdown list from attendees or roles or departments or permissions or select users. It is required while choose 'Send' OR 'Send & Save'. But when we choose 'Save in library' then this param is optional. Example:- [{"select_user_id":"4392", "user_name":"testing_name1", "user_email":"tpurposely@gmail.com"}, {"select_user_id":"4392", "user_name":"testing_name2", "user_email":"tpurposely1@yopmail.com"}]
     * @bodyParam due_date string required The Due date of toolbox talk. Ex:- "2025-08-22" 
     * @bodyParam resource_url array required when 'pdf_file' is not present and choose only 'Send' OR 'Send & Save' The 'Video URL Link' for a toolbox talk. Ex:- "['youtube.com','testtubevideo.com' ]"
     * @bodyParam pdf_file array required when 'resource_url' is not present and choose only 'Send' OR 'Send & Save' The 'Upload PDF File' for a toolbox talk. Ex:- "['firstPDF.pdf','secondPDF.pdf' ]"
     * @bodyParam description string optional The description of the toolbox talk.
     * @bodyParam questions json array with some keys (objects) optional. The Question Sheets for the toolbox talk. Example:- [{"text":"this is first question", "options" : [ "test1", "test2", "test3", "test4"],"correctAnswer":"1"},{"text":"this is second question", "options" : [ "test1", "test2", "test3", "test4"], "correctAnswer":"2" }]
     * @bodyParam attemptQuestions integer required when we choose 'questions' the Question Sheets for the toolbox talk. In this Number of Questions to Ask per Participant(attemptQuestions) is always greater then Number of Correct Answers Required to Pass(number_of_correct_answer_to_pass).
     * @bodyParam number_of_correct_answer_to_pass integer required when we choose 'questions' the Question Sheets for the toolbox talk. In this Number of Correct Answers Required to Pass(number_of_correct_answer_to_pass) is always less then Number of Questions to Ask per Participant(attemptQuestions).
     * @bodyParam isLibrary integer required when we select options from dropdown list then we send the values in this params 1, 2 or 3. Example:- 1 for 'Save in library', 2 for 'Send' OR 3 for 'Send & Save'
     *
     * @response 201 {
     *  "msg": "Toolbox Talk created successfully",
     *  "data": {
     *      "title": "new fresh without send and save",
     *      "user_id": "4392",
     *      "number_of_questions_to_ask": "1",
     *      "number_of_correct_answer_to_pass": "1",
     *      "is_library": "1",
     *      "due_date": "2025-08-26",
     *      "description": "This talk covers essential safety measures when working at heights, including the use of protective equipment, proper setup of ladders and scaffolding, and awareness of potential fall hazards.",
     *      "updated_at": "2025-08-26T11:24:48.000000Z",
     *      "created_at": "2025-08-26T11:24:48.000000Z",
     *      "id": 59,
     *      "status": "0",
     *      "is_created": "1"
     *    }
     * }
     *
     * @response 422 {
     *  "error": {
     *      "name": ["The title field is required."],
     *  }
     * }
     */

    public function createToolboxtalk(CreateToolboxTalkRequest $request)
    {
        try {
            $authUserId = Auth::user()->id ?? '4392';
            DB::beginTransaction();
            $user = User::find(1);
            if (!$user->hasPermissionTo('Creator')) {
                return response()->json([
                    'message' => "You do not have permission to access Create Toolbox Talk feature!",
                ], 200);
            }
            $toolboxTalk = ToolboxTalk::create([
                'title' => $request->title,
                'user_id' => $authUserId,
                'number_of_questions_to_ask' => isset($request->attemptQuestions) && !empty($request->attemptQuestions) ? $request->attemptQuestions : null,
                'number_of_correct_answer_to_pass' => isset($request->number_of_correct_answer_to_pass) && !empty($request->number_of_correct_answer_to_pass) ? $request->number_of_correct_answer_to_pass : null,
                'is_library' => $request->isLibrary,
                'due_date' => $request->due_date ?? null,
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
                    if (count($resourceUrlData)  > 0) {
                        $i = 0;
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

                if ($resourceUrlDataWithKey) {
                    ResourceVideoLink::insert($resourceUrlDataWithKey);
                    $toolboxTalk->update(['updated_at' => Carbon::now()]);
                }
            } else if (!empty($request->pdf_file) && count($request->pdf_file) > 0) {
                $i = 0;
                foreach ($request->file('pdf_file') as $file) {
                    $fileName = 'toolbox_talk_' . $toolboxTalk->id . rand(10, 100) . time() . '.pdf';
                    $filePath = $file->storeAs('toolbox_talks', $fileName, 'public');
                    $fileData[$i]['file_name'] =  $fileName;
                    $fileData[$i]['file_path'] = 'storage/' . $filePath;
                    $fileData[$i]['toolbox_talk_id'] = $toolboxTalk->id;
                    $i++;
                }
                if (count($fileData) > 0) {
                    MediaFile::insert($fileData);
                    $toolboxTalk->update(['updated_at' => Carbon::now()]);
                }
            }

            if (isset($request->questions) && !empty($request->questions) && ($request->questions != null || $request->questions != '')) {
                $questions = json_decode($request->questions, true);
                if (count($questions) < $request->attemptQuestions) {
                    return response()->json([
                        'message' => "The number of questios asked must be less than or the same as the amount of questions added!",
                    ], 200);
                }
                if ($request->attemptQuestions < $request->numberOfCorrectAnswer) {
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
                            'correct_answer' => ($index + 1 == $questionData['correctAnswer']) ? '1' : '0',  // Check if it's the correct answer
                            'question_id' => $question->id,
                        ]);
                    }
                }
                $toolboxTalk->update(['updated_at' => Carbon::now()]);
            }

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
                $userEmails = [];
                $toolBoxTalkID = $toolboxTalk->id;
                $dueDateWithoutFormat = $request->due_date ?? null;
                $dataToInsert = array_map(function ($userDetail) use ($toolBoxTalkID, $dueDateWithoutFormat, &$userEmails) {
                    $userEmails[] = $userDetail->user_email;
                    return [
                        'user_id'         => $userDetail->select_user_id,
                        'user_name'       => $userDetail->user_name,
                        'user_email'      => $userDetail->user_email,
                        'toolbox_talk_id' => $toolBoxTalkID,
                        'due_date'        => $dueDateWithoutFormat,
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ];
                }, $selectUserDetail);

                $assignedOrNot = AssignToolboxTalk::insert($dataToInsert);

                if ($assignedOrNot) {
                    try {
                        $subject = 'Assigned:- ' . $toolboxTalk->title;
                        $line = 'Toolbox talk: ' . $toolboxTalk->title . ' has been assigned.';
                        $actionUrl = config('app.VITE_FRONT_URL') . '/my-toolbox-talks/assigned-to-me/' . $toolboxTalk->id;
                        $actionText = 'Assigned Toolbox talk';
                        foreach ($userEmails as $email) {
                            \Notification::route('mail', $email)->notify(new SendEmailNotification($toolboxTalk, $subject, $line, $actionUrl, $actionText));
                        }
                    } catch (Exception $e) {
                        Log::error('Failed to send Toolbox Talk assignment emails: ' . $e->getMessage());
                    }
                    $toolboxTalk->update(['status' => '1', 'is_created' => '1', 'updated_at' => Carbon::now()]);
                }
            }
            DB::commit();
            return response()->json(['msg' => 'Toolbox Talk created successfully', 'data' => $toolboxTalk], 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to create Toolbox Talk: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Get details of a single toolbox talk by ID.
     *
     * This endpoint returns detailed information about a toolbox talk when their ID is provided as a query parameter. This API is providing the details of a single toolbox talk which have all data of questions sheet with options and correct answers and also fetching the data of documents like video URL links or PDF's data. Now if we are getting the data of assigned users then this toolbox is already assigned to some users or whatever we are getting data of this user in below response & apart from this we are getting details of that user also who has created this Toolbox talk.
     *
     * @queryParam id int required The ID of the toolbox talk. 
     *
     * @response 200 {
     *       "talkDetails": {
     *          "id": 58,
     *          "title": "new fresh test1",
     *          "number_of_questions_to_ask": 1,
     *          "number_of_correct_answer_to_pass": 1,
     *          "description": "This talk covers essential safety measures when working at heights, including the use of protective equipment, proper setup of ladders and scaffolding, and awareness of potential fall hazards.",
     *          "user_id": 4392,
     *          "is_library": "2",
     *           "due_date": "2025-08-26",
     *           "deleted_at": null,
     *           "status": "1",
     *           "created_at": "2025-08-26T10:54:33.000000Z",
     *           "updated_at": "2025-08-26T10:54:37.000000Z",
     *           "questions": [{ "id": 167, "name": "this is first question", "options": [{"id": 665, "name": "test1"}, {"id": 666,"name": "test2"},{"id": 667,"name": "test3"},{"id": 668,"name": "test4"}], "correct_answer": [{"id": 665,"name": "test1"}]},{ "id": 167, "name": "this is second question", "options": [{"id": 770, "name": "A"}, {"id": 771,"name": "B"},{"id": 772,"name": "C"},{"id": 773,"name": "D"}], "correct_answer": [{"id": 772,"name": "C"}]}],
     *          "video_url": [],
     *           "file_data": [{"id": 49,"toolbox_talk_id": 58,"file_url": "https://companymanagementsystems-back-qa.chetu.com/storage/toolbox_talks/toolbox_talk_58311756205673.pdf", "file_name": "toolbox_talk_58311756205673.pdf","file_status": "1", "file_state": "Completed"}],
     *           "assigned_users": [{"id": 113,"name": "testing_name1","status": "","attempt": null,"time": null,"date": null,"result": { "result": "0/0" }}],
     *           "created_by_user": null
     *       },
     *      "status": 200
     * }
     *
     * @response 404 {
     *  "error": "Toolbox talk data not found"
     * }
     */
    public function toolboxTalkDetails(Request $req, $id)
    {
        try {
            if (isset($id) && !empty($id)) {
                $talkDetails = ToolboxTalk::withTrashed()->with('questions', 'getAssignedUsers', 'getCreatedByUser', 'resourceUrlData', 'attachmentsPdfData')->findOrFail($id);
                return response()->json([
                    'talkDetails'  => new ToolBoxDetailsResource($talkDetails),
                    'status'       => 200,
                ]);
            } else {
                return response()->json(['msg' => 'Id not found !!']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch Toolbox Talk Details: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Get details of an assigned toolbox talk by toolbox_talk_id which is assigned to me (asigned to authentication user AUTH user).
     *
     * This endpoint returns detailed information about a assigned toolbox talk when their ID is provided as a query parameter. This API is providing the details of a single assigned toolbox talk which have all data of questions sheet with options and correct answers and also fetching the data of documents like video URL links or PDF's data. Now if we are getting the data of assigned users then this toolbox is already assigned to some users or whatever we are getting data of this user in below response & apart from this we are getting details of that user also who has created this Toolbox talk.
     *
     * @bodyParam toolbox_talk_id int required The toolbox_talk_id of the toolbox talk. 
     *
     * @response 200 {
     *       "status": 200,
     *       "msg": "Successfully fetched Toolbox Talks that are assigned to you.",
     *       "assignToMeToolboxTalks": {
     *          "id": 58,
     *          "title": "new fresh test1",
     *          "number_of_questions_to_ask": 1,
     *          "number_of_correct_answer_to_pass": 1,
     *          "description": "This talk covers essential safety measures when working at heights, including the use of protective equipment, proper setup of ladders and scaffolding, and awareness of potential fall hazards.",
     *          "user_id": 4392,
     *          "is_library": "2",
     *           "due_date": "2025-08-26",
     *           "deleted_at": null,
     *           "status": "1",
     *           "created_at": "2025-08-26T10:54:33.000000Z",
     *           "updated_at": "2025-08-26T10:54:37.000000Z",
     *           "questions": [{ "id": 167, "name": "this is first question", "options": [{"id": 665, "name": "test1"}, {"id": 666,"name": "test2"},{"id": 667,"name": "test3"},{"id": 668,"name": "test4"}], "correct_answer": [{"id": 665,"name": "test1"}]},{ "id": 167, "name": "this is second question", "options": [{"id": 770, "name": "A"}, {"id": 771,"name": "B"},{"id": 772,"name": "C"},{"id": 773,"name": "D"}], "correct_answer": [{"id": 772,"name": "C"}]}],
     *          "video_url": [],
     *           "file_data": [{"id": 49,"toolbox_talk_id": 58,"file_url": "https://companymanagementsystems-back-qa.chetu.com/storage/toolbox_talks/toolbox_talk_58311756205673.pdf", "file_name": "toolbox_talk_58311756205673.pdf","file_status": "1", "file_state": "Completed"}],
     *       },
     *      
     * }
     *
     * @response 404 {
     *  "error": "Assigned toolbox talk data not found"
     * }
     */

    public function assignedToMeDetail(GetAssignToMeDetailRequest $req)
    {
        $loggedinuser = Auth::user()->id ?? '4392';
        try {
            $getAssignToMeTalks = AssignToolboxTalk::where('user_id', $loggedinuser)->where('toolbox_talk_id', $req->toolbox_talk_id)->with('getToolboxTalk')->first();
            if (!empty($getAssignToMeTalks)) {
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
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch Toolbox Talk Details: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Delete a video URL or attachment PDF by attachment_id.
     *
     * This endpoint deletes a Video URL Link or Attachments specified by its IDs in the request body in an array and given toolbox_talk_id also for identiying.
     *
     * @bodyParam toolbox_talk_id integer required The toolbox_talk_id of the toolbox talk.
     * @bodyParam attachment_id integer array required The attachment_id of the attachment or video URL link table to delete.
     *
     * @response 200 {
     *      "message": "Attachment is deleted successfully."
        }
     *
     * @response 404 {
     *  "error": "Data not found."
     * }
     *
     * @response 500 {
     *  "error": "Failed to delete attachments: Something went wrong!"
     * }
     */
    public function deleteVideoUrlOrAttachments(DeleteUrlAndPdfRequest $req)
    {
        try {
            $toolboxTalk = ToolboxTalk::withTrashed()->find($req->toolbox_talk_id);
            if (!empty($toolboxTalk) && isset($req->attachment_id) && is_array($req->attachment_id)) {
                $filesToDelete = MediaFile::whereIn('id', $req->attachment_id)->where('toolbox_talk_id', $req->toolbox_talk_id)->get();
                $deletedFiles = [];
                foreach ($filesToDelete as $file) {
                    $filePath = storage_path('app/public/toolbox_talks/' . $file->file_name);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                        $deletedFiles[] = $file->id;
                    }
                }
                if (count($deletedFiles) > 0) {
                    $deleted = MediaFile::whereIn('id', $deletedFiles)->forceDelete();
                    if ($deleted) {
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

    /**
     * Delete a toolbox talk by toolboxTalk_ids into array.
     *
     * This endpoint deletes a toolbox talk specified by its IDs in the request body in an array. In this API we can delete multiple toolbox talks together or we can delete only single at a time.
     *
     * @bodyParam toolboxTalk_ids integer array required The toolboxTalk_ids of the toolbox talks to delete.
     *
     * @response 200 {
     *      "message": "Selected Toolbox Talk have been deleted successfully."
        }
     *
     * @response 404 {
     *  "error": "Data not found."
     * }
     *
     * @response 500 {
     *  "error": "Failed to delete toolbox talks: Something went wrong!"
     * }
     */
    public function deleteSelectedTalks(Request $request)
    {
        try {
            $toolboxTalk_ids = json_decode($request->toolboxTalk_ids);
            $toolboxTalk_ids = $toolboxTalk_ids;
            if (isset($toolboxTalk_ids) && !empty($toolboxTalk_ids)) {
                foreach ($toolboxTalk_ids as $key => $toolboxTalk_id) {
                    $talk = ToolboxTalk::withTrashed()->findOrFail($toolboxTalk_id);
                    if (!empty($talk)) {
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
            } else {
                return response()->json(['error' => 'Please select at least one toolbox talk.'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete selected Toolbox Talks: ' . $e->getMessage()], 500);
        }
    }



    /**
     * Make a toolbox talk assigned to users.
     *
     * This endpoint do assign a toolbox to users. In this API, when we assign a toolbox talk then we need to choose one option from dropdown 'Send', 'Save in library' OR 'Send & Save'. If we choose 'Send' OR 'Send & Save' then we always need to select any role or departments or attendees or permissions and also 'Video URL Link' OR 'Upload PDF file' if attachment not uploaded at creating time of toolbox talk. And if we choose only Save in Library then it is showing as it is when this toolbox talk was created unassigned within 'create by me' tab and 'toolbox library within Company library'.
     *
     * @bodyParam toolbox_talk_id interger required. The toolbox_talk_id of the toolbox talk.
     * @bodyParam select_user_detail json array with some keys (objects). The users selected from dropdown list from attendees or roles or departments or permissions or select users. It is required while choose 'Send' OR 'Send & Save'. But when we choose 'Save in library' then this param is optional. Example:- [{"select_user_id":"4392", "user_name":"testing_name1", "user_email":"tpurposely@gmail.com"}, {"select_user_id":"4392", "user_name":"testing_name2", "user_email":"tpurposely1@yopmail.com"}]
     * @bodyParam due_date string optional The Due date of toolbox talk. Ex:- "2025-08-22" 
     * @bodyParam isLibrary integer required when we select options from dropdown list then we send the values in this params 1, 2 or 3. Example:- 1 for 'Save in library', 2 for 'Send' OR 3 for 'Send & Save'
     *
     * @response 201 {
     *  "msg": "Toolbox talk has been assigned successfully",
     * }
     *
     * @response 422 {
     *  "error": {
     *      "toolbox_talk_id": ["The toolbox_talk_id field is required."],
     *  }
     * }
     */
    public function updateNewAssignedToolboxTalk(AssignedToolboxTalkRequest $request)
    {

        try {
            $toolboxTalk = ToolboxTalk::withTrashed()->with('getAssignedUsers')->findOrFail($request->toolbox_talk_id);
            if ($toolboxTalk->status == 1 && $request->isLibrary == 1) {
                return response()->json([
                    'msg' => 'Toolbox talk already assigned.'
                ], 409);
            }
            DB::beginTransaction();
            $dataToInsert = array();
            if ($request->isLibrary == "1") {
                $toolboxTalk->update(['status' => '0', 'is_created' => '1', 'updated_at' => Carbon::now(), 'due_date' => $request->due_date]);
            } else if ($request->isLibrary == "2" || $request->isLibrary == "3") {
                $selectUserDetail = json_decode($request->select_user_detail);
                if (!is_array($selectUserDetail)) {
                    return response()->json(['error' => 'Invalid user details format'], 400);
                }
                if (empty($selectUserDetail)) {
                    return response()->json(['error' => 'No user details provided'], 400);
                }
                $toolBoxTalkID = $toolboxTalk->id;
                $userEmails = [];
                $dueDateWithoutFormat = $request->due_date ?? null;
                $dataToInsert = array_map(function ($userDetail) use ($toolBoxTalkID, $dueDateWithoutFormat, &$userEmails) {
                    $userEmails[] = $userDetail->user_email;
                    return [
                        'user_id'          => $userDetail->select_user_id,
                        'user_name'        => $userDetail->user_name,
                        'user_email'       => $userDetail->user_email,
                        'toolbox_talk_id'  => $toolBoxTalkID,
                        'due_date'         => $dueDateWithoutFormat,
                        'created_at'       => now(),
                        'updated_at'       => now(),
                    ];
                }, $selectUserDetail);

                $assignedOrNot = AssignToolboxTalk::insert($dataToInsert);
                if ($assignedOrNot) {
                    try {
                        $subject = 'Assigned:- ' . $toolboxTalk->title;
                        $line = 'Toolbox talk: ' . $toolboxTalk->title . ' has been assigned.';
                        $actionUrl = config('app.VITE_FRONT_URL') . '/my-toolbox-talks/assigned-to-me/' . $toolboxTalk->id;
                        $actionText = 'Assigned Toolbox talk';
                        foreach ($userEmails as $email) {
                            \Notification::route('mail', $email)->notify(new SendEmailNotification($toolboxTalk, $subject, $line, $actionUrl, $actionText));
                        }
                    } catch (Exception $e) {
                        Log::error('Failed to send Toolbox Talk assignment emails: ' . $e->getMessage());
                    }
                    $toolboxTalk->update(['status' => '1', 'is_created' => '1', 'updated_at' => Carbon::now(), 'due_date' => $request->due_date]);
                }
            }
            DB::commit();
            return response()->json(['msg' => 'Toolbox talk has been assigned successfully'], 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to assign Toolbox Talks: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update the attachments PDF's OR Video Resource Url's of a toolbox talk.
     *
     * This endpoint updates the attachments PDF's OR Video Resource Url's of a toolbox talk. In this API, while we are updating the attachments PDF's or Video Resource URL's of a toolbox talk, we need to send toolbox_talk_id, resource_url in array OR pdf_file in array.
     *
     * @bodyParam toolbox_talk_id interger required. The toolbox_talk_id of the toolbox talk.
     * @bodyParam resource_url array required when 'pdf_file' is not present. The 'Video URL Link' for a toolbox talk. Ex:- "['youtube.com','testtubevideo.com' ]"
     * @bodyParam pdf_file array required when 'resource_url' is not present. The 'Upload PDF File' for a toolbox talk. Ex:- "['firstPDF.pdf','secondPDF.pdf' ]"
     *
     * @response 201 {
     *  "message": "Attachments updated successfully",
     *  "Updated_Toolbox_Talk": {
     *          "id": 1,
     *          "title": "new fresh test1",
     *          "number_of_questions_to_ask": 1,
     *          "number_of_correct_answer_to_pass": 1,
     *          "description": "This talk covers essential safety measures when working at heights, including the use of protective equipment, proper setup of ladders and scaffolding, and awareness of potential fall hazards.",
     *          "user_id": 4392,
     *          "is_library": "2",
     *          "due_date": "2025-08-26",
     *          "deleted_at": null,
     *          "status": "1",
     *          "created_at": "2025-08-26T10:54:33.000000Z",
     *          "updated_at": "2025-08-26T10:54:37.000000Z",
     *       }
     * }
     *
     * @response 422 {
     *  "error": {
     *      "toolbox_talk_id": ["The toolbox_talk_id field is required."],
     *  }
     * }
     */
    public function updateAttachmentsPdfUrl(UpdateAttachmentRequest $req)
    {
        try {
            $toolboxTalk = ToolboxTalk::withTrashed()->find($req->toolbox_talk_id);
            if (!empty($req->resource_url)) {
                ResourceVideoLink::updateOrCreate(
                    ['toolbox_talk_id' => $req->toolbox_talk_id],
                    ['video_url' => $req->resource_url]
                );
                $toolboxTalk->update(['updated_at' => Carbon::now()]);
            }

            if (!empty($toolboxTalk)) {
                $fileData = [];
                if (!empty($req->pdf_file) && count($req->pdf_file) > 0) {
                    $i = 0;
                    foreach ($req->file('pdf_file') as $file) {
                        $fileName = 'toolbox_talk_' . $toolboxTalk->id . rand(10, 100) . time() . '.pdf';
                        $filePath = $file->storeAs('toolbox_talks', $fileName, 'public');
                        $fileData[$i]['file_name'] =  $fileName;
                        $fileData[$i]['file_path'] = 'storage/' . $filePath;
                        $fileData[$i]['toolbox_talk_id'] = $toolboxTalk->id;
                        $i++;
                    }
                    if (count($fileData) > 0) {
                        MediaFile::insert($fileData);
                        $toolboxTalk->update(['updated_at' => Carbon::now()]);
                    }
                }
            }
            return response()->json(['message' => 'Attachments updated successfully.', 'Updated_Toolbox_Talk' => $toolboxTalk], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the questions sheet with options and correct answer of a toolbox talk.
     *
     * This endpoint updates the question sheet with options and correct answer of a toolbox talk. In this API, while we are updating the question sheet with options and correct answer of a toolbox talk, we need to send toolbox_talk_id, questions in json array with some keys (objects), Number of Questions to Ask per Participant, Number of Correct Answers Required to Pass & New questions add if wants to add.
     *
     * @bodyParam toolbox_talk_id interger required. The toolbox_talk_id of the toolbox talk.
     * @bodyParam questions json array with some keys (objects) optional. The Question Sheets for the toolbox talk. Example:- [{"text":"this is updated first question", "options" : [ "test11", "test22", "test33", "test44"],"correctAnswer":"4"},{"text":"this is updated second question", "options" : [ "test111", "test222", "test333", "test444"], "correctAnswer":"1" }]
     * @bodyParam attemptQuestions integer required when we choose 'questions' the Question Sheets for the toolbox talk. In this Number of Questions to Ask per Participant(attemptQuestions) is always greater then Number of Correct Answers Required to Pass(number_of_correct_answer_to_pass).
     * @bodyParam number_of_correct_answer_to_pass integer required when we choose 'questions' the Question Sheets for the toolbox talk. In this Number of Correct Answers Required to Pass(number_of_correct_answer_to_pass) is always less then Number of Questions to Ask per Participant(attemptQuestions).
     * @bodyParam new_questions json array with some keys (objects) optional. The New Questions added for the toolbox talk. Example:- [{"text":"this is new extra first question", "options" : [ "test11", "test22", "test33", "test44"],"correctAnswer":"4"},{"text":"this is new extra second question", "options" : [ "test111", "test222", "test333", "test444"], "correctAnswer":"1" }]
     *
     * @response 201 {
     *  "message": "Questions updated successfully.",
     *  "Toolbox_Talk": {
     *          "id": 1,
     *          "title": "new fresh test1",
     *          "number_of_questions_to_ask": 1,
     *          "number_of_correct_answer_to_pass": 1,
     *          "description": "This talk covers essential safety measures when working at heights, including the use of protective equipment, proper setup of ladders and scaffolding, and awareness of potential fall hazards.",
     *          "user_id": 4392,
     *          "is_library": "2",
     *          "due_date": "2025-08-26",
     *          "deleted_at": null,
     *          "is_created": "1",
     *          "status": "1",
     *          "created_at": "2025-08-26T10:54:33.000000Z",
     *          "updated_at": "2025-08-26T10:54:37.000000Z",
     *       }
     * }
     *
     * @response 404 {
     *  "error": "Question not found for ID."
     * }
     * 
     * @response 422 {
     *  "error": {
     *      "toolbox_talk_id": ["The toolbox_talk_id field is required."],
     *  }
     * }
     */
    public function updateQuestions(UpdateQuestionsRequest $request)
    {
        try {
            $toolbox_talk_id = $request->toolbox_talk_id;
            $toolboxTalk = ToolboxTalk::withTrashed()->findOrFail($toolbox_talk_id);
            if (isset($request->questions) && !empty($request->questions)) {
                $questions = json_decode($request->questions, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return response()->json(['error' => 'Invalid JSON format for questions'], 400);
                }
                $checkUpdated = $toolboxTalk->update(['number_of_questions_to_ask' => $request->attemptQuestions, 'number_of_correct_answer_to_pass' => $request->number_of_correct_answer_to_pass]);
                foreach ($questions as $question) {
                    Log::info('Processing question ID: ' . $question['id']);
                    $quest = $toolboxTalk->questions()->find($question['id']);
                    if ($quest) {
                        $quest->update([
                            "name" => $question['name']
                        ]);
                        foreach ($question['options'] as $option) {
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
            if ($toolboxTalk) {
                if (isset($request->new_questions) && !empty($request->new_questions)) {
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
            return response()->json(['message' => 'Questions updated successfully.', 'Toolbox_Talk' => $toolboxTalk], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }



    /**
     * Attempt the questions sheet with correct answer of a toolbox talk.
     *
     * This endpoint attempts the question sheet with correct answer of a toolbox talk. In this API, while we are attempting the question sheet with correct answer of a toolbox talk, we need to send toolbox_talk_id, questions in json array with some keys (objects) with the question ID you want to attempt and any answer ID which one you want to choose answer.
     *
     * @bodyParam toolbox_talk_id interger required. The toolbox_talk_id of the toolbox talk.
     * @bodyParam questions json array with some keys (objects) required. The Question Id's and Options ID's for the toolbox talk. Example:- [{ "question_id": 2, "answer": 7 },{ "question_id": 1, "answer": 2 }]
     * @bodyParam auth_user_id integer optional. This is authentication user ID who is attempting the Question Sheet.
     *
     * @response 201 {
     *   "message": "Questions attempted successfully.",
     *   "data": [
     *       {
     *          "id": 1,
     *          "user_id": "4392",
     *          "question_id": 1,
     *          "toolbox_talk_id": "2",
     *          "answer": 3,
     *          "is_correct": 1,
     *          "attempt_count": 1,
     *          "result_data_count": {
     *             "total_questions": 2,
     *             "number_of_attempted": 2,
     *             "number_of_passed": 1
     *           }
     *       }
     *   ],
     *   "result": {
     *        "correct_count": 1,
     *        "status": "passed"
     *      }
     * }
     *
     * @response 404 {
     *  "error": "Question not found for ID."
     * }
     * 
     * @response 422 {
     *  "error": {
     *      "toolbox_talk_id": ["The toolbox_talk_id field is required."],
     *  }
     * }
     */
    public function attemptQuestions(AttemptQuestionsRequest $request)
    {
        $authUser = Auth::user()->id ?? '4392';
        try {
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


    /**
     * Delete a single question from question sheet of a toolbox talk by ID.
     *
     * This endpoint deletes a single question from question sheet of a toolbox talk by ID is provided as a query parameter. This API deletes a question from the questions sheet of a particular toolbox talk. We provide the question id into the param for deleting a questioon from the question sheet.
     *
     * @queryParam id int required The question ID of a questions sheet of a toolbox talk. 
     *
     * @response 200 {
     *      "message": "Question is deleted successfully!"
     * }
     *
     * @response 404 {
     *  "error": "Question ID data not found"
     * }
     */
    public function deleteQuestionPerToolboxTalk($id)
    {
        try {
            $deleteQuestion = Question::where('id', $id)->with('options')->first();
            if (!empty($deleteQuestion)) {
                $deletedQuestion = $deleteQuestion->delete();
                if ($deletedQuestion) {
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

    /**
     * Delete a toolbox talk by toolbox_talk_id into array.
     *
     * This endpoint deletes a toolbox talk specified by its IDs in the request body in an array. In this API we can delete multiple toolbox talks together or we can delete only single at a time.
     *
     * @bodyParam toolbox_talk_id integer array required The toolbox_talk_id of the toolbox talks to delete.
     *
     * @response 200 {
     *      "message": "Toolbox talk library is deleted successfully!"
        }
     *
     * @response 404 {
     *  "error": "Data not found."
     * }
     *
     * @response 500 {
     *  "error": "Failed to delete toolbox talks library: Something went wrong!"
     * }
     */
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

    /**
     * Retrieve all toolbox talks data which is created.
     *
     * This endpoint returns all toolbox talks data. In this API, we get all toolbox talk data and also we can filter through assigned or unassigned status that toolbox tallk is in assigned status or unassigned status. We can do search, filter by dates from all toolbox talks.
     *
     * @queryParam no need of any param initial. If we want to search or filter or sorted any toolbox talk then we need to put query params while we are searching then we need to put 'search' & for getting assigned or unassigned then we need to put 'status' param and 'start_date' & 'end_date' when we want to filter according to the dates from calender.
     *
     * @response 200 {
     *      "message": "Toolbox Talks fetched successfully",
     *      "toolboxTalks": {
     *           "data": [
     *               {
     *                   "id": 8,
     *                   "title": "Test new again",
     *                   "video_url": null,
     *                   "number_of_questions_to_ask": null,
     *                   "number_of_correct_answer_to_pass": null,
     *                   "file": null,
     *                   "description": "",
     *                   "user_id": 4392,
     *                   "is_library": "3",
     *                   "is_library_deleted": "2",
     *                   "due_date": "2025-08-27",
     *                   "deleted_at": null,
     *                   "status": "1",
     *                   "is_created": "1",
     *                   "created_at": "2025-08-27T14:35:44.000000Z",
     *                   "updated_at": "2025-08-27T14:35:52.000000Z",
     *                   "get_assigned_users_count": 5,
     *                   "get_count_completed_count": 0
     *               },
     *               {
     *                   "id": 7,
     *                   "title": "Testing new ",
     *                   "video_url": null,
     *                   "number_of_questions_to_ask": null,
     *                   "number_of_correct_answer_to_pass": null,
     *                   "file": null,
     *                   "description": "",
     *                   "user_id": 4392,
     *                   "is_library": "3",
     *                   "is_library_deleted": "2",
     *                   "due_date": "2025-08-27",
     *                   "deleted_at": null,
     *                   "status": "1",
     *                   "is_created": "1",
     *                   "created_at": "2025-08-27T14:34:51.000000Z",
     *                   "updated_at": "2025-08-27T14:34:55.000000Z",
     *                   "get_assigned_users_count": 1,
     *                   "get_count_completed_count": 0
     *               },
     *           ],
     *           "links": {"first": "https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks?page=1", "last": "https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks?page=1", "prev": null,"next": null},
     *           "meta": { "current_page": 1, "from": 1, "last_page": 1,
     *           "links": [{"url": null, "label": "&laquo; Previous", "active": false}, {"url": "https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks?page=1","label": "1","active": true}, { "url": null, "label": "Next &raquo;", "active": false }],
     *           "path": "https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks", "per_page": 10, "to": 8, "total": 8 }
     *       }
     *   }
     *
     * @response 404 {
     *  "error": "Data not found."
     * }
     *
     * @response 500 {
     *  "error": "Failed to fetched toolbox talks: Something went wrong!"
     * }
     */
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

    /**
     * Retrieve all assigned to me toolbox talks data which is assigned to authentication (auth) user.
     *
     * This endpoint returns all assigned to me toolbox talks data. In this API, we get all assigned to me toolbox talks data and also we can filter through ongoing or completed or ended status that toolbox tallk is in ongoing status (means need to take or attempt the question sheet or acknowledged toolbox talk) or completed status(means attempt done or acknowledged successfully toolbox talk) or ended status(means toolbox talk has been expired). We can do search, filter by dates from all assigned to me toolbox talks.
     *
     * @queryParam no need of any param at initial. If we want to search or filter or sorted any toolbox talk then we need to put query params while we are searching then we need to put 'search' & for getting ongoing or completed or ended then we need to put 'status' param and 'start_date' & 'end_date' when we want to filter according to the dates from calender.
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Successfully fetched Toolbox Talks that are assigned to you.",
     *       "assignToMeToolboxTalks": {
     *           "data": [
     *           {
     *               "id": 44,
     *               "role_id": null,
     *               "permission_id": null,
     *               "toolbox_talk_id": 8,
     *               "user_email": "chandrakeshp@chetu.com",
     *               "user_name": "Chandrakesh Pandey",
     *               "due_date": "2025-08-27",
     *               "user_id": 4392,
     *               "status": "3",
     *               "result": null,
     *               "attempt_count": null,
     *               "date_time": null,
     *               "created_at": "2025-08-27T14:35:44.000000Z",
     *               "updated_at": "2025-08-27T14:35:44.000000Z",
     *               "deleted_at": null,
     *               "get_toolbox_talk_count": 1,
     *               "get_toolbox_talk": {
     *                   "id": 8,
     *                   "title": "Test new again",
     *                   "video_url": null,
     *                   "number_of_questions_to_ask": null,
     *                   "number_of_correct_answer_to_pass": null,
     *                   "file": null,
     *                   "description": "",
     *                   "user_id": 4392,
     *                   "is_library": "3",
     *                   "is_library_deleted": "2",
     *                   "due_date": "2025-08-27",
     *                   "deleted_at": null,
     *                   "status": "1",
     *                   "is_created": "1",
     *                   "created_at": "2025-08-27T14:35:44.000000Z",
     *                   "updated_at": "2025-08-27T14:35:52.000000Z",
     *                   "get_created_by_user": null,
     *                   "questions": [],
     *                   "get_assigned_users": [
     *                       {
     *                           "id": 42,
     *                           "role_id": null,
     *                           "permission_id": null,
     *                           "toolbox_talk_id": 8,
     *                           "user_email": "akashs@chetu.com",
     *                           "user_name": "Akash Sinha",
     *                           "due_date": "2025-08-27",
     *                           "user_id": 4379,
     *                           "status": "3",
     *                           "result": null,
     *                           "attempt_count": null,
     *                           "date_time": null,
     *                           "created_at": "2025-08-27T14:35:44.000000Z",
     *                           "updated_at": "2025-08-27T14:35:44.000000Z",
     *                           "deleted_at": null,
     *                           "assigned_users": null
     *                       },
     *                       {
     *                           "id": 43,
     *                           "role_id": null,
     *                           "permission_id": null,
     *                           "toolbox_talk_id": 8,
     *                           "user_email": "armaanl@chetu.com",
     *                           "user_name": "armaan lodi",
     *                           "due_date": "2025-08-27",
     *                           "user_id": 4723,
     *                           "status": "3",
     *                           "result": null,
     *                           "attempt_count": null,
     *                           "date_time": null,
     *                           "created_at": "2025-08-27T14:35:44.000000Z",
     *                           "updated_at": "2025-08-27T14:35:44.000000Z",
     *                           "deleted_at": null,
     *                           "assigned_users": null
     *                       }
     *                   ],
     *                   "resource_url_data": [
     *                       {
     *                           "id": 7,
     *                           "user_id": 4392,
     *                           "toolbox_talk_id": 8,
     *                           "video_url": "https://static.vecteezy.com/system/resources/previews/008/259/475/mp4/wooden-dummy-training-in-wing-chun-kung-fu-a-man-practicing-wing-chun-video.mp4",
     *                           "video_description": null,
     *                           "video_status": "1",
     *                           "video_state": "Completed",
     *                           "deleted_at": null,
     *                           "created_at": null,
     *                           "updated_at": "2025-08-27T14:38:05.000000Z"
     *                       }
     *                   ],
     *                   "attachments_pdf_data": []
     *               }
     *           },
     *           ]
     *      }
     *
     * @response 404 {
     *  "error": "Data not found."
     * }
     *
     * @response 500 {
     *  "error": "Failed to fetched toolbox talks: Something went wrong!"
     * }
     */
    public function assignToMeToolboxTalks(Request $req)
    {
        $user_id = Auth::user()->id ?? 4392; // this is auth user id
        $filter = $this->filterRequestData($req);
        try {
            if (isset($user_id) && !empty($user_id)) {
                $getAssignToMeTalks = GetAllAssignedByMeTalksResource::collection(AssignToolboxTalk::searchingAssignedMeFilter($req)->where('user_id', $user_id)->with('getToolboxTalk')->withCount('getToolboxTalk')->where('deleted_at', null)->orderBy($filter['sortBy'], $filter['sortOrder'])->paginate($filter['showPage']))->response()->getData(true);
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


    /**
     * Retrieve all company library toolbox talks data which is saved into toolbox talk library.
     *
     * This endpoint returns all company library toolbox talks data. In this API, we get all company library toolbox talks data and also we can sorting through choosing Date created or Date updated from the dropdown list that toolbox tallk is created at what datetime or updated at what datetime. We can do search from the company library toolbox talks.
     *
     * @queryParam no need of any param at initial. If we want to search or sorting any library toolbox talks then we need to put query params while we are searching then we need to put 'search_cms' & for sorting according to the dates we need to put the updated_date or created_date in param.
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Company Toolbox Talks Talks fetched successfully.",
     *       "toolboxTalks": {
     *           "data": [
     *               {
     *                   "id": 8,
     *                   "title": "Test new again",
     *                   "video_url": null,
     *                   "number_of_questions_to_ask": null,
     *                   "number_of_correct_answer_to_pass": null,
     *                   "file": null,
     *                   "description": "",
     *                   "user_id": 4392,
     *                   "is_library": "3",
     *                   "is_library_deleted": "2",
     *                   "due_date": "2025-08-27",
     *                   "deleted_at": null,
     *                   "status": "1",
     *                   "is_created": "1",
     *                   "created_at": "2025-08-27T14:35:44.000000Z",
     *                   "updated_at": "2025-08-27T14:35:52.000000Z",
     *                   "get_assigned_users_count": 5,
     *                   "get_count_completed_count": 0
     *               },
     *               {
     *                   "id": 7,
     *                   "title": "Testing new ",
     *                   "video_url": null,
     *                   "number_of_questions_to_ask": null,
     *                   "number_of_correct_answer_to_pass": null,
     *                   "file": null,
     *                   "description": "",
     *                   "user_id": 4392,
     *                   "is_library": "3",
     *                   "is_library_deleted": "2",
     *                   "due_date": "2025-08-27",
     *                   "deleted_at": null,
     *                   "status": "1",
     *                   "is_created": "1",
     *                   "created_at": "2025-08-27T14:34:51.000000Z",
     *                   "updated_at": "2025-08-27T14:34:55.000000Z",
     *                   "get_assigned_users_count": 1,
     *                   "get_count_completed_count": 0
     *               },
     *           ],
     *           "links": {"first": "https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks?page=1", "last": "https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks?page=1", "prev": null,"next": null},
     *           "meta": { "current_page": 1, "from": 1, "last_page": 1,
     *           "links": [{"url": null, "label": "&laquo; Previous", "active": false}, {"url": "https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks?page=1","label": "1","active": true}, { "url": null, "label": "Next &raquo;", "active": false }],
     *           "path": "https://companymanagementsystems-back-qa.chetu.com/api/v1/createdByMe-talks", "per_page": 10, "to": 8, "total": 8 }
     *       }
     *
     * @response 404 {
     *  "error": "Data not found."
     * }
     *
     * @response 500 {
     *  "error": "Failed to fetched toolbox talks: Something went wrong!"
     * }
     */
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


    /**
     * Update the video status OR PDF status of a toolbox talk.
     *
     * This endpoint updates the video status OR PDF status of a toolbox talk. In this API, while we are updating the video status OR PDF status of a toolbox talk, we need to send 'video_id' OR 'file_id' and 'type' param to differentiate that we are updating PDF status or video status & also send the value of 'status' means video is watched or not & at other hand, PDF is read or not.
     *
     * @bodyParam 'toolbox_talk_id' int required The toolbox_talk_id of the toolbox talk. 
     * @bodyParam 'video_id' interger required while 'file_id' is not available. The video id of the toolbox talk.
     * @bodyParam 'file_id' interger required while 'video_id' is not available. The File id of the toolbox talk.
     * @bodyParam 'type' string required. The 'type' to differentiate the PDF or Video of the toolbox talk.
     * @bodyParam 'status' interger required. Status of video has been watched or not, same for PDF is read or not of a toolbox talk.
     *
     * @response 201 {
     *  "status": 200,
     *  "message": "Attachments updated successfully",
     *  "data": {
     *          "id": 1,
     *   "user_id": 4392,
     *   "toolbox_talk_id": 1,
     *   "video_url": "https://static.vecteezy.com/system/resources/previews/008/259/475/mp4/wooden-dummy-training-in-wing-chun-kung-fu-a-man-practicing-wing-chun-video.mp4",
     *   "video_description": null,
     *   "video_status": "1",
     *   "video_state": "Completed",
     *   "deleted_at": null,
     *   "created_at": "2025-08-26T17:22:40.000000Z",
     *   "updated_at": "2025-08-27T18:05:08.000000Z"
     *       }
     *   "msg": "Video has been completed successfully!"
     * }
     *
     * @response 422 {
     *  "error": {
     *      "toolbox_talk_id": ["The toolbox_talk_id field is required."],
     *  }
     * }
     */
    public function updateVideoPdfsStatus(CheckVideoPdfStatusRequest $req)
    {
        $authUser = Auth::user()->id ?? '4392';
        if ($req->type == 'Video') {
            $updateStatus = tap(ResourceVideoLink::where('id', $req->video_id))->update(['video_status' => $req->status, 'video_state' => 'Completed', 'user_id' => $authUser, 'toolbox_talk_id' => $req->toolbox_talk_id])->first();
        } else {
            $updateStatus = tap(MediaFile::where('id', $req->file_id))->update(['file_status' => $req->status, 'file_state' => 'Completed', 'user_id' => $authUser, 'toolbox_talk_id' => $req->toolbox_talk_id])->first();
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

    /**
     * Get details of questions with their options by toolbox_talk_id.
     *
     * This endpoint returns details of questions with their options of a toolbox talk when their ID is provided as a body parameter. This API is providing the details of all questions with thier options for a particular toolbox talk which have all data of questions sheet with options.
     *
     * @bodyParam toolbox_talk_id int required The toolbox_talk_id of the toolbox talk. 
     *
     * @response 200 {
     *       "msg": "Toolbox Talks questions and options data has been fetched successfully.",
     *       "data": {
     *          "id": 58,
     *          "title": "new fresh test1",
     *          "number_of_questions_to_ask": 1,
     *          "number_of_correct_answer_to_pass": 1,
     *          "description": "This talk covers essential safety measures when working at heights, including the use of protective equipment, proper setup of ladders and scaffolding, and awareness of potential fall hazards.",
     *          "user_id": 4392,
     *          "is_library": "2",
     *           "questions": [{ "id": 167, "name": "this is first question", "options": [{"id": 665, "name": "test1"}, {"id": 666,"name": "test2"},{"id": 667,"name": "test3"},{"id": 668,"name": "test4"}],{ "id": 167, "name": "this is second question", "options": [{"id": 770, "name": "A"}, {"id": 771,"name": "B"},{"id": 772,"name": "C"},{"id": 773,"name": "D"}]}],
     *       },
     *      
     * }
     *
     * @response 404 {
     *  "error": "Questions with options of a toolbox talk data not found"
     * }
     */
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

    /**
     * Get video OR PDF status detail after watched or read by toolbox_talk_id.
     *
     * This endpoint returns details of video OR PDf status(updated status) of a toolbox talk when their ID is provided as a body parameter. This API is providing the details of status of Video OR PDF.
     *
     * @bodyParam toolbox_talk_id int required The toolbox_talk_id of the toolbox talk. 
     *
     * @response 200 {
     *  {
     *      "status": 200,
     *      "vorfstatus": 3
     *  }
     *      
     * }
     *
     */
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

    /**
     * Update the acknowledged status of a toolbox talk.
     *
     * This endpoint updates the acknowledged status of a toolbox talk. In this API, while we are updating the acknowledged status of a toolbox talk, we need to send 'status' value as 2. When any auth user watches any video through the video link or read the proper PDF then if question sheets are avilable of this toolbox talk, user need to attempt the exam or attempt the questions if he passed then he can acknowledged for this particular toolbox talk. If he failed then he need to attempt again & again, until he does not pass.
     *
     * @bodyParam 'toolbox_talk_id' int required The toolbox_talk_id of the toolbox talk. 
     *
     * @response 201 {
     *  "message": "AssignToolBox acknowledged successfully!",
     * }
     *
     * @response 422 {
     *  "error": {
     *      "toolbox_talk_id": ["The toolbox_talk_id field is required."],
     *  }
     * }
     */
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

    /**
     * Make a copy of a toolbox talk.
     *
     * This endpoint updates Make a copy of a toolbox talk. In this API, while we are making a copy of a toolbox talk. Using this API we can make a copy of a particular toolbox talk. We can generate multiple copies of a toolbox talk. After copy of the toolbox talk, whole data is copied as it is and we are able to assigned to some users.
     *
     * @bodyParam 'toolbox_talk_id' int required The toolbox_talk_id of the toolbox talk. 
     *
     * @response 201 {
     *  "msg": "Toolbox Talk copy is created successfully",
     * }
     *
     * @response 422 {
     *  "error": {
     *      "toolbox_talk_id": ["The toolbox_talk_id field is required."],
     *  }
     * }
     */
    public function makeToolboxCopy(GetAssignToMeDetailRequest $req)
    {
        try {
            DB::beginTransaction();
            $original = ToolboxTalk::with('questions.options', 'resourceUrlData', 'attachmentsPdfData', 'getAssignedUsers')->find($req->toolbox_talk_id);
            $user = User::find(1);
            if (!$user->hasPermissionTo('Creator')) {
                return response()->json([
                    'message' => "You do not have permission to access Create Toolbox Talk feature!",
                ], 200);
            }
            $copy = $original->replicate();
            $baseTitle = $original->title . ' - copy';
            $number = 1;
            $newTitle = $baseTitle . " ($number)";
            while (ToolboxTalk::where('title', $newTitle)->exists()) {
                $number++;
                $newTitle = $baseTitle . " ($number)";
            }
            $copy->title = $newTitle;
            $copy->save();
            if ($original->resourceUrlData) {
                $resourceUrlDataWithKey = [];
                foreach ($original->resourceUrlData as $url) {
                    $resourceUrlDataWithKey[] = [
                        'video_url' => $url->video_url,
                        'toolbox_talk_id' => $copy->id,
                    ];
                }
                ResourceVideoLink::insert($resourceUrlDataWithKey);
            }
            if ($original->attachmentsPdfData) {
                $fileData = [];
                foreach ($original->attachmentsPdfData as $file) {
                    $fileName = 'toolbox_talk_' . $copy->id . rand(10, 100) . time() . '.pdf';
                    $filePath = $file->file_path;
                    $fileData[] = [
                        'file_name' => $fileName,
                        'file_path' => $filePath,
                        'toolbox_talk_id' => $copy->id,
                    ];
                }
                MediaFile::insert($fileData);
            }
            if ($original->questions) {
                foreach ($original->questions as $questionData) {
                    $question = $copy->questions()->create([
                        'name' => $questionData->name,
                        'toolbox_talk_id' => $copy->id,
                    ]);
                    foreach ($questionData->options as $index => $optionName) {
                        $question->options()->create([
                            'name' => $optionName->name,
                            'correct_answer' => $optionName->correct_answer,
                            'question_id' => $question->id,
                        ]);
                    }
                }
            }
            $copy->update(['status' => '0', 'is_created' => '1', 'updated_at' => Carbon::now(), 'is_library' => null]);
            DB::commit();
            return response()->json(['msg' => 'Toolbox Talk copy is created successfully.', 'data' => $copy], 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to create Toolbox Talk: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update the title or description of a toolbox talk.
     *
     * This endpoint updates the title or description of a toolbox talk. In this API, while we are updating the title or description then title or desciption param will be send in API in bodyparam & also send the toolbox talk ID.
     *
     * @bodyParam 'toolbox_talk_id' int required The toolbox_talk_id of the toolbox talk. 
     * @bodyParam 'title' string required while 'description' is not available. The title of the toolbox talk.
     * @bodyParam 'description' string required while 'title' is not availble. The description of the toolbox talk.
     *
     * @response 201 {
     *  "msg": "Toolbox Talk content has been updated successfully",
     * }
     *
     * @response 422 {
     *  "error": {
     *      "toolbox_talk_id": ["The toolbox_talk_id field is required."],
     *  }
     * }
     */
    public function updateContentToolboxtalk(UpdateContentToolboxRequest $req)
    {
        try {
            $updateContent = ToolboxTalk::where('id', $req->toolbox_talk_id)->first();
            if (!empty($updateContent) || ($updateContent != null || $updateContent != '')) {
                $updatedData = $updateContent->update(['title' => $req->title ?? $updateContent->title]);
                $updatedData = $updateContent->update(['description' => $req->description ?? $updateContent->description]);
                if ($updatedData) {
                    return response()->json(['msg' => 'Toolbox Talk content has been updated successfully'], 201);
                }
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create Toolbox Talk: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Get the detailed data of signoff sheet with title data of a toolbox talk.
     *
     * This endpoint retrieves detailed data of signoff sheet with title data of a toolbox talk. In this API, while we are getting ata of signoff sheet with title data then we need to send only 'toolbox_talk_id' in queryParam.
     *
     * @queryParam 'toolbox_talk_id' int required The toolbox_talk_id of the toolbox talk.
     *
     * @response 201 {
     * }
     *
     * @response 422 {
     *  "error": {
     *      "toolbox_talk_id": ["The toolbox_talk_id field is required."],
     *  }
     * }
     */
    public function exportCsv($id)
    {
        try {
            $toolbox_talk_id = $id;
            if (!empty($toolbox_talk_id)) {
                $toolboxTalk = ToolboxTalk::withTrashed()->with('getAssignedUsers')->findOrFail($toolbox_talk_id);
                return Excel::download(new ToolboxTalkCSVExport($toolboxTalk), 'toolbox_talk_' . $toolbox_talk_id . '.csv');
            } else {
                return response()->json([
                    'message' => "Id is required!",
                ], 500);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Failed to Export Toolbox Talk CSV Export:' . $e->getMessage()
            ], 500);
        }
    }
}
