<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {

            // 1. Drop foreign key lama (kelas_id -> rombels.id)
            $table->dropForeign(['kelas_id']);

            // 2. Tambahkan foreign key yang BENAR
            $table->foreign('kelas_id')
                  ->references('id')
                  ->on('kelas')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {

            // rollback: hapus FK ke kelas
            $table->dropForeign(['kelas_id']);

            // (opsional) kalau mau balikin ke rombels lagi
            // $table->foreign('kelas_id')
            //       ->references('id')
            //       ->on('rombels');
        });
    }
};