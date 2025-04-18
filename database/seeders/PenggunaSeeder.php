<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('pengguna')->insert([
            [
                'nama' => 'Admin Utama',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'peran' => 'admin',
                'dibuat_pada' => Carbon::now(),
            ],
            [
                'nama' => 'Karyawan Satu',
                'email' => 'karyawan1@example.com',
                'password' => Hash::make('karyawan123'),
                'peran' => 'pengguna',
                'dibuat_pada' => Carbon::now(),
            ],
            [
                'nama' => 'Karyawan Dua',
                'email' => 'karyawan2@example.com',
                'password' => Hash::make('karyawan123'),
                'peran' => 'pengguna',
                'dibuat_pada' => Carbon::now(),
            ],
        ]);
    }
}
