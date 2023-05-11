<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\Controller;

class Root extends Controller
{
    public function index()
    {
        $data = [
            "title"     => "Landing Page"
        ];

        return view("pages/landing-page", $data);
    }
}
