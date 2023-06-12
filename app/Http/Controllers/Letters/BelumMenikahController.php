<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\LetterController;
use App\Http\Res\Response;
use App\Models\Letters\BelumMenikah;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BelumMenikahController extends LetterController
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "surat_pengantar"   => [
                "required",
                Rule::file()->types(["pdf"])->max(2048)
            ],
            "keperluan"         => "required|string",
            "keterangan"        => "required|string"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $surat_pengantar = $request->file("surat_pengantar")->store("letters");

        $result = DB::transaction(function () use ($request, $surat_pengantar) {
            $keterangan = "Berdasarkan surat pengantar {$request->keterangan} dan sepengetahuan kami. Bahwa yang namanya tersebut diatas adalah benar Belum Menikah yang beralamat sebagaimana tersebut di atas. Adapun surat keterangan ini dipergunakan untuk";

            $letter = new BelumMenikah;
            $letter->keperluan          = $request->keperluan;
            $letter->surat_pengantar    = $surat_pengantar;
            $letter->keterangan         = $keterangan;
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
            "keterangan"     => "required|string"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $letter = BelumMenikah::where("surat_id", $surat->id)->first();
        $letter->keperluan = $request->keperluan;
        $letter->keterangan = $request->keterangan;
        $letter->save();

        return $letter;
    }

    public function detail($surat_id)
    {
        return BelumMenikah::with(["surat", "surat.info", "surat.pemohon", "surat.pemohon.alamat"])->where("surat_id", $surat_id)->first();
    }
}
