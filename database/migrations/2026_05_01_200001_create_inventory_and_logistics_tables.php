<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Obat
        Schema::create('medicines', function (Blueprint $table) {
            $table->id('id_obat');
            $table->string('nama_obat');
            $table->string('jenis_obat');
            $table->integer('stok_obat');
            $table->text('kandungan_obat')->nullable();
            $table->date('tanggal_kadaluwarsa');
            $table->date('tanggal_pembelian')->nullable();
            $table->decimal('harga_obat', 15, 2);
            $table->string('status')->default('Tersedia');
            $table->timestamps();
        });

        // Tabel Gizi - Pemesanan Menu
        Schema::create('pemesanan_menu', function (Blueprint $table) {
            $table->id();
            $table->string('ruang');
            $table->string('kelas');
            $table->string('nama_pasien');
            $table->enum('shift', ['Pagi', 'Siang', 'Sore'])->default('Pagi');
            $table->date('tanggal');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // Tabel Gizi - Laporan Pemesanan
        Schema::create('laporan_pemesanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->time('jam_pesan');
            $table->time('jam_kirim')->nullable();
            $table->time('jam_lapor')->nullable();
            $table->enum('status', ['Baru', 'Proses', 'Terkirim', 'Selesai'])->default('Baru');
            $table->timestamps();
        });

        // Tabel Gizi - Jadwal Makan
        Schema::create('jadwal_makan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->time('jam_pesan');
            $table->time('jam_kirim')->nullable();
            $table->time('jam_lapor')->nullable();
            $table->enum('shift', ['Pagi', 'Siang', 'Sore'])->default('Pagi');
            $table->timestamps();
        });

        // Tabel Logistik Cepat
        Schema::create('fast_logistics', function (Blueprint $table) {
            $table->id();
            $table->integer('total_bius_tersedia');
            $table->integer('jumlah_cairan_infus');
            $table->integer('jumlah_alat_bedah_steril');
            $table->timestamp('terakhir_dicek');
            $table->timestamps();
        });

        // Tabel Paket Obat (Surgery Packages)
        Schema::create('medicine_packages', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->string('jenis_obat');
            $table->integer('total_paket');
            $table->text('preoperatif')->nullable();
            $table->text('intraoperatif')->nullable();
            $table->text('postoperatif')->nullable();
            $table->timestamps();
        });

        // Tabel Audit Inventaris Obat
        Schema::create('medicine_audits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obat_id');
            $table->integer('stok_fisik');
            $table->integer('stok_sistem');
            $table->integer('selisih');
            $table->text('keterangan')->nullable();
            $table->string('auditor');
            $table->timestamps();

            $table->foreign('obat_id')->references('id_obat')->on('medicines')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicine_audits');
        Schema::dropIfExists('medicine_packages');
        Schema::dropIfExists('fast_logistics');
        Schema::dropIfExists('jadwal_makan');
        Schema::dropIfExists('laporan_pemesanan');
        Schema::dropIfExists('pemesanan_menu');
        Schema::dropIfExists('medicines');
    }
};
