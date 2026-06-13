@extends('layouts.app')

@section('title','Notifikasi')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Notifikasi</p>
            <h1 class="text-4xl font-bold text-slate-900">Statistik dan Kunjungan</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Kelola notifikasi jadwal operasi dan paket obat dalam tampilan yang lebih terstruktur.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ url('/dashboard') }}" class="btn-secondary">Kembali ke Dashboard</a>
            <button class="btn-primary">Tambah Notifikasi</button>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-3">
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Total Notifikasi</p>
            <p class="mt-4 text-4xl font-black text-slate-900">{{ $notifications->count() ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">notifikasi aktif saat ini</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Operasi</p>
            <p class="mt-4 text-4xl font-black text-emerald-700">{{ $operationNotifications ?? 15 }}</p>
            <p class="mt-3 text-sm text-slate-500">notifikasi jadwal operasi</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Farmasi</p>
            <p class="mt-4 text-4xl font-black text-sky-700">{{ $pharmacyNotifications ?? 8 }}</p>
            <p class="mt-3 text-sm text-slate-500">notifikasi paket obat</p>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
        <div class="card-panel p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Pusat Notifikasi</h2>
                    <p class="text-sm text-slate-500 mt-1">Ringkasan notifikasi operasi dan paket obat.</p>
                </div>
                <span class="inline-flex rounded-full bg-slate-100 px-3 py-2 text-xs uppercase tracking-[0.18em] text-slate-500">Terbaru</span>
            </div>

            <div class="space-y-4">
                <div class="rounded-[1.75rem] border border-emerald-100 bg-emerald-50 p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs uppercase tracking-[0.22em] text-emerald-700 font-semibold">Jadwal Operasi</p>
                            <p class="mt-3 text-sm text-slate-700">Ruang Operasi A telah terisi 90%. Jadwal operasi berikutnya dalam 45 menit.</p>
                        </div>
                        <span class="inline-flex rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-700">Update</span>
                    </div>
                </div>
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="font-semibold text-slate-900">Perubahan Jadwal Operasi</p>
                    <p class="mt-2 text-sm text-slate-500">Jadwal pasien Anisa Putri dipindah ke Ruang Operasi C karena kebutuhan alat.</p>
                </div>
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="font-semibold text-slate-900">Catatan Dokter</p>
                    <p class="mt-2 text-sm text-slate-500">Pastikan dokumen persetujuan dan persiapan sebelum operasi sudah lengkap.</p>
                </div>
            </div>
        </div>
        <div class="card-panel p-6">
            <h2 class="text-xl font-bold text-slate-900 mb-4">Detail Notifikasi</h2>
            <div class="space-y-4">
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="font-semibold text-slate-900">Jadwal Operasi</p>
                    <p class="mt-2 text-sm text-slate-500">Operasi: Appendektomi • Dokter: Dr. Anissa Putri • Ruang Operasi A.</p>
                </div>
                <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5">
                    <p class="font-semibold text-slate-900">Paket Obat</p>
                    <p class="mt-2 text-sm text-slate-500">Paket anestesi sudah siap diproses dan menunggu diambil oleh tim OR.</p>
                </div>
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="font-semibold text-slate-900">Detail Jadwal</p>
                    <ul class="mt-3 space-y-2 text-sm text-slate-600">
                        <li><strong>Pasien:</strong> Anisa Putri</li>
                        <li><strong>Jenis Operasi:</strong> Bedah Umum</li>
                        <li><strong>Waktu:</strong> 08.00 - 10.00</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
