<?php

namespace App\Http\Controllers;

use App\Http\Res\Response;
use App\Models\Credential;
use App\Models\KK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KKController extends Controller
{
    public function index(Request $request)
    {
        $dataKK = KK::with("kepalaKeluarga");
        $dataKK = (new Filters($dataKK, $request))->search("kk.no_kk")->beforeDate()->afterDate()->result();
        return Response::success($dataKK->get()->toArray());
    }

    public function show($noKK)
    {
        return Response::success(KK::with(["anggotaKeluarga", "kepalaKeluarga"])->find($noKK));
    }

    public function fotoKK(KK $kk)
    {
        $base64File = base64_encode(Storage::disk("local")->get($kk->foto_kk));
        return Response::success(["data" => $base64File]);
    }

    public function destroy(KK $kk)
    {
        $credential = Credential::find($kk->nik_kepala_keluarga);
        $credential->delete();

        return $kk->delete() ? Response::message("Berhasil menghapus akun!", 200) : Response::message("Gagal menghapus akun!");
    }
}
