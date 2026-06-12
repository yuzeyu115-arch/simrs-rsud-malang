<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - RSUD Kota Malang</title>
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
                        'primary-blue': '#2563eb',
                        'primary-rose': '#f43f5e'
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f6f8f9; }
        .sidebar-active { background-color: #ecfdf5; color: #047857; font-weight: 700; }
    </style>
</head>
<body class="min-h-screen bg-[#f6f8f9]">
    <div class="min-h-screen">
        <div class="flex">
            <aside class="w-72 bg-white border-r border-slate-200 min-h-screen px-6 py-8 shadow-sm">
                <div class="mb-10 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-primary-green text-white flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-hospital text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm uppercase tracking-[0.25em] text-slate-400">RS Sahabat Sehat</p>
                        <p class="text-xs text-slate-500">Pelayanan Ramah, Kesehatan Optimal</p>
                    </div>
                </div>

                <nav class="space-y-3">
                    <div class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">Utama</div>
                    <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-sm font-semibold bg-primary-green/10 text-primary-green shadow-sm shadow-primary-green/10">
                        <i class="fa-solid fa-gauge-high w-5 text-base"></i>
                        Dashboard KPI
                    </a>
                    <a href="{{ url('/jadwal-operasi') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-100 transition">
                        <i class="fa-solid fa-calendar-check w-5 text-base"></i>
                        Jadwal Operasi
                    </a>
                    <a href="{{ url('/bed-manager-list') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-100 transition">
                        <i class="fa-solid fa-bed w-5 text-base"></i>
                        Bed Manager
                    </a>
                    <a href="{{ url('/farmasi') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-100 transition">
                        <i class="fa-solid fa-pills w-5 text-base"></i>
                        Unit Farmasi
                    </a>
                    <a href="{{ route('logistik-ringkasan') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-100 transition">
                        <i class="fa-solid fa-credit-card w-5 text-base"></i>
                        Pembayaran
                    </a>
                </nav>

                <div class="mt-auto pt-8 border-t border-slate-200">
                    <a href="{{ url('/logout') }}" class="flex items-center gap-3 text-red-600 font-semibold hover:text-red-700 transition">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Keluar
                    </a>
                </div>
            </aside>

            <div class="flex-1">
                <header class="sticky top-0 z-20 bg-white/90 backdrop-blur-md border-b border-slate-200 px-8 py-5 shadow-sm">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="relative max-w-xl w-full">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="search" class="w-full rounded-3xl border border-slate-200 bg-slate-50 py-3 pl-12 pr-4 text-sm text-slate-800 outline-none focus:border-primary-green focus:ring-2 focus:ring-primary-green/20" placeholder="Pencarian cepat...">
                        </div>
                        <div class="flex items-center gap-4">
                            <button class="relative rounded-3xl bg-slate-100 p-3 text-slate-600 hover:text-slate-900 transition">
                                <i class="fa-regular fa-bell text-lg"></i>
                                <span class="absolute -top-1 -right-1 inline-flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] text-white font-bold">5</span>
                            </button>
                            <div class="flex items-center gap-3 rounded-3xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                                <div class="w-12 h-12 rounded-full bg-primary-green text-white grid place-items-center text-base font-bold">DA</div>
                                <div class="text-right">
                                    <p class="font-semibold text-slate-800">Dr. Devia Amanda</p>
                                    <p class="text-xs text-slate-500">Kepala Bedah Umum</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="px-8 py-8 space-y-8">
                    <div class="flex flex-col lg:flex-row lg:justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-extrabold text-slate-900">Dashboard Utama</h1>
                            <p class="mt-3 text-sm text-slate-500">Ringkasan aktivitas rumah sakit hari ini.</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ url('/jadwal-operasi') }}" class="inline-flex items-center gap-2 rounded-3xl bg-primary-green px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-green/20 hover:bg-primary-green-hover transition">
                                <i class="fa-solid fa-calendar-plus"></i>
                                Jadwal Baru
                            </a>
                            <button class="inline-flex items-center gap-2 rounded-3xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                                <i class="fa-solid fa-gear"></i>
                                Status Operasi
                            </button>
                        </div>
                    </div>

                    <section class="grid grid-cols-1 xl:grid-cols-4 gap-6">
                        <article class="rounded-[32px] bg-white p-6 shadow-sm border border-slate-200">
                            <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Total Ruang Operasi</p>
                            <h2 class="mt-5 text-4xl font-black text-slate-900">{{ $totalRooms ?? 5 }}</h2>
                            <p class="mt-4 text-sm text-slate-500">{{ $usedRooms ?? 2 }} terpakai · {{ ($totalRooms ?? 5) - ($usedRooms ?? 2) }} kosong</p>
                        </article>
                        <article class="rounded-[32px] bg-white p-6 shadow-sm border border-slate-200">
                            <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Ketersediaan Bed</p>
                            <h2 class="mt-5 text-4xl font-black text-slate-900">{{ $availableBeds ?? 50 }}</h2>
                            <p class="mt-4 text-sm text-slate-500">{{ $occupiedBeds ?? 15 }} terisi</p>
                        </article>
                        <article class="rounded-[32px] bg-white p-6 shadow-sm border border-slate-200">
                            <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Operasi Hari Ini</p>
                            <h2 class="mt-5 text-4xl font-black text-slate-900">{{ $operasiHariIni ?? 1 }}</h2>
                            <p class="mt-4 text-sm text-slate-500">{{ $dibatalkan ?? 0 }} dibatalkan · {{ $selesai ?? 0 }} selesai</p>
                        </article>
                        <article class="rounded-[32px] bg-white p-6 shadow-sm border border-slate-200">
                            <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Status Operasi</p>
                            <div class="mt-5 space-y-4">
                                <div class="rounded-3xl bg-emerald-50 p-4">
                                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-700">Sedang Berlangsung</p>
                                    <p class="mt-3 text-2xl font-black text-slate-900">Operasi Berlangsung</p>
                                </div>
                                <div class="grid grid-cols-3 gap-3 text-center">
                                    <div class="rounded-3xl bg-slate-50 p-3">
                                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Ruang A</p>
                                        <p class="mt-2 text-lg font-bold text-slate-900">1</p>
                                    </div>
                                    <div class="rounded-3xl bg-slate-50 p-3">
                                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Ruang B</p>
                                        <p class="mt-2 text-lg font-bold text-slate-900">0</p>
                                    </div>
                                    <div class="rounded-3xl bg-slate-50 p-3">
                                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Ruang C</p>
                                        <p class="mt-2 text-lg font-bold text-slate-900">2</p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </section>

                    <section class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                        <article class="xl:col-span-2 rounded-[32px] bg-white border border-slate-200 p-6 shadow-sm">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                                <div>
                                    <p class="text-sm font-black uppercase tracking-[0.16em] text-slate-400">Statistik Tindakan & Kunjungan</p>
                                    <p class="text-xs text-slate-400 mt-2">Tren operasi dan pasien rawat inap selama 7 hari terakhir.</p>
                                </div>
                                <a href="{{ route('statistik-kunjungan') }}" class="rounded-2xl bg-primary-green px-4 py-2 text-sm font-semibold text-white hover:bg-primary-green-hover transition">Laporan Dokter</a>
                            </div>
                            <div class="h-80">
                                <canvas id="dashboardChart" class="h-full w-full"></canvas>
                            </div>
                        </article>

                        <div class="space-y-6">
                            <article class="rounded-[32px] bg-white border border-slate-200 p-6 shadow-sm">
                                <div class="flex items-center justify-between mb-5">
                                    <div>
                                        <p class="text-sm font-black uppercase tracking-[0.16em] text-slate-400">Ringkasan Cepat</p>
                                        <p class="text-xs text-slate-500 mt-1">Persediaan utama dalam satu tampilan.</p>
                                    </div>
                                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-700 bg-emerald-100 rounded-full px-3 py-1">Live Update</span>
                                </div>
                                <div class="space-y-4">
                                    <div class="rounded-3xl bg-slate-50 p-4">
                                        <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Total Bed Tersedia</p>
                                        <div class="mt-3 flex items-center justify-between gap-4 text-slate-900">
                                            <span class="text-2xl font-black">{{ $availableBeds ?? 50 }}</span>
                                            <span class="text-sm text-emerald-600">78 Ampul</span>
                                        </div>
                                    </div>
                                    <div class="rounded-3xl bg-slate-50 p-4">
                                        <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Cairan Infus HCL</p>
                                        <div class="mt-3 flex items-center justify-between gap-4 text-slate-900">
                                            <span class="text-2xl font-black">120</span>
                                            <span class="text-sm text-slate-500">Kantong</span>
                                        </div>
                                    </div>
                                    <div class="rounded-3xl bg-slate-50 p-4">
                                        <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Alat Bedah</p>
                                        <div class="mt-3 flex items-center justify-between gap-4 text-slate-900">
                                            <span class="text-2xl font-black">12</span>
                                            <span class="text-sm text-rose-600">1 Habis</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <article class="rounded-[32px] bg-white border border-slate-200 p-6 shadow-sm">
                                <div class="flex items-center justify-between mb-5">
                                    <p class="text-sm font-black uppercase tracking-[0.16em] text-slate-400">Noticeboard</p>
                                    <button class="text-xs font-semibold text-primary-green hover:underline">Lihat semua</button>
                                </div>
                                <div class="space-y-4">
                                    <div class="rounded-[32px] bg-rose-50 border border-rose-100 p-4">
                                        <p class="text-[10px] uppercase tracking-[0.2em] font-black text-rose-700">Darurat</p>
                                        <h3 class="mt-3 font-semibold text-slate-900">Rapat Koordinasi KA Bedah</h3>
                                        <p class="text-xs text-slate-500 mt-2">Tim bedah diminta berkumpul pada jam 14.00 untuk koordinasi pasien.</p>
                                    </div>
                                    <div class="rounded-[32px] bg-emerald-50 border border-emerald-100 p-4">
                                        <p class="text-[10px] uppercase tracking-[0.2em] font-black text-emerald-700">Umum</p>
                                        <h3 class="mt-3 font-semibold text-slate-900">Audit Inventaris Obat</h3>
                                        <p class="text-xs text-slate-500 mt-2">Tim logistik akan melakukan pengecekan stok hari ini.</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('dashboardChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    datasets: [
                        {
                            label: 'Operasi',
                            data: [12, 18, 14, 22, 17, 15, 20],
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.15)',
                            fill: true,
                            tension: 0.35,
                            pointRadius: 3,
                            pointBackgroundColor: '#10b981'
                        },
                        {
                            label: 'Rawat Inap',
                            data: [20, 16, 18, 14, 21, 24, 22],
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.12)',
                            fill: true,
                            tension: 0.35,
                            pointRadius: 3,
                            pointBackgroundColor: '#2563eb'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#111827',
                            titleColor: '#fff',
                            bodyColor: '#fff'
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#6b7280' }
                        },
                        y: {
                            grid: { color: 'rgba(148, 163, 184, 0.15)' },
                            ticks: { color: '#6b7280' }
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>
