@extends('layouts.app')

@section('title','Edit Profil')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h1 class="text-xl font-bold mb-4">Edit Profil</h1>
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="grid gap-4">
                <div>
                    <label class="block text-sm font-semibold">Nama</label>
                    <input type="text" name="name" value="{{ $user->name ?? '' }}" class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-semibold">Email</label>
                    <input type="email" name="email" value="{{ $user->email ?? '' }}" class="w-full border rounded px-3 py-2" />
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
