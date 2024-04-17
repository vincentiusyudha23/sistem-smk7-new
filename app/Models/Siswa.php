<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';
    protected $fillable = ['id_orangtua','id_kelas','id_jurusan','username','password','nama','nis','tanggal_lahir'];
    protected $primaryKey = 'id_siswa';
}
