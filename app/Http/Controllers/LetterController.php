<?php

namespace App\Http\Controllers;

use App\Http\Res\Response;
use App\Models\AnggotaKeluarga;
use App\Models\InfoSurat;
use App\Models\Letters\BelumMenikah;
use App\Models\Letters\Domisili;
use App\Models\Letters\KeteranganUsaha;
use App\Models\Letters\PengantarPernikahan;
use App\Models\Letters\Skck;
use App\Models\Letters\Sktm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LetterController extends Controller
{
    public function index(Request $request)
    {
        // $skck = Skck::all();
        // $skbm = BelumMenikah::all();
        // $domisili = Domisili::all();
        // $sktm = Sktm::all();
        // $sku = KeteranganUsaha::all();
        // $spp = PengantarPernikahan::all();

        // $letters = [
        //     "skck"          => $skck,
        //     "skbm"          => $skbm,
        //     "domisili"      => $domisili,
        //     "sktm"          => $sktm,
        //     "sku"           => $sku,
        //     "spp"           => $spp
        // ];

        // if ($request->user->role === "admin" || $request->user->role === "super_admin") {
        //     if ($request->no_kk) {
        //         // 
        //     }

        //     return Response::success($letters);
        // }

        // $newLetters = [];
        // foreach ($letters as $key => $letter) {
        //     array_push($newLetters, [$key => $letter->where("no_kk", $request->user->no_kk)]);
        // }

        // return Response::success($newLetters);
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

        $controller = $request->letter_type . "Controller";
        return app()->call("\App\Http\Controllers\Letters\\" . $controller . "@create");
    }
}
