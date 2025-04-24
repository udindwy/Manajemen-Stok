<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokMasukSeeder extends Seeder
{
    public function run()
    {
        DB::table('stok_masuk')->insert([
            [
                'id_produk' => 1,
                'jumlah' => 30,
                'id_pengguna' => 1,
                'tanggal_masuk' => Carbon::now(),
            ],
            [
                'id_produk' => 2,
                'jumlah' => 50,
                'id_pengguna' => 2,
                'tanggal_masuk' => Carbon::now(),
            ]
        ]);
    }
}
