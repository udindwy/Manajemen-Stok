<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PenggunaSeeder::class,
            KategoriSeeder::class,
            ProdukSeeder::class,
            StokMasukSeeder::class,
            StokKeluarSeeder::class,
        ]);
    }
}
