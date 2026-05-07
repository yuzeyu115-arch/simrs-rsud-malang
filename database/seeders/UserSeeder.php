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
        $users = [
            [
                'name' => 'Dr. Ahmad Spesialis OK',
                'username' => 'kepala_ok',
                'password' => Hash::make('password123'),
                'role' => 'Kepala Instalansi Operasi',
            ],
            [
                'name' => 'Budi Anestesi, S.Kep',
                'username' => 'asisten_anestesi_1',
                'password' => Hash::make('password123'),
                'role' => 'Perawat Anestesi (Asisten)',
            ],
            [
                'name' => 'Siti Bedah, S.Kep',
                'username' => 'asisten_bedah_1',
                'password' => Hash::make('password123'),
                'role' => 'Perawat Bedah (Asisten)',
            ],
            [
                'name' => 'Rini Instrument, S.Kep',
                'username' => 'instrumentor_1',
                'password' => Hash::make('password123'),
                'role' => 'Perawat Instrumentor',
            ],
            [
                'name' => 'Joko Sirkuler, S.Kep',
                'username' => 'sirkuler_1',
                'password' => Hash::make('password123'),
                'role' => 'Perawat sirkuler (onloop)',
            ],
            [
                'name' => 'Dr. Hendra, Sp.B',
                'username' => 'dokter_bedah_1',
                'password' => Hash::make('password123'),
                'role' => 'Dokter bedah',
            ],
            [
                'name' => 'Dr. Maya, Sp.An',
                'username' => 'dokter_anestesi_1',
                'password' => Hash::make('password123'),
                'role' => 'dokter anestesi',
            ],
            [
                'name' => 'Lani Recovery, S.Kep',
                'username' => 'perawat_rr_1',
                'password' => Hash::make('password123'),
                'role' => 'perawat recovercy room',
            ],
            [
                'name' => 'Apoteker Rian',
                'username' => 'farmasi_1',
                'password' => Hash::make('password123'),
                'role' => 'Farmasi dan obat',
            ],
            [
                'name' => 'Tim Gizi Sehat',
                'username' => 'gizi_1',
                'password' => Hash::make('password123'),
                'role' => 'Gizi',
            ],
            [
                'name' => 'Admin SIMRS',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['username' => $user['username']],
                $user
            );
        }
    }
}
