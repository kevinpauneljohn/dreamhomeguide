<?php

use App\Http\Controllers\AppointmentActivityController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
   Route::resource('appointment-activity',AppointmentActivityController::class);
   Route::get('/get-appointment-activities/{appointment}',[AppointmentActivityController::class,'getAppointmentActivities'])->name('get-appointment-activities');
   Route::get('/get-appointment-tasks/{appointment}',[AppointmentActivityController::class,'getAppointmentTasks'])->name('get-appointment-tasks');
});
