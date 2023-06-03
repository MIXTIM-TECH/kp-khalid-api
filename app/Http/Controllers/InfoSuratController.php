<?php

namespace App\Http\Controllers;

use App\Http\Res\Response;
use App\Models\InfoSurat;

class InfoSuratController extends Controller
{
    public function index()
    {
        return Response::success(InfoSurat::all());
    }
}
