<?php

use App\Http\Controllers\QuotaController;

Route::middleware(['auth'])->group(function () {
    Route::resource('quota',QuotaController::class);
});
