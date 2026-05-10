<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    /** @use HasFactory<\Database\Factories\LayananFactory> */
    use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'persyaratan',
        'kategori',
        'external_url',
        'is_active',
    ];

    public function permohonan()
    {
        return $this->hasMany(Permohonan::class);
    }
}
