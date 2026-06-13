@extends('layouts.app')

@section('title','Ringkasan Logistik Cepat')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm text-slate-500">Logistik</p>
            <h1 class="text-3xl font-bold text-slate-900">Ringkasan Cepat</h1>
        </div>
        <p class="rounded-2xl bg-slate-100 px-4 py-2 text-sm text-slate-600">Pantau stok dan status persediaan</p>
    </div>

    @if(session('success'))
        <div class="rounded-3xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6 md:grid-cols-3">
        <div class="card-panel p-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Bius Tersedia</p>
                    <p class="mt-3 text-3xl font-bold text-sky-600">{{ $logistics->total_bius_tersedia ?? 0 }}</p>
                    <p class="text-sm text-slate-500 mt-2">Unit</p>
                </div>
                <div class="rounded-3xl bg-sky-100 p-4 text-sky-700">
                    <i class="fa-solid fa-syringe text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="card-panel p-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Cairan Infus</p>
                    <p class="mt-3 text-3xl font-bold text-emerald-600">{{ $logistics->jumlah_cairan_infus ?? 0 }}</p>
                    <p class="text-sm text-slate-500 mt-2">Botol</p>
                </div>
                <div class="rounded-3xl bg-emerald-100 p-4 text-emerald-700">
                    <i class="fa-solid fa-droplet text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="card-panel p-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Alat Bedah Steril</p>
                    <p class="mt-3 text-3xl font-bold text-violet-600">{{ $logistics->jumlah_alat_bedah_steril ?? 0 }}</p>
                    <p class="text-sm text-slate-500 mt-2">Set</p>
                </div>
                <div class="rounded-3xl bg-violet-100 p-4 text-violet-700">
                    <i class="fa-solid fa-scissors text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1fr_1.5fr]">
        <section class="card-panel p-6">
            <div class="mb-4">
                <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Update Stok</p>
                <h2 class="mt-2 text-xl font-semibold text-slate-900">Kontrol Ketersediaan</h2>
            </div>

            <form action="{{ route('logistik-ringkasan.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Total Bius Tersedia *</label>
                    <input name="total_bius_tersedia" value="{{ old('total_bius_tersedia', $logistics->total_bius_tersedia ?? 0) }}" type="number" min="0" class="input-base" />
                    @error('total_bius_tersedia') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Cairan Infus *</label>
                    <input name="jumlah_cairan_infus" value="{{ old('jumlah_cairan_infus', $logistics->jumlah_cairan_infus ?? 0) }}" type="number" min="0" class="input-base" />
                    @error('jumlah_cairan_infus') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Alat Bedah Steril *</label>
                    <input name="jumlah_alat_bedah_steril" value="{{ old('jumlah_alat_bedah_steril', $logistics->jumlah_alat_bedah_steril ?? 0) }}" type="number" min="0" class="input-base" />
                    @error('jumlah_alat_bedah_steril') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                @if($logistics)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Terakhir Dicek</p>
                        <p class="mt-2 text-sm text-slate-700">{{ $logistics->terakhir_dicek ? date('d/m/Y H:i', strtotime($logistics->terakhir_dicek)) : '-' }}</p>
                    </div>
                @endif

                <button type="submit" class="btn-primary w-full">Simpan Update</button>
            </form>
        </section>

        <section class="space-y-4">
            <div class="card-panel p-6">
                <div class="mb-4">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Status Logistik</p>
                    <h2 class="mt-2 text-xl font-semibold text-slate-900">Ringkasan Persediaan</h2>
                </div>

                <div class="space-y-4">
                    <div class="rounded-3xl border-l-4 border-sky-500 bg-sky-50 p-4">
                        <p class="font-semibold text-slate-900">Bius (Anestesi)</p>
                        <p class="text-sm text-slate-600 mt-1">Stok saat ini: <span class="font-semibold text-sky-700">{{ $logistics->total_bius_tersedia ?? 0 }} Unit</span></p>
                        <p class="text-xs text-slate-500 mt-2">Untuk kebutuhan operasi rutin 1-2 minggu</p>
                    </div>
                    <div class="rounded-3xl border-l-4 border-emerald-500 bg-emerald-50 p-4">
                        <p class="font-semibold text-slate-900">Cairan Infus</p>
                        <p class="text-sm text-slate-600 mt-1">Stok saat ini: <span class="font-semibold text-emerald-700">{{ $logistics->jumlah_cairan_infus ?? 0 }} Botol</span></p>
                        <p class="text-xs text-slate-500 mt-2">Untuk pasien rawat inap dan operasi</p>
                    </div>
                    <div class="rounded-3xl border-l-4 border-violet-500 bg-violet-50 p-4">
                        <p class="font-semibold text-slate-900">Alat Bedah Steril</p>
                        <p class="text-sm text-slate-600 mt-1">Stok saat ini: <span class="font-semibold text-violet-700">{{ $logistics->jumlah_alat_bedah_steril ?? 0 }} Set</span></p>
                        <p class="text-xs text-slate-500 mt-2">Set lengkap untuk operasi minor dan mayor</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
