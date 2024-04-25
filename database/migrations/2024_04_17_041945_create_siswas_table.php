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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('id_orangtua')->references('id_orangtua')->on('orang_tuas')->cascadeOnDelete();
            $table->foreignId('id_kelas')->references('id_kelas')->on('kelas')->cascadeOnDelete();
            $table->foreignId('id_jurusan')->references('id_jurusan')->on('jurusans')->cascadeOnDelete();
            $table->string('password')->nullable();
            $table->string('nama');
            $table->string('nis');
            $table->date('tanggal_lahir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
