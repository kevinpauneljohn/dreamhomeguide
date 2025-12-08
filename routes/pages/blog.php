<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('blog', BlogController::class);
    Route::get('/get-blogs',[BlogController::class,'getBlogs'])->name('get-blogs');
});

