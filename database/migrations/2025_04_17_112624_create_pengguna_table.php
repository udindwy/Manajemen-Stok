<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunaTable extends Migration
{
    public function up()
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id('id_pengguna');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('peran', ['admin', 'pengguna']);
            $table->timestamp('dibuat_pada')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengguna');
    }
}
