<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CredentialController;
use App\Http\Controllers\ManagenemtFamilyController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Auth;
use App\Http\Middleware\Patriach;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// TODO: Admin
Route::middleware([Auth::class, Admin::class])->group(function () {
    Route::controller(CredentialController::class)->group(function () {
        Route::get("/data-pendaftar", "pendaftar");
        Route::get("/data-pendaftar-kadaluarsa", "pendaftarKadaluarsa");
        Route::patch("/pendaftar/{userCredential}/aktivasi", "activation");
        Route::patch("/pendaftar/{userCredential}/tolak", "reject");
    });
});

// TODO: User
Route::middleware([Auth::class, Patriach::class])->group(function () {
    Route::controller(ManagenemtFamilyController::class)->group(function () {
        Route::get("/anggota-keluarga/{kk}", "index");
        Route::get("/anggota-keluarga/{kk}/{anggotaKeluarga}", "show");
        Route::post("/anggota-keluarga/{kk}", "create");
        Route::put("/anggota-keluarga/{kk}/{anggotaKeluarga}", "update");
        Route::delete("/anggota-keluarga/{kk}/{anggotaKeluarga}", "destroy");
    });
});

// TODO: Public
Route::controller(AuthController::class)->group(function () {
    Route::post("/register", "register");
    Route::post("/login", "login");
    Route::post("/refresh-token", "refreshToken");
});
