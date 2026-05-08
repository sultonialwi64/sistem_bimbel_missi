<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Get all notifications for authenticated user
     */
    public function index(Request $request)
    {
        $notifications = $this->notificationService->getRecentNotifications(
            $request->user(),
            $request->input('limit', 20)
        );

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = \App\Models\Notification::findOrFail($id);
        
        // Authorize
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notification marked as read');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        $this->notificationService->markAllAsRead($request->user());

        return redirect()->back()->with('success', 'All notifications marked as read');
    }

    /**
     * Get unread count (for API/notification bell)
     */
    public function unreadCount(Request $request)
    {
        return response()->json([
            'count' => $this->notificationService->getUnreadCount($request->user())
        ]);
    }
}
