<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\Controller;
use App\Http\Res\Response;
use App\Models\AnggotaKeluarga;
use App\Models\InfoSurat;
use App\Models\KK;
use App\Models\Skck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class SkckController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "surat_pengantar"   => [
                "required",
                File::types(["pdf"])->max(2048)
            ],
            "keperluan"         => "required|string",
            "keterangan"        => "required|string"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $surat_pengantar = $request->file("surat_pengantar")->store("letters");

        $result = DB::transaction(function () use ($request, $surat_pengantar) {
            $letter = new Skck;
            $letter->pemohon = $request->nik;
            $letter->keperluan = $request->keperluan;
            $letter->surat_pengantar = $surat_pengantar;
            $letter->save();

            $infoSurat = InfoSurat::where("jenis_surat", "Skck")->first();
            $infoSurat->jumlah_surat += 1;
            $infoSurat->save();

            $pemohon = AnggotaKeluarga::find($request->nik);
            $kk = KK::find($pemohon->no_kk);
            $kk->jumlah_surat_diajukan += 1;

            return $letter;
        });

        return Response::success($result);
    }
}
