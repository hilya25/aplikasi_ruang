<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Tampilkan daftar semua ruangan (dikelompokkan berdasarkan jenis)
     */
    public function index()
    {
        $rooms = Room::latest()->get();

        // Kelompokkan ruangan berdasarkan jenis
        $groupedRooms = $rooms->groupBy('type');

        // Urutan jenis ruangan yang diinginkan
        $typeOrder = ['Kelas', 'Lab', 'Aula', 'Lapangan', 'Masjid', 'Activity Room'];

        return view('admin.rooms.index', compact('rooms', 'groupedRooms', 'typeOrder'));
    }

    /**
     * Simpan ruangan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:50',
            'type'        => 'required|string|max:30',
            'capacity'    => 'nullable|integer|min:0',
            'location'    => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        Room::create($request->only('name', 'type', 'capacity', 'location', 'description'));

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Ruangan berhasil ditambahkan!');
    }

    /**
     * Update ruangan yang sudah ada
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name'        => 'required|string|max:50',
            'type'        => 'required|string|max:30',
            'capacity'    => 'nullable|integer|min:0',
            'location'    => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $room->update($request->only('name', 'type', 'capacity', 'location', 'description'));

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Ruangan berhasil diperbarui!');
    }

    /**
     * Hapus ruangan
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Ruangan berhasil dihapus!');
    }
}
