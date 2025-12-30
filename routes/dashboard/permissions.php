<?php

use App\Http\Controllers\PermissionsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('permissions', PermissionsController::class);
    Route::get('/get-permissions',[PermissionsController::class,'getPermissions'])->name('get-permissions');
});
