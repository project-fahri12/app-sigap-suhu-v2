<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daftar_ulangs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pendaftar_id')
                ->constrained('pendaftarans')
                ->cascadeOnDelete();

            $table->integer('tagihan');
            $table->integer('dibayar')->default(0);

            $table->enum('status_pembayaran', [
                'belum_bayar',
                'kurang',
                'lunas'
            ])->default('belum_bayar');

            $table->string('keterangan', 150)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daftar_ulangs');
    }
};
