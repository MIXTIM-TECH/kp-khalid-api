<?php

namespace App\Http\Controllers;

use App\Models\KK;

class KKController extends Controller
{
    public function index()
    {
        return $this->responseSuccess(KK::with("kepalaKeluarga")->get());
    }
}
