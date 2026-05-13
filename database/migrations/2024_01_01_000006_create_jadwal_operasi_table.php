<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwal_operasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pasien_id')->nullable();
            $table->uuid('ruang_operasi_id')->nullable();
            $table->uuid('bed_id')->nullable();
            $table->string('jenis_operasi');
            $table->timestamp('waktu_mulai');
            $table->timestamp('waktu_selesai')->nullable();
            $table->string('status', 50)->default('dijadwalkan');
            $table->longText('catatan')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            // Foreign Keys
            $table->foreign('pasien_id')->references('id')->on('pasien')->onDelete('set null');
            $table->foreign('ruang_operasi_id')->references('id')->on('ruang_operasi')->onDelete('set null');
            $table->foreign('bed_id')->references('id')->on('bed')->onDelete('set null');
            
            // Indexes
            $table->index('status');
            $table->index('waktu_mulai');
            $table->index('pasien_id');
            $table->index('ruang_operasi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_operasi');
    }
};
