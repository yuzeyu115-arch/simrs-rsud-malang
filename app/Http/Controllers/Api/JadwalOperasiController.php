<?php

namespace App\Http\Controllers\Api;

use App\Models\JadwalOperasi;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class JadwalOperasiController extends Controller
{
    /**
     * Display a listing of surgery schedules
     */
    public function index(Request $request)
    {
        $query = JadwalOperasi::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by surgery date range
        if ($request->has('from_date') && $request->has('to_date')) {
            $query->whereBetween('waktu_mulai', [
                $request->from_date,
                $request->to_date
            ]);
        }

        $schedules = $query->with(['pasien', 'timOperasi', 'ruangOperasi'])
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $schedules,
        ]);
    }

    /**
     * Store a newly created surgery schedule
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'ruang_operasi_id' => 'required|exists:ruang_operasi,id',
            'jenis_operasi' => 'required|string|max:255',
            'waktu_mulai' => 'required|date_format:Y-m-d H:i:s|after:now',
            'waktu_selesai' => 'required|date_format:Y-m-d H:i:s|after:waktu_mulai',
            'catatan' => 'sometimes|string',
        ]);

        $schedule = JadwalOperasi::create([
            ...$validated,
            'status' => 'scheduled',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Surgery schedule created successfully',
            'data' => $schedule->load(['pasien', 'timOperasi', 'ruangOperasi']),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified surgery schedule
     */
    public function show(JadwalOperasi $jadwalOperasi)
    {
        return response()->json([
            'success' => true,
            'data' => $jadwalOperasi->load(['pasien', 'timOperasi', 'ruangOperasi', 'pemakaianOperasi']),
        ]);
    }

    /**
     * Update the specified surgery schedule
     */
    public function update(Request $request, JadwalOperasi $jadwalOperasi)
    {
        $validated = $request->validate([
            'jenis_operasi' => 'sometimes|string|max:255',
            'waktu_mulai' => 'sometimes|date_format:Y-m-d H:i:s',
            'waktu_selesai' => 'sometimes|date_format:Y-m-d H:i:s',
            'catatan' => 'sometimes|string',
            'status' => 'sometimes|in:scheduled,in-progress,completed,cancelled',
        ]);

        $jadwalOperasi->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Surgery schedule updated successfully',
            'data' => $jadwalOperasi->load(['pasien', 'timOperasi']),
        ]);
    }

    /**
     * Delete the specified surgery schedule
     */
    public function destroy(JadwalOperasi $jadwalOperasi)
    {
        $jadwalOperasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Surgery schedule deleted successfully',
        ]);
    }

    /**
     * Update surgery schedule status
     */
    public function updateStatus(Request $request, JadwalOperasi $jadwalOperasi)
    {
        $validated = $request->validate([
            'status' => 'required|in:scheduled,in-progress,completed,cancelled',
        ]);

        $jadwalOperasi->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Surgery status updated',
            'data' => $jadwalOperasi,
        ]);
    }

    /**
     * Add team member to surgery
     */
    public function addTeamMember(Request $request, JadwalOperasi $jadwalOperasi)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'peran' => 'required|in:dokter_bedah,dokter_anestesi,perawat,pembantu',
        ]);

        $jadwalOperasi->timOperasi()->attach(
            $validated['user_id'],
            ['peran' => $validated['peran']]
        );

        return response()->json([
            'success' => true,
            'message' => 'Team member added successfully',
            'data' => $jadwalOperasi->load('timOperasi'),
        ]);
    }

    /**
     * Remove team member from surgery
     */
    public function removeTeamMember(JadwalOperasi $jadwalOperasi, User $user)
    {
        $jadwalOperasi->timOperasi()->detach($user->id);

        return response()->json([
            'success' => true,
            'message' => 'Team member removed successfully',
            'data' => $jadwalOperasi->load('timOperasi'),
        ]);
    }
}
