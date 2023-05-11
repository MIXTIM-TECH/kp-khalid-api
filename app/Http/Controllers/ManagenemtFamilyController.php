<?php

namespace App\Http\Controllers;

use App\Http\Res\Api;
use App\Models\AnggotaKeluarga;
use App\Models\KK;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ManagenemtFamilyController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = require_once(app_path("Http/Req/ValidationRules.php"));
    }

    public function index(KK $noKK)
    {
        return $this->responseSuccess($noKK::with("anggotaKeluarga")->get());
    }

    public function create(Request $request)
    {
        $validationResult = $this->checkValidator(Validator::make($request->all(), [
            "nama"          => "required|string",
            "nik"           => $this->rules["nik"],
            "no_kk"         => "required|exists:kk,no_kk",
            "no_whatsapp"   => "max:20"
        ]));

        if ($validationResult !== true) return $validationResult;

        $result = DB::transaction(function () use ($request) {
            // tambah anggota keluarga
            $anggotaKeluarga = new AnggotaKeluarga;
            $anggotaKeluarga->nama = $request->nama;
            $anggotaKeluarga->nik = $request->nik;
            $anggotaKeluarga->no_kk = $request->no_kk;
            $anggotaKeluarga->save();

            // update jumlah keluarga (table kk)
            $kk = KK::find($anggotaKeluarga->no_kk);
            $kk->jumlah_keluarga += 1;
            $kk->save();

            // tambah data penduduk
            $penduduk = new Penduduk;
            $penduduk->no_kk = $request->no_kk;
            $penduduk->nik_anggota_keluarga = $anggotaKeluarga->nik;
            $penduduk->no_whatsapp = $request->no_whatsapp;
            $penduduk->save();

            return $anggotaKeluarga;
        });

        return $this->responseSuccess($result);
    }

    public function update(KK $noKK)
    {
        // 
    }

    public function destroy(KK $kk, Request $request)
    {
        // validasi jika yang dihapus adalah nik kepala keluarga
        if ($kk->nik_kepala_keluarga === $request->nik)
            return response()->json(Api::fail("Tidak dapat menghapus kepala keluarga, silakan ganti kepala keluarga terlebih dahulu."));

        $result = DB::transaction(function () use ($kk, $request) {
            // kurangi jumlah keluarga
            $kk->jumlah_keluarga -= 1;
            $kk->save();

            // anggota keluarga
            $anggotaKeluarga = AnggotaKeluarga::find($request->nik);
            if (!$anggotaKeluarga) {
                DB::rollBack();
                return $this->responseNotFound("Nik tidak terdaftar sebagai anggota keluarga.");
            }

            return $this->responseSuccess($anggotaKeluarga->delete());
        });

        return $result;
    }
}
