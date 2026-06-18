@extends('layouts.app')

@section('title', 'Foto Prosedur Operasi')

@section('content')
    <div class="page-content">
        <div class="bg-white rounded-xl shadow-sm p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900">Foto Prosedur Operasi</h1>
                <p class="text-sm text-slate-500">Halaman tampilan foto dan dokumentasi operasi.</p>
            </div>
            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 p-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-4">Detail Operasi</h2>
                    <p class="text-sm text-slate-600"><strong>Pasien:</strong> {{ $operasi->nama_pasien ?? 'N/A' }}</p>
                    <p class="text-sm text-slate-600 mt-2"><strong>Jenis Operasi:</strong> {{ $operasi->jenis_tindakan ?? 'N/A' }}</p>
                    <p class="text-sm text-slate-600 mt-2"><strong>Dokter Bedah:</strong> {{ $operasi->dokter_bedah ?? 'N/A' }}</p>
                    <p class="text-sm text-slate-600 mt-2"><strong>Ruang Operasi:</strong> {{ $operasi->nama_ruang ?? 'N/A' }}</p>
                    <p class="text-sm text-slate-600 mt-2"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($operasi->tanggal_operasi)->format('d M Y') }}</p>
                    <p class="text-sm text-slate-600 mt-2"><strong>Jam Mulai:</strong> {{ \Carbon\Carbon::parse($operasi->jam_mulai)->format('H:i') }} WIB</p>
                </div>
                <div class="rounded-3xl border border-slate-200 p-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-4">Galeri Prosedur</h2>
                    <div class="space-y-4">
                        <div class="aspect-[4/3] overflow-hidden rounded-3xl bg-slate-100 flex items-center justify-center text-slate-400">
                            <span>Foto Operasi Terpasang</span>
                        </div>
                        <div class="aspect-[4/3] overflow-hidden rounded-3xl bg-slate-100 flex items-center justify-center text-slate-400">
                            <span>Dokumentasi Tindakan</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8 rounded-3xl border border-slate-200 p-6 bg-slate-50">
                <p class="text-sm text-slate-600">Halaman ini dapat digunakan sebagai placeholder untuk menampilkan foto operasi, dokumentasi medis, atau bukti proses bedah.</p>
                <p class="text-sm text-slate-600 mt-3">Gunakan fitur unggah foto jika ingin menambahkan dokumentasi visual operasi.</p>
            </div>
        </div>
    </div>
@endsection
