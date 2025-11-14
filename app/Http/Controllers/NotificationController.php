<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a paginated list of the user's notifications.
     */
    public function index()
    {
        // Paginate notifications for proper links()
        $notifications = Auth::user()->notifications()->latest()->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a single notification as read via AJAX.
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}
