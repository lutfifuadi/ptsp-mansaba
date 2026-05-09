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
        Schema::create('calon_murids', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nisn')->unique()->nullable();
            $table->string('no_pendaftaran')->unique();
            $table->string('jalur_pendaftaran');
            $table->string('asal_sekolah');
            $table->string('tempat_tanggal_lahir');
            $table->string('no_hp_calon')->nullable();
            $table->string('no_hp_ortu');
            $table->string('nama_ortu');
            $table->string('nik')->unique();
            $table->string('status_kelulusan')->default('Proses'); // Default status
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_murids');
    }
};
