<?php

namespace App\Models\Letters;

use App\Models\OrangTua;
use App\Models\Surat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skck extends Model
{
    use HasFactory;

    protected $table = "surat_skck";

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }

    public function ayah()
    {
        return $this->belongsTo(OrangTua::class, "id_ayah");
    }

    public function ibu()
    {
        return $this->belongsTo(OrangTua::class, "id_ibu");
    }
}
