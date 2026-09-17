<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Dashboard user (guru/staff)
     */
    public function dashboard()
    {
        $user = Auth::user();

        $myBookings = Booking::with('room')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total'     => Booking::where('user_id', $user->id)->count(),
            'pending'   => Booking::where('user_id', $user->id)->where('status', 'pending')->count(),
            'approved'  => Booking::where('user_id', $user->id)->where('status', 'approved')->count(),
            'rejected'  => Booking::where('user_id', $user->id)->where('status', 'rejected')->count(),
        ];

        return view('user.dashboard', compact('myBookings', 'stats'));
    }

    /**
     * Daftar notifikasi user
     */
    public function notifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.notifications', compact('notifications'));
    }

    /**
     * Tandai notifikasi sudah dibaca
     */
    public function markNotificationRead(Notification $notification)
    {
        // Pastikan user hanya bisa baca notifikasi sendiri
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->update(['is_read' => true]);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    /**
     * Tandai semua notifikasi sudah dibaca
     */
    public function markAllNotificationsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }

    /**
     * Daftar ruangan (katalog) - dikelompokkan berdasarkan jenis
     */
    public function rooms()
    {
        $rooms = Room::where('is_active', true)
            ->withCount(['schedules as schedules_count' => function ($q) {
                $q->where('status', 'active');
            }])
            ->orderBy('name')
            ->get();

        // Kelompokkan berdasarkan jenis
        $groupedRooms = $rooms->groupBy('type');

        // Urutan jenis ruangan
        $typeOrder = ['Kelas', 'Lab', 'Aula', 'Lapangan', 'Masjid', 'Activity Room', 'Perpustakaan'];

        return view('user.rooms', compact('rooms', 'groupedRooms', 'typeOrder'));
    }

    /**
     * Detail ruangan + jadwal
     */
    public function show(Room $room)
    {
        // Jadwal pelajaran yang aktif, urutkan per hari
        $schedules = $room->schedules()
            ->where('status', 'active')
            ->with('classRoom')
            ->orderByRaw("FIELD(day_of_week, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('start_time')
            ->get();

        // Booking yang sudah disetujui dan belum lewat waktu
        $bookings = $room->bookings()
            ->where('status', 'approved')
            ->where('end_datetime', '>=', now())
            ->with('user')
            ->orderBy('start_datetime')
            ->get();

        return view('user.room-detail', compact('room', 'schedules', 'bookings'));
    }
}