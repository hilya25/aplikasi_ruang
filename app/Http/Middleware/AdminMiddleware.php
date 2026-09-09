<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Check if authenticated user is an admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->usertype !== 'admin') {
            abort(403, 'Unauthorized. Admin access only.');
        }

        return $next($request);
    }
}
