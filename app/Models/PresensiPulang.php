<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiPulang extends Model
{
    use HasFactory;

    protected $table = 'presensi_pulangs';
    protected $fillable = ['id_siswa','status'];
    protected $primaryKey = 'id_presensi';
}
