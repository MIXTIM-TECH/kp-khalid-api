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
        Schema::create("waktu_aktivasi", function (Blueprint $table) {
            $table->string("tanggal_registrasi", 20);
            $table->string("batas_aktivasi", 20);
            $table->string("username", 16)->unique();
            $table->foreign("username")->references("username")->on("credentials")->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists("waktu_aktivasi");
    }
};
