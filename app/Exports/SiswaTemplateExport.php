<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SiswaTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'nisn',
            'nis',
            'no_peserta',
            'nama_lengkap',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'kelas',
            'jurusan',
        ];
    }

    public function array(): array
    {
        return [
            ['1234567890', '12345', 'P-001', 'Ahmad Fauzi', 'Bandung', '10 Mei 2005', 'laki-laki', 'XII', 'IPA'],
            ['2345678901', '23456', 'P-002', 'Siti Nurhaliza', 'Jakarta', '15 Agustus 2006', 'perempuan', 'XI', 'IPS'],
            ['3456789012', '34567', 'P-003', 'Rizki Pratama', 'Garut', '20 Januari 2005', 'laki-laki', 'XII', 'IPA'],
        ];
    }
}
