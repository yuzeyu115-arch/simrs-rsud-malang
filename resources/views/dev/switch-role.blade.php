@extends('layouts.app')

@section('title','Dev: Switch Role')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div class="card-panel p-6">
            <h1 class="text-2xl font-bold mb-4">Dev: Quick Switch Role</h1>
            @if(session('error'))
                <div class="text-red-600 font-bold mb-3">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl p-4 mb-3">{{ session('success') }}</div>
            @endif
            <p class="text-sm text-slate-600 mb-5">Klik role untuk langsung login sebagai akun contoh. Jika user belum ada di database, akan dibuat otomatis.</p>
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @php
                    $staticRoles = [
                        ['label' => 'DPJB', 'username' => 'DPJB', 'password' => 'SimrsRSUD!'],
                        ['label' => 'Admin', 'username' => 'AdminRSUD', 'password' => 'SimrsRSUD!'],
                        ['label' => 'TPP', 'username' => 'TPP', 'password' => 'SimrsRSUD!'],
                        ['label' => 'KPP', 'username' => 'KPP', 'password' => 'SimrsRSUD!'],
                        ['label' => 'Unit Farmasi', 'username' => 'Farmasi', 'password' => 'SimrsRSUD!'],
                        ['label' => 'Perawat Anestesi', 'username' => 'KepAnes', 'password' => 'SimrsRSUD!'],
                    ];
                @endphp

                @foreach($staticRoles as $r)
                    <div class="border border-slate-200 rounded-3xl p-5 bg-slate-50">
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500 mb-3">{{ $r['label'] }}</p>
                        <p class="text-sm text-slate-700"><strong>Username:</strong> {{ $r['username'] }}</p>
                        <p class="text-sm text-slate-700 mb-4"><strong>Password:</strong> {{ $r['password'] }}</p>
                        <a href="/dev/login-as/{{ $r['username'] }}" class="btn-primary w-full justify-center">Login sebagai {{ $r['label'] }}</a>
                    </div>
                @endforeach
            </div>
            <p class="text-xs text-slate-400 mt-5">Hanya gunakan di lingkungan dev/local. Jika tampilan ini tidak diperlukan di produksi, hapus rute /dev.</p>
        </div>
    </div>
@endsection