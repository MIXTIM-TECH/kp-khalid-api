<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaktuAktivasi extends Model
{
    use HasFactory;

    protected $table = "waktu_aktivasi";
    protected $guarded = [];
    protected $primaryKey = "username";
    protected $keyType = "string";
    public $incrementing = false;
}
