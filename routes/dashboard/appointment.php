<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('appointment', \App\Http\Controllers\AppointmentController::class);
    Route::get('/get-appointments',[AppointmentController::class,'getAppointments'])->name('get-appointments');
    Route::get('/get-appointment/user/{userId}',[AppointmentController::class,'getUserAppointments'])->name('get-user-appointment');
    Route::get('/appointment/status/{appointment}',[AppointmentController::class,'getAppointmentStatus'])->name('appointment.status');
});
