<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->string('kode_produk')->unique()->nullable();
            $table->string('nama_produk');
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedInteger('id_supplier')->nullable();
            $table->integer('stok')->default(0);
            $table->integer('stok_minimal')->default(0);
            $table->text('deskripsi')->nullable();
            $table->text('qr_code')->nullable(); // Ubah dari string ke text
            $table->timestamp('dibuat_pada')->useCurrent();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
            $table->foreign('id_supplier')->references('id_supplier')->on('supplier')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk');
    }
}
