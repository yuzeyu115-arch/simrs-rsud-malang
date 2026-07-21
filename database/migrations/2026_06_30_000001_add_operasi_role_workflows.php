<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surgery_schedules', function (Blueprint $table) {
            if (! Schema::hasColumn('surgery_schedules', 'waktu_pelaksanaan')) {
                $table->dateTime('waktu_pelaksanaan')->nullable()->after('jam_mulai');
            }
            if (! Schema::hasColumn('surgery_schedules', 'finalized_at')) {
                $table->timestamp('finalized_at')->nullable()->after('status');
            }
            if (! Schema::hasColumn('surgery_schedules', 'finalized_by')) {
                $table->unsignedBigInteger('finalized_by')->nullable()->after('finalized_at');
            }
            if (! Schema::hasColumn('surgery_schedules', 'catatan_finalisasi')) {
                $table->text('catatan_finalisasi')->nullable()->after('finalized_by');
            }
        });

        Schema::create('doctor_operation_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surgery_schedule_id');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->text('lembar_observasi');
            $table->text('cppt');
            $table->timestamps();
        });

        Schema::create('anesthesia_package_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surgery_schedule_id');
            $table->unsignedBigInteger('medicine_package_id');
            $table->unsignedBigInteger('requested_by')->nullable();
            $table->string('status')->default('Menunggu Disiapkan');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anesthesia_package_orders');
        Schema::dropIfExists('doctor_operation_notes');

        Schema::table('surgery_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('surgery_schedules', 'catatan_finalisasi')) {
                $table->dropColumn('catatan_finalisasi');
            }
            if (Schema::hasColumn('surgery_schedules', 'finalized_by')) {
                $table->dropColumn('finalized_by');
            }
            if (Schema::hasColumn('surgery_schedules', 'finalized_at')) {
                $table->dropColumn('finalized_at');
            }
            if (Schema::hasColumn('surgery_schedules', 'waktu_pelaksanaan')) {
                $table->dropColumn('waktu_pelaksanaan');
            }
        });
    }
};
