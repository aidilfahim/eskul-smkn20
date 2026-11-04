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
    Schema::create('pendaftarans', function (Blueprint $table) {
        $table->id();
        // Menghubungkan pendaftaran dengan siswa (tabel users)
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        // Menghubungkan pendaftaran dengan ekskul
        $table->foreignId('ekstrakurikuler_id')->constrained()->cascadeOnDelete();
        // Status pendaftaran
        $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
