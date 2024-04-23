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
        Schema::create('mapels', function (Blueprint $table) {
            $table->id('id_mapel');
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('id_kelas')->references('id_kelas')->on('kelas')->cascadeOnDelete();
            $table->foreignId('id_jurusan')->references('id_jurusan')->on('jurusans')->cascadeOnDelete();
            $table->string('nama_mapel');
            $table->string('kode_mapel')->unique();
            $table->string('nama_guru');
            $table->string('nip');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapels');
    }
};
