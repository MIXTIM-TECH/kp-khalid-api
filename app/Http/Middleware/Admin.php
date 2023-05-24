<?php

namespace App\Http\Middleware;

use App\Http\Res\Response;
use Closure;
use Illuminate\Http\Request;

class Admin
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
        $role = $request->user->role;
        if ($role !== "admin" && $role !== "super_admin") {
            return Response::message("Hanya Admin yang Dapat Mengakses", 403);
        }

        return $next($request);
    }
}
