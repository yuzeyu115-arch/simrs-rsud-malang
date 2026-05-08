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
                'name' => 'PJ Admin',
                'username' => 'pj_admin',
                'password' => Hash::make('password'),
                'role' => 'pj_admin',
            ],
            [
                'name' => 'Dr. DPJP',
                'username' => 'dpjp',
                'password' => Hash::make('password'),
                'role' => 'dpjp',
            ],
            [
                'name' => 'Dr. Ahmad Spesialis OK',
                'username' => 'kepala_ok',
                'password' => Hash::make('password'),
                'role' => 'kepala_instalasi_operasi',
            ],
            [
                'name' => 'Budi Anestesi, S.Kep',
                'username' => 'asisten_anestesi_1',
                'password' => Hash::make('password'),
                'role' => 'perawat_anestesi',
            ],
            [
                'name' => 'Siti Bedah, S.Kep',
                'username' => 'asisten_bedah_1',
                'password' => Hash::make('password'),
                'role' => 'perawat_bedah',
            ],
            [
                'name' => 'Rini Instrument, S.Kep',
                'username' => 'instrumentor_1',
                'password' => Hash::make('password'),
                'role' => 'perawat_instrumentor',
            ],
            [
                'name' => 'Joko Sirkuler, S.Kep',
                'username' => 'sirkuler_1',
                'password' => Hash::make('password'),
                'role' => 'perawat_sirkuler',
            ],
            [
                'name' => 'Dr. Hendra, Sp.B',
                'username' => 'dokter_bedah_1',
                'password' => Hash::make('password'),
                'role' => 'dokter_bedah',
            ],
            [
                'name' => 'Dr. Maya, Sp.An',
                'username' => 'dokter_anestesi_1',
                'password' => Hash::make('password'),
                'role' => 'dokter_anestesi',
            ],
            [
                'name' => 'Lani Recovery, S.Kep',
                'username' => 'perawat_rr_1',
                'password' => Hash::make('password'),
                'role' => 'perawat_recovery',
            ],
            [
                'name' => 'Apoteker Rian',
                'username' => 'farmasi_1',
                'password' => Hash::make('password'),
                'role' => 'farmasi',
            ],
            [
                'name' => 'Tim Gizi Sehat',
                'username' => 'gizi_1',
                'password' => Hash::make('password'),
                'role' => 'gizi',
            ],
            [
                'name' => 'Admin SIMRS',
                'username' => 'admin',
                'password' => Hash::make('password'),
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
