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
        Schema::create('guest_books', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('no_whatsapp');
            $table->text('alamat');
            $table->enum('jenis_instansi', ['Instansi', 'Lembaga', 'Personal']);
            $table->string('nama_instansi')->nullable();
            $table->string('tujuan');
            $table->text('keperluan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_books');
    }
};
