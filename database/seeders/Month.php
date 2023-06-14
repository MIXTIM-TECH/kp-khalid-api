<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Month extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("months")->insert([
            ['month' => 'Januari', 'month_number' => 1],
            ['month' => 'Februari', 'month_number' => 2],
            ['month' => 'Maret', 'month_number' => 3],
            ['month' => 'April', 'month_number' => 4],
            ['month' => 'Mei', 'month_number' => 5],
            ['month' => 'Juni', 'month_number' => 6],
            ['month' => 'Juli', 'month_number' => 7],
            ['month' => 'Agustus', 'month_number' => 8],
            ['month' => 'September', 'month_number' => 9],
            ['month' => 'Oktober', 'month_number' => 10],
            ['month' => 'November', 'month_number' => 11],
            ['month' => 'Desember', 'month_number' => 12]
        ]);
    }
}
