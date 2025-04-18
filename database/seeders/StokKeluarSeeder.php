<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokKeluarSeeder extends Seeder
{
    public function run()
    {
        DB::table('stok_keluar')->insert([
            [
                'id_pengguna' => 1,
                'id_produk' => 1,
                'jumlah' => 20,
                'tanggal_keluar' => Carbon::create('2025', '04', '16', '09', '00', '00'),
            ],
            [
                'id_pengguna' => 2,
                'id_produk' => 2,
                'jumlah' => 10,
                'tanggal_keluar' => Carbon::create('2025', '04', '17', '10', '30', '00'),
            ],
            [
                'id_pengguna' => 1,
                'id_produk' => 3,
                'jumlah' => 15,
                'tanggal_keluar' => Carbon::create('2025', '04', '18', '08', '45', '00'),
            ],
            [
                'id_pengguna' => 2,
                'id_produk' => 4,
                'jumlah' => 30,
                'tanggal_keluar' => Carbon::create('2025', '04', '18', '14', '20', '00'),
            ],
            [
                'id_pengguna' => 1,
                'id_produk' => 5,
                'jumlah' => 25,
                'tanggal_keluar' => Carbon::create('2025', '04', '19', '11', '15', '00'),
            ],
        ]);
    }
}
