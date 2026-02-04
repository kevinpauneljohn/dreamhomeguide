<?php

use App\Http\Controllers\CommissionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('commission', CommissionController::class);
    Route::get('/commissions-datatable/{user}',[CommissionController::class,'getCommissionsTable'])->name('get-commissions-table');
});
