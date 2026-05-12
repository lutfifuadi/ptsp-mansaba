<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithUpserts;

class SiswaImport implements ToModel, WithHeadingRow, SkipsOnError, WithBatchInserts, WithChunkReading, WithUpserts
{
    use SkipsErrors;

    public function model(array $row): ?Siswa
    {
        $nisn = trim($row['nisn'] ?? '');
        if (empty($nisn)) {
            return null;
        }

        return new Siswa([
            'nisn'             => $nisn,
            'nis'              => trim($row['nis'] ?? ''),
            'nama_lengkap'     => trim($row['nama_lengkap'] ?? ''),
            'tempat_lahir'     => trim($row['tempat_lahir'] ?? ''),
            'tanggal_lahir'    => $this->parseIndonesianDate($row['tanggal_lahir'] ?? null),
            'jenis_kelamin'    => $this->normalizeGender(trim($row['jenis_kelamin'] ?? '')),
            'kelas'            => trim($row['kelas'] ?? ''),
            'jurusan'          => trim($row['jurusan'] ?? ''),
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function uniqueBy()
    {
        return 'nisn';
    }

    private function parseIndonesianDate($date): ?string
    {
        if (empty($date)) {
            return null;
        }

        // If it's already a numeric date from Excel
        if (is_numeric($date)) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
            } catch (\Exception $e) {
                // Fallback to string parsing
            }
        }

        $date = trim($date);
        
        $months = [
            'Januari'   => 'January',
            'Februari'  => 'February',
            'Maret'     => 'March',
            'April'     => 'April',
            'Mei'       => 'May',
            'Juni'      => 'June',
            'Juli'      => 'July',
            'Agustus'   => 'August',
            'September' => 'September',
            'Oktober'   => 'October',
            'November'  => 'November',
            'Desember'  => 'December',
            'Nopember'  => 'November', // Common misspelling
        ];

        foreach ($months as $indo => $eng) {
            if (stripos($date, $indo) !== false) {
                $date = str_ireplace($indo, $eng, $date);
                break;
            }
        }

        try {
            return \Carbon\Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to parse date: {$date}. Error: " . $e->getMessage());
            return null;
        }
    }

    private function normalizeGender(string $value): ?string
    {
        $value = strtolower(trim($value));

        if (in_array($value, ['laki-laki', 'laki laki', 'laki', 'pria', 'male'], true)) {
            return 'laki-laki';
        }

        if (in_array($value, ['perempuan', 'wanita', 'female', 'p'], true)) {
            return 'perempuan';
        }

        return null;
    }
}
