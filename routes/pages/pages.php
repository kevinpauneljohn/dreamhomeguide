<?php

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/list-my-property',[PagesController::class,'listMyProperty'])->name('list-my-property');
Route::post('/submit-listing',[PagesController::class,'submitListing'])->name('store-list-my-property');
Route::get('/privacy-policy',[PagesController::class,'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-and-conditions',[PagesController::class,'termsAndConditions'])->name('terms-and-conditions');
Route::get('/sitemap',[PagesController::class,'sitemap'])->name('sitemap');
Route::get('/sitemap.xml',[PagesController::class,'sitemapXml'])->name('sitemap.xml');

Route::get('/blogs',[PagesController::class,'blogs'])->name('blogs');
Route::get('/blog/post/{slug}',[PagesController::class,'blogPost'])->name('blog-post');
