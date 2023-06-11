<?php

namespace App\Models\Letters;

use App\Models\Surat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domisili extends Model
{
    use HasFactory;

    protected $table = "surat_ket_domisili";

    public function surat()
    {
        return $this->hasOne(Surat::class);
    }
}
