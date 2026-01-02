<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
   Route::get('/profile', [ProfileController::class,'profile'])->name('profile');
   Route::put('/profile/update', [ProfileController::class,'updateProfile'])->name('profile.update');
   Route::put('/profile/change-password', [ProfileController::class,'changePassword'])->name('profile.change-password');
});
