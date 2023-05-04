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
        Schema::create("detail_alamat", function (Blueprint $table) {
            $table->id();
            $table->text("alamat");
            $table->string("rt", 2)->nullable();
            $table->string("rw", 2)->nullable();
            $table->string("kelurahan")->nullable();
            $table->string("kecamatan")->nullable();
            $table->string("kabupaten")->nullable();
            $table->string("provinsi")->nullable();
            $table->enum("type", ["orang_tua", "anggota_keluarga", "surat_ket_tidak_mampu"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("detail_alamat");
    }
};
