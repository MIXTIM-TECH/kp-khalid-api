<?php

namespace App\Http\Res;

class Api
{
    public static function success($data): array
    {
        return [
            "ok"    => true,
            "data"  => $data
        ];
    }

    public static function fail(string $message): array
    {
        return [
            "ok"        => false,
            "message"   => $message
        ];
    }

    public static function errors($errors): array
    {
        return [
            "ok"        => false,
            "errors"    => $errors
        ];
    }
}
