<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\LetterController;
use App\Http\Res\Response;
use App\Models\Letters\PengantarPernikahan;
use App\Models\OrangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PengantarPernikahanController extends LetterController
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "alamat_pernikahan"         => "required|string",
            "tempat_lahir"              => "required|string",
            "tanggal_lahir"             => "required|date_format:Y-m-d",
            "nama_ayah"                 => "required|string",
            "nama_ibu"                  => "required|string",
            "agama_ayah"                => [
                "required",
                Rule::in(["Islam", "Kristen Protestan", "Katolik", "Hindu", "Buddha", "Kong Hu Cu"])
            ],
            "agama_ibu"                 => [
                "required",
                Rule::in(["Islam", "Kristen Protestan", "Katolik", "Hindu", "Buddha", "Kong Hu Cu"])
            ],
            "alamat_ayah"               => "required|string",
            "alamat_ibu"                => "required|string",
            "status_perkawinan_ayah"    => "required|string",
            "status_perkawinan_ibu"     => "required|string",
            "pendidikan_ayah"           => "required|string",
            "pendidikan_ibu"            => "required|string",
            "nik_ayah"                  => "required|string|max:16|min:16",
            "nik_ibu"                   => "required|string|max:16|min:16",
            "tempat_lahir_ayah"         => "required|string",
            "tempat_lahir_ibu"          => "required|string",
            "tanggal_lahir_ayah"        => "required|date_format:Y-m-d",
            "tanggal_lahir_ibu"         => "required|date_format:Y-m-d",
            "pekerjaan_ayah"            => "required|string",
            "pekerjaan_ibu"             => "required|string"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        DB::transaction(function () {
            $ayah = new OrangTua;
            // 
            $ayah->save();

            $ibu = new OrangTua;
            // 
            $ibu->save();

            $letter = new PengantarPernikahan;
            // 
            $letter->save();
        });
    }

    public function detail($surat_id)
    {
        return PengantarPernikahan::where("surat_id", $surat_id)->first();
    }
}
