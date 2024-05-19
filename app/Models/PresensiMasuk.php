<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiMasuk extends Model
{
    use HasFactory;

    protected $table = 'presensi_masuks';
    protected $fillable = ['id_siswa','status'];
    protected $primaryKey = 'id_presensi';
}
