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
        Schema::create('sesi_ujian_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_sesi_ujian')->references('id')->on('sesi_ujians')->cascadeOnDelete();
            $table->foreignId('id_kelas')->references('id_kelas')->on('kelas_jurusans')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_ujian_kelas');
    }
};
