<?php

namespace App\Models;

use App\Models\Mapel;
use App\Models\HasilUjian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SesiUjian extends Model
{
    use HasFactory;

    protected $table = 'sesi_ujians';
    protected $fillable = ['id_mapel','tanggal_ujian','start','end','status','soal_ujian'];
    protected $primaryKey = 'id';

    protected $casts = [ 
        'tanggal_ujian' => 'datetime',
        'end' => 'datetime',
        'start' => 'datetime'
    ];

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }

    /**
     * Mendapatkan daftar ujian berdasarkan kelas dan jurusan siswa
     *
     * @param int $id_kelas
     * @param int $id_jurusan
     * @return \Illuminate\Database\Eloquent\Collection
     */
    // public static function getUjiansByKelasJurusan($id_kelas, $id_jurusan)
    // {
    //     return self::select('sesi_ujians.*', 'mapels.id_kelas', 'mapels.id_jurusan')
    //         ->join('mapels', 'sesi_ujians.id_mapel', '=', 'mapels.id_mapel')
    //         ->where('mapels.id_kelas', $id_kelas)
    //         ->where('mapels.id_jurusan', $id_jurusan)
    //         ->latest();
    // }

    public function hasil_ujian(): HasMany
    {
        return $this->hasMany(HasilUjian::class, 'id_sesi_ujian', 'id');
    }
}
