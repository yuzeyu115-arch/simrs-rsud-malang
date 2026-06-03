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

    if (! $user || ! \Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
        return back()->withErrors(['email' => 'Kredensial tidak cocok'])->withInput();
    }

    \Illuminate\Support\Facades\Auth::login($user);
    $request->session()->regenerate();

    // Redirect based on role (simple mapping)
    $role = $user->role ?? 'guest';
    $roleRoutes = [
        'farmasi' => url('/farmasi'),
        'gizi' => url('/gizi'),
        'dokter' => url('/dashboard'),
        'dokter_bedah' => url('/jadwal-operasi'),
        'dokter_anestesi' => url('/jadwal-operasi'),
        'perawat' => url('/bed-manager'),
        'perawat_instrumentor' => url('/jadwal-operasi'),
        'admin' => url('/admin/pengguna'),
        'pj_admin' => url('/dashboard'),
        'dpjp' => url('/dashboard'),
    ];

    $target = $roleRoutes[$role] ?? url('/dashboard');
    return redirect()->intended($target);
})->middleware('guest')->name('login.post');

// 4. Rute Dashboard Utama (Dinamis dari Database dengan Fallback)
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
        
        $appointmentHariIni = DB::table('appointments')
            ->whereDate('tanggal_janji', now()->toDateString())
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
        $appointmentHariIni = 12;
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
        'criticalStock', 'operasiHariIni', 'appointmentHariIni',
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
    // minimal update: attempt to update authenticated user if exists
    try {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user) {
            \Illuminate\Support\Facades\DB::table('users')->where('id', $user->id)->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'updated_at' => now()
            ]);
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
        if ($user) {
            \Illuminate\Support\Facades\DB::table('users')->where('id', $user->id)->update([
                'password' => \Illuminate\Support\Facades\Hash::make($request->input('password')),
                'updated_at' => now()
            ]);
        }
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

// Rute Bed Manager
Route::get('/bed-manager', function () {
    return view('bed-manager');
})->name('bed-manager');

// Rute Farmasi & Obat
Route::get('/farmasi', function () {
    try {
        $packages = DB::table('medicine_packages')->orderBy('nama_paket')->get();
        $medicines = DB::table('medicines')->orderBy('nama_obat')->get();
    } catch (\Exception $e) {
        $packages = collect();
        $medicines = collect();
    }
    return view('farmasi', compact('packages', 'medicines'));
})->name('farmasi');

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

// Rute Gizi
Route::get('/gizi', function () {
    try {
        $todayOrders = DB::table('pemesanan_menu')->whereDate('tanggal', now()->toDateString())->count();
        $todayReports = DB::table('laporan_pemesanan')->whereDate('created_at', now()->toDateString())->count();
        $todaySchedules = DB::table('jadwal_makan')->whereDate('created_at', now()->toDateString())->count();
        $latestOrders = DB::table('pemesanan_menu')->orderBy('tanggal', 'desc')->limit(5)->get();
    } catch (\Exception $e) {
        $todayOrders = 0;
        $todayReports = 0;
        $todaySchedules = 0;
        $latestOrders = collect();
    }

    $stats = [
        'today_orders' => $todayOrders,
        'delta_orders' => 0,
        'today_reports' => $todayReports,
        'delta_reports' => 0,
        'today_schedules' => $todaySchedules,
        'delta_schedules' => 0,
    ];

    return view('gizi', compact('stats', 'latestOrders'));
})->name('gizi');

// Preview halaman desain Figma (non-destruktif)
Route::get('/gizi/figma', function () {
    try {
        $todayOrders = DB::table('pemesanan_menu')->whereDate('tanggal', now()->toDateString())->count();
        $todayReports = DB::table('laporan_pemesanan')->whereDate('created_at', now()->toDateString())->count();
        $todaySchedules = DB::table('jadwal_makan')->whereDate('created_at', now()->toDateString())->count();
        $latestOrders = DB::table('pemesanan_menu')->orderBy('tanggal', 'desc')->limit(8)->get();
    } catch (\Exception $e) {
        $todayOrders = 0;
        $todayReports = 0;
        $todaySchedules = 0;
        $latestOrders = collect();
    }

    $stats = [
        'today_orders' => $todayOrders,
        'delta_orders' => 0,
        'today_reports' => $todayReports,
        'delta_reports' => 0,
        'today_schedules' => $todaySchedules,
        'delta_schedules' => 0,
    ];

    return view('gizi.figma-page', compact('stats', 'latestOrders'));
})->name('gizi.figma');

// Rute Janji Temu
Route::get('/janji-temu', function () {
    try {
        $doctors = DB::table('dokter_bedah')->orderBy('nama')->get();
        $rooms = DB::table('operating_rooms')->orderBy('nama_ruang')->get();
    } catch (\Exception $e) {
        $doctors = collect();
        $rooms = collect();
    }

    return view('janji-temu', compact('doctors', 'rooms'));
})->name('janji-temu');

Route::post('/janji-temu', function (Request $request) {
    $validated = $request->validate([
        'nama_pasien' => 'required|string|max:255',
        'nomor_rm' => 'nullable|string|max:50',
        'tanggal_janji' => 'required|date',
        'jam_janji' => 'required',
        'poliklinik' => 'required|string|max:255',
        'dokter_tujuan' => 'required|string|max:255',
        'jenis' => 'required|string|max:255',
        'prioritas' => 'nullable|string|in:Normal,Urgent,Emergency',
        'catatan' => 'nullable|string|max:1000',
    ]);

    $validated['status'] = 'Terjadwal';
    $validated['created_at'] = now();
    $validated['updated_at'] = now();

    DB::table('appointments')->insert($validated);

    return redirect()->route('janji-temu')->with('success', 'Janji temu berhasil ditambahkan.');
})->name('janji-temu.store');

Route::get('/janji-temu/{id}/edit', function ($id) {
    $appointment = DB::table('appointments')->where('id', $id)->first();
    if (! $appointment) {
        abort(404);
    }
    $doctors = DB::table('dokter_bedah')->orderBy('nama')->get();
    $rooms = DB::table('operating_rooms')->orderBy('nama_ruang')->get();
    return view('janji-temu', compact('doctors', 'rooms', 'appointment'));
})->name('janji-temu.edit');

Route::put('/janji-temu/{id}', function (Request $request, $id) {
    $validated = $request->validate([
        'nama_pasien' => 'required|string|max:255',
        'nomor_rm' => 'nullable|string|max:50',
        'tanggal_janji' => 'required|date',
        'jam_janji' => 'required',
        'poliklinik' => 'required|string|max:255',
        'dokter_tujuan' => 'required|string|max:255',
        'jenis' => 'required|string|max:255',
        'prioritas' => 'nullable|string|in:Normal,Urgent,Emergency',
        'catatan' => 'nullable|string|max:1000',
        'status' => 'nullable|string|in:Terjadwal,Selesai,Menunggu,Dibatalkan',
    ]);

    $validated['updated_at'] = now();

    DB::table('appointments')->where('id', $id)->update($validated);

    return redirect()->route('janji-temu.list')->with('success', 'Janji temu berhasil diperbarui.');
})->name('janji-temu.update');

Route::delete('/janji-temu/{id}', function ($id) {
    DB::table('appointments')->where('id', $id)->delete();
    return redirect()->route('janji-temu.list')->with('success', 'Janji temu berhasil dihapus.');
})->name('janji-temu.destroy');

Route::get('/janji-temu/list', function () {
    $appointments = DB::table('appointments')->orderBy('tanggal_janji', 'asc')->get();
    return view('list-appointment', ['appointments' => $appointments]);
})->name('janji-temu.list');

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
        'role' => 'required|string|in:admin,dokter,perawat,farmasi,gizi,logistik',
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
        'role' => 'required|string|in:admin,dokter,perawat,farmasi,gizi,logistik',
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

// ===== PEMESANAN MENU =====
// Form untuk membuat pemesanan baru (halaman terpisah)
Route::get('/gizi/pemesanan-menu/create', function () {
    $rooms = DB::table('operating_rooms')->orderBy('nama_ruang')->get();
    try {
        $menusList = DB::table('menus')->orderBy('nama_menu')->get();
    } catch (\Exception $e) {
        $menusList = collect();
    }
    return view('gizi.create-pemesanan-menu', compact('rooms', 'menusList'));
})->name('pemesanan-menu.create');

Route::get('/gizi/pemesanan-menu', function () {
    try {
        $menus = DB::table('pemesanan_menu')->orderBy('tanggal', 'desc')->get();
        // try to load master menu items if available
        try {
            $menusList = DB::table('menus')->orderBy('nama_menu')->get();
        } catch (\Exception $e) {
            $menusList = collect();
        }

        $todayOrders = DB::table('pemesanan_menu')->whereDate('tanggal', now()->toDateString())->count();
        try {
            $todayReports = DB::table('laporan_pemesanan')->whereDate('created_at', now()->toDateString())->count();
        } catch (\Exception $e) {
            $todayReports = 0;
        }
        $todaySchedules = DB::table('jadwal_makan')->whereDate('created_at', now()->toDateString())->count();

        $stats = [
            'today_orders' => $todayOrders,
            'delta_orders' => 0,
            'today_reports' => $todayReports,
            'delta_reports' => 0,
            'today_schedules' => $todaySchedules,
            'delta_schedules' => 0,
        ];
    } catch (\Exception $e) {
        $menus = collect();
        $menusList = collect();
        $stats = [
            'today_orders' => 0,
            'delta_orders' => 0,
            'today_reports' => 0,
            'delta_reports' => 0,
            'today_schedules' => 0,
            'delta_schedules' => 0,
        ];
    }

    return view('gizi.pemesanan-menu', compact('menus', 'menusList', 'stats'));
})->name('pemesanan-menu');

Route::post('/gizi/pemesanan-menu', function (Request $request) {
    $validated = $request->validate([
        'ruang' => 'required|string|max:255',
        'kelas' => 'required|string|max:255',
        'nama_pasien' => 'required|string|max:255',
        'shift' => 'required|in:Pagi,Siang,Sore',
        'tanggal' => 'required|date',
        'catatan' => 'nullable|string',
    ]);

    $validated['created_at'] = now();
    $validated['updated_at'] = now();
    DB::table('pemesanan_menu')->insert($validated);

    return redirect()->route('pemesanan-menu')->with('success', 'Pemesanan menu berhasil ditambahkan.');
})->name('pemesanan-menu.store');

Route::get('/gizi/pemesanan-menu/{id}/edit', function ($id) {
    $menu = DB::table('pemesanan_menu')->where('id', $id)->first();
    $menus = DB::table('pemesanan_menu')->orderBy('tanggal', 'desc')->get();
    if (!$menu) abort(404);
    return view('gizi.pemesanan-menu', compact('menu', 'menus'));
})->name('pemesanan-menu.edit');

Route::put('/gizi/pemesanan-menu/{id}', function (Request $request, $id) {
    $validated = $request->validate([
        'ruang' => 'required|string|max:255',
        'kelas' => 'required|string|max:255',
        'nama_pasien' => 'required|string|max:255',
        'shift' => 'required|in:Pagi,Siang,Sore',
        'tanggal' => 'required|date',
        'catatan' => 'nullable|string',
    ]);

    $validated['updated_at'] = now();
    DB::table('pemesanan_menu')->where('id', $id)->update($validated);

    return redirect()->route('pemesanan-menu')->with('success', 'Pemesanan menu berhasil diperbarui.');
})->name('pemesanan-menu.update');

Route::delete('/gizi/pemesanan-menu/{id}', function ($id) {
    DB::table('pemesanan_menu')->where('id', $id)->delete();
    return redirect()->route('pemesanan-menu')->with('success', 'Pemesanan menu berhasil dihapus.');
})->name('pemesanan-menu.destroy');

// ===== JADWAL MAKAN =====
Route::get('/gizi/jadwal-makan', function () {
    $jadwal = DB::table('jadwal_makan')->orderBy('created_at', 'desc')->get();
    try {
        $todayOrders = DB::table('pemesanan_menu')->whereDate('tanggal', now()->toDateString())->count();
        $todayReports = DB::table('laporan_pemesanan')->whereDate('created_at', now()->toDateString())->count();
        $todaySchedules = DB::table('jadwal_makan')->whereDate('created_at', now()->toDateString())->count();
    } catch (\Exception $e) {
        $todayOrders = 0;
        $todayReports = 0;
        $todaySchedules = 0;
    }
    $stats = [
        'today_orders' => $todayOrders,
        'delta_orders' => 0,
        'today_reports' => $todayReports,
        'delta_reports' => 0,
        'today_schedules' => $todaySchedules,
        'delta_schedules' => 0,
    ];
    return view('gizi.jadwal-makan', compact('jadwal', 'stats'));
})->name('jadwal-makan');

Route::post('/gizi/jadwal-makan', function (Request $request) {
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'jam_pesan' => 'required|date_format:H:i',
        'shift' => 'required|in:Pagi,Siang,Sore',
    ]);

    $validated['created_at'] = now();
    $validated['updated_at'] = now();
    DB::table('jadwal_makan')->insert($validated);

    return redirect()->route('jadwal-makan')->with('success', 'Jadwal makan berhasil ditambahkan.');
})->name('jadwal-makan.store');

Route::get('/gizi/jadwal-makan/{id}/edit', function ($id) {
    $jadwalItem = DB::table('jadwal_makan')->where('id', $id)->first();
    $jadwal = DB::table('jadwal_makan')->orderBy('created_at', 'desc')->get();
    if (!$jadwalItem) abort(404);
    return view('gizi.jadwal-makan', compact('jadwalItem', 'jadwal'));
})->name('jadwal-makan.edit');

Route::put('/gizi/jadwal-makan/{id}', function (Request $request, $id) {
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'jam_pesan' => 'required|date_format:H:i',
        'shift' => 'required|in:Pagi,Siang,Sore',
    ]);

    $validated['updated_at'] = now();
    DB::table('jadwal_makan')->where('id', $id)->update($validated);

    return redirect()->route('jadwal-makan')->with('success', 'Jadwal makan berhasil diperbarui.');
})->name('jadwal-makan.update');

Route::delete('/gizi/jadwal-makan/{id}', function ($id) {
    DB::table('jadwal_makan')->where('id', $id)->delete();
    return redirect()->route('jadwal-makan')->with('success', 'Jadwal makan berhasil dihapus.');
})->name('jadwal-makan.destroy');

// ===== MANAJEMEN BED / INPATIENT BEDS =====
Route::get('/bed-manager-list', function () {
    $beds = DB::table('inpatient_beds')->orderBy('created_at', 'desc')->get();
    return view('bed-manager-list', compact('beds'));
})->name('bed-manager-list');

Route::post('/bed-manager-add', function (Request $request) {
    $validated = $request->validate([
        'gedung' => 'required|string|max:255',
        'lantai' => 'required|string|max:255',
        'ruangan' => 'required|string|max:255',
        'no_bed' => 'required|string|max:255',
        'jenis_kamar' => 'required|string|max:255',
    ]);

    $validated['status'] = 'Tersedia';
    $validated['created_at'] = now();
    $validated['updated_at'] = now();
    DB::table('inpatient_beds')->insert($validated);

    return redirect()->route('bed-manager-list')->with('success', 'Bed berhasil ditambahkan.');
})->name('bed-manager.store');

Route::get('/bed-manager/{id}/edit', function ($id) {
    $bed = DB::table('inpatient_beds')->where('id', $id)->first();
    $beds = DB::table('inpatient_beds')->orderBy('created_at', 'desc')->get();
    if (!$bed) abort(404);
    return view('bed-manager-list', compact('bed', 'beds'));
})->name('bed-manager.edit');

Route::put('/bed-manager/{id}', function (Request $request, $id) {
    $validated = $request->validate([
        'gedung' => 'required|string|max:255',
        'lantai' => 'required|string|max:255',
        'ruangan' => 'required|string|max:255',
        'no_bed' => 'required|string|max:255',
        'jenis_kamar' => 'required|string|max:255',
        'status' => 'required|in:Tersedia,Terisi,Booking,Maintenance',
        'nama_pasien' => 'nullable|string|max:255',
    ]);

    $validated['updated_at'] = now();
    DB::table('inpatient_beds')->where('id', $id)->update($validated);

    return redirect()->route('bed-manager-list')->with('success', 'Bed berhasil diperbarui.');
})->name('bed-manager.update');

Route::delete('/bed-manager/{id}', function ($id) {
    DB::table('inpatient_beds')->where('id', $id)->delete();
    return redirect()->route('bed-manager-list')->with('success', 'Bed berhasil dihapus.');
})->name('bed-manager.destroy');

// ===== RAPAT KOORDINASI / COORDINATION MEETINGS =====
Route::get('/bedah/rapat-koordinasi', function () {
    $meetings = DB::table('coordination_meetings')->orderBy('tanggal_rapat', 'desc')->get();
    return view('bedah.rapat-koordinasi', compact('meetings'));
})->name('rapat-koordinasi');

Route::post('/bedah/rapat-koordinasi', function (Request $request) {
    $validated = $request->validate([
        'judul_rapat' => 'required|string|max:255',
        'tanggal_rapat' => 'required|date',
        'pimpinan_rapat' => 'required|string|max:255',
        'peserta_rapat' => 'required|string',
        'notulen_hasil' => 'required|string',
        'lampiran_dokumen' => 'nullable|string',
    ]);

    $validated['created_at'] = now();
    $validated['updated_at'] = now();
    DB::table('coordination_meetings')->insert($validated);

    return redirect()->route('rapat-koordinasi')->with('success', 'Rapat koordinasi berhasil ditambahkan.');
})->name('rapat-koordinasi.store');

Route::get('/bedah/rapat-koordinasi/{id}/edit', function ($id) {
    $meetingItem = DB::table('coordination_meetings')->where('id', $id)->first();
    $meetings = DB::table('coordination_meetings')->orderBy('tanggal_rapat', 'desc')->get();
    if (!$meetingItem) abort(404);
    return view('bedah.rapat-koordinasi', compact('meetingItem', 'meetings'));
})->name('rapat-koordinasi.edit');

Route::put('/bedah/rapat-koordinasi/{id}', function (Request $request, $id) {
    $validated = $request->validate([
        'judul_rapat' => 'required|string|max:255',
        'tanggal_rapat' => 'required|date',
        'pimpinan_rapat' => 'required|string|max:255',
        'peserta_rapat' => 'required|string',
        'notulen_hasil' => 'required|string',
        'lampiran_dokumen' => 'nullable|string',
    ]);

    $validated['updated_at'] = now();
    DB::table('coordination_meetings')->where('id', $id)->update($validated);

    return redirect()->route('rapat-koordinasi')->with('success', 'Rapat koordinasi berhasil diperbarui.');
})->name('rapat-koordinasi.update');

Route::delete('/bedah/rapat-koordinasi/{id}', function ($id) {
    DB::table('coordination_meetings')->where('id', $id)->delete();
    return redirect()->route('rapat-koordinasi')->with('success', 'Rapat koordinasi berhasil dihapus.');
})->name('rapat-koordinasi.destroy');

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
        'pj_admin','dpjp','kepala_instalasi_operasi','perawat_anestesi','perawat_bedah','perawat_instrumentor','perawat_sirkuler','dokter_bedah','dokter_anestesi','perawat_recovery','farmasi','gizi','admin'
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