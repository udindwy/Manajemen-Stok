<?php

namespace Database\Seeders;

use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        $produk = [
            // Sembako
            [
                'nama_produk' => 'Beras Premium',
                'kode_produk' => 'PRD-0001',
                'id_kategori' => 1,
                'stok' => 100,
                'stok_minimal' => 20,
                'deskripsi' => 'Beras premium per kg',
                'dibuat_pada' => Carbon::now(),
                'qr_code' => QrCode::size(100)->generate('PRD-0001'),
            ],
            [
                'nama_produk' => 'Minyak Goreng',
                'kode_produk' => 'PRD-0002',
                'id_kategori' => 1,
                'stok' => 10,
                'stok_minimal' => 20,
                'deskripsi' => 'Minyak goreng kemasan 1L',
                'dibuat_pada' => Carbon::now(),
                'qr_code' => QrCode::size(100)->generate('PRD-0002'),
            ],
            [
                'nama_produk' => 'Gula Pasir',
                'kode_produk' => 'PRD-0003',
                'id_kategori' => 1,
                'stok' => 75,
                'stok_minimal' => 15,
                'deskripsi' => 'Gula pasir per kg',
                'dibuat_pada' => Carbon::now(),
                'qr_code' => QrCode::size(100)->generate('PRD-0003'),
            ],
            // Minuman
            [
                'nama_produk' => 'Air Mineral',
                'kode_produk' => 'PRD-0004',
                'id_kategori' => 2,
                'stok' => 100,
                'stok_minimal' => 24,
                'deskripsi' => 'Air mineral 600ml',
                'dibuat_pada' => Carbon::now(),
                'qr_code' => QrCode::size(100)->generate('PRD-0004'),
            ],
            // Makanan Ringan
            [
                'nama_produk' => 'Biskuit',
                'kode_produk' => 'PRD-0005',
                'id_kategori' => 3,
                'stok' => 60,
                'stok_minimal' => 12,
                'deskripsi' => 'Biskuit kemasan',
                'dibuat_pada' => Carbon::now(),
                'qr_code' => QrCode::size(100)->generate('PRD-0005'),
            ],
            // Perlengkapan Mandi
            [
                'nama_produk' => 'Sabun Mandi',
                'kode_produk' => 'PRD-0006',
                'id_kategori' => 4,
                'stok' => 48,
                'stok_minimal' => 12,
                'deskripsi' => 'Sabun mandi batang',
                'dibuat_pada' => Carbon::now(),
                'qr_code' => QrCode::size(100)->generate('PRD-0006'),
            ],
            // Bumbu Dapur
            [
                'nama_produk' => 'Kecap Manis',
                'kode_produk' => 'PRD-0007',
                'id_kategori' => 5,
                'stok' => 36,
                'stok_minimal' => 6,
                'deskripsi' => 'Kecap manis 600ml',
                'dibuat_pada' => Carbon::now(),
                'qr_code' => QrCode::size(100)->generate('PRD-0007'),
            ],
        ];

        foreach ($produk as $p) {
            Produk::create($p);
        }
    }
}
