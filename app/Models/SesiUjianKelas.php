<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiUjianKelas extends Model
{
    use HasFactory;

    protected $table = 'sesi_ujian_kelas';
    protected $fillable = ['id_sesi_ujian','id_kelas'];
    protected $primaryKey = 'id';
}
