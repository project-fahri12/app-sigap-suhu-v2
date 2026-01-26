<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom jk di tabel asramas
        Schema::table('asramas', function (Blueprint $table) {
            $table->enum('jk', ['L', 'P'])->after('nama_asrama')
                  ->comment('L = Laki-laki, P = Perempuan')
                  ->default('L');
        });

        // Tambah kolom jk di tabel romkams
        Schema::table('romkams', function (Blueprint $table) {
            $table->enum('jk', ['L', 'P'])->after('nama_romkam')
                  ->comment('L = Laki-laki, P = Perempuan')
                  ->default('L');
        });
    }

    public function down(): void
    {
        Schema::table('asramas', function (Blueprint $table) {
            $table->dropColumn('jk');
        });

        Schema::table('romkams', function (Blueprint $table) {
            $table->dropColumn('jk');
        });
    }
};
