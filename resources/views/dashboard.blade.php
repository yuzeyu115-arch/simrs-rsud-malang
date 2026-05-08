<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SIMRS - RSUD Kota Malang</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

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
    </style>
</head>
<body class="bg-gray-50 flex min-h-screen">

    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col flex-shrink-0 shadow-sm z-20">
        <div class="p-6 flex items-center space-x-3">
            <div class="w-8 h-8 bg-primary-green rounded-lg flex items-center justify-center text-white shadow-md">
                <i class="fa-solid fa-hospital"></i>
            </div>
            <span class="text-xl font-bold text-gray-800 tracking-tight">SIMRS</span>
        </div>

        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-4 mb-2">UTAMA</p>
            <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3 p-3 rounded-xl sidebar-active transition-all text-sm font-semibold">
                 <i class="fa-solid fa-house w-5"></i> <span>Dashboard</span>
            </a>

            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-6 mb-2">BEDAH</p>
            <a href="{{ url('/jadwal-operasi') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-calendar-check w-5"></i> <span>Jadwal Operasi</span>
            </a>
            <a href="{{ url('/rapat-koordinasi') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
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
            <a href="{{ url('/farmasi') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-pills w-5"></i> <span>Farmasi & Obat</span>
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

    <main class="flex-1 overflow-y-auto">
        
        <div class="sticky top-0 bg-white/80 backdrop-blur-md border-b border-gray-100 px-8 py-4 z-10 flex justify-between items-center">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl bg-gray-50 text-sm outline-none focus:ring-2 focus:ring-primary-green/20 focus:border-primary-green transition-all" placeholder="Pencarian cepat...">
            </div>
            
            <div class="flex items-center space-x-6">
                <a href="{{ url('/notifications') }}" class="relative text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                </a>
                <div class="h-8 w-px bg-gray-200"></div>
                <a href="{{ url('/profile') }}" class="flex items-center space-x-3 hover:bg-gray-50 p-2 rounded-xl transition-colors">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-800 leading-none">Dr. Andi Prakoso</p>
                        <p class="text-xs text-gray-500 mt-1">Kepala Bedah Umum</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-primary-green flex items-center justify-center text-white font-bold shadow-sm">AP</div>
                </a>
            </div>
        </div>

        <div class="p-8">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard Utama</h2>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Ringkasan aktivitas hari ini, {{ date('d F Y') }}</p>
                    @isset($userRole)
                        <p class="text-xs mt-2 text-gray-500">Role: <span class="font-bold text-sm text-amber-600">{{ ucfirst($userRole) }}</span>
                        @if(!empty($isPJAdmin)) <span class="ml-3 inline-block px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs font-bold">PJ Admin</span> @endif
                        @if(!empty($isDPJP)) <span class="ml-2 inline-block px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-xs font-bold">DPJP</span> @endif
                        </p>
                    @endisset
                </div>
                @if(!empty($isPJAdmin) || !empty($isDPJP))
                <a href="{{ url('/jadwal-operasi') }}" class="bg-primary-green hover:bg-primary-green-hover text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-primary-green/20 transition-all active:scale-95 flex items-center inline-block">
                    <i class="fa-solid fa-plus mr-2"></i> Jadwal Baru
                </a>
                @else
                <a href="{{ url('/jadwal-operasi') }}" class="bg-gray-200 text-gray-600 px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center inline-block cursor-not-allowed" title="Hanya untuk PJ Admin / DPJP">
                    <i class="fa-solid fa-plus mr-2"></i> Jadwal Baru
                </a>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Ruang Operasi</p>
                            <h3 class="text-3xl font-black text-gray-800">{{ $totalRooms ?? 5 }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-solid fa-door-open"></i>
                        </div>
                    </div>
                    <div class="flex items-center text-xs font-bold">
                        <span class="text-green-500">{{ $usedRooms ?? 2 }} Terpakai</span>
                        <span class="mx-2 text-gray-200">•</span>
                        <span class="text-gray-400">{{ ($totalRooms ?? 5) - ($usedRooms ?? 2) }} Kosong</span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Ketersediaan Bed</p>
                            <h3 class="text-3xl font-black text-gray-800">{{ $availableBeds ?? 45 }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-solid fa-bed-pulse"></i>
                        </div>
                    </div>
                    <div class="text-xs font-bold text-emerald-600">
                        <i class="fa-solid fa-arrow-up mr-1"></i> {{ $occupiedBeds ?? 100 }} bed terisi
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Stok Obat (Kritis)</p>
                            <h3 class="text-3xl font-black text-gray-800">{{ $criticalStock ?? 3 }} <span class="text-sm font-medium text-gray-400 uppercase tracking-widest ml-1">item</span></h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-500 flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-solid fa-capsules"></i>
                        </div>
                    </div>
                    <a href="{{ url('/farmasi') }}" class="text-xs font-bold text-red-500 hover:underline transition-all">Lihat detail stok</a>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Operasi Hari Ini</p>
                            <h3 class="text-3xl font-black text-gray-800">{{ $operasiHariIni ?? 0 }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-solid fa-notes-medical"></i>
                        </div>
                    </div>
                    <a href="{{ url('/jadwal-operasi') }}" class="text-xs font-bold text-amber-600 hover:underline">Lihat jadwal</a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-red-50 border-l-4 border-red-500 p-5 rounded-r-2xl flex items-start gap-4 shadow-sm animate-pulse">
                        <i class="fa-solid fa-triangle-exclamation text-red-500 text-lg mt-0.5"></i>
                        <div>
                            <h4 class="text-sm font-bold text-red-800">Peringatan Bentrok Jadwal!</h4>
                            <p class="text-xs text-red-700 mt-1 leading-relaxed">Sistem mendeteksi <b>Dr. Budi</b> sudah memiliki jadwal di Ruang Operasi A pada 10:00 - 12:00.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                        <div class="flex justify-between items-center mb-8">
                            <h3 class="text-lg font-bold text-gray-800">Statistik Tindakan & Kunjungan</h3>
                            <div class="flex items-center space-x-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                                <span class="flex items-center"><span class="w-3 h-3 rounded-full bg-emerald-500 mr-2"></span> Operasi</span>
                                <span class="flex items-center"><span class="w-3 h-3 rounded-full bg-blue-500 mr-2"></span> Rawat Inap</span>
                            </div>
                        </div>
                        <div class="h-72 w-full">
                            <canvas id="mainChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-50 bg-gray-50/30 flex justify-between items-center">
                            <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest">Noticeboard</h3>
                            <button class="text-[10px] font-bold text-primary-green hover:underline">LIHAT SEMUA</button>
                        </div>
                        <div class="divide-y divide-gray-50">
                            <div class="p-6 hover:bg-gray-50 transition-colors cursor-pointer group">
                                <span class="inline-block px-2 py-1 bg-red-100 text-red-600 text-[10px] font-black rounded uppercase mb-3">Darurat</span>
                                <h4 class="text-sm font-bold text-gray-800 group-hover:text-primary-green transition-colors">Rapat Koordinasi KA Bedah</h4>
                                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Seluruh kepala departemen harap berkumpul di Ruang Utama lantai 2 pukul 14.00.</p>
                            </div>
                            <div class="p-6 hover:bg-gray-50 transition-colors cursor-pointer group">
                                <span class="inline-block px-2 py-1 bg-emerald-100 text-emerald-600 text-[10px] font-black rounded uppercase mb-3">Umum</span>
                                <h4 class="text-sm font-bold text-gray-800 group-hover:text-primary-green transition-colors">Audit Inventaris Obat</h4>
                                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Tim farmasi akan melakukan audit stok bius pagi esok.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
                        <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest mb-6">Logistik Cepat</h3>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between text-xs font-bold mb-2">
                                    <span class="text-gray-500">Total Bius Tersedia</span>
                                    <span class="text-gray-800">78 Ampul</span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="bg-blue-500 h-full w-[75%] rounded-full shadow-sm"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-bold mb-2">
                                    <span class="text-gray-500">Cairan Infus HCL</span>
                                    <span class="text-gray-800">120 Kantong</span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="bg-emerald-500 h-full w-[85%] rounded-full shadow-sm"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-bold mb-2 text-red-500">
                                    <span>Alat Bedah (Steril)</span>
                                    <span>12 Set (Menipis)</span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="bg-red-500 h-full w-[30%] rounded-full shadow-sm"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <footer class="mt-12 text-center">
                <p class="text-xs font-bold text-gray-300 uppercase tracking-[0.2em]">&copy; 2026 SIMRS RSUD KOTA MALANG. ALL RIGHTS RESERVED.</p>
            </footer>
        </div>
    </main>

    <script>
        (function(){
            const canvas = document.getElementById('mainChart');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            const mainChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [
                    {
                        label: 'Operasi (Bedah)',
                        data: [4, 6, 3, 5, 2, 7, 1],
                        borderColor: '#10b981',
                        backgroundColor: (context) => {
                            const chart = context.chart;
                            const {ctx, chartArea} = chart;
                            if (!chartArea) return 'rgba(16,185,129,0.08)';
                            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                            gradient.addColorStop(0, 'rgba(16, 185, 129, 0)');
                            gradient.addColorStop(1, 'rgba(16, 185, 129, 0.2)');
                            return gradient;
                        },
                        borderWidth: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Rawat Inap Baru',
                        data: [12, 19, 15, 17, 14, 22, 10],
                        borderColor: '#3b82f6',
                        borderWidth: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        tension: 0.4,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#f3f4f6' },
                        ticks: { font: { size: 10, weight: 'bold' }, color: '#9ca3af' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10, weight: 'bold' }, color: '#9ca3af' }
                    }
                }
            }
            });
        })();
    </script>
</body>
</html>