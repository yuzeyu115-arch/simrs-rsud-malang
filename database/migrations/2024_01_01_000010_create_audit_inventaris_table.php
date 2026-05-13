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
        Schema::create('audit_inventaris', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('inventaris_id')->nullable();
            $table->string('jenis_aktivitas', 50);
            $table->integer('jumlah');
            $table->longText('keterangan')->nullable();
            $table->timestamp('waktu_audit')->useCurrent();
            $table->unsignedBigInteger('diaudit_oleh')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            // Foreign Keys
            $table->foreign('inventaris_id')->references('id')->on('inventaris')->onDelete('cascade');
            $table->foreign('diaudit_oleh')->references('id')->on('users')->onDelete('set null');
            
            // Indexes
            $table->index('waktu_audit');
            $table->index('jenis_aktivitas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_inventaris');
    }
};
