@extends('layouts.app')

@section('title','Dashboard Utama')

@push('styles')
<style>
    .stat-card { border-radius: 1.75rem; background: #ffffff; border: 1px solid rgba(148, 163, 184, 0.14); box-shadow: 0 18px 36px rgba(15, 23, 42, 0.06); }
    .stat-card-label { text-transform: uppercase; letter-spacing: 0.18em; color: #64748b; font-size: 0.72rem; font-weight: 700; }
    .stat-card-value { font-size: 2.5rem; font-weight: 800; color: #0f172a; }
</style>
@endpush

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Dashboard</p>
            <h1 class="text-4xl font-bold text-slate-900">Operasi & Logistik Rumah Sakit</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Pantau ketersediaan ruang operasi, bed, dan status paket obat dalam satu tampilan.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ url('/jadwal-operasi') }}" class="btn-secondary">Jadwal Operasi</a>
            <a href="{{ url('/bed-manager') }}" class="btn-secondary">Bed Manager</a>
            <a href="{{ url('/farmasi') }}" class="btn-primary">Unit Farmasi</a>
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="card-stat p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Total Ruang Operasi</p>
                    <p class="mt-4 text-4xl font-black text-slate-900">{{ $totalRooms ?? 5 }}</p>
                    <p class="mt-3 text-sm text-slate-500">{{ $usedRooms ?? 2 }} terpakai</p>
                </div>
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-700">
                    <i class="fa-solid fa-door-open text-xl"></i>
                </div>
            </div>
        </div>
        <div class="card-stat p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Ketersediaan Bed</p>
                    <p class="mt-4 text-4xl font-black text-slate-900">{{ $availableBeds ?? 50 }}</p>
                    <p class="mt-3 text-sm text-slate-500">{{ $occupiedBeds ?? 15 }} terisi</p>
                </div>
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-sky-50 text-sky-700">
                    <i class="fa-solid fa-bed text-xl"></i>
                </div>
            </div>
        </div>
        <div class="card-stat p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Operasi Hari Ini</p>
                    <p class="mt-4 text-4xl font-black text-slate-900">{{ $operasiHariIni ?? 1 }}</p>
                    <p class="mt-3 text-sm text-slate-500">{{ $operasiHariIni ? 'Jadwal berlangsung' : 'Tidak ada operasi' }}</p>
                </div>
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-rose-50 text-rose-700">
                    <i class="fa-solid fa-heart-pulse text-xl"></i>
                </div>
            </div>
        </div>
        <div class="card-stat p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Stok Kritis</p>
                    <p class="mt-4 text-4xl font-black text-slate-900">{{ $criticalStock ?? 3 }}</p>
                    <p class="mt-3 text-sm text-slate-500">Perlu restock segera</p>
                </div>
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-orange-50 text-orange-700">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.7fr_1fr]">
        <div class="card-panel p-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Statistik Tindakan & Kunjungan</h2>
                    <p class="text-sm text-slate-500 mt-1">Grafik 7 hari terakhir.</p>
                </div>
                <span class="inline-flex rounded-full bg-slate-100 px-3 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Realtime</span>
            </div>
            <div class="h-96">
                <canvas id="dashboardChart"></canvas>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card-panel p-6">
                <div class="flex items-center justify-between gap-3 mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Status Operasi</h3>
                        <p class="text-sm text-slate-500">Ringkasan ruang operasi saat ini.</p>
                    </div>
                    <span class="text-xs uppercase tracking-[0.22em] text-slate-400">Aktif</span>
                </div>
                <div class="space-y-4">
                    @foreach([['Ruang Operasi A','Sedang Berlangsung','bg-rose-50 text-rose-700'], ['Ruang Operasi B','Siap digunakan','bg-emerald-50 text-emerald-700'], ['Ruang Operasi C','Pembersihan','bg-slate-100 text-slate-700']] as $status)
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $status[0] }}</p>
                                    <p class="text-sm text-slate-500">{{ $status[1] }}</p>
                                </div>
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $status[2] }}">{{ $status[1] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 flex justify-end">
                    <a href="{{ url('/jadwal-operasi') }}" class="btn-secondary">Lihat detail</a>
                </div>
            </div>
            <div class="card-panel p-6">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-slate-900">Ringkasan Logistik Cepat</h3>
                    <p class="text-sm text-slate-500">Data terbaru sejak 1 jam lalu.</p>
                </div>
                <div class="space-y-4">
                    <div class="rounded-3xl bg-emerald-50 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-emerald-700 font-semibold">Paket Obat</p>
                        <p class="mt-2 text-lg font-semibold text-emerald-900">{{ $fastLogistics->paket ?? '—' }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ $fastLogistics->keterangan ?? 'Tidak ada data terbaru.' }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-4">
                        <p class="text-sm font-semibold text-slate-900">Permintaan Terakhir</p>
                        <p class="mt-2 text-sm text-slate-500">{{ $fastLogistics->created_at ? $fastLogistics->created_at : 'Hari ini' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('dashboardChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [
                    {
                        label: 'Tindakan',
                        data: [12, 18, 14, 22, 20, 26, 24],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.16)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointBackgroundColor: '#10b981'
                    },
                    {
                        label: 'Kunjungan',
                        data: [20, 24, 22, 28, 30, 34, 38],
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14, 165, 233, 0.12)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointBackgroundColor: '#0ea5e9'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(148, 163, 184, 0.16)' },
                        ticks: { color: '#64748b' }
                    }
                },
                plugins: {
                    legend: { labels: { color: '#475569', boxWidth: 12 } }
                }
            }
        });
    }
</script>
@endpush
