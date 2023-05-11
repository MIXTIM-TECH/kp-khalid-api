<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;

class User extends Controller
{
    public function index()
    {
        $data = [
            "sidebar"       => [
                "name"      => "User"
            ]
        ];

        return view("pages.dashboard", $data);
    }

    public function keluarga()
    {
        return view("pages.user.anggota-keluarga");
    }

    public function detailKeluarga($nik)
    {
        return view("pages.user.detail-keluarga", ["nik" => $nik]);
    }

    public function ajukanSurat()
    {
        return view("pages.user.ajukan-surat");
    }

    public function settingProfile()
    {
        return view("pages.user.setting-profile");
    }
}
