<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function notificationMarkAsRead(Request $request): \Illuminate\Http\JsonResponse
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

    public function notifications(): array
    {
        return [
            'unread_count' => auth()->user()->unreadNotifications()->count(),
            'unread_messages' => auth()->user()->unreadNotifications()->limit(10)->get(),
        ];
    }

    public function getNotifications(): \Illuminate\Http\JsonResponse
    {
        return DataTables::of(auth()->user()->notifications()->latest()->get())
            ->make(true);
    }

    public function allNotifications(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('dashboard.pages.notifications.allnotifications')->with([
            'title' => 'Notifications',
            'notifications' => auth()->user()->notifications()->latest()->paginate(20),
        ]);
    }
}
