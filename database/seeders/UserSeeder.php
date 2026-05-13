<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@simrs.local',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Dokter
        User::create([
            'name' => 'Dr. Hendra',
            'email' => 'dokter1@simrs.local',
            'password' => Hash::make('password123'),
            'role' => 'dokter',
        ]);

        User::create([
            'name' => 'Dr. Devia',
            'email' => 'dokter2@simrs.local',
            'password' => Hash::make('password123'),
            'role' => 'dokter',
        ]);

        // Ka Bedah
        User::create([
            'name' => 'Kepala Bedah',
            'email' => 'kabedah@simrs.local',
            'password' => Hash::make('password123'),
            'role' => 'ka_bedah',
        ]);

        // Perawat
        User::create([
            'name' => 'Perawat 1',
            'email' => 'perawat1@simrs.local',
            'password' => Hash::make('password123'),
            'role' => 'perawat',
        ]);

        User::create([
            'name' => 'Perawat 2',
            'email' => 'perawat2@simrs.local',
            'password' => Hash::make('password123'),
            'role' => 'perawat',
        ]);

        // Anestesi
        User::create([
            'name' => 'Dokter Anestesi',
            'email' => 'anestesi@simrs.local',
            'password' => Hash::make('password123'),
            'role' => 'anestesi',
        ]);

        // Ahli Gizi
        User::create([
            'name' => 'Ahli Gizi',
            'email' => 'gizi@simrs.local',
            'password' => Hash::make('password123'),
            'role' => 'ahli_gizi',
        ]);

        // Farmasi
        User::create([
            'name' => 'Staff Farmasi',
            'email' => 'farmasi@simrs.local',
            'password' => Hash::make('password123'),
            'role' => 'farmasi',
        ]);

        // Rekam Medis
        User::create([
            'name' => 'Rekam Medis',
            'email' => 'rekammedis@simrs.local',
            'password' => Hash::make('password123'),
            'role' => 'rekam_medis',
        ]);

        // Pasien
        User::create([
            'name' => 'Anisa Putri',
            'email' => 'pasien1@simrs.local',
            'no_hp' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'pasien',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'pasien2@simrs.local',
            'no_hp' => '081234567891',
            'password' => Hash::make('password123'),
            'role' => 'pasien',
        ]);
    }
}
