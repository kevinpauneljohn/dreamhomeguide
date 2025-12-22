<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
   Route::get('/activities/lead/{lead}', [\App\Http\Controllers\ActivityController::class,'getActivitiesByLeads'])->name('activities.leads');
   Route::get('/activities/user/{user}', [\App\Http\Controllers\ActivityController::class,'getActivitiesByUser'])->name('activities.user');
});
