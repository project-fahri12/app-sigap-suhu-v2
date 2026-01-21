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
        Schema::create('pendaftars', function (Blueprint $table) {
    $table->id();
    $table->string('kode_pendaftaran')->unique();
    $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans')->onDelete('cascade');
    $table->integer('sekolah_id'); 
    $table->integer('pondok_id')->nullable();
    $table->integer('gelombang_ppdb_id')->nullable();

    
    // Data Pribadi
    $table->string('nama_lengkap');
    $table->string('nik', 16);
    $table->string('nisn', 10);
    $table->string('nomor_kk', 16);
    $table->string('tempat_lahir');
    $table->date('tanggal_lahir');
    $table->enum('jenis_kelamin', ['L', 'P']);
    $table->integer('anak_ke');
    $table->integer('jumlah_saudara');
    $table->string('domisili_santri');  
    $table->string('berkebutuhan_khusus')->nullable();
    
    // Alamat
    $table->text('alamat_lengkap');
    $table->string('rt', 5);
    $table->string('rw', 5);
    $table->string('provinsi');
    $table->string('kabupaten');
    $table->string('kecamatan');
    $table->string('desa');
    $table->string('kode_pos', 10);
    
    // Sekolah Asal
    $table->string('sekolah_asal');
    $table->string('npsn_sekolah');
    $table->string('status_sekolah');
    
    $table->string('status_pendaftaran')->default('pending');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};
