<?php

namespace App\Http\Controllers;

use App\Http\Res\Response;
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

    public function __construct()
    {
        $this->rules = require_once(app_path("Http/Req/ValidationRules.php"));
        $this->time = time();
    }

    private static function getSecondDays(int $day): int
    {
        $hours = 3600;
        $days = $hours * 24;
        return $days * $day;
    }

    private static function generateToken(array $payload): array
    {
        $time = time();
        $keys = ["access" => env("JWT_SECRET"), "refresh" => env("JWT_REFRESH")];
        $tokens = [];

        foreach ($keys as $prop => $key) {
            try {
                $exp = $time + 3600; // 1 jam
                if ($prop === "refresh") $exp = $time + self::getSecondDays(7);

                $payload["exp"] = $exp;
                $tokens["token_$prop"] = JWT::encode($payload, $key, "HS256");
            } catch (Exception $e) {
                return Response::message($e->getMessage());
            }
        }
        return $tokens;
    }

    public static function getAuth(array $payload)
    {
        $tokens = self::generateToken($payload);
        return array_merge($payload, $tokens);
    }

    public static function getPayload(string $username, string $role): array
    {
        $time = time();
        $payload = [
            "username"  => $username,
            "role"      => $role,
            "iat"       => $time
        ];

        if ($role === "user") {
            $kk = KK::where("nik_kepala_keluarga", $username)->first();
            $payload["no_kk"] = $kk->no_kk;
        }

        return $payload;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "username"      => "required",
            "password"      => "required"
        ]);

        if ($validator->fails()) return Response::errors($validator);

        // validasi user
        $credential = Credential::with("penduduk")->where("username", $request->username)->first();

        if (!$credential || !password_verify($request->password, $credential->password)) {
            return Response::message("Username atau password salah", 400);
        }
        if ($credential->status === "tidak_aktif") {
            return Response::message("Akun anda belum bisa digunakan, Harap tunggu 2x 24-Jam atau hubungi admin kelurahan.", 401);
        }
        if ($credential->status === "ditolak") {
            return Response::message("Maaf, akun anda ditolak untuk aktivasi.", 403);
        }

        // generate token
        $payload = [
            "username"  => $credential->username,
            "role"      => $credential->role,
            "iat"       => $this->time
        ];
        if ($credential->penduduk) $payload["no_kk"] = $credential->penduduk->no_kk;
        return Response::success(array_merge($payload, self::generateToken($payload)));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "password"      => "string|required|min:8",
            "no_kk"         => $this->rules["no_kk"],
            "no_whatsapp"   => "string|required",
            "foto_kk"       => [
                "required",
                File::image()->max(2048)
            ],
            "nama"          => "string|required",
            "nik"           => $this->rules["nik"]
        ]);
        if ($validator->fails()) return Response::errors($validator);

        // upload foto kk
        $fileName = "penduduk/" . $request->file("foto_kk")->store("kk", "penduduk");

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
            $waktuAktivasi->batas_aktivasi = $this->time + self::getSecondDays(2);
            $waktuAktivasi->save();

            return $user;
        }, 5);

        return Response::success(["penduduk" => $user]);
    }

    public function refreshToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "token_refresh" => "required"
        ]);

        if ($validator->fails()) return Response::errors($validator);

        try {
            $payload = JWT::decode($request->token_refresh, new Key(env("JWT_REFRESH"), "HS256"));
            $payload->iat = $this->time;

            return Response::success(self::generateToken((array) $payload));
        } catch (Exception $e) {
            return Response::message($e->getMessage());
        }
    }
}
