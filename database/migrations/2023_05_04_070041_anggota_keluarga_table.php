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
        Schema::create("anggota_keluarga", function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->string("nik", 16)->unique();
            $table->enum("jenis_kelamin", ["P", "L"])->nullable();
            $table->string("tempat_lahir")->nullable();
            $table->date("tanggal_lahir")->nullable();
            $table->enum("status", ["kawin", "belum_kawin"])->nullable();
            $table->enum("pendidikan", ["SD", "SMP", "SMA", "D3", "S1", "S2", "S3"])->nullable();
            $table->string("jenis_pekerjaan");
            $table->enum("agama", ["Islam", "Kristen Protestan", "Katolik", "Hindu", "Buddha", "Kong Hu Cu",]);
            $table->enum("status_perkawinan", ["menikah", "belum_menikah", "cerai_hidup", "cerai_mati"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("anggota_keluarga");
    }
};
