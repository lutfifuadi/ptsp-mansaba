<?php

namespace App\Imports;

use App\Models\CalonMurid;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithUpserts;

class CalonMuridImport implements ToModel, WithHeadingRow, SkipsOnError, WithBatchInserts, WithChunkReading, WithUpserts
{
    use SkipsErrors;

    public function model(array $row): ?CalonMurid
    {
        $noPendaftaran = trim($row['no_pendaftaran'] ?? '');
        if (empty($noPendaftaran)) {
            return null;
        }

        $status = trim($row['status_kelulusan'] ?? 'Proses');
        // Normalize status to match enum/validation in controller
        if (stripos($status, 'lulus') !== false && stripos($status, 'tidak') === false) {
            $status = 'Lulus';
        } elseif (stripos($status, 'tidak') !== false) {
            $status = 'Tidak Lulus';
        } else {
            $status = 'Proses';
        }

        return new CalonMurid([
            'nama_lengkap'         => trim($row['nama_lengkap'] ?? ''),
            'nisn'                 => trim($row['nisn'] ?? null),
            'no_pendaftaran'       => $noPendaftaran,
            'jalur_pendaftaran'    => trim($row['jalur_pendaftaran'] ?? ''),
            'asal_sekolah'         => trim($row['asal_sekolah'] ?? ''),
            'tempat_tanggal_lahir' => trim($row['tempat_tanggal_lahir'] ?? ''),
            'no_hp_calon'          => trim($row['no_hp_calon'] ?? null),
            'no_hp_ortu'           => trim($row['no_hp_ortu'] ?? ''),
            'nama_ortu'            => trim($row['nama_ortu'] ?? ''),
            'nik'                  => trim($row['nik'] ?? ''),
            'status_kelulusan'     => $status,
            'keterangan'           => trim($row['keterangan'] ?? null),
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
        return 'no_pendaftaran';
    }
}
