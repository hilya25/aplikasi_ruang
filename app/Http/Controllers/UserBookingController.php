<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

        // Cek konflik dengan jadwal kelas
        $startCarbon = Carbon::parse($request->start_datetime);
        $endCarbon = Carbon::parse($request->end_datetime);

        // Mapping hari dalam Bahasa Indonesia
        $dayMapping = [
            1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu',
            4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu',
        ];
        $dayOfWeek = $dayMapping[$startCarbon->dayOfWeek];

        // Cari jadwal kelas yang aktif dan bentrok
        $conflictingSchedule = Schedule::where('room_id', $request->room_id)
            ->where('day_of_week', $dayOfWeek)
            ->where('status', 'active')
            ->where(function ($query) use ($request) {
                // Cek overlap waktu: jadwal kelas dimulai SEBELUM booking selesai
                // DAN jadwal kelas selesai SETELAH booking dimulai
                $query->where(function ($q) use ($request) {
                    $q->where('start_time', '<', substr($request->end_datetime, 11, 5))
                      ->where('end_time', '>', substr($request->start_datetime, 11, 5));
                });
            })
            ->with('classRoom')
            ->first();

        if ($conflictingSchedule) {
            $className = $conflictingSchedule->classRoom ? $conflictingSchedule->classRoom->name : 'Tidak ada kelas';
            $subject = $conflictingSchedule->subject ?? 'Tidak ada mata pelajaran';
            $scheduleTime = $conflictingSchedule->start_time . ' - ' . $conflictingSchedule->end_time;

            return back()->withInput()
                ->with('error', "Waktu yang dipilih bentrok dengan jadwal kelas!
                    <br><strong>Kelas:</strong> {$className}
                    <br><strong>Mata Pelajaran:</strong> {$subject}
                    <br><strong>Jam:</strong> {$scheduleTime}
                    <br><br>Silakan pilih waktu lain yang tidak berbenturan dengan jadwal kelas.");
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

    /**
     * AJAX: Cek konflik jadwal kelas secara real-time
     */
    public function checkScheduleConflict(Request $request)
    {
        $request->validate([
            'room_id'        => 'required|exists:rooms,id',
            'start_datetime' => 'required|date',
            'end_datetime'   => 'required|date|after:start_datetime',
        ]);

        $startCarbon = Carbon::parse($request->start_datetime);
        $endCarbon = Carbon::parse($request->end_datetime);

        // Mapping hari dalam Bahasa Indonesia
        $dayMapping = [
            1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu',
            4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu',
        ];
        $dayOfWeek = $dayMapping[$startCarbon->dayOfWeek];

        // Cari jadwal kelas yang aktif dan bentrok
        $conflictingSchedule = Schedule::where('room_id', $request->room_id)
            ->where('day_of_week', $dayOfWeek)
            ->where('status', 'active')
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('start_time', '<', substr($request->end_datetime, 11, 5))
                      ->where('end_time', '>', substr($request->start_datetime, 11, 5));
                });
            })
            ->with('classRoom')
            ->first();

        if ($conflictingSchedule) {
            $className = $conflictingSchedule->classRoom ? $conflictingSchedule->classRoom->name : 'Tidak ada kelas';
            $subject = $conflictingSchedule->subject ?? 'Tidak ada mata pelajaran';

            return response()->json([
                'has_conflict' => true,
                'schedule' => [
                    'class_name' => $className,
                    'subject' => $subject,
                    'start_time' => $conflictingSchedule->start_time,
                    'end_time' => $conflictingSchedule->end_time,
                    'day_of_week' => $dayOfWeek,
                ],
            ]);
        }

        return response()->json([
            'has_conflict' => false,
        ]);
    }
}