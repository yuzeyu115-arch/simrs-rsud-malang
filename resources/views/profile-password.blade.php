@extends('layouts.app')

@section('title','Ubah Kata Sandi')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Keamanan Akun</p>
            <h1 class="text-4xl font-bold text-slate-900">Ubah Kata Sandi</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Perbarui kata sandi akun Anda untuk menjaga keamanan data pribadi.</p>
        </div>
        <a href="{{ route('profile') }}" class="btn-secondary">Kembali ke Profil</a>
    </div>

    <div class="mx-auto max-w-2xl">
        <div class="card-panel p-6">
            <form action="{{ route('profile.password') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi Saat Ini</label>
                <input type="password" name="current_password" class="input-base" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi Baru</label>
                <input type="password" name="password" class="input-base" required minlength="6">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="password_confirmation" class="input-base" required>
            </div>
            <div class="flex flex-wrap gap-3 pt-4">
                <a href="{{ route('profile') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Simpan Kata Sandi</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
