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
        Schema::table('permohonan', function (Blueprint $table) {
            // Make user_id nullable (tidak wajib login)
            $table->unsignedBigInteger('user_id')->nullable()->change();
            // Tambah kolom nisn setelah user_id
            $table->string('nisn', 10)->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn('nisn');
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};
