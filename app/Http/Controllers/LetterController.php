<?php

namespace App\Http\Controllers;

use App\Http\Res\Response;
use App\Models\AnggotaKeluarga;
use App\Models\InfoSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LetterController extends Controller
{
    public function index()
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

        $pemohon = AnggotaKeluarga::with("alamat")->find($request->nik);
        $isDataIssetNull = array_search(null, (array) $pemohon);
        $isAlamatIssetNull = array_search(null, (array) $pemohon->alamat);
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
