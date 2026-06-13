@extends('layouts.app')

@section('title','Profil Pengguna')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500">Akun Anda</p>
            <h1 class="text-3xl font-bold text-slate-900">Profil Pengguna</h1>
            <p class="text-sm text-slate-600 mt-2">Kelola informasi pribadi dan akses akun Anda.</p>
        </div>
        <a href="{{ url('/dashboard') }}" class="btn-secondary">Kembali</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-[320px_minmax(0,1fr)]">
        <div class="card-panel p-6 text-center">
            @php
                $displayName = $user->name ?? auth()->user()->name ?? 'Pengguna';
                $initials = collect(explode(' ', trim($displayName)))->map(fn($part) => strtoupper(substr($part, 0, 1)))->join('');
            @endphp
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-emerald-600 to-emerald-700 text-3xl font-black text-white shadow-lg">{{ $initials }}</div>
            <h2 class="mt-5 text-xl font-bold text-slate-900">{{ $displayName }}</h2>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-500 mt-2">{{ $user->role ?? auth()->user()->role ?? 'Tenaga Medis' }}</p>
            <div class="mt-6 space-y-3">
                <a href="{{ route('profile.edit') }}" class="block btn-primary">Edit Profil</a>
                <a href="{{ route('profile.password.form') }}" class="block btn-secondary">Ubah Password</a>
            </div>
            <div class="mt-8 rounded-3xl bg-slate-50 p-5 text-left text-sm text-slate-600">
                <p class="font-semibold text-slate-900">Akses Terakhir</p>
                <p class="mt-2">{{ $user->last_login_at?->format('d M Y H:i') ?? 'Belum tersedia' }}</p>
                <p class="mt-1 text-xs text-slate-500">Lokasi: {{ $user->last_login_ip ?? 'Tidak tersedia' }}</p>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900 mb-5">Informasi Pribadi</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 mb-2">Email</p>
                        <p class="text-sm text-slate-700">{{ $user->email ?? auth()->user()->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 mb-2">Username</p>
                        <p class="text-sm text-slate-700">{{ $user->username ?? auth()->user()->username ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 mb-2">Spesialisasi</p>
                        <p class="text-sm text-slate-700">{{ $user->spesialisasi ?? auth()->user()->spesialisasi ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 mb-2">Telepon</p>
                        <p class="text-sm text-slate-700">{{ $user->phone ?? auth()->user()->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900 mb-3">Tentang Anda</h2>
                <p class="text-sm leading-relaxed text-slate-600">{{ $user->bio ?? auth()->user()->bio ?? 'Belum ada deskripsi.' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
