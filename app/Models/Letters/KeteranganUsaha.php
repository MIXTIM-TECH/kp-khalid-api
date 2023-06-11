<?php

namespace App\Models\Letters;

use App\Models\Surat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeteranganUsaha extends Model
{
    use HasFactory;

    protected $table = "surat_ket_usaha";

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}
