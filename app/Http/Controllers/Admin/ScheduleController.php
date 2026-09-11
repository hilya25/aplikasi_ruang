<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Room;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    /**
     * Tampilkan daftar semua jadwal (dikelompokkan per jenis ruangan)
     */
    public function index()
    {
        $rooms = Room::where('is_active', true)
            ->with(['schedules' => function ($q) {
                $q->with('classRoom')
                  ->orderByRaw("FIELD(day_of_week, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
                  ->orderBy('start_time');
            }])
            ->orderBy('name')
            ->get();

        $classes = ClassRoom::orderBy('name')->get();

        // Kelompokkan ruangan berdasarkan jenis
        $groupedRooms = $rooms->groupBy('type');

        // Urutan jenis ruangan
        $typeOrder = ['Kelas', 'Lab', 'Aula', 'Lapangan', 'Masjid', 'Activity Room'];

        return view('admin.schedules.index', compact('rooms', 'classes', 'groupedRooms', 'typeOrder'));
    }

    /**
     * Form input jadwal bulk (banyak jadwal sekaligus)
     */
    public function createBulk()
    {
        $rooms = Room::where('is_active', true)->orderBy('name')->get();
        $classes = ClassRoom::orderBy('name')->get();

        return view('admin.schedules.bulk', compact('rooms', 'classes'));
    }

    /**
     * Simpan jadwal baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id'     => 'required|exists:rooms,id',
            'class_id'    => 'nullable|exists:classes,id',
            'subject'     => 'nullable|string|max:100',
            'day_of_week' => 'required|string|max:10',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
        ]);

        Schedule::create($request->only('room_id', 'class_id', 'subject', 'day_of_week', 'start_time', 'end_time'));

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Update jadwal yang sudah ada
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'room_id'     => 'required|exists:rooms,id',
            'class_id'    => 'nullable|exists:classes,id',
            'subject'     => 'nullable|string|max:100',
            'day_of_week' => 'required|string|max:10',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
        ]);

        $schedule->update($request->only('room_id', 'class_id', 'subject', 'day_of_week', 'start_time', 'end_time'));

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diperbarui!');
    }

    /**
     * Toggle status jadwal (active/inactive)
     */
    public function toggleStatus(Schedule $schedule)
    {
        $newStatus = $schedule->status === 'active' ? 'inactive' : 'active';
        $schedule->update(['status' => $newStatus]);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Status jadwal berhasil diubah ke ' . ucfirst($newStatus) . '!');
    }

    /**
     * Hapus jadwal
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }

    /**
     * Simpan banyak jadwal sekaligus (bulk) untuk satu ruangan
     */
    public function storeBulk(Request $request)
    {
        $request->validate([
            'room_id'   => 'required|exists:rooms,id',
            'class_id'  => 'nullable',
            'days'      => 'required|array|min:1',
            'days.*'    => 'string',
            'subjects'  => 'required|array',
            'start_times' => 'required|array',
            'end_times'   => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            $roomId  = $request->room_id;
            $classId = $request->class_id ?: null;
            $days    = $request->days;

            foreach ($days as $day) {
                $subjects = $request->subjects[$day] ?? [];
                $starts   = $request->start_times[$day] ?? [];
                $ends     = $request->end_times[$day] ?? [];

                $count = max(count($subjects), count($starts), count($ends));

                for ($i = 0; $i < $count; $i++) {
                    $start = $starts[$i] ?? null;
                    $end   = $ends[$i] ?? null;

                    if ($start && $end) {
                        Schedule::create([
                            'room_id'     => $roomId,
                            'class_id'    => $classId,
                            'subject'     => $subjects[$i] ?? null,
                            'day_of_week' => $day,
                            'start_time'  => $start,
                            'end_time'    => $end,
                            'status'      => 'active',
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan untuk semua hari yang dipilih!');
    }
}
