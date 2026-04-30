<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $fillable = ['kunci', 'nilai'];

    public static function get(string $kunci, mixed $default = null): mixed
    {
        $row = static::where('kunci', $kunci)->first();
        return $row ? $row->nilai : $default;
    }

    public static function set(string $kunci, mixed $nilai): void
    {
        static::updateOrCreate(['kunci' => $kunci], ['nilai' => $nilai]);
    }
}
