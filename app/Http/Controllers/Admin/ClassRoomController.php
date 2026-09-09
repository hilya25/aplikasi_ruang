<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    /**
     * Tampilkan daftar semua kelas
     */
    public function index()
    {
        $classes = ClassRoom::orderBy('name')->get();
        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Simpan kelas baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20|unique:classes,name',
        ]);

        ClassRoom::create($request->only('name'));

        return redirect()->route('admin.classes.index')
            ->with('success', 'Kelas berhasil ditambahkan!');
    }

    /**
     * Update kelas
     */
    public function update(Request $request, ClassRoom $classRoom)
    {
        $request->validate([
            'name' => 'required|string|max:20|unique:classes,name,' . $classRoom->id,
        ]);

        $classRoom->update($request->only('name'));

        return redirect()->route('admin.classes.index')
            ->with('success', 'Kelas berhasil diperbarui!');
    }

    /**
     * Hapus kelas
     */
    public function destroy(ClassRoom $classRoom)
    {
        $classRoom->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Kelas berhasil dihapus!');
    }
}