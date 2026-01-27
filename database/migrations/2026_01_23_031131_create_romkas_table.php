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

            // Relasi
            $table->foreignId('pondok_id')
                  ->constrained('pondoks')
                  ->cascadeOnDelete();

            $table->foreignId('asrama_id')
                  ->constrained('asramas')
                  ->cascadeOnDelete();

            // Data Romkam
            $table->string('nis')->nullable(); // Wali kamar / pembimbing
            $table->string('nama_romkam');
            $table->integer('kapasitas');
            $table->string('status_romkam')->default('Tersedia');

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
