<?php

namespace App\Exports;

use App\Models\GuestBook;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GuestBookExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $format;

    public function __construct($format = 'xlsx')
    {
        $this->format = $format;
    }

    public function collection()
    {
        return GuestBook::orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'No. WhatsApp',
            'Alamat',
            'Jenis Instansi',
            'Nama Instansi',
            'Tujuan',
            'Keperluan',
            'Waktu Kunjungan',
        ];
    }

    public function map($guestBook): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $guestBook->nama_lengkap,
            $guestBook->no_whatsapp,
            $guestBook->alamat,
            $guestBook->jenis_instansi,
            $guestBook->nama_instansi ?: '-',
            $guestBook->tujuan,
            $guestBook->keperluan,
            $guestBook->created_at->format('d/m/Y H:i') . ' WIB',
        ];
    }
}
