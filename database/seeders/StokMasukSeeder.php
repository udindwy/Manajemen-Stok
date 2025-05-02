<?php

namespace Database\Seeders;

use App\Models\StokMasuk;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StokMasukSeeder extends Seeder
{
    public function run()
    {
        $stokMasuk = [
            [
                'id_produk' => 1,
                'jumlah' => 100,
                'id_pengguna' => 1,
                'tanggal_masuk' => Carbon::now(),
            ],
            [
                'id_produk' => 2,
                'jumlah' => 50,
                'id_pengguna' => 1,
                'tanggal_masuk' => Carbon::now(),
            ],
            [
                'id_produk' => 3,
                'jumlah' => 75,
                'id_pengguna' => 1,
                'tanggal_masuk' => Carbon::now(),
            ],
            [
                'id_produk' => 4,
                'jumlah' => 100,
                'id_pengguna' => 1,
                'tanggal_masuk' => Carbon::now(),
            ],
            [
                'id_produk' => 5,
                'jumlah' => 60,
                'id_pengguna' => 1,
                'tanggal_masuk' => Carbon::now(),
            ],
            [
                'id_produk' => 6,
                'jumlah' => 48,
                'id_pengguna' => 1,
                'tanggal_masuk' => Carbon::now(),
            ],
            [
                'id_produk' => 7,
                'jumlah' => 36,
                'id_pengguna' => 1,
                'tanggal_masuk' => Carbon::now(),
            ],
        ];

        foreach ($stokMasuk as $sm) {
            StokMasuk::create($sm);
        }
    }
}