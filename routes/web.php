<?php

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini adalah tempat Anda mendaftarkan rute web untuk aplikasi SimpleOK.
|
*/

$requireRole = static function (array $roles): void {
    /** @var User|null $user */
    $user = Auth::user();

    // Expand role aliases: tpp => rekam_medis, kpp => perawat
    $roleAliases = [
        'tpp' => 'rekam_medis',
        'kpp' => 'perawat',
    ];
    $expandedRoles = [];
    foreach ($roles as $r) {
        $expandedRoles[] = $r;
        if (isset($roleAliases[$r])) {
            $expandedRoles[] = $roleAliases[$r];
        }
        // Also add reverse lookup
        $reverse = array_search($r, $roleAliases, true);
        if ($reverse !== false) {
            $expandedRoles[] = $reverse;
        }
    }
    $expandedRoles = array_unique($expandedRoles);

    if (! $user || ! in_array($user->role, $expandedRoles, true)) {
        abort(403, 'Akses ditolak.');
    }
};

$notifyRoles = static function (array $roles, string $judul, string $pesan, string $tipe = 'Info'): void {
    $userIds = User::query()
        ->when(! in_array('*', $roles, true), fn ($query) => $query->whereIn('role', $roles))
        ->pluck('id');

    $rows = $userIds->map(fn ($userId) => [
        'user_id' => $userId,
        'judul' => $judul,
        'pesan' => $pesan,
        'tipe' => $tipe,
        'is_read' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ])->all();

    if ($rows) {
        DB::table('notifications')->insert($rows);
    }
};

$buildFarmasiOrders = static function () {
    $orders = DB::table('anesthesia_package_orders')
        ->join('medicine_packages', 'anesthesia_package_orders.medicine_package_id', '=', 'medicine_packages.id')
        ->leftJoin('surgery_schedules', 'anesthesia_package_orders.surgery_schedule_id', '=', 'surgery_schedules.id')
        ->leftJoin('users', 'anesthesia_package_orders.requested_by', '=', 'users.id')
        ->select(
            'anesthesia_package_orders.*',
            'medicine_packages.nama_paket',
            'medicine_packages.total_paket as jumlah_item',
            'surgery_schedules.nama_pasien',
            'surgery_schedules.nomor_rm',
            'users.name as dipesan_oleh'
        )
        ->orderByDesc('anesthesia_package_orders.created_at')
        ->get();

    return $orders->map(function ($order) {
        $order->order_id = 'POB-'.date('ymd', strtotime($order->created_at)).'-'.str_pad((string) $order->id, 3, '0', STR_PAD_LEFT);
        $order->waktu_pesan = date('d M Y H:i', strtotime($order->created_at));
        $order->dipesan_oleh = $order->dipesan_oleh ?: 'Perawat Anestesi';

        return $order;
    });
};

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
    $user = User::where('username', 'simrsITSK')->first();
    if (! $user) {
        abort(404, 'User simrsITSK tidak ditemukan.');
    }

    Auth::login($user);
    request()->session()->regenerate();

    return redirect()->route('dashboard');
})->name('auto-login');

// Rute Logout (GET untuk memudahkan dari sidebar)
Route::get('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout.get');

Route::post('/login', function (Request $request) {
    $data = $request->validate([
        'password' => ['required'],
        // accept either username or email
        'username' => ['nullable', 'required_without:email'],
        'email' => ['nullable', 'required_without:username'],
    ]);

    // Determine identifier (prefer username field if present)
    $identifier = trim((string) ($request->input('username') ?: $request->input('email')));
    $normalizedIdentifier = strtolower($identifier);

    // Map static shortcut users to roles that exist in the users.role enum
    $staticUsers = [
        'dpjb' => ['password' => 'SimrsRSUD!', 'role' => 'dokter', 'name' => 'DPJB'],
        'adminrsud' => ['password' => 'SimrsRSUD!', 'role' => 'admin', 'name' => 'Admin RSUD'],
        'tpp' => ['password' => 'SimrsRSUD!', 'role' => 'rekam_medis', 'name' => 'TPP'],
        'kpp' => ['password' => 'SimrsRSUD!', 'role' => 'perawat', 'name' => 'KPP'],
        'farmasi' => ['password' => 'SimrsRSUD!', 'role' => 'farmasi', 'name' => 'Unit Farmasi'],
        'kepanes' => ['password' => 'SimrsRSUD!', 'role' => 'anestesi', 'name' => 'Perawat Anestesi'],
        // full-username shortcuts (from request)
        'tppsimpleok' => ['password' => 'tpp123', 'role' => 'rekam_medis', 'name' => 'TPP'],
        'kppsimpleok' => ['password' => 'kpp123', 'role' => 'perawat', 'name' => 'KPP'],
        'dpjbsimpleok' => ['password' => 'dpjb123', 'role' => 'dokter', 'name' => 'DPJB'],
        'peransimpleok' => ['password' => 'anestesi123', 'role' => 'anestesi', 'name' => 'Perawat Anestesi'],
        'farmasisimpleok' => ['password' => 'farmasi123', 'role' => 'farmasi', 'name' => 'Unit Farmasi'],
    ];

    $shortcutUserMap = [
        'tppsimpleok' => ['username' => 'tppSimpleOk', 'password' => 'tpp123', 'role' => 'rekam_medis', 'name' => 'TPP'],
        'kppsimpleok' => ['username' => 'kppSimpleOk', 'password' => 'kpp123', 'role' => 'perawat', 'name' => 'KPP'],
        'dpjbsimpleok' => ['username' => 'dpjbSimpleOk', 'password' => 'dpjb123', 'role' => 'dokter', 'name' => 'DPJB'],
        'peransimpleok' => ['username' => 'peranSimpleOk', 'password' => 'anestesi123', 'role' => 'anestesi', 'name' => 'Perawat Anestesi'],
        'farmasisimpleok' => ['username' => 'farmasiSimpleOk', 'password' => 'farmasi123', 'role' => 'farmasi', 'name' => 'Unit Farmasi'],
    ];

    $knownCredentialPasswords = [
        'tppsimpleok' => 'tpp123',
        'kppsimpleok' => 'kpp123',
        'dpjbsimpleok' => 'dpjb123',
        'peransimpleok' => 'anestesi123',
        'farmasisimpleok' => 'farmasi123',
    ];

    try {
        $user = User::where('email', $identifier)
            ->orWhereRaw('LOWER(username) = ?', [$normalizedIdentifier])
            ->first();
    } catch (QueryException $e) {
        // Attempt to recover from missing users table by running migrations and seeder once
        try {
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('db:seed', ['--class' => 'UserSeeder', '--force' => true]);
        } catch (Exception $inner) {
            $msg = 'Database belum siap dan pemulihan otomatis gagal. Jalankan skrip restore manual.';

            return back()->withErrors(['database' => $msg]);
        }

        // Retry lookup after recovery
        $user = User::where('email', $identifier)
            ->orWhereRaw('LOWER(username) = ?', [$normalizedIdentifier])
            ->first();
    }

    $shortcutUser = $shortcutUserMap[$normalizedIdentifier] ?? null;

    if (! $user && isset($staticUsers[$normalizedIdentifier])) {
        $static = $staticUsers[$normalizedIdentifier];
        // compare against validated password input
        if (($data['password'] ?? null) === $static['password']) {
            $createData = [
                'name' => $static['name'],
                'email' => $normalizedIdentifier.'@simrs.local',
                'role' => $static['role'],
                'password' => Hash::make($static['password']),
            ];

            // Mapping of roles that may not exist in all database schemas
            $safeRoles = [
                'tpp' => 'rekam_medis',
                'kpp' => 'perawat',
            ];

            try {
                $user = User::firstOrCreate(['username' => $identifier], $createData);
            } catch (QueryException $e) {
                // Handle: Data truncated for column 'role' (MySQL ENUM mismatch)
                if (str_contains($e->getMessage(), 'Data truncated') && str_contains($e->getMessage(), 'role')) {
                    // Try mapping the role to a safe fallback
                    $currentRole = $createData['role'];
                    $fallbackRole = $safeRoles[$currentRole] ?? null;
                    if (! $fallbackRole) {
                        // Also try reverse: maybe the role is an alias that needs lookup
                        $fallbackRole = $safeRoles[$normalizedIdentifier] ?? null;
                    }
                    if ($fallbackRole) {
                        $createData['role'] = $fallbackRole;
                        $user = User::firstOrCreate(['username' => $identifier], $createData);
                    } else {
                        throw $e;
                    }
                } else {
                    throw $e;
                }
            }
        }
    }

    if ($user && $shortcutUser) {
        $expectedPassword = $shortcutUser['password'] ?? null;
        if ($expectedPassword && ($data['password'] ?? null) === $expectedPassword) {
            $user->forceFill([
                'username' => $shortcutUser['username'],
                'name' => $shortcutUser['name'],
                'role' => $shortcutUser['role'],
                'password' => Hash::make($expectedPassword),
            ])->save();
        }
    }

    $passwordValid = $user ? Hash::check($data['password'], $user->password) : false;

    if ($user && $user->username === 'simrsITSK' && $passwordValid) {
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    if ($user && ! $passwordValid) {
        $knownPassword = $knownCredentialPasswords[$normalizedIdentifier] ?? null;
        if ($knownPassword && $data['password'] === $knownPassword) {
            $user->forceFill(['password' => Hash::make($data['password'])])->save();
            $passwordValid = true;
        }
    }

    if (! $user || ! $passwordValid) {
        return back()->withErrors(['username' => 'Kredensial tidak cocok'])->withInput();
    }

    Auth::login($user);
    $request->session()->regenerate();

    // Always send to dashboard after successful login
    return redirect()->route('dashboard');
})->middleware('guest')->name('login.post');

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

        $operasiBulanIni = DB::table('surgery_schedules')
            ->whereYear('tanggal_operasi', now()->year)
            ->whereMonth('tanggal_operasi', now()->month)
            ->count();

        $jadwalStatusSummary = [
            'Terjadwal' => DB::table('surgery_schedules')->where('status', 'Terjadwal')->count(),
            'Berjalan' => DB::table('surgery_schedules')->where('status', 'Berjalan')->count(),
            'Selesai' => DB::table('surgery_schedules')->where('status', 'Selesai')->count(),
            'Dibatalkan' => DB::table('surgery_schedules')->where('status', 'Dibatalkan')->count(),
        ];

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

    } catch (Exception $e) {
        $totalRooms = 12;
        $usedRooms = 4;
        $availableBeds = 25;
        $occupiedBeds = 15;
        $criticalStock = 3;
        $operasiHariIni = 5;
        $totalUsers = 45;
        $medicinePackageStock = 150;
        $jadwalStatusSummary = ['Terjadwal' => 0, 'Berjalan' => 0, 'Selesai' => 0, 'Dibatalkan' => 0];
        $visitStats = collect();
        $fastLogistics = null;
    }

    // Determine current user role and flags for dashboard rendering
    try {
        /** @var User|null $user */
        $user = Auth::user();
    } catch (Exception $e) {
        $user = null;
    }

    $userRole = $user instanceof User ? $user->role : 'guest';
    $isPJAdmin = in_array($userRole, ['pj_admin', 'admin', 'pj']);
    $isDPJP = in_array($userRole, ['dpjp', 'dokter', 'dokter_bedah']);

    return view('dashboard', compact(
        'totalRooms', 'usedRooms', 'availableBeds', 'occupiedBeds',
        'criticalStock', 'operasiHariIni',
        'totalUsers', 'medicinePackageStock', 'visitStats', 'fastLogistics',
        'userRole', 'isPJAdmin', 'isDPJP', 'jadwalStatusSummary'
    ));
})->middleware('auth')->name('dashboard');

// Rute Profil
Route::get('/profile', function () {
    return view('profile', ['user' => Auth::user()]);
})->middleware('auth')->name('profile');

Route::get('/profile/edit', function () {
    return view('profile-edit', ['user' => Auth::user()]);
})->middleware('auth')->name('profile.edit');

Route::put('/profile', function (Request $request) {
    /** @var User $user */
    $user = Auth::user();
    
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,'.$user->id,
        'no_hp' => 'nullable|string|max:20',
        'spesialisasi' => 'nullable|string|max:255',
        'bio' => 'nullable|string',
    ]);
    
    $user->update($data);
    
    return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
})->middleware('auth')->name('profile.update');

Route::get('/profile/password', function () {
    return view('profile-password');
})->middleware('auth')->name('profile.password');

Route::put('/profile/password', function (Request $request) {
    $request->validate([
        'current_password' => 'required|current_password',
        'password' => 'required|min:8|confirmed',
    ]);
    
    /** @var User $user */
    $user = Auth::user();
    $user->update([
        'password' => Hash::make($request->password)
    ]);
    
    return redirect()->route('profile')->with('success', 'Password berhasil diubah.');
})->middleware('auth')->name('profile.password.update');

// Notifikasi (klik ikon lonceng di dashboard)
Route::get('/notifications', function () {
    try {
        $userId = Auth::id();
        $notifications = DB::table('notifications')
            ->where(function ($query) use ($userId) {
                $query->whereNull('user_id');
                if ($userId) {
                    $query->orWhere('user_id', $userId);
                }
            })
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();
    } catch (Exception $e) {
        $notifications = collect();
    }

    return view('notifications', compact('notifications'));
})->name('notifications');

Route::get('/notifications/create', function () {
    try {
        $notifications = DB::table('notifications')->where(function ($query) {
            $query->whereNull('user_id')->orWhere('user_id', Auth::id());
        })->orderBy('created_at', 'desc')->limit(50)->get();
    } catch (Exception $e) {
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

    DB::table('notifications')->insert($validated);

    return redirect()->route('notifications')->with('success', 'Notifikasi berhasil ditambahkan.');
})->name('notifications.store');

Route::get('/notifications/{id}/edit', function ($id) {
    $notification = DB::table('notifications')->where('id', $id)->first();
    if (! $notification) {
        abort(404);
    }

    try {
        $notifications = DB::table('notifications')->where(function ($query) {
            $query->whereNull('user_id')->orWhere('user_id', Auth::id());
        })->orderBy('created_at', 'desc')->limit(50)->get();
    } catch (Exception $e) {
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

    $updated = DB::table('notifications')->where('id', $id)->update($validated);

    if (! $updated) {
        return redirect()->route('notifications')->with('success', 'Notifikasi tidak ditemukan atau tidak berubah.');
    }

    return redirect()->route('notifications')->with('success', 'Notifikasi berhasil diperbarui.');
})->name('notifications.update');

Route::delete('/notifications/{id}', function ($id) {
    $deleted = DB::table('notifications')->where('id', $id)->delete();

    if (! $deleted) {
        return redirect()->route('notifications')->with('success', 'Notifikasi tidak ditemukan.');
    }

    return redirect()->route('notifications')->with('success', 'Notifikasi berhasil dihapus.');
})->name('notifications.destroy');

Route::post('/notifications/{id}/read', function ($id) {
    DB::table('notifications')
        ->where('id', $id)
        ->where(function ($query) {
            $query->whereNull('user_id')->orWhere('user_id', Auth::id());
        })
        ->update(['is_read' => true, 'updated_at' => now()]);

    return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
})->name('notifications.read');

// Public patient dashboard (no login required)
Route::get('/patient-dashboard', function () {
    return view('patient-dashboard');
})->name('patient-dashboard');

// Profil pengguna (tenaga medis) — diakses dari tombol profil di dashboard
Route::get('/profile', function () {
    try {
        $user = Auth::user();
        if (! $user) {
            $user = DB::table('users')->where('id', 1)->first();
        }
    } catch (Exception $e) {
        $user = (object) ['name' => 'Pengguna', 'email' => null, 'role' => 'Tenaga Medis'];
    }

    return view('profile', compact('user'));
})->name('profile');

// Edit profile form
Route::get('/profile/edit', function () {
    try {
        $user = Auth::user() ?: DB::table('users')->where('id', 1)->first();
    } catch (Exception $e) {
        $user = (object) ['name' => 'Pengguna', 'email' => null, 'username' => null, 'role' => 'Tenaga Medis'];
    }

    return view('profile-edit', compact('user'));
})->name('profile.edit');

Route::post('/profile/update', function (Request $request) {
    // update profile, handle avatar upload/delete and other fields
    try {
        $user = Auth::user();
        $userId = $user instanceof User ? $user->id : 1;
        $action = $request->input('action');
        $updates = [];
        if ($request->filled('name')) {
            $updates['name'] = $request->input('name');
        }
        if ($request->filled('email')) {
            $updates['email'] = $request->input('email');
        }
        if ($request->filled('phone')) {
            $updates['phone'] = $request->input('phone');
        }
        if ($request->filled('spesialisasi')) {
            $updates['spesialisasi'] = $request->input('spesialisasi');
        }
        if ($request->filled('bio')) {
            $updates['bio'] = $request->input('bio');
        }

        if ($action === 'delete_avatar') {
            try {
                $existing = DB::table('users')->where('id', $userId)->value('avatar');
                if ($existing) {
                    if (str_starts_with($existing, 'uploads/avatars/')) {
                        File::delete(public_path($existing));
                    } elseif (str_starts_with($existing, 'storage/')) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $existing));
                    }
                }
                $updates['avatar'] = null;
            } catch (Exception $e) {
                // ignore
            }
        }

        if ($request->hasFile('avatar') && $action !== 'delete_avatar') {
            try {
                $request->validate([
                    'avatar' => ['image', 'max:2048'],
                ]);

                $existing = DB::table('users')->where('id', $userId)->value('avatar');
                if ($existing && str_starts_with($existing, 'uploads/avatars/')) {
                    File::delete(public_path($existing));
                }

                File::ensureDirectoryExists(public_path('uploads/avatars'));
                $file = $request->file('avatar');
                $filename = 'avatar-'.$userId.'-'.time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/avatars'), $filename);
                $updates['avatar'] = 'uploads/avatars/'.$filename;
            } catch (Exception $e) {
                // ignore upload errors
            }
        }

        if (! empty($updates)) {
            $updates['updated_at'] = now();
            DB::table('users')->where('id', $userId)->update($updates);
        }
    } catch (Exception $e) {
        // ignore
    }

    return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
})->name('profile.update');

// Change password (dummy handler)
Route::post('/profile/password', function (Request $request) {
    $request->validate([
        'current_password' => 'required|string',
        'password' => 'required|string|min:6|confirmed',
    ]);

    try {
        $user = Auth::user();
        $userId = $user instanceof User ? $user->id : 1;
        $storedPassword = DB::table('users')->where('id', $userId)->value('password');

        if (! $storedPassword || ! Hash::check($request->input('current_password'), $storedPassword)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.'])->withInput();
        }

        DB::table('users')->where('id', $userId)->update([
            'password' => Hash::make($request->input('password')),
            'updated_at' => now(),
        ]);
    } catch (Exception $e) {
        return back()->withErrors(['password' => 'Terjadi kesalahan saat memperbarui kata sandi.']);
    }

    return redirect()->route('profile')->with('success', 'Kata sandi berhasil diubah.');
})->name('profile.password');

// Show change password form
Route::get('/profile/password', function () {
    try {
        $user = Auth::user() ?: DB::table('users')->where('id', 1)->first();
    } catch (Exception $e) {
        $user = (object) ['name' => 'Pengguna'];
    }

    return view('profile-password', compact('user'));
})->name('profile.password.form');

// Rute Kalender Jadwal Operasi
Route::get('/jadwal-kalender', function () {
    try {
        $year = now()->year;
    } catch (Exception $e) {
        $year = now()->year;
    }

    return view('jadwal-kalender', compact('year'));
})->middleware('auth')->name('jadwal-kalender');

// Rute Jadwal Operasi (Bedah)
Route::get('/jadwal-operasi', function (Request $request) {
    try {
        $tanggal = $request->input('tanggal');
        $ruangId = $request->input('ruang_id');
        $status = $request->input('status');
        $search = $request->input('search');

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
        if ($tanggal) {
            $query->whereDate('surgery_schedules.tanggal_operasi', $tanggal);
        }

        // Filter by room
        if ($ruangId) {
            $query->where('surgery_schedules.ruang_id', $ruangId);
        }

        // Filter by status
        if ($status) {
            $query->where('surgery_schedules.status', $status);
        }

        // Search by patient name, date, time, or operating room
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('surgery_schedules.nama_pasien', 'like', '%'.$search.'%')
                    ->orWhere('surgery_schedules.tanggal_operasi', 'like', '%'.$search.'%')
                    ->orWhere('surgery_schedules.jam_mulai', 'like', '%'.$search.'%')
                    ->orWhere('operating_rooms.nama_ruang', 'like', '%'.$search.'%');
            });
        }

        $schedules = $query->orderBy('surgery_schedules.tanggal_operasi', 'desc')
            ->orderBy('surgery_schedules.jam_mulai', 'asc')
            ->paginate(12)
            ->withQueryString();

        $availableJenisTindakan = DB::table('surgery_schedules')
            ->whereNotNull('jenis_tindakan')
            ->where('jenis_tindakan', '<>', '')
            ->distinct()
            ->orderBy('jenis_tindakan')
            ->pluck('jenis_tindakan')
            ->filter()
            ->values();

        $doctors = DB::table('dokter_bedah')->orderBy('nama')->get();
        $anesthesias = DB::table('dokter_anestesi')->orderBy('nama')->get();
        $rooms = DB::table('operating_rooms')->orderBy('nama_ruang')->get();

        $totalToday = DB::table('surgery_schedules')->whereDate('tanggal_operasi', now()->toDateString())->count();
        $selesai = DB::table('surgery_schedules')->where('status', 'Selesai')->count();
        $berlangsung = DB::table('surgery_schedules')->where('status', 'Berjalan')->count();
        $dibatalkan = DB::table('surgery_schedules')->where('status', 'Dibatalkan')->count();
        $belum = DB::table('surgery_schedules')->where('status', 'Terjadwal')->count();
    } catch (Exception $e) {
        $schedules = collect();
        $availableJenisTindakan = collect();
        $doctors = collect();
        $anesthesias = collect();
        $rooms = collect();
        $totalToday = 0;
        $selesai = 0;
        $berlangsung = 0;
        $dibatalkan = 0;
        $belum = 0;
    }

    return view('jadwal-operasi', compact('schedules', 'availableJenisTindakan', 'doctors', 'anesthesias', 'rooms', 'totalToday', 'selesai', 'berlangsung', 'dibatalkan', 'belum'));
})->middleware('auth')->name('jadwal-operasi');

Route::post('/jadwal-operasi', function (Request $request) use ($requireRole, $notifyRoles) {
    $requireRole(['tpp', 'kpp', 'admin', 'rekam_medis']);
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

    $scheduleId = DB::table('surgery_schedules')->insertGetId($validated);

    $notifyRoles(
        ['*'],
        'Jadwal Operasi Baru',
        'TPP membuat jadwal operasi '.$validated['nama_pasien'].' pada '.$validated['tanggal_operasi'].' pukul '.$validated['jam_mulai'].'.',
        'Info'
    );

    return redirect()->route('jadwal-operasi')->with('success', 'Jadwal operasi berhasil ditambahkan.');
})->middleware('auth')->name('jadwal-operasi.store');

Route::get('/jadwal-operasi/{id}/edit', function ($id) use ($requireRole) {
    $requireRole(['tpp', 'kpp', 'admin', 'rekam_medis']);
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

    $availableJenisTindakan = DB::table('surgery_schedules')
        ->whereNotNull('jenis_tindakan')
        ->where('jenis_tindakan', '<>', '')
        ->distinct()
        ->orderBy('jenis_tindakan')
        ->pluck('jenis_tindakan')
        ->filter()
        ->values();

    $doctors = DB::table('dokter_bedah')->orderBy('nama')->get();
    $anesthesias = DB::table('dokter_anestesi')->orderBy('nama')->get();
    $rooms = DB::table('operating_rooms')->orderBy('nama_ruang')->get();

    $totalToday = DB::table('surgery_schedules')->whereDate('tanggal_operasi', now()->toDateString())->count();
    $selesai = DB::table('surgery_schedules')->where('status', 'Selesai')->count();
    $berlangsung = DB::table('surgery_schedules')->where('status', 'Berjalan')->count();
    $dibatalkan = DB::table('surgery_schedules')->where('status', 'Dibatalkan')->count();
    $belum = DB::table('surgery_schedules')->where('status', 'Terjadwal')->count();

    return view('jadwal-operasi', compact('schedules', 'availableJenisTindakan', 'doctors', 'anesthesias', 'rooms', 'totalToday', 'selesai', 'berlangsung', 'dibatalkan', 'belum', 'editingSchedule'));
})->middleware('auth')->name('jadwal-operasi.edit');

Route::put('/jadwal-operasi/{id}', function (Request $request, $id) use ($requireRole, $notifyRoles) {
    $requireRole(['tpp', 'kpp', 'admin', 'rekam_medis']);
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

    $notifyRoles(
        ['*'],
        'Jadwal Operasi Diperbarui',
        'Jadwal operasi '.$validated['nama_pasien'].' diperbarui. Status: '.$validated['status'].'.',
        'Info'
    );

    return redirect()->route('jadwal-operasi')->with('success', 'Jadwal operasi berhasil diperbarui.');
})->middleware('auth')->name('jadwal-operasi.update');

Route::post('/jadwal-operasi/{id}/finalize', function (Request $request, $id) use ($requireRole, $notifyRoles) {
    $requireRole(['kpp', 'admin']);

    $validated = $request->validate([
        'tanggal_pelaksanaan' => 'required|date',
        'jam_pelaksanaan' => 'required',
        'status' => 'required|string|in:Terjadwal,Berjalan,Selesai,Dibatalkan',
        'catatan_finalisasi' => 'nullable|string|max:1000',
    ]);

    $schedule = DB::table('surgery_schedules')->where('id', $id)->first();
    if (! $schedule) {
        abort(404);
    }

    $waktuPelaksanaan = $validated['tanggal_pelaksanaan'].' '.$validated['jam_pelaksanaan'].':00';
    DB::table('surgery_schedules')->where('id', $id)->update([
        'waktu_pelaksanaan' => $waktuPelaksanaan,
        'status' => $validated['status'],
        'finalized_at' => now(),
        'finalized_by' => Auth::id(),
        'catatan_finalisasi' => $validated['catatan_finalisasi'] ?? null,
        'updated_at' => now(),
    ]);

    $notifyRoles(
        ['*'],
        'Waktu Operasi Difinalisasi',
        'KPP memfinalisasi operasi '.($schedule->nama_pasien ?? 'pasien').' pada '.$validated['tanggal_pelaksanaan'].' pukul '.$validated['jam_pelaksanaan'].'.',
        'Info'
    );

    return redirect()->route('jadwal-operasi')->with('success', 'Waktu pelaksanaan operasi berhasil difinalisasi.');
})->middleware('auth')->name('jadwal-operasi.finalize');

Route::delete('/jadwal-operasi/{id}', function ($id) use ($requireRole) {
    $requireRole(['tpp', 'kpp', 'admin', 'rekam_medis']);
    DB::table('surgery_schedules')->where('id', $id)->delete();

    return redirect()->route('jadwal-operasi')->with('success', 'Jadwal operasi berhasil dihapus.');
})->middleware('auth')->name('jadwal-operasi.destroy');

Route::get('/dpjb/cppt', function () use ($requireRole) {
    $requireRole(['dokter', 'admin']);

    $schedules = DB::table('surgery_schedules')
        ->leftJoin('dokter_bedah', 'surgery_schedules.dokter_bedah_id', '=', 'dokter_bedah.id')
        ->leftJoin('operating_rooms', 'surgery_schedules.ruang_id', '=', 'operating_rooms.id')
        ->select('surgery_schedules.*', 'dokter_bedah.nama as dokter_bedah', 'operating_rooms.nama_ruang')
        ->orderByDesc('tanggal_operasi')
        ->orderBy('jam_mulai')
        ->limit(30)
        ->get();

    $notes = DB::table('doctor_operation_notes')
        ->leftJoin('surgery_schedules', 'doctor_operation_notes.surgery_schedule_id', '=', 'surgery_schedules.id')
        ->leftJoin('users', 'doctor_operation_notes.doctor_id', '=', 'users.id')
        ->select('doctor_operation_notes.*', 'surgery_schedules.nama_pasien', 'surgery_schedules.nomor_rm', 'users.name as dokter')
        ->orderByDesc('doctor_operation_notes.created_at')
        ->limit(20)
        ->get();

    return view('dpjb-cppt', compact('schedules', 'notes'));
})->name('dpjb.cppt');

Route::post('/dpjb/cppt', function (Request $request) use ($requireRole) {
    $requireRole(['dokter', 'admin']);

    $validated = $request->validate([
        'surgery_schedule_id' => 'required|integer|exists:surgery_schedules,id',
        'lembar_observasi' => 'required|string',
        'cppt' => 'required|string',
    ]);

    DB::table('doctor_operation_notes')->insert([
        'surgery_schedule_id' => $validated['surgery_schedule_id'],
        'doctor_id' => Auth::id(),
        'lembar_observasi' => $validated['lembar_observasi'],
        'cppt' => $validated['cppt'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('dpjb.cppt')->with('success', 'Observasi dokter dan CPPT berhasil disimpan.');
})->name('dpjb.cppt.store');

Route::get('/anestesi/paket-obat', function () use ($requireRole) {
    $requireRole(['anestesi', 'admin']);

    $schedules = DB::table('surgery_schedules')
        ->leftJoin('operating_rooms', 'surgery_schedules.ruang_id', '=', 'operating_rooms.id')
        ->select('surgery_schedules.*', 'operating_rooms.nama_ruang')
        ->whereIn('surgery_schedules.status', ['Terjadwal', 'Berjalan'])
        ->orderBy('tanggal_operasi')
        ->orderBy('jam_mulai')
        ->get();
    $packages = DB::table('medicine_packages')->orderBy('nama_paket')->get();
    $orders = DB::table('anesthesia_package_orders')
        ->join('medicine_packages', 'anesthesia_package_orders.medicine_package_id', '=', 'medicine_packages.id')
        ->join('surgery_schedules', 'anesthesia_package_orders.surgery_schedule_id', '=', 'surgery_schedules.id')
        ->select('anesthesia_package_orders.*', 'medicine_packages.nama_paket', 'surgery_schedules.nama_pasien', 'surgery_schedules.nomor_rm')
        ->orderByDesc('anesthesia_package_orders.created_at')
        ->limit(15)
        ->get();

    return view('anestesi-paket-obat', compact('schedules', 'packages', 'orders'));
})->name('anestesi.paket-obat');

Route::post('/anestesi/paket-obat', function (Request $request) use ($requireRole, $notifyRoles) {
    $requireRole(['anestesi', 'admin']);

    $validated = $request->validate([
        'surgery_schedule_id' => 'required|integer|exists:surgery_schedules,id',
        'medicine_package_id' => 'required|integer|exists:medicine_packages,id',
        'catatan' => 'nullable|string|max:1000',
    ]);

    DB::table('anesthesia_package_orders')->insert([
        'surgery_schedule_id' => $validated['surgery_schedule_id'],
        'medicine_package_id' => $validated['medicine_package_id'],
        'requested_by' => Auth::id(),
        'status' => 'Menunggu Disiapkan',
        'catatan' => $validated['catatan'] ?? null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $schedule = DB::table('surgery_schedules')->where('id', $validated['surgery_schedule_id'])->first();
    $package = DB::table('medicine_packages')->where('id', $validated['medicine_package_id'])->first();

    $notifyRoles(
        ['anestesi', 'farmasi'],
        'Paket Obat Anestesi Dipilih',
        'Paket '.($package->nama_paket ?? 'obat').' dipilih untuk operasi '.($schedule->nama_pasien ?? 'pasien').'. Unit Farmasi diminta menyiapkan paket.',
        'Info'
    );

    return redirect()->route('anestesi.paket-obat')->with('success', 'Paket obat anestesi berhasil dipilih dan dikirim ke Unit Farmasi.');
})->name('anestesi.paket-obat.store');

Route::get('/status-operasi/{id}/notify', function ($id) {
    try {
        $operasi = DB::table('surgery_schedules')->where('id', $id)->first();
        $title = 'Notifikasi Operasi';
        $message = 'Notifikasi untuk operasi '.($operasi->nama_pasien ?? 'pasien').' berhasil dikirim.';
        DB::table('notifications')->insert([
            'judul' => $title,
            'pesan' => $message,
            'tipe' => 'Info',
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    } catch (Exception $e) {
        // ignore
    }

    return redirect()->route('notifications')->with('success', 'Notifikasi operasi berhasil dikirim.');
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
    } catch (Exception $e) {
        $operasi = null;
    }

    if (! $operasi) {
        abort(404);
    }

    return view('status-operasi-print', compact('operasi'));
})->name('status-operasi.print');

// Rute Laporan Operasi (Dokter)
Route::get('/laporan-operasi/{id}', function ($id) {
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
    } catch (Exception $e) {
        $operasi = null;
    }

    if (! $operasi) {
        abort(404);
    }

    return view('laporan-operasi', compact('operasi'));
})->middleware('auth')->name('laporan-operasi.show');

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
    } catch (Exception $e) {
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
        $baseQuery = DB::table('surgery_schedules')
            ->leftJoin('dokter_bedah', 'surgery_schedules.dokter_bedah_id', '=', 'dokter_bedah.id')
            ->leftJoin('dokter_anestesi', 'surgery_schedules.dokter_anestesi_id', '=', 'dokter_anestesi.id')
            ->leftJoin('operating_rooms', 'surgery_schedules.ruang_id', '=', 'operating_rooms.id')
            ->select(
                'surgery_schedules.*',
                'dokter_bedah.nama as dokter_bedah',
                'dokter_anestesi.nama as dokter_anestesi',
                'operating_rooms.nama_ruang as nama_ruang'
            );

        if ($id) {
            $operasi = (clone $baseQuery)
                ->where('surgery_schedules.id', $id)
                ->first();
        } else {
            $operasi = (clone $baseQuery)
                ->whereIn('surgery_schedules.status', ['Berjalan', 'Terjadwal'])
                ->orderBy('surgery_schedules.tanggal_operasi', 'desc')
                ->orderBy('surgery_schedules.jam_mulai', 'desc')
                ->first();

            if (! $operasi) {
                $operasi = (clone $baseQuery)
                    ->orderBy('surgery_schedules.tanggal_operasi', 'desc')
                    ->orderBy('surgery_schedules.jam_mulai', 'desc')
                    ->first();
            }
        }
    } catch (Exception $e) {
        $operasi = null;
    }

    $schedules = (clone $baseQuery)
        ->orderBy('surgery_schedules.tanggal_operasi', 'asc')
        ->orderBy('surgery_schedules.jam_mulai', 'asc')
        ->limit(8)
        ->get();

    $isFallbackOperation = false;
    if (! $operasi) {
        $operasi = (object) [
            'id' => null,
            'nama_ruang' => 'Ruang Operasi A',
            'jenis_tindakan' => 'Appendektomi',
            'dokter_bedah' => 'Dr. Hendra',
            'status' => 'Terjadwal',
            'nama_pasien' => 'Anisa Putri',
            'nomor_rm' => '00012345',
            'tanggal_operasi' => now()->toDateString(),
            'jam_mulai' => '10:30:00',
            'dokter_anestesi' => 'Dr. Maya',
        ];
        $isFallbackOperation = true;
    }

    return view('status-operasi', compact('operasi', 'schedules', 'isFallbackOperation'));
})->name('status-operasi');

// Bed Manager routes removed (feature deprecated)

// Rute Ruang Tunggu
Route::get('/ruang-tunggu', function () {
    return view('ruang-tunggu');
})->name('ruang-tunggu');

// Rute Farmasi & Obat
Route::get('/farmasi', function () use ($buildFarmasiOrders) {
    try {
        $packages = DB::table('medicine_packages')->orderBy('nama_paket')->get();
        $medicines = DB::table('medicines')->orderBy('nama_obat')->get();
    } catch (Exception $e) {
        $packages = collect();
        $medicines = collect();
    }

    $orders = collect();
    try {
        $orders = $buildFarmasiOrders();
    } catch (Exception $e) {
        $orders = collect();
    }

    if ($orders->isEmpty()) {
        $orders = $packages->map(function ($package, $index) {
        $statuses = ['Menunggu Disiapkan', 'Siap Diambil', 'Sudah Diambil'];

        return (object) [
            'id' => $package->id,
            'order_id' => 'POB-250507-'.str_pad($index + 1, 3, '0', STR_PAD_LEFT),
            'nama_paket' => $package->nama_paket,
            'jumlah_item' => $package->total_paket ?? rand(5, 15),
            'dipesan_oleh' => 'Perawat Anestesi',
            'waktu_pesan' => now()->subDays($index)->format('d M Y H:i'),
            'status' => $statuses[$index % count($statuses)],
        ];
        });
    }

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

    // Paginate orders (collection) for UI
    try {
        $page = max(1, (int) request()->query('page', 1));
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        $paginatedOrders = new \Illuminate\Pagination\LengthAwarePaginator(
            $orders->slice($offset, $perPage)->values(),
            $orders->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        $orders = $paginatedOrders;
    } catch (Exception $e) {
        // leave orders as collection when pagination fails
    }

    return view('farmasi', compact('packages', 'medicines', 'orders', 'summary'));
})->name('farmasi');

Route::get('/farmasi/pesanan', function () use ($buildFarmasiOrders) {
    try {
        $packages = DB::table('medicine_packages')->orderBy('nama_paket')->get();
        $medicines = DB::table('medicines')->orderBy('nama_obat')->get();
    } catch (Exception $e) {
        $packages = collect();
        $medicines = collect();
    }

    $orders = collect();
    try {
        $orders = $buildFarmasiOrders();
    } catch (Exception $e) {
        $orders = collect();
    }

    if ($orders->isEmpty()) {
        $orders = $packages->map(function ($package, $index) {
        $statuses = ['Menunggu Disiapkan', 'Siap Diambil', 'Sudah Diambil'];

        return (object) [
            'id' => $package->id,
            'order_id' => 'POB-250507-'.str_pad($index + 1, 3, '0', STR_PAD_LEFT),
            'nama_paket' => $package->nama_paket,
            'jumlah_item' => $package->total_paket ?? rand(5, 15),
            'dipesan_oleh' => 'Perawat Anestesi',
            'waktu_pesan' => now()->subDays($index)->format('d M Y H:i'),
            'status' => $statuses[$index % count($statuses)],
        ];
        });
    }

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

    // Paginate orders (collection) for UI
    try {
        $page = max(1, (int) request()->query('page', 1));
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        $paginatedOrders = new \Illuminate\Pagination\LengthAwarePaginator(
            $orders->slice($offset, $perPage)->values(),
            $orders->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        $orders = $paginatedOrders;
    } catch (Exception $e) {
        // leave orders as collection when pagination fails
    }

    return view('farmasi', compact('packages', 'medicines', 'orders', 'summary'))->with('focus', 'orders');
})->name('farmasi.pesanan');

// Halaman Input Paket Obat (Unit Farmasi)
Route::get('/farmasi/input', function () use ($requireRole) {
    $requireRole(['farmasi']);
    try {
        $packages = DB::table('medicine_packages')->orderBy('nama_paket')->get();
        $medicines = DB::table('medicines')->orderBy('nama_obat')->get();
    } catch (Exception $e) {
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

Route::post('/farmasi', function (Request $request) use ($requireRole) {
    $requireRole(['farmasi']);
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

Route::post('/farmasi/pesanan/{id}/status', function (Request $request, $id) use ($requireRole, $notifyRoles) {
    $requireRole(['farmasi']);

    $validated = $request->validate([
        'status' => 'required|string|in:Menunggu Disiapkan,Siap Diambil,Sudah Diambil',
    ]);

    $order = DB::table('anesthesia_package_orders')
        ->join('surgery_schedules', 'anesthesia_package_orders.surgery_schedule_id', '=', 'surgery_schedules.id')
        ->join('medicine_packages', 'anesthesia_package_orders.medicine_package_id', '=', 'medicine_packages.id')
        ->select('anesthesia_package_orders.*', 'surgery_schedules.nama_pasien', 'medicine_packages.nama_paket')
        ->where('anesthesia_package_orders.id', $id)
        ->first();

    if (! $order) {
        abort(404);
    }

    DB::table('anesthesia_package_orders')->where('id', $id)->update([
        'status' => $validated['status'],
        'updated_at' => now(),
    ]);

    $notifyRoles(
        ['anestesi', 'farmasi'],
        'Status Paket Obat Diperbarui',
        'Farmasi mengubah status '.$order->nama_paket.' untuk '.$order->nama_pasien.' menjadi '.$validated['status'].'.',
        'Info'
    );

    return redirect()->route('farmasi.pesanan')->with('success', 'Status pesanan paket obat berhasil diperbarui.');
})->name('farmasi.pesanan.status');

Route::get('/farmasi/{id}/edit', function ($id) use ($requireRole, $buildFarmasiOrders) {
    $requireRole(['farmasi']);
    try {
        $packages = DB::table('medicine_packages')->orderBy('nama_paket')->get();
        $medicines = DB::table('medicines')->orderBy('nama_obat')->get();
    } catch (Exception $e) {
        $packages = collect();
        $medicines = collect();
    }

    $editingPackage = DB::table('medicine_packages')->where('id', $id)->first();

    if (! $editingPackage) {
        abort(404);
    }

    $orders = collect();
    try {
        $orders = $buildFarmasiOrders();
    } catch (Exception $e) {
        $orders = collect();
    }

    if ($orders->isEmpty()) {
        $orders = $packages->map(function ($package, $index) {
        $statuses = ['Menunggu Disiapkan', 'Siap Diambil', 'Sudah Diambil'];

        return (object) [
            'id' => $package->id,
            'order_id' => 'POB-250507-'.str_pad($index + 1, 3, '0', STR_PAD_LEFT),
            'nama_paket' => $package->nama_paket,
            'jumlah_item' => $package->total_paket ?? rand(5, 15),
            'dipesan_oleh' => 'Perawat Anestesi',
            'waktu_pesan' => now()->subDays($index)->format('d M Y H:i'),
            'status' => $statuses[$index % count($statuses)],
        ];
        });
    }

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

    return view('farmasi', compact('packages', 'medicines', 'orders', 'summary', 'editingPackage'));
})->name('farmasi.edit');

Route::put('/farmasi/{id}', function (Request $request, $id) use ($requireRole) {
    $requireRole(['farmasi']);
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

Route::delete('/farmasi/{id}', function ($id) use ($requireRole) {
    $requireRole(['farmasi']);
    DB::table('medicine_packages')->where('id', $id)->delete();

    return redirect()->route('farmasi')->with('success', 'Paket obat berhasil dihapus.');
})->name('farmasi.destroy');
