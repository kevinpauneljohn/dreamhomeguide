<?php
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::post('/notifications/mark-read', [NotificationController::class,'notificationMarkAsRead'])->name('notifications-mark-read');
    Route::get('/notifications', [NotificationController::class,'notifications'])->name('notifications');

});
