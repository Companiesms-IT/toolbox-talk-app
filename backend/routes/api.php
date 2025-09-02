<?php

use App\Http\Controllers\API\ToolboxTalkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::post('/create-toolbox-talk', [ToolboxTalkController::class, 'createToolboxTalk']);
    Route::get('/createdByMe-talks', [ToolboxTalkController::class, 'createdByMeTalks']);
    Route::get('/toolbox-talk/{id?}',  [ToolboxTalkController::class, 'toolboxTalkDetails']);
    Route::post('/toolboxtalk/{id}',  [ToolboxTalkController::class, 'updateToolboxTalk']);
    Route::get('/check-status/{id}',  [ToolboxTalkController::class, 'checkTalkStatus']);
    Route::post('/delete-url-pdf',  [ToolboxTalkController::class, 'deleteVideoUrlOrAttachments']);  // delete single Talk
    Route::post('/delete-selected-talks',  [ToolboxTalkController::class, 'deleteSelectedTalks']);    // delete selected talks
    Route::get('/assignToMe-talks',  [ToolboxTalkController::class, 'assignToMeToolboxTalks']);      // Apply filters
    Route::post('/update-attachments',  [ToolboxTalkController::class, 'updateAttachmentsPdfUrl']);        // update Attachments
    Route::post('/update-questions',  [ToolboxTalkController::class, 'updateQuestions']);            // update Questions
    Route::get('/company-library-toolbox-talks',  [ToolboxTalkController::class, 'companyLibraryToolboxTalks']);
    Route::get('/assigned-users/{id?}', [ToolboxTalkController::class, 'getAssignedUsers']); // Export Toolbox PDF  
    Route::post('/attempt-questions', [ToolboxTalkController::class, 'attemptQuestions']); // Attempt Questions
    Route::post('/update-new-assigned-toolbox', [ToolboxTalkController::class, 'updateNewAssignedToolboxTalk']);
    Route::post('/assignedtome',  [ToolboxTalkController::class, 'assignedToMeDetail']);
    Route::get('/delete-question/{id}',  [ToolboxTalkController::class, 'deleteQuestionPerToolboxTalk']);
    Route::post('/delete-selected-cms-library',  [ToolboxTalkController::class, 'deleteSelectedCmsLibrary']);
    Route::post('/update-video-pdf-status',  [ToolboxTalkController::class, 'updateVideoPdfsStatus']);
    Route::post('/get-questions-options',  [ToolboxTalkController::class, 'getOnlyQuestionOptions']);
    Route::post('/video-pdf-status', [ToolboxTalkController::class, 'videoPdfsStatus']);
    Route::post('/acknowledged-status', [ToolboxTalkController::class, 'acknowledgedStatus']);
    Route::post('/make-toolbox-copy', [ToolboxTalkController::class, 'makeToolboxCopy']);
    Route::post('/update-content-toolboxtalk', [ToolboxTalkController::class, 'updateContentToolboxtalk']);
    Route::post('/export-toolbox-pdf', [ToolboxTalkController::class, 'exportToolboxPdf']); // Export Toolbox PDF    
    Route::get('/export_toolbox_csv/{id}', [ToolboxTalkController::class, 'exportCsv']); // csv export excel

});
