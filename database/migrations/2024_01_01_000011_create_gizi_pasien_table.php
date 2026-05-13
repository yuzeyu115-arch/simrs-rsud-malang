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
        Schema::create('gizi_pasien', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pasien_id')->nullable();
            $table->uuid('jadwal_operasi_id')->nullable();
            $table->string('tipe_diet', 100);
            $table->longText('menu_makanan');
            $table->unsignedBigInteger('ditentukan_oleh')->nullable();
            $table->timestamp('waktu_pemberian')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            // Foreign Keys
            $table->foreign('pasien_id')->references('id')->on('pasien')->onDelete('cascade');
            $table->foreign('jadwal_operasi_id')->references('id')->on('jadwal_operasi')->onDelete('set null');
            $table->foreign('ditentukan_oleh')->references('id')->on('users')->onDelete('set null');
            
            // Indexes
            $table->index('pasien_id');
            $table->index('tipe_diet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gizi_pasien');
    }
};
