<?php

use App\Http\Controllers\ModelUnitController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('model-units', ModelUnitController::class);
    Route::get('/get-model-units/{project_id}',[ModelUnitController::class,'getModelUnits'])->name('get-model-units');
});
