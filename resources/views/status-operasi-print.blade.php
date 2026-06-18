@extends('layouts.app')

@section('title', 'Cetak Status Operasi')

@section('content')
    <div class="page-content">
        <div class="bg-white rounded-xl shadow-sm p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Laporan Operasi</h1>
                    <p class="text-sm text-slate-500">Cetak ringkasan operasi untuk dokumentasi.</p>
                </div>
                <button onclick="window.print()" class="btn-primary">Cetak Sekarang</button>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 mb-6">
                <div class="rounded-3xl border border-slate-200 p-6">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Pasien</p>
                    <h2 class="mt-2 text-xl font-bold text-slate-900">{{ $operasi->nama_pasien ?? 'N/A' }}</h2>
                    <p class="mt-1 text-sm text-slate-600">RM: {{ $operasi->nomor_rm ?? 'N/A' }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 p-6">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Operasi</p>
                    <h2 class="mt-2 text-xl font-bold text-slate-900">{{ $operasi->jenis_tindakan ?? 'N/A' }}</h2>
                    <p class="mt-1 text-sm text-slate-600">Ruang: {{ $operasi->nama_ruang ?? 'N/A' }}</p>
                    <p class="mt-1 text-sm text-slate-600">Dokter: {{ $operasi->dokter_bedah ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-3 mb-6">
                <div class="rounded-3xl border border-slate-200 p-6">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Tanggal</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">{{ \Carbon\Carbon::parse($operasi->tanggal_operasi)->format('d M Y') }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 p-6">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Jam Mulai</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">{{ \Carbon\Carbon::parse($operasi->jam_mulai)->format('H:i') }} WIB</p>
                </div>
                <div class="rounded-3xl border border-slate-200 p-6">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Status</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">{{ $operasi->status ?? 'Terjadwal' }}</p>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 p-6 mb-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Ringkasan Operasi</h2>
                <p class="text-sm text-slate-600">Dokumentasi ini dapat digunakan sebagai formulir pencatatan operasi dan dilengkapi detail pasien, dokter, serta jadwal.</p>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Dokter Anestesi</p>
                        <p class="mt-2 text-sm text-slate-900">{{ $operasi->dokter_anestesi ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Ruang Operasi</p>
                        <p class="mt-2 text-sm text-slate-900">{{ $operasi->nama_ruang ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Catatan Tambahan</h2>
                <p class="text-sm text-slate-600">- Pastikan semua persiapan peralatan dan obat sudah terkonfirmasi.</p>
                <p class="text-sm text-slate-600">- Verifikasi identitas pasien sebelum memasuki ruang operasi.</p>
                <p class="text-sm text-slate-600">- Catat semua perubahan status operasi jika diperlukan.</p>
            </div>
        </div>
    </div>
@endsection
