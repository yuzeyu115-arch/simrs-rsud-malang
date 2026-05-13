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
        Schema::create('rapat_koordinasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judul_rapat');
            $table->timestamp('waktu_pelaksanaan');
            $table->string('lokasi', 100)->nullable();
            $table->longText('deskripsi')->nullable();
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            // Foreign Keys
            $table->foreign('dibuat_oleh')->references('id')->on('users')->onDelete('set null');
            
            // Indexes
            $table->index('waktu_pelaksanaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapat_koordinasi');
    }
};
