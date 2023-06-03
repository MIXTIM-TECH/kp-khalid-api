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
        Schema::create("wali", function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->string("pendidikan");
            $table->string("nik", 16);
            $table->string("pekerjaan");
            $table->enum("status_perkawinan", ["kawin", "belum_kawin", "cerai_hidup", "cerai_mati"]);
            $table->text("alamat");
            $table->enum("jenis_kelamin", ["P", "L"]);
            $table->string("tempat_lahir");
            $table->date("tanggal_lahir");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("wali");
    }
};
