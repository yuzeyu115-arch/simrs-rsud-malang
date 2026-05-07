<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Appointment - SIMRS RS Sahabat Sehat</title>
    
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
        .filter-input-wrapper { position: relative; }
        .filter-input {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 14px;
            padding-right: 40px;
            width: 100%;
            font-size: 13px;
            font-weight: 500;
            color: #334155;
            transition: all 0.2s;
        }
        .filter-input:focus {
            outline: none;
            border-color: #006d32;
            box-shadow: 0 0 0 3px rgba(0, 109, 50, 0.05);
        }
        .filter-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
            pointer-events: none;
        }
        .table-header {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 700;
            font-size: 12px;
            border-bottom: 2px solid #f1f5f9;
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
        }
        .status-terjadwal { background-color: #e0f2fe; color: #0369a1; }
        .status-selesai { background-color: #dcfce7; color: #15803d; }
        .status-menunggu { background-color: #fef9c3; color: #a16207; }
        
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
                <i class="fa-solid fa-hand-holding-medical text-2xl"></i>
            </div>
            <div>
                <h1 class="text-lg font-extrabold text-hospital-green leading-tight">RS SAHABAT SEHAT</h1>
                <p class="text-[10px] font-semibold text-slate-400">Pelayanan Ramah, Kesehatan Optimal</p>
            </div>
        </div>

        <nav class="flex-1 px-6 mt-6 space-y-1 overflow-y-auto pb-10">
            <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] px-4 mt-4 mb-2">UTAMA</p>
            <a href="{{ url('/dashboard') }}" class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 transition-all text-sm font-bold">
                 <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-house"></i></div>
                 <span>Dashboard</span>
            </a>

            <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] px-4 mt-8 mb-2">GIZI</p>
            <a href="{{ url('/gizi') }}" class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 transition-all text-sm font-bold">
                 <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-cart-shopping"></i></div>
                 <span>Pemesanan Menu</span>
            </a>
            <a href="#" class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 transition-all text-sm font-bold">
                 <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-file-invoice"></i></div>
                 <span>Laporan Pemesanan</span>
            </a>
            <a href="#" class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 transition-all text-sm font-bold">
                 <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-calendar-days"></i></div>
                 <span>Jadwal Makan</span>
            </a>

            <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] px-4 mt-8 mb-2">JANJI TEMU</p>
            <a href="{{ url('/janji-temu') }}" class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 transition-all text-sm font-bold">
                 <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-circle-plus"></i></div>
                 <span>Add Appointment</span>
            </a>
            <a href="{{ url('/janji-temu/list') }}" class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl sidebar-active shadow-sm transition-all text-sm font-bold">
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
            <div class="relative w-96">
                <input type="text" placeholder="Pencarian Cepat..." class="w-full bg-slate-100 border-none rounded-full py-2.5 px-6 text-sm font-medium focus:ring-2 focus:ring-hospital-green/20 placeholder-slate-400">
                <i class="fa-solid fa-magnifying-glass absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            </div>
            
            <div class="flex items-center space-x-6">
                <!-- Notifications -->
                <div class="relative cursor-pointer group">
                    <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-500 group-hover:text-hospital-green transition-colors">
                        <i class="fa-solid fa-bell text-lg"></i>
                    </div>
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 border-2 border-white text-white text-[10px] font-black flex items-center justify-center rounded-full">3</span>
                </div>

                <!-- User Profile -->
                <div class="flex items-center space-x-3 pl-6 border-l border-slate-200">
                    <img src="https://ui-avatars.com/api/?name=Devia+Amanda&background=006d32&color=fff" class="w-11 h-11 rounded-full border-2 border-hospital-green/10 shadow-sm" alt="Profile">
                    <div class="hidden md:block">
                        <p class="text-sm font-bold text-slate-800 leading-tight flex items-center">
                            Dr. Devia Amanda
                            <i class="fa-solid fa-chevron-down ml-2 text-[10px] text-slate-400"></i>
                        </p>
                        <p class="text-[11px] text-slate-400 font-bold mt-0.5">Kepala Bedah Umum</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="p-10 max-w-[1400px] mx-auto space-y-6">
            
            <!-- Header & Breadcrumbs & Add Button -->
            <div class="flex justify-between items-end">
                <div>
                    <h2 class="text-3xl font-extrabold text-hospital-green tracking-tight">List Appointment</h2>
                    <div class="flex items-center mt-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                        <span class="breadcrumb-item">Dashboard</span>
                        <span class="breadcrumb-item">Janji Temu</span>
                        <span class="text-hospital-green">List Appointment</span>
                    </div>
                </div>
                <a href="{{ url('/janji-temu') }}" class="bg-hospital-green text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg shadow-green-900/20 hover:bg-green-800 transition-all flex items-center space-x-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>Add Appointment</span>
                </a>
            </div>

            <!-- List Appointment Card (Filter) -->
            <div class="bg-white rounded-[24px] shadow-sm overflow-hidden border border-slate-100 p-8">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-slate-700 mb-2">Cari Pasien</label>
                        <div class="filter-input-wrapper">
                            <input type="text" class="filter-input" placeholder="Cari nama pasien...">
                            <i class="fa-solid fa-magnifying-glass filter-icon"></i>
                        </div>
                    </div>
                    <div class="md:col-span-5">
                        <label class="block text-xs font-bold text-slate-700 mb-2">Tanggal</label>
                        <div class="flex items-center space-x-3">
                            <div class="filter-input-wrapper flex-1">
                                <input type="text" class="filter-input" placeholder="dd/mm/yyyy">
                                <i class="fa-solid fa-calendar-days filter-icon"></i>
                            </div>
                            <span class="text-slate-400 text-xs font-bold">s/d</span>
                            <div class="filter-input-wrapper flex-1">
                                <input type="text" class="filter-input" placeholder="dd/mm/yyyy">
                                <i class="fa-solid fa-calendar-days filter-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-2">Status</label>
                        <select class="filter-input appearance-none">
                            <option>Semua</option>
                            <option>Terjadwal</option>
                            <option>Selesai</option>
                            <option>Menunggu</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <button class="w-full bg-hospital-green text-white py-2.5 rounded-xl text-sm font-bold hover:bg-green-800 transition-all">
                            Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-[24px] shadow-sm overflow-hidden border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="table-header">
                                <th class="px-6 py-5">No</th>
                                <th class="px-6 py-5">Nama Pasien</th>
                                <th class="px-6 py-5">Ruang / Poliklinik</th>
                                <th class="px-6 py-5">Tanggal</th>
                                <th class="px-6 py-5">Jam</th>
                                <th class="px-6 py-5">Dokter</th>
                                <th class="px-6 py-5">Jenis</th>
                                <th class="px-6 py-5">Status</th>
                                <th class="px-6 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($appointments as $index => $appointment)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $index + 1 }}</td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-extrabold text-slate-800">{{ $appointment->nama_pasien }}</p>
                                    <p class="text-[10px] font-bold text-slate-400">RM. {{ $appointment->nomor_rm }}</p>
                                </td>
                                <td class="px-6 py-5 text-sm font-bold text-slate-600">{{ $appointment->poliklinik }}</td>
                                <td class="px-6 py-5 text-sm font-bold text-slate-600">{{ \Carbon\Carbon::parse($appointment->tanggal_janji)->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-5 text-sm font-bold text-slate-600">{{ \Carbon\Carbon::parse($appointment->jam_janji)->format('H:i') }}</td>
                                <td class="px-6 py-5 text-sm font-bold text-slate-600">{{ $appointment->dokter_tujuan }}</td>
                                <td class="px-6 py-5 text-sm font-bold text-slate-600">{{ $appointment->jenis ?? 'Kontrol' }}</td>
                                <td class="px-6 py-5">
                                    @php
                                        $statusClass = match($appointment->status ?? 'Terjadwal') {
                                            'Terjadwal' => 'status-terjadwal',
                                            'Selesai' => 'status-selesai',
                                            'Menunggu' => 'status-menunggu',
                                            default => 'status-terjadwal',
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }} shadow-sm">{{ $appointment->status ?? 'Terjadwal' }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex justify-center space-x-3">
                                        <a href="{{ route('janji-temu.edit', $appointment->id) }}" class="action-btn action-btn-edit shadow-sm" title="Edit">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('janji-temu.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus janji temu ini?');">
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
                                <td colspan="9" class="px-6 py-12 text-center text-sm font-bold text-slate-400">
                                    <i class="fa-solid fa-calendar-xmark text-3xl mb-3 block text-slate-300"></i>
                                    Belum ada data janji temu.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Footer -->
                <div class="px-8 py-6 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-xs font-bold text-slate-400">Menampilkan 1 - {{ count($appointments) }} dari {{ count($appointments) }} data</p>
                    
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center space-x-1">
                            <button class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-slate-100"><i class="fa-solid fa-chevron-left text-[10px]"></i></button>
                            <button class="w-8 h-8 rounded-lg flex items-center justify-center bg-hospital-green text-white font-bold text-xs">1</button>
                            <button class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-slate-100"><i class="fa-solid fa-chevron-right text-[10px]"></i></button>
                        </div>
                        
                        <div class="relative">
                            <select class="bg-slate-50 border border-slate-200 rounded-lg py-1.5 pl-3 pr-8 text-[11px] font-bold text-slate-600 appearance-none focus:outline-none">
                                <option>10 / halaman</option>
                                <option>25 / halaman</option>
                                <option>50 / halaman</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
