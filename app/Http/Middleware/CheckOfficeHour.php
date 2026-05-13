<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Symfony\Component\HttpFoundation\Response;

class CheckOfficeHour
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Helpers::isOfficeHour()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Layanan saat ini sedang tutup (di luar jam operasional).'
                ], 403);
            }

            $config = Helpers::currentOfficeHour();
            return response()->view('ptsp.surat.tutup', compact('config'), 403);
        }

        return $next($request);
    }
}
