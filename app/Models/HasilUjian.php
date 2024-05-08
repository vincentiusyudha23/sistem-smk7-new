<?php

namespace App\Models;

use App\Models\Siswa;
use App\Models\SesiUjian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilUjian extends Model
{
    use HasFactory;
    protected $table = 'hasil_ujians';
    protected $fillable = ['id_siswa','id_sesi_ujian','nama_siswa','jawaban','nilai'];
    protected $primaryKey = 'id';

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function sesi_ujian(): BelongsTo
    {
        return $this->belongsTo(SesiUjian::class, 'id_sesi_ujian', 'id');
    }
}
