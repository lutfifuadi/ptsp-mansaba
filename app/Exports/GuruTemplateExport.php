<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GuruTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'nama_lengkap',
            'nip',
            'nuptk',
            'bidang_studi',
            'no_whatsapp',
            'alamat',
            'is_active',
        ];
    }

    public function array(): array
    {
        return [
            ['Ahmad Fauzi', '198501012010011001', '1234567890123456', 'Matematika', '081234567890', 'Jl. Merdeka No. 1 Bandung', 'ya'],
            ['Siti Nurhaliza', '198702022011022002', '2345678901234567', 'Bahasa Indonesia', '081234567891', 'Jl. Diponegoro No. 5 Bandung', 'ya'],
            ['Rizki Pratama', '199003032012033003', '3456789012345678', 'Fisika', '', 'Jl. Ahmad Yani No. 10 Bandung', 'tidak'],
        ];
    }
}
