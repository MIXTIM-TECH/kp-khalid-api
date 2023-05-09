<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaKeluarga extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "anggota_keluarga";
    protected $primaryKey = "nik";
    protected $keyType = "string";
    public $incrementing = false;
}
