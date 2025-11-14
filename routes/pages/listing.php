<?php

use App\Http\Controllers\ListingController;
    use Illuminate\Support\Facades\Route;

Route::resource('listing', ListingController::class);
