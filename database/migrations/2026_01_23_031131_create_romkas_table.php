<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('romkams', function (Blueprint $table) {
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

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('romkams');
    }
};
