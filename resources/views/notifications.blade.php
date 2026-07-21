@extends('layouts.app')

@section('title','Notifikasi')

@section('content')
@php
    $surgeryCount = $notifications->filter(fn($item) => str_contains(strtolower($item->judul.' '.$item->pesan), 'operasi'))->count();
    $medicineCount = $notifications->filter(fn($item) => str_contains(strtolower($item->judul.' '.$item->pesan), 'paket') || str_contains(strtolower($item->judul.' '.$item->pesan), 'obat'))->count();
    $unreadCount = $notifications->where('is_read', false)->count();
@endphp

<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Pusat Notifikasi</p>
            <h1 class="text-4xl font-bold text-slate-900">Notifikasi</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Cek pemberitahuan jadwal operasi, finalisasi KPP, dan paket obat dari Unit Farmasi.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('dashboard') }}" class="btn-secondary"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
            <a href="{{ route('notifications.create') }}" class="btn-primary"><i class="fas fa-plus mr-2"></i>Tambah</a>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-3xl border border-emerald-100 bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
    @endif

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Total</p>
            <p class="mt-4 text-4xl font-black text-slate-900">{{ $notifications->count() }}</p>
            <p class="mt-3 text-sm text-slate-500">notifikasi tampil</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Belum Dibaca</p>
            <p class="mt-4 text-4xl font-black text-rose-700">{{ $unreadCount }}</p>
            <p class="mt-3 text-sm text-slate-500">butuh pengecekan</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Jadwal Operasi</p>
            <p class="mt-4 text-4xl font-black text-emerald-700">{{ $surgeryCount }}</p>
            <p class="mt-3 text-sm text-slate-500">pembaruan operasi</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Paket Obat</p>
            <p class="mt-4 text-4xl font-black text-sky-700">{{ $medicineCount }}</p>
            <p class="mt-3 text-sm text-slate-500">pembaruan farmasi</p>
        </div>
    </div>

    @if(isset($mode) && ($mode === 'create' || $mode === 'edit'))
        <div class="card-panel p-6">
            <div class="flex items-center justify-between gap-4 mb-5">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">{{ $mode === 'create' ? 'Tambah Notifikasi' : 'Edit Notifikasi' }}</h2>
                    <p class="text-sm text-slate-500 mt-1">{{ $mode === 'create' ? 'Buat pemberitahuan baru.' : 'Perbarui isi pemberitahuan.' }}</p>
                </div>
                <a href="{{ route('notifications') }}" class="btn-secondary">Batal</a>
            </div>
            <form action="{{ $mode === 'create' ? route('notifications.store') : route('notifications.update', $notification->id) }}" method="POST" class="grid gap-4">
                @csrf
                @if($mode === 'edit') @method('PUT') @endif
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-2">Judul</label>
                    <input name="judul" type="text" value="{{ old('judul', $notification->judul ?? '') }}" class="input-base" placeholder="Judul notifikasi">
                    @error('judul')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-2">Pesan</label>
                    <textarea name="pesan" rows="3" class="input-base" placeholder="Isi pesan notifikasi">{{ old('pesan', $notification->pesan ?? '') }}</textarea>
                    @error('pesan')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-2">Tipe</label>
                    <select name="tipe" class="input-base">
                        <option value="Info" {{ old('tipe', $notification->tipe ?? '') === 'Info' ? 'selected' : '' }}>Info</option>
                        <option value="Warning" {{ old('tipe', $notification->tipe ?? '') === 'Warning' ? 'selected' : '' }}>Warning</option>
                        <option value="Danger" {{ old('tipe', $notification->tipe ?? '') === 'Danger' ? 'selected' : '' }}>Danger</option>
                    </select>
                    @error('tipe')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="flex justify-end gap-3">
                    <button type="submit" class="btn-primary">{{ $mode === 'create' ? 'Simpan' : 'Perbarui' }}</button>
                </div>
            </form>
        </div>
    @endif

    <div class="card-panel p-6">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Daftar Notifikasi</h2>
                <p class="text-sm text-slate-500 mt-1">Urutan terbaru berada di atas.</p>
            </div>
        </div>

        <div class="grid gap-4">
            @forelse($notifications as $notificationItem)
                @php
                    $typeClass = match($notificationItem->tipe) {
                        'Danger' => 'bg-rose-50 text-rose-700',
                        'Warning' => 'bg-amber-50 text-amber-700',
                        default => 'bg-sky-50 text-sky-700',
                    };
                @endphp
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $typeClass }}">{{ $notificationItem->tipe }}</span>
                                @if(! $notificationItem->is_read)
                                    <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">Baru</span>
                                @endif
                                <span class="text-xs text-slate-400">{{ date('d M Y H:i', strtotime($notificationItem->created_at)) }}</span>
                            </div>
                            <h3 class="mt-3 text-lg font-bold text-slate-900">{{ $notificationItem->judul }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $notificationItem->pesan }}</p>
                        </div>
                        <div class="flex flex-wrap gap-2 lg:justify-end">
                            @if(! $notificationItem->is_read)
                                <form action="{{ route('notifications.read', $notificationItem->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="rounded-2xl border border-emerald-200 bg-white px-3 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-50 transition">Dibaca</button>
                                </form>
                            @endif
                            <a href="{{ route('notifications.edit', $notificationItem->id) }}" class="rounded-2xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-sky-700 hover:bg-sky-50 transition">Edit</a>
                            <form action="{{ route('notifications.destroy', $notificationItem->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus notifikasi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-2xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50 transition">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-12 text-center text-slate-500">
                    <i class="fas fa-inbox text-3xl"></i>
                    <p class="mt-3 text-sm">Belum ada notifikasi.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
