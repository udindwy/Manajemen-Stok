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
                'jumlah' => 10,
                'id_pengguna' => 2,
                'tanggal_keluar' => Carbon::now()->subDays(2),
            ],
            [
                'id_produk' => 2,
                'jumlah' => 20,
                'id_pengguna' => 3,
                'tanggal_keluar' => Carbon::now()->subDays(1),
            ],
            [
                'id_produk' => 3,
                'jumlah' => 5,
                'id_pengguna' => 2,
                'tanggal_keluar' => Carbon::now(),
            ],
        ];

        foreach ($stokKeluar as $sk) {
            StokKeluar::create($sk);
        }
    }
}
