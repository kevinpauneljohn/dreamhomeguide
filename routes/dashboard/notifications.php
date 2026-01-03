<?php
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::post('/notifications/mark-read', [NotificationController::class,'notificationMarkAsRead'])->name('notifications-mark-read');
    Route::get('/notifications', [NotificationController::class,'notifications'])->name('notifications');
    Route::get('/all-notifications', [NotificationController::class,'allNotifications'])->name('all-notifications');
    Route::get('/get-notifications',[NotificationController::class,'getNotifications'])->name('get-notifications');
});
