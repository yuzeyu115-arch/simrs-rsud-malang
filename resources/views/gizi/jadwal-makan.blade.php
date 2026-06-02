@extends('layouts.app')

@section('title', 'Gizi - Jadwal Makan')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-6">
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-emerald-700">Gizi ( Jadwal Makan )</h1>
        <p class="text-gray-600 mt-2">Kelola Pemesanan Menu, Laporan Pemesanan, dan Jadwal Makanan Pasien.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Total Pesanan Hari Ini</div>
                <div class="text-2xl font-bold text-gray-800">{{ $stats['today_orders'] ?? 48 }}</div>
            </div>
            <div class="text-green-500 font-semibold">+{{ $stats['delta_orders'] ?? 12 }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Total Laporan Hari ini</div>
                <div class="text-2xl font-bold text-gray-800">{{ $stats['today_reports'] ?? 48 }}</div>
            </div>
            <div class="text-green-500 font-semibold">+{{ $stats['delta_reports'] ?? 10 }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Jadwal Makan Hari Ini</div>
                <div class="text-2xl font-bold text-gray-800">{{ $stats['today_schedules'] ?? 92 }}</div>
            </div>
            <div class="text-green-500 font-semibold">+{{ $stats['delta_schedules'] ?? 18 }}</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Jadwal Makan Pasien</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">No.</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Jam Pesan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Jam Kirim</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Jam Lapor</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($jadwal as $i => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $i + 1 }}.</td>
                            <td class="px-4 py-3 font-semibold">{{ $item->nama ?? $item->nama_pasien ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $item->jam_pesan ?? ($item->jam ?? '07:30') }}</td>
                            <td class="px-4 py-3">{{ $item->jam_kirim ?? '08:15' }}</td>
                            <td class="px-4 py-3">{{ $item->jam_lapor ?? '08:25' }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="#" class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-sm font-semibold">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">Belum ada jadwal makan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6 h-40">
            <h4 class="text-emerald-700 font-semibold mb-2">Informasi Gizi</h4>
            <div class="text-sm text-gray-600">Ringkasan informasi gizi pasien atau panduan singkat dapat ditampilkan di sini.</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 h-40">
            <h4 class="text-emerald-700 font-semibold mb-2">Ringkasan Gizi</h4>
            <div class="text-sm text-gray-600">Statistik singkat, diet khusus, dan kebutuhan nutrisi.</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 h-40">
            <h4 class="text-emerald-700 font-semibold mb-2">Catatan</h4>
            <div class="text-sm text-gray-600">Catatan penting tentang pasien atau jadwal dapat ditempatkan di sini.</div>
        </div>
    </div>

</div>
@endsection

