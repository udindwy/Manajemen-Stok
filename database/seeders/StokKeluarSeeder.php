<?php

namespace Database\Seeders;

use App\Models\StokKeluar;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StokKeluarSeeder extends Seeder
{
    public function run()
    {
        $stokKeluar = [
            [
                'id_produk' => 1,
                'jumlah' => 5,
                'id_pengguna' => 2,
                'tanggal_keluar' => Carbon::now()->subDays(2),
            ],
            [
                'id_produk' => 2,
                'jumlah' => 3,
                'id_pengguna' => 3,
                'tanggal_keluar' => Carbon::now()->subDays(2),
            ],
            [
                'id_produk' => 3,
                'jumlah' => 2,
                'id_pengguna' => 2,
                'tanggal_keluar' => Carbon::now()->subDays(1),
            ],
            [
                'id_produk' => 4,
                'jumlah' => 12,
                'id_pengguna' => 3,
                'tanggal_keluar' => Carbon::now()->subDays(1),
            ],
            [
                'id_produk' => 5,
                'jumlah' => 6,
                'id_pengguna' => 2,
                'tanggal_keluar' => Carbon::now(),
            ],
            [
                'id_produk' => 6,
                'jumlah' => 4,
                'id_pengguna' => 3,
                'tanggal_keluar' => Carbon::now(),
            ],
            [
                'id_produk' => 7,
                'jumlah' => 2,
                'id_pengguna' => 2,
                'tanggal_keluar' => Carbon::now(),
            ],
        ];

        foreach ($stokKeluar as $sk) {
            StokKeluar::create($sk);
        }
    }
}
