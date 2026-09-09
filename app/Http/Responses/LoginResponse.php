<?php

namespace App\Http\Responses;

use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request): RedirectResponse
    {
        $user = $request->user();

        // Catat waktu login terakhir
        $user->forceFill(['last_login_at' => now()])->saveQuietly();

        // Arahkan sesuai tipe user (sama seperti HomeController)
        if ($user->usertype === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }
}
