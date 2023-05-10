<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CredentialController;
use App\Http\Controllers\ManagenemtFamilyController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Auth;
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
        Route::patch("/pendaftar/update-status/{userCredential}", "activation");
    });
});

// TODO: User
Route::middleware(Auth::class)->group(function () {
    Route::controller(ManagenemtFamilyController::class)->group(function () {
        Route::get("/anggota-keluarga/{noKK}", "index");
        Route::post("/anggota-keluarga", "create");
        Route::put("/anggota-keluarga/{noKK}", "update");
        Route::delete("/anggota-keluarga/{kk}", "destroy");
    });
});

// TODO: Public
Route::controller(AuthController::class)->group(function () {
    Route::post("/register", "register");
    Route::post("/login", "login");
    Route::post("/refresh-token", "refreshToken");
});
