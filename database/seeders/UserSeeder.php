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
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@simrs.local',
                'password' => 'password123',
                'role' => 'admin',
            ],
            [
                'name' => 'Dr. Khatarina',
                'username' => 'drkhatarina',
                'email' => 'khatarina@simrs.local',
                'password' => 'password123',
                'role' => 'dokter',
            ],
            [
                'name' => 'Dr. Allifia',
                'username' => 'drallifia',
                'email' => 'allifia@simrs.local',
                'password' => 'password123',
                'role' => 'dokter',
            ],
            [
                'name' => 'Dr. Syani',
                'username' => 'drsyani',
                'email' => 'syani@simrs.local',
                'password' => 'password123',
                'role' => 'dokter',
            ],
            [
                'name' => 'Dr. Nada',
                'username' => 'drnada',
                'email' => 'nada@simrs.local',
                'password' => 'password123',
                'role' => 'dokter',
            ],
            [
                'name' => 'Dr. Devia',
                'username' => 'drdevia',
                'email' => 'devia@simrs.local',
                'password' => 'password123',
                'role' => 'dokter',
            ],
            [
                'name' => 'Dr. Hellena',
                'username' => 'drhellena',
                'email' => 'hellena@simrs.local',
                'password' => 'password123',
                'role' => 'dokter',
            ],
            [
                'name' => 'Kepala Bedah',
                'username' => 'kabedah',
                'email' => 'kabedah@simrs.local',
                'password' => 'password123',
                'role' => 'ka_bedah',
            ],
            [
                'name' => 'Perawat Anisa',
                'username' => 'perawat_anisa',
                'email' => 'perawat1@simrs.local',
                'password' => 'password123',
                'role' => 'perawat',
            ],
            [
                'name' => 'Perawat Budi',
                'username' => 'perawat_budi',
                'email' => 'perawat2@simrs.local',
                'password' => 'password123',
                'role' => 'perawat',
            ],
            [
                'name' => 'Perawat Syani',
                'username' => 'perawat_syari',
                'email' => 'perawat3@simrs.local',
                'password' => 'password123',
                'role' => 'perawat',
            ],
            [
                'name' => 'Dokter Anestesi Maya',
                'username' => 'drmayanestesi',
                'email' => 'anestesi@simrs.local',
                'password' => 'password123',
                'role' => 'anestesi',
            ],
            [
                'name' => 'Ahli Gizi Rian',
                'username' => 'gizi_rian',
                'email' => 'gizi@simrs.local',
                'password' => 'password123',
                'role' => 'ahli_gizi',
            ],
            [
                'name' => 'Staff Farmasi Rian',
                'username' => 'farmasi_rian',
                'email' => 'farmasi@simrs.local',
                'password' => 'password123',
                'role' => 'farmasi',
            ],
            [
                'name' => 'Rekam Medis',
                'username' => 'rekammedis',
                'email' => 'rekammedis@simrs.local',
                'password' => 'password123',
                'role' => 'rekam_medis',
            ],
            [
                'name' => 'SIMRS ITSK',
                'username' => 'simrsITSK',
                'email' => 'simrsitsk@simrs.local',
                'password' => 'simpleok',
                'role' => 'admin',
            ],
            // Custom users requested
            [
                'name' => 'TPP',
                'username' => 'tppSimpleOk',
                'email' => 'tppSimpleOk@simrs.local',
                'password' => 'tpp123',
                'role' => 'rekam_medis',
            ],
            [
                'name' => 'KPP',
                'username' => 'kppSimpleOk',
                'email' => 'kppSimpleOk@simrs.local',
                'password' => 'kpp123',
                'role' => 'perawat',
            ],
            [
                'name' => 'DPJB',
                'username' => 'dpjbSimpleOk',
                'email' => 'dpjbSimpleOk@simrs.local',
                'password' => 'dpjb123',
                'role' => 'dokter',
            ],
            [
                'name' => 'Perawat Anestesi',
                'username' => 'peranSimpleOk',
                'email' => 'peranSimpleOk@simrs.local',
                'password' => 'anestesi123',
                'role' => 'anestesi',
            ],
            [
                'name' => 'Unit Farmasi',
                'username' => 'farmasiSimpleOk',
                'email' => 'farmasiSimpleOk@simrs.local',
                'password' => 'farmasi123',
                'role' => 'farmasi',
            ],
            [
                'name' => 'Anisa Putri',
                'username' => 'pasien_anisa',
                'email' => 'pasien1@simrs.local',
                'no_hp' => '081234567890',
                'password' => 'password123',
                'role' => 'pasien',
            ],
            [
                'name' => 'Budi Santoso',
                'username' => 'pasien_budi',
                'email' => 'pasien2@simrs.local',
                'no_hp' => '081234567891',
                'password' => 'password123',
                'role' => 'pasien',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['username' => $user['username']],
                array_merge($user, ['password' => Hash::make($user['password'])])
            );
        }
    }
}
