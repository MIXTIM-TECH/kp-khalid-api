<?php

namespace App\Http\Middleware;

use App\Http\Res\Api;
use App\Models\AnggotaKeluarga;
use Closure;
use Illuminate\Http\Request;

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
        if ($request->user->role !== "user") return $next($request);

        $failedResponse = response()->json(Api::fail("Akses Ditolak"), 403);

        // cek username dan nik_kepala_keluarga
        if ($request->user->username !== $request->kk->nik_kepala_keluarga) {
            return $failedResponse;
        }

        // cek no_kk dan nik_anggota_keluarga
        if ($request->anggotaKeluarga) {
            $anggotaKeluarga = AnggotaKeluarga::where("no_kk", $request->kk->no_kk)->where("nik", $request->anggotaKeluarga->nik)->first();
            if (!$anggotaKeluarga) return $failedResponse;
        }

        return $next($request);
    }
}
