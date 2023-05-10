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
        Schema::table("waktu_aktivasi", function (Blueprint $table) {
            $table->string("username", 16)->unique();
            $table->foreign("username")->references("nik_kepala_keluarga")->on("kk");
            $table->primary("username");
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
