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
        Schema::create('peserta_rapat', function (Blueprint $table) {
            $table->uuid('rapat_id');
            $table->foreignId('user_id');
            $table->string('status_kehadiran', 50)->default('diundang');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            // Primary Key
            $table->primary(['rapat_id', 'user_id']);
            
            // Foreign Keys
            $table->foreign('rapat_id')->references('id')->on('rapat_koordinasi')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_rapat');
    }
};
