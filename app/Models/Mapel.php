<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapels';
    protected $fillable = ['id_kelas','id_jurusan','username','password','nama_mapel','nama_guru','nip'];
    protected $primaryKey = 'id_mapel';
}
