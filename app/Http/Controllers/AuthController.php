<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\Credential;
use App\Models\KK;
use App\Models\Penduduk;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class AuthController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = require_once(app_path("Http/Req/ValidationRules.php"));
    }

    public function login(Request $request)
    {
        $validationResult = $this->checkValidator(Validator::make($request->all(), [
            "username"      => "required",
            "password"      => "required"
        ]));

        if ($validationResult !== true) return $validationResult;

        // validasi user
        $credential = Credential::where("username", $request->username)->with("penduduk")->first();
        if (!$credential || !password_verify($request->password, $credential->password)) {
            return $this->responseNotFound("Username atau password salah");
        }
        if (!$credential->status) return $this->responseUnauthorize("Akun anda belum bisa digunakan, Harap tunggu atau hubungi admin kelurahan.");

        // generate token
        $payload = [
            "role"  => $credential->role,
            "nik"   => $credential->penduduk->nik_anggota_keluarga
        ];
        $keys = ["access" => env("JWT_SECRET"), "refresh" => env("JWT_REFRESH")];
        foreach ($keys as $prop => $key) {
            try {
                $tokens["token_$prop"] = JWT::encode($payload, $key, "HS256");
            } catch (Exception $e) {
                return $this->unknownResponse($e->getMessage());
            }
        }

        return $this->responseSuccess(array_merge($payload, $tokens));
    }

    public function register(Request $request)
    {
        $validationResult = $this->checkValidator(Validator::make($request->all(), [
            "password"      => "string|required|min:8",
            "no_kk"         => $this->rules["no_kk"],
            "no_whatsapp"   => "string|required",
            "foto_kk"       => [
                "required",
                File::image()->max(2048)
            ],
            "nama"          => "string|required",
            "nik"           => $this->rules["nik"]
        ], [
            "no_kk" => ["unique"    => "Nomor KK telah terdaftar."],
            "nik"   => ["unique"    => "Nomor Nik telah terdaftar."]
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

            $user = new Penduduk;
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

        return $this->responseSuccess(["penduduk" => $user]);
    }

    public function refreshToken(Request $request)
    {
        $validationResult = $this->checkValidator(Validator::make($request->all(), [
            "token_refresh" => "required"
        ]));

        if ($validationResult !== true) return $validationResult;

        try {
            $payload = JWT::decode($request->token_refresh, new Key(env("JWT_REFRESH"), "HS256"));
            $token = JWT::encode((array) $payload, env("JWT_SECRET"), "HS256");
            return $this->responseSuccess(["token_access" => $token]);
        } catch (Exception $e) {
            return $this->unknownResponse($e->getMessage());
        }
    }
}
