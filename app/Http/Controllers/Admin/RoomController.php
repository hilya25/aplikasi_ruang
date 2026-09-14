<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'image'       => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'type'        => 'required|string|max:30',
            'capacity'    => 'nullable|integer|min:0',
            'location'    => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $data = $request->only('name', 'type', 'capacity', 'location', 'description');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        Room::create($data);

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
            'image'       => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'type'        => 'required|string|max:30',
            'capacity'    => 'nullable|integer|min:0',
            'location'    => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $data = $request->only('name', 'type', 'capacity', 'location', 'description');

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        $room->update($data);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Ruangan berhasil diperbarui!');
    }

    /**
     * Hapus ruangan
     */
    public function destroy(Room $room)
    {
        // Hapus gambar dari storage jika ada
        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Ruangan berhasil dihapus!');
    }
}
