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
        Schema::create("wali", function (Blueprint $table) {
            $table->id();
            $table->string("nama_wali");
            $table->enum("jenis_kelamin", ["P", "L"]);
            $table->string("tempat_lahir");
            $table->string("tanggal_lahir");
            $table->string("pekerjaan");
            $table->string("status_perkawinan");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("wali");
    }
};
