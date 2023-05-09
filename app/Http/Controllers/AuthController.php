<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\Credential;
use App\Models\KK;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 
    }

    public function register(Request $request)
    {
        $validationResult = $this->checkValidator(Validator::make($request->all(), [
            "password"      => "string|required|min:8",
            "no_kk"         => "string|required|unique:kk,no_kk|max:16",
            "no_whatsapp"   => "string|required",
            "foto_kk"       => [
                "required",
                File::image()->max(2048)
            ],
            "nama"          => "string|required",
            "nik"           => "string|required|max:16|unique:anggota_keluarga,nik"
        ]));

        if ($validationResult !== true) return $validationResult;

        // upload foto kk
        $fileName = $request->file("foto_kk")->store("kk", "penduduk");

        $user = DB::transaction(function () use ($request, $fileName) {
            $anggotaKeluarga = new AnggotaKeluarga;
            $anggotaKeluarga->nama = $request->nama;
            $anggotaKeluarga->nik = $request->nik;
            $anggotaKeluarga->save();

            $kk = new KK;
            $kk->no_kk = $request->no_kk;
            $kk->nik_kepala_keluarga = $request->nik;
            $kk->foto_kk = $fileName;
            $kk->save();

            $user = new User;
            $user->no_kk = $kk->no_kk;
            $user->nik_anggota_keluarga = $request->nik;
            $user->no_whatsapp = $request->no_whatsapp;
            $user->save();

            $credential = new Credential;
            $credential->username = $request->nik;
            $credential->password = password_hash($request->password, PASSWORD_DEFAULT);
            $credential->save();

            return $user;
        }, 5);

        return $this->responseSuccess(["user" => $user]);
    }
}
