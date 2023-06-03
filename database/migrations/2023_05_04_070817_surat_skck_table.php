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
        Schema::create("surat_skck", function (Blueprint $table) {
            $table->id();
            $table->string("pemohon", 16)->nullable();
            $table->foreign("pemohon")->references("nik")->on("anggota_keluarga")->cascadeOnUpdate()->nullOnDelete();
            $table->string("surat_pengantar"); // file_name
            $table->text("keperluan");
            $table->text("keterangan");
            $table->string("nama_ayah");
            $table->string("nama_ibu");
            $table->string("agama");
            $table->text("alamat");
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
        Schema::dropIfExists("surat_skck");
    }
};
