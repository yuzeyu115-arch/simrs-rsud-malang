<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmasi & Obat - SIMRS RSUD Kota Malang</title>
    
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
        body { font-family: 'Inter', sans-serif; background-color: #f3f4ee; }
        .table-row-hover:hover { background-color: #f8fafc; }
        .sidebar-active {
            background-color: #e8f5e9;
            color: #1b5e20;
            font-weight: 700;
        }
        .tab-active {
            background-color: #b9e3b6;
            color: #1b5e20;
            font-weight: bold;
        }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col flex-shrink-0 shadow-sm z-20">
        <div class="p-6 flex items-center space-x-3">
            <div class="w-8 h-8 bg-primary-green rounded-lg flex items-center justify-center text-white shadow-md">
                <i class="fa-solid fa-hospital"></i>
            </div>
            <span class="text-xl font-bold text-gray-800 tracking-tight">SIMRS</span>
        </div>

        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-4 mb-2">UTAMA</p>
            <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-house w-5"></i> <span>Dashboard KPI</span>
            </a>
            <a href="{{ url('/jadwal-operasi') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-calendar-check w-5"></i> <span>Jadwal Operasi (Bedah)</span>
            </a>
            <a href="{{ url('/bed-manager') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-bed w-5"></i> <span>Bed Manager</span>
            </a>

            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-6 mb-2">LOGISTIK</p>
            <a href="{{ url('/farmasi') }}" class="flex items-center space-x-3 p-3 rounded-xl sidebar-active transition-all text-sm">
                 <i class="fa-solid fa-pills w-5 text-primary-green"></i> <span>Farmasi & Obat</span>
            </a>
            <a href="{{ url('/gizi') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-utensils w-5"></i> <span>Gizi</span>
            </a>

            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-6 mb-2 text-gray-400">JANJI TEMU</p>
            <a href="{{ url('/janji-temu') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-calendar-plus w-5"></i> <span>Add Appointment</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
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
    <main class="flex-1 overflow-y-auto flex flex-col">
        <!-- Topbar -->
        <div class="sticky top-0 bg-white/80 backdrop-blur-md border-b border-gray-100 px-8 py-4 z-10 flex justify-between items-center">
            <div class="flex items-center">
                <h2 class="text-2xl font-black text-[#1b5e20] tracking-tight">Farmasi & Obat</h2>
            </div>
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-3 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-800 leading-none">Dr. Devia Amanda</p>
                        <p class="text-xs text-gray-500 mt-1">Kepala Bedah Umum</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Devia+Amanda&background=10b981&color=fff" class="w-10 h-10 rounded-full shadow-sm" alt="Profile">
                </div>
            </div>
        </div>

        <div class="p-8 flex-1">
            <div class="mb-6">
                <p class="text-sm font-medium text-green-700">Kelola pesanan paket obat rumah sakit hari ini.</p>
            </div>

            <!-- Two Column Layout -->
            <div class="flex flex-col lg:flex-row gap-6 h-full">
                <div class="w-full lg:w-1/3 flex flex-col gap-4">
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                        <p class="text-xs font-bold text-gray-500 mb-2">Total Paket Obat</p>
                        <div class="flex items-end gap-2">
                            <h3 class="text-4xl font-black text-black">{{ $packages->count() }}</h3>
                            <span class="text-sm font-bold text-gray-400 mb-1">Paket</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                        <p class="text-xs font-bold text-gray-500 mb-2">Aksi</p>
                        <div class="space-y-3">
                            <a href="{{ route('farmasi') }}" class="block w-full text-center px-4 py-3 rounded-xl bg-green-50 text-green-700 border border-green-100 font-bold hover:bg-green-100 transition-all">Tambah Paket Baru</a>
                            @if(isset($editingPackage))
                                <a href="{{ route('farmasi') }}" class="block w-full text-center px-4 py-3 rounded-xl border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 transition-all">Batal Edit</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-2/3 flex flex-col gap-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-green-900">{{ isset($editingPackage) ? 'Edit Paket Obat' : 'Form Paket Obat Baru' }}</h3>
                                <p class="text-sm text-gray-500 mt-1">Isi data paket obat untuk menyimpan ke database.</p>
                            </div>
                        </div>
                        @if(session('success'))
                            <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-100 p-4 text-emerald-700 font-semibold">{{ session('success') }}</div>
                        @endif
                        @php
                            $packageAction = isset($editingPackage)
                                ? route('farmasi.update', $editingPackage->id)
                                : route('farmasi.store');
                        @endphp
                        <form action="{{ $packageAction }}" method="POST" class="grid gap-4">
                            @csrf
                            @if(isset($editingPackage))
                                @method('PUT')
                            @endif
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Nama Paket</label>
                                    <input name="nama_paket" value="{{ old('nama_paket', $editingPackage->nama_paket ?? '') }}" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20" placeholder="Nama paket">
                                    @error('nama_paket')<p class="text-xs text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Jenis Obat</label>
                                    <input name="jenis_obat" value="{{ old('jenis_obat', $editingPackage->jenis_obat ?? '') }}" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20" placeholder="Contoh: Antibiotik">
                                    @error('jenis_obat')<p class="text-xs text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Total Paket</label>
                                    <input name="total_paket" value="{{ old('total_paket', $editingPackage->total_paket ?? '') }}" type="number" min="1" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20" placeholder="Jumlah paket">
                                    @error('total_paket')<p class="text-xs text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Preoperatif</label>
                                    <input name="preoperatif" value="{{ old('preoperatif', $editingPackage->preoperatif ?? '') }}" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20" placeholder="Contoh: Antibiotik profilaksis">
                                    @error('preoperatif')<p class="text-xs text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Intraoperatif</label>
                                    <input name="intraoperatif" value="{{ old('intraoperatif', $editingPackage->intraoperatif ?? '') }}" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20" placeholder="Contoh: Analgesik intravena">
                                    @error('intraoperatif')<p class="text-xs text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Postoperatif</label>
                                    <input name="postoperatif" value="{{ old('postoperatif', $editingPackage->postoperatif ?? '') }}" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20" placeholder="Contoh: Obat antinyeri">
                                    @error('postoperatif')<p class="text-xs text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="flex justify-end gap-3 pt-2">
                                @if(isset($editingPackage))
                                    <a href="{{ route('farmasi') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition-all">Batal</a>
                                @endif
                                <button type="submit" class="px-6 py-3 rounded-xl bg-primary-green text-white font-bold hover:bg-primary-green-hover transition-all">{{ isset($editingPackage) ? 'Perbarui Paket' : 'Tambah Paket' }}</button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-green-900">Daftar Paket Obat</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 text-xs font-bold uppercase text-gray-500 tracking-widest border-b border-gray-100">
                                    <tr>
                                        <th class="p-4">#</th>
                                        <th class="p-4">Nama Paket</th>
                                        <th class="p-4">Jenis Obat</th>
                                        <th class="p-4">Total</th>
                                        <th class="p-4">Preoperatif</th>
                                        <th class="p-4">Intraoperatif</th>
                                        <th class="p-4">Postoperatif</th>
                                        <th class="p-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                                    @forelse($packages as $index => $package)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="p-4 font-bold text-slate-500">{{ $index + 1 }}</td>
                                            <td class="p-4 font-semibold text-slate-800">{{ $package->nama_paket }}</td>
                                            <td class="p-4">{{ $package->jenis_obat }}</td>
                                            <td class="p-4">{{ $package->total_paket }}</td>
                                            <td class="p-4">{{ $package->preoperatif ?? '-' }}</td>
                                            <td class="p-4">{{ $package->intraoperatif ?? '-' }}</td>
                                            <td class="p-4">{{ $package->postoperatif ?? '-' }}</td>
                                            <td class="p-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('farmasi.edit', $package->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white border border-green-100 text-green-600 hover:bg-green-50 transition-all" title="Edit Paket">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                    <form action="{{ route('farmasi.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Hapus paket obat ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white border border-red-100 text-red-600 hover:bg-red-50 transition-all" title="Hapus Paket">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="p-6 text-center text-gray-500">Belum ada paket obat, silakan tambahkan data terlebih dahulu.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JavaScript for Tab Switching -->
            <script>
                function showTab(tabName, event) {
                    if (event) event.preventDefault();
                    
                    // Reset all tabs to inactive state
                    const allTabs = ['jantung', 'obgyn'];
                    
                    allTabs.forEach(name => {
                        const tabEl = document.getElementById('tab-' + name);
                        const contentEl = document.getElementById('content-' + name);
                        
                        if (tabEl && contentEl) {
                            if (name === tabName) {
                                // Set active
                                tabEl.className = "block px-5 py-4 rounded-lg tab-active text-sm transition-colors";
                                contentEl.classList.remove('hidden');
                            } else {
                                // Set inactive
                                tabEl.className = "block px-5 py-4 rounded-lg text-gray-600 hover:bg-gray-50 font-semibold text-sm transition-colors";
                                contentEl.classList.add('hidden');
                            }
                        }
                    });
                }
            </script>
        </div>
    </main>

</body>
</html>
