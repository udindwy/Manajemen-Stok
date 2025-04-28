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
                'jumlah' => 50,
                'id_pengguna' => 1,
                'tanggal_masuk' => Carbon::now()->subDays(5),
            ],
            [
                'id_produk' => 2,
                'jumlah' => 100,
                'id_pengguna' => 1,
                'tanggal_masuk' => Carbon::now()->subDays(4),
            ],
            [
                'id_produk' => 3,
                'jumlah' => 30,
                'id_pengguna' => 1,
                'tanggal_masuk' => Carbon::now()->subDays(3),
            ],
        ];

        foreach ($stokMasuk as $sm) {
            StokMasuk::create($sm);
        }
    }
}