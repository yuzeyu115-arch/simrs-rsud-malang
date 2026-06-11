<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Operasi (Bedah) - RSUD Kota Malang</title>
    
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
        .stat-card { border-radius: 12px; padding: 16px; border: 1px solid rgba(0,0,0,0.05); }
        .badge {
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: capitalize;
        }
    </style>
</head>
<body class="flex overflow-hidden h-screen text-gray-800">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col flex-shrink-0 shadow-sm z-20">
        <div class="p-6 flex items-center space-x-3">
            <div class="w-8 h-8 bg-primary-green rounded-lg flex items-center justify-center text-white shadow-md">
                <i class="fa-solid fa-hospital"></i>
            </div>
            <span class="text-xl font-bold text-gray-800 tracking-tight">RS SAHABAT SEHAT</span>
        </div>

        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-4 mb-2">UTAMA</p>
            <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-house w-5"></i> <span>Dashboard KPI</span>
            </a>
            <a href="{{ url('/jadwal-operasi') }}" class="flex items-center space-x-3 p-3 rounded-xl sidebar-active transition-all text-sm">
                 <i class="fa-solid fa-calendar-check w-5 text-primary-green"></i> <span>Jadwal Operasi (Bedah)</span>
            </a>
            <a href="{{ url('/bed-manager') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-bed w-5"></i> <span>Bed Manager</span>
            </a>

            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-6 mb-2">LOGISTIK</p>
            <a href="{{ url('/farmasi') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-pills w-5"></i> <span>Farmasi & Obat</span>
            </a>
            <a href="{{ url('/gizi') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-utensils w-5"></i> <span>Gizi</span>
            </a>
            <a href="{{ url('/bed-manager') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-bed w-5"></i> <span>Bed Manager</span>
            </a>

            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-6 mb-2 text-gray-400">JANJI TEMU</p>
              <a href="#" data-title="Tambah Janji Temu" data-body="Fitur menambah janji temu belum diimplementasikan." class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                  <i class="fa-solid fa-calendar-plus w-5"></i> <span>Add Appointment</span>
              </a>
              <a href="#" data-title="Daftar Janji Temu" data-body="Daftar janji temu belum tersedia di UI saat ini." class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                  <i class="fa-solid fa-list-check w-5"></i> <span>List Appointment</span>
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
        <div class="sticky top-0 bg-white/80 backdrop-blur-md px-8 py-4 z-10 flex justify-between items-center border-b border-gray-50">
            <button class="text-gray-500 text-xl"><i class="fa-solid fa-bars"></i></button>
            <div class="flex items-center space-x-6">
                <div class="relative w-80">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input id="globalSearch" type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl bg-gray-50 text-sm outline-none focus:ring-2 focus:ring-primary-green/20 focus:border-primary-green transition-all" placeholder="Cari nama tenaga medis atau pasien...">
                    <div id="searchResults" class="absolute left-0 right-0 mt-2 bg-white border border-gray-100 rounded-lg shadow-lg z-50 hidden max-h-64 overflow-auto"></div>
                </div>

                <a href="{{ url('/notifications') }}" class="relative text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[8px] font-bold w-4 h-4 rounded-full flex items-center justify-center">3</span>
                </a>

                <a href="{{ url('/profile') }}" class="flex items-center space-x-3 bg-white px-4 py-1.5 rounded-xl border border-gray-100 shadow-sm hover:bg-gray-50">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-800 leading-none">Dr. Devia Amanda</p>
                        <p class="text-[10px] text-gray-400 font-bold mt-1 uppercase">Kepala Bedah Umum</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Devia+Amanda&background=10b981&color=fff" class="w-9 h-9 rounded-full" alt="Profile">
                    <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
                </a>
            </div>
        </div>

        <div class="p-8 space-y-6">
            
            <!-- Breadcrumb & Title -->
            <div>
                <nav class="flex text-xs font-bold text-gray-400 mb-2 space-x-2">
                    <span class="text-green-600">Utama</span>
                    <span>/</span>
                    <span>Jadwal Operasi (Bedah)</span>
                </nav>
                <h2 class="text-3xl font-black text-[#1b5e20] tracking-tight">Jadwal Operasi (Bedah)</h2>
                <p class="text-sm font-semibold text-gray-500 mt-1">Kelola jadwal operasi bedah rumah sakit.</p>
            </div>

            <script>
                (function(){
                    const input = document.getElementById('globalSearch');
                    const resultsBox = document.getElementById('searchResults');
                    let timer = null;

                    function renderResults(items){
                        if(!items || items.length === 0){ resultsBox.classList.add('hidden'); resultsBox.innerHTML=''; return; }
                        resultsBox.classList.remove('hidden');
                        resultsBox.innerHTML = items.map(it => `
                            <a href="${it.link}" class="block px-4 py-3 hover:bg-gray-50 border-b last:border-b-0">
                                <div class="text-sm font-bold text-gray-800">${it.title}</div>
                                <div class="text-xs text-gray-500 mt-1">${it.meta || it.type}</div>
                            </a>
                        `).join('');
                    }

                    input.addEventListener('input', function(e){
                        const q = this.value.trim();
                        clearTimeout(timer);
                        if (q.length < 2) { renderResults([]); return; }
                        timer = setTimeout(()=>{
                            fetch(`/quick-search?q=${encodeURIComponent(q)}`)
                                .then(r=>r.json())
                                .then(renderResults)
                                .catch(()=>renderResults([]));
                        }, 250);
                    });

                    document.addEventListener('click', function(ev){
                        if (!ev.target.closest('#searchResults') && !ev.target.closest('#globalSearch')){
                            resultsBox.classList.add('hidden');
                        }
                    });
                })();
            </script>

            <!-- Filter Bar -->
            <form id="filterForm" method="GET" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-50 flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Tanggal</label>
                    <div class="relative">
                        <input type="date" name="tanggal" value="{{ request('tanggal', now()->format('Y-m-d')) }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-green-500/20 bg-white">
                        <i class="fa-solid fa-calendar-days absolute right-4 top-3 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Ruangan</label>
                    <select name="ruang_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-green-500/20 bg-white">
                        <option value="">Semua Ruangan</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ request('ruang_id') == $room->id ? 'selected' : '' }}>{{ $room->nama_ruang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Status</label>
                    <select name="status" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-green-500/20 bg-white">
                        <option value="">Semua Status</option>
                        <option value="Terjadwal" {{ request('status') == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="Berjalan" {{ request('status') == 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="flex-[1.5] min-w-[200px]">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Cari Pasien / Dokter</label>
                    <div class="relative">
                        <input type="text" name="search" placeholder="Cari nama pasien / dokter..." value="{{ request('search') }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-green-500/20 bg-white">
                        <i class="fa-solid fa-magnifying-glass absolute right-4 top-3 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-primary-green text-white px-6 py-2.5 rounded-xl font-bold hover:bg-primary-green-hover transition-all flex items-center space-x-1">
                        <i class="fa-solid fa-filter text-sm"></i>
                        <span>Filter</span>
                    </button>
                    @if(request()->query())
                        <a href="{{ route('jadwal-operasi') }}" class="border border-gray-200 text-gray-600 px-4 py-2.5 rounded-xl font-bold hover:bg-gray-50 transition-all">Reset</a>
                    @endif
                </div>
            </form>
                <button class="bg-[#1b5e20] text-white px-6 py-2.5 rounded-xl font-bold flex items-center space-x-2 shadow-lg shadow-green-900/10 hover:bg-[#164919] transition-all">
                    <i class="fa-solid fa-plus text-sm"></i>
                    <span>Jadwal Baru</span>
                </button>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-2xl p-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-50">
                <h3 class="text-lg font-black text-green-900 mb-4">{{ isset($editingSchedule) ? 'Edit Jadwal Operasi' : 'Tambah Jadwal Operasi Baru' }}</h3>
                @php
                    $formAction = isset($editingSchedule)
                        ? route('jadwal-operasi.update', $editingSchedule->id)
                        : route('jadwal-operasi.store');
                @endphp
                <form action="{{ $formAction }}" method="POST" class="grid gap-4 lg:grid-cols-2">
                    @csrf
                    @if(isset($editingSchedule))
                        @method('PUT')
                    @endif
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Nama Pasien</label>
                        <input name="nama_pasien" value="{{ old('nama_pasien', $editingSchedule->nama_pasien ?? '') }}" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20" placeholder="Nama pasien">
                        @error('nama_pasien')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Nomor RM</label>
                        <input name="nomor_rm" value="{{ old('nomor_rm', $editingSchedule->nomor_rm ?? '') }}" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20" placeholder="Contoh: 00012345">
                        @error('nomor_rm')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Dokter Bedah</label>
                        <select name="dokter_bedah_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20">
                            <option value="">Pilih dokter bedah</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('dokter_bedah_id', $editingSchedule->dokter_bedah_id ?? '') == $doctor->id ? 'selected' : '' }}>{{ $doctor->nama }}</option>
                            @endforeach
                        </select>
                        @error('dokter_bedah_id')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Dokter Anestesi</label>
                        <select name="dokter_anestesi_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20">
                            <option value="">Pilih dokter anestesi</option>
                            @foreach($anesthesias as $anesthesia)
                                <option value="{{ $anesthesia->id }}" {{ old('dokter_anestesi_id', $editingSchedule->dokter_anestesi_id ?? '') == $anesthesia->id ? 'selected' : '' }}>{{ $anesthesia->nama }}</option>
                            @endforeach
                        </select>
                        @error('dokter_anestesi_id')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Ruang Operasi</label>
                        <select name="ruang_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20">
                            <option value="">Pilih ruang operasi</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('ruang_id', $editingSchedule->ruang_id ?? '') == $room->id ? 'selected' : '' }}>{{ $room->nama_ruang }}</option>
                            @endforeach
                        </select>
                        @error('ruang_id')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Tanggal Operasi</label>
                        <input name="tanggal_operasi" value="{{ old('tanggal_operasi', $editingSchedule->tanggal_operasi ?? '') }}" type="date" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20">
                        @error('tanggal_operasi')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Jam Mulai</label>
                        <input name="jam_mulai" value="{{ old('jam_mulai', $editingSchedule->jam_mulai ?? '') }}" type="time" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20">
                        @error('jam_mulai')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Jenis Tindakan</label>
                        <input name="jenis_tindakan" value="{{ old('jenis_tindakan', $editingSchedule->jenis_tindakan ?? '') }}" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20" placeholder="Contoh: Appendektomi">
                        @error('jenis_tindakan')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    @if(isset($editingSchedule))
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Status</label>
                            <select name="status" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20">
                                <option value="Terjadwal" {{ old('status', $editingSchedule->status) == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                                <option value="Berjalan" {{ old('status', $editingSchedule->status) == 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                                <option value="Selesai" {{ old('status', $editingSchedule->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Dibatalkan" {{ old('status', $editingSchedule->status) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            @error('status')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    @endif
                    <div class="lg:col-span-2 text-right flex flex-wrap items-center justify-end gap-3">
                        @if(isset($editingSchedule))
                            <a href="{{ route('jadwal-operasi') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition-all">Batal</a>
                        @endif
                        <button type="submit" class="bg-primary-green text-white px-6 py-3 rounded-xl font-bold hover:bg-primary-green-hover transition-all">{{ isset($editingSchedule) ? 'Perbarui Jadwal' : 'Simpan Jadwal' }}</button>
                    </div>
                </form>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-5 gap-4">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-50 flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-green-600 uppercase mb-0.5">Total Operasi Hari Ini</p>
                        <h3 class="text-xl font-black">{{ $totalToday ?? 0 }} <span class="text-[10px] text-gray-400 font-bold">Jadwal</span></h3>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-50 flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-blue-600 uppercase mb-0.5">Selesai</p>
                        <h3 class="text-xl font-black">{{ $selesai ?? 0 }} <span class="text-[10px] text-gray-400 font-bold">Jadwal</span></h3>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-50 flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-600">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-orange-600 uppercase mb-0.5">Berlangsung</p>
                        <h3 class="text-xl font-black">{{ $berlangsung ?? 0 }} <span class="text-[10px] text-gray-400 font-bold">Jadwal</span></h3>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-50 flex items-center space-x-4 border-red-50">
                    <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-500">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-red-500 uppercase mb-0.5">Dibatalkan</p>
                        <h3 class="text-xl font-black text-red-600">{{ $dibatalkan ?? 0 }} <span class="text-[10px] text-gray-400 font-bold">Jadwal</span></h3>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-50 flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400">
                        <i class="fa-solid fa-circle-pause"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-gray-500 uppercase mb-0.5">Belum Dimulai</p>
                        <h3 class="text-xl font-black">{{ $belum ?? 0 }} <span class="text-[10px] text-gray-400 font-bold">Jadwal</span></h3>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col min-h-[500px]">
                <div class="p-6 border-b border-gray-50">
                    <h4 class="text-lg font-black text-green-900">Daftar Jadwal Operasi</h4>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">
                            <tr>
                                <th class="p-4 w-12 text-center">No.</th>
                                <th class="p-4">Waktu</th>
                                <th class="p-4">Pasien</th>
                                <th class="p-4">Jenis Operasi</th>
                                <th class="p-4">Dokter</th>
                                <th class="p-4">Ruangan</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs font-bold text-gray-700 divide-y divide-gray-50">
                            @forelse($schedules as $index => $schedule)
                                @php
                                    $badgeClasses = [
                                        'Selesai' => 'bg-green-50 text-green-600 border border-green-100',
                                        'Berjalan' => 'bg-blue-50 text-blue-600 border border-blue-100',
                                        'Dibatalkan' => 'bg-red-50 text-red-500 border border-red-100',
                                        'Terjadwal' => 'bg-gray-100 text-gray-500 border border-gray-200',
                                    ];
                                    $statusClass = $badgeClasses[$schedule->status] ?? 'bg-gray-100 text-gray-500 border border-gray-200';
                                @endphp
                                <tr>
                                    <td class="p-4 text-center">{{ $index + 1 }}</td>
                                    <td class="p-4">{{ date('H:i', strtotime($schedule->jam_mulai)) }}</td>
                                    <td class="p-4">
                                        <p class="text-gray-900">{{ $schedule->nama_pasien }}</p>
                                        <p class="text-[10px] text-gray-400 font-black mt-0.5 tracking-tight uppercase">RM {{ $schedule->nomor_rm }}</p>
                                    </td>
                                    <td class="p-4 text-gray-500 font-semibold">{{ $schedule->jenis_tindakan }}</td>
                                    <td class="p-4">{{ $schedule->dokter_bedah ?? 'N/A' }}</td>
                                    <td class="p-4 font-black text-gray-800">{{ $schedule->nama_ruang ?? 'N/A' }}</td>
                                    <td class="p-4">
                                        <span class="badge {{ $statusClass }}">{{ $schedule->status }}</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('jadwal-operasi.edit', $schedule->id) }}" class="w-8 h-8 rounded-lg bg-white text-green-600 hover:bg-green-50 transition-all flex items-center justify-center border border-green-100 shadow-sm" title="Edit Jadwal">
                                                <i class="fa-solid fa-pen text-[10px]"></i>
                                            </a>
                                            <form action="{{ route('jadwal-operasi.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal operasi ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-white text-red-600 hover:bg-red-50 transition-all flex items-center justify-center border border-red-100 shadow-sm" title="Hapus Jadwal">
                                                    <i class="fa-solid fa-trash text-[10px]"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-6 text-center text-gray-500">Belum ada jadwal operasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-6 bg-gray-50/50 flex justify-between items-center border-t border-gray-50">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Menampilkan {{ $schedules->count() ? '1 - '.$schedules->count() : 0 }} dari {{ $schedules->count() }} data</p>
                    <div class="flex items-center space-x-1">
                        <button class="w-8 h-8 rounded-lg bg-white border border-gray-100 text-gray-400 hover:bg-gray-50 transition-all flex items-center justify-center"><i class="fa-solid fa-chevron-left text-[10px]"></i></button>
                        <button class="w-8 h-8 rounded-lg bg-[#1b5e20] text-white font-bold text-xs">1</button>
                        <button class="w-8 h-8 rounded-lg bg-white border border-gray-100 text-gray-500 font-bold text-xs hover:bg-gray-50 transition-all">2</button>
                        <button class="w-8 h-8 rounded-lg bg-white border border-gray-100 text-gray-500 font-bold text-xs hover:bg-gray-50 transition-all">3</button>
                        <button class="w-8 h-8 rounded-lg bg-white border border-gray-100 text-gray-400 hover:bg-gray-50 transition-all flex items-center justify-center"><i class="fa-solid fa-chevron-right text-[10px]"></i></button>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
