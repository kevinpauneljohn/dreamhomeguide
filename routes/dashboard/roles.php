<?php

use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
   Route::resource('roles', RolesController::class);
    Route::get('/get-roles',[RolesController::class,'getRoles'])->name('roles.get');
});
