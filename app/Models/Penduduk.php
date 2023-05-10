<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Penduduk extends Authenticatable
{
    use HasFactory;

    protected $table = "penduduk";
    protected $guarded = [];
    protected $primaryKey = "nik_anggota_keluarga";
    protected $keyType = "string";
    public $incrementing = false;
}
