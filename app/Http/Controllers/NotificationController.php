<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get user notifications
     */
    public function index(Request $request)
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->with('fromUser', 'post.topic')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return response()->json(['data' => $notifications]);
    }

    /**
     * Get unread notifications count
     */
    public function unreadCount()
    {
        $count = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();
            
        return response()->json(['unread_count' => $count]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification)
    {
        $this->authorize('view', $notification);
        
        $notification->update(['is_read' => true]);
        return response()->json(['data' => $notification]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        return response()->json(['message' => 'All notifications marked as read']);
    }

    /**
     * Delete a notification
     */
    public function destroy(Notification $notification)
    {
        $this->authorize('delete', $notification);
        
        $notification->delete();
        return response()->json(['message' => 'Notification deleted']);
    }

    /**
     * Delete all notifications
     */
    public function destroyAll()
    {
        Notification::where('user_id', auth()->id())->delete();
        return response()->json(['message' => 'All notifications deleted']);
    }
}
