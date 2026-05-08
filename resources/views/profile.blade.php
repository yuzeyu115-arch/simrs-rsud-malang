<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - SIMRS RSUD Kota Malang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>tailwind.config = { theme: { extend: { colors: { 'primary-green': '#10b981' } } } }</script>
    <style>body { font-family: 'Inter', sans-serif; background-color:#f7f9f7; }</style>
</head>
<body class="bg-gray-50 flex overflow-hidden min-h-screen">

    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col flex-shrink-0 shadow-sm z-20">
        <div class="p-6 flex items-center space-x-3">
            <div class="w-8 h-8 bg-primary-green rounded-lg flex items-center justify-center text-white shadow-md">
                <i class="fa-solid fa-hospital"></i>
            </div>
            <span class="text-xl font-bold text-gray-800 tracking-tight">SIMRS</span>
        </div>
        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                <i class="fa-solid fa-house w-5"></i> <span>Dashboard</span>
            </a>
            <div class="mt-auto pt-10 px-3 pb-8">
                <a href="{{ url('/logout') }}" class="flex items-center space-x-3 text-red-500 font-bold text-sm hover:underline">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </nav>
    </aside>

    <main class="flex-1 overflow-y-auto">
        <div class="sticky top-0 bg-white/80 backdrop-blur-md border-b border-gray-100 px-8 py-4 z-10 flex justify-between items-center">
            <h2 class="text-2xl font-black text-[#1b5e20] tracking-tight">Profil Pengguna</h2>
            <div>
                <a href="{{ url('/dashboard') }}" class="text-sm text-gray-500 hover:underline">Kembali</a>
            </div>
        </div>

        <div class="p-8">
            <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <div class="bg-white rounded-xl border border-gray-100 p-6 text-center shadow-sm">
                        @php $displayName = isset($user->name) ? $user->name : (\Illuminate\Support\Facades\Auth::user()->name ?? 'Pengguna'); @endphp
                        <div class="w-24 h-24 rounded-full bg-primary-green flex items-center justify-center text-white text-2xl font-bold mx-auto">{{ strtoupper(substr($displayName,0,1)) }}</div>
                        <h3 class="text-lg font-bold text-gray-800 mt-4">{{ $displayName }}</h3>
                        <p class="text-xs text-gray-500 mt-2">{{ $user->role ?? (\Illuminate\Support\Facades\Auth::user()->role ?? 'Tenaga Medis') }}</p>
                        <div class="mt-6 space-y-2">
                            <a href="#" class="block px-4 py-2 rounded-xl bg-primary-green text-white font-bold hover:bg-primary-green-hover transition-all">Edit Profil</a>
                            <a href="#" class="block px-4 py-2 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition-all">Ubah Kata Sandi</a>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
                        <h4 class="text-lg font-bold text-gray-800 mb-4">Informasi Pribadi</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Email</p>
                                <p class="text-sm text-gray-700">{{ $user->email ?? (\Illuminate\Support\Facades\Auth::user()->email ?? '-') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Username</p>
                                <p class="text-sm text-gray-700">{{ $user->username ?? (\Illuminate\Support\Facades\Auth::user()->username ?? '-') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Spesialisasi</p>
                                <p class="text-sm text-gray-700">{{ $user->spesialisasi ?? (\Illuminate\Support\Facades\Auth::user()->spesialisasi ?? '-') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Telepon</p>
                                <p class="text-sm text-gray-700">{{ $user->phone ?? (\Illuminate\Support\Facades\Auth::user()->phone ?? '-') }}</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <h5 class="text-sm font-bold text-gray-800 mb-2">Tentang</h5>
                            <p class="text-sm text-gray-600">{{ $user->bio ?? (\Illuminate\Support\Facades\Auth::user()->bio ?? 'Tidak ada deskripsi.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

</body>
</html>
