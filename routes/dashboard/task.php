<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('task', TaskController::class);
    Route::get('/get-tasks',[TaskController::class,'getTasks'])->name('get-tasks');
});
