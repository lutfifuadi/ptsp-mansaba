<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class SiswaImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    public function model(array $row): ?Siswa
    {
        $nisn = trim($row['nisn'] ?? '');
        if (empty($nisn)) {
            return null;
        }

        $status = strtolower(trim($row['status_kelulusan'] ?? 'pending'));
        if (!in_array($status, ['lulus', 'tidak_lulus', 'pending'])) {
            $status = 'pending';
        }

        return Siswa::updateOrCreate(
            ['nisn' => $nisn],
            [
                'nis'              => trim($row['nis'] ?? ''),
                'nama_lengkap'     => trim($row['nama_lengkap'] ?? ''),
                'tempat_lahir'     => trim($row['tempat_lahir'] ?? ''),
                'tanggal_lahir'    => !empty($row['tanggal_lahir']) ? \Carbon\Carbon::parse($row['tanggal_lahir'])->format('Y-m-d') : null,
                'nama_orang_tua'   => trim($row['nama_orang_tua'] ?? ''),
                'no_peserta_ujian' => trim($row['no_peserta_ujian'] ?? ''),
                'kelas'            => trim($row['kelas'] ?? ''),
                'jurusan'          => trim($row['jurusan'] ?? ''),
                'madrasah_asal'    => trim($row['madrasah_asal'] ?? ''),
                'status_kelulusan' => $status,
            ]
        );
    }
}
