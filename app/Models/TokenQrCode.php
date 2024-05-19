<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenQrCode extends Model
{
    use HasFactory;

    protected $table = 'token_qr_codes';
    protected $fillable = ['nama','token','status'];
    protected $primaryKey = 'id';
}
