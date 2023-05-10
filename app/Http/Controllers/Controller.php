<?php

namespace App\Http\Controllers;

use App\Http\Res\Api;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function checkValidator(\Illuminate\Validation\Validator $validator)
    {
        return ($validator->fails()) ? response()->json(Api::errors($validator->errors()), 400) : true;
    }

    protected function responseSuccess($data)
    {
        return response()->json(Api::success($data));
    }

    protected function responseNotFound(string $message)
    {
        return response()->json(Api::fail($message), 404);
    }

    protected function responseUnauthorize(string $message)
    {
        return response()->json(Api::fail($message), 403);
    }

    protected function unknownResponse(string $message, $status = 500)
    {
        return response()->json(Api::fail($message, $status));
    }
}
