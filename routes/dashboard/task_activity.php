<?php

use App\Http\Controllers\TaskActivityController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('task-activity',TaskActivityController::class);
    Route::get('/get-task-activities/{task}',[TaskActivityController::class,'getTaskActivities'])->name('get-task-activities');
});
