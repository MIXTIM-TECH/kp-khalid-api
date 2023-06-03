<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\Controller;
use App\Http\Res\Response;
use App\Models\Skck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class SkckController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nik"               => "required|exists:anggota_keluarga,nik",
            "surat_pengantar"   => [
                "required",
                File::types(["pdf"])->max(2048)
            ],
            "keperluan"         => "required|string"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $surat_pengantar = $request->file("surat_pengantar")->store("letters");

        $letter = new Skck;
        $letter->pemohon = $request->nik;
        $letter->keperluan = $request->keperluan;
        $letter->surat_pengantar = $surat_pengantar;
        $letter->save();

        return Response::success($letter);
    }
}
