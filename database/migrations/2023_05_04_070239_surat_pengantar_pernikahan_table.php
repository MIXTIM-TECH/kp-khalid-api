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
        Schema::create("surat_pengantar_pernikahan", function (Blueprint $table) {
            $table->id();
            $table->string("pemohon", 16)->nullable();
            $table->foreign("pemohon")->references("nik")->on("anggota_keluarga")->cascadeOnUpdate()->nullOnDelete();
            $table->string("no_kk", 16)->nullable();
            $table->foreign("no_kk")->references("no_kk")->on("kk")->cascadeOnUpdate()->nullOnDelete();
            $table->text("alamat_pernikahan");
            $table->string("tempat_lahir");
            $table->date("tanggal_lahir");
            $table->foreignId("id_ayah")->constrained("orang_tua");
            $table->foreignId("id_ibu")->constrained("orang_tua");
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
        Schema::dropIfExists("surat_pengantar_pernikahan");
    }
};
