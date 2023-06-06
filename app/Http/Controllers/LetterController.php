<?php

namespace App\Http\Controllers;

use App\Http\Res\Response;
use App\Models\AnggotaKeluarga;
use App\Models\InfoSurat;
use App\Models\KK;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LetterController extends Controller
{
    protected static $kk, $infoSurat;

    public function index(Request $request)
    {
        $result = DB::table("surat_info_surat")
            ->join("surat_ket_belum_menikah", "surat_id", "=", "surat_ket_belum_menikah.id", "left")
            ->join("surat_ket_domisili", "surat_id", "=", "surat_ket_domisili.id", "left")
            ->join("surat_ket_tidak_mampu", "surat_id", "=", "surat_ket_tidak_mampu.id", "left")
            ->join("surat_ket_usaha", "surat_id", "=", "surat_ket_usaha.id", "left")
            ->join("surat_skck", "surat_id", "=", "surat_skck.id", "left");

        return Response::success($result->get());
    }

    public function letterInfo()
    {
        return Response::success(InfoSurat::all());
    }

    protected function addJumlahSurat()
    {
        self::$infoSurat->jumlah_surat += 1;
        self::$infoSurat->save();
    }

    protected function addJumlahSuratDiajukan()
    {
        self::$kk->jumlah_surat_diajukan += 1;
        self::$kk->save();
    }

    protected function addSurat(Request $request)
    {
        $surat = new Surat;
        $surat->pemohon = $request->nik;
        $surat->no_kk = self::$kk->no_kk;
        $surat->info_id = self::$infoSurat->id;
        $surat->save();

        return $surat->id;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "letter_type"   => "required|exists:info_surat,jenis_surat",
            "nik"           => "required|exists:anggota_keluarga,nik"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $pemohon = AnggotaKeluarga::with("alamat")->find($request->nik)->toArray();
        $isDataIssetNull = array_search(null, $pemohon);
        $isAlamatIssetNull = array_search(null, $pemohon["alamat"]);

        if ($isDataIssetNull || $isAlamatIssetNull) return Response::success(["redirect" => [
            "path"      => "anggota-keluarga/{$request->nik}",
            "method"    => "PUT",
            "message"   => "Harap lengkapi data anda terlebih dahulu",
            "pemohon"   => $pemohon
        ]], 302);

        $pemohon = AnggotaKeluarga::find($request->nik);
        $infoSurat = InfoSurat::where("jenis_surat", $request->letter_type)->first();
        self::$kk = KK::find($pemohon->no_kk);
        self::$infoSurat = $infoSurat;

        $controller = $request->letter_type . "Controller";
        return app()->call("\App\Http\Controllers\Letters\\" . $controller . "@create");
    }
}
