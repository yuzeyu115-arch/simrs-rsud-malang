<?php

namespace App\Http\Controllers\Api;

use App\Models\Pasien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class PasienController extends Controller
{
    /**
     * Display a listing of patients
     */
    public function index(Request $request)
    {
        $query = Pasien::query();

        // Search by name or medical record number
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_lengkap', 'like', "%$search%")
                  ->orWhere('no_rekam_medis', 'like', "%$search%");
        }

        // Filter by gender
        if ($request->has('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $pasiens = $query->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $pasiens,
        ]);
    }

    /**
     * Store a newly created patient
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'no_rekam_medis' => 'required|unique:pasien,no_rekam_medis|string',
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'golongan_darah' => 'sometimes|in:A,B,AB,O',
            'alamat' => 'required|string',
        ]);

        $pasien = Pasien::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Patient created successfully',
            'data' => $pasien,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified patient
     */
    public function show(Pasien $pasien)
    {
        return response()->json([
            'success' => true,
            'data' => $pasien->load(['jadwalOperasi']),
        ]);
    }

    /**
     * Update the specified patient
     */
    public function update(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'sometimes|string|max:255',
            'tanggal_lahir' => 'sometimes|date',
            'jenis_kelamin' => 'sometimes|in:laki-laki,perempuan',
            'golongan_darah' => 'sometimes|in:A,B,AB,O',
            'alamat' => 'sometimes|string',
        ]);

        $pasien->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Patient updated successfully',
            'data' => $pasien,
        ]);
    }

    /**
     * Delete the specified patient
     */
    public function destroy(Pasien $pasien)
    {
        $pasien->delete();

        return response()->json([
            'success' => true,
            'message' => 'Patient deleted successfully',
        ]);
    }

    /**
     * Get patient's appointments
     */
    public function appointments(Pasien $pasien)
    {
        return response()->json([
            'success' => true,
            'data' => $pasien->appointments()->with('dokter')->get(),
        ]);
    }

    /**
     * Get patient's medical history
     */
    public function medicalHistory(Pasien $pasien)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'appointments' => $pasien->appointments()->with('dokter')->get(),
                'surgeries' => $pasien->jadwalOperasi()->with('timOperasi')->get(),
            ],
        ]);
    }
}
