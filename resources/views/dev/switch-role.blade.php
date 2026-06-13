@extends('layouts.app')

@section('title','Dev: Switch Role')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="card-panel p-6">
            <h1 class="text-xl font-bold mb-4">Dev: Quick Switch Role</h1>
            @if(session('error'))
                <div class="text-red-600 font-bold mb-3">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="text-green-600 font-bold mb-3">{{ session('success') }}</div>
            @endif
            <p class="text-sm text-slate-600 mb-4">Klik username untuk langsung login sebagai user contoh (dibuat oleh seeder).</p>
            <div class="grid grid-cols-2 gap-3">
                @foreach($roles as $r)
                    <a href="/dev/login-as/{{ $r }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm hover:bg-slate-100">Login as {{ $r }}</a>
                @endforeach
            </div>
            <p class="text-xs text-slate-400 mt-4">Hanya gunakan di lingkungan dev/local.</p>
        </div>
    </div>
@endsection