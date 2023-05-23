<?php

namespace App\Http\Controllers;

use App\Http\Res\Response;
use App\Models\KK;

class KKController extends Controller
{
    public function index()
    {
        $dataKK = KK::with("kepalaKeluarga")->get();
        return Response::success($dataKK->toArray());
    }
}
