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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('no_hp', 20)->unique()->nullable();
            $table->string('google_id')->unique()->nullable();
            $table->string('avatar')->nullable();
            $table->string('facebook_id')->unique()->nullable();
            $table->string('wechat_id')->unique()->nullable();
            $table->string('password')->nullable();
            $table->enum('role', [
                'admin', 
                'dokter', 
                'perawat', 
                'anestesi', 
                'ka_bedah', 
                'ahli_gizi', 
                'farmasi', 
                'rekam_medis', 
                'pasien'
            ])->default('pasien');
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            // Indexes
            $table->index('email');
            $table->index('google_id');
            $table->index('role');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
