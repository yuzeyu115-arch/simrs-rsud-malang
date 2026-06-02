@extends('layouts.app')

@section('title', 'Pemesanan Menu')

@section('content')
<div class="max-w-7xl mx-auto py-4">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gizi — Pemesanan Menu</h1>
        <p class="text-gray-600 mt-2">Kelola pemesanan menu, laporan pemesanan, dan jadwal makanan pasien.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg p-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Header cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Total Pesanan Hari Ini</div>
                <div class="text-2xl font-bold text-gray-800">{{ $stats['today_orders'] ?? 0 }}</div>
            </div>
            <div class="text-green-500 font-semibold">+{{ $stats['delta_orders'] ?? 0 }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Total Laporan Hari Ini</div>
                <div class="text-2xl font-bold text-gray-800">{{ $stats['today_reports'] ?? 0 }}</div>
            </div>
            <div class="text-green-500 font-semibold">+{{ $stats['delta_reports'] ?? 0 }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Jadwal Makan Hari Ini</div>
                <div class="text-2xl font-bold text-gray-800">{{ $stats['today_schedules'] ?? 0 }}</div>
            </div>
            <div class="text-green-500 font-semibold">+{{ $stats['delta_schedules'] ?? 0 }}</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Filter Pemesanan Menu</h2>
            <div class="flex items-center gap-2">
                <a href="#" id="open-modal" class="px-4 py-2 bg-green-600 text-white rounded">Buat baru</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="text-sm text-gray-600">Tanggal</label>
                <input type="date" class="w-full border rounded px-3 py-2" id="filter-date">
            </div>
            <div>
                <label class="text-sm text-gray-600">Shift</label>
                <select class="w-full border rounded px-3 py-2" id="filter-shift">
                    <option value="">Semua</option>
                    <option value="Pagi">Pagi</option>
                    <option value="Siang">Siang</option>
                    <option value="Sore">Sore</option>
                </select>
            </div>
            <div>
                <label class="text-sm text-gray-600">Kelas</label>
                <select class="w-full border rounded px-3 py-2" id="filter-kelas">
                    <option value="">Semua</option>
                    <option value="VIP">VIP</option>
                    <option value="Kelas 1">Kelas 1</option>
                    <option value="Kelas 2">Kelas 2</option>
                    <option value="Kelas 3">Kelas 3</option>
                </select>
            </div>
        </div>
    </div>

    <!-- List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Daftar Pemesanan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">#</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Pasien</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Ruang</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Kelas</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Shift</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($menus as $index => $m)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-semibold">{{ $m->nama_pasien }}</td>
                            <td class="px-4 py-3">{{ $m->ruang }}</td>
                            <td class="px-4 py-3">{{ $m->kelas }}</td>
                            <td class="px-4 py-3"><span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">{{ $m->shift }}</span></td>
                            <td class="px-4 py-3">{{ date('d/m/Y', strtotime($m->tanggal)) }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('pemesanan-menu.edit', $m->id) }}" class="p-2 text-green-600 hover:bg-green-50 rounded">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('pemesanan-menu.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada pemesanan menu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('gizi.create-pemesanan-menu')

</div>
@endsection

@push('scripts')
<script>
document.getElementById('open-modal')?.addEventListener('click', function(e){
    e.preventDefault();
    document.getElementById('modal-create')?.classList.remove('hidden');
});
document.querySelectorAll('[data-close-modal]').forEach(btn=> btn.addEventListener('click', ()=>{
    document.getElementById('modal-create')?.classList.add('hidden');
}));
</script>
@endpush
