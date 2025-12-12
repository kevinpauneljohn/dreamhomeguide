<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('appointment', \App\Http\Controllers\AppointmentController::class);
});
