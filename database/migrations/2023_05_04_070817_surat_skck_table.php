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
        Schema::create("surat_skck", function (Blueprint $table) {
            $table->id();
            $table->foreignId("surat_id")->constrained("surat")->cascadeOnDelete();
            $table->string("surat_pengantar"); // file_name
            $table->text("keperluan");
            $table->text("keterangan");
            $table->foreignId("id_ayah")->constrained("orang_tua");
            $table->foreignId("id_ibu")->constrained("orang_tua");
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
        Schema::dropIfExists("surat_skck");
    }
};
