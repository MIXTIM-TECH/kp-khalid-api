<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\Controller;
use App\Http\Res\Response;
use App\Models\AnggotaKeluarga;
use App\Models\InfoSurat;
use App\Models\KK;
use App\Models\Letters\Skck;
use App\Models\OrangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SkckController extends Controller
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
            $letter->pemohon            = $request->nik;
            $letter->surat_pengantar    = $surat_pengantar;
            $letter->keperluan          = $request->keperluan;
            $letter->keterangan         = $keterangan;
            $letter->id_ayah            = $ayah->id;
            $letter->id_ibu             = $ibu->id;
            $letter->save();

            $infoSurat = InfoSurat::where("jenis_surat", "Skck")->first();
            $infoSurat->jumlah_surat += 1;
            $infoSurat->save();

            $pemohon = AnggotaKeluarga::find($request->nik);
            $kk = KK::find($pemohon->no_kk);
            $kk->jumlah_surat_diajukan += 1;
            $kk->save();

            $letter->no_kk = $kk->no_kk;
            $letter->save();

            return $letter;
        });

        return Response::success($result);
    }
}
