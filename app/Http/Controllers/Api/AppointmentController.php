<?php

namespace App\Http\Controllers\Api;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments
     */
    public function index(Request $request)
    {
        $query = Appointment::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by prioritas
        if ($request->has('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }

        // Filter by poliklinik
        if ($request->has('poliklinik')) {
            $query->where('poliklinik', $request->poliklinik);
        }

        // Search by patient name or doctor
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pasien', 'like', "%{$search}%")
                  ->orWhere('dokter_tujuan', 'like', "%{$search}%")
                  ->orWhere('nomor_rm', 'like', "%{$search}%");
            });
        }

        // Date range filter
        if ($request->has('from_date') && $request->has('to_date')) {
            $query->whereBetween('tanggal_janji', [
                $request->from_date,
                $request->to_date,
            ]);
        }

        $appointments = $query->orderBy('tanggal_janji', 'desc')
            ->orderBy('jam_janji', 'asc')
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $appointments,
        ]);
    }

    /**
     * Store a newly created appointment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'nomor_rm' => 'required|string|max:50',
            'tanggal_janji' => 'required|date',
            'jam_janji' => 'required',
            'poliklinik' => 'required|string|max:255',
            'dokter_tujuan' => 'required|string|max:255',
            'jenis' => 'sometimes|string|max:255',
            'prioritas' => 'sometimes|in:Normal,Urgent,Emergency',
            'catatan' => 'nullable|string',
        ]);

        $validated['status'] = 'Terjadwal';
        $validated['jenis'] = $validated['jenis'] ?? 'Kontrol';
        $validated['prioritas'] = $validated['prioritas'] ?? 'Normal';

        $appointment = Appointment::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Appointment created successfully',
            'data' => $appointment,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified appointment
     */
    public function show(Appointment $appointment)
    {
        return response()->json([
            'success' => true,
            'data' => $appointment,
        ]);
    }

    /**
     * Update the specified appointment
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'nama_pasien' => 'sometimes|string|max:255',
            'nomor_rm' => 'sometimes|string|max:50',
            'tanggal_janji' => 'sometimes|date',
            'jam_janji' => 'sometimes',
            'poliklinik' => 'sometimes|string|max:255',
            'dokter_tujuan' => 'sometimes|string|max:255',
            'jenis' => 'sometimes|string|max:255',
            'prioritas' => 'sometimes|in:Normal,Urgent,Emergency',
            'status' => 'sometimes|in:Terjadwal,Selesai,Menunggu,Dibatalkan',
            'catatan' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Appointment updated successfully',
            'data' => $appointment,
        ]);
    }

    /**
     * Delete the specified appointment
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Appointment deleted successfully',
        ]);
    }

    /**
     * Update appointment status
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:Terjadwal,Selesai,Menunggu,Dibatalkan',
        ]);

        $appointment->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Appointment status updated',
            'data' => $appointment,
        ]);
    }
}
