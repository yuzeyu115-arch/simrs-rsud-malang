<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmasi & Obat - RSUD Kota Malang</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-green': '#10b981',
                        'primary-green-hover': '#059669',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f7f9f7; }
        .sidebar-active {
            background-color: #e8f5e9;
            color: #1b5e20;
            font-weight: 700;
        }
        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
            background-color: #fff;
            transition: all 0.2s;
        }
        .action-btn-edit { color: #10b981; border-color: #a7f3d0; }
        .action-btn-edit:hover { background-color: #ecfdf5; border-color: #6ee7b7; }
        .action-btn-delete { color: #ef4444; border-color: #fee2e2; }
        .action-btn-delete:hover { background-color: #fef2f2; border-color: #fecaca; }
    </style>
</head>
<body class="flex overflow-hidden h-screen text-gray-800">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col flex-shrink-0 shadow-sm z-20">
        <div class="p-6 flex items-center space-x-3">
            <div class="w-8 h-8 bg-primary-green rounded-lg flex items-center justify-center text-white shadow-md">
                <i class="fa-solid fa-hospital"></i>
            </div>
            <span class="text-xl font-bold text-gray-800 tracking-tight">RSUD Malang</span>
        </div>

        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-4 mb-2">UTAMA</p>
            <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-house w-5"></i> <span>Dashboard</span>
            </a>

            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-6 mb-2">BEDAH</p>
            <a href="{{ url('/jadwal-operasi') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-calendar-check w-5"></i> <span>Jadwal Operasi</span>
            </a>
            <a href="{{ route('rapat-koordinasi') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-users w-5"></i> <span>Rapat Koordinasi</span>
            </a>

            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-6 mb-2">KEPERAWATAN</p>
            <a href="{{ url('/bed-manager-list') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-bed-pulse w-5"></i> <span>Manajemen Bed</span>
            </a>
            <a href="{{ url('/janji-temu') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-calendar-plus w-5"></i> <span>Janji Temu</span>
            </a>

            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-6 mb-2">LOGISTIK</p>
            <a href="{{ url('/farmasi') }}" class="flex items-center space-x-3 p-3 rounded-xl sidebar-active transition-all text-sm font-semibold">
                 <i class="fa-solid fa-pills w-5 text-primary-green"></i> <span>Farmasi & Obat</span>
            </a>
            <a href="{{ url('/logistik/ringkasan-cepat') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-boxes-stacked w-5"></i> <span>Ringkasan Logistik</span>
            </a>

            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-6 mb-2">GIZI</p>
            <a href="{{ url('/gizi/pemesanan-menu') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-utensils w-5"></i> <span>Pemesanan Menu</span>
            </a>
            <a href="{{ url('/gizi/jadwal-makan') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-clock w-5"></i> <span>Jadwal Makan</span>
            </a>

            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-6 mb-2">STATISTIK</p>
            <a href="{{ url('/statistik/tindakan-kunjungan') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-chart-line w-5"></i> <span>Tindakan & Kunjungan</span>
            </a>

            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-6 mb-2">ADMINISTRASI</p>
            <a href="{{ url('/admin/pengguna') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-users-gear w-5"></i> <span>Manajemen Pengguna</span>
            </a>

            <div class="mt-auto pt-10 px-3 pb-8">
                <a href="{{ url('/logout') }}" class="flex items-center space-x-3 text-red-500 font-bold text-sm hover:underline">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <!-- Topbar -->
        <div class="sticky top-0 bg-white/80 backdrop-blur-md border-b border-gray-100 px-8 py-4 z-10 flex justify-between items-center">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" id="searchInput" onkeyup="filterData()" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl bg-gray-50 text-sm outline-none focus:ring-2 focus:ring-primary-green/20 focus:border-primary-green transition-all" placeholder="Cari obat atau paket obat...">
            </div>
            
            <div class="flex items-center space-x-6">
                <a href="{{ url('/notifications') }}" class="relative text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                </a>
                <div class="h-8 w-px bg-gray-200"></div>
                <a href="{{ url('/profile') }}" class="flex items-center space-x-3 hover:bg-gray-50 p-2 rounded-xl transition-colors">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-800 leading-none">{{ Auth::user()->name ?? 'Dr. Devia Amanda' }}</p>
                        <p class="text-xs text-gray-500 mt-1 uppercase">{{ Auth::user()->role == 'farmasi' ? 'Staff Farmasi' : 'Kepala Bedah Umum' }}</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Devia Amanda') }}&background=10b981&color=fff" class="w-10 h-10 rounded-full shadow-sm" alt="Profile">
                    <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
                </a>
            </div>
        </div>

        <div class="p-8 space-y-6">
            
            <!-- Breadcrumb & Title -->
            <div class="flex justify-between items-end">
                <div>
                    <nav class="flex text-xs font-bold text-gray-400 mb-2 space-x-2">
                        <span class="text-emerald-600">Logistik</span>
                        <span>/</span>
                        <span>Farmasi & Obat</span>
                    </nav>
                    <h2 class="text-3xl font-black text-[#1b5e20] tracking-tight">Farmasi & Inventaris Obat</h2>
                    <p class="text-sm font-semibold text-gray-500 mt-1">Kelola ketersediaan obat satuan dan paket obat bedah rumah sakit.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="rounded-2xl bg-emerald-50 border border-emerald-100 p-4 text-emerald-800 font-bold text-sm flex items-center space-x-3 shadow-sm animate-pulse">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 text-xl shadow-inner">
                        <i class="fa-solid fa-capsules"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Jenis Obat</p>
                        <h3 class="text-2xl font-black text-gray-800">{{ $medicines->count() }} <span class="text-xs font-bold text-gray-400">item</span></h3>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-red-600 text-xl shadow-inner">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Stok Kritis / Habis</p>
                        <h3 class="text-2xl font-black text-red-600">
                            {{ $medicines->filter(fn($m) => $m->status != 'Tersedia' || $m->stok_obat < 50)->count() }}
                            <span class="text-xs font-bold text-gray-400">item</span>
                        </h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-xl shadow-inner">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Paket Obat</p>
                        <h3 class="text-2xl font-black text-gray-800">{{ $packages->count() }} <span class="text-xs font-bold text-gray-400">paket</span></h3>
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button onclick="switchTab('obat')" id="tab-obat" class="border-primary-green text-primary-green flex items-center space-x-2 py-4 px-1 border-b-2 font-bold text-sm cursor-pointer outline-none">
                        <i class="fa-solid fa-pills"></i>
                        <span>Stok & Inventaris Obat</span>
                    </button>
                    <button onclick="switchTab('paket')" id="tab-paket" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center space-x-2 py-4 px-1 border-b-2 font-semibold text-sm cursor-pointer outline-none">
                        <i class="fa-solid fa-boxes-packing"></i>
                        <span>Paket Obat Operasi</span>
                    </button>
                </nav>
            </div>

            <!-- Section: Stok Obat -->
            <div id="section-obat" class="space-y-6 hidden">
                <!-- Form Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800">{{ isset($editingMedicine) ? 'Edit Data Obat' : 'Tambah Obat Baru' }}</h3>
                        <p class="text-sm text-gray-400 font-medium">Lengkapi detail informasi obat di bawah ini.</p>
                    </div>

                    @php
                        $obatAction = isset($editingMedicine)
                            ? route('farmasi.obat.update', $editingMedicine->id_obat)
                            : route('farmasi.obat.store');
                    @endphp

                    <form action="{{ $obatAction }}" method="POST" class="space-y-6">
                        @csrf
                        @if(isset($editingMedicine))
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Nama Obat</label>
                                <input name="nama_obat" value="{{ old('nama_obat', $editingMedicine->nama_obat ?? '') }}" type="text" required class="w-full bg-gray-50 border-gray-200 border rounded-2xl px-5 py-3.5 text-sm font-semibold focus:ring-2 focus:ring-primary-green/20 focus:border-primary-green outline-none transition-all" placeholder="Contoh: Paracetamol 500mg">
                                @error('nama_obat')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Jenis Obat</label>
                                <input name="jenis_obat" value="{{ old('jenis_obat', $editingMedicine->jenis_obat ?? '') }}" type="text" required class="w-full bg-gray-50 border-gray-200 border rounded-2xl px-5 py-3.5 text-sm font-semibold focus:ring-2 focus:ring-primary-green/20 focus:border-primary-green outline-none transition-all" placeholder="Contoh: Analgesik, Anestesi">
                                @error('jenis_obat')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Kandungan Obat</label>
                                <input name="kandungan_obat" value="{{ old('kandungan_obat', $editingMedicine->kandungan_obat ?? '') }}" type="text" class="w-full bg-gray-50 border-gray-200 border rounded-2xl px-5 py-3.5 text-sm font-semibold focus:ring-2 focus:ring-primary-green/20 focus:border-primary-green outline-none transition-all" placeholder="Contoh: Paracetamol">
                                @error('kandungan_obat')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Stok Obat</label>
                                <input name="stok_obat" value="{{ old('stok_obat', $editingMedicine->stok_obat ?? '') }}" type="number" min="0" required class="w-full bg-gray-50 border-gray-200 border rounded-2xl px-5 py-3.5 text-sm font-semibold focus:ring-2 focus:ring-primary-green/20 focus:border-primary-green outline-none transition-all" placeholder="Jumlah stok">
                                @error('stok_obat')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Harga Obat (IDR)</label>
                                <input name="harga_obat" value="{{ old('harga_obat', $editingMedicine->harga_obat ?? '') }}" type="number" step="0.01" min="0" required class="w-full bg-gray-50 border-gray-200 border rounded-2xl px-5 py-3.5 text-sm font-semibold focus:ring-2 focus:ring-primary-green/20 focus:border-primary-green outline-none transition-all" placeholder="Contoh: 5000">
                                @error('harga_obat')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Tanggal Kadaluwarsa</label>
                                <input name="tanggal_kadaluwarsa" value="{{ old('tanggal_kadaluwarsa', $editingMedicine->tanggal_kadaluwarsa ?? '') }}" type="date" required class="w-full bg-gray-50 border-gray-200 border rounded-2xl px-5 py-3.5 text-sm font-semibold focus:ring-2 focus:ring-primary-green/20 focus:border-primary-green outline-none transition-all">
                                @error('tanggal_kadaluwarsa')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Status</label>
                                <select name="status" required class="w-full bg-gray-50 border-gray-200 border rounded-2xl px-5 py-3.5 text-sm font-semibold focus:ring-2 focus:ring-primary-green/20 focus:border-primary-green outline-none transition-all">
                                    <option value="Tersedia" {{ old('status', $editingMedicine->status ?? '') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="Menipis" {{ old('status', $editingMedicine->status ?? '') == 'Menipis' ? 'selected' : '' }}>Menipis</option>
                                    <option value="Habis" {{ old('status', $editingMedicine->status ?? '') == 'Habis' ? 'selected' : '' }}>Habis</option>
                                </select>
                                @error('status')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="flex items-end justify-end space-x-3">
                                @if(isset($editingMedicine))
                                    <a href="{{ route('farmasi') }}" class="px-6 py-3.5 rounded-2xl border border-gray-200 text-gray-500 font-bold text-sm hover:bg-gray-50 transition-all text-center">Batal</a>
                                @endif
                                <button type="submit" class="bg-primary-green text-white px-8 py-3.5 rounded-2xl text-sm font-bold shadow-lg shadow-emerald-500/20 hover:bg-primary-green-hover transition-all">
                                    {{ isset($editingMedicine) ? 'Simpan Perubahan' : 'Tambah Obat' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Table Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-50">
                        <h3 class="text-lg font-bold text-gray-800">Daftar Inventaris Obat</h3>
                        <p class="text-sm text-gray-400 font-medium">Stok obat satuan yang tersedia di instalasi farmasi.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left" id="obatTable">
                            <thead>
                                <tr class="bg-gray-50/50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">
                                    <th class="px-8 py-5">No</th>
                                    <th class="px-8 py-5">Nama Obat</th>
                                    <th class="px-8 py-5">Jenis & Kandungan</th>
                                    <th class="px-8 py-5 text-center">Stok</th>
                                    <th class="px-8 py-5 text-right">Harga</th>
                                    <th class="px-8 py-5 text-center">Tanggal Kadaluwarsa</th>
                                    <th class="px-8 py-5 text-center">Status</th>
                                    <th class="px-8 py-5 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-xs font-bold text-gray-700">
                                @forelse($medicines as $index => $medicine)
                                    @php
                                        $expDate = Carbon\Carbon::parse($medicine->tanggal_kadaluwarsa);
                                        $isExpiringSoon = $expDate->isFuture() && $expDate->diffInMonths(now()) <= 6;
                                        $isExpired = $expDate->isPast();
                                        
                                        $badgeColor = 'bg-green-50 text-green-600 border-green-100';
                                        if ($medicine->status == 'Menipis' || $medicine->stok_obat < 50) {
                                            $badgeColor = 'bg-amber-50 text-amber-600 border-amber-100';
                                        }
                                        if ($medicine->status == 'Habis' || $medicine->stok_obat == 0) {
                                            $badgeColor = 'bg-red-50 text-red-600 border-red-100';
                                        }
                                    @endphp
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-8 py-5 text-sm font-bold text-gray-400">{{ $index + 1 }}</td>
                                        <td class="px-8 py-5 search-target-name">
                                            <p class="text-sm font-extrabold text-gray-900 leading-snug">{{ $medicine->nama_obat }}</p>
                                        </td>
                                        <td class="px-8 py-5">
                                            <p class="text-xs font-bold text-gray-600">{{ $medicine->jenis_obat }}</p>
                                            <p class="text-[10px] text-gray-400 font-bold tracking-tight uppercase">{{ $medicine->kandungan_obat ?? '-' }}</p>
                                        </td>
                                        <td class="px-8 py-5 text-center text-sm font-bold text-gray-800">
                                            {{ $medicine->stok_obat }}
                                        </td>
                                        <td class="px-8 py-5 text-right text-sm font-bold text-gray-800">
                                            Rp {{ number_format($medicine->harga_obat, 0, ',', '.') }}
                                        </td>
                                        <td class="px-8 py-5 text-center">
                                            <span class="text-xs font-bold @if($isExpired) text-red-600 @elseif($isExpiringSoon) text-amber-600 @else text-gray-600 @endif">
                                                {{ $expDate->translatedFormat('d M Y') }}
                                                @if($isExpired)
                                                    <span class="block text-[9px] text-red-500 font-black tracking-wider uppercase mt-0.5">EXPIRED!</span>
                                                @elseif($isExpiringSoon)
                                                    <span class="block text-[9px] text-amber-500 font-black tracking-wider uppercase mt-0.5">EXPIRING SOON</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 text-center">
                                            <span class="px-2.5 py-1 rounded-lg border text-[10px] font-black uppercase tracking-wider {{ $badgeColor }}">
                                                {{ $medicine->status }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5">
                                            <div class="flex justify-center space-x-3">
                                                <a href="{{ route('farmasi.obat.edit', $medicine->id_obat) }}" class="action-btn action-btn-edit shadow-sm" title="Edit">
                                                    <i class="fa-solid fa-pencil text-xs"></i>
                                                </a>
                                                <form action="{{ route('farmasi.obat.destroy', $medicine->id_obat) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data obat ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn action-btn-delete shadow-sm" title="Hapus">
                                                        <i class="fa-solid fa-trash text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-8 py-16 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-4">
                                                    <i class="fa-solid fa-capsules text-2xl"></i>
                                                </div>
                                                <p class="text-sm font-bold text-gray-400">Belum ada data obat yang terdaftar.</p>
                                                <p class="text-xs text-gray-300 mt-1">Silakan gunakan form di atas untuk menambahkan data.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Section: Paket Obat -->
            <div id="section-paket" class="space-y-6 hidden">
                <!-- Form Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800">{{ isset($editingPackage) ? 'Edit Paket Obat' : 'Tambah Paket Obat Baru' }}</h3>
                        <p class="text-sm text-gray-400 font-medium">Lengkapi detail paket obat di bawah ini.</p>
                    </div>

                    @php
                        $packageAction = isset($editingPackage)
                            ? route('farmasi.update', $editingPackage->id)
                            : route('farmasi.store');
                    @endphp

                    <form action="{{ $packageAction }}" method="POST" class="space-y-6">
                        @csrf
                        @if(isset($editingPackage))
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Nama Paket</label>
                                <input name="nama_paket" value="{{ old('nama_paket', $editingPackage->nama_paket ?? '') }}" type="text" required class="w-full bg-gray-50 border-gray-200 border rounded-2xl px-5 py-3.5 text-sm font-semibold focus:ring-2 focus:ring-primary-green/20 focus:border-primary-green outline-none transition-all" placeholder="Contoh: Paket Operasi Ringan">
                                @error('nama_paket')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Jenis Obat</label>
                                <input name="jenis_obat" value="{{ old('jenis_obat', $editingPackage->jenis_obat ?? '') }}" type="text" required class="w-full bg-gray-50 border-gray-200 border rounded-2xl px-5 py-3.5 text-sm font-semibold focus:ring-2 focus:ring-primary-green/20 focus:border-primary-green outline-none transition-all" placeholder="Contoh: Antibiotik & Analgesik">
                                @error('jenis_obat')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Total Paket</label>
                                <input name="total_paket" value="{{ old('total_paket', $editingPackage->total_paket ?? '') }}" type="number" min="1" required class="w-full bg-gray-50 border-gray-200 border rounded-2xl px-5 py-3.5 text-sm font-semibold focus:ring-2 focus:ring-primary-green/20 focus:border-primary-green outline-none transition-all" placeholder="Jumlah stok">
                                @error('total_paket')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Preoperatif</label>
                                <input name="preoperatif" value="{{ old('preoperatif', $editingPackage->preoperatif ?? '') }}" type="text" class="w-full bg-gray-50 border-gray-200 border rounded-2xl px-5 py-3.5 text-sm font-semibold focus:ring-2 focus:ring-primary-green/20 focus:border-primary-green outline-none transition-all" placeholder="Obat sebelum operasi">
                                @error('preoperatif')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Intraoperatif</label>
                                <input name="intraoperatif" value="{{ old('intraoperatif', $editingPackage->intraoperatif ?? '') }}" type="text" class="w-full bg-gray-50 border-gray-200 border rounded-2xl px-5 py-3.5 text-sm font-semibold focus:ring-2 focus:ring-primary-green/20 focus:border-primary-green outline-none transition-all" placeholder="Obat selama operasi">
                                @error('intraoperatif')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Postoperatif</label>
                                <input name="postoperatif" value="{{ old('postoperatif', $editingPackage->postoperatif ?? '') }}" type="text" class="w-full bg-gray-50 border-gray-200 border rounded-2xl px-5 py-3.5 text-sm font-semibold focus:ring-2 focus:ring-primary-green/20 focus:border-primary-green outline-none transition-all" placeholder="Obat setelah operasi">
                                @error('postoperatif')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-2">
                            @if(isset($editingPackage))
                                <a href="{{ route('farmasi') }}" class="px-8 py-3.5 rounded-2xl border border-gray-200 text-gray-500 font-bold text-sm hover:bg-gray-50 transition-all text-center">Batal</a>
                            @endif
                            <button type="submit" class="px-10 py-3.5 rounded-2xl bg-primary-green text-white font-bold text-sm shadow-lg shadow-emerald-500/20 hover:bg-primary-green-hover transition-all">
                                {{ isset($editingPackage) ? 'Simpan Perubahan' : 'Tambah Paket' }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Table Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-50">
                        <h3 class="text-lg font-bold text-gray-800">Daftar Paket Obat Bedah</h3>
                        <p class="text-sm text-gray-400 font-medium">Daftar paket obat yang tersedia untuk keperluan tindakan operasi.</p>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left" id="paketTable">
                            <thead>
                                <tr class="bg-gray-50/50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">
                                    <th class="px-8 py-5">No</th>
                                    <th class="px-8 py-5">Nama Paket</th>
                                    <th class="px-8 py-5">Jenis Obat</th>
                                    <th class="px-8 py-5 text-center">Stok</th>
                                    <th class="px-8 py-5">Preoperatif</th>
                                    <th class="px-8 py-5">Intraoperatif</th>
                                    <th class="px-8 py-5">Postoperatif</th>
                                    <th class="px-8 py-5 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-xs font-bold text-gray-700">
                                @forelse($packages as $index => $package)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-8 py-5 text-sm font-bold text-gray-400">{{ $index + 1 }}</td>
                                        <td class="px-8 py-5 search-target-name">
                                            <p class="text-sm font-extrabold text-gray-900 leading-snug">{{ $package->nama_paket }}</p>
                                        </td>
                                        <td class="px-8 py-5 text-gray-600 font-semibold">{{ $package->jenis_obat }}</td>
                                        <td class="px-8 py-5 text-center">
                                            <span class="px-2.5 py-1 rounded bg-emerald-50 text-[#1b5e20] text-xs font-extrabold">
                                                {{ $package->total_paket }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 font-semibold text-gray-500">{{ $package->preoperatif ?? '-' }}</td>
                                        <td class="px-8 py-5 font-semibold text-gray-500">{{ $package->intraoperatif ?? '-' }}</td>
                                        <td class="px-8 py-5 font-semibold text-gray-500">{{ $package->postoperatif ?? '-' }}</td>
                                        <td class="px-8 py-5">
                                            <div class="flex justify-center space-x-3">
                                                <a href="{{ route('farmasi.edit', $package->id) }}" class="action-btn action-btn-edit shadow-sm" title="Edit">
                                                    <i class="fa-solid fa-pencil text-xs"></i>
                                                </a>
                                                <form action="{{ route('farmasi.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus paket obat ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn action-btn-delete shadow-sm" title="Hapus">
                                                        <i class="fa-solid fa-trash text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-8 py-16 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-4">
                                                    <i class="fa-solid fa-box-open text-2xl"></i>
                                                </div>
                                                <p class="text-sm font-bold text-gray-400">Belum ada paket obat yang terdaftar.</p>
                                                <p class="text-xs text-gray-300 mt-1">Silakan gunakan form di atas untuk menambahkan data.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <footer class="pt-6 pb-2 text-center">
                <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.2em]">&copy; 2026 RSUD Kota Malang. ALL RIGHTS RESERVED.</p>
            </footer>
        </div>
    </main>

    @php
        $activeTab = isset($editingPackage) ? 'paket' : (isset($editingMedicine) ? 'obat' : 'obat');
    @endphp

    <script>
        let activeTab = '{{ $activeTab }}';

        function switchTab(tab) {
            activeTab = tab;
            const tabObat = document.getElementById('tab-obat');
            const tabPaket = document.getElementById('tab-paket');
            const secObat = document.getElementById('section-obat');
            const secPaket = document.getElementById('section-paket');

            if (tab === 'obat') {
                secObat.classList.remove('hidden');
                secPaket.classList.add('hidden');
                tabObat.className = "border-primary-green text-primary-green flex items-center space-x-2 py-4 px-1 border-b-2 font-bold text-sm cursor-pointer outline-none";
                tabPaket.className = "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center space-x-2 py-4 px-1 border-b-2 font-semibold text-sm cursor-pointer outline-none";
            } else {
                secPaket.classList.remove('hidden');
                secObat.classList.add('hidden');
                tabPaket.className = "border-primary-green text-primary-green flex items-center space-x-2 py-4 px-1 border-b-2 font-bold text-sm cursor-pointer outline-none";
                tabObat.className = "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center space-x-2 py-4 px-1 border-b-2 font-semibold text-sm cursor-pointer outline-none";
            }
            filterData();
        }

        function filterData() {
            const query = document.getElementById('searchInput').value.toLowerCase().trim();
            const tableId = activeTab === 'obat' ? 'obatTable' : 'paketTable';
            const rows = document.querySelectorAll(`#${tableId} tbody tr`);

            rows.forEach(row => {
                const nameCell = row.querySelector('.search-target-name');
                if (!nameCell) return;
                const name = nameCell.textContent.toLowerCase();
                
                if (name.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Initialize state on load
        document.addEventListener('DOMContentLoaded', () => {
            switchTab(activeTab);
        });
    </script>

</body>
</html>
