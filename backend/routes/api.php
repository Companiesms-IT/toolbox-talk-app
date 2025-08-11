<?php

use App\Http\Controllers\API\ToolboxTalkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    // Define a POST route within the v1 prefix
    Route::post('/create-toolbox-talk', [ToolboxTalkController::class, 'createToolboxTalk']);
    Route::get('/roles-permissions-users', [ToolboxTalkController::class, 'getRolesPermissions']);
    Route::get('/createdByMe-talks', [ToolboxTalkController::class, 'createdByMeTalks']);

    /** Assign Toolbox Talk */
    Route::post('/assign-toolboxtalk',  [ToolboxTalkController::class, 'assignToolboxTalk']);
    Route::get('/toolbox-talk/{id?}',  [ToolboxTalkController::class, 'toolboxTalkDetails']);
    // Route::post('/toolbox-talk-details/',  [ToolboxTalkController::class, 'toolboxTalkDetails']);
    Route::post('/toolboxtalk/{id}',  [ToolboxTalkController::class, 'updateToolboxTalk']);

    Route::get('/check-status/{id}',  [ToolboxTalkController::class, 'checkTalkStatus']);    // Completed Check Status
    // Route::delete('/delete-talk/{id?}',  [ToolboxTalkController::class, 'deleteTalk']); 
    Route::post('/delete-url-pdf',  [ToolboxTalkController::class, 'deleteVideoUrlOrAttachments']);  // delete single Talk
    Route::post('/delete-selected-talks',  [ToolboxTalkController::class, 'deleteSelectedTalks']);    // delete selected talks
    Route::get('/assignToMe-talks',  [ToolboxTalkController::class, 'assignToMeToolboxTalks']);      // get sent to me toolbox talks
    Route::post('/filter-toolbox-talks',  [ToolboxTalkController::class, 'applyFiltersTalks']);      // Apply filters
    Route::post('/update-attachments',  [ToolboxTalkController::class, 'updateAttachmentsPdfUrl']);        // update Attachments
    Route::post('/update-questions',  [ToolboxTalkController::class, 'updateQuestions']);            // update Questions
    Route::get('/company-library-toolbox-talks',  [ToolboxTalkController::class, 'companyLibraryToolboxTalks']);  
    Route::post('/export-toolbox-pdf', [ToolboxTalkController::class, 'exportToolboxPdf']); // Export Toolbox PDF    
    Route::get('/assigned-users/{id?}', [ToolboxTalkController::class, 'getAssignedUsers']); // Export Toolbox PDF  
     
    Route::post('/attempt-questions', [ToolboxTalkController::class, 'attemptQuestions']); // Attempt Questions
    Route::post('/update-new-assigned-toolbox', [ToolboxTalkController::class, 'updateNewAssignedToolboxTalk']);
    
    //Assigned to me
    Route::post('/assignedtome',  [ToolboxTalkController::class, 'assignedToMeDetail']);
    Route::get('/delete-question/{id}',  [ToolboxTalkController::class, 'deleteQuestionPerToolboxTalk']); 
    Route::post('/delete-selected-cms-library',  [ToolboxTalkController::class, 'deleteSelectedCmsLibrary']);
    
    Route::post('/update-video-pdf-status',  [ToolboxTalkController::class, 'updateVideoPdfsStatus']);
    
    Route::post('/get-questions-options',  [ToolboxTalkController::class, 'getOnlyQuestionOptions']);
    
    //Video or attachedment status
    Route::post('/video-pdf-status', [ToolboxTalkController::class, 'videoPdfsStatus']);
    
    Route::post('/acknowledged-status', [ToolboxTalkController::class, 'acknowledgedStatus']);

});