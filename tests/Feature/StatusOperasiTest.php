<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class StatusOperasiTest extends TestCase
{
    use RefreshDatabase;

    public function test_status_operasi_falls_back_to_latest_surgery_schedule_when_no_active_one_exists(): void
    {
        DB::table('dokter_bedah')->insert([
            'id' => 1,
            'nama' => 'Dr. Test',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('dokter_anestesi')->insert([
            'id' => 1,
            'nama' => 'Dr. Anestesi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('operating_rooms')->insert([
            'id' => 1,
            'nama_ruang' => 'Ruang 1',
            'status' => 'Tersedia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('surgery_schedules')->insert([
            'nama_pasien' => 'Budi Santoso',
            'nomor_rm' => '00012345',
            'dokter_bedah_id' => 1,
            'dokter_anestesi_id' => 1,
            'ruang_id' => 1,
            'tanggal_operasi' => '2025-05-18',
            'jam_mulai' => '10:30:00',
            'jenis_tindakan' => 'Appendectomy',
            'status' => 'Selesai',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get('/status-operasi');

        $response->assertStatus(200);
        $response->assertSee('Monitoring Operasi');
        $response->assertSee('Budi Santoso');
    }
}
