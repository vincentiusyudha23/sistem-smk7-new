<?php

namespace App\Models;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PresensiPulang extends Model
{
    use HasFactory;

    protected $table = 'presensi_pulangs';
    protected $fillable = ['id_siswa','status'];
    protected $primaryKey = 'id_presensi';

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa','id_siswa');
    }
}
