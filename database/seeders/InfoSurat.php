<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfoSurat extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("info_surat")->insert([
            ["jenis_surat" => "Skck"],
            ["jenis_surat" => "Sktm"],
            ["jenis_surat" => "PengantarPernikahan"],
            ["jenis_surat" => "Domisili"],
            ["jenis_surat" => "BelumMenikah"],
            ["jenis_surat" => "KeteranganUsaha"]
        ]);
    }
}
