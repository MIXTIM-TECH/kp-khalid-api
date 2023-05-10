<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperAdminAccount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("credentials")->insert([
            "username"  => "polandu-jk",
            "password"  => password_hash("[.';asdpolandu-jk", PASSWORD_DEFAULT),
            "role"      => "super_admin",
            "status"    => true
        ]);
    }
}
