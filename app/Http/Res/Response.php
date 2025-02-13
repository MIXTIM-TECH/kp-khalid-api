<?php

namespace App\Http\Res;

use Illuminate\Validation\Validator;

class Response
{
    public static function success($data, $status = 200)
    {
        return response()->json($data, $status);
    }

    public static function errors(Validator $validator, $status = 400)
    {
        return response()->json($validator->errors(), $status);
    }

    public static function message(string $message, int $status = 500)
    {
        return response()->json(["message" => $message], $status);
    }
}
