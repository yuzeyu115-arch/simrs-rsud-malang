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
        Schema::create('bed', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ruang_operasi_id');
            $table->string('kode_bed', 20);
            $table->string('status', 50)->default('tersedia');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            // Foreign Key
            $table->foreign('ruang_operasi_id')->references('id')->on('ruang_operasi')->onDelete('cascade');
            
            // Indexes
            $table->index('status');
            $table->index('kode_bed');
            $table->index('ruang_operasi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bed');
    }
};
