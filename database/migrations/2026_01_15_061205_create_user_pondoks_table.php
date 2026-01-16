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
        Schema::create('user_pondoks', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id');   
    $table->unsignedBigInteger('pondok_id'); 
    $table->timestamps();

    // Foreign key
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('pondok_id')->references('id')->on('pondoks')->onDelete('cascade');

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_pondoks');
    }
};
