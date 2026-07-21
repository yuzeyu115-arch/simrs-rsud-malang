<?php

namespace App\Http\Controllers\Api;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Carbon\Carbon;

class MedicineController extends Controller
{
    /**
     * Display a listing of medicines
     */
    public function index(Request $request)
    {
        $query = Medicine::query();

        // Search by name
        if ($request->has('search')) {
            $query->where('nama_obat', 'like', "%{$request->search}%");
        }

        // Filter by type
        if ($request->has('jenis_obat')) {
            $query->where('jenis_obat', $request->jenis_obat);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $medicines = $query->paginate($request->per_page ?? 20);

        return response()->json([
            'success' => true,
            'data' => $medicines,
        ]);
    }

    /**
     * Store a newly created medicine
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|unique:medicines,nama_obat|string|max:255',
            'jenis_obat' => 'required|string|max:100',
            'stok_obat' => 'required|integer|min:0',
            'kandungan_obat' => 'required|string',
            'tanggal_kadaluwarsa' => 'required|date|after:today',
            'harga_obat' => 'required|numeric|min:0',
            'status' => 'sometimes|in:aktif,nonaktif',
        ]);

        $medicine = Medicine::create([
            ...$validated,
            'status' => $validated['status'] ?? 'aktif',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Medicine created successfully',
            'data' => $medicine,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified medicine
     */
    public function show(Medicine $medicine)
    {
        return response()->json([
            'success' => true,
            'data' => $medicine,
        ]);
    }

    /**
     * Update the specified medicine
     */
    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'nama_obat' => 'sometimes|unique:medicines,nama_obat,' . $medicine->id_obat . ',id_obat|string|max:255',
            'jenis_obat' => 'sometimes|string|max:100',
            'kandungan_obat' => 'sometimes|string',
            'tanggal_kadaluwarsa' => 'sometimes|date',
            'harga_obat' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:aktif,nonaktif',
        ]);

        $medicine->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Medicine updated successfully',
            'data' => $medicine,
        ]);
    }

    /**
     * Delete the specified medicine
     */
    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return response()->json([
            'success' => true,
            'message' => 'Medicine deleted successfully',
        ]);
    }

    /**
     * Update medicine stock
     */
    public function updateStok(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'stok_obat' => 'required|integer|min:0',
            'type' => 'sometimes|in:set,add,subtract',
        ]);

        $type = $validated['type'] ?? 'set';
        $stok = $validated['stok_obat'];

        if ($type === 'add') {
            $medicine->stok_obat += $stok;
        } elseif ($type === 'subtract') {
            $medicine->stok_obat = max(0, $medicine->stok_obat - $stok);
        } else {
            $medicine->stok_obat = $stok;
        }

        $medicine->save();

        return response()->json([
            'success' => true,
            'message' => 'Medicine stock updated',
            'data' => $medicine,
        ]);
    }

    /**
     * Get expired medicines
     */
    public function getExpired()
    {
        $expired = Medicine::where('tanggal_kadaluwarsa', '<=', now())
            ->get();

        return response()->json([
            'success' => true,
            'count' => count($expired),
            'data' => $expired,
        ]);
    }

    /**
     * Get low stock medicines
     */
    public function getLowStock(Request $request)
    {
        $threshold = $request->threshold ?? 10;

        $lowStock = Medicine::where('stok_obat', '<=', $threshold)
            ->where('status', 'aktif')
            ->get();

        return response()->json([
            'success' => true,
            'threshold' => $threshold,
            'count' => count($lowStock),
            'data' => $lowStock,
        ]);
    }
}
