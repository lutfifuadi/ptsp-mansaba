<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

trait HandlesPdfImages
{
    /**
     * Menentukan path gambar (lokal atau remote S3)
     */
    protected function resolveImagePath($path)
    {
        if (!$path) return null;

        // Jika diawali http, berarti remote URL (S3/Cloud)
        if (str_starts_with($path, 'http')) {
            return $path;
        }

        // Jika tidak, asumsikan di storage lokal
        if (Storage::disk('public')->exists($path)) {
            return storage_path('app/public/' . $path);
        }

        return null;
    }

    /**
     * Konversi gambar ke Base64 agar stabil di PDF
     */
    protected function encodeImageToBase64($path)
    {
        if (!$path) return null;

        try {
            if (str_starts_with($path, 'http')) {
                // Ambil gambar dari URL remote
                $response = Http::get($path);
                if ($response->successful()) {
                    $imageData = $response->body();
                    $type = $response->header('Content-Type') ?: 'image/png';
                    return 'data:' . $type . ';base64,' . base64_encode($imageData);
                }
            } else {
                // Baca file lokal
                if (file_exists($path)) {
                    $imageData = file_get_contents($path);
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    return 'data:image/' . $type . ';base64,' . base64_encode($imageData);
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Base64 Encoding Error: " . $e->getMessage());
        }

        return null;
    }
}
