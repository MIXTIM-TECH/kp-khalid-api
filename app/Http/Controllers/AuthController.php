<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\AnggotaKeluarga;
use App\Models\Credential;
use App\Models\KK;
use App\Models\Penduduk;
use App\Models\WaktuAktivasi;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class AuthController extends Controller
{
    private $rules, $time;

    private function getSecondDays(int $day): int
    {
        $hours = 3600;
        $days = $hours * 24;
        return $days * $day;
    }

    private function generateToken(array $payload): array
    {
        $keys = ["access" => env("JWT_SECRET"), "refresh" => env("JWT_REFRESH")];
        foreach ($keys as $prop => $key) {
            try {
                $exp = $this->time + 3600; // 1 jam
                if ($prop === "refresh") $exp = $this->time + $this->getSecondDays(7);

                $payload["exp"] = $exp;
                $tokens["token_$prop"] = JWT::encode($payload, $key, "HS256");
            } catch (Exception $e) {
                return $this->unknownResponse($e->getMessage());
            }
        }
        return $tokens;
    }

    public function __construct()
    {
        $this->rules = require_once(app_path("Http/Req/ValidationRules.php"));
        $this->time = time();
    }

    public function login(Request $request)
    {
        $validationResult = $this->checkValidator(Validator::make($request->all(), [
            "username"      => "required",
            "password"      => "required"
        ]));

        if ($validationResult !== true) return $validationResult;

        // validasi user
        $credential = Credential::with("penduduk")->where("username", $request->username)->first();

        if (!$credential || !password_verify($request->password, $credential->password))
            return $this->responseNotFound("Username atau password salah");
        if ($credential->status === "tidak_aktif")
            return $this->responseUnauthorize("Akun anda belum bisa digunakan, Harap tunggu 2x 24-Jam atau hubungi admin kelurahan.");
        if ($credential->status === "ditolak") return $this->responseUnauthorize("Maaf, akun anda ditolak untuk aktivasi.");

        // generate token
        $payload = [
            "username"  => $credential->username,
            "role"      => $credential->role,
            "iat"       => $this->time
        ];
        if ($credential->penduduk) $payload["no_kk"] = $credential->penduduk->no_kk;
        $tokens = $this->generateToken($payload);

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
        ]));

        if ($validationResult !== true) return $validationResult;

        // upload foto kk
        $fileName = $request->file("foto_kk")->store("kk", "penduduk");

        $user = DB::transaction(function () use ($request, $fileName) {
            $alamat = new Alamat;
            $alamat->type = "anggota_keluarga";
            $alamat->save();

            $anggotaKeluarga = new AnggotaKeluarga;
            $anggotaKeluarga->id_detail_alamat = $alamat->id;
            $anggotaKeluarga->nama = $request->nama;
            $anggotaKeluarga->nik = $request->nik;
            $anggotaKeluarga->save();

            $kk = new KK;
            $kk->no_kk = $request->no_kk;
            $kk->nik_kepala_keluarga = $request->nik;
            $kk->foto_kk = $fileName;
            $kk->save();

            // update nomor kk
            $anggotaKeluarga->no_kk = $kk->no_kk;
            $anggotaKeluarga->save();

            $user = new Penduduk;
            $user->no_kk = $kk->no_kk;
            $user->nik_anggota_keluarga = $request->nik;
            $user->no_whatsapp = $request->no_whatsapp;
            $user->save();

            $credential = new Credential;
            $credential->username = $request->nik;
            $credential->password = password_hash($request->password, PASSWORD_DEFAULT);
            $credential->save();

            $waktuAktivasi = new WaktuAktivasi;
            $waktuAktivasi->username = $request->nik;
            $waktuAktivasi->tanggal_registrasi = $this->time;
            $waktuAktivasi->batas_aktivasi = $this->time + $this->getSecondDays(2);
            $waktuAktivasi->save();

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
            $payload->iat = $this->time;
            $tokens = $this->generateToken((array) $payload);

            return $this->responseSuccess($tokens);
        } catch (Exception $e) {
            return $this->unknownResponse($e->getMessage());
        }
    }
}
