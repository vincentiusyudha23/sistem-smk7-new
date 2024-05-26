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
        Schema::create('kelas_jurusans', function (Blueprint $table) {
            $table->id('id_kelas');
            $table->string('jurusan');
            $table->enum('kelas', [10,11,12]);
            $table->string('nama_kelas');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_jurusans');
    }
};
