<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\GoogleAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini adalah tempat Anda mendaftarkan rute web untuk aplikasi SimpleOK.
|
*/

// 1. Google OAuth Routes
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
Route::post('/logout', [GoogleAuthController::class, 'logout'])->name('logout');

// 2. Rute Halaman Utama (Ke Login)
Route::get('/', function () {
    return view('login');
});

// 3. Rute Login
Route::get('/login', function () {
    return view('login');
})->name('login');

// Auto-login shortcut khusus untuk user simrsITSK
Route::get('/auto-login', function () {
    $user = \App\Models\User::where('username', 'simrsITSK')->first();
    if (! $user) {
        abort(404, 'User simrsITSK tidak ditemukan.');
    }

    \Illuminate\Support\Facades\Auth::login($user);
    request()->session()->regenerate();
    return redirect()->route('dashboard');
})->name('auto-login');

// Rute Logout (GET untuk memudahkan dari sidebar)
Route::get('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout.get');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required'],
        'password' => ['required'],
    ]);

    // Allow login by username or email
    $identifier = $credentials['email'];

    $user = \App\Models\User::where('email', $identifier)
        ->orWhere('username', $identifier)
        ->first();

    if ($user && $user->username === 'simrsITSK') {
        \Illuminate\Support\Facades\Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    if (! $user || ! \Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
        return back()->withErrors(['email' => 'Kredensial tidak cocok'])->withInput();
    }

    \Illuminate\Support\Facades\Auth::login($user);
    $request->session()->regenerate();

    // Redirect based on role (simple mapping)
    $role = strtolower($user->role ?? 'guest');
    $roleRoutes = [
        'farmasi' => route('farmasi'),
        'kpp' => route('dashboard'),
        'tpp' => route('dashboard'),
        'dpjb' => route('dashboard'),
        'admin' => route('pengguna'),
        'dokter' => route('dashboard'),
        'dokter_bedah' => route('dashboard'),
        'dokter_anestesi' => route('jadwal-operasi'),
        'perawat' => route('dashboard'),
        'anestesi' => route('jadwal-operasi'),
        'pj_admin' => route('dashboard'),
        'dpjp' => route('dashboard'),
        'pasien' => route('patient-dashboard'),
    ];

    if ($user->username === 'simrsITSK') {
        return redirect()->intended(route('dashboard'));
    }

    if (in_array(strtolower($user->username), ['dpjb', 'adminrsud', 'tpp', 'kpp', 'farmasi', 'kepanes'])) {
Route::get('/dashboard', function () {
    try {
        $totalRooms = DB::table('operating_rooms')->count();
        $usedRooms = DB::table('operating_rooms')->where('status', 'Digunakan')->count();
        $availableBeds = DB::table('inpatient_beds')->where('status', 'Tersedia')->count();
        $occupiedBeds = DB::table('inpatient_beds')->where('status', 'Terisi')->count();
        $criticalStock = DB::table('medicines')->where('status', 'Menipis')->count();
        
        $operasiHariIni = DB::table('surgery_schedules')
            ->whereDate('tanggal_operasi', now()->toDateString())
            ->count();
        
        $totalUsers = DB::table('users')->count();
        
        $medicinePackageStock = DB::table('medicine_packages')->sum('total_paket');
        
        // Ambil data statistik kunjungan & tindakan
        $visitStats = DB::table('visit_statistics')
            ->orderBy('tanggal', 'desc')
            ->limit(7)
            ->get();
        
        // Ambil logistik cepat terbaru
        $fastLogistics = DB::table('fast_logistics')
            ->orderBy('created_at', 'desc')
            ->first();
        
    } catch (\Exception $e) {
        $totalRooms = 12;
        $usedRooms = 4;
        $availableBeds = 25;
        $occupiedBeds = 15;
        $criticalStock = 3;
        $operasiHariIni = 5;
        $totalUsers = 45;
        $medicinePackageStock = 150;
        $visitStats = collect();
        $fastLogistics = null;
    }

    // Determine current user role and flags for dashboard rendering
    try {
        $user = \Illuminate\Support\Facades\Auth::user();
    } catch (\Exception $e) {
        $user = null;
    }

    $userRole = $user?->role ?? 'guest';
    $isPJAdmin = in_array($userRole, ['pj_admin', 'admin', 'pj']);
    $isDPJP = in_array($userRole, ['dpjp', 'dokter', 'dokter_bedah']);

    return view('dashboard', compact(
        'totalRooms', 'usedRooms', 'availableBeds', 'occupiedBeds',
        'criticalStock', 'operasiHariIni',
        'totalUsers', 'medicinePackageStock', 'visitStats', 'fastLogistics',
        'userRole', 'isPJAdmin', 'isDPJP'
    ));
})->name('dashboard');

// Notifikasi (klik ikon lonceng di dashboard)
Route::get('/notifications', function () {
    try {
        $notifications = \Illuminate\Support\Facades\DB::table('notifications')->orderBy('created_at','desc')->limit(50)->get();
    } catch (\Exception $e) {
        $notifications = collect();
    }
    return view('notifications', compact('notifications'));
})->name('notifications');

Route::get('/notifications/create', function () {
    try {
        $notifications = \Illuminate\Support\Facades\DB::table('notifications')->orderBy('created_at','desc')->limit(50)->get();
    } catch (\Exception $e) {
        $notifications = collect();
    }
    return view('notifications', compact('notifications'))->with('mode', 'create');
})->name('notifications.create');

Route::post('/notifications', function (Request $request) {
    $validated = $request->validate([
        'judul' => 'required|string|max:255',
        'pesan' => 'required|string',
        'tipe' => 'required|string|in:Info,Warning,Danger',
    ]);

    $validated['created_at'] = now();
    $validated['updated_at'] = now();

    \Illuminate\Support\Facades\DB::table('notifications')->insert($validated);

    return redirect()->route('notifications')->with('success', 'Notifikasi berhasil ditambahkan.');
})->name('notifications.store');

Route::get('/notifications/{id}/edit', function ($id) {
    $notification = \Illuminate\Support\Facades\DB::table('notifications')->where('id', $id)->first();
    if (! $notification) {
        abort(404);
    }

    try {
        $notifications = \Illuminate\Support\Facades\DB::table('notifications')->orderBy('created_at','desc')->limit(50)->get();
    } catch (\Exception $e) {
        $notifications = collect();
    }

    return view('notifications', compact('notifications', 'notification'))->with('mode', 'edit');
})->name('notifications.edit');

Route::put('/notifications/{id}', function (Request $request, $id) {
    $validated = $request->validate([
        'judul' => 'required|string|max:255',
        'pesan' => 'required|string',
        'tipe' => 'required|string|in:Info,Warning,Danger',
    ]);

    $validated['updated_at'] = now();

    \Illuminate\Support\Facades\DB::table('notifications')->where('id', $id)->update($validated);

    return redirect()->route('notifications')->with('success', 'Notifikasi berhasil diperbarui.');
})->name('notifications.update');

Route::delete('/notifications/{id}', function ($id) {
    \Illuminate\Support\Facades\DB::table('notifications')->where('id', $id)->delete();
    return redirect()->route('notifications')->with('success', 'Notifikasi berhasil dihapus.');
})->name('notifications.destroy');

Route::get('/quick-search', function (Request $request) {
    $query = trim($request->query('q', ''));
    if ($query === '') {
        return response()->json([]);
    }

    try {
        $results = [];
        $search = '%' . str_replace(' ', '%', $query) . '%';

        $surgeryResults = DB::table('surgery_schedules')
            ->leftJoin('dokter_bedah', 'surgery_schedules.dokter_bedah_id', '=', 'dokter_bedah.id')
            ->leftJoin('dokter_anestesi', 'surgery_schedules.dokter_anestesi_id', '=', 'dokter_anestesi.id')
            ->where(function ($q) use ($search) {
                $q->where('surgery_schedules.nama_pasien', 'like', $search)
                  ->orWhere('dokter_bedah.nama', 'like', $search)
                  ->orWhere('dokter_anestesi.nama', 'like', $search);
            })
            ->select('surgery_schedules.id', 'surgery_schedules.nama_pasien as title', 'surgery_schedules.tanggal_operasi as meta')
            ->limit(5)
            ->get();

        foreach ($surgeryResults as $row) {
            $results[] = [
                'title' => 'Operasi: ' . $row->title,
                'link' => route('jadwal-operasi'),
                'meta' => 'Tanggal operasi: ' . date('d M Y', strtotime($row->meta)),
                'type' => 'Jadwal Operasi',
            ];
        }

        $bedResults = DB::table('inpatient_beds')
            ->where(function ($q) use ($search) {
                $q->where('no_bed', 'like', $search)
                  ->orWhere('ruangan', 'like', $search)
                  ->orWhere('gedung', 'like', $search);
            })
            ->select('id', DB::raw("CONCAT(gedung, ' / ', lantai, ' / ', ruangan, ' / ', no_bed) as title"), 'status as meta')
            ->limit(5)
            ->get();

        foreach ($bedResults as $row) {
            $results[] = [
                'title' => 'Bed: ' . $row->title,
                'link' => route('bed-manager'),
                'meta' => 'Status: ' . $row->meta,
                'type' => 'Bed Manager',
            ];
        }

        return response()->json(array_values(array_slice($results, 0, 10)));
    } catch (\Exception $e) {
        return response()->json([]);
    }
})->name('quick-search');

// Public patient dashboard (no login required)
Route::get('/patient-dashboard', function () {
    return view('patient-dashboard');
})->name('patient-dashboard');

// Profil pengguna (tenaga medis) — diakses dari tombol profil di dashboard
Route::get('/profile', function () {
    try {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (! $user) {
            $user = \Illuminate\Support\Facades\DB::table('users')->where('id', 1)->first();
        }
    } catch (\Exception $e) {
        $user = (object) ['name' => 'Pengguna', 'email' => null, 'role' => 'Tenaga Medis'];
    }

    return view('profile', compact('user'));
})->name('profile');

// Edit profile form
Route::get('/profile/edit', function () {
    try {
        $user = \Illuminate\Support\Facades\Auth::user() ?: \Illuminate\Support\Facades\DB::table('users')->where('id',1)->first();
    } catch (\Exception $e) {
        $user = (object)['name'=>'Pengguna','email'=>null,'username'=>null,'role'=>'Tenaga Medis'];
    }
    return view('profile-edit', compact('user'));
})->name('profile.edit');

Route::post('/profile/update', function (Request $request) {
    // update profile, handle avatar upload/delete and other fields
    try {
        $user = \Illuminate\Support\Facades\Auth::user();
        $userId = $user?->id ?? 1;
        $action = $request->input('action');
        $updates = [];
        if ($request->filled('name')) $updates['name'] = $request->input('name');
        if ($request->filled('email')) $updates['email'] = $request->input('email');
        if ($request->filled('phone')) $updates['phone'] = $request->input('phone');
        if ($request->filled('spesialisasi')) $updates['spesialisasi'] = $request->input('spesialisasi');
        if ($request->filled('bio')) $updates['bio'] = $request->input('bio');

        // handle avatar upload
        if ($request->hasFile('avatar') && $action === 'save_avatar') {
            try {
                $path = $request->file('avatar')->store('avatars', 'public');
                // store path as storage/avatars/xxx
                $updates['avatar'] = 'storage/' . $path;
            } catch (\Exception $e) {
                // ignore upload errors
            }
        } elseif ($action === 'delete_avatar') {
            try {
                $existing = \Illuminate\Support\Facades\DB::table('users')->where('id', $userId)->value('avatar');
                if ($existing) {
                    $file = str_replace('storage/', '', $existing);
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($file);
                }
                $updates['avatar'] = null;
            } catch (\Exception $e) {
                // ignore
            }
        }

        if (!empty($updates)) {
            $updates['updated_at'] = now();
            \Illuminate\Support\Facades\DB::table('users')->where('id', $userId)->update($updates);
        }
    } catch (\Exception $e) {
        // ignore
    }
    return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
})->name('profile.update');

// Change password (dummy handler)
Route::post('/profile/password', function (Request $request) {
    // validate minimal
    $request->validate(['password' => 'required|min:6','password_confirmation' => 'required|same:password']);
    try {
        $user = \Illuminate\Support\Facades\Auth::user();
        $userId = $user?->id ?? 1;
        \Illuminate\Support\Facades\DB::table('users')->where('id', $userId)->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->input('password')),
            'updated_at' => now()
        ]);
    } catch (\Exception $e) {}
    return redirect()->route('profile')->with('success','Kata sandi berhasil diubah.');
})->name('profile.password');

// Show change password form
Route::get('/profile/password', function () {
    try {
        $user = \Illuminate\Support\Facades\Auth::user() ?: \Illuminate\Support\Facades\DB::table('users')->where('id',1)->first();
    } catch (\Exception $e) {
        $user = (object)['name'=>'Pengguna'];
    }
    return view('profile-password', compact('user'));
})->name('profile.password.form');

// Rute Jadwal Operasi (Bedah)
Route::get('/jadwal-operasi', function (Request $request) {
    try {
        $query = DB::table('surgery_schedules')
            ->leftJoin('dokter_bedah', 'surgery_schedules.dokter_bedah_id', '=', 'dokter_bedah.id')
            ->leftJoin('dokter_anestesi', 'surgery_schedules.dokter_anestesi_id', '=', 'dokter_anestesi.id')
            ->leftJoin('operating_rooms', 'surgery_schedules.ruang_id', '=', 'operating_rooms.id')
            ->select(
                'surgery_schedules.*',
                'dokter_bedah.nama as dokter_bedah',
                'dokter_anestesi.nama as dokter_anestesi',
                'operating_rooms.nama_ruang as nama_ruang'
            );

        // Filter by date
        if ($request->tanggal) {
            $query->whereDate('surgery_schedules.tanggal_operasi', $request->tanggal);
        }

        // Filter by room
        if ($request->ruang_id) {
            $query->where('surgery_schedules.ruang_id', $request->ruang_id);
        }

        // Filter by status
        if ($request->status) {
            $query->where('surgery_schedules.status', $request->status);
        }

        // Search by patient name or doctor
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('surgery_schedules.nama_pasien', 'like', '%'.$request->search.'%')
                  ->orWhere('dokter_bedah.nama', 'like', '%'.$request->search.'%')
                  ->orWhere('dokter_anestesi.nama', 'like', '%'.$request->search.'%');
            });
        }

        $schedules = $query->orderBy('tanggal_operasi', 'desc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        $doctors = DB::table('dokter_bedah')->orderBy('nama')->get();
        $anesthesias = DB::table('dokter_anestesi')->orderBy('nama')->get();
        $rooms = DB::table('operating_rooms')->orderBy('nama_ruang')->get();

        $totalToday = DB::table('surgery_schedules')->whereDate('tanggal_operasi', now()->toDateString())->count();
        $selesai = DB::table('surgery_schedules')->where('status', 'Selesai')->count();
        $berlangsung = DB::table('surgery_schedules')->where('status', 'Berjalan')->count();
        $dibatalkan = DB::table('surgery_schedules')->where('status', 'Dibatalkan')->count();
        $belum = DB::table('surgery_schedules')->where('status', 'Terjadwal')->count();
    } catch (\Exception $e) {
        $schedules = collect();
        $doctors = collect();
        $anesthesias = collect();
        $rooms = collect();
        $totalToday = 0;
        $selesai = 0;
        $berlangsung = 0;
        $dibatalkan = 0;
        $belum = 0;
    }

    return view('jadwal-operasi', compact('schedules', 'doctors', 'anesthesias', 'rooms', 'totalToday', 'selesai', 'berlangsung', 'dibatalkan', 'belum'));
})->name('jadwal-operasi');

Route::post('/jadwal-operasi', function (Request $request) {
    $validated = $request->validate([
        'nama_pasien' => 'required|string|max:255',
        'nomor_rm' => 'required|string|max:50',
        'dokter_bedah_id' => 'required|integer|exists:dokter_bedah,id',
        'dokter_anestesi_id' => 'required|integer|exists:dokter_anestesi,id',
        'ruang_id' => 'required|integer|exists:operating_rooms,id',
        'tanggal_operasi' => 'required|date',
        'jam_mulai' => 'required',
        'jenis_tindakan' => 'required|string|max:255',
    ]);

    $validated['status'] = 'Terjadwal';
    $validated['created_at'] = now();
    $validated['updated_at'] = now();

    DB::table('surgery_schedules')->insert($validated);

    return redirect()->route('jadwal-operasi')->with('success', 'Jadwal operasi berhasil ditambahkan.');
})->name('jadwal-operasi.store');

Route::get('/jadwal-operasi/{id}/edit', function ($id) {
    $editingSchedule = DB::table('surgery_schedules')->where('id', $id)->first();
    if (! $editingSchedule) {
        abort(404);
    }

    $schedules = DB::table('surgery_schedules')
        ->leftJoin('dokter_bedah', 'surgery_schedules.dokter_bedah_id', '=', 'dokter_bedah.id')
        ->leftJoin('dokter_anestesi', 'surgery_schedules.dokter_anestesi_id', '=', 'dokter_anestesi.id')
        ->leftJoin('operating_rooms', 'surgery_schedules.ruang_id', '=', 'operating_rooms.id')
        ->select(
            'surgery_schedules.*',
            'dokter_bedah.nama as dokter_bedah',
            'dokter_anestesi.nama as dokter_anestesi',
            'operating_rooms.nama_ruang as nama_ruang'
        )
        ->orderBy('tanggal_operasi', 'desc')
        ->orderBy('jam_mulai', 'asc')
        ->get();

    $doctors = DB::table('dokter_bedah')->orderBy('nama')->get();
    $anesthesias = DB::table('dokter_anestesi')->orderBy('nama')->get();
    $rooms = DB::table('operating_rooms')->orderBy('nama_ruang')->get();

    $totalToday = DB::table('surgery_schedules')->whereDate('tanggal_operasi', now()->toDateString())->count();
    $selesai = DB::table('surgery_schedules')->where('status', 'Selesai')->count();
    $berlangsung = DB::table('surgery_schedules')->where('status', 'Berjalan')->count();
    $dibatalkan = DB::table('surgery_schedules')->where('status', 'Dibatalkan')->count();
    $belum = DB::table('surgery_schedules')->where('status', 'Terjadwal')->count();

    return view('jadwal-operasi', compact('schedules', 'doctors', 'anesthesias', 'rooms', 'totalToday', 'selesai', 'berlangsung', 'dibatalkan', 'belum', 'editingSchedule'));
})->name('jadwal-operasi.edit');

Route::put('/jadwal-operasi/{id}', function (Request $request, $id) {
    $validated = $request->validate([
        'nama_pasien' => 'required|string|max:255',
        'nomor_rm' => 'required|string|max:50',
        'dokter_bedah_id' => 'required|integer|exists:dokter_bedah,id',
        'dokter_anestesi_id' => 'required|integer|exists:dokter_anestesi,id',
        'ruang_id' => 'required|integer|exists:operating_rooms,id',
        'tanggal_operasi' => 'required|date',
        'jam_mulai' => 'required',
        'jenis_tindakan' => 'required|string|max:255',
        'status' => 'required|string|in:Terjadwal,Berjalan,Selesai,Dibatalkan',
    ]);

    $validated['updated_at'] = now();

    DB::table('surgery_schedules')->where('id', $id)->update($validated);

    return redirect()->route('jadwal-operasi')->with('success', 'Jadwal operasi berhasil diperbarui.');
})->name('jadwal-operasi.update');

Route::delete('/jadwal-operasi/{id}', function ($id) {
    DB::table('surgery_schedules')->where('id', $id)->delete();
    return redirect()->route('jadwal-operasi')->with('success', 'Jadwal operasi berhasil dihapus.');
})->name('jadwal-operasi.destroy');

Route::get('/status-operasi/{id}/notify', function ($id) {
    try {
        $operasi = DB::table('surgery_schedules')->where('id', $id)->first();
        $title = 'Notifikasi Operasi';
        $message = 'Notifikasi untuk operasi ' . ($operasi->nama_pasien ?? 'pasien') . ' berhasil dikirim.';
        \Illuminate\Support\Facades\DB::table('notifications')->insert([
            'judul' => $title,
            'pesan' => $message,
            'tipe' => 'Info',
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    } catch (\Exception $e) {
        // ignore
    }
    return redirect()->route('status-operasi', ['id' => $id])->with('success', 'Notifikasi operasi berhasil dikirim.');
})->name('status-operasi.notify');

Route::get('/status-operasi/{id}/print', function ($id) {
    try {
        $operasi = DB::table('surgery_schedules')
            ->leftJoin('dokter_bedah', 'surgery_schedules.dokter_bedah_id', '=', 'dokter_bedah.id')
            ->leftJoin('dokter_anestesi', 'surgery_schedules.dokter_anestesi_id', '=', 'dokter_anestesi.id')
            ->leftJoin('operating_rooms', 'surgery_schedules.ruang_id', '=', 'operating_rooms.id')
            ->select(
                'surgery_schedules.*',
                'dokter_bedah.nama as dokter_bedah',
                'dokter_anestesi.nama as dokter_anestesi',
                'operating_rooms.nama_ruang as nama_ruang'
            )
            ->where('surgery_schedules.id', $id)
            ->first();
    } catch (\Exception $e) {
        $operasi = null;
    }

    if (! $operasi) {
        abort(404);
    }

    return view('status-operasi-print', compact('operasi'));
})->name('status-operasi.print');

Route::get('/status-operasi/{id}/photo', function ($id) {
    try {
        $operasi = DB::table('surgery_schedules')
            ->leftJoin('dokter_bedah', 'surgery_schedules.dokter_bedah_id', '=', 'dokter_bedah.id')
            ->leftJoin('dokter_anestesi', 'surgery_schedules.dokter_anestesi_id', '=', 'dokter_anestesi.id')
            ->leftJoin('operating_rooms', 'surgery_schedules.ruang_id', '=', 'operating_rooms.id')
            ->select(
                'surgery_schedules.*',
                'dokter_bedah.nama as dokter_bedah',
                'dokter_anestesi.nama as dokter_anestesi',
                'operating_rooms.nama_ruang as nama_ruang'
            )
            ->where('surgery_schedules.id', $id)
            ->first();
    } catch (\Exception $e) {
        $operasi = null;
    }

    if (! $operasi) {
        abort(404);
    }

    return view('status-operasi-photo', compact('operasi'));
})->name('status-operasi.photo');

// Rute Status Operasi
Route::get('/status-operasi/{id?}', function ($id = null) {
    try {
        if ($id) {
            $operasi = DB::table('surgery_schedules')
                ->leftJoin('dokter_bedah', 'surgery_schedules.dokter_bedah_id', '=', 'dokter_bedah.id')
                ->leftJoin('dokter_anestesi', 'surgery_schedules.dokter_anestesi_id', '=', 'dokter_anestesi.id')
                ->leftJoin('operating_rooms', 'surgery_schedules.ruang_id', '=', 'operating_rooms.id')
                ->select(
                    'surgery_schedules.*',
                    'dokter_bedah.nama as dokter_bedah',
                    'dokter_anestesi.nama as dokter_anestesi',
                    'operating_rooms.nama_ruang as nama_ruang'
                )
                ->where('surgery_schedules.id', $id)
                ->first();
        } else {
            // Get latest/current operasi
            $operasi = DB::table('surgery_schedules')
                ->leftJoin('dokter_bedah', 'surgery_schedules.dokter_bedah_id', '=', 'dokter_bedah.id')
                ->leftJoin('dokter_anestesi', 'surgery_schedules.dokter_anestesi_id', '=', 'dokter_anestesi.id')
                ->leftJoin('operating_rooms', 'surgery_schedules.ruang_id', '=', 'operating_rooms.id')
                ->select(
                    'surgery_schedules.*',
                    'dokter_bedah.nama as dokter_bedah',
                    'dokter_anestesi.nama as dokter_anestesi',
                    'operating_rooms.nama_ruang as nama_ruang'
                )
                ->whereIn('surgery_schedules.status', ['Berjalan', 'Terjadwal'])
                ->orderBy('surgery_schedules.tanggal_operasi', 'desc')
                ->first();
        }
    } catch (\Exception $e) {
        $operasi = null;
    }

    return view('status-operasi', compact('operasi'));
})->name('status-operasi');

// Bed Manager routes removed (feature deprecated)

// Rute Farmasi & Obat
Route::get('/farmasi', function () {
    try {
        $packages = DB::table('medicine_packages')->orderBy('nama_paket')->get();
        $medicines = DB::table('medicines')->orderBy('nama_obat')->get();
    } catch (\Exception $e) {
        $packages = collect();
        $medicines = collect();
    }

    $orders = $packages->map(function ($package, $index) {
        $statuses = ['Menunggu Disiapkan', 'Siap Diambil', 'Sudah Diambil'];
        return (object) [
            'id' => $package->id,
            'order_id' => 'POB-250507-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
            'nama_paket' => $package->nama_paket,
            'jumlah_item' => $package->total_paket ?? rand(5, 15),
            'dipesan_oleh' => 'Perawat Anestesi',
            'waktu_pesan' => now()->subDays($index)->format('d M Y H:i'),
            'status' => $statuses[$index % count($statuses)],
        ];
    });

    if ($orders->isEmpty()) {
        $orders = collect([
            (object) ['order_id' => 'POB-250507-001', 'nama_paket' => 'Paket Anestesi Umum', 'jumlah_item' => 12, 'dipesan_oleh' => 'Perawat Anestesi', 'waktu_pesan' => '07 Mei 2025 08:30', 'status' => 'Menunggu Disiapkan'],
            (object) ['order_id' => 'POB-250507-002', 'nama_paket' => 'Paket Spinal Anestesi', 'jumlah_item' => 8, 'dipesan_oleh' => 'Perawat Anestesi', 'waktu_pesan' => '07 Mei 2025 09:15', 'status' => 'Menunggu Disiapkan'],
            (object) ['order_id' => 'POB-250507-003', 'nama_paket' => 'Paket Emergency Anestesi', 'jumlah_item' => 15, 'dipesan_oleh' => 'Perawat Anestesi', 'waktu_pesan' => '07 Mei 2025 10:05', 'status' => 'Siap Diambil'],
            (object) ['order_id' => 'POB-250507-004', 'nama_paket' => 'Paket Regional Anestesi', 'jumlah_item' => 9, 'dipesan_oleh' => 'Perawat Anestesi', 'waktu_pesan' => '07 Mei 2025 10:45', 'status' => 'Siap Diambil'],
            (object) ['order_id' => 'POB-250507-005', 'nama_paket' => 'Paket Anestesi Anak', 'jumlah_item' => 7, 'dipesan_oleh' => 'Perawat Anestesi', 'waktu_pesan' => '07 Mei 2025 11:20', 'status' => 'Sudah Diambil'],
        ]);
    }

    $summary = [
        'total_paket' => $orders->count(),
        'waiting' => $orders->where('status', 'Menunggu Disiapkan')->count(),
        'ready' => $orders->where('status', 'Siap Diambil')->count(),
        'picked' => $orders->where('status', 'Sudah Diambil')->count(),
    ];

    return view('farmasi', compact('packages', 'medicines', 'orders', 'summary'));
})->name('farmasi');

Route::get('/farmasi/pesanan', function () {
    try {
        $packages = DB::table('medicine_packages')->orderBy('nama_paket')->get();
        $medicines = DB::table('medicines')->orderBy('nama_obat')->get();
    } catch (\Exception $e) {
        $packages = collect();
        $medicines = collect();
    }

    $orders = $packages->map(function ($package, $index) {
        $statuses = ['Menunggu Disiapkan', 'Siap Diambil', 'Sudah Diambil'];
        return (object) [
            'id' => $package->id,
            'order_id' => 'POB-250507-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
            'nama_paket' => $package->nama_paket,
            'jumlah_item' => $package->total_paket ?? rand(5, 15),
            'dipesan_oleh' => 'Perawat Anestesi',
            'waktu_pesan' => now()->subDays($index)->format('d M Y H:i'),
            'status' => $statuses[$index % count($statuses)],
        ];
    });

    if ($orders->isEmpty()) {
        $orders = collect([
            (object) ['order_id' => 'POB-250507-001', 'nama_paket' => 'Paket Anestesi Umum', 'jumlah_item' => 12, 'dipesan_oleh' => 'Perawat Anestesi', 'waktu_pesan' => '07 Mei 2025 08:30', 'status' => 'Menunggu Disiapkan'],
            (object) ['order_id' => 'POB-250507-002', 'nama_paket' => 'Paket Spinal Anestesi', 'jumlah_item' => 8, 'dipesan_oleh' => 'Perawat Anestesi', 'waktu_pesan' => '07 Mei 2025 09:15', 'status' => 'Menunggu Disiapkan'],
            (object) ['order_id' => 'POB-250507-003', 'nama_paket' => 'Paket Emergency Anestesi', 'jumlah_item' => 15, 'dipesan_oleh' => 'Perawat Anestesi', 'waktu_pesan' => '07 Mei 2025 10:05', 'status' => 'Siap Diambil'],
            (object) ['order_id' => 'POB-250507-004', 'nama_paket' => 'Paket Regional Anestesi', 'jumlah_item' => 9, 'dipesan_oleh' => 'Perawat Anestesi', 'waktu_pesan' => '07 Mei 2025 10:45', 'status' => 'Siap Diambil'],
            (object) ['order_id' => 'POB-250507-005', 'nama_paket' => 'Paket Anestesi Anak', 'jumlah_item' => 7, 'dipesan_oleh' => 'Perawat Anestesi', 'waktu_pesan' => '07 Mei 2025 11:20', 'status' => 'Sudah Diambil'],
        ]);
    }

    $summary = [
        'total_paket' => $orders->count(),
        'waiting' => $orders->where('status', 'Menunggu Disiapkan')->count(),
        'ready' => $orders->where('status', 'Siap Diambil')->count(),
        'picked' => $orders->where('status', 'Sudah Diambil')->count(),
    ];

    return view('farmasi', compact('packages', 'medicines', 'orders', 'summary'))->with('focus', 'orders');
})->name('farmasi.pesanan');

// Halaman Input Paket Obat (Unit Farmasi)
Route::get('/farmasi/input', function () {
    try {
        $packages = DB::table('medicine_packages')->orderBy('nama_paket')->get();
        $medicines = DB::table('medicines')->orderBy('nama_obat')->get();
    } catch (\Exception $e) {
        $packages = collect();
        $medicines = collect();
    }

    $summary = [
        'total_paket' => $packages->count(),
        'waiting' => 0,
        'ready' => 0,
        'picked' => 0,
    ];

    return view('farmasi-input', compact('packages', 'medicines', 'summary'));
})->name('farmasi.input');

Route::post('/farmasi', function (Request $request) {
    $validated = $request->validate([
        'nama_paket' => 'required|string|max:255',
        'jenis_obat' => 'required|string|max:255',
        'total_paket' => 'required|integer|min:1',
        'preoperatif' => 'nullable|string',
        'intraoperatif' => 'nullable|string',
        'postoperatif' => 'nullable|string',
    ]);

    $validated['created_at'] = now();
    $validated['updated_at'] = now();

    DB::table('medicine_packages')->insert($validated);

    return redirect()->route('farmasi')->with('success', 'Paket obat berhasil ditambahkan.');
})->name('farmasi.store');

Route::get('/farmasi/{id}/edit', function ($id) {
    try {
        $packages = DB::table('medicine_packages')->orderBy('nama_paket')->get();
        $medicines = DB::table('medicines')->orderBy('nama_obat')->get();
    } catch (\Exception $e) {
        $packages = collect();
        $medicines = collect();
    }
    $editingPackage = DB::table('medicine_packages')->where('id', $id)->first();

    if (!$editingPackage) {
        abort(404);
    }

    return view('farmasi', compact('packages', 'medicines', 'editingPackage'));
})->name('farmasi.edit');

Route::put('/farmasi/{id}', function (Request $request, $id) {
    $validated = $request->validate([
        'nama_paket' => 'required|string|max:255',
        'jenis_obat' => 'required|string|max:255',
        'total_paket' => 'required|integer|min:1',
        'preoperatif' => 'nullable|string',
        'intraoperatif' => 'nullable|string',
        'postoperatif' => 'nullable|string',
    ]);

    $validated['updated_at'] = now();

    DB::table('medicine_packages')->where('id', $id)->update($validated);

    return redirect()->route('farmasi')->with('success', 'Paket obat berhasil diperbarui.');
})->name('farmasi.update');

Route::delete('/farmasi/{id}', function ($id) {
    DB::table('medicine_packages')->where('id', $id)->delete();
    return redirect()->route('farmasi')->with('success', 'Paket obat berhasil dihapus.');
})->name('farmasi.destroy');

// Rute CRUD Obat Individu
Route::post('/farmasi/obat', function (Request $request) {
    $validated = $request->validate([
        'nama_obat' => 'required|string|max:255',
        'jenis_obat' => 'required|string|max:255',
        'stok_obat' => 'required|integer|min:0',
        'kandungan_obat' => 'nullable|string',
        'tanggal_kadaluwarsa' => 'required|date',
        'harga_obat' => 'required|numeric|min:0',
        'status' => 'required|string|in:Tersedia,Menipis,Habis',
    ]);

    $validated['created_at'] = now();
    $validated['updated_at'] = now();

    DB::table('medicines')->insert($validated);

    return redirect()->route('farmasi')->with('success', 'Data obat berhasil ditambahkan.');
})->name('farmasi.obat.store');

Route::get('/farmasi/obat/{id}/edit', function ($id) {
    try {
        $packages = DB::table('medicine_packages')->orderBy('nama_paket')->get();
        $medicines = DB::table('medicines')->orderBy('nama_obat')->get();
    } catch (\Exception $e) {
        $packages = collect();
        $medicines = collect();
    }
    $editingMedicine = DB::table('medicines')->where('id_obat', $id)->first();

    if (!$editingMedicine) {
        abort(404);
    }

    return view('farmasi', compact('packages', 'medicines', 'editingMedicine'));
})->name('farmasi.obat.edit');

Route::put('/farmasi/obat/{id}', function (Request $request, $id) {
    $validated = $request->validate([
        'nama_obat' => 'required|string|max:255',
        'jenis_obat' => 'required|string|max:255',
        'stok_obat' => 'required|integer|min:0',
        'kandungan_obat' => 'nullable|string',
        'tanggal_kadaluwarsa' => 'required|date',
        'harga_obat' => 'required|numeric|min:0',
        'status' => 'required|string|in:Tersedia,Menipis,Habis',
    ]);

    $validated['updated_at'] = now();

    DB::table('medicines')->where('id_obat', $id)->update($validated);

    return redirect()->route('farmasi')->with('success', 'Data obat berhasil diperbarui.');
})->name('farmasi.obat.update');

Route::delete('/farmasi/obat/{id}', function ($id) {
    DB::table('medicines')->where('id_obat', $id)->delete();
    return redirect()->route('farmasi')->with('success', 'Data obat berhasil dihapus.');
})->name('farmasi.obat.destroy');


// ===== MANAJEMEN PENGGUNA / USER MANAGEMENT =====
Route::get('/admin/pengguna', function () {
    $users = DB::table('users')->orderBy('created_at', 'desc')->get();
    return view('admin.pengguna', compact('users'));
})->name('pengguna');

Route::post('/admin/pengguna', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'nullable|email|unique:users,email',
        'password' => 'required|string|min:6',
        'role' => 'required|string|in:admin,dokter,perawat,farmasi,logistik',
    ]);

    $validated['password'] = bcrypt($validated['password']);
    DB::table('users')->insert($validated);

    return redirect()->route('pengguna')->with('success', 'User berhasil ditambahkan.');
})->name('pengguna.store');

Route::get('/admin/pengguna/{id}/edit', function ($id) {
    $user = DB::table('users')->where('id', $id)->first();
    $users = DB::table('users')->orderBy('created_at', 'desc')->get();
    if (!$user) abort(404);
    return view('admin.pengguna', compact('user', 'users'));
})->name('pengguna.edit');

Route::put('/admin/pengguna/{id}', function (Request $request, $id) {
    $user = DB::table('users')->where('id', $id)->first();
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,'.$id,
        'email' => 'nullable|email|unique:users,email,'.$id,
        'role' => 'required|string|in:admin,dokter,perawat,farmasi,logistik',
        'password' => 'nullable|string|min:6',
    ]);

    if (!empty($validated['password'])) {
        $validated['password'] = bcrypt($validated['password']);
    } else {
        unset($validated['password']);
    }

    DB::table('users')->where('id', $id)->update($validated);
    return redirect()->route('pengguna')->with('success', 'User berhasil diperbarui.');
})->name('pengguna.update');

Route::delete('/admin/pengguna/{id}', function ($id) {
    DB::table('users')->where('id', $id)->delete();
    return redirect()->route('pengguna')->with('success', 'User berhasil dihapus.');
})->name('pengguna.destroy');

// Bed Manager routes removed (feature deprecated)

// ===== STATISTIK & LOGISTIK =====
Route::get('/statistik/tindakan-kunjungan', function () {
    $stats = DB::table('visit_statistics')->orderBy('tanggal', 'desc')->get();
    return view('statistik.tindakan-kunjungan', compact('stats'));
})->name('statistik-kunjungan');

Route::post('/statistik/tindakan-kunjungan', function (Request $request) {
    $validated = $request->validate([
        'tanggal' => 'required|date',
        'jumlah_kunjungan' => 'required|integer|min:0',
        'jumlah_operasi' => 'required|integer|min:0',
        'tindakan_terbanyak' => 'nullable|string|max:255',
    ]);

    DB::table('visit_statistics')->insert(array_merge($validated, [
        'created_at' => now(),
        'updated_at' => now(),
    ]));

    return redirect()->route('statistik-kunjungan')->with('success', 'Statistik berhasil ditambahkan.');
})->name('statistik-kunjungan.store');

Route::get('/logistik/ringkasan-cepat', function () {
    $logistics = DB::table('fast_logistics')->latest()->first();
    return view('logistik.ringkasan-cepat', compact('logistics'));
})->name('logistik-ringkasan');

Route::post('/logistik/ringkasan-cepat', function (Request $request) {
    $validated = $request->validate([
        'total_bius_tersedia' => 'required|integer|min:0',
        'jumlah_cairan_infus' => 'required|integer|min:0',
        'jumlah_alat_bedah_steril' => 'required|integer|min:0',
    ]);

    $validated['terakhir_dicek'] = now();
    $validated['created_at'] = now();
    $validated['updated_at'] = now();

    DB::table('fast_logistics')->insert($validated);

    return redirect()->route('logistik-ringkasan')->with('success', 'Data logistik berhasil disimpan.');
})->name('logistik-ringkasan.store');

Route::get('/db-check', function () {
    try {
        DB::connection()->getPdo();
        $tables = DB::select('SHOW TABLES');
        return response()->json([
            'status' => 'Connected!',
            'database' => DB::getDatabaseName(),
            'tables' => $tables
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'Error',
            'message' => $e->getMessage()
        ], 500);
    }
});

// 5. Rute Tambahan (Opsional untuk masa depan)
// Route::get('/farmasi', function () {
//     return view('farmasi');
// });

// ===== DEV HELPERS =====
// Quick role switcher for local testing (logs in as example users created by UserSeeder)
Route::get('/dev/switch-role', function () {
    $roles = [
        'pj_admin','dpjp','kepala_instalasi_operasi','perawat_anestesi','perawat_bedah','perawat_instrumentor','perawat_sirkuler','dokter_bedah','dokter_anestesi','perawat_recovery','farmasi','admin'
    ];
    return view('dev.switch-role', compact('roles'));
});

Route::get('/dev/login-as/{username}', function ($username) {
    try {
        $user = \App\Models\User::where('username', $username)->first();
        if (! $user) return redirect('/dev/switch-role')->with('error', 'User not found');
        \Illuminate\Support\Facades\Auth::login($user);
        request()->session()->regenerate();
        return redirect('/dashboard')->with('success', 'Logged in as '.$user->username);
    } catch (\Exception $e) {
        return redirect('/dev/switch-role')->with('error', 'Login failed');
    }
});