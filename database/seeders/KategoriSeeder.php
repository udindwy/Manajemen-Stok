<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategoris = [
            'Bahan Baku Utama',
            'Bahan Baku Pendukung',
            'Bahan Pengemasan',
            'Produk Setengah Jadi',
            'Produk Jadi',
            'Peralatan Produksi',
            'Perlengkapan Pendukung'
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create([
                'nama_kategori' => $kategori,
                'dibuat_pada' => now()
            ]);
        }
    }
}
