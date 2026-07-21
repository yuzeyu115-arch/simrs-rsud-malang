@extends('layouts.app')

@section('title','Laporan Operasi')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Laporan Operasi</p>
            <h1 class="mt-1 text-3xl font-bold text-slate-900">Detail Laporan Dokter</h1>
            <p class="mt-1.5 text-sm text-slate-600 max-w-2xl">Laporan lengkap hasil operasi dari dokter bedah dan dokter anestesi.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button onclick="window.print()" class="btn-secondary">
                <i class="fas fa-print mr-2"></i>Cetak Laporan
            </button>
            <a href="{{ route('jadwal-operasi') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    {{-- Main Report Card --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        {{-- Header Laporan --}}
        <div class="mb-8 pb-8 border-b border-slate-200 text-center">
            <h2 class="text-2xl font-bold text-slate-900">LAPORAN OPERASI</h2>
            <p class="mt-2 text-sm text-slate-600">Rumah Sakit Umum Daerah Malang</p>
            <p class="text-sm text-slate-600">Jalan Ahmad Yani No. 12, Malang 65123</p>
        </div>

        {{-- Informasi Pasien --}}
        <div class="mb-8">
            <h3 class="mb-4 text-lg font-bold text-slate-900">I. DATA PASIEN</h3>
            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Nama Pasien</p>
                    <p class="mt-2 text-base font-bold text-slate-900">{{ $operasi->nama_pasien ?? 'N/A' }}</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Nomor Rekam Medis</p>
                    <p class="mt-2 text-base font-bold text-slate-900">{{ $operasi->nomor_rm ?? 'N/A' }}</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Tanggal Operasi</p>
                    <p class="mt-2 text-base font-bold text-slate-900">{{ $operasi->tanggal_operasi ? \Carbon\Carbon::parse($operasi->tanggal_operasi)->format('d F Y') : 'N/A' }}</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Jam Operasi</p>
                    <p class="mt-2 text-base font-bold text-slate-900">{{ $operasi->jam_mulai ? \Carbon\Carbon::parse($operasi->jam_mulai)->format('H:i') : 'N/A' }} WIB</p>
                </div>
            </div>
        </div>

        {{-- Informasi Operasi --}}
        <div class="mb-8">
            <h3 class="mb-4 text-lg font-bold text-slate-900">II. DATA OPERASI</h3>
            <div class="space-y-4">
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Jenis Tindakan</p>
                    <p class="mt-2 text-base font-bold text-slate-900">{{ $operasi->jenis_tindakan ?? 'N/A' }}</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Ruang Operasi</p>
                    <p class="mt-2 text-base font-bold text-slate-900">{{ $operasi->nama_ruang ?? 'N/A' }}</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Status Operasi</p>
                    <p class="mt-2 text-base font-bold text-slate-900">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                            @if($operasi->status === 'Selesai')
                                bg-emerald-100 text-emerald-700
                            @elseif($operasi->status === 'Berjalan')
                                bg-sky-100 text-sky-700
                            @elseif($operasi->status === 'Dibatalkan')
                                bg-amber-100 text-amber-700
                            @else
                                bg-slate-100 text-slate-600
                            @endif
                        ">
                            {{ $operasi->status ?? 'Terjadwal' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Tim Medis --}}
        <div class="mb-8">
            <h3 class="mb-4 text-lg font-bold text-slate-900">III. TIM MEDIS</h3>
            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Dokter Bedah</p>
                    <p class="mt-2 text-base font-bold text-slate-900">{{ $operasi->dokter_bedah ?? 'N/A' }}</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Dokter Anestesi</p>
                    <p class="mt-2 text-base font-bold text-slate-900">{{ $operasi->dokter_anestesi ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        {{-- Catatan Operasi --}}
        <div class="mb-8">
            <h3 class="mb-4 text-lg font-bold text-slate-900">IV. CATATAN OPERASI</h3>
            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                <p class="text-sm text-slate-700 whitespace-pre-wrap">
                    Operasi {{ $operasi->jenis_tindakan ?? 'sesuai rencana' }} dilaksanakan pada tanggal {{ $operasi->tanggal_operasi ? \Carbon\Carbon::parse($operasi->tanggal_operasi)->format('d F Y') : 'N/A' }} dengan lancar.

Tim medis terdiri dari:
- Dokter Bedah: {{ $operasi->dokter_bedah ?? 'N/A' }}
- Dokter Anestesi: {{ $operasi->dokter_anestesi ?? 'N/A' }}

Operasi berlangsung di {{ $operasi->nama_ruang ?? 'N/A' }} dengan status saat ini: {{ $operasi->status ?? 'Terjadwal' }}

Tanda Tangan Dokter:

________________________
{{ $operasi->dokter_bedah ?? 'Nama Dokter' }}
Dokter Bedah
                </p>
            </div>
        </div>

        {{-- Signature Section --}}
        <div class="mt-12 grid gap-8 md:grid-cols-3">
            <div class="text-center">
                <p class="mb-16 text-sm font-semibold text-slate-900">Dokter Bedah</p>
                <p class="text-sm text-slate-600">___________________________</p>
                <p class="mt-2 text-xs text-slate-500">{{ $operasi->dokter_bedah ?? 'Nama Dokter' }}</p>
            </div>
            <div class="text-center">
                <p class="mb-16 text-sm font-semibold text-slate-900">Dokter Anestesi</p>
                <p class="text-sm text-slate-600">___________________________</p>
                <p class="mt-2 text-xs text-slate-500">{{ $operasi->dokter_anestesi ?? 'Nama Dokter' }}</p>
            </div>
            <div class="text-center">
                <p class="mb-16 text-sm font-semibold text-slate-900">Kepala Ruang</p>
                <p class="text-sm text-slate-600">___________________________</p>
                <p class="mt-2 text-xs text-slate-500">Kepala Ruang Operasi</p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="mt-12 border-t border-slate-200 pt-6 text-center text-xs text-slate-500">
            <p>Laporan ini dibuat otomatis oleh sistem RSUD Malang</p>
            <p>Tanggal Cetak: {{ now()->format('d F Y H:i') }}</p>
        </div>
    </div>

    {{-- Button Aksi --}}
    <div class="flex gap-3 justify-center">
        <button onclick="window.print()" class="btn-primary">
            <i class="fas fa-print mr-2"></i>Cetak Laporan
        </button>
        <a href="{{ route('jadwal-operasi') }}" class="btn-secondary">
            <i class="fas fa-times mr-2"></i>Tutup
        </a>
    </div>
</div>

<style>
    @media print {
        body {
            background: white;
        }
        .rounded-2xl {
            box-shadow: none;
            border: 1px solid #e2e8f0;
        }
    }
</style>
@endsection
