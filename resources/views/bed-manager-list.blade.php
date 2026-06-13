@extends('layouts.app')

@section('title','Bed Manager')

@push('styles')
<style>
    .card-stat {
        border-radius: 1rem;
        background: #ffffff;
        border: 1px solid rgba(148, 163, 184, 0.16);
        padding: 1.5rem;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
    }
    .badge-tersedia,
    .badge-terisi,
    .badge-booking,
    .badge-maintenance {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .badge-tersedia { background: #dcfce7; color: #166534; }
    .badge-terisi { background: #DBEAFE; color: #1D4ED8; }
    .badge-booking { background: #E0F2FE; color: #0284C7; }
    .badge-maintenance { background: #FEF3C7; color: #92400E; }
</style>
@endpush

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500">Manajemen Bed</p>
            <h1 class="text-3xl font-bold text-slate-900">Bed Manager</h1>
            <p class="text-sm text-slate-600 mt-2">Kelola ketersediaan dan status tempat tidur pasien dengan mudah.</p>
        </div>
        <a href="#" class="btn-primary">
            <i class="fas fa-plus"></i>
            Tambah Bed
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="card-stat">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Total Bed</p>
            <div class="mt-4 text-3xl font-black text-slate-900">{{ $beds->count() ?? 0 }}</div>
            <p class="mt-3 text-sm text-slate-500">tersedia di sistem</p>
        </div>
        <div class="card-stat">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Tersedia</p>
            <div class="mt-4 text-3xl font-black text-emerald-600">{{ $beds->where('status', 'Tersedia')->count() ?? 0 }}</div>
            <p class="mt-3 text-sm text-slate-500">siap digunakan</p>
        </div>
        <div class="card-stat">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Terisi</p>
            <div class="mt-4 text-3xl font-black text-blue-600">{{ $beds->where('status', 'Terisi')->count() ?? 0 }}</div>
            <p class="mt-3 text-sm text-slate-500">sedang digunakan</p>
        </div>
        <div class="card-stat">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Booking</p>
            <div class="mt-4 text-3xl font-black text-sky-600">{{ $beds->where('status', 'Booking')->count() ?? 0 }}</div>
            <p class="mt-3 text-sm text-slate-500">sudah dipesan</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <h2 class="font-bold text-slate-900">Daftar Tempat Tidur</h2>
            <p class="text-sm text-slate-500 mt-1">Tabel lengkap semua bed yang tersedia di rumah sakit.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-sm text-slate-700">
                <thead class="bg-slate-50 text-left text-xs uppercase tracking-[0.24em] text-slate-500">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Lokasi</th>
                        <th class="px-6 py-3">No Bed</th>
                        <th class="px-6 py-3">Jenis</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Pasien</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($beds as $index => $b)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-semibold">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-900">{{ $b->gedung }}</div>
                                <div class="text-xs text-slate-500">Lt.{{ $b->lantai }} · {{ $b->ruangan }}</div>
                            </td>
                            <td class="px-6 py-4 font-semibold">{{ $b->no_bed }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $b->jenis_kamar }}</td>
                            <td class="px-6 py-4">
                                @if($b->status == 'Tersedia')
                                    <span class="badge-tersedia">Tersedia</span>
                                @elseif($b->status == 'Terisi')
                                    <span class="badge-terisi">Terisi</span>
                                @elseif($b->status == 'Booking')
                                    <span class="badge-booking">Booking</span>
                                @else
                                    <span class="badge-maintenance">Maintenance</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600 text-sm">{{ $b->nama_pasien ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('bed-manager.edit', $b->id) }}" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-emerald-100 text-emerald-600 hover:bg-emerald-50 transition" title="Edit">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <form action="{{ route('bed-manager.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Yakin hapus bed ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-red-100 text-red-600 hover:bg-red-50 transition" title="Hapus">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center text-slate-400">
                                <i class="fas fa-inbox text-3xl"></i>
                                <p class="mt-4 text-sm">Belum ada data tempat tidur</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
