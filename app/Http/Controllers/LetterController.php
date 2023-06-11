<?php

namespace App\Http\Controllers;

use App\Http\Res\Response;
use App\Models\AnggotaKeluarga;
use App\Models\InfoSurat;
use App\Models\KK;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LetterController extends Controller
{
    protected static $kk, $infoSurat;

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

    public function index(Request $request)
    {
        $result = Surat::with("info");
        if ($request->user->role === "user") {
            $result = $result->where("no_kk", $request->user->no_kk);
        }

        $result = (new Filters($result, $request))->search("pemohon")->result();
        return Response::success($result->get());
    }

    public function show(Surat $surat)
    {
        return Surat::with(["info", "pemohon"])->find($surat->id);
    }

    public function showByJenisSurat($jenisSurat, Surat $surat)
    {
        $validator = Validator::make(["jenis_surat" => $jenisSurat], [
            "jenis_surat"   => "exists:info_surat,jenis_surat"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        return app()->call("\App\Http\Controllers\Letters\\" . $jenisSurat . "@detail", [
            "surat_id" => $surat->id
        ]);
    }

    public function letterInfo()
    {
        return Response::success(InfoSurat::all());
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

    public function update()
    {
        // -
    }

    public function destroy(Surat $surat)
    {
        return $surat->delete() ? Response::message("Berhasil Menghapus Surat", 200) : Response::message("Gagal Menghapus");
    }
}
