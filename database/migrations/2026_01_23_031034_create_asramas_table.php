<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asramas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_asrama');
            $table->string('status_asrama')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('romkams');
        Schema::dropIfExists('asramas');
    }
};
