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
        Schema::create("mempelai", function (Blueprint $table) {
            $table->id();
            $table->enum("kategori", ["Suami", "Istri"]);
            $table->enum("jenis_kelamin", ["P", "L"]);
            $table->string("ayah");
            $table->string("nik_ayah", 16);
            $table->string("tempat_lahir");
            $table->date("tanggal_lahir");
            $table->enum("agama", ["Islam", "Kristen Protestan", "Katolik", "Hindu", "Buddha", "Kong Hu Cu"]);
            $table->string("pekerjaan");
            $table->text("alamat");
            $table->string("nama");
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
        Schema::dropIfExists("mempelai");
    }
};
