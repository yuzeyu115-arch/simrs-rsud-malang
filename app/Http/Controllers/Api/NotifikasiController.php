<?php

namespace App\Http\Controllers\Api;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotifikasiController extends Controller
{
    /**
     * Display a listing of notifications
     */
    public function index(Request $request)
    {
        $query = Notifikasi::query();

        // Filter by status (read/unread)
        if ($request->has('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        // Filter by type
        if ($request->has('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        // Filter for current user or global notifications
        if ($request->user()) {
            $query->where(function ($q) use ($request) {
                $q->whereNull('user_id')
                  ->orWhere('user_id', $request->user()->id);
            });
        }

        // Default: order by most recent
        $notifications = $query->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 20);

        return response()->json([
            'success' => true,
            'data' => $notifications,
        ]);
    }

    /**
     * Display the specified notification
     */
    public function show(Notifikasi $notifikasi)
    {
        // Mark as read when viewed
        if (!$notifikasi->is_read) {
            $notifikasi->update(['is_read' => true]);
        }

        return response()->json([
            'success' => true,
            'data' => $notifikasi,
        ]);
    }

    /**
     * Delete the specified notification
     */
    public function destroy(Notifikasi $notifikasi)
    {
        $notifikasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully',
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notifikasi $notifikasi)
    {
        $notifikasi->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
            'data' => $notifikasi,
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        $query = Notifikasi::where('is_read', false);

        // Only mark user's own + global notifications
        if ($request->user()) {
            $query->where(function ($q) use ($request) {
                $q->whereNull('user_id')
                  ->orWhere('user_id', $request->user()->id);
            });
        }

        $query->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read',
        ]);
    }
}
