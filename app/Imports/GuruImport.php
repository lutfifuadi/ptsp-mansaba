<?php

namespace App\Imports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithUpserts;

class GuruImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, WithBatchInserts, WithChunkReading, WithUpserts
{
    use SkipsErrors;

    public function model(array $row): ?Guru
    {
        $namaLengkap = trim($row['nama_lengkap'] ?? '');
        if (empty($namaLengkap)) {
            return null;
        }

        return new Guru([
            'nama_lengkap' => $namaLengkap,
            'nip'          => trim($row['nip'] ?? ''),
            'nuptk'        => trim($row['nuptk'] ?? ''),
            'bidang_studi' => trim($row['bidang_studi'] ?? ''),
            'no_whatsapp'  => trim($row['no_whatsapp'] ?? ''),
            'alamat'       => trim($row['alamat'] ?? ''),
            'is_active'    => $this->normalizeActive(trim($row['is_active'] ?? '')),
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nip'          => ['nullable', 'string', 'max:50'],
            'nuptk'        => ['nullable', 'string', 'max:50'],
            'bidang_studi' => ['required', 'string', 'max:255'],
            'no_whatsapp'  => ['nullable', 'string', 'max:20'],
            'alamat'       => ['nullable', 'string'],
        ];
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
        return 'nip';
    }

    private function normalizeActive(string $value): bool
    {
        $value = strtolower(trim($value));

        if (in_array($value, ['ya', 'yes', 'aktif', 'active', '1', 'true'], true)) {
            return true;
        }

        return false;
    }
}
