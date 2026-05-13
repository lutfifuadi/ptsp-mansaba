<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petugas_layanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petugas_id')->constrained('petugas')->onDelete('cascade');
            $table->foreignId('layanan_id')->constrained('layanan')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['petugas_id', 'layanan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petugas_layanan');
    }
};
