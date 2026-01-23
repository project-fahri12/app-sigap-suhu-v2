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
        Schema::create('romkas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pondok_id'); // foreign key
            $table->string('nis');
            $table->string('nama_romkam');
            $table->integer('kapasitas');
            $table->string('status_romkam')->nullable();
            $table->unsignedBigInteger('asrama_id'); // foreign key
            $table->timestamps();

            $table->foreign('asrama_id')->references('id')->on('asramas')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('romkas');
    }
};
