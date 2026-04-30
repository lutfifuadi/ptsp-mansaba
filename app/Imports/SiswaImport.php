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
                'kelas'            => trim($row['kelas'] ?? ''),
                'jurusan'          => trim($row['jurusan'] ?? ''),
                'status_kelulusan' => $status,
            ]
        );
    }
}
