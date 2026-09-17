<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'class_id',
        'subject',
        'teacher',
        'day_of_week',
        'start_time',
        'end_time',
        'status',
    ];

    // Relasi: Jadwal milik satu ruangan
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Relasi: Jadwal milik satu kelas
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
}
