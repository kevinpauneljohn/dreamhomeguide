<?php

use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

Route::get('/apec-homes/alpine-residences', [LandingPageController::class, 'landingPage'])->name('landing-page');
Route::post('/form-submit', [LandingPageController::class, 'formSubmit'])->name('form-submit');
Route::get('/thank-you', [LandingPageController::class, 'thankYou'])->name('thank-you');
