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
        'no_peserta',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'nama_orang_tua',
        'no_peserta_ujian',
        'kelas',
        'jurusan',
        'madrasah_asal',
        'status_kelulusan',
        'validation_token',
    ];

    public function isLulus(): bool
    {
        return $this->status_kelulusan === 'lulus';
    }

    /**
     * Generate dan simpan validation_token unik jika belum ada.
     * Hanya untuk siswa yang berstatus lulus.
     */
    public function generateValidationToken(): void
    {
        if ($this->status_kelulusan === 'lulus' && empty($this->validation_token)) {
            $this->validation_token = Str::random(64);
            $this->save();
        }
    }
}
