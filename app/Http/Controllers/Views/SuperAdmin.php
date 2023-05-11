<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\Controller;

class SuperAdmin extends Controller
{
    public function index()
    {
        $data = [
            "sidebar"       => [
                "name"      => "Super Admin"
            ]
        ];

        return view("pages.dashboard", $data);
    }

    public function admin()
    {
        return view("pages.super-admin.admin");
    }
}
