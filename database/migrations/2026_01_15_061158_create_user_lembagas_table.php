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
        Schema::create('user_sekolah', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id');    // FK ke users
    $table->unsignedBigInteger('sekolah_id'); // FK ke sekolah
    $table->timestamps();

    // Foreign key
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('sekolah_id')->references('id')->on('sekolahs')->onDelete('cascade');


});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_lembagas');
    }
};
