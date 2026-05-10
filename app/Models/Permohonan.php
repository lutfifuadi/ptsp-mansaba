<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    /** @use HasFactory<\Database\Factories\PermohonanFactory> */
    use HasFactory;

    protected $table = 'permohonan';

    protected $fillable = [
        'user_id',
        'nisn',
        'layanan_id',
        'no_tiket',
        'status',
        'data_form',
        'catatan_admin',
    ];

    /**
     * user_id nullable untuk permohonan dari public (tanpa login)
     */
    protected $casts = [
        'data_form' => 'array',
        'user_id'   => 'integer',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nisn', 'nisn');
    }
}
