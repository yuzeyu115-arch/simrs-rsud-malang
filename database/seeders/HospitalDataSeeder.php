<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HospitalDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Staff Tables
        DB::table('kepala_instalasi_operasi')->insertOrIgnore([
            ['nama' => 'Dr. Ahmad Spesialis OK', 'nip' => '198501012010011001', 'alamat' => 'Malang', 'no_telp' => '081234567890'],
        ]);

        DB::table('dokter_bedah')->insertOrIgnore([
            ['nama' => 'Dr. Hendra, Sp.B', 'nip' => '197505052005011002', 'spesialisasi' => 'Bedah Umum', 'alamat' => 'Malang'],
            ['nama' => 'Dr. Devia Amanda, Sp.B', 'nip' => '198808082015012003', 'spesialisasi' => 'Bedah Digestif', 'alamat' => 'Malang'],
        ]);

        DB::table('dokter_anestesi')->insertOrIgnore([
            ['nama' => 'Dr. Maya, Sp.An', 'nip' => '198202022010012004', 'alamat' => 'Malang'],
        ]);

        DB::table('perawat_sirkuler')->insertOrIgnore([
            ['nama' => 'Joko Sirkuler, S.Kep', 'nip' => '199003032018011005', 'alamat' => 'Malang'],
        ]);

        DB::table('staff_farmasi')->insertOrIgnore([
            ['nama' => 'Apoteker Rian', 'nip' => '199204042019011006', 'alamat' => 'Malang'],
        ]);

        // 2. Seed Medicines
        DB::table('medicines')->insertOrIgnore([
            [
                'nama_obat' => 'Paracetamol 500mg',
                'jenis_obat' => 'Analgesik',
                'stok_obat' => 500,
                'kandungan_obat' => 'Paracetamol',
                'tanggal_kadaluwarsa' => '2026-12-31',
                'harga_obat' => 5000.00,
                'created_at' => now(),
            ],
            [
                'nama_obat' => 'Lidocaine Injection',
                'jenis_obat' => 'Anestesi Lokal',
                'stok_obat' => 100,
                'kandungan_obat' => 'Lidocaine HCl',
                'tanggal_kadaluwarsa' => '2025-06-30',
                'harga_obat' => 25000.00,
                'created_at' => now(),
            ],
            [
                'nama_obat' => 'Infus RL 500ml',
                'jenis_obat' => 'Cairan Infus',
                'stok_obat' => 200,
                'kandungan_obat' => 'Ringer Laktat',
                'tanggal_kadaluwarsa' => '2027-01-01',
                'harga_obat' => 15000.00,
                'created_at' => now(),
            ],
        ]);

        // 3. Seed Medicine Packages (Farmasi & Obat)
        DB::table('medicine_packages')->insertOrIgnore([
            [
                'nama_paket' => 'Paket Bedah Umum A',
                'jenis_obat' => 'Campuran',
                'total_paket' => 25,
                'preoperatif' => 'Diazepam, Atropine',
                'intraoperatif' => 'Lidocaine, Propofol, Fentanyl',
                'postoperatif' => 'Ketorolac, Paracetamol IV',
                'created_at' => now(),
            ],
            [
                'nama_paket' => 'Paket Bedah Digestif',
                'jenis_obat' => 'Antibiotik & Analgesik',
                'total_paket' => 15,
                'preoperatif' => 'Cefazolin 2g',
                'intraoperatif' => 'Sevoflurane, Rocuronium',
                'postoperatif' => 'Ceftriaxone, Morphine',
                'created_at' => now(),
            ],
        ]);

        // 3b. Seed Gizi - Pemesanan Menu
        DB::table('pemesanan_menu')->insertOrIgnore([
            [
                'ruang' => 'Ruang Melati 1',
                'kelas' => 'VIP',
                'nama_pasien' => 'Anisa Putri',
                'shift' => 'Pagi',
                'tanggal' => '2025-05-18',
                'catatan' => 'Diet rendah garam',
                'created_at' => now(),
            ],
            [
                'ruang' => 'Ruang Seruni',
                'kelas' => 'Kelas 1',
                'nama_pasien' => 'Budi Santoso',
                'shift' => 'Siang',
                'tanggal' => '2025-05-18',
                'catatan' => 'Alergi seafood',
                'created_at' => now(),
            ],
            [
                'ruang' => 'ICU',
                'kelas' => 'Kelas 1',
                'nama_pasien' => 'Citra Wulandari',
                'shift' => 'Sore',
                'tanggal' => '2025-05-18',
                'catatan' => null,
                'created_at' => now(),
            ],
        ]);

        // 3c. Seed Gizi - Laporan Pemesanan
        DB::table('laporan_pemesanan')->insertOrIgnore([
            [
                'nama' => 'Anisa Putri',
                'jam_pesan' => '06:00',
                'jam_kirim' => '06:45',
                'jam_lapor' => '07:00',
                'status' => 'Selesai',
                'created_at' => now(),
            ],
            [
                'nama' => 'Budi Santoso',
                'jam_pesan' => '11:30',
                'jam_kirim' => '12:00',
                'jam_lapor' => null,
                'status' => 'Terkirim',
                'created_at' => now(),
            ],
            [
                'nama' => 'Citra Wulandari',
                'jam_pesan' => '16:00',
                'jam_kirim' => null,
                'jam_lapor' => null,
                'status' => 'Baru',
                'created_at' => now(),
            ],
        ]);

        // 3d. Seed Gizi - Jadwal Makan
        DB::table('jadwal_makan')->insertOrIgnore([
            [
                'nama' => 'Anisa Putri',
                'jam_pesan' => '06:00',
                'jam_kirim' => '06:45',
                'jam_lapor' => '07:00',
                'shift' => 'Pagi',
                'created_at' => now(),
            ],
            [
                'nama' => 'Budi Santoso',
                'jam_pesan' => '11:30',
                'jam_kirim' => '12:00',
                'jam_lapor' => '12:15',
                'shift' => 'Siang',
                'created_at' => now(),
            ],
            [
                'nama' => 'Citra Wulandari',
                'jam_pesan' => '16:00',
                'jam_kirim' => '16:30',
                'jam_lapor' => '16:45',
                'shift' => 'Sore',
                'created_at' => now(),
            ],
        ]);

        // 4. Seed Operating Rooms
        DB::table('operating_rooms')->insertOrIgnore([
            ['nama_ruang' => 'Bedah A', 'status' => 'Tersedia', 'lantai' => '2'],
            ['nama_ruang' => 'Bedah B', 'status' => 'Digunakan', 'lantai' => '2'],
            ['nama_ruang' => 'ICU', 'status' => 'Tersedia', 'lantai' => '1'],
        ]);

        // 4. Seed Inpatient Beds (Bed Manager)
        DB::table('inpatient_beds')->insertOrIgnore([
            [
                'gedung' => 'Gedung A (Tulip)',
                'lantai' => 'Lantai 2',
                'ruangan' => 'Ruang Melati 1',
                'no_bed' => 'Bed 01',
                'jenis_kamar' => 'VIP',
                'status' => 'Terisi',
                'nama_pasien' => 'Anisa Putri',
                'created_at' => now(),
            ],
            [
                'gedung' => 'Gedung A (Tulip)',
                'lantai' => 'Lantai 2',
                'ruangan' => 'Ruang Melati 1',
                'no_bed' => 'Bed 02',
                'jenis_kamar' => 'VIP',
                'status' => 'Tersedia',
                'nama_pasien' => null,
                'created_at' => now(),
            ],
            [
                'gedung' => 'Gedung B (Mawar)',
                'lantai' => 'Lantai 3',
                'ruangan' => 'Ruang Seruni',
                'no_bed' => 'Bed 10',
                'jenis_kamar' => 'Kelas 1',
                'status' => 'Booking',
                'nama_pasien' => 'Budi Santoso',
                'created_at' => now(),
            ],
        ]);

        // 5. Seed Surgery Schedules (Jadwal Operasi)
        DB::table('surgery_schedules')->insertOrIgnore([
            [
                'nama_pasien' => 'Anisa Putri',
                'nomor_rm' => '00012345',
                'dokter_bedah_id' => 2, // Dr. Devia Amanda
                'dokter_anestesi_id' => 1, // Dr. Maya
                'ruang_id' => 1, // Bedah A
                'tanggal_operasi' => '2025-05-18',
                'jam_mulai' => '10:30:00',
                'jenis_tindakan' => 'Bedah Digestif (Appendectomy)',
                'status' => 'Terjadwal',
                'created_at' => now(),
            ],
            [
                'nama_pasien' => 'Budi Santoso',
                'nomor_rm' => '00012346',
                'dokter_bedah_id' => 1, // Dr. Hendra
                'dokter_anestesi_id' => 1, // Dr. Maya
                'ruang_id' => 3, // ICU
                'tanggal_operasi' => '2025-05-18',
                'jam_mulai' => '13:00:00',
                'jenis_tindakan' => 'Pasang Ventilator',
                'status' => 'Berjalan',
                'created_at' => now(),
            ],
            [
                'nama_pasien' => 'Citra Wulandari',
                'nomor_rm' => '00012347',
                'dokter_bedah_id' => 2,
                'dokter_anestesi_id' => 1,
                'ruang_id' => 1,
                'tanggal_operasi' => '2025-05-19',
                'jam_mulai' => '09:00:00',
                'jenis_tindakan' => 'Hernia Repair',
                'status' => 'Terjadwal',
                'created_at' => now(),
            ],
        ]);

        // 6. Seed Appointments (Janji Temu) - Based on UI design
        DB::table('appointments')->insertOrIgnore([
            [
                'nama_pasien' => 'Anisa Putri',
                'nomor_rm' => '00012345',
                'tanggal_janji' => '2025-05-18',
                'jam_janji' => '10:30',
                'poliklinik' => 'Bedah A',
                'dokter_tujuan' => 'Dr. Devia Amanda',
                'jenis' => 'Kontrol',
                'prioritas' => 'Normal',
                'status' => 'Terjadwal',
                'created_at' => now(),
            ],
            [
                'nama_pasien' => 'Budi Santoso',
                'nomor_rm' => '00012346',
                'tanggal_janji' => '2025-05-18',
                'jam_janji' => '13:00',
                'poliklinik' => 'ICU',
                'dokter_tujuan' => 'Dr. Rudi Hartono',
                'jenis' => 'Konsultasi',
                'prioritas' => 'Urgent',
                'status' => 'Terjadwal',
                'created_at' => now(),
            ],
            [
                'nama_pasien' => 'Citra Wulandari',
                'nomor_rm' => '00012347',
                'tanggal_janji' => '2025-05-19',
                'jam_janji' => '09:00',
                'poliklinik' => 'Anak',
                'dokter_tujuan' => 'Dr. Sinta Dewi',
                'jenis' => 'Kontrol',
                'prioritas' => 'Normal',
                'status' => 'Selesai',
                'created_at' => now(),
            ],
            [
                'nama_pasien' => 'Dewi Lestari',
                'nomor_rm' => '00012348',
                'tanggal_janji' => '2025-05-19',
                'jam_janji' => '11:30',
                'poliklinik' => 'Internal',
                'dokter_tujuan' => 'Dr. Andi Wijaya',
                'jenis' => 'Tindakan',
                'prioritas' => 'Normal',
                'status' => 'Terjadwal',
                'created_at' => now(),
            ],
            [
                'nama_pasien' => 'Fajar Nugroho',
                'nomor_rm' => '00012349',
                'tanggal_janji' => '2025-05-20',
                'jam_janji' => '08:30',
                'poliklinik' => 'Bedah B',
                'dokter_tujuan' => 'Dr. Devia Amanda',
                'jenis' => 'Kontrol',
                'prioritas' => 'Normal',
                'status' => 'Menunggu',
                'created_at' => now(),
            ],
            [
                'nama_pasien' => 'Gita Amelia',
                'nomor_rm' => '00012350',
                'tanggal_janji' => '2025-05-20',
                'jam_janji' => '14:00',
                'poliklinik' => 'Kebidanan',
                'dokter_tujuan' => 'Dr. Maya Sari',
                'jenis' => 'Konsultasi',
                'prioritas' => 'Normal',
                'status' => 'Terjadwal',
                'created_at' => now(),
            ],
        ]);

        // 6. Seed Fast Logistics
        DB::table('fast_logistics')->insertOrIgnore([
            [
                'total_bius_tersedia' => 45,
                'jumlah_cairan_infus' => 120,
                'jumlah_alat_bedah_steril' => 15,
                'terakhir_dicek' => now(),
                'created_at' => now(),
            ],
        ]);

        // 7. Seed Notifications
        DB::table('notifications')->insertOrIgnore([
            ['judul' => 'Stok Obat Menipis', 'pesan' => 'Stok Lidocaine tersisa 10 unit.', 'tipe' => 'Warning', 'created_at' => now()],
            ['judul' => 'Jadwal Operasi Baru', 'pesan' => 'Operasi Anisa Putri dijadwalkan besok.', 'tipe' => 'Info', 'created_at' => now()],
        ]);
    }
}
