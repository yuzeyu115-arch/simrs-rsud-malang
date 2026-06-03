@extends('layouts.app')

@section('title','Ubah Kata Sandi')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h1 class="text-xl font-bold mb-4">Ubah Kata Sandi</h1>
        <form action="{{ route('profile.password') }}" method="POST">
            @csrf
            <div class="grid gap-4">
                <div>
                    <label class="block text-sm font-semibold">Kata Sandi Baru</label>
                    <input type="password" name="password" class="w-full border rounded px-3 py-2" required minlength="6" />
                </div>
                <div>
                    <label class="block text-sm font-semibold">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required />
                </div>
                <div class="flex justify-end">
                    <a href="{{ route('profile') }}" class="px-4 py-2 rounded border mr-2">Batal</a>
                    <button type="submit" class="px-4 py-2 rounded bg-emerald-600 text-white">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
