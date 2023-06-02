<?php

namespace App\Http\Controllers;

use App\Http\Res\Response;
use App\Models\Alamat;
use App\Models\AnggotaKeluarga;
use App\Models\KK;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ManagementFamilyController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = require_once(app_path("Http/Req/ValidationRules.php"));
    }

    public function isPatriach(Request $request)
    {
        if (!$request->no_kk) return false;

        $kk = KK::find($request->no_kk);
        if ($request->user->role !== "user") return true;
        if ($kk->nik_kepala_keluarga === $request->user->username) return true;

        return false;
    }

    public function index(Request $request)
    {
        if (!$this->isPatriach($request)) return Response::message("Akses Ditolak", 403);

        $dataKeluarga = AnggotaKeluarga::where("no_kk", $request->no_kk);
        return Response::success($dataKeluarga->get()->toArray());
    }

    public function show(AnggotaKeluarga $anggotaKeluarga, Request $request)
    {
        if (!$this->isPatriach($request)) return Response::message("Akses Ditolak", 403);

        return Response::success($anggotaKeluarga);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama"          => "required|string",
            "nik"           => $this->rules["nik"],
            "no_whatsapp"   => "max:20"
        ]);
        if ($validator->fails()) return Response::errors($validator);
        if (!$this->isPatriach($request)) return Response::message("Akses Ditolak", 403);

        $result = DB::transaction(function () use ($request) {
            // tambah alamat
            $alamat = new Alamat;
            $alamat->type = "anggota_keluarga";
            $alamat->save();

            // tambah anggota keluarga
            $anggotaKeluarga = new AnggotaKeluarga;
            $anggotaKeluarga->id_detail_alamat = $alamat->id;
            $anggotaKeluarga->nama = $request->nama;
            $anggotaKeluarga->nik = $request->nik;
            $anggotaKeluarga->no_kk = $request->no_kk;
            $anggotaKeluarga->save();

            // update jumlah keluarga (table kk)
            $kk = KK::find($request->no_kk);
            $kk->jumlah_keluarga += 1;
            $kk->save();

            // tambah data penduduk
            $penduduk = new Penduduk;
            $penduduk->no_kk = $kk->no_kk;
            $penduduk->nik_anggota_keluarga = $request->nik;
            $penduduk->no_whatsapp = $request->no_whatsapp;
            $penduduk->save();

            return $anggotaKeluarga;
        });

        return Response::success($result);
    }

    public function update(AnggotaKeluarga $anggotaKeluarga, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "no_whatsapp"       => "max:20",
            "nama"              => "required|string",
            "jenis_kelamin"     => Rule::in(["P", "L"]),
            "tampat_lahir"      => "string",
            "tanggal_lahir"     => "date_format:Y-m-d",
            "status"            => Rule::in(["Kawin", "Belum Kawin"]),
            "pendidikan"        => Rule::in(["SD", "SMP", "SMA", "D3", "S1", "S2", "S3"]),
            "jenis_pekerjaan"   => "string",
            "agama"             => Rule::in(["Islam", "Kristen Protestan", "Katolik", "Hindu", "Buddha", "Kong Hu Cu"]),
            "status_perkawinan" => Rule::in(["Menikah", "Belum Menikah", "Cerai Hidup", "Cerai Mati"]),
            "alamat"            => "required|string",
            "rt"                => Rule::in(["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"]),
            "rw"                => Rule::in(["1", "2", "3"]),
            "kelurahan"         => "string|max:255",
            "kecamatan"         => "string|max:255",
            "kabupaten"         => "string|max:255",
            "provinsi"          => "string|max:255",
            "no_kk"             => "required|exists:kk,no_kk"
        ]);
        if ($validator->fails()) return Response::errors($validator);
        if (!$this->isPatriach($request)) return Response::message("Akses Ditolak", 403);

        $result = DB::transaction(function () use ($anggotaKeluarga, $request) {
            // update no whatsapp (penduduk)
            $penduduk = Penduduk::find($anggotaKeluarga->nik);
            $penduduk->no_whatsapp = $request->no_whatsapp;
            $penduduk->save();

            // create / update data alamat
            $alamat = Alamat::find($anggotaKeluarga->id_detail_alamat);
            if (!$alamat) $alamat = new Alamat;
            $alamat->alamat = $request->alamat;
            $alamat->rt = $request->rt;
            $alamat->rw = $request->rw;
            $alamat->kelurahan = $request->kelurahan;
            $alamat->kecamatan = $request->kecamatan;
            $alamat->kabupaten = $request->kabupaten;
            $alamat->provinsi = $request->provinsi;
            $alamat->type = "anggota_keluarga";
            $alamat->save();

            // $anggotaKeluarga
            $anggotaKeluarga->id_detail_alamat = $alamat->id;
            $anggotaKeluarga->nama = $request->nama;
            $anggotaKeluarga->jenis_kelamin = $request->jenis_kelamin;
            $anggotaKeluarga->tempat_lahir = $request->tempat_lahir;
            $anggotaKeluarga->tanggal_lahir = $request->tanggal_lahir;
            $anggotaKeluarga->status = $request->status;
            $anggotaKeluarga->pendidikan = $request->pendidikan;
            $anggotaKeluarga->jenis_pekerjaan = $request->jenis_pekerjaan;
            $anggotaKeluarga->agama = $request->agama;
            $anggotaKeluarga->status_perkawinan = $request->status_perkawinan;
            $anggotaKeluarga->save();

            return $anggotaKeluarga->with(["alamat", "penduduk"])->find($anggotaKeluarga->nik);
        });

        return Response::success($result);
    }

    public function destroy(AnggotaKeluarga $anggotaKeluarga, Request $request)
    {
        if (!$this->isPatriach($request)) return Response::message("Akses Ditolak", 403);

        // validasi jika yang dihapus adalah nik kepala keluarga
        $kk = KK::find($request->no_kk);
        if ($kk->nik_kepala_keluarga === $anggotaKeluarga->nik) {
            return Response::message("Tidak dapat menghapus kepala keluarga, silakan ganti kepala keluarga terlebih dahulu.", 400);
        }

        $result = DB::transaction(function () use ($kk, $anggotaKeluarga) {
            // kurangi jumlah keluarga
            $kk->jumlah_keluarga -= 1;
            $kk->save();
            return $anggotaKeluarga->delete();
        });

        return $result ? Response::message("Berhasil Menghapus Data Keluarga.", 200) : Response::message("Gagal Menghapus", 200);
    }

    public function imageKK(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "token_access"  => "required|string",
            "image_name"    => "required|string"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        return response()->download("penduduk/kk/{$request->image_name}");
    }
}
