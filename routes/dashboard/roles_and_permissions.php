<?php

use App\Http\Controllers\RolesAndPermissionsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/roles', [RolesAndPermissionsController::class,'rolesIndex'])->name('roles.index');
    Route::post('/roles',[RolesAndPermissionsController::class,'rolesStore'])->name('roles.store');
    Route::get('/roles/{role}/edit',[RolesAndPermissionsController::class,'rolesEdit'])->name('roles.edit');
    Route::put('/roles/{role}',[RolesAndPermissionsController::class,'rolesUpdate'])->name('roles.update');
    Route::delete('/roles/{role}',[RolesAndPermissionsController::class,'rolesDestroy'])->name('roles.destroy');

    Route::get('/roles/create', [RolesAndPermissionsController::class,'rolesCreate'])->name('roles.create');
    Route::get('/roles/get',[RolesAndPermissionsController::class,'getRoles'])->name('roles.get');

});

