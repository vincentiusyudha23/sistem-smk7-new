<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapels';
    protected $fillable = ['user_id','password','kode_mapel','nama_mapel','nama_guru','nip'];
    protected $primaryKey = 'id_mapel';

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function sesi_ujian(): HasMany
    {
        return $this->hasMany(SesiUjian::class);
    }
}
