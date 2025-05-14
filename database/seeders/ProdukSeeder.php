<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\StokMasuk;
use Illuminate\Database\Seeder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        $produks = [
            [
                'nama_produk' => 'Bahan Kimia A',
                'kode_produk' => 'PRD-0001',
                'id_kategori' => 1,
                'id_supplier' => 1,
                'stok' => 1000,
                'stok_minimal' => 200,
                'deskripsi' => 'Bahan kimia utama untuk produksi',
                'dibuat_pada' => now(),
            ],
            [
                'nama_produk' => 'Bahan Tambahan X',
                'kode_produk' => 'PRD-0002',
                'id_kategori' => 2,
                'id_supplier' => 4,
                'stok' => 500,
                'stok_minimal' => 100,
                'deskripsi' => 'Bahan tambahan untuk stabilizer',
                'dibuat_pada' => now(),
            ],
            [
                'nama_produk' => 'Kemasan Botol 100ml',
                'kode_produk' => 'PRD-0003',
                'id_kategori' => 3,
                'id_supplier' => 2,
                'stok' => 5000,
                'stok_minimal' => 1000,
                'deskripsi' => 'Botol plastik ukuran 100ml',
                'dibuat_pada' => now(),
            ],
            [
                'nama_produk' => 'Produk A Setengah Jadi',
                'kode_produk' => 'PRD-0004',
                'id_kategori' => 4,
                'id_supplier' => 1,
                'stok' => 200,
                'stok_minimal' => 50,
                'deskripsi' => 'Produk A tahap intermediate',
                'dibuat_pada' => now(),
            ],
            [
                'nama_produk' => 'Produk A Final',
                'kode_produk' => 'PRD-0005',
                'id_kategori' => 5,
                'id_supplier' => 1,
                'stok' => 300,
                'stok_minimal' => 100,
                'deskripsi' => 'Produk A siap distribusi',
                'dibuat_pada' => now(),
            ],
            [
                'nama_produk' => 'Mesin Mixer 500L',
                'kode_produk' => 'PRD-0006',
                'id_kategori' => 6,
                'id_supplier' => 3,
                'stok' => 2,
                'stok_minimal' => 1,
                'deskripsi' => 'Mesin pencampur kapasitas 500L',
                'dibuat_pada' => now(),
            ]
        ];

        foreach ($produks as $produk) {
            $qrCode = QrCode::size(100)
                ->backgroundColor(255, 255, 255)
                ->margin(2)
                ->generate($produk['kode_produk']);
            $produk['qr_code'] = $qrCode;
            
            // simpan produk dan dapatkan instance produk yang baru dibuat
            $newProduk = Produk::create($produk);

            // catat stok masuk awal
            if ($produk['stok'] > 0) {
                StokMasuk::create([
                    'id_produk' => $newProduk->id_produk,
                    'jumlah' => $produk['stok'],
                    'id_pengguna' => 1, // ID admin
                    'tanggal_masuk' => now(),
                ]);
            }
        }
    }
}
