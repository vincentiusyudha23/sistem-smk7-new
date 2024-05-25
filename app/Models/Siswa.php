<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrangTua;
use App\Models\KelasSiswa;
use App\Models\KelasJurusan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';
    protected $fillable = ['user_id','id_orangtua','password','nama','nis','tanggal_lahir'];
    protected $primaryKey = 'id_siswa';

    protected $casts = [ 'tanggal_lahir' => 'datetime'];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orangTua(): BelongsTo
    {
        return $this->BelongsTo(OrangTua::class, 'id_orangtua', 'id_orangtua');
    }

    public function kelas()
    {
        return $this->belongsTo(KelasSiswa::class, 'id_siswa', 'id_siswa');
    }

    public function getKelas()
    {
        // Ambil id siswa
        $id_siswa = $this->id_siswa;
        
        // Ambil data kelas dari tabel Kelas berdasarkan id_kelas yang didapat dari siswa
        $kelas = KelasJurusan::join('kelas_siswas', 'kelas_jurusans.id_kelas', '=', 'kelas_siswas.id_kelas')
                      ->where('kelas_siswas.id_siswa', $id_siswa)
                      ->select('kelas_jurusans.*')
                      ->first();
        
        return $kelas;
    }

}
