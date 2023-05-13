<?php

namespace App\Http\Middleware;

use App\Http\Res\Api;
use Closure;
use Illuminate\Http\Request;

class SuperAdmin
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
        if ($request->user->role !== "super_admin")
            return response()->json(Api::fail("Only Super Admin Can Access"), 403);

        return $next($request);
    }
}
