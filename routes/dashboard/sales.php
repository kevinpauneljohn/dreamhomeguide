<?php

use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('sales',\App\Http\Controllers\SalesController::class);
    Route::get('/sales-pipeline',[SalesController::class,'pipeline'])->name('sales.pipeline');
    Route::get('/sales-datatable',[SalesController::class,'getSalesDataTables'])->name('sales.datatable');
});
