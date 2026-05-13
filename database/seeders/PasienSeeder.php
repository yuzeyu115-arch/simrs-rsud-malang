<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Seeder;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasiens = [
            [
                'no_rekam_medis' => 'RM001',
                'nama_lengkap' => 'Budi Santoso',
                'tanggal_lahir' => '1985-05-15',
                'jenis_kelamin' => 'Laki-laki',
                'golongan_darah' => 'O',
                'alamat' => 'Jl. Ahmad Yani No. 123, Malang',
            ],
            [
                'no_rekam_medis' => 'RM002',
                'nama_lengkap' => 'Siti Nurhaliza',
                'tanggal_lahir' => '1990-08-22',
                'jenis_kelamin' => 'Perempuan',
                'golongan_darah' => 'A',
                'alamat' => 'Jl. Diponegoro No. 45, Malang',
            ],
            [
                'no_rekam_medis' => 'RM003',
                'nama_lengkap' => 'Ahmad Riyadi',
                'tanggal_lahir' => '1978-03-10',
                'jenis_kelamin' => 'Laki-laki',
                'golongan_darah' => 'B',
                'alamat' => 'Jl. Gatot Subroto No. 78, Malang',
            ],
            [
                'no_rekam_medis' => 'RM004',
                'nama_lengkap' => 'Rini Wijaya',
                'tanggal_lahir' => '1992-12-05',
                'jenis_kelamin' => 'Perempuan',
                'golongan_darah' => 'AB',
                'alamat' => 'Jl. Veteran No. 56, Malang',
            ],
            [
                'no_rekam_medis' => 'RM005',
                'nama_lengkap' => 'Hendra Kusuma',
                'tanggal_lahir' => '1988-07-30',
                'jenis_kelamin' => 'Laki-laki',
                'golongan_darah' => 'O',
                'alamat' => 'Jl. Sudirman No. 99, Malang',
            ],
        ];

        foreach ($pasiens as $pasien) {
            Pasien::create($pasien);
        }
    }
}
