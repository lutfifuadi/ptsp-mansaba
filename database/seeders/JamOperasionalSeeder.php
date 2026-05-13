<?php

namespace Database\Seeders;

use App\Models\JamOperasional;
use Illuminate\Database\Seeder;

class JamOperasionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = [
            ['hari' => 0, 'nama_hari' => 'Minggu', 'jam_buka' => null, 'jam_tutup' => null, 'is_aktif' => false],
            ['hari' => 1, 'nama_hari' => 'Senin', 'jam_buka' => '07:30', 'jam_tutup' => '16:00', 'is_aktif' => true],
            ['hari' => 2, 'nama_hari' => 'Selasa', 'jam_buka' => '07:30', 'jam_tutup' => '16:00', 'is_aktif' => true],
            ['hari' => 3, 'nama_hari' => 'Rabu', 'jam_buka' => '07:30', 'jam_tutup' => '16:00', 'is_aktif' => true],
            ['hari' => 4, 'nama_hari' => 'Kamis', 'jam_buka' => '07:30', 'jam_tutup' => '16:00', 'is_aktif' => true],
            ['hari' => 5, 'nama_hari' => 'Jumat', 'jam_buka' => '07:30', 'jam_tutup' => '16:30', 'is_aktif' => true],
            ['hari' => 6, 'nama_hari' => 'Sabtu', 'jam_buka' => null, 'jam_tutup' => null, 'is_aktif' => false],
        ];

        foreach ($days as $day) {
            JamOperasional::updateOrCreate(['hari' => $day['hari']], $day);
        }
    }
}
