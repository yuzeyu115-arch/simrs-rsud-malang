@extends('layouts.app')

@section('title','Dashboard Pasien')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Dashboard Pasien</p>
            <h1 class="text-4xl font-bold text-slate-900">Informasi & Status Perawatan</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Pantau status perawatan dan ikuti instruksi tim medis untuk hasil optimal.</p>
        </div>
        <button class="btn-primary">Hubungi Tim Medis</button>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="card-panel p-6">
            <div class="flex items-start gap-4">
                <div class="rounded-3xl bg-emerald-50 p-4 text-emerald-700">
                    <i class="fa-solid fa-heart-pulse text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Status Perawatan</p>
                    <h2 class="mt-3 text-xl font-semibold text-slate-900">Pengawasan Kesehatan</h2>
                    <p class="mt-2 text-slate-600">Cek informasi terbaru dan ikuti arahan tim medis untuk perawatan optimal.</p>
                </div>
            </div>
        </div>

        <div class="card-panel p-6">
            <div class="flex items-start gap-4">
                <div class="rounded-3xl bg-sky-50 p-4 text-sky-700">
                    <i class="fa-solid fa-calendar-days text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Informasi Pra-Bedah</p>
                    <h2 class="mt-3 text-xl font-semibold text-slate-900">Persiapan Operasi</h2>
                    <p class="mt-2 text-slate-600">Ikuti instruksi tim medis dan siapkan dokumen medis sebelumnya.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card-panel p-6 bg-emerald-50 border border-emerald-100">
        <div class="flex items-center gap-4">
            <div class="rounded-3xl bg-white p-4 text-emerald-600 shadow-sm">
                <i class="fa-solid fa-circle-info text-2xl"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-emerald-700">Pengingat</p>
                <p class="text-sm text-slate-600">Jika Anda memiliki pertanyaan, hubungi tim layanan pasien atau gunakan fitur notifikasi pada dashboard.</p>
            </div>
        </div>
    </div>
</div>
@endsection
