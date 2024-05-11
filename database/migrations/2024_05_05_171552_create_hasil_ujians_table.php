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
        Schema::create('hasil_ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->references('id_siswa')->on('siswas')->cascadeOnDelete();
            $table->foreignId('id_sesi_ujian')->references('id')->on('sesi_ujians')->cascadeOnDelete();
            $table->string('nama_siswa');
            $table->json('jawaban');
            $table->float('nilai', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_ujians');
    }
};
