<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasJurusan extends Model
{
    use HasFactory;

    protected $table = 'kelas_jurusans';
    protected $fillable = ['kelas','jurusan','nama_kelas'];
    protected $primaryKey = 'id_kelas';
}
