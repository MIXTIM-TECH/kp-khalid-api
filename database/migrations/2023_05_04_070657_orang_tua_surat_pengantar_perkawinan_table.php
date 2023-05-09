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
        Schema::create("orang_tua_surat_pengantar_perkawinan", function (Blueprint $table) {
            $table->foreignId("id_spk")->constrained("surat_pengantar_perkawinan");
            $table->foreignId("id_orang_tua")->constrained("orang_tua");
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
        Schema::dropIfExists("orang_tua_surat_pengantar_perkawinan");
    }
};
