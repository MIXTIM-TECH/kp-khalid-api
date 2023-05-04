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
        Schema::create("credentials", function (Blueprint $table) {
            $table->string("username");
            $table->string("password");
            $table->enum("role", ["super_admin", "admin", "user"]);
            $table->enum("status", ["aktif", "tidak_aktif"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("credentials");
    }
};
