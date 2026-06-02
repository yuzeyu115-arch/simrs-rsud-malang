@extends('layouts.app')

@section('title', 'Gizi - Desain Figma')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Prototype - Halaman Desain Figma</h1>
            <p class="mt-2 text-sm text-gray-500">Halaman demo yang mereplikasi layout dari file Figma (preview). Tidak mengubah data produksi.</p>
        </div>
        <a href="{{ route('gizi') }}" class="rounded-lg bg-white border px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Kembali ke Dashboard</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-3 mb-6">
        <div class="col-span-2 rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900">Overview</h2>
                <p class="text-sm text-gray-500 mt-1">Ringkasan ringkas mengikuti tampilan Figma: judul, kartu metrik, daftar, dan preview menu.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="rounded-xl bg-emerald-50 p-4">
                    <p class="text-xs text-gray-500">Pesanan Hari Ini</p>
                    <p class="mt-2 text-2xl font-black text-gray-900">{{ $stats['today_orders'] ?? 0 }}</p>
                </div>
                <div class="rounded-xl bg-blue-50 p-4">
                    <p class="text-xs text-gray-500">Laporan</p>
                    <p class="mt-2 text-2xl font-black text-gray-900">{{ $stats['today_reports'] ?? 0 }}</p>
                </div>
                <div class="rounded-xl bg-orange-50 p-4">
                    <p class="text-xs text-gray-500">Jadwal</p>
                    <p class="mt-2 text-2xl font-black text-gray-900">{{ $stats['today_schedules'] ?? 0 }}</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-gray-700">
                    <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Nama Pasien</th>
                            <th class="px-4 py-3">Ruang</th>
                            <th class="px-4 py-3">Shift</th>
                            <th class="px-4 py-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($latestOrders ?? collect() as $i => $o)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $i + 1 }}</td>
                                <td class="px-4 py-3">{{ $o->nama_pasien ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $o->ruang ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $o->shift ?? '-' }}</td>
                                <td class="px-4 py-3">{{ !empty($o->tanggal) ? date('d M Y', strtotime($o->tanggal)) : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">Tidak ada data contoh.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <aside class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Preview Desain</h3>
            <div class="mt-4 h-48 w-full rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">Preview image / assets dari Figma (placeholder)</div>
            <p class="mt-4 text-sm text-gray-500">Gunakan halaman ini sebagai referensi visual ketika menata CSS/komponen agar menyesuaikan Figma.</p>
        </aside>
    </div>
</div>
@endsection
