<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CredentialController extends Controller
{
    private $time;

    public function __construct()
    {
        $this->time = time();
    }

    public function activation(Credential $userCredential)
    {
        $userCredential->status = true;
        $userCredential->save();
        return $this->responseSuccess("Aktivasi Berhasil");
    }

    public function pendaftar()
    {
        return $this->responseSuccess(Credential::with("penduduk")->whereHas("waktuAktivasi", function (Builder $query) {
            $query->where("batas_aktivasi", ">", $this->time);
        })->where("status", false)->get());
    }

    public function pendaftarKadaluarsa()
    {
        return $this->responseSuccess(Credential::with("penduduk")->whereHas("waktuAktivasi", function (Builder $query) {
            $query->where("batas_aktivasi", "<", $this->time);
        })->where("status", false)->get());
    }
}
