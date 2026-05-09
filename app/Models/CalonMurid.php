<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonMurid extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'nisn',
        'no_pendaftaran',
        'jalur_pendaftaran',
        'asal_sekolah',
        'tempat_tanggal_lahir',
        'no_hp_calon',
        'no_hp_ortu',
        'nama_ortu',
        'nik',
        'status_kelulusan',
        'keterangan',
    ];
}
