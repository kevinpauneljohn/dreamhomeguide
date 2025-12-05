<?php

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/list-my-property',[PagesController::class,'listMyProperty'])->name('list-my-property');
Route::post('/submit-listing',[PagesController::class,'submitListing'])->name('store-list-my-property');
