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
        Schema::create("forget_password", function (Blueprint $table) {
            $table->id();
            $table->string("nik_kepala_keluarga", 16)->unique();
            $table->foreign("nik_kepala_keluarga")->references("username")->on("credentials")->cascadeOnUpdate()->cascadeOnDelete();
            $table->string("phone_number");
            $table->string("otp");
            $table->string("expired");
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
        Schema::dropIfExists("forget_password");
    }
};
