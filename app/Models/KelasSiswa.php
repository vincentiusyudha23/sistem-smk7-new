<?php

namespace App\Models;

use App\Models\KelasJurusan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KelasSiswa extends Model
{
    use HasFactory;
    protected $table = 'kelas_siswas';
    protected $fillable = ['id_kelas','id_siswa'];
    protected $primaryKey = 'id';

    public function kelasJurusan()
    {
        return $this->hasOne(KelasJurusan::class);
    }

    public function kelas()
    {
        return $this->hasOne(KelasJurusan::class, 'id_kelas', 'id_kelas');
    }
}
