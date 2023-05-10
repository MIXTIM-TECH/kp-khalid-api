<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CredentialController;
use App\Http\Controllers\ManagenemtFamilyController;
use App\Http\Middleware\Auth;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(Auth::class)->group(function () {
    Route::controller(ManagenemtFamilyController::class)->group(function () {
        Route::get("/anggota-keluarga", "index");
        Route::post("/anggota-keluarga", "create");
    });

    Route::controller(CredentialController::class)->group(function () {
        Route::get("/data-pendaftar", "pendaftar");
        Route::get("/data-pendaftar-kadaluarsa", "pendaftarKadaluarsa");
        Route::patch("/pendaftar/update-status/{userCredential}", "activation");
    });
});

Route::controller(AuthController::class)->group(function () {
    Route::post("/register", "register");
    Route::post("/login", "login");
    Route::post("/refresh-token", "refreshToken");
});
