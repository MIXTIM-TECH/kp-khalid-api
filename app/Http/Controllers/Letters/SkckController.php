<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\LetterController;
use App\Http\Res\Response;
use App\Models\AnggotaKeluarga;
use App\Models\InfoSurat;
use App\Models\KK;
use App\Models\Letters\Skck;
use App\Models\OrangTua;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SkckController extends LetterController
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "surat_pengantar"   => [
                "required",
                Rule::file()->types(["pdf"])->max(2048)
            ],
            "keperluan"         => "required|string",
            "keterangan"        => "required|string",
            "nama_ayah"         => "required|string",
            "nama_ibu"          => "required|string",
            "agama"             => [
                "required",
                Rule::in(["Islam", "Kristen Protestan", "Katolik", "Hindu", "Buddha", "Kong Hu Cu"])
            ],
            "alamat"            => "required|string"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $surat_pengantar = $request->file("surat_pengantar")->store("letters");

        $result = DB::transaction(function () use ($request, $surat_pengantar) {
            $ayah = new OrangTua;
            $ibu = new OrangTua;
            $ayah->nama_lengkap = $request->nama_ayah;
            $ibu->nama_lengkap = $request->nama_ibu;
            $ayah->agama = $request->agama;
            $ibu->agama = $request->agama;
            $ayah->alamat = $request->alamat;
            $ibu->alamat = $request->alamat;
            $ayah->save();
            $ibu->save();

            $keterangan = "Berdasarkan surat pengantar {$request->keterangan} dan sepanjang pengetahuan kami yang bersangkutan belum pernah terlibat kriminalitas dan berkelakuan baik.";

            $letter = new Skck;
            $letter->surat_pengantar    = $surat_pengantar;
            $letter->keperluan          = $request->keperluan;
            $letter->keterangan         = $keterangan;
            $letter->id_ayah            = $ayah->id;
            $letter->id_ibu             = $ibu->id;
            $letter->surat_id = $this->addSurat($request);
            $letter->save();

            $this->addJumlahSurat();
            $this->addJumlahSuratDiajukan();

            return $letter;
        });

        return Response::success($result);
    }

    public function update(Request $request, Surat $surat)
    {
        $validator = Validator::make($request->all(), [
            "keperluan"         => "required|string",
            "keterangan"        => "required|string",
            "nama_ayah"         => "required|string",
            "nama_ibu"          => "required|string",
            "agama"             => [
                "required",
                Rule::in(["Islam", "Kristen Protestan", "Katolik", "Hindu", "Buddha", "Kong Hu Cu"])
            ],
            "alamat"            => "required|string"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $result = DB::transaction(function () use ($request, $surat) {
            $letter = Skck::where("surat_id", $surat->id)->first();
            $letter->keperluan          = $request->keperluan;
            $letter->keterangan         = $request->keterangan;
            $letter->save();

            $ayah = OrangTua::find($letter->id_ayah);
            $ibu = OrangTua::find($letter->id_ibu);
            $ayah->nama_lengkap = $request->nama_ayah;
            $ibu->nama_lengkap = $request->nama_ibu;
            $ayah->agama = $request->agama;
            $ibu->agama = $request->agama;
            $ayah->alamat = $request->alamat;
            $ibu->alamat = $request->alamat;
            $ayah->save();
            $ibu->save();

            return $letter;
        });

        return Response::success($result);
    }

    public function detail($surat_id)
    {
        return Skck::with(["surat", "surat.info", "surat.pemohon", "ayah", "ibu", "surat.pemohon.alamat"])->where("surat_id", $surat_id)->first();
    }
}
