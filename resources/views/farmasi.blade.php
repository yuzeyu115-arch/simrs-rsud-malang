@extends('layouts.app')

@section('title','Unit Farmasi')

@push('styles')
<style>
    .badge-waiting { display: inline-flex; align-items: center; justify-content: center; border-radius: 9999px; background: #fef3c7; color: #92400e; padding: 0.55rem 0.9rem; font-size: 0.7rem; font-weight: 700; }
    .badge-ready { display: inline-flex; align-items: center; justify-content: center; border-radius: 9999px; background: #dcfce7; color: #166534; padding: 0.55rem 0.9rem; font-size: 0.7rem; font-weight: 700; }
    .badge-picked { display: inline-flex; align-items: center; justify-content: center; border-radius: 9999px; background: #dbeafe; color: #1d4ed8; padding: 0.55rem 0.9rem; font-size: 0.7rem; font-weight: 700; }
</style>
@endpush

@section('content')
<div class="space-y-8">
    <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-end">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Unit Farmasi</p>
            <h1 class="text-4xl font-bold text-slate-900">Ringkasan Farmasi</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Pantau paket obat operasi, status pengiriman, dan pengambilan secara cepat.</p>
        </div>
        <div class="flex flex-col gap-3 items-end">
            <div class="rounded-3xl border border-emerald-100 bg-emerald-50 px-5 py-4 shadow-sm text-right">
                <p class="text-xs uppercase tracking-[0.2em] text-emerald-700">Status Sistem</p>
                <p class="mt-2 text-sm font-semibold text-emerald-900">Siap Melayani</p>
            </div>
            <a href="{{ route('farmasi.input') }}" class="btn-primary">Tambah Pesanan</a>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-4">
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Total Paket</p>
            <p class="mt-4 text-4xl font-black text-slate-900">{{ $summary['total_paket'] ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">paket obat dipesan</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Menunggu</p>
            <p class="mt-4 text-4xl font-black text-amber-700">{{ $summary['waiting'] ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">disiapkan di farmasi</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Siap Diambil</p>
            <p class="mt-4 text-4xl font-black text-emerald-700">{{ $summary['ready'] ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">siap untuk OR</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Sudah Diambil</p>
            <p class="mt-4 text-4xl font-black text-sky-700">{{ $summary['picked'] ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">sudah digunakan</p>
        </div>
    </div>

    <div class="bg-white rounded-[1.5rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-900">Daftar Pesanan Paket Obat</h2>
            <p class="text-sm text-slate-500 mt-1">Pesanan dari perawat anestesi yang sedang diproses.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-sm text-slate-700">
                <thead class="bg-slate-50 text-left text-xs uppercase tracking-[0.24em] text-slate-500">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Paket</th>
                        <th class="px-6 py-3">Item</th>
                        <th class="px-6 py-3">Pemesan</th>
                        <th class="px-6 py-3">Waktu</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($orders as $index => $order)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-semibold">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $order->order_id }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $order->nama_paket }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $order->jumlah_item }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $order->dipesan_oleh }}</td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ $order->waktu_pesan }}</td>
                            <td class="px-6 py-4">
                                @if($order->status == 'Menunggu Disiapkan')
                                    <span class="badge-waiting">Menunggu</span>
                                @elseif($order->status == 'Siap Diambil')
                                    <span class="badge-ready">Siap</span>
                                @else
                                    <span class="badge-picked">Diambil</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <button class="rounded-2xl border border-emerald-200 bg-white px-4 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-50 transition">Detail</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center text-slate-400">
                                <i class="fas fa-inbox text-3xl"></i>
                                <p class="mt-3 text-sm">Belum ada pesanan paket obat.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('farmasi.pesanan') }}" class="btn-primary">Lihat Semua Pesanan</a>
    </div>
</div>
@endsection
