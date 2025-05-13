<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $suppliers = [
            [
                'nama_supplier' => 'PT Bahan Kimia Utama',
                'kontak' => '081234567890',
                'alamat' => 'Jl. Industri Kimia No. 123, Cikarang',
                'lead_time' => 7,
                'dibuat_pada' => now()
            ],
            [
                'nama_supplier' => 'PT Kemasan Profesional',
                'kontak' => '087654321098',
                'alamat' => 'Kawasan Industri MM2100 Blok A1, Bekasi',
                'lead_time' => 5,
                'dibuat_pada' => now()
            ],
            [
                'nama_supplier' => 'CV Mesin Produksi',
                'kontak' => '089876543210',
                'alamat' => 'Jl. Teknik Mesin No. 45, Tangerang',
                'lead_time' => 14,
                'dibuat_pada' => now()
            ],
            [
                'nama_supplier' => 'PT Bahan Tambahan',
                'kontak' => '082145678901',
                'alamat' => 'Jl. Industri Raya No. 67, Karawang',
                'lead_time' => 3,
                'dibuat_pada' => now()
            ]
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}