<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBookingController extends Controller
{
    /**
     * Form booking ruangan
     */
    public function create()
    {
        $rooms = Room::where('is_active', true)->orderBy('name')->get();
        return view('user.bookings.create', compact('rooms'));
    }

    /**
     * Simpan booking baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id'        => 'required|exists:rooms,id',
            'event_type'     => 'required|in:Pinjam,Acara Sekolah,Dikosongkan',
            'description'    => 'nullable|string|max:255',
            'start_datetime' => 'required|date|after_or_equal:now',
            'end_datetime'   => 'required|date|after:start_datetime',
        ]);

        // Cek ketersediaan ruangan
        $conflict = Booking::where('room_id', $request->room_id)
            ->where('status', '!=', 'rejected')
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_datetime', [$request->start_datetime, $request->end_datetime])
                    ->orWhereBetween('end_datetime', [$request->start_datetime, $request->end_datetime])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_datetime', '<=', $request->start_datetime)
                          ->where('end_datetime', '>=', $request->end_datetime);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->withInput()
                ->with('error', 'Ruangan sudah terjadwal di waktu tersebut! Silakan pilih waktu lain.');
        }

        // Simpan booking
        Booking::create([
            'room_id'        => $request->room_id,
            'user_id'        => Auth::id(),
            'event_type'     => $request->event_type,
            'description'    => $request->description,
            'start_datetime' => $request->start_datetime,
            'end_datetime'   => $request->end_datetime,
            'status'         => 'pending',
        ]);

        return redirect()->route('user.bookings.my')
            ->with('success', 'Booking berhasil diajukan! Menunggu persetujuan admin.');
    }

    /**
     * Daftar booking saya
     */
    public function myBookings()
    {
        $bookings = Booking::with('room')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.bookings.my', compact('bookings'));
    }

    /**
     * Batalkan booking (hanya jika status pending)
     */
    public function cancel(Booking $booking)
    {
        // Pastikan user hanya bisa batalkan booking sendiri
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Hanya bisa batalkan jika status pending
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking yang sudah diproses tidak bisa dibatalkan.');
        }

        $booking->delete();

        return back()->with('success', 'Booking berhasil dibatalkan!');
    }
}