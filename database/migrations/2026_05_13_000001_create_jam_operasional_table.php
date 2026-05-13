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
        Schema::create('jam_operasional', function (Blueprint $table) {
            $table->id();
            $table->integer('hari')->unique()->comment('0=Minggu, 1=Senin, ..., 6=Sabtu');
            $table->string('nama_hari');
            $table->time('jam_buka')->nullable();
            $table->time('jam_tutup')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jam_operasional');
    }
};
