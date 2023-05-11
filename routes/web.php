<?php

use App\Http\Controllers\Views\Admin;
use App\Http\Controllers\Views\Root;
use App\Http\Controllers\Views\SuperAdmin;
use App\Http\Controllers\Views\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(Root::class)->group(function () {
    Route::get("/", "index"); // landing page
});

Route::controller(User::class)->group(function () {
    $routes = [
        "dashboard"                 => "index",
        "keluarga"                  => "keluarga",
        "keluarga/{nik}"            => "detailKeluarga",
        "ajukan-surat"              => "ajukanSurat",
        "profile/setting"           => "settingProfile"
        // any route
    ];

    foreach ($routes as $route => $method) {
        Route::get("user/$route", $method);
    }
});

$routesAdmin = [
    "dashboard"                 => "index",
    "ubah-profile"              => "ubahProfile",
    "pendaftar"                 => "pendaftar",
    "pendaftar/{nik}"           => "detailPendaftar",
    "pendaftar/kadaluarsa"      => "pendaftarKadaluarsa",
    "pendaftar/ditolak"         => "pendaftarDitolak",
    "keluarga"                  => "keluarga",
    "keluarga/{noKK}"           => "detailKeluarga",
    "surat/pengajuan"           => "pengajuanSurat",
    "surat/pengajuan/{nik}"     => "detailPengajuanSurat"
];

Route::controller(Admin::class)->group(function () use ($routesAdmin) {
    foreach ($routesAdmin as $route => $method) {
        Route::get("admin/$route", $method);
        Route::get("super-admin/$route", $method);
    }
});

Route::controller(SuperAdmin::class)->group(function () use ($routesAdmin) {
    $routes = [
        "admin"         => "admin"
        // any route
    ];

    foreach ($routes as $route => $method) {
        Route::get("super-admin/$route", $method);
    }
});
