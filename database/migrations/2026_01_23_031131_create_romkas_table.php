<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('romkams', function (Blueprint $table) {
<<<<<<< HEAD
            $table->engine = 'InnoDB';

            $table->id();

            $table->foreignId('pondok_id')
                  ->constrained('pondoks')
                  ->cascadeOnDelete();

            $table->string('nis');
            $table->string('nama_romkam');
            $table->integer('kapasitas');
            $table->string('status_romkam')->nullable();

            $table->foreignId('asrama_id')
                  ->constrained('asramas')
                  ->cascadeOnDelete();

=======
            $table->id();
            
            // Relasi ke Pondok
            $table->foreignId('pondok_id')->constrained('pondoks')->onDelete('cascade'); 
            
            // Relasi ke Asrama (Gedung) - Pastikan tabel asramas sudah dibuat lebih dulu
            $table->foreignId('asrama_id')->constrained('asramas')->onDelete('cascade');
            
            $table->string('nis')->nullable(); // NIS Wali Kamar / Pembimbing
            $table->string('nama_romkam');
            $table->integer('kapasitas');
            $table->string('status_romkam')->default('Tersedia'); // Default 'Tersedia' daripada NULL
            
>>>>>>> 2b7298b4caabe6b918d24deb5a98e188364485b5
            $table->timestamps();
        });
    }

    public function down(): void
    {
<<<<<<< HEAD
        Schema::dropIfExists('romkams');
=======
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('romkams');
        Schema::enableForeignKeyConstraints();
>>>>>>> 2b7298b4caabe6b918d24deb5a98e188364485b5
    }
};