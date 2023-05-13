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

    public function alamat()
    {
        return $this->hasOne(Alamat::class, "id", "id_detail_alamat");
    }

    public function penduduk()
    {
        return $this->hasOne(Penduduk::class, "nik_anggota_keluarga");
    }
}
