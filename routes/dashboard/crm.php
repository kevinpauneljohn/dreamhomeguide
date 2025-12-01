<?php

use App\Http\Controllers\CrmController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
   Route::get('/crm', CrmController::class)->name('crm.index');
});
