<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InviteCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'is_used',
        'used_by_user_id',
    ];

    protected $casts = [
        'is_used' => 'boolean',
    ];

    public function usedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'used_by_user_id');
    }
}
