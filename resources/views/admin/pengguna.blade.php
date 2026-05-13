<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - SimpleOK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4ee; }
    </style>
</head>
<body class="flex overflow-hidden h-screen">
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col flex-shrink-0 shadow-sm z-20">
        <div class="p-6 flex items-center space-x-3">
            <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center text-white shadow-md">
                <i class="fa-solid fa-hospital"></i>
            </div>
            <span class="text-xl font-bold text-gray-800">SimpleOK</span>
        </div>
        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-4 mb-2">MAIN</p>
            <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                <i class="fa-solid fa-house w-5"></i> <span>Dashboard</span>
            </a>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-6 mb-2">ADMIN</p>
            <a href="{{ route('pengguna') }}" class="flex items-center space-x-3 p-3 rounded-xl bg-green-50 text-green-700 font-bold text-sm">
                <i class="fa-solid fa-users w-5"></i> <span>Manajemen Pengguna</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 overflow-y-auto flex flex-col">
        <div class="sticky top-0 bg-white border-b border-gray-100 px-8 py-4 z-10 flex justify-between items-center">
            <h2 class="text-2xl font-black text-green-900">Manajemen Pengguna</h2>
        </div>

        <div class="p-8 flex-1 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl p-4 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form Add/Edit User -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-green-900 mb-4">{{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h3>
                
                @php
                    $userAction = isset($user)
                        ? route('pengguna.update', $user->id)
                        : route('pengguna.store');
                @endphp
                <form action="{{ $userAction }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap *</label>
                        <input name="name" value="{{ old('name', $user->name ?? '') }}" type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Username *</label>
                        <input name="username" value="{{ old('username', $user->username ?? '') }}" type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        @error('username') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                        <input name="email" value="{{ old('email', $user->email ?? '') }}" type="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">{{ isset($user) ? 'Password (Kosongkan jika tidak diubah)' : 'Password *' }}</label>
                        <input name="password" type="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" {{ !isset($user) ? 'required' : '' }}>
                        @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Role *</label>
                        <select name="role" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="dokter" {{ old('role', $user->role ?? '') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                            <option value="perawat" {{ old('role', $user->role ?? '') == 'perawat' ? 'selected' : '' }}>Perawat</option>
                            <option value="farmasi" {{ old('role', $user->role ?? '') == 'farmasi' ? 'selected' : '' }}>Farmasi</option>
                            <option value="gizi" {{ old('role', $user->role ?? '') == 'gizi' ? 'selected' : '' }}>Gizi</option>
                            <option value="logistik" {{ old('role', $user->role ?? '') == 'logistik' ? 'selected' : '' }}>Logistik</option>
                        </select>
                        @error('role') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2 flex justify-end gap-3">
                        @if(isset($user))
                            <a href="{{ route('pengguna') }}" class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50">Batal</a>
                        @endif
                        <button type="submit" class="px-6 py-2 rounded-lg bg-green-600 text-white font-bold hover:bg-green-700">
                            {{ isset($user) ? 'Perbarui' : 'Tambah' }} Pengguna
                        </button>
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-green-900">Daftar Pengguna</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-sm font-bold uppercase text-gray-600 tracking-widest border-b border-gray-100">
                            <tr>
                                <th class="p-4">#</th>
                                <th class="p-4">Nama</th>
                                <th class="p-4">Username</th>
                                <th class="p-4">Email</th>
                                <th class="p-4">Role</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                            @forelse($users as $index => $u)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-4 font-semibold text-gray-400">{{ $index + 1 }}</td>
                                    <td class="p-4 font-semibold">{{ $u->name }}</td>
                                    <td class="p-4">{{ $u->username }}</td>
                                    <td class="p-4">{{ $u->email ?? '-' }}</td>
                                    <td class="p-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">{{ ucfirst($u->role) }}</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('pengguna.edit', $u->id) }}" class="p-2 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 transition-all">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form action="{{ route('pengguna.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-all">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-500">Belum ada pengguna.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
