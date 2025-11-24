<?php

use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('property', PropertyController::class);
    Route::get('/properties', [PropertyController::class, 'properties'])->name('properties');
    Route::get('/property/images/{property}', [PropertyController::class, 'propertyImages'])->name('property.images');
    Route::post('/property/images/{property}/upload', [PropertyController::class, 'uploadPropertyImages'])->name('property.images.upload');
    Route::get('/property/images/{property}/get',[PropertyController::class,'images'])->name('property.images.get');
});
