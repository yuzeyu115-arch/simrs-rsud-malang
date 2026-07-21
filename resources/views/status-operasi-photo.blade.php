@extends('layouts.app')

@section('title','Foto Prosedur Operasi')

@section('content')
<div class="space-y-8">
    <div class="page-band">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Galeri Prosedur</p>
                <h1 class="text-4xl font-bold text-slate-900">Dokumentasi Tindakan</h1>
                <p class="mt-2 text-sm text-slate-600 max-w-2xl">Tampilan foto dokumentasi operasi untuk bukti prosedur dan review tim medis.</p>
            </div>
            <a href="{{ route('status-operasi') }}" class="btn-secondary">Kembali ke Status Operasi</a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-3xl overflow-hidden border border-slate-200 bg-white shadow-sm">
            <img src="https://via.placeholder.com/720x480?text=Prosedur+Sterilisasi" alt="Prosedur Sterilisasi" class="h-64 w-full object-cover">
            <div class="p-5">
                <h2 class="font-semibold text-slate-900">Sterilisasi Alat</h2>
                <p class="mt-2 text-sm text-slate-600">Proses sterilisasi instrumen sebelum tindakan operasi dimulai.</p>
            </div>
        </div>
        <div class="rounded-3xl overflow-hidden border border-slate-200 bg-white shadow-sm">
            <img src="https://via.placeholder.com/720x480?text=Prosedur+Persiapan+Pasien" alt="Persiapan Pasien" class="h-64 w-full object-cover">
            <div class="p-5">
                <h2 class="font-semibold text-slate-900">Persiapan Pasien</h2>
                <p class="mt-2 text-sm text-slate-600">Pasien dipersiapkan untuk masuk ruang operasi dengan pemeriksaan akhir.</p>
            </div>
        </div>
        <div class="rounded-3xl overflow-hidden border border-slate-200 bg-white shadow-sm">
            <img src="https://via.placeholder.com/720x480?text=Dokumentasi+Tim+Bedah" alt="Dokumentasi Tim Bedah" class="h-64 w-full object-cover">
            <div class="p-5">
                <h2 class="font-semibold text-slate-900">Tim Bedah</h2>
                <p class="mt-2 text-sm text-slate-600">Dokumentasi tim medis saat melakukan tindakan di ruang operasi.</p>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900 mb-4">Detail Operasi</h2>
            <p class="text-sm text-slate-600"><strong>Pasien:</strong> {{ $operasi->nama_pasien ?? 'N/A' }}</p>
            <p class="text-sm text-slate-600 mt-2"><strong>Jenis Operasi:</strong> {{ $operasi->jenis_tindakan ?? 'N/A' }}</p>
            <p class="text-sm text-slate-600 mt-2"><strong>Dokter Bedah:</strong> {{ $operasi->dokter_bedah ?? 'N/A' }}</p>
            <p class="text-sm text-slate-600 mt-2"><strong>Ruang Operasi:</strong> {{ $operasi->nama_ruang ?? 'N/A' }}</p>
            <p class="text-sm text-slate-600 mt-2"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($operasi->tanggal_operasi)->format('d M Y') }}</p>
            <p class="text-sm text-slate-600 mt-2"><strong>Jam Mulai:</strong> {{ \Carbon\Carbon::parse($operasi->jam_mulai)->format('H:i') }} WIB</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-emerald-50 p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900 mb-4">Dokumentasi</h2>
            <p class="text-sm text-slate-600">Foto-foto ini dapat digunakan sebagai bukti visual dari prosedur operasi dan kondisi ruangan saat tindakan berlangsung.</p>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
                <li>• Persiapan dan sterilisasi</li>
                <li>• Penempatan pasien dan tim medis</li>
                <li>• Dokumentasi jalannya tindakan</li>
            </ul>
        </div>
    </div>
</div>
@endsection
