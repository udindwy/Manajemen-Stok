<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategori = [
            ['nama_kategori' => 'Sembako', 'dibuat_pada' => Carbon::now()],
            ['nama_kategori' => 'Minuman', 'dibuat_pada' => Carbon::now()],
            ['nama_kategori' => 'Makanan Ringan', 'dibuat_pada' => Carbon::now()],
            ['nama_kategori' => 'Perlengkapan Mandi', 'dibuat_pada' => Carbon::now()],
            ['nama_kategori' => 'Alat Tulis', 'dibuat_pada' => Carbon::now()],
            ['nama_kategori' => 'Bumbu Dapur', 'dibuat_pada' => Carbon::now()],
        ];

        foreach ($kategori as $k) {
            Kategori::create($k);
        }
    }
}
