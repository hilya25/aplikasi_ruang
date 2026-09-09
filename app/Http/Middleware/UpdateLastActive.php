<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastActive
{
    /**
     * Handle an incoming request.
     *
     * Update last_active_at untuk user yang sedang login,
     * dipakai untuk menampilkan status online di halaman admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Update hanya jika aktivitas terakhir > 1 menit lalu (hemat query)
            $lastActive = $user->last_active_at ? \Carbon\Carbon::parse($user->last_active_at) : null;
            if (!$lastActive || $lastActive->diffInMinutes(now()) >= 1) {
                $user->forceFill(['last_active_at' => now()])->saveQuietly();
            }

            // Jika user tidak aktif melebihi umur session (tutup browser tanpa logout),
            // anggap offline secara otomatis
            if ($user->is_logged_in && $lastActive &&
                $lastActive->diffInMinutes(now()) > config('session.lifetime')) {
                $user->forceFill(['is_logged_in' => false])->saveQuietly();
            }
        }

        return $next($request);
    }
}
