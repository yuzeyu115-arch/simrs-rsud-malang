@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-6 py-4 text-sm font-semibold text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6 xl:grid-cols-[1.3fr_0.9fr]">
        <div class="card-panel p-6">
            <div class="flex items-center justify-between gap-4 mb-6">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Pengguna</p>
                    <h2 class="text-2xl font-semibold text-slate-900">Daftar Pengguna</h2>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left">
                    <thead class="bg-slate-50 text-sm font-semibold uppercase tracking-wide text-slate-600">
                        <tr>
                            <th class="p-4">#</th>
                            <th class="p-4">Nama</th>
                            <th class="p-4">Username</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Role</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($users as $index => $u)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-4 font-semibold text-slate-400">{{ $index + 1 }}</td>
                                <td class="p-4 font-semibold text-slate-800">{{ $u->name }}</td>
                                <td class="p-4">{{ $u->username }}</td>
                                <td class="p-4">{{ $u->email ?? '-' }}</td>
                                <td class="p-4">
                                    <span class="inline-flex items-center rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">{{ ucfirst($u->role) }}</span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-2">
                                        <a href="{{ route('pengguna.edit', $u->id) }}" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form action="{{ route('pengguna.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-red-50 text-red-600 hover:bg-red-100 transition">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6 text-center text-slate-500">Belum ada pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-panel p-6">
            <div class="mb-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Form</p>
                <h2 class="text-2xl font-semibold text-slate-900">{{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h2>
            </div>

            @php
                $userAction = isset($user)
                    ? route('pengguna.update', $user->id)
                    : route('pengguna.store');
            @endphp

            <form action="{{ $userAction }}" method="POST" class="space-y-4">
                @csrf
                @if(isset($user))
                    @method('PUT')
                @endif

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Nama Lengkap *</label>
                    <input name="name" value="{{ old('name', $user->name ?? '') }}" type="text" class="input-base" placeholder="Masukkan nama lengkap">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Username *</label>
                    <input name="username" value="{{ old('username', $user->username ?? '') }}" type="text" class="input-base" placeholder="Masukkan username">
                    @error('username') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input name="email" value="{{ old('email', $user->email ?? '') }}" type="email" class="input-base" placeholder="Masukkan email">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">{{ isset($user) ? 'Password (Kosongkan jika tidak diubah)' : 'Password *' }}</label>
                    <input name="password" type="password" class="input-base" placeholder="Masukkan password" {{ !isset($user) ? 'required' : '' }}>
                    @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Role *</label>
                    <select name="role" class="input-base">
                        <option value="">Pilih Role</option>
                        <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="dokter" {{ old('role', $user->role ?? '') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                        <option value="perawat" {{ old('role', $user->role ?? '') == 'perawat' ? 'selected' : '' }}>Perawat</option>
                        <option value="farmasi" {{ old('role', $user->role ?? '') == 'farmasi' ? 'selected' : '' }}>Farmasi</option>
                        <option value="logistik" {{ old('role', $user->role ?? '') == 'logistik' ? 'selected' : '' }}>Logistik</option>
                    </select>
                    @error('role') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    @if(isset($user))
                        <a href="{{ route('pengguna') }}" class="btn-secondary">Batal</a>
                    @endif
                    <button type="submit" class="btn-primary">
                        {{ isset($user) ? 'Perbarui' : 'Tambah' }} Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
