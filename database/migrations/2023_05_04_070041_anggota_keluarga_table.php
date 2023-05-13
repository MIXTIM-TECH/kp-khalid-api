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
            $table->string("nik", 16)->unique()->primary();
            $table->string("nama");
            $table->enum("jenis_kelamin", ["P", "L"])->nullable();
            $table->string("tempat_lahir")->nullable();
            $table->date("tanggal_lahir")->nullable();
            $table->enum("status", ["Kawin", "Belum Kawin"])->nullable();
            $table->enum("pendidikan", ["SD", "SMP", "SMA", "D3", "S1", "S2", "S3"])->nullable();
            $table->string("jenis_pekerjaan")->nullable();
            $table->enum("agama", ["Islam", "Kristen Protestan", "Katolik", "Hindu", "Buddha", "Kong Hu Cu",])->nullable();
            $table->enum("status_perkawinan", ["Menikah", "Belum Menikah", "Cerai Hidup", "Cerai Mati"])->nullable();
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
        Schema::dropIfExists("anggota_keluarga");
    }
};
