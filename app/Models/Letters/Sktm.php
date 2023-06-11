<?php

namespace App\Models\Letters;

use App\Models\OrangTua;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sktm extends Model
{
    use HasFactory;

    protected $table = "surat_ket_tidak_mampu";

    public function surat()
    {
        return $this->hasOne(Surat::class);
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class);
    }
}
