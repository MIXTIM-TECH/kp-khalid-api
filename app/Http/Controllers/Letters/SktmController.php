<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\LetterController;
use App\Http\Res\Response;
use App\Models\AnggotaKeluarga;
use App\Models\InfoSurat;
use App\Models\KK;
use App\Models\Letters\Sktm;
use App\Models\OrangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SktmController extends LetterController
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama_orang_tua"                => "required|string",
            "jenis_kelamin_orang_tua"       => [
                "required",
                Rule::in(["P", "L"])
            ],
            "tempat_lahir_orang_tua"        => "required|string",
            "tanggal_lahir_orang_tua"       => "required|date_format:Y-m-d",
            "pekerjaan_orang_tua"           => "required|string",
            "status_perkawinan"             => "required|string",
            "pendidikan_orang_tua"          => "required|string",
            "nik_orang_tua"                 => "required|string|max:16",
            "alamat_orang_tua"              => "required|string",
            "surat_pengantar"               => [
                "required",
                Rule::file()->types(["pdf"])->max(2048)
            ],
            "keperluan"                     => "required|string",
            "keterangan"                    => "required|string",
            "pendidikan"                    => "required|string"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $surat_pengantar = $request->file("surat_pengantar")->store("letters");

        $result = DB::transaction(function () use ($request, $surat_pengantar) {
            $parent = new OrangTua;
            $parent->nama_lengkap = $request->nama_orang_tua;
            $parent->jenis_kelamin = $request->jenis_kelamin_orang_tua;
            $parent->tempat_lahir = $request->tempat_lahir_orang_tua;
            $parent->tanggal_lahir = $request->tanggal_lahir_orang_tua;
            $parent->pekerjaan = $request->pekerjaan_orang_tua;
            $parent->status_perkawinan = $request->status_perkawinan;
            $parent->pendidikan = $request->pendidikan_orang_tua;
            $parent->nik = $request->nik_orang_tua;
            $parent->alamat = $request->alamat_orang_tua;
            $parent->save();

            $keperluan = "Adapun  surat  keterangan  ini  dipergunakan  untuk {$request->keperluan}.  Demikianlah surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan seperlunya.";
            $keterangan = "Berdasarkan surat dari {$request->keterangan}, memang benar yang namanya tersebut diatas adalah warga  Kelurahan Jembatan Kecil yang berdomisili pada alamat tersebut dan benar keluarga tidak mampu yang mempunyai anak";

            $letter = new Sktm;
            $letter->id_orang_tua = $parent->id;
            $letter->surat_pengantar = $surat_pengantar;
            $letter->keperluan = $keperluan;
            $letter->keterangan = $keterangan;
            $letter->pendidikan = $request->pendidikan;
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
        return Sktm::with(["surat", "surat.info", "surat.pemohon", "orangTua"])->where("surat_id", $surat_id)->first();
    }
}
