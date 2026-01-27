    <?php

use App\Http\Controllers\ComputationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('computations',ComputationController::class);
    Route::get('/get-project-units/{project}',[ComputationController::class,'units'])->name('get-units');
    Route::get('/get-computations',[ComputationController::class,'getComputations'])->name('get-computations');
    Route::get('/get-computations-prompt/{computation}',[ComputationController::class,'getComputationPrompt'])->name('get-computations-prompt');
});
