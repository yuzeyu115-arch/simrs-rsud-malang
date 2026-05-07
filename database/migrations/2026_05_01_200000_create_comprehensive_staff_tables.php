<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $staffTables = [
            'kepala_instalasi_operasi',
            'perawat_anestesi',
            'perawat_bedah',
            'perawat_instrumentor',
            'perawat_sirkuler',
            'dokter_bedah',
            'dokter_anestesi',
            'perawat_recovery',
            'staff_farmasi',
            'staff_gizi'
        ];

        foreach ($staffTables as $tableName) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('nip')->unique()->nullable();
                $table->string('spesialisasi')->nullable();
                $table->text('alamat')->nullable();
                $table->string('no_telp')->nullable();
                $table->enum('status', ['Aktif', 'Cuti', 'Non-Aktif'])->default('Aktif');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_gizi');
        Schema::dropIfExists('staff_farmasi');
        Schema::dropIfExists('perawat_recovery');
        Schema::dropIfExists('dokter_anestesi');
        Schema::dropIfExists('dokter_bedah');
        Schema::dropIfExists('perawat_sirkuler');
        Schema::dropIfExists('perawat_instrumentor');
        Schema::dropIfExists('perawat_bedah');
        Schema::dropIfExists('perawat_anestesi');
        Schema::dropIfExists('kepala_instalasi_operasi');
    }
};
