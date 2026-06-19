@extends('layouts.app')

@section('title','Dashboard Pasien')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Dashboard Pasien</p>
            <h1 class="text-4xl font-bold text-slate-900">Informasi & Status Perawatan</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Masuk tanpa login untuk melihat ringkasan proses perawatan dan notifikasi terkait operasi Anda.</p>
        </div>
        <a href="/" class="btn-secondary">Kembali ke Login</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="card-panel p-6">
            <div class="flex items-start gap-4">
                <div class="rounded-3xl bg-emerald-50 p-4 text-emerald-700">
                    <i class="fa-solid fa-notes-medical text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Ringkasan Proses</p>
                    <h2 class="mt-3 text-xl font-semibold text-slate-900">Dari input jadwal hingga persiapan obat</h2>
                    <p class="mt-2 text-slate-600">Sistem ini membantu tim medis berkoordinasi sehingga pasien dapat melihat perkembangan jadwal operasi dan perawatan.</p>
                </div>
            </div>
        </div>

        <div class="card-panel p-6">
            <div class="flex items-start gap-4">
                <div class="rounded-3xl bg-sky-50 p-4 text-sky-700">
                    <i class="fa-solid fa-users-medical text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Peran Aktor</p>
                    <h2 class="mt-3 text-xl font-semibold text-slate-900">Koordinasi tim rumah sakit</h2>
                    <p class="mt-2 text-slate-600">TPP, KPP, DPJB, Perawat Anestesi, dan Farmasi terintegrasi dalam alur notifikasi untuk memastikan tata kelola operasi.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="card-panel p-5">
            <p class="text-sm uppercase tracking-[0.24em] text-slate-500 mb-4">TPP</p>
            <h3 class="text-lg font-semibold text-slate-900">Input Jadwal Operasi</h3>
            <p class="mt-3 text-sm text-slate-600">TPP menginput jadwal operasi pasien, memicu notifikasi otomatis ke seluruh tim.</p>
        </div>
        <div class="card-panel p-5">
            <p class="text-sm uppercase tracking-[0.24em] text-slate-500 mb-4">KPP</p>
            <h3 class="text-lg font-semibold text-slate-900">Tentukan Kamar & Waktu</h3>
            <p class="mt-3 text-sm text-slate-600">KPP menentukan kamar operasi dan kamar rawat inap, serta memfinalisasi jadwal pelaksanaan.</p>
        </div>
        <div class="card-panel p-5">
            <p class="text-sm uppercase tracking-[0.24em] text-slate-500 mb-4">DPJB</p>
            <h3 class="text-lg font-semibold text-slate-900">Tindak Medis & Dokumentasi</h3>
            <p class="mt-3 text-sm text-slate-600">Dokter mengisi lembar observasi dan CPPT pasien secara terintegrasi setelah tindakan medis.</p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="card-panel p-6 bg-emerald-50 border border-emerald-100">
            <p class="text-sm font-semibold text-emerald-700">Perawat Anestesi</p>
            <p class="mt-3 text-slate-600">Memilih paket obat yang dibutuhkan untuk operasi pasien, lalu mengirimkan notifikasi ke unit farmasi.</p>
        </div>
        <div class="card-panel p-6 bg-slate-50 border border-slate-200">
            <p class="text-sm font-semibold text-slate-700">Unit Farmasi</p>
            <p class="mt-3 text-slate-600">Memvalidasi dan menyiapkan informasi paket obat sesuai permintaan, sehingga logistik obat terkendali.</p>
        </div>
    </div>

    <div class="card-panel p-6">
        <div class="flex items-center gap-4">
            <div class="rounded-3xl bg-white p-4 text-emerald-600 shadow-sm">
                <i class="fa-solid fa-circle-info text-2xl"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-emerald-700">Informasi untuk pasien</p>
                <p class="text-sm text-slate-600">Halaman ini menampilkan alur layanan yang terintegrasi. Pasien dapat menggunakan notifikasi dan informasi jadwal tanpa harus login.</p>
            </div>
        </div>
    </div>
</div>
@endsection
