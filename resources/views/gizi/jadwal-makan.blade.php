@extends('layouts.app')

@section('title', 'Jadwal Makan')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-3xl font-black text-gray-900">Jadwal Makan</h1>
            <p class="mt-2 text-sm text-gray-500">Atur jadwal makan pasien dan tinjau status pengiriman makanan secara real time.</p>
        </div>
        <div class="inline-flex items-center gap-3">
            <a href="{{ route('gizi') }}" class="inline-flex items-center gap-2 rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali Dashboard</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">
        <div class="rounded-3xl bg-white p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Pesanan Hari Ini</p>
                    <p class="mt-3 text-3xl font-black text-gray-900">{{ $stats['today_orders'] ?? 0 }}</p>
                </div>
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                    <i class="fa-solid fa-bowl-food"></i>
                </div>
            </div>
            <p class="mt-4 text-sm text-gray-500">Total pemesanan menu yang tercatat hari ini.</p>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Laporan Hari Ini</p>
                    <p class="mt-3 text-3xl font-black text-gray-900">{{ $stats['today_reports'] ?? 0 }}</p>
                </div>
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
            </div>
            <p class="mt-4 text-sm text-gray-500">Laporan perkembangan layanan gizi yang masuk.</p>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Jadwal Makan</p>
                    <p class="mt-3 text-3xl font-black text-gray-900">{{ $stats['today_schedules'] ?? 0 }}</p>
                </div>
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-orange-50 text-orange-700">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>
            <p class="mt-4 text-sm text-gray-500">Jumlah jadwal makan yang terdaftar untuk hari ini.</p>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.4fr_0.6fr]">
        <div class="space-y-6">
            <div class="rounded-3xl bg-white p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between gap-4 border-b border-gray-200 pb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Daftar Jadwal Makan</h2>
                        <p class="mt-1 text-sm text-gray-500">Pantau jadwal makan pasien dan cek status secara cepat.</p>
                    </div>
                    <span class="rounded-full bg-orange-50 px-3 py-1 text-xs font-semibold text-orange-700">{{ $jadwal->count() }} Jadwal</span>
                </div>
                <div class="mt-5 overflow-x-auto">
                    <table class="min-w-full text-left text-sm text-gray-700">
                        <thead class="border-b border-gray-200 bg-gray-50 text-xs uppercase tracking-[0.16em] text-gray-500">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Jam Pesan</th>
                                <th class="px-4 py-3">Shift</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($jadwal as $i => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 font-semibold text-gray-700">{{ $i + 1 }}</td>
                                    <td class="px-4 py-4 text-gray-900">{{ $item->nama ?? $item->nama_pasien ?? '—' }}</td>
                                    <td class="px-4 py-4 text-gray-600">{{ $item->jam_pesan ?? '07:30' }}</td>
                                    <td class="px-4 py-4"><span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">{{ $item->shift }}</span></td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="#" data-title="Lihat Jadwal" data-body="Detail jadwal belum tersedia. Minta saya untuk menambahkannya." class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-emerald-50 text-emerald-700 hover:bg-emerald-100">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-gray-500">Belum ada jadwal makan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between gap-4 border-b border-gray-200 pb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Tambah Jadwal Baru</h2>
                        <p class="mt-1 text-sm text-gray-500">Masukkan detail jadwal makan pasien dari sini.</p>
                    </div>
                </div>
                <form action="{{ route('jadwal-makan.store') }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">Nama Pasien</label>
                            <input name="nama" value="{{ old('nama') }}" type="text" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700" placeholder="Masukkan nama pasien" />
                            @error('nama') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">Jam Pesan</label>
                            <input name="jam_pesan" value="{{ old('jam_pesan') }}" type="time" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700" />
                            @error('jam_pesan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">Shift Makan</label>
                        <select name="shift" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                            <option value="">Pilih shift</option>
                            <option value="Pagi" {{ old('shift') == 'Pagi' ? 'selected' : '' }}>Pagi</option>
                            <option value="Siang" {{ old('shift') == 'Siang' ? 'selected' : '' }}>Siang</option>
                            <option value="Sore" {{ old('shift') == 'Sore' ? 'selected' : '' }}>Sore</option>
                        </select>
                        @error('shift') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="rounded-2xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-emerald-700">Simpan Jadwal</button>
                    </div>
                </form>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="rounded-3xl bg-white p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">Catatan Gizi</h2>
                <p class="mt-4 text-sm text-gray-600">Gunakan menu ini untuk mencatat kebutuhan nutrisi pasien dan menjaga jadwal makan berjalan lancar.</p>
                <div class="mt-6 space-y-4 text-sm text-gray-600">
                    <div class="rounded-2xl bg-gray-50 p-4">
                        <p class="font-semibold text-gray-900">Diet khusus</p>
                        <p class="mt-2">Pastikan menu disesuaikan untuk pasien dengan pantangan dan alergi.</p>
                    </div>
                    <div class="rounded-2xl bg-gray-50 p-4">
                        <p class="font-semibold text-gray-900">Koordinasi</p>
                        <p class="mt-2">Sinkronkan jadwal dengan tim gizi dan perawat agar tidak ada keterlambatan.</p>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection

