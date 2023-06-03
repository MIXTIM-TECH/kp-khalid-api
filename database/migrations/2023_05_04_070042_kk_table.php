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
        Schema::create("kk", function (Blueprint $table) {
            $table->string("no_kk", 16)->primary();
            $table->string("foto_kk"); // file_name
            $table->integer("jumlah_keluarga")->unsigned()->default(1);
            $table->integer("jumlah_surat_diajukan")->unsigned()->default(0);
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
        Schema::dropIfExists("kk");
    }
};
