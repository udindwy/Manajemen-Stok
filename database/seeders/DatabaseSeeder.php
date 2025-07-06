<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PenggunaSeeder::class,
            // KategoriSeeder::class,
            // SupplierSeeder::class,
            // ProdukSeeder::class,
        ]);
    }
}
