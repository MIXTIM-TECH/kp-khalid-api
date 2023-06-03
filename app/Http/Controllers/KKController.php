<?php

namespace App\Http\Controllers;

use App\Http\Res\Response;
use App\Models\KK;
use Illuminate\Http\Request;

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
}
