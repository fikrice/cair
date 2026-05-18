<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LockoutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && in_array($user->role, ['finance', 'warehouse'])) {
            // Izinkan dashboard, profile, dan logout saja
            if (!$request->routeIs('dashboard', 'profile.edit', 'profile.update', 'profile.destroy', 'logout') && 
                !in_array($request->path(), ['dashboard', 'profile', 'logout'])) {
                abort(403, 'Akses ke modul ini ditangguhkan sementara. Silakan selesaikan pembayaran tagihan (Term 80%) untuk membuka kembali fitur ini.');
            }
        }

        return $next($request);
    }
}
