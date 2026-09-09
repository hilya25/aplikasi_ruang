<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalRooms = Room::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $todayBookings = Booking::whereDate('start_datetime', Carbon::today())->count();
        $recentBookings = Booking::with('room', 'user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalRooms', 'pendingBookings', 'todayBookings', 'recentBookings'));
    }

    /**
     * Halaman monitoring user: siapa saja yang login / sedang aktif.
     */
    public function activeUsers()
    {
        // User yang sedang login (belum logout)
        $onlineUsers = User::where('is_logged_in', true)
            ->orderByDesc('last_active_at')
            ->get();

        $recentlyLoggedIn = User::whereNotNull('last_login_at')
            ->orderByDesc('last_login_at')
            ->take(10)
            ->get();

        $neverLoggedIn = User::whereNull('last_login_at')->count();

        return view('admin.active-users', compact('onlineUsers', 'recentlyLoggedIn', 'neverLoggedIn'));
    }
}
