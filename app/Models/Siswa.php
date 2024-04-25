<?php

namespace App\Models;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\OrangTua;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';
    protected $fillable = ['user_id','id_orangtua','password','id_kelas','id_jurusan','nama','nis','tanggal_lahir'];
    protected $primaryKey = 'id_siswa';

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function jurusan(): HasOne
    {
        return $this->hasOne(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }

    public function orangTua(): BelongsTo
    {
        return $this->BelongsTo(OrangTua::class, 'id_orangtua', 'id_orangtua');
    }

}
