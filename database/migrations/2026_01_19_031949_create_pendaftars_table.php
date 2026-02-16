<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();

            $table->string('kode_pendaftaran')->unique();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans')->cascadeOnDelete();
            
            // Dibuat nullable karena dipilih setelah login (dashboard)
            $table->foreignId('sekolah_id')->nullable()->constrained('sekolahs')->nullOnDelete();
            $table->foreignId('pondok_id')->nullable()->constrained('pondoks')->nullOnDelete();
            $table->foreignId('gelombang_ppdb_id')->nullable()->constrained('gelombang_ppdbs')->nullOnDelete();
            
            // Data Pribadi
            $table->string('nama_lengkap');
            $table->string('nisn', 10)->unique(); // Wajib di awal
            $table->string('tempat_lahir');      // Wajib di awal
            $table->date('tanggal_lahir');       // Wajib di awal
            
            // Data yang dilengkapi nanti (Nullable)
            $table->string('nik', 16)->nullable();
            $table->string('nomor_kk', 16)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->integer('anak_ke')->nullable();
            $table->integer('jumlah_saudara')->nullable();
            $table->string('domisili_santri')->nullable();
            $table->string('berkebutuhan_khusus')->nullable();

            // Alamat (Semua Nullable untuk dilengkapi di dashboard)
            $table->text('alamat_lengkap')->nullable();
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->string('kode_pos', 10)->nullable();

            // Sekolah Asal
            $table->string('sekolah_asal'); // Wajib di awal
            $table->string('npsn_sekolah')->nullable();
            $table->string('status_sekolah')->nullable();

            $table->string('status_pendaftaran')->default('draft');
            $table->string('status_berkas')->default('belum');
            $table->string('last_step')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};