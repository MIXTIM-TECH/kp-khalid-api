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
        Schema::create("orang_tua", function (Blueprint $table) {
            $table->id();
            $table->string("nama_lengkap");
            $table->enum("agama", ["Islam", "Kristen Protestan", "Katolik", "Hindu", "Buddha", "Kong Hu Cu",]);
            $table->text("alamat");
            $table->string("nik", 16)->nullable();
            $table->string("tempat_lahir")->nullable();
            $table->string("tanggal_lahir")->nullable();
            $table->string("pekerjaan")->nullable();
            $table->enum("kategori", ["ayah", "ibu"])->nullable();
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
        Schema::dropIfExists("orang_tua");
    }
};
