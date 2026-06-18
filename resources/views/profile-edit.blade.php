@extends('layouts.app')

@section('title','Pengaturan Edit Profil')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">Pengaturan</p>
            <h1 class="text-2xl font-bold text-slate-900">Pengaturan Edit Profil</h1>
        </div>
        <a href="{{ route('profile') }}" class="inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-4 py-2 text-sm shadow-sm">Kembali</a>
    </div>

    <div class="rounded-lg bg-emerald-50 p-6">
        <div class="grid gap-6 lg:grid-cols-[320px_minmax(0,1fr)]">
            <div class="p-6">
                <p class="text-lg font-bold text-slate-900">{{ $user->name ?? 'dr. xxxxxx' }}</p>
                <p class="text-sm text-slate-600">{{ $user->role ?? 'Tenaga Medis' }}</p>

                <div class="mt-6 bg-white rounded-lg p-6 shadow-sm">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="flex flex-col items-center">
                            <div class="h-24 w-24 rounded-full bg-slate-100 flex items-center justify-center text-2xl text-slate-400 overflow-hidden">
                                @if(isset($user->avatar) && $user->avatar)
                                    <img src="{{ asset($user->avatar) }}" alt="avatar" class="h-full w-full object-cover">
                                @else
                                    {{ strtoupper(substr($user->name ?? 'P', 0, 1)) }}
                                @endif
                            </div>
                            <label class="mt-3 text-xs text-slate-500">Klik untuk mengunggah foto baru (maks 2mb)</label>
                            <input type="file" name="avatar" accept="image/*" class="mt-3">
                        </div>

                        <div class="flex flex-col gap-3">
                            <button type="submit" name="action" value="save_avatar" class="btn-primary">Simpan Foto</button>
                            <button type="submit" name="action" value="delete_avatar" class="btn-secondary">Hapus Foto</button>
                        </div>
                    </form>
                </div>

                <div class="mt-6 rounded-md bg-white p-4 shadow-sm text-sm">
                    <p class="font-semibold text-slate-700">Member Sejak</p>
                    <p class="text-slate-600">{{ $user->created_at?->format('d M Y') ?? 'Belum tersedia' }}</p>
                </div>
            </div>

            <div class="p-6">
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Informasi Data Diri</h2>
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2">NAMA</label>
                            <input name="name" type="text" value="{{ $user->name ?? '' }}" class="input-base border-2 border-emerald-200 focus:border-emerald-500 rounded-md" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2">EMAIL</label>
                            <input name="email" type="email" value="{{ $user->email ?? '' }}" class="input-base border-2 border-emerald-200 focus:border-emerald-500 rounded-md" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2">SPESIALISASI</label>
                            <input name="spesialisasi" type="text" value="{{ $user->spesialisasi ?? '' }}" class="input-base border-2 border-emerald-200 focus:border-emerald-500 rounded-md" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2">TELEPON</label>
                            <input name="phone" type="text" value="{{ $user->phone ?? '' }}" class="input-base border-2 border-emerald-200 focus:border-emerald-500 rounded-md" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2">TENTANG</label>
                            <textarea name="bio" rows="4" class="input-base resize-none bg-emerald-50 border-2 border-emerald-100 rounded-md">{{ $user->bio ?? '' }}</textarea>
                        </div>

                        <div class="flex items-center gap-3 pt-3">
                            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-md bg-emerald-700 px-4 py-2 text-white">Simpan</button>
                            <button type="button" class="inline-flex items-center justify-center gap-2 rounded-md border border-emerald-700 px-4 py-2 text-emerald-700 bg-white">Hapus</button>
                            <a href="{{ route('profile.password.form') }}" class="ml-auto inline-flex items-center justify-center gap-2 rounded-md border border-emerald-300 px-4 py-2 text-emerald-700 bg-white">Ubah Kata Sandi</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
