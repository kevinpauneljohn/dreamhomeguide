<?php
use App\Http\Controllers\LeadsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('leads', LeadsController::class);
    Route::get('/get-leads',[LeadsController::class,'getLeads'])->name('get-leads');
    Route::patch('/lead/{lead}/update-field',[LeadsController::class,'updateField'])->name('lead.update-field');
});
