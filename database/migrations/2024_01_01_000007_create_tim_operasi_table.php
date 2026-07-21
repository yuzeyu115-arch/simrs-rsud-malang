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
        Schema::create('tim_operasi', function (Blueprint $table) {
            $table->uuid('jadwal_operasi_id');
            $table->foreignId('user_id');
            $table->string('peran', 50)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            // Primary Key
            $table->primary(['jadwal_operasi_id', 'user_id']);
            
            // Foreign Keys
            $table->foreign('jadwal_operasi_id')->references('id')->on('jadwal_operasi')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tim_operasi');
    }
};
