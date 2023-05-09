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
        Schema::create("orang_tua_surat_skck", function (Blueprint $table) {
            $table->foreignId("id_surat_skck")->constrained("surat_skck");
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
        Schema::dropIfExists("orang_tua_surat_skck");
    }
};
