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
        Schema::create("surat_ket_belum_menikah", function (Blueprint $table) {
            $table->id();
            $table->string("pemohon", 16)->nullable();
            $table->string("no_kk", 16)->nullable();
            $table->foreign("no_kk")->references("no_kk")->on("kk")->cascadeOnUpdate()->nullOnDelete();
            $table->foreign("pemohon")->references("nik")->on("anggota_keluarga")->cascadeOnUpdate()->nullOnDelete();
            $table->string("surat_pengantar"); // file_name
            $table->text("keperluan");
            $table->text("keterangan");
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
        Schema::dropIfExists("surat_ket_belum_menikah");
    }
};
