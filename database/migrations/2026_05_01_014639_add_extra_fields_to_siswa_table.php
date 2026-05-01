<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable()->after('nama_lengkap');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('nama_orang_tua')->nullable()->after('tanggal_lahir');
            $table->string('no_peserta_ujian')->nullable()->after('nis');
            $table->string('madrasah_asal')->nullable()->after('jurusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn(['tempat_lahir', 'tanggal_lahir', 'nama_orang_tua', 'no_peserta_ujian', 'madrasah_asal']);
        });
    }
};
