<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStokKeluarTable extends Migration
{
    public function up()
    {
        Schema::create('stok_keluar', function (Blueprint $table) {
            $table->id('id_stok_keluar');
            $table->unsignedBigInteger('id_produk');
            $table->integer('jumlah');
            $table->unsignedBigInteger('id_pengguna');
            $table->dateTime('tanggal_keluar');
            $table->timestamps();

            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stok_keluar');
    }
}
