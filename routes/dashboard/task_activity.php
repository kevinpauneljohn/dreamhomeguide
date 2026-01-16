<?php

use App\Http\Controllers\TaskActivityController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('task-activity',TaskActivityController::class);
});
