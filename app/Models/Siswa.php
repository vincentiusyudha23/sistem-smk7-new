<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrangTua;
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

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orangTua(): BelongsTo
    {
        return $this->BelongsTo(OrangTua::class, 'id_orangtua', 'id_orangtua');
    }

}
