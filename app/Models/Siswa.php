<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nisn',
        'nis',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'kelas',
        'jurusan',
    ];

    public function permohonan()
    {
        return $this->hasMany(\App\Models\Permohonan::class, 'nisn', 'nisn');
    }
}
