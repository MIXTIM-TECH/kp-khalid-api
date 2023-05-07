<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "username"      => "string|required",
            "password"      => "string|required|min:8",
            "no_kk"         => "string|unique:kk,no_kk",
            "foto_kk"       => [
                "required",
                File::image()->max(2048)
            ]
        ]);
    }
}
