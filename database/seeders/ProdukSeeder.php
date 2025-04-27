<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        DB::table('produk')->insert([
            [
                'nama_produk' => 'Nasi Goreng Spesial',
                'id_kategori' => 1,
                'stok' => 50,
                'stok_minimal' => 10,
                'deskripsi' => 'Nasi Goreng dengan berbagai topping lezat',
                'dibuat_pada' => Carbon::now(),
            ],
            [
                'nama_produk' => 'Teh Botol',
                'id_kategori' => 2,
                'stok' => 100,
                'stok_minimal' => 10,
                'deskripsi' => 'Teh botol dengan rasa manis alami',
                'dibuat_pada' => Carbon::now(),
            ],
            [
                'nama_produk' => 'Ayam Goreng',
                'id_kategori' => 1,
                'stok' => 30,
                'stok_minimal' => 10,
                'deskripsi' => 'Ayam Goreng dengan rasa gurih dan renyah',
                'dibuat_pada' => Carbon::now(),
            ],
            [
                'nama_produk' => 'Es Teh Manis',
                'id_kategori' => 2,
                'stok' => 50,
                'stok_minimal' => 15,
                'deskripsi' => 'Es teh manis dengan rasa segar',
                'dibuat_pada' => Carbon::now(),
            ],
            [
                'nama_produk' => 'Mie Goreng',
                'id_kategori' => 1,
                'stok' => 75,
                'stok_minimal' => 20,
                'deskripsi' => 'Mie Goreng dengan bumbu spesial',
                'dibuat_pada' => Carbon::now(),
            ],
        ]);
    }
}
