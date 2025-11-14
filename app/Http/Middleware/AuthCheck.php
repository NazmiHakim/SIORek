<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // login apakah sesuai dengan rolenya
        if (!Auth::check() || Auth::user()->role !== $role) {
            // jika tidak maka tolak akses
            abort(403, 'AKSES DITOLAK: ANDA TIDAK MEMILIKI HAK AKSES.');
        }

        // jika lolos, lanjut halaman sesuai rolenya
        return $next($request);
    }
}