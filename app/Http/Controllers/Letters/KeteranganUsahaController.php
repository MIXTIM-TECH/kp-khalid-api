<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\LetterController;
use App\Http\Res\Response;
use App\Models\Letters\KeteranganUsaha;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KeteranganUsahaController extends LetterController
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "keperluan"        => "required|string",
            "nama_usaha"        => "required|string",
            "alamat_usaha"      => "required|string"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $result = DB::transaction(function () use ($request) {
            $nama_usaha = "Berdasarkan keterangan yang bersangkutan dan sepengetahuan kami, bahwa yang namanya tersebut diatas adalah benar mempunyai usaha {$request->nama_usaha} yang";
            $alamat_usaha = "beralamat di {$request->alamat_usaha}";
            $keperluan = "Adapun surat keterangan ini dipergunakan untuk {$request->keperluan}";

            $letter = new KeteranganUsaha;
            $letter->keperluan = $keperluan;
            $letter->nama_usaha = $nama_usaha;
            $letter->alamat_usaha = $alamat_usaha;
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
            "keperluan"     => "required|string",
            "nama_usaha"     => "required|string",
            "alamat_usaha"  => "required|string"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $letter = KeteranganUsaha::where("surat_id", $surat->id)->first();
        $letter->keperluan = $request->keperluan;
        $letter->nama_usaha = $request->nama_usaha;
        $letter->alamat_usaha = $request->alamat_usaha;
        $letter->save();

        return $letter;
    }

    public function detail($surat_id)
    {
        return KeteranganUsaha::with(["surat", "surat.info", "surat.pemohon", "surat.pemohon.alamat"])->where("surat_id", $surat_id)->first();
    }
}
