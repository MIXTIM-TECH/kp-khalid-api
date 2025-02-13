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

Route::get("/{any}", function () {
    return view("root");
})->where("any", ".*");
