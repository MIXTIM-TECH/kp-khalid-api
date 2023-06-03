<?php

namespace App\Http\Middleware;

use App\Http\Res\Response;
use App\Models\KK;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Patriach
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
        $validator = Validator::make($request->all(), [
            "no_kk"     => "required|exists:kk,no_kk"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $kk = KK::find($request->no_kk);
        $request->kk = $kk;

        if ($request->user->role !== "user") return $next($request);
        if ($kk->nik_kepala_keluarga !== $request->user->username) return Response::message("Akses Ditolak", 403);

        return $next($request);
    }
}
