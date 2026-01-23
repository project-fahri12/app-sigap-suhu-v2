<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->unique()->constrained('pendaftars')->onDelete('cascade');
            $table->string('nis')->nullable()->constrained('kelas');
            $table->foreignId('rombel_id')->nullable()->nullable();
            $table->foreignId('kelas_id')->nullable()->constrained('rombels');
            $table->foreignId('pondok_id')->nullable()->constrained('pondoks');
            $table->string('status_santri')->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
