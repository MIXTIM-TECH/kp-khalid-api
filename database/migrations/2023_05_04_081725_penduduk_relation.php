<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("penduduk", function (Blueprint $table) {
            $table->string("no_kk");
            $table->foreign("no_kk")->references("no_kk")->on("kk");
            $table->string("nik_anggota_keluarga", 16)->unique();
            $table->foreign("nik_anggota_keluarga")->references("nik")->on("anggota_keluarga")->cascadeOnUpdate()->cascadeOnDelete();
            $table->primary(["no_kk", "nik_anggota_keluarga"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 
    }
};
