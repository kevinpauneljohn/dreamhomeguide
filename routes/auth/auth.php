<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class,'login'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class,'authenticate'])->name('authenticate');
Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');

