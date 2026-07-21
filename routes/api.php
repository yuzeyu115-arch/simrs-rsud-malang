<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\PasienController;
use App\Http\Controllers\Api\JadwalOperasiController;
use App\Http\Controllers\Api\MedicineController;
use App\Http\Controllers\Api\NotifikasiController;

Route::prefix('v1')->middleware('api.token')->group(function () {
    
    // Authentication
    Route::post('/logout', function (Request $request) {
        $request->user()->forceFill(['remember_token' => null])->save();
        return response()->json(['message' => 'Logged out successfully']);
    });
    Route::get('/me', [\App\Http\Controllers\Api\AuthController::class, 'me']);

    // Appointments
    Route::apiResource('appointments', AppointmentController::class);
    Route::patch('appointments/{appointment}/status', [AppointmentController::class, 'updateStatus']);

    // Pasien (Patients)
    Route::apiResource('pasiens', PasienController::class);
    Route::get('pasiens/{pasien}/appointments', [PasienController::class, 'appointments']);
    Route::get('pasiens/{pasien}/medical-history', [PasienController::class, 'medicalHistory']);

    // Jadwal Operasi (Surgery Schedules)
    Route::apiResource('jadwal-operasi', JadwalOperasiController::class)
        ->parameters(['jadwal-operasi' => 'jadwalOperasi']);
    Route::patch('jadwal-operasi/{jadwalOperasi}/status', [JadwalOperasiController::class, 'updateStatus']);
    Route::post('jadwal-operasi/{jadwalOperasi}/tim', [JadwalOperasiController::class, 'addTeamMember']);
    Route::delete('jadwal-operasi/{jadwalOperasi}/tim/{user}', [JadwalOperasiController::class, 'removeTeamMember']);

    // Medicine (Farmasi/Obat)
    Route::get('medicines/expired', [MedicineController::class, 'getExpired']);
    Route::get('medicines/low-stock', [MedicineController::class, 'getLowStock']);
    Route::apiResource('medicines', MedicineController::class);
    Route::patch('medicines/{medicine}/stok', [MedicineController::class, 'updateStok']);

    // Notifikasi (Notifications)
    Route::apiResource('notifikasi', NotifikasiController::class, ['only' => ['index', 'show', 'destroy']]);
    Route::patch('notifikasi/{notifikasi}/read', [NotifikasiController::class, 'markAsRead']);
    Route::post('notifikasi/read-all', [NotifikasiController::class, 'markAllAsRead']);
});

// Public routes (no authentication required)
Route::prefix('v1')->group(function () {
    Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
});
