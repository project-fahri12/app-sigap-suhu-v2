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
<<<<<<< HEAD
            $table->foreignId('pondok_id')->nullable()->constrained('pondoks')->nullOnDelete();
            $table->foreignId('pendaftar_id')->unique()->constrained('pendaftars')->cascadeOnDelete();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->cascadeOnDelete();
            $table->foreignId('romkam_id')->nullable()->constrained('romkams')->cascadeOnDelete();
            $table->string('nis');
            $table->string('status_santri')->nullable();
=======
            $table->foreignId('pondok_id')->nullable()->constrained('pondoks');
            $table->foreignId('pendaftar_id')->unique()->constrained('pendaftars')->onDelete('cascade');
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->foreignId('romkam_id')->nullable()->constrained('romkams')->onDelete('set null');
            $table->string('nis')->nullable(); 
            $table->string('status_santri')->nullable(); 
>>>>>>> 2b7298b4caabe6b918d24deb5a98e188364485b5
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