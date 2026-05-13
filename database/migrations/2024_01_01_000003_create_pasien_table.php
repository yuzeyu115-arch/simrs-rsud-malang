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
        Schema::create('pasien', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->nullable();
            $table->string('no_rekam_medis', 50)->unique();
            $table->string('nama_lengkap');
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin', 20)->nullable();
            $table->string('golongan_darah', 5)->nullable();
            $table->longText('alamat')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            // Foreign Key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            
            // Indexes
            $table->index('no_rekam_medis');
            $table->index('nama_lengkap');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
