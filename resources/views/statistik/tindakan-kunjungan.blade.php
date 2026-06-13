@extends('layouts.app')

@section('title','Statistik Tindakan & Kunjungan')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm text-slate-500">Statistik</p>
            <h1 class="text-3xl font-bold text-slate-900">Tindakan & Kunjungan</h1>
        </div>
        <p class="rounded-2xl bg-slate-100 px-4 py-2 text-sm text-slate-600">Perbarui data terbaru dan pantau tren</p>
    </div>

    @if(session('success'))
        <div class="rounded-3xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-[1fr_1.6fr]">
        <section class="card-panel p-6">
            <div class="flex items-center justify-between gap-3 mb-4">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Input Statistik</p>
                    <h2 class="mt-2 text-xl font-semibold text-slate-900">Tambah Data Baru</h2>
                </div>
            </div>

            <form action="{{ route('statistik-kunjungan.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal *</label>
                    <input name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" type="date" class="input-base" />
                    @error('tanggal') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Kunjungan *</label>
                    <input name="jumlah_kunjungan" value="{{ old('jumlah_kunjungan', '0') }}" type="number" min="0" class="input-base" />
                    @error('jumlah_kunjungan') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Operasi *</label>
                    <input name="jumlah_operasi" value="{{ old('jumlah_operasi', '0') }}" type="number" min="0" class="input-base" />
                    @error('jumlah_operasi') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tindakan Terbanyak</label>
                    <input name="tindakan_terbanyak" value="{{ old('tindakan_terbanyak') }}" type="text" class="input-base" placeholder="Contoh: Appendektomi" />
                    @error('tindakan_terbanyak') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn-primary w-full">Simpan Data</button>
            </form>
        </section>

        <section class="space-y-6">
            <div class="card-panel p-6">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Grafik</p>
                        <h2 class="mt-2 text-xl font-semibold text-slate-900">Tren Kunjungan & Operasi</h2>
                    </div>
                </div>
                <canvas id="statisticChart" class="h-72 w-full"></canvas>
            </div>

            <div class="card-panel overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
                    <h2 class="text-xl font-semibold text-slate-900">Data Statistik</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase tracking-[0.15em] text-xs font-semibold">
                            <tr>
                                <th class="px-4 py-3 text-left">Tanggal</th>
                                <th class="px-4 py-3 text-left">Kunjungan</th>
                                <th class="px-4 py-3 text-left">Operasi</th>
                                <th class="px-4 py-3 text-left">Tindakan Terbanyak</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 text-slate-700">
                            @forelse($stats as $s)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3 font-semibold">{{ date('d/m/Y', strtotime($s->tanggal)) }}</td>
                                    <td class="px-4 py-3"><span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">{{ $s->jumlah_kunjungan }}</span></td>
                                    <td class="px-4 py-3"><span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">{{ $s->jumlah_operasi }}</span></td>
                                    <td class="px-4 py-3">{{ $s->tindakan_terbanyak ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-slate-500">Belum ada data statistik</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>

@push('scripts')
<script>
    const stats = @json($stats);
    const labels = stats.map(s => new Date(s.tanggal).toLocaleDateString('id-ID')).reverse();
    const kunjungan = stats.map(s => s.jumlah_kunjungan).reverse();
    const operasi = stats.map(s => s.jumlah_operasi).reverse();

    const ctx = document.getElementById('statisticChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Kunjungan',
                    data: kunjungan,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Operasi',
                    data: operasi,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush
@endsection
