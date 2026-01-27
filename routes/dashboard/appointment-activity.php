<?php

use App\Http\Controllers\AppointmentActivityController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
   Route::resource('appointment-activity',AppointmentActivityController::class);
});
