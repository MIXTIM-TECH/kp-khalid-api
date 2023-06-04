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
        Schema::table("anggota_keluarga", function (Blueprint $table) {
            $table->string("no_kk", 16)->nullable();
            $table->foreign("no_kk")->references("no_kk")->on("kk")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("id_detail_alamat")->nullable()->constrained("detail_alamat");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 
    }
};
