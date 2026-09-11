<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    /**
     * Tampilkan daftar semua kelas (dikelompokkan berdasarkan angkatan)
     */
    public function index()
    {
        $classes = ClassRoom::orderBy('name')->get();

        // Kelompokkan kelas berdasarkan angkatan (X, XI, XII)
        $groupedClasses = $classes->groupBy(function ($class) {
            $name = strtolower(trim($class->name));

            // Cek dengan regex untuk berbagai format
            // Format: x-a rpl, xi-a rpl, xii-a rpl, 10-a rpl, dll
            if (preg_match('/^(xii|12)/', $name)) {
                return 'XII';
            } elseif (preg_match('/^(xi|11)/', $name)) {
                return 'XI';
            } elseif (preg_match('/^(x|10)/', $name)) {
                return 'X';
            }

            return 'Lainnya';
        });

        // Sort dalam setiap group agar lebih rapi
        foreach ($groupedClasses as $grade => $gradeClasses) {
            $groupedClasses[$grade] = $gradeClasses->sortBy('name');
        }

        // Urutan angkatan
        $gradeOrder = ['X', 'XI', 'XII', 'Lainnya'];

        return view('admin.classes.index', compact('classes', 'groupedClasses', 'gradeOrder'));
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