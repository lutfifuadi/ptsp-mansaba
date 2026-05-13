<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PwaController extends Controller
{
    public function manifest()
    {
        $manifest = [
            'name'             => Pengaturan::get('pwa_name', 'Aplikasi PTSP'),
            'short_name'       => Pengaturan::get('pwa_short_name', 'PTSP'),
            'description'      => Pengaturan::get('pwa_description', 'Sistem Informasi Pelayanan Terpadu Satu Pintu MAN 1 Kota Bandung'),
            'start_url'        => '/',
            'display'          => 'standalone',
            'background_color' => Pengaturan::get('pwa_background_color', '#ffffff'),
            'theme_color'      => Pengaturan::get('pwa_theme_color', '#7367f0'),
            'icons'            => [
                [
                    'src'   => asset('assets/img/pwa/icon-192x192.png'),
                    'sizes' => '192x192',
                    'type'  => 'image/png',
                ],
                [
                    'src'   => asset('assets/img/pwa/icon-512x512.png'),
                    'sizes' => '512x512',
                    'type'  => 'image/png',
                ],
            ],
        ];

        return response()->json($manifest);
    }

    public function serviceWorker()
    {
        $swContent = "
        const CACHE_NAME = 'ptsp-v1';
        const urlsToCache = [
          '/',
          '/assets/css/style.css',
          '/assets/js/main.js'
        ];

        self.addEventListener('install', event => {
          event.waitUntil(
            caches.open(CACHE_NAME)
              .then(cache => cache.addAll(urlsToCache))
          );
        });

        self.addEventListener('fetch', event => {
          event.respondWith(
            caches.match(event.request)
              .then(response => {
                if (response) {
                  return response;
                }
                return fetch(event.request);
              })
          );
        });
        ";

        return response($swContent)
            ->header('Content-Type', 'application/javascript');
    }
}
