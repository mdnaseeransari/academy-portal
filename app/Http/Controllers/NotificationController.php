<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Show all notifications in admin.
     */
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.notifications', compact('notifications'));
    }

    /**
     * Save new notification, deactivate all others first.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        DB::transaction(function() use ($request) {
            // Deactivate all existing active notifications
            Notification::where('is_active', true)->update(['is_active' => false]);

            // Create new active notification
            Notification::create([
                'message' => $request->message,
                'is_active' => true,
            ]);
        });

        return redirect()->back()->with('success', 'Notification created and activated successfully.');
    }

    /**
     * Delete a notification.
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted successfully.');
    }
}
