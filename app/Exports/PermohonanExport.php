<?php

namespace App\Exports;

use App\Models\Permohonan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PermohonanExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Permohonan::with(['user', 'layanan', 'siswa'])->latest();

        if ($this->request->filled('layanan_id')) {
            $query->where('layanan_id', $this->request->layanan_id);
        }

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        if ($this->request->filled('sumber')) {
            if ($this->request->sumber === 'publik') {
                $query->whereNull('user_id');
            } elseif ($this->request->sumber === 'login') {
                $query->whereNotNull('user_id');
            }
        }

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_tiket', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'No. Tiket',
            'Tanggal Pengajuan',
            'Layanan',
            'NISN',
            'Nama Pemohon/Siswa',
            'Status',
            'Detail Data (Form)',
            'Catatan Admin',
        ];
    }

    public function map($permohonan): array
    {
        static $no = 0;
        $no++;

        $namaSiswa = $permohonan->siswa ? $permohonan->siswa->nama_lengkap : ($permohonan->user ? $permohonan->user->name : '-');
        
        $detailData = '';
        if (is_array($permohonan->data_form)) {
            foreach ($permohonan->data_form as $key => $value) {
                $label = ucwords(str_replace('_', ' ', $key));
                $formatted = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value;
                $detailData .= "{$label}: {$formatted}\n";
            }
        }

        return [
            $no,
            $permohonan->no_tiket,
            $permohonan->created_at->format('d/m/Y H:i'),
            $permohonan->layanan->nama_layanan ?? '-',
            $permohonan->nisn ?: '-',
            $namaSiswa,
            strtoupper($permohonan->status),
            trim($detailData),
            $permohonan->catatan_admin ?: '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
