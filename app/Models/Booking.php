<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'user_id',
        'event_type',
        'description',
        'start_datetime',
        'end_datetime',
        'status',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];

    // Relasi: Booking milik satu ruangan
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Relasi: Booking milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
