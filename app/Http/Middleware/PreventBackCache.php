<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventBackCache
{
    /**
     * Handle an incoming request.
     *
     * Mencegah browser menampilkan halaman setelah logout
     * dengan menambahkan header no-cache.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set(
            'Cache-Control',
            'no-cache, no-store, must-revalidate, max-age=0'
        );

        return $response;
    }
}
