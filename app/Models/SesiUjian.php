<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiUjian extends Model
{
    use HasFactory;

    protected $table = 'sesi_ujians';
    protected $fillable = ['id_mapel','tanggal_ujian','start','end','status','soal_ujian'];
    protected $primaryKey = 'id';
}
