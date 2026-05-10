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
            $table->dropColumn(['no_peserta_ujian', 'tipe_kelulusan']);
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa', 'no_peserta_ujian')) {
                $table->string('no_peserta_ujian', 50)->nullable()->after('nis');
            }
            if (!Schema::hasColumn('siswa', 'tipe_kelulusan')) {
                $table->string('tipe_kelulusan')->default('XII')->after('status_kelulusan');
            }
        });
    }
};
