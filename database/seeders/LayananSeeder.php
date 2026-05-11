<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layanan = [
            [
                'nama_layanan' => 'Buku Tamu Online',
                'deskripsi' => 'Silakan isi buku tamu kunjungan Anda ke madrasah secara online.',
                'persyaratan' => 'Tidak ada persyaratan khusus.',
                'kategori' => 'umum',
                'external_url' => 'https://form.man1kotabandung.sch.id/',
                'is_active' => true,
            ],
            [
                'nama_layanan' => 'Pengambilan Ijazah',
                'deskripsi' => 'Layanan penjadwalan dan informasi pengambilan ijazah asli.',
                'persyaratan' => '1. Membawa fotokopi Akta Kelahiran\n2. Membawa Kartu Pelajar/Identitas Diri',
                'kategori' => 'umum',
                'is_active' => true,
            ],
            [
                'nama_layanan' => 'Pembuatan Surat-Surat',
                'deskripsi' => 'Pengajuan surat keterangan siswa, surat mutasi, dan surat lainnya.',
                'persyaratan' => '1. Kartu Pelajar Aktif\n2. Surat Pengantar Orang Tua (untuk Mutasi)',
                'kategori' => 'siswa',
                'is_active' => true,
            ],
            [
                'nama_layanan' => 'Legalisir',
                'deskripsi' => 'Layanan pengesahan fotokopi raport, SKKB dan dokumen akademik untuk siswa aktif.',
                'persyaratan' => '1. Dokumen Asli\n2. Fotokopi Dokumen (Maks. 5 Lembar)',
                'kategori' => 'siswa',
                'is_active' => true,
            ],
            [
                'nama_layanan' => 'Legalisir Ijazah',
                'deskripsi' => 'Layanan legalisir ijazah bagi alumni MAN 1 Kota Bandung.',
                'persyaratan' => '1. Fotokopi Ijazah\n2. Dokumen Asli Ijazah',
                'kategori' => 'umum',
                'is_active' => true,
            ],
        ];

        foreach ($layanan as $l) {
            \App\Models\Layanan::updateOrCreate(
                ['nama_layanan' => $l['nama_layanan']],
                $l
            );
        }
    }
}
