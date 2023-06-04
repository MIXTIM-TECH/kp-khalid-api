<?php

namespace App\Http\Controllers;

use App\Http\Res\Response;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssetController extends Controller
{
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "token"     => "required|string",
            "file"      => "required|string"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        try {
            $payload = JWT::decode($request->token, new Key(env("JWT_SECRET"), "HS256"));
            $request->user = $payload;

            return response()->download($request->file);
        } catch (Exception $e) {
            return Response::message($e->getMessage());
        }
    }
}
