<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
   Route::resource('note',NoteController::class);
   Route::get('/get-notes/lead/{lead}',[NoteController::class,'getNotes'])->name('get-notes');
});
