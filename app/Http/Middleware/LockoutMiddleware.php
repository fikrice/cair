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
        if ($request->user() && in_array($request->user()->role, ['finance', 'warehouse'])) {
            abort(403, 'Akses ke modul ini ditangguhkan sementara. Silakan selesaikan pembayaran tagihan (Term 80%) untuk membuka kembali fitur ini.');
        }

        return $next($request);
    }
}
