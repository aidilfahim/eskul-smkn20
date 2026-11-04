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
    Schema::create('ekstrakurikulers', function (Blueprint $table) {
        $table->id();
        $table->string('nama_ekskul');
        $table->string('kategori'); // <-- Tambahan
        $table->string('hari');     // <-- Tambahan
        $table->string('jam');      // <-- Tambahan
        $table->text('deskripsi');
        $table->string('pembina');
        $table->integer('kuota');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekstrakurikulers');
    }
};
