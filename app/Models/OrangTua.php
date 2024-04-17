<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    use HasFactory;

    protected $table = 'orang_tuas';
    protected $fillable = ['nama','nomor_telepon'];
    protected $primaryKey = 'id_orangtua';
}
