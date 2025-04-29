<?php

namespace Database\Seeders;

use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        $produk = [
            [
                'nama_produk' => 'Beras',
                'kode_produk' => 'PRD-0001',
                'id_kategori' => 1,
                'stok' => 100,
                'stok_minimal' => 20,
                'deskripsi' => 'Beras premium per kg',
                'dibuat_pada' => Carbon::now(),
            ],
            [
                'nama_produk' => 'Mie Instan',
                'kode_produk' => 'PRD-0002',
                'id_kategori' => 1,
                'stok' => 150,
                'stok_minimal' => 30,
                'deskripsi' => 'Mie instan berbagai rasa',
                'dibuat_pada' => Carbon::now(),
            ],
            [
                'nama_produk' => 'Teh Botol',
                'kode_produk' => 'PRD-0003',  // Diubah dari kode_barang
                'id_kategori' => 2,
                'stok' => 50,
                'stok_minimal' => 10,
                'deskripsi' => 'Minuman teh dalam botol',
                'dibuat_pada' => Carbon::now(),
            ],
            [
                'nama_produk' => 'Sabun Mandi',
                'kode_produk' => 'PRD-0004',  // Diubah dari kode_barang
                'id_kategori' => 4,
                'stok' => 10,
                'stok_minimal' => 15,
                'deskripsi' => 'Sabun mandi batangan',
                'dibuat_pada' => Carbon::now(),
            ],
            [
                'nama_produk' => 'Pulpen',
                'kode_produk' => 'PRD-0005',  // Diubah dari kode_barang
                'id_kategori' => 5,
                'stok' => 100,
                'stok_minimal' => 20,
                'deskripsi' => 'Pulpen hitam',
                'dibuat_pada' => Carbon::now(),
            ],
        ];

        foreach ($produk as $p) {
            Produk::create($p);
        }
    }
}
