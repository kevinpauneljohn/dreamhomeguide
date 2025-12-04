<?php

use App\Http\Controllers\ListingController;
    use Illuminate\Support\Facades\Route;

Route::resource('listing', ListingController::class);
Route::get('/property-listing/{slug}', [ListingController::class, 'showBySlug'])->name('show-property-by-slug');
