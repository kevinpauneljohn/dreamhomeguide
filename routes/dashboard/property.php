<?php

use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('property', PropertyController::class);
    Route::get('/permissions', [PropertyController::class, 'permission'])->name('permissions');
    Route::get('/properties', [PropertyController::class, 'properties'])->name('properties');
});
