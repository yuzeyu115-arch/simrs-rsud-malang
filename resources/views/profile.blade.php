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
                $displayName = $user->name ?? auth()->user()?->name ?? 'Pengguna';
                $initials = collect(explode(' ', trim($displayName)))->map(fn($part) => strtoupper(substr($part, 0, 1)))->join('');
            @endphp
            <div class="mx-auto flex h-20 w-20 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-emerald-600 to-emerald-700 text-3xl font-black text-white shadow-lg">
                @if(! empty($user->avatar))
                    <img src="{{ asset($user->avatar) }}" alt="Foto profil" class="h-full w-full object-cover">
                @else
                    {{ $initials }}
                @endif
            </div>
            <h2 class="mt-5 text-xl font-bold text-slate-900">{{ $displayName }}</h2>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-500 mt-2">{{ $user->role ?? auth()->user()?->role ?? 'Tenaga Medis' }}</p>
            <div class="mt-6 space-y-3">
                <button type="button" id="openProfileEditModal" class="block w-full btn-primary">Edit Profil</button>
                <button type="button" id="openPasswordModal" class="block w-full btn-secondary">Ubah Password</button>
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
                        <p class="text-sm text-slate-700">{{ $user->email ?? auth()->user()?->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 mb-2">Username</p>
                        <p class="text-sm text-slate-700">{{ $user->username ?? auth()->user()?->username ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 mb-2">Spesialisasi</p>
                        <p class="text-sm text-slate-700">{{ $user->spesialisasi ?? auth()->user()?->spesialisasi ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 mb-2">Telepon</p>
                        <p class="text-sm text-slate-700">{{ $user->phone ?? auth()->user()?->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900 mb-3">Tentang Anda</h2>
                <p class="text-sm leading-relaxed text-slate-600">{{ $user->bio ?? auth()->user()?->bio ?? 'Belum ada deskripsi.' }}</p>
            </div>
        </div>
    </div>
</div>

<div id="profileEditModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/50 p-4 backdrop-blur-sm">
    <div class="w-full max-w-3xl rounded-[1.75rem] bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between gap-3 border-b border-slate-200 pb-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Pengaturan Akun</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-900">Edit Profil</h2>
            </div>
            <button type="button" id="closeProfileEditModal" class="rounded-full border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-600">Tutup</button>
        </div>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-5 space-y-4">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                    <input name="name" type="text" value="{{ $user->name ?? auth()->user()?->name ?? '' }}" class="input-base" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input name="email" type="email" value="{{ $user->email ?? auth()->user()?->email ?? '' }}" class="input-base" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Spesialisasi</label>
                    <input name="spesialisasi" type="text" value="{{ $user->spesialisasi ?? auth()->user()?->spesialisasi ?? '' }}" class="input-base" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Telepon</label>
                    <input name="phone" type="text" value="{{ $user->phone ?? auth()->user()?->phone ?? '' }}" class="input-base" />
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Bio Singkat</label>
                    <textarea name="bio" rows="4" class="input-base resize-none">{{ $user->bio ?? auth()->user()?->bio ?? '' }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Unggah Foto Profil</label>
                    <input type="file" name="avatar" accept="image/*" class="input-base" />
                </div>
            </div>
            <div class="flex flex-wrap justify-end gap-3 pt-2">
                <button type="button" id="closeProfileEditModal2" class="btn-secondary">Batal</button>
                <button type="submit" class="btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="passwordModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/50 p-4 backdrop-blur-sm">
    <div class="w-full max-w-lg rounded-[1.75rem] bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between gap-3 border-b border-slate-200 pb-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Keamanan Akun</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-900">Ubah Kata Sandi</h2>
            </div>
            <button type="button" id="closePasswordModal" class="rounded-full border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-600">Tutup</button>
        </div>
        <form action="{{ route('profile.password') }}" method="POST" class="mt-5 space-y-4">
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
            <div class="flex flex-wrap justify-end gap-3 pt-2">
                <button type="button" id="closePasswordModal2" class="btn-secondary">Batal</button>
                <button type="submit" class="btn-primary">Simpan Kata Sandi</button>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        const profileEditModal = document.getElementById('profileEditModal');
        const openProfileEditBtn = document.getElementById('openProfileEditModal');
        const closeProfileEditBtn = document.getElementById('closeProfileEditModal');
        const closeProfileEditBtn2 = document.getElementById('closeProfileEditModal2');

        const passwordModal = document.getElementById('passwordModal');
        const openPasswordBtn = document.getElementById('openPasswordModal');
        const closePasswordBtn = document.getElementById('closePasswordModal');
        const closePasswordBtn2 = document.getElementById('closePasswordModal2');

        const openModal = (modal) => {
            if (!modal) return;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        };

        const closeModal = (modal) => {
            if (!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        };

        openProfileEditBtn?.addEventListener('click', () => openModal(profileEditModal));
        closeProfileEditBtn?.addEventListener('click', () => closeModal(profileEditModal));
        closeProfileEditBtn2?.addEventListener('click', () => closeModal(profileEditModal));
        profileEditModal?.addEventListener('click', (event) => {
            if (event.target === profileEditModal) closeModal(profileEditModal);
        });

        openPasswordBtn?.addEventListener('click', () => openModal(passwordModal));
        closePasswordBtn?.addEventListener('click', () => closeModal(passwordModal));
        closePasswordBtn2?.addEventListener('click', () => closeModal(passwordModal));
        passwordModal?.addEventListener('click', (event) => {
            if (event.target === passwordModal) closeModal(passwordModal);
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeModal(profileEditModal);
                closeModal(passwordModal);
            }
        });
    })();
</script>

@endsection
