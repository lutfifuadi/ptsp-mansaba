<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected $pmbmKeys = [
        'pmbm_tanggal_pengumuman',
        'pmbm_judul_lulus',
        'pmbm_judul_tidak_lulus',
        'pmbm_teks_pembuka',
        'pmbm_label_lulus',
        'pmbm_label_tidak_lulus',
        'pmbm_redaksi_lulus',
        'pmbm_redaksi_tidak_lulus',
        'pmbm_teks_penutup',
    ];

    protected $kelulusanKeys = [
        'tanggal_pengumuman',
        'judul_lulus',
        'judul_tidak_lulus',
        'teks_pembuka',
        'label_lulus',
        'label_tidak_lulus',
        'redaksi_lulus',
        'redaksi_tidak_lulus',
        'teks_penutup',
        'versi_surat',
    ];

    public function up(): void
    {
        $keys = array_merge($this->pmbmKeys, $this->kelulusanKeys);
        DB::table('pengaturan')->whereIn('kunci', $keys)->delete();
    }

    public function down(): void
    {
    }
};
