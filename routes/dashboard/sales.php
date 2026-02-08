<?php

use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('sales',\App\Http\Controllers\SalesController::class);
    Route::get('/sales-pipeline',[SalesController::class,'pipeline'])->name('sales.pipeline');
    Route::get('/sales-datatable',[SalesController::class,'getSalesDataTables'])->name('sales.datatable');
    Route::get('/get-current-month-sales',[SalesController::class,'getCurrentMonthSales'])->name('sales.current-month');
    Route::get('/get-agent-sales-rankings',[SalesController::class,'getAgentRankingTable'])->name('sales.rankings');
    Route::get('/get-current-year-sales', [SalesController::class, 'getCurrentYearSales'])->name('sales.current-year');
});
