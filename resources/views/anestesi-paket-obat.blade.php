@extends('layouts.app')

@section('title','Paket Obat Anestesi')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Perawat Anestesi</p>
            <h1 class="mt-1 text-3xl font-bold text-slate-900">Pilih Paket Obat Anestesi</h1>
            <p class="mt-1.5 text-sm text-slate-600 max-w-2xl">Pilih paket obat untuk jadwal operasi. Unit Farmasi akan menerima detail paket dan notifikasi persiapan.</p>
        </div>
        <a href="{{ route('farmasi.pesanan') }}" class="btn-secondary">Pantau Pesanan</a>
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
    @endif

    <div class="grid gap-4 xl:grid-cols-[0.72fr_1.28fr]">
        <div class="card-panel p-5">
            <h2 class="text-lg font-bold text-slate-900">Form Pemilihan Paket</h2>
            <form action="{{ route('anestesi.paket-obat.store') }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Jadwal Operasi</label>
                    <select name="surgery_schedule_id" class="input-base" required>
                        <option value="">Pilih operasi</option>
                        @foreach($schedules as $schedule)
                            <option value="{{ $schedule->id }}" @selected(old('surgery_schedule_id') == $schedule->id)>
                                {{ $schedule->nama_pasien }} - {{ $schedule->nama_ruang ?? 'Ruang OK' }} - {{ date('d M Y', strtotime($schedule->tanggal_operasi)) }} {{ date('H:i', strtotime($schedule->jam_mulai)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('surgery_schedule_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Paket Obat</label>
                    <select name="medicine_package_id" class="input-base" required>
                        <option value="">Pilih paket obat</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" @selected(old('medicine_package_id') == $package->id)>
                                {{ $package->nama_paket }} - {{ $package->total_paket }} item
                            </option>
                        @endforeach
                    </select>
                    @error('medicine_package_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Catatan</label>
                    <textarea name="catatan" rows="3" class="input-base" placeholder="Instruksi tambahan untuk farmasi">{{ old('catatan') }}</textarea>
                    @error('catatan')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn-primary">Kirim ke Farmasi</button>
                </div>
            </form>
        </div>

        <div class="card-panel overflow-hidden">
            <div class="border-b border-slate-100 px-5 py-4">
                <h2 class="text-lg font-bold text-slate-900">Pesanan Paket Terbaru</h2>
            </div>
            <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-sm text-slate-700">
                <thead class="bg-slate-50 text-left text-xs uppercase tracking-[0.16em] text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Pasien</th>
                        <th class="px-4 py-3">Paket</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Catatan</th>
                        <th class="px-4 py-3">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($orders as $order)
                        <tr>
                            <td class="px-4 py-3 font-semibold text-slate-900">{{ $order->nama_pasien }}<br><span class="text-xs font-normal text-slate-500">RM {{ $order->nomor_rm }}</span></td>
                            <td class="px-4 py-3">{{ $order->nama_paket }}</td>
                            <td class="px-4 py-3"><span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">{{ $order->status }}</span></td>
                            <td class="px-4 py-3 text-slate-500">{{ $order->catatan ?: '-' }}</td>
                            <td class="px-4 py-3 text-xs text-slate-500">{{ date('d M Y H:i', strtotime($order->created_at)) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-10 text-center text-slate-400">Belum ada paket yang dipilih.</td></tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<style>
    .input-base {
        border-radius: 0.85rem;
        padding: 0.72rem 0.9rem;
    }
</style>
@endsection
