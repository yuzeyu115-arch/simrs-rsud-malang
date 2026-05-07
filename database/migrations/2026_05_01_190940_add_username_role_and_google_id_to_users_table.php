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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('name')->nullable();
            $table->string('role')->after('password')->nullable();
            $table->string('google_id')->nullable()->after('role');
            $table->string('avatar')->nullable()->after('google_id');
            // Change email to nullable for cases where only username is used
            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'role', 'google_id', 'avatar']);
            $table->string('email')->nullable(false)->change();
        });
    }
};
