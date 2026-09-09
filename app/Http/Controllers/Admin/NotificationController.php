<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Tampilkan daftar notifikasi admin
     */
    public function index()
    {
        $notifications = Notification::latest()->get();
        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Tandai notifikasi sudah dibaca
     */
    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    /**
     * Tandai semua notifikasi sudah dibaca
     */
    public function markAllAsRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}