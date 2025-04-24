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
                'nama' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'peran' => 'admin',
                'dibuat_pada' => Carbon::now(),
            ],
            [
                'nama' => 'Karyawan',
                'email' => 'karyawan1@example.com',
                'password' => Hash::make('karyawan123'),
                'peran' => 'pengguna',
                'dibuat_pada' => Carbon::now(),
            ],
        ]);
    }
}
