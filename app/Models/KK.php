<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KK extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "kk";
    protected $primaryKey = "no_kk";
    protected $keyType = "string";
    public $incrementing = false;
}
