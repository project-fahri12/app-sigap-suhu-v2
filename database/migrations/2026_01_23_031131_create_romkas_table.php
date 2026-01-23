<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('romkams', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Pondok
            $table->foreignId('pondok_id')->constrained('pondoks')->onDelete('cascade'); 
            
            // Relasi ke Asrama (Gedung) - Pastikan tabel asramas sudah dibuat lebih dulu
            $table->foreignId('asrama_id')->constrained('asramas')->onDelete('cascade');
            
            $table->string('nis')->nullable(); // NIS Wali Kamar / Pembimbing
            $table->string('nama_romkam');
            $table->integer('kapasitas');
            $table->string('status_romkam')->default('Tersedia'); // Default 'Tersedia' daripada NULL
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('romkams');
        Schema::enableForeignKeyConstraints();
    }
};