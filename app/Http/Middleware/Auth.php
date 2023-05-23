<?php

namespace App\Http\Middleware;

use App\Http\Res\Response;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if (!$token) return Response::message("Dibutuhkan Token!", 401);

        try {
            $payload = JWT::decode($token, new Key(env("JWT_SECRET"), "HS256"));
            $request->user = $payload;
            return $next($request);
        } catch (Exception $e) {
            return Response::message($e->getMessage());
        }
    }
}
