@extends('layouts.app')

@section('title','Pengaturan Edit Profil')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Pengaturan Profil</p>
            <h1 class="text-4xl font-bold text-slate-900">Edit Profil Pengguna</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Kelola informasi pribadi dan detail akun Anda dengan mudah.</p>
        </div>
        <a href="{{ route('profile') }}" class="btn-secondary">Kembali ke Profil</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-[320px_minmax(0,1fr)]">
        <div class="card-panel p-6 text-center">
            <div class="mx-auto mb-6 flex h-28 w-28 items-center justify-center rounded-full bg-gradient-to-br from-emerald-600 to-emerald-700 text-4xl font-black text-white shadow-lg">
                {{ strtoupper(substr($user->name ?? 'P', 0, 1)) }}
            </div>
            <p class="text-base font-semibold text-slate-900">{{ $user->name ?? 'Pengguna' }}</p>
            <p class="text-sm text-slate-500 mt-1">{{ $user->role ?? 'Tenaga Medis' }}</p>
            <div class="mt-6 space-y-3">
                <button type="button" class="btn-secondary w-full">Ubah Foto Profil</button>
            </div>
            <div class="mt-8 rounded-3xl bg-slate-50 p-5 text-left text-sm text-slate-600">
                <p class="font-semibold text-slate-900">Member Sejak</p>
                <p class="mt-2">{{ $user->created_at?->format('d M Y') ?? 'Belum tersedia' }}</p>
            </div>
        </div>

        <div class="card-panel p-6">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Informasi Data Diri</h2>
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama</label>
                    <input name="name" type="text" value="{{ $user->name ?? '' }}" class="input-base">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input name="email" type="email" value="{{ $user->email ?? '' }}" class="input-base">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Telepon</label>
                    <input name="phone" type="text" value="{{ $user->phone ?? '' }}" class="input-base">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tentang</label>
                    <textarea name="bio" rows="4" class="input-base resize-none">{{ $user->bio ?? '' }}</textarea>
                </div>
                <div class="flex flex-wrap gap-3 pt-4">
                    <a href="{{ route('profile') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
