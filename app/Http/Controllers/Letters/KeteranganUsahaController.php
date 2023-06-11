<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\LetterController;
use App\Http\Res\Response;
use App\Models\AnggotaKeluarga;
use App\Models\InfoSurat;
use App\Models\KK;
use App\Models\Letters\KeteranganUsaha;
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

    public function detail($surat_id)
    {
        return KeteranganUsaha::where("surat_id", $surat_id)->first();
    }
}
