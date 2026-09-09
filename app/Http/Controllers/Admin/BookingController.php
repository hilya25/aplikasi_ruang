<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Notification;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Tampilkan daftar semua booking
     */
    public function index()
    {
        $bookings = Booking::with('room', 'user')->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Setujui booking
     */
    public function approve(Booking $booking)
    {
        $booking->update(['status' => 'approved']);

        // Buat notifikasi
        Notification::create([
            'user_id' => $booking->user_id,
            'title'   => 'Booking Disetujui',
            'message' => 'Booking ruangan "' . $booking->room->name . '" telah disetujui oleh admin.',
            'type'    => 'booking_approved',
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil disetujui!');
    }

    /**
     * Tolak booking
     */
    public function reject(Booking $booking)
    {
        $booking->update(['status' => 'rejected']);

        // Buat notifikasi
        Notification::create([
            'user_id' => $booking->user_id,
            'title'   => 'Booking Ditolak',
            'message' => 'Booking ruangan "' . $booking->room->name . '" telah ditolak oleh admin.',
            'type'    => 'booking_rejected',
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil ditolak!');
    }
}
