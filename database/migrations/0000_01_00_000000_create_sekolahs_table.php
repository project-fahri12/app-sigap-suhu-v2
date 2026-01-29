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
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sekolah');
            $table->string('nama_sekolah');
            $table->string('jenjang', '20');
            $table->enum('keterangan', ['tidak_wajib', 'wajib'])->default('wajib');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('sekolahs');
        Schema::enableForeignKeyConstraints();

    }
};
