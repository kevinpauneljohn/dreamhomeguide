<?php

use App\Http\Controllers\ContactUsController;
use Illuminate\Support\Facades\Route;

Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact-us');
