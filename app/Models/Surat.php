<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table = "surat";

    public function info()
    {
        return $this->hasOne(InfoSurat::class);
    }

    public function pemohon()
    {
        return $this->hasOne(AnggotaKeluarga::class, "pemohon");
    }
}
