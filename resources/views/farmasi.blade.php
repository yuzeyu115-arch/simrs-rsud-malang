<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmasi & Obat - SimpleOK RSUD</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'hospital-green': '#006d32',
                        'hospital-green-light': '#e8f5e9',
                        'hospital-green-soft': '#f0fdf4',
                    },
                    fontFamily: {
                        'outfit': ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .sidebar-item { transition: all 0.2s ease; }
        .sidebar-active {
            background-color: #e8f5e9;
            color: #006d32;
            font-weight: 700;
        }
        .table-header {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 700;
            font-size: 12px;
            border-bottom: 2px solid #f1f5f9;
        }
        .action-btn {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
            background-color: #fff;
            transition: all 0.2s;
        }
        .action-btn-edit { color: #475569; }
        .action-btn-edit:hover { background-color: #f1f5f9; border-color: #cbd5e1; }
        .action-btn-delete { color: #ef4444; border-color: #fee2e2; }
        .action-btn-delete:hover { background-color: #fef2f2; border-color: #fecaca; }

        .breadcrumb-item:not(:last-child)::after {
            content: ">";
            margin: 0 8px;
            color: #94a3b8;
        }
    </style>
</head>
<body class="flex h-screen text-slate-800 overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-72 bg-white border-r border-slate-100 flex flex-col flex-shrink-0 z-20 shadow-sm">
        <div class="p-8 pb-4 flex items-center space-x-3">
            <div class="w-12 h-12 bg-hospital-green rounded-2xl flex items-center justify-center text-white shadow-lg shadow-green-900/20">
                <i class="fa-solid fa-hospital text-2xl"></i>
            </div>
            <div>
                <h1 class="text-lg font-extrabold text-hospital-green leading-tight">SimpleOK</h1>
                <p class="text-[10px] font-semibold text-slate-400">Pelayanan Ramah, Kesehatan Optimal</p>
            </div>
        </div>

        <nav class="flex-1 px-6 mt-6 space-y-1 overflow-y-auto pb-10">
            <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] px-4 mt-4 mb-2">UTAMA</p>
            <a href="{{ url('/dashboard') }}" class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 transition-all text-sm font-bold">
                 <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-house"></i></div>
                 <span>Dashboard KPI</span>
            </a>
            <a href="{{ url('/jadwal-operasi') }}" class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 transition-all text-sm font-bold">
                 <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-calendar-check"></i></div>
                 <span>Jadwal Operasi</span>
            </a>
            <a href="{{ url('/bed-manager') }}" class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 transition-all text-sm font-bold">
                 <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-bed"></i></div>
                 <span>Bed Manager</span>
            </a>

            <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] px-4 mt-8 mb-2">LOGISTIK</p>
            <a href="{{ url('/farmasi') }}" class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl sidebar-active shadow-sm transition-all text-sm font-bold">
                 <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-pills"></i></div>
                 <span>Farmasi & Obat</span>
            </a>
            <a href="{{ url('/gizi') }}" class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 transition-all text-sm font-bold">
                 <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-utensils"></i></div>
                 <span>Gizi</span>
            </a>

            <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] px-4 mt-8 mb-2">JANJI TEMU</p>
            <a href="{{ url('/janji-temu') }}" class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 transition-all text-sm font-bold">
                 <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-circle-plus"></i></div>
                 <span>Add Appointment</span>
            </a>
            <a href="{{ url('/janji-temu/list') }}" class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 transition-all text-sm font-bold">
                 <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-list-ul"></i></div>
                 <span>List Appointment</span>
            </a>

            <div class="pt-12 px-4">
                <a href="{{ url('/logout') }}" class="flex items-center space-x-3 text-red-500 font-extrabold text-sm hover:underline">
                    <i class="fa-solid fa-right-from-bracket text-lg"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto bg-slate-50/50">
        <!-- Topbar -->
        <header class="px-10 py-6 flex justify-between items-center bg-white sticky top-0 z-10 border-b border-slate-100">
            <div class="flex items-center">
                <h2 class="text-2xl font-black text-hospital-green tracking-tight">Farmasi & Obat</h2>
            </div>
            
            <div class="flex items-center space-x-6">
                <!-- User Profile -->
                <div class="flex items-center space-x-3 pl-6 border-l border-slate-200">
                    <img src="https://ui-avatars.com/api/?name=Devia+Amanda&background=006d32&color=fff" class="w-11 h-11 rounded-full border-2 border-hospital-green/10 shadow-sm" alt="Profile">
                    <div class="hidden md:block">
                        <p class="text-sm font-bold text-slate-800 leading-tight">Dr. Devia Amanda</p>
                        <p class="text-[11px] text-slate-400 font-bold mt-0.5">Kepala Bedah Umum</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="p-10 max-w-[1600px] mx-auto space-y-8">
            
            <!-- Header & Summary Row -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <h2 class="text-3xl font-extrabold text-hospital-green tracking-tight">Kelola Paket Obat</h2>
                    <div class="flex items-center mt-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                        <span class="breadcrumb-item">Logistik</span>
                        <span class="text-hospital-green">Farmasi & Obat</span>
                    </div>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="bg-white px-6 py-3 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
                        <div class="w-10 h-10 bg-hospital-green-light rounded-xl flex items-center justify-center text-hospital-green">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Paket</p>
                            <p class="text-xl font-black text-slate-800 leading-none">{{ $packages->count() }}</p>
                        </div>
                    </div>
                    
                    @if(!isset($editingPackage))
                    <button onclick="document.getElementById('form-paket').scrollIntoView({behavior: 'smooth'})" class="bg-hospital-green text-white px-6 py-3.5 rounded-2xl text-sm font-bold shadow-lg shadow-green-900/20 hover:bg-green-800 transition-all flex items-center space-x-2">
                        <i class="fa-solid fa-plus"></i>
                        <span>Paket Baru</span>
                    </button>
                    @endif
                </div>
            </div>

            <!-- Form Card -->
            <div id="form-paket" class="bg-white rounded-[32px] shadow-sm overflow-hidden border border-slate-100 p-8 transition-all duration-500">
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-slate-800">{{ isset($editingPackage) ? 'Edit Paket Obat' : 'Tambah Paket Obat Baru' }}</h3>
                    <p class="text-sm text-slate-400 font-medium">Lengkapi detail paket obat di bawah ini.</p>
                </div>

                @if(session('success'))
                    <div class="mb-8 rounded-2xl bg-emerald-50 border border-emerald-100 p-4 text-emerald-700 font-bold text-sm flex items-center space-x-3 animate-pulse">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

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
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Nama Paket</label>
                            <input name="nama_paket" value="{{ old('nama_paket', $editingPackage->nama_paket ?? '') }}" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-sm font-semibold focus:ring-2 focus:ring-hospital-green/20 transition-all" placeholder="Contoh: Paket Operasi Ringan">
                            @error('nama_paket')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Jenis Obat</label>
                            <input name="jenis_obat" value="{{ old('jenis_obat', $editingPackage->jenis_obat ?? '') }}" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-sm font-semibold focus:ring-2 focus:ring-hospital-green/20 transition-all" placeholder="Contoh: Antibiotik & Analgesik">
                            @error('jenis_obat')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Total Paket</label>
                            <input name="total_paket" value="{{ old('total_paket', $editingPackage->total_paket ?? '') }}" type="number" min="1" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-sm font-semibold focus:ring-2 focus:ring-hospital-green/20 transition-all" placeholder="Jumlah stok">
                            @error('total_paket')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Preoperatif</label>
                            <input name="preoperatif" value="{{ old('preoperatif', $editingPackage->preoperatif ?? '') }}" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-sm font-semibold focus:ring-2 focus:ring-hospital-green/20 transition-all" placeholder="Obat sebelum operasi">
                            @error('preoperatif')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Intraoperatif</label>
                            <input name="intraoperatif" value="{{ old('intraoperatif', $editingPackage->intraoperatif ?? '') }}" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-sm font-semibold focus:ring-2 focus:ring-hospital-green/20 transition-all" placeholder="Obat selama operasi">
                            @error('intraoperatif')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Postoperatif</label>
                            <input name="postoperatif" value="{{ old('postoperatif', $editingPackage->postoperatif ?? '') }}" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-sm font-semibold focus:ring-2 focus:ring-hospital-green/20 transition-all" placeholder="Obat setelah operasi">
                            @error('postoperatif')<p class="text-xs text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        @if(isset($editingPackage))
                            <a href="{{ route('farmasi') }}" class="px-8 py-4 rounded-2xl border border-slate-200 text-slate-500 font-bold text-sm hover:bg-slate-50 transition-all">Batal</a>
                        @endif
                        <button type="submit" class="px-10 py-4 rounded-2xl bg-hospital-green text-white font-bold text-sm shadow-lg shadow-green-900/20 hover:bg-green-800 transition-all">
                            {{ isset($editingPackage) ? 'Simpan Perubahan' : 'Tambah Paket' }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-[32px] shadow-sm overflow-hidden border border-slate-100">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Daftar Paket Obat</h3>
                        <p class="text-sm text-slate-400 font-medium">Daftar paket obat yang tersedia di logistik.</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="table-header">
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
                        <tbody class="divide-y divide-slate-50">
                            @forelse($packages as $index => $package)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-6 text-sm font-bold text-slate-400">{{ $index + 1 }}</td>
                                    <td class="px-8 py-6">
                                        <p class="text-sm font-extrabold text-slate-800">{{ $package->nama_paket }}</p>
                                    </td>
                                    <td class="px-8 py-6 text-sm font-bold text-slate-600">{{ $package->jenis_obat }}</td>
                                    <td class="px-8 py-6 text-center">
                                        <span class="px-3 py-1.5 rounded-lg bg-hospital-green-light text-hospital-green font-black text-xs">
                                            {{ $package->total_paket }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-sm font-semibold text-slate-500">{{ $package->preoperatif ?? '-' }}</td>
                                    <td class="px-8 py-6 text-sm font-semibold text-slate-500">{{ $package->intraoperatif ?? '-' }}</td>
                                    <td class="px-8 py-6 text-sm font-semibold text-slate-500">{{ $package->postoperatif ?? '-' }}</td>
                                    <td class="px-8 py-6">
                                        <div class="flex justify-center space-x-3">
                                            <a href="{{ route('farmasi.edit', $package->id) }}" class="action-btn action-btn-edit shadow-sm" title="Edit">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            <form action="{{ route('farmasi.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus paket obat ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn action-btn-delete shadow-sm" title="Hapus">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-8 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                                                <i class="fa-solid fa-box-open text-2xl"></i>
                                            </div>
                                            <p class="text-sm font-bold text-slate-400">Belum ada paket obat yang terdaftar.</p>
                                            <p class="text-xs text-slate-300 mt-1">Silakan gunakan form di atas untuk menambahkan data.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
