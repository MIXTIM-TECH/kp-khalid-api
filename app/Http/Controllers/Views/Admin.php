<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\Controller;

class Admin extends Controller
{
    public function index()
    {
        $data = [
            "sidebar"       => [
                "name"      => "Admin"
            ]
        ];

        return view("pages.dashboard", $data);
    }

    public function ubahProfile()
    {
        return view("pages.admin.ubah-profile");
    }

    public function pendaftar()
    {
        return view("pages.admin.pendaftar");
    }

    public function detailPendaftar($nik)
    {
        return view("pages.admin.detail-pendaftar", ["nik" => $nik]);
    }

    public function pendaftarKadaluarsa()
    {
        return view("pages.admin.pendaftar-kadaluarsa");
    }

    public function pendaftarDitolak()
    {
        return view("pages.admin.pendaftar-ditolak");
    }

    public function keluarga()
    {
        return view("pages.admin.keluarga");
    }

    public function detailKeluarga($noKK)
    {
        return view("pages.admin.detail-keluarga", ["noKK" => $noKK]);
    }

    public function pengajuanSurat()
    {
        return view("pages.admin.pengajuan-surat");
    }

    public function detailPengajuanSurat()
    {
        return view("pages.admin.detail-pengajuan-surat");
    }
}
