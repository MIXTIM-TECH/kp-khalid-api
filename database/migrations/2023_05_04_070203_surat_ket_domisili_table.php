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
        Schema::create("surat_ket_domisili", function (Blueprint $table) {
            $table->id();
            $table->foreignId("surat_id")->constrained("surat");
            $table->string("surat_pengantar"); // filename
            $table->text("keperluan");
            $table->text("keterangan");
            $table->text("pendidikan");
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
        Schema::dropIfExists("surat_ket_domisili");
    }
};
