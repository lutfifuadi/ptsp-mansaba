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
            $config = Helpers::currentOfficeHour();
            
            // Share status and config with all views
            view()->share('is_office_closed', true);
            view()->share('office_config', $config);

            // If it's not a GET request (e.g., POST submission), we MUST block it
            if (!$request->isMethod('GET')) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Layanan saat ini sedang tutup (di luar jam operasional).'
                    ], 403);
                }

                return response()->view('ptsp.surat.tutup', compact('config'), 403);
            }
        }

        return $next($request);
    }
}
