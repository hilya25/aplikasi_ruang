<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'type',
        'capacity',
        'location',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi: Ruangan punya banyak jadwal
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Relasi: Ruangan punya banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
