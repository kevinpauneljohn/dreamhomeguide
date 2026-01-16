<?php


use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/tools/calculator/{type}', [\App\Http\Controllers\ToolsController::class, 'calculator'])
        ->name('tools.calculator');

    Route::post('/tools/get-computation-result', [\App\Http\Controllers\ToolsController::class, 'computations'])
        ->name('tools.computations');

});
