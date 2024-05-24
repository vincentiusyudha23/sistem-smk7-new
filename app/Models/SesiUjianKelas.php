<?php

namespace App\Models;

use App\Models\SesiUjian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SesiUjianKelas extends Model
{
    use HasFactory;

    protected $table = 'sesi_ujian_kelas';
    protected $fillable = ['id_sesi_ujian','id_kelas'];
    protected $primaryKey = 'id';

    public function sesi_ujian(): HasOne
    {
        return $this->hasOne(SesiUjian::class,'id', 'id_sesi_ujian');
    }
}
