@extends('layouts.app')

@section('title','Pengaturan Edit Profil')

@section('content')
<div class="space-y-8">
        <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Pengaturan Akun</p>
                <h1 class="text-4xl font-bold text-slate-900">Edit Profil</h1>
                <p class="mt-2 text-sm text-slate-600 max-w-2xl">Perbarui informasi profil Anda dalam satu tampilan yang rapi dan mudah digulir.</p>
            </div>
            <a href="{{ route('profile') }}" class="btn-secondary">Kembali ke Profil</a>
        </div>

        <div class="card-panel p-6">
            <div class="grid gap-6 xl:grid-cols-[320px_minmax(0,1fr)]">
                <div class="space-y-6">
                    <div class="rounded-[1.75rem] bg-slate-100 p-6 text-center">
                        <div class="mx-auto mb-4 flex h-28 w-28 items-center justify-center rounded-full bg-white text-5xl text-slate-500 overflow-hidden">
                            @if(isset($user->avatar) && $user->avatar)
                                <img src="{{ asset($user->avatar) }}" alt="avatar" class="h-full w-full object-cover">
                            @else
                                {{ strtoupper(substr($user->name ?? 'P', 0, 1)) }}
                            @endif
                        </div>
                        <p class="text-lg font-semibold text-slate-900">{{ $user->name ?? 'Dr. Pengguna' }}</p>
                        <p class="text-sm text-slate-500">{{ ucfirst($user->role ?? 'Tenaga Medis') }}</p>
                    </div>

                    <div class="rounded-[1.75rem] bg-emerald-50 p-6">
                        <h2 class="text-lg font-bold text-slate-900 mb-3">Profil Ringkas</h2>
                        <p class="text-sm text-slate-600">Form ini memungkinkan Anda memperbarui nama, email, telepon, spesialisasi, dan bio dalam satu halaman.</p>
                    </div>

                    <div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-semibold text-slate-700">Member Sejak</p>
                        <p class="mt-2 text-slate-600">{{ $user->created_at?->format('d M Y') ?? 'Tidak tersedia' }}</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-bold text-slate-900 mb-5">Informasi Pribadi</h2>
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                            @csrf
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                                <input name="name" type="text" value="{{ $user->name ?? '' }}" class="input-base" />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                                <input name="email" type="email" value="{{ $user->email ?? '' }}" class="input-base" />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Spesialisasi</label>
                                <input name="spesialisasi" type="text" value="{{ $user->spesialisasi ?? '' }}" class="input-base" />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Telepon</label>
                                <input name="phone" type="text" value="{{ $user->phone ?? '' }}" class="input-base" />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Bio Singkat</label>
                                <textarea name="bio" rows="4" class="input-base resize-none">{{ $user->bio ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Unggah Foto Profil</label>
                                <input type="file" name="avatar" accept="image/*" class="input-base" />
                            </div>
                            <div class="flex flex-wrap gap-3 pt-3">
                                <button type="submit" class="btn-primary">Simpan</button>
                                <button type="submit" name="action" value="delete_avatar" class="btn-secondary">Hapus Foto</button>
                                <button id="openPasswordModal" type="button" class="btn-secondary sm:ml-auto">Ubah Kata Sandi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="passwordModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
            <div class="w-full max-w-md rounded-[1.75rem] bg-white p-6 shadow-xl">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Ubah Kata Sandi</h3>
                        <p class="text-sm text-slate-500">Perbarui kata sandi akun Anda untuk keamanan lebih baik.</p>
                    </div>
                    <button id="closePasswordModal" class="text-slate-500 hover:text-slate-700">×</button>
                </div>
                <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password" class="input-base w-full" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi Baru</label>
                        <input type="password" name="password" class="input-base w-full" required minlength="6">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" class="input-base w-full" required>
                    </div>
                    <div class="flex justify-end gap-3 pt-3">
                        <button type="button" id="closePasswordModal2" class="btn-secondary">Batal</button>
                        <button type="submit" class="btn-primary">Simpan Kata Sandi</button>
                    </div>
                </form>
            </div>
        </div>
</div>

<script>
    (function() {
        const openBtn = document.getElementById('openPasswordModal');
        const closeBtn = document.getElementById('closePasswordModal');
        const closeBtn2 = document.getElementById('closePasswordModal2');
        const modal = document.getElementById('passwordModal');
        function open() { modal.classList.remove('hidden'); modal.classList.add('flex'); }
        function close() { modal.classList.remove('flex'); modal.classList.add('hidden'); }
        openBtn?.addEventListener('click', open);
        closeBtn?.addEventListener('click', close);
        closeBtn2?.addEventListener('click', close);
        modal?.addEventListener('click', function(e){ if (e.target === modal) close(); });
        document.addEventListener('keydown', function(e){ if(e.key === 'Escape') close(); });
    })();
</script>
@endsection
