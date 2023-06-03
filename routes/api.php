<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CredentialController;
use App\Http\Controllers\InfoSuratController;
use App\Http\Controllers\KKController;
use App\Http\Controllers\ManagementFamilyController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Auth;
use App\Http\Middleware\Patriach;
use App\Http\Middleware\SuperAdmin;
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

Route::middleware(Auth::class)->group(function () {
    // TODO: Super Admin
    Route::middleware(SuperAdmin::class)->controller(CredentialController::class)->group(function () {
        Route::get("/admin", "admin");
        Route::post("/admin", "createAdmin");
        Route::delete("/admin/{admin}", "destroyAdmin");
    });

    // TODO: Admin
    Route::middleware(Admin::class)->group(function () {
        Route::controller(CredentialController::class)->group(function () {
            Route::get("/data-pendaftar", "pendaftar");
            Route::get("/data-pendaftar-kadaluarsa", "pendaftarKadaluarsa");
            Route::get("/data-pendaftar-ditolak", "pendaftarDitolak");
            Route::patch("/pendaftar/{userCredential}/aktivasi", "activation");
            Route::patch("/pendaftar/{userCredential}/tolak", "reject");
        });

        Route::controller(KKController::class)->group(function () {
            Route::get("/data-keluarga", "index");
            Route::get("/data-keluarga/{kk}", "show");
        });
    });

    // Todo: Admin & User
    Route::controller(KKController::class)->middleware(Patriach::class)->group(function () {
        Route::get("/data-keluarga/{kk}", "show");
    });

    Route::controller(InfoSuratController::class)->group(function () {
        Route::get("/info-surat", "index");
    });

    // TODO: User
    Route::controller(ManagementFamilyController::class)->middleware(Patriach::class)->group(function () {
        Route::get("/anggota-keluarga", "index");
        Route::get("/anggota-keluarga/{anggotaKeluarga}", "show");
        Route::post("/anggota-keluarga", "create");
        Route::put("/anggota-keluarga/{kk}/{anggotaKeluarga}", "update");
        Route::delete("/anggota-keluarga/{anggotaKeluarga}", "destroy");
    });
});


// TODO: Get KK Image
Route::get("/kk/image", [ManagementFamilyController::class  => "imageKK"]);


// TODO: Public
Route::controller(AuthController::class)->group(function () {
    Route::post("/register", "register");
    Route::post("/login", "login");
    Route::post("/refresh-token", "refreshToken");
});
