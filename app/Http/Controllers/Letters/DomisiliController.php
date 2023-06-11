<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\LetterController;
use App\Http\Res\Response;
use App\Models\AnggotaKeluarga;
use App\Models\InfoSurat;
use App\Models\KK;
use App\Models\Letters\Domisili;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DomisiliController extends LetterController
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "surat_pengantar"   => [
                "required",
                Rule::file()->types(["pdf"])->max(2048)
            ],
            "keperluan"         => "required|string",
            "keterangan"         => "required|string",
            "pendidikan"         => "required|string",
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $surat_pengantar = $request->file("surat_pengantar")->store("letters");

        $result = DB::transaction(function () use ($request, $surat_pengantar) {
            $keterangan = "Berdasarkan Surat Pengantar {$request->keterangan}, orang yang namanya tersebut di atas memang  benar  berdomisili/bertempat  tinggal  pada alamat sebagaimana tersebut di atas.";
            $keperluan = "Adapun Surat Keterangan Domisili ini dipergunakan untuk {$request->keperluan}";

            $letter = new Domisili;
            $letter->surat_pengantar = $surat_pengantar;
            $letter->keperluan      = $keperluan;
            $letter->keterangan     = $keterangan;
            $letter->pendidikan     = $request->pendidikan;
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
        return Domisili::where("surat_id", $surat_id)->first();
    }
}
