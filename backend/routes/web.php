<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ToolboxTalkController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/export_toolbox_csv_web/{id}', [ToolboxTalkController::class, 'exportCsv']); // csv export excel

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
