<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('santris', function (Blueprint $table) {
            $table->id();

            // Relasi utama
            $table->foreignId('pendaftar_id')
                  ->unique()
                  ->constrained('pendaftars')
                  ->cascadeOnDelete();

            $table->foreignId('pondok_id')
                  ->nullable()
                  ->constrained('pondoks')
                  ->nullOnDelete();

            $table->foreignId('sekolah_id')
                  ->constrained('sekolahs')
                  ->cascadeOnDelete();

            $table->foreignId('romkam_id')
                  ->nullable()
                  ->constrained('romkams')
                  ->nullOnDelete();

            // Data santri
            $table->string('nis')->nullable();
            $table->string('status_santri')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('santris');
        Schema::enableForeignKeyConstraints();
    }
};
