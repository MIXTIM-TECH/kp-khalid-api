<?php

namespace App\Http\Controllers;

use App\Http\Res\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LetterController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "letter_type"   => "required|exists:info_surat,jenis_surat"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $controller = $request->letter_type . "Controller";
        return app()->call("\App\Http\Controllers\Letters\\" . $controller . "@create");
    }
}
