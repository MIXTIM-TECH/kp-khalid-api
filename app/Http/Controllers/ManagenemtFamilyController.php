<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManagenemtFamilyController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = require_once(app_path("Http/Req/ValidationRules.php"));
    }

    public function index()
    {
        return $this->responseSuccess(AnggotaKeluarga::all());
    }

    public function create(Request $request)
    {
        $validationResult = $this->checkValidator(Validator::make($request->all(), [
            "nik"           => $this->rules["nik"],
            "no_kk"         => "required|exists:kk,no_kk",
            "no_whatsapp"   => "max:20"
        ]));

        if ($validationResult !== true) return $validationResult;

        // validasi kepala keluarga

        // tambah anggota keluarga

        // update jumlah keluarga (table kk)

        // tambah data penduduk
    }
}
