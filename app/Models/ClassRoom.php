<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = ['name'];

    // Relasi: Kelas punya banyak jadwal
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
