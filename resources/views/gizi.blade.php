@extends('layouts.app')

@section('title', 'Dashboard Gizi')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 py-4">
    <div>
        <h2 class="text-3xl font-black text-gray-900 tracking-tight">Dashboard Gizi</h2>
        <p class="text-sm text-gray-500 mt-2">Kelola pemesanan menu, laporan pemesanan, dan jadwal makan pasien.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-gray-400">Pesanan Hari Ini</p>
                    <h3 class="text-3xl font-black text-gray-900">{{ $stats['today_orders'] ?? 0 }}</h3>
                </div>
                <div class="inline-flex items-center justify-center h-12 w-12 rounded-2xl bg-emerald-50 text-emerald-700">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
            </div>
            <p class="text-sm text-gray-500">Jumlah permintaan menu yang terdaftar hari ini.</p>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-gray-400">Laporan Hari Ini</p>
                    <h3 class="text-3xl font-black text-gray-900">{{ $stats['today_reports'] ?? 0 }}</h3>
                </div>
                <div class="inline-flex items-center justify-center h-12 w-12 rounded-2xl bg-blue-50 text-blue-700">
                    <i class="fa-solid fa-file-invoice"></i>
                </div>
            </div>
            <p class="text-sm text-gray-500">Laporan pemesanan yang dibuat hari ini.</p>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-gray-400">Jadwal Makan</p>
                    <h3 class="text-3xl font-black text-gray-900">{{ $stats['today_schedules'] ?? 0 }}</h3>
                </div>
                <div class="inline-flex items-center justify-center h-12 w-12 rounded-2xl bg-orange-50 text-orange-700">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
            </div>
            <p class="text-sm text-gray-500">Jadwal makan yang terdaftar hari ini.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-[2fr_1fr] gap-6">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-black text-gray-900">Ringkasan Pesanan</h3>
                    <p class="text-sm text-gray-500 mt-1">Tinjau pesanan menu terbaru.</p>
                </div>
                <a href="{{ route('pemesanan-menu') }}" class="text-emerald-600 font-semibold hover:text-emerald-800">Lihat semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-[11px] tracking-[0.08em]">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Pasien</th>
                            <th class="px-4 py-3">Ruang</th>
                            <th class="px-4 py-3">Kelas</th>
                            <th class="px-4 py-3">Shift</th>
                            <th class="px-4 py-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($latestOrders as $index => $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 font-semibold text-gray-700">{{ $index + 1 }}</td>
                                <td class="px-4 py-4 text-gray-800">{{ $order->nama_pasien ?? '-' }}</td>
                                <td class="px-4 py-4 text-gray-600">{{ $order->ruang ?? '-' }}</td>
                                <td class="px-4 py-4 text-gray-600">{{ $order->kelas ?? '-' }}</td>
                                <td class="px-4 py-4 text-gray-600">{{ $order->shift ?? '-' }}</td>
                                <td class="px-4 py-4 text-gray-600">{{ !empty($order->tanggal) ? date('d M Y', strtotime($order->tanggal)) : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-gray-500">Belum ada data pesanan menu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 space-y-4">
            <div class="bg-emerald-50 rounded-3xl p-5">
                <h4 class="text-lg font-black text-emerald-800">Aksi Gizi</h4>
                <p class="text-sm text-emerald-700 mt-1">Buka modul yang paling penting untuk operasi gizi.</p>
            </div>
            <a href="{{ route('pemesanan-menu') }}" class="block rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-700 font-semibold hover:bg-emerald-100">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-utensils"></i>
                    <span>Pemesanan Menu</span>
                </div>
            </a>
            <a href="{{ route('jadwal-makan') }}" class="block rounded-3xl border border-blue-200 bg-blue-50 px-5 py-4 text-blue-700 font-semibold hover:bg-blue-100">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span>Jadwal Makan</span>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
