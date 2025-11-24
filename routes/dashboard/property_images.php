<?php

use App\Http\Controllers\PropertyImageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('property-images',PropertyImageController::class);
});
