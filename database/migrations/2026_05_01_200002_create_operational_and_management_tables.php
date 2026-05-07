<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Ruang Operasi
        Schema::create('operating_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruang');
            $table->enum('status', ['Tersedia', 'Digunakan', 'Maintenance'])->default('Tersedia');
            $table->string('lantai')->nullable();
            $table->timestamps();
        });

        // Tabel Ketersediaan Kasur Rawat Inap (Bed Manager)
        Schema::create('inpatient_beds', function (Blueprint $table) {
            $table->id();
            $table->string('gedung');
            $table->string('lantai');
            $table->string('ruangan');
            $table->string('no_bed');
            $table->string('jenis_kamar');
            $table->enum('status', ['Tersedia', 'Terisi', 'Booking', 'Maintenance'])->default('Tersedia');
            $table->string('nama_pasien')->nullable();
            $table->timestamps();
        });

        // Tabel Jadwal Operasi
        Schema::create('surgery_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasien');
            $table->string('nomor_rm');
            $table->unsignedBigInteger('dokter_bedah_id');
            $table->unsignedBigInteger('dokter_anestesi_id');
            $table->unsignedBigInteger('ruang_id');
            $table->date('tanggal_operasi');
            $table->time('jam_mulai');
            $table->string('jenis_tindakan');
            $table->enum('status', ['Terjadwal', 'Berjalan', 'Selesai', 'Dibatalkan'])->default('Terjadwal');
            $table->timestamps();

            // Note: Since staff tables are separate, foreign keys might be tricky. 
            // In a real app, we'd probably use a unified users table or loose linking.
        });

        // Tabel Janji Temu
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasien');
            $table->string('nomor_rm');
            $table->date('tanggal_janji');
            $table->time('jam_janji');
            $table->string('poliklinik');
            $table->string('dokter_tujuan');
            $table->string('jenis')->default('Kontrol');
            $table->enum('prioritas', ['Normal', 'Urgent', 'Emergency'])->default('Normal');
            $table->enum('status', ['Terjadwal', 'Selesai', 'Menunggu', 'Dibatalkan'])->default('Terjadwal');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // Tabel Statistik Tindakan Kunjungan
        Schema::create('visit_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->integer('jumlah_kunjungan');
            $table->integer('jumlah_operasi');
            $table->string('tindakan_terbanyak')->nullable();
            $table->timestamps();
        });

        // Tabel Rapat Koordinasi KA Bedah
        Schema::create('coordination_meetings', function (Blueprint $table) {
            $table->id();
            $table->string('judul_rapat');
            $table->date('tanggal_rapat');
            $table->string('pimpinan_rapat');
            $table->text('peserta_rapat');
            $table->text('notulen_hasil');
            $table->string('lampiran_dokumen')->nullable();
            $table->timestamps();
        });

        // Tabel Notifikasi
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('judul');
            $table->text('pesan');
            $table->enum('tipe', ['Info', 'Warning', 'Danger'])->default('Info');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('coordination_meetings');
        Schema::dropIfExists('visit_statistics');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('surgery_schedules');
        Schema::dropIfExists('inpatient_beds');
        Schema::dropIfExists('operating_rooms');
    }
};
