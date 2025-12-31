<?php


use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/tools/calculator/{type}', [\App\Http\Controllers\ToolsController::class, 'calculator'])
        ->name('tools.calculator');

});
