<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KK extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "kk";
    protected $primaryKey = "no_kk";
    protected $keyType = "string";
    public $incrementing = false;

    public function anggotaKeluarga()
    {
        return $this->hasMany(AnggotaKeluarga::class, "no_kk");
    }

    public function kepalaKeluarga()
    {
        return $this->hasOne(AnggotaKeluarga::class, "nik", "nik_kepala_keluarga");
    }
}
