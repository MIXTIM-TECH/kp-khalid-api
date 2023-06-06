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
        Schema::create("surat_ket_usaha", function (Blueprint $table) {
            $table->id();
            $table->foreignId("surat_id")->constrained("surat")->cascadeOnDelete();
            $table->string("nama_usaha");
            $table->text("keperluan");
            $table->text("alamat_usaha");
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
        Schema::dropIfExists("surat_ket_usaha");
    }
};
