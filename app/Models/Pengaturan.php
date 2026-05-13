<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $fillable = ['kunci', 'nilai'];
    protected static $sensitiveKeys = ['gemini_api_keys', 'wa_api_key'];

    public static function get(string $kunci, mixed $default = null): mixed
    {
        $row = static::where('kunci', $kunci)->first();
        if (!$row) return $default;

        if (in_array($kunci, self::$sensitiveKeys) && !empty($row->nilai)) {
            try {
                return \Illuminate\Support\Facades\Crypt::decryptString($row->nilai);
            } catch (\Exception $e) {
                return $row->nilai; // Fallback jika belum terenkripsi
            }
        }

        return $row->nilai;
    }

    public static function set(string $kunci, mixed $nilai): void
    {
        if (in_array($kunci, self::$sensitiveKeys) && !empty($nilai)) {
            $nilai = \Illuminate\Support\Facades\Crypt::encryptString($nilai);
        }
        static::updateOrCreate(['kunci' => $kunci], ['nilai' => $nilai]);
    }
}
