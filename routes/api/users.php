<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/get-users', [UserController::class, 'getUsers'])->name('api.users.get');
});
