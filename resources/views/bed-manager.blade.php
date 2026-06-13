@extends('layouts.app')

@section('title','Bed Manager')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Bed Manager</p>
            <h1 class="text-4xl font-bold text-slate-900">Kelola Ketersediaan Tempat Tidur</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Pantau status bed rumah sakit, mulai dari terisi hingga dalam pembersihan.</p>
        </div>
        <a href="#" class="btn-primary">Tambah Bed</a>
    </div>

    <div class="grid gap-6 xl:grid-cols-5">
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Total Tempat Tidur</p>
            <p class="mt-4 text-4xl font-black text-slate-900">{{ $beds->count() ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">tersedia di sistem</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Terisi</p>
            <p class="mt-4 text-4xl font-black text-sky-700">{{ $beds->where('status', 'Terisi')->count() ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">sedang digunakan</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Tersedia</p>
            <p class="mt-4 text-4xl font-black text-emerald-700">{{ $beds->where('status', 'Tersedia')->count() ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">siap digunakan</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Dalam Pembersihan</p>
            <p class="mt-4 text-4xl font-black text-violet-700">{{ $beds->where('status', 'Maintenance')->count() ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">sedang dibersihkan</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Tidak Tersedia</p>
            <p class="mt-4 text-4xl font-black text-rose-700">{{ $beds->where('status', 'Tidak Tersedia')->count() ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">tidak dapat dipakai</p>
        </div>
    </div>

    <div class="card-panel p-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Filter Ketersediaan</h2>
                <p class="text-sm text-slate-500 mt-1">Saring berdasarkan gedung, lantai, jenis kamar, dan status.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <button class="btn-secondary">Refresh</button>
                <button class="btn-primary">Terapkan Filter</button>
            </div>
        </div>
        <div class="mt-6 grid gap-4 lg:grid-cols-5">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Gedung</label>
                <select class="input-base">
                    <option>Semua Gedung</option>
                    <option>Gedung A</option>
                    <option>Gedung B</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Lantai</label>
                <select class="input-base">
                    <option>Semua Lantai</option>
                    <option>Lantai 1</option>
                    <option>Lantai 2</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Jenis Kamar</label>
                <select class="input-base">
                    <option>Semua Jenis Kamar</option>
                    <option>VIP</option>
                    <option>Kelas I</option>
                    <option>Kelas II</option>
                    <option>Kelas III</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Status</label>
                <select class="input-base">
                    <option>Semua Status</option>
                    <option>Terisi</option>
                    <option>Tersedia</option>
                    <option>Reservasi</option>
                    <option>Maintenance</option>
                    <option>Tidak Tersedia</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Cari</label>
                <input type="text" placeholder="Cari kamar / bed..." class="input-base">
            </div>
        </div>
        <div class="mt-6 rounded-3xl bg-slate-50 p-4 text-sm text-slate-500">
            Hasil akan ditampilkan berdasarkan filter yang dipilih. Gunakan tombol Terapkan Filter untuk memperbarui daftar tempat tidur.
        </div>
    </div>

    <div class="card-panel overflow-x-auto">
        <div class="px-6 py-5 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-900">Daftar Tempat Tidur</h2>
        </div>
        <table class="w-full min-w-[760px] text-sm text-slate-700">
            <thead class="bg-slate-50 text-left text-xs uppercase tracking-[0.24em] text-slate-500">
                <tr>
                    <th class="p-4">No.</th>
                    <th class="p-4">Gedung</th>
                    <th class="p-4">Lantai</th>
                    <th class="p-4">Ruangan</th>
                    <th class="p-4">No.Bed</th>
                    <th class="p-4">Jenis Kamar</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Pasien</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($beds as $index => $b)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4">{{ $index + 1 }}</td>
                        <td class="p-4">{{ $b->gedung }}</td>
                        <td class="p-4">{{ $b->lantai }}</td>
                        <td class="p-4">{{ $b->ruangan }}</td>
                        <td class="p-4">{{ $b->no_bed }}</td>
                        <td class="p-4">{{ $b->jenis_kamar }}</td>
                        <td class="p-4">
                            @if($b->status == 'Tersedia')
                                <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Tersedia</span>
                            @elseif($b->status == 'Terisi')
                                <span class="inline-flex rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">Terisi</span>
                            @elseif($b->status == 'Booking')
                                <span class="inline-flex rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">Reservasi</span>
                            @elseif($b->status == 'Maintenance')
                                <span class="inline-flex rounded-full bg-violet-50 px-3 py-1 text-xs font-semibold text-violet-700">Maintenance</span>
                            @else
                                <span class="inline-flex rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700">Tidak Tersedia</span>
                            @endif
                        </td>
                        <td class="p-4 text-slate-600">{{ $b->nama_pasien ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-slate-400">
                            <i class="fas fa-inbox text-3xl"></i>
                            <p class="mt-3 text-sm">Belum ada data tempat tidur.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
