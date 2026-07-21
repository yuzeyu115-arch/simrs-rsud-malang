@extends('layouts.app')

@section('title','Unit Farmasi')

@push('styles')
<style>
    .badge-waiting { display: inline-flex; align-items: center; justify-content: center; border-radius: 9999px; background: #fef3c7; color: #92400e; padding: 0.55rem 0.9rem; font-size: 0.7rem; font-weight: 700; }
    .badge-ready { display: inline-flex; align-items: center; justify-content: center; border-radius: 9999px; background: #dcfce7; color: #166534; padding: 0.55rem 0.9rem; font-size: 0.7rem; font-weight: 700; }
    .badge-picked { display: inline-flex; align-items: center; justify-content: center; border-radius: 9999px; background: #dbeafe; color: #1d4ed8; padding: 0.55rem 0.9rem; font-size: 0.7rem; font-weight: 700; }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-6">
@auth
<div class="space-y-8">
    <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-end">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Unit Farmasi</p>
            <h1 class="text-4xl font-bold text-slate-900">{{ ($focus ?? null) === 'orders' ? 'Semua Pesanan Paket Obat' : 'Ringkasan Farmasi' }}</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">{{ ($focus ?? null) === 'orders' ? 'Daftar lengkap pesanan paket obat dari perawat anestesi.' : 'Pantau paket obat operasi, status pengiriman, dan pengambilan secara cepat.' }}</p>
        </div>
        @php $canInputFarmasi = auth()->user()?->role === 'farmasi'; @endphp
        <div class="flex flex-col gap-3 items-end">
            <div class="rounded-3xl border border-emerald-100 bg-emerald-50 px-5 py-4 shadow-sm text-right">
                <p class="text-xs uppercase tracking-[0.2em] text-emerald-700">Status Sistem</p>
                <p class="mt-2 text-sm font-semibold text-emerald-900">Siap Melayani</p>
            </div>
            <div class="flex flex-wrap gap-3">
                @if(($focus ?? null) === 'orders')
                    <a href="{{ route('farmasi') }}" class="btn-secondary">Ringkasan Farmasi</a>
                @endif
                @if($canInputFarmasi)
                    <a href="{{ route('farmasi.input') }}" class="btn-primary">Tambah Pesanan</a>
                @endif
            </div>
        </div>
    </div>

    @if(isset($editingPackage))
        <div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm mb-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Detail Paket</p>
                    <h2 class="text-2xl font-bold text-slate-900 mt-2">Edit Paket {{ $editingPackage->nama_paket }}</h2>
                </div>
                <a href="{{ route('farmasi') }}" class="btn-secondary">Kembali ke Ringkasan</a>
            </div>
            <form action="{{ route('farmasi.update', $editingPackage->id) }}" method="POST" class="mt-6 grid gap-4 lg:grid-cols-2">
                @csrf
                @method('PUT')
                <div>
                    <label class="form-label" for="nama_paket">Nama Paket</label>
                    <input id="nama_paket" name="nama_paket" type="text" class="form-control" value="{{ old('nama_paket', $editingPackage->nama_paket) }}" required>
                </div>
                <div>
                    <label class="form-label" for="jenis_obat">Jenis Obat</label>
                    <input id="jenis_obat" name="jenis_obat" type="text" class="form-control" value="{{ old('jenis_obat', $editingPackage->jenis_obat) }}" required>
                </div>
                <div>
                    <label class="form-label" for="total_paket">Jumlah Item</label>
                    <input id="total_paket" name="total_paket" type="number" min="1" value="{{ old('total_paket', $editingPackage->total_paket) }}" class="form-control" required>
                </div>
                <div class="form-row sm:grid-cols-2">
                    <div>
                        <label class="form-label" for="preoperatif">Instruksi Preoperatif</label>
                        <input id="preoperatif" name="preoperatif" type="text" class="form-control" value="{{ old('preoperatif', $editingPackage->preoperatif) }}">
                    </div>
                    <div>
                        <label class="form-label" for="intraoperatif">Instruksi Intraoperatif</label>
                        <input id="intraoperatif" name="intraoperatif" type="text" class="form-control" value="{{ old('intraoperatif', $editingPackage->intraoperatif) }}">
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <label class="form-label" for="postoperatif">Instruksi Postoperatif</label>
                    <input id="postoperatif" name="postoperatif" type="text" class="form-control" value="{{ old('postoperatif', $editingPackage->postoperatif) }}">
                </div>
                <div class="lg:col-span-2 flex flex-wrap gap-3 justify-end">
                    <button type="submit" class="btn-primary">Perbarui Paket</button>
                </div>
            </form>
        </div>
    @endif

    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Total Paket</p>
            <p class="mt-4 text-4xl font-black text-slate-900">{{ $summary['total_paket'] ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">paket obat dipesan</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Menunggu</p>
            <p class="mt-4 text-4xl font-black text-amber-700">{{ $summary['waiting'] ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">disiapkan di farmasi</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Siap Diambil</p>
            <p class="mt-4 text-4xl font-black text-emerald-700">{{ $summary['ready'] ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">siap untuk OR</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Sudah Diambil</p>
            <p class="mt-4 text-4xl font-black text-sky-700">{{ $summary['picked'] ?? 0 }}</p>
            <p class="mt-3 text-sm text-slate-500">sudah digunakan</p>
        </div>
    </div>

    <div class="bg-white rounded-[1.5rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-900">Daftar Pesanan Paket Obat</h2>
            <p class="text-sm text-slate-500 mt-1">Pesanan dari perawat anestesi yang sedang diproses.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-sm text-slate-700">
                <thead class="bg-slate-50 text-left text-xs uppercase tracking-[0.24em] text-slate-500">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Paket</th>
                        <th class="px-6 py-3">Pasien</th>
                        <th class="px-6 py-3">Item</th>
                        <th class="px-6 py-3">Pemesan</th>
                        <th class="px-6 py-3">Waktu</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($orders as $index => $order)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-semibold">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $order->order_id }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $order->nama_paket }}</td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $order->nama_pasien ?? '-' }}
                                @if($order->nomor_rm ?? null)
                                    <br><span class="text-xs text-slate-400">RM {{ $order->nomor_rm }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $order->jumlah_item }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $order->dipesan_oleh }}</td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ $order->waktu_pesan }}</td>
                            <td class="px-6 py-4">
                                @if($order->status == 'Menunggu Disiapkan')
                                    <span class="badge-waiting">Menunggu</span>
                                @elseif($order->status == 'Siap Diambil')
                                    <span class="badge-ready">Siap</span>
                                @else
                                    <span class="badge-picked">Diambil</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    @if($canInputFarmasi && isset($order->nama_pasien))
                                        <form action="{{ route('farmasi.pesanan.status', $order->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            <select name="status" class="rounded-2xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700">
                                                <option value="Menunggu Disiapkan" @selected($order->status === 'Menunggu Disiapkan')>Menunggu</option>
                                                <option value="Siap Diambil" @selected($order->status === 'Siap Diambil')>Siap</option>
                                                <option value="Sudah Diambil" @selected($order->status === 'Sudah Diambil')>Diambil</option>
                                            </select>
                                            <button type="submit" class="rounded-2xl border border-emerald-200 bg-white px-4 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-50 transition">Update</button>
                                        </form>
                                        <a href="{{ route('farmasi.edit', $order->id) }}" class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">Detail</a>
                                    @elseif($canInputFarmasi)
                                        <a href="{{ route('farmasi.edit', $order->id) }}" class="rounded-2xl border border-emerald-200 bg-white px-4 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-50 transition">Detail</a>
                                    @else
                                        <span class="text-xs text-slate-400">Tidak tersedia</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-16 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M5 7V5a2 2 0 012-2h10a2 2 0 012 2v2" />
                                    </svg>
                                    <p class="mt-3 text-sm">Belum ada pesanan paket obat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-4 bg-white border-t border-slate-100 text-center">
        @if(method_exists($orders, 'links'))
            {{ $orders->links() }}
        @endif
    </div>

    <div class="text-center mt-6">
        @if(($focus ?? null) === 'orders')
            <a href="{{ route('farmasi') }}" class="btn-secondary">Kembali ke Ringkasan</a>
        @endif
    </div>
</div>
@else
<div class="rounded-[1.5rem] border border-slate-200 bg-white p-8 shadow-sm text-center">
    <h2 class="text-lg font-bold text-slate-900">Akses Farmasi</h2>
    <p class="mt-2 text-sm text-slate-600">Silakan masuk untuk melihat dan mengelola pesanan paket obat.</p>
    <div class="mt-4">
        <a href="{{ route('login') }}" class="btn-primary">Masuk</a>
    </div>
</div>
@endauth
</div>
@endsection
