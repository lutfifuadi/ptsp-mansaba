<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        // Tanggal pengumuman: 4 Mei 2026 00:00:00 WIB (UTC+7 = 2026-05-03 17:00:00 UTC)
        Pengaturan::set('tanggal_pengumuman', '2026-05-04 00:00:00');
        Pengaturan::set('nama_kepala_sekolah', 'Nama Kepala Sekolah');
        Pengaturan::set('nip_kepala_sekolah', 'NIP. 000000000000000000');
        Pengaturan::set('ttd_kepala_sekolah', null);
        Pengaturan::set('stempel_sekolah', null);
        Pengaturan::set('tahun_ajaran', '2025/2026');
        Pengaturan::set('nomor_surat', '');
        Pengaturan::set('versi_surat', 'lengkap');
    }
}
