<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function notificationMarkAsRead(Request $request)
    {
        try {
            $notification = auth()->user()->notifications()->where('id', $request->id)->firstOrFail();
            $notification->markAsRead();
            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read',
                'unread_count' => auth()->user()->unreadNotifications()->count(),
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function notifications()
    {
        return auth()->user()->unreadNotifications()->limit(10)->get();
    }
}
