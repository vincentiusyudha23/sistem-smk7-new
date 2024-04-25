<?php

namespace App\Models;

use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapels';
    protected $fillable = ['user_id','id_kelas','id_jurusan','password','kode_mapel','nama_mapel','nama_guru','nip'];
    protected $primaryKey = 'id_mapel';

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function jurusan(): HasOne
    {
        return $this->hasOne(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
}
