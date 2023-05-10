<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = "username";
    protected $keyType = "string";
    protected $hidden = ["username", "password"];
    public $incrementing = false;

    public function penduduk()
    {
        return $this->hasOne(Penduduk::class, "nik_anggota_keluarga");
    }

    public function waktuAktivasi()
    {
        return $this->hasOne(WaktuAktivasi::class, "username");
    }
}
