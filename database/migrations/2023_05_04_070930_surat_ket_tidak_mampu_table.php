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
        Schema::create("surat_ket_tidak_mampu", function (Blueprint $table) {
            $table->id();
            $table->foreignId("surat_id")->constrained("surat")->cascadeOnDelete();
            $table->foreignId("id_orang_tua")->constrained("orang_tua");
            $table->string("surat_pengantar");
            $table->text("keperluan");
            $table->text("keterangan");
            $table->string("pendidikan");
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
        Schema::dropIfExists("surat_ket_tidak_mampu");
    }
};
