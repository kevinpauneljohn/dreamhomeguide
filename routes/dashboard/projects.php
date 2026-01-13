<?php
 use App\Http\Controllers\ProjectController;
 use Illuminate\Support\Facades\Route;

 Route::middleware(['auth'])->group(function () {
     Route::resource('project', ProjectController::class);
     Route::get('/get-projects',[ProjectController::class,'getProjects'])->name('get-projects');
 });
