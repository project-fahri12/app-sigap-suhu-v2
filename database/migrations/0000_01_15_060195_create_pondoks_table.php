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
        Schema::create('pondoks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pondok');
            $table->string('nama_pondok');
            $table->string('yayasan_mitra')->nullable();
            $table->string('jenis');
            $table->string('pengasuh')->nullable();
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
        Schema::dropIfExists('pondoks');
        Schema::enableForeignKeyConstraints();

    }
};
