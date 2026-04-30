<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nisn',
        'nis',
        'nama_lengkap',
        'kelas',
        'jurusan',
        'status_kelulusan',
    ];

    public function isLulus(): bool
    {
        return $this->status_kelulusan === 'lulus';
    }
}
