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

        DB::transaction(function () use ($request) {
            $ayah = new OrangTua;
            $ayah->nama_lengkap = $request->nama_ayah;
            $ayah->agama = $request->agama_ayah;
            $ayah->alamat = $request->alamat_ayah;
            $ayah->jenis_kelamin = "L";
            $ayah->status_perkawinan = $request->status_perkawinan_ayah;
            $ayah->pendidikan = $request->pendidikan_ayah;
            $ayah->nik = $request->nik_ayah;
            $ayah->tempat_lahir = $request->tempat_lahir_ayah;
            $ayah->tanggal_lahir = $request->tanggal_lahir_ayah;
            $ayah->pekerjaan = $request->pekerjaan_ayah;
            $ayah->save();

            $ibu = new OrangTua;
            $ibu->nama_lengkap = $request->nama_ibu;
            $ibu->agama = $request->agama_ibu;
            $ibu->alamat = $request->alamat_ibu;
            $ibu->jenis_kelamin = "P";
            $ibu->status_perkawinan = $request->status_perkawinan_ibu;
            $ibu->pendidikan = $request->pendidikan_ibu;
            $ibu->nik = $request->nik_ibu;
            $ibu->tempat_lahir = $request->tempat_lahir_ibu;
            $ibu->tanggal_lahir = $request->tanggal_lahir_ibu;
            $ibu->pekerjaan = $request->pekerjaan_ibu;
            $ibu->save();

            $letter = new PengantarPernikahan;
            $letter->surat_id = $this->addSurat($request);
            $letter->alamat_pernikahan = $request->alamat_pernikahan;
            $letter->tempat_lahir = $request->tempat_lahir;
            $letter->tanggal_lahir = $request->tanggal_lahir;
            $letter->id_ayah = $ayah->id;
            $letter->id_ibu = $request->id;
            $letter->save();

            $this->addJumlahSurat();
            $this->addJumlahSuratDiajukan();
        });
    }

    public function detail($surat_id)
    {
        return PengantarPernikahan::with(["surat", "surat.info", "surat.pemohon", "ayah", "ibu", "surat.pemohon.alamat"])
            ->where("surat_id", $surat_id)->first();
    }
}
