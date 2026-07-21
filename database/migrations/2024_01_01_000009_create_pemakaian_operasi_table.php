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
        Schema::create('pemakaian_operasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('jadwal_operasi_id')->nullable();
            $table->uuid('inventaris_id')->nullable();
            $table->integer('jumlah_dipakai');
            $table->unsignedBigInteger('dicatat_oleh')->nullable();
            $table->timestamp('waktu_pencatatan')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            // Foreign Keys
            $table->foreign('jadwal_operasi_id')->references('id')->on('jadwal_operasi')->onDelete('cascade');
            $table->foreign('inventaris_id')->references('id')->on('inventaris')->onDelete('set null');
            $table->foreign('dicatat_oleh')->references('id')->on('users')->onDelete('set null');
            
            // Indexes
            $table->index('jadwal_operasi_id');
            $table->index('waktu_pencatatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemakaian_operasi');
    }
};
