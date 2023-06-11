<?php

namespace App\Models\Letters;

use App\Models\OrangTua;
use App\Models\Surat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengantarPernikahan extends Model
{
    use HasFactory;

    protected $table = "surat_pengantar_pernikahan";

    public function surat()
    {
        return $this->hasOne(Surat::class);
    }

    public function ayah()
    {
        return $this->hasOne(OrangTua::class, "id_ayah");
    }

    public function ibu()
    {
        return $this->hasOne(OrangTua::class, "id_ibu");
    }
}
