@extends('layouts.app')

@section('title','Pembayaran')

@push('styles')
<style>
    .badge-lunas { display:inline-flex; align-items:center; justify-content:center; border-radius:9999px; background:#d1fae5; color:#047857; padding:0.55rem 0.9rem; font-size:0.7rem; font-weight:700; }
    .badge-menunggu { display:inline-flex; align-items:center; justify-content:center; border-radius:9999px; background:#fef3c7; color:#92400e; padding:0.55rem 0.9rem; font-size:0.7rem; font-weight:700; }
    .badge-belum { display:inline-flex; align-items:center; justify-content:center; border-radius:9999px; background:#fee2e2; color:#b91c1c; padding:0.55rem 0.9rem; font-size:0.7rem; font-weight:700; }
</style>
@endpush

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Ringkasan Keuangan</p>
            <h1 class="text-4xl font-bold text-slate-900">Dashboard Pembayaran</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Pantau status tagihan dan pendapatan operasi secara realtime.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 shadow-sm">
                <p class="text-xs uppercase tracking-[0.2em] text-emerald-700 font-semibold">Dikelola Kepala OK</p>
                <p class="mt-1 text-sm font-semibold text-emerald-900">Siap Monitor</p>
            </div>
            <button class="btn-primary">Tambah Pembayaran</button>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-4">
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Total Operasi</p>
            <p class="mt-4 text-4xl font-black text-slate-900">{{ $stats['total_operasi'] ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">bulan ini</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Pendapatan</p>
            <p class="mt-4 text-4xl font-black text-emerald-700">Rp {{ number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.') }}</p>
            <p class="mt-3 text-sm text-slate-500">total bulan ini</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Menunggu</p>
            <p class="mt-4 text-4xl font-black text-amber-700">{{ $stats['waiting'] ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">operasi pembayaran</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Dibayar</p>
            <p class="mt-4 text-4xl font-black text-emerald-700">{{ $stats['paid'] ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">operasi</p>
        </div>
    </div>

    <div class="rounded-[1.5rem] border border-sky-100 bg-sky-50 p-6 shadow-sm text-slate-700">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-sky-700 font-semibold">Integrasi Otomatis</p>
                <p class="mt-2 text-sm">Data pembayaran diisi dan dikelola langsung oleh Kepala OK.</p>
            </div>
            <div class="text-sm font-semibold text-sky-900">TPP & Ruang Operasi terhubung</div>
        </div>
    </div>

    <div class="bg-white rounded-[1.5rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-900">Daftar Pembayaran Operasi</h2>
            <p class="text-sm text-slate-500 mt-1">Data terintegrasi dari TPP dan Ruang Operasi.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-sm text-slate-700">
                <thead class="bg-slate-50 text-left text-xs uppercase tracking-[0.24em] text-slate-500">
                    <tr>
                        <th class="px-6 py-3">Rekam Medis</th>
                        <th class="px-6 py-3">Nama Pasien</th>
                        <th class="px-6 py-3">Jenis Operasi</th>
                        <th class="px-6 py-3">Klasifikasi</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3 text-right">Tarif (Rp)</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($records as $record)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $record->rekam_medis }}</td>
                            <td class="px-6 py-4 text-slate-700">{{ $record->nama_pasien }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $record->jenis_operasi }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $record->klasifikasi }}</td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ date('d M Y', strtotime($record->tanggal_operasi)) }}</td>
                            <td class="px-6 py-4 text-right font-semibold text-slate-900">{{ number_format($record->tarif, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($record->status == 'Lunas')
                                    <span class="badge-lunas">Lunas</span>
                                @elseif($record->status == 'Menunggu')
                                    <span class="badge-menunggu">Menunggu</span>
                                @else
                                    <span class="badge-belum">Belum Bayar</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center text-slate-400">
                                <i class="fas fa-inbox text-3xl"></i>
                                <p class="mt-3 text-sm">Tidak ada data pembayaran.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-[1.5rem] border border-emerald-100 bg-emerald-50 p-6 shadow-sm text-sm text-emerald-700">
        <p class="font-semibold">Integrasi Otomatis</p>
        <p class="mt-2">Semua data pembayaran terintegrasi otomatis dari Modul TPP dan Ruang Operasi.</p>
    </div>
</div>
@endsection
