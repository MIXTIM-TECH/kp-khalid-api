<?php

namespace Database\Seeders;

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
            [
                "jenis_surat"   => "Skck",
                "nama"          => "Surat Keterangan Catatan Kriminal"
            ],
            [
                "jenis_surat"   => "Sktm",
                "nama"          => "Surat Keterangan Tidak Mampu"
            ],
            [
                "jenis_surat"   => "PengantarPernikahan",
                "nama"          => "Surat Pengantar Pernikahan"
            ],
            [
                "jenis_surat"   => "Domisili",
                "nama"          => "Surat Keterangan Domisili"
            ],
            [
                "jenis_surat"   => "BelumMenikah",
                "nama"          => "Surat Keterangan Belum Menikah"
            ],
            [
                "jenis_surat"   => "KeteranganUsaha",
                "nama"          => "Surat Keterangan Usaha"
            ]
        ]);
    }
}
