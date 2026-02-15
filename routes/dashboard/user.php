<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('user', UserController::class);
    Route::get('/get-users',[UserController::class,'getUsers'])->name('get-users');
    Route::post('/update-user-profile-photo/{user}',[UserController::class,'updateProfilePhoto'])->name('update-user-profile-photo');
    Route::post('/users/{user}/files/upload',[UserFileController::class,'store'])->name('users.files.store');
    Route::get('/users/{user}/files',[UserFileController::class,'getUserFiles'])->name('users.files');
    Route::delete('/users/files/{userFile}/delete',[UserFileController::class,'destroy'])->name('users.files.destroy');
});
