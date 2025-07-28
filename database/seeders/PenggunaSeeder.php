<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run()
    {
        Pengguna::create([
            'nama' => 'Admin',
            'email' => 'udin.dwi@students.utdi.ac.id',
            'password' => Hash::make('admin123'),
            'peran' => 'admin',
            'dibuat_pada' => now()
        ]);

        Pengguna::create([
            'nama' => 'Karyawan',
            'email' => 'karyawan@karyawan.com',
            'password' => Hash::make('karyawan123'),
            'peran' => 'pengguna',
            'dibuat_pada' => now()
        ]);
    }
}
