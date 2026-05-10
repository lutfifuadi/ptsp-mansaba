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
        Schema::table('layanan', function (Blueprint $table) {
            $table->enum('kategori', ['umum', 'siswa'])->default('siswa')->after('persyaratan');
            $table->string('external_url')->nullable()->after('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layanan', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'external_url']);
        });
    }
};
