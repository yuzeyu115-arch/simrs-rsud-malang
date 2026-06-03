@extends('layouts.app')

@section('title', 'Pemesanan Menu')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-3xl font-black text-gray-900">Pemesanan Menu</h1>
            <p class="mt-2 text-sm text-gray-500">Kelola pemesanan menu pasien, filter data dengan cepat, dan buat pesanan baru.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="#" id="open-modal" class="inline-flex items-center gap-2 rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow hover:bg-emerald-700">
                <i class="fa-solid fa-plus"></i>
                <span>Buat Pemesanan</span>
            </a>
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
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
            </div>
            <p class="mt-4 text-sm text-gray-500">Total pemesanan yang direkam hari ini.</p>
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
            <p class="mt-4 text-sm text-gray-500">Jumlah laporan pemesanan hari ini.</p>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Jadwal Makan</p>
                    <p class="mt-3 text-3xl font-black text-gray-900">{{ $stats['today_schedules'] ?? 0 }}</p>
                </div>
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-orange-50 text-orange-700">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
            </div>
            <p class="mt-4 text-sm text-gray-500">Jumlah jadwal makan yang dijadwalkan hari ini.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-[1.4fr_0.6fr] gap-6 mb-6">
        <div class="space-y-6">
            <div class="rounded-3xl bg-white p-6 shadow-sm border border-gray-100">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Filter Data Pemesanan</h2>
                        <p class="mt-1 text-sm text-gray-500">Gunakan filter untuk menemukan pesanan berdasarkan tanggal, shift, atau kelas.</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button id="filter-reset" class="rounded-2xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Reset Filter</button>
                        <button id="filter-apply" class="rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Terapkan</button>
                    </div>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">Tanggal</label>
                        <input type="date" id="filter-date" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700" />
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">Shift</label>
                        <select id="filter-shift" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                            <option value="">Semua Shift</option>
                            <option value="Pagi">Pagi</option>
                            <option value="Siang">Siang</option>
                            <option value="Sore">Sore</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">Kelas</label>
                        <select id="filter-kelas" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                            <option value="">Semua Kelas</option>
                            <option value="VIP">VIP</option>
                            <option value="Kelas 1">Kelas 1</option>
                            <option value="Kelas 2">Kelas 2</option>
                            <option value="Kelas 3">Kelas 3</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Daftar Pemesanan</h2>
                        <p class="text-sm text-gray-500">Tinjau pemesanan terbaru dan ambil tindakan cepat.</p>
                    </div>
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">{{ $menus->count() }} Pemesanan</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm text-gray-700">
                        <thead class="border-b border-gray-200 bg-gray-50 text-xs uppercase tracking-[0.16em] text-gray-500">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Pasien</th>
                                <th class="px-4 py-3">Ruang</th>
                                <th class="px-4 py-3">Kelas</th>
                                <th class="px-4 py-3">Shift</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($menus as $index => $m)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 font-semibold text-gray-700">{{ $index + 1 }}</td>
                                    <td class="px-4 py-4 text-gray-900">{{ $m->nama_pasien }}</td>
                                    <td class="px-4 py-4 text-gray-600">{{ $m->ruang }}</td>
                                    <td class="px-4 py-4 text-gray-600">{{ $m->kelas }}</td>
                                    <td class="px-4 py-4"><span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">{{ $m->shift }}</span></td>
                                    <td class="px-4 py-4 text-gray-600">{{ date('d M Y', strtotime($m->tanggal)) }}</td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('pemesanan-menu.edit', $m->id) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-emerald-50 text-emerald-700 hover:bg-emerald-100">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form action="{{ route('pemesanan-menu.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus pemesanan ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-red-50 text-red-700 hover:bg-red-100">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-10 text-center text-gray-500">Belum ada pemesanan menu.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="rounded-3xl bg-white p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">Ringkasan Hari Ini</h2>
                <dl class="mt-6 space-y-4 text-sm text-gray-600">
                    <div class="flex items-center justify-between rounded-2xl bg-gray-50 p-4">
                        <span>Total pesanan</span>
                        <span class="font-semibold text-gray-900">{{ $stats['today_orders'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-gray-50 p-4">
                        <span>Laporan masuk</span>
                        <span class="font-semibold text-gray-900">{{ $stats['today_reports'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-gray-50 p-4">
                        <span>Jadwal terdaftar</span>
                        <span class="font-semibold text-gray-900">{{ $stats['today_schedules'] ?? 0 }}</span>
                    </div>
                </dl>
            </div>

            <div class="rounded-3xl bg-emerald-50 p-6 shadow-sm border border-emerald-100">
                <h2 class="text-lg font-semibold text-emerald-800">Dengan SimpleOK</h2>
                <p class="mt-3 text-sm text-emerald-700">Pantau setiap pesanan dengan lebih cepat dan pastikan pasien menerima menu yang sesuai.</p>
            </div>
        </aside>
    </div>

    @include('gizi.create-pemesanan-menu')
</div>
@endsection

@push('scripts')
<script>
document.getElementById('open-modal')?.addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('modal-create')?.classList.remove('hidden');
});

document.querySelectorAll('[data-close-modal]').forEach(btn => btn.addEventListener('click', function() {
    document.getElementById('modal-create')?.classList.add('hidden');
}));
</script>
@endpush
