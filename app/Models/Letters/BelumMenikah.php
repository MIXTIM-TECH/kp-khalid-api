<?php

namespace App\Models\Letters;

use App\Models\Surat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BelumMenikah extends Model
{
    use HasFactory;

    protected $table = "surat_ket_belum_menikah";

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}
