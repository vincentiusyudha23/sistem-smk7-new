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

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'kelas_siswas', 'id_kelas', 'id_siswa');
    }
}
