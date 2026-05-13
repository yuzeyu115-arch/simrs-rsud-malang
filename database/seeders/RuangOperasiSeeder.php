<?php

namespace Database\Seeders;

use App\Models\RuangOperasi;
use Illuminate\Database\Seeder;

class RuangOperasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ruangs = [
            [
                'nama_ruangan' => 'OK 1 - Bedah Umum',
                'status' => 'tersedia',
                'kapasitas_bed' => 4,
                'catatan' => 'Ruang operasi untuk bedah umum',
            ],
            [
                'nama_ruangan' => 'OK 2 - Bedah Spesialis',
                'status' => 'tersedia',
                'kapasitas_bed' => 3,
                'catatan' => 'Ruang operasi untuk bedah spesialis',
            ],
            [
                'nama_ruangan' => 'OK 3 - Ortopedi',
                'status' => 'tersedia',
                'kapasitas_bed' => 2,
                'catatan' => 'Ruang operasi untuk ortopedi',
            ],
            [
                'nama_ruangan' => 'Recovery Room',
                'status' => 'tersedia',
                'kapasitas_bed' => 6,
                'catatan' => 'Ruang pemulihan pasca operasi',
            ],
        ];

        foreach ($ruangs as $ruang) {
            RuangOperasi::create($ruang);
        }
    }
}
