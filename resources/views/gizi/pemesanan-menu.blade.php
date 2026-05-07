<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Menu - SIMRS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-8 px-4">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Pemesanan Menu</h1>
            <p class="text-gray-600 mt-2">Kelola pemesanan menu untuk pasien rawat inap</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg p-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">{{ isset($menu) ? 'Edit Pemesanan' : 'Pemesanan Baru' }}</h2>
                    
                    @php
                        $action = isset($menu) ? route('pemesanan-menu.update', $menu->id) : route('pemesanan-menu.store');
                    @endphp
                    <form action="{{ $action }}" method="POST" class="space-y-4">
                        @csrf
                        @if(isset($menu)) @method('PUT') @endif

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Ruang *</label>
                            <input name="ruang" value="{{ old('ruang', $menu->ruang ?? '') }}" type="text" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Contoh: ICU 1">
                            @error('ruang') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas *</label>
                            <select name="kelas" class="w-full border border-gray-300 rounded px-3 py-2">
                                <option>Pilih Kelas</option>
                                <option value="VIP" {{ old('kelas', $menu->kelas ?? '') == 'VIP' ? 'selected' : '' }}>VIP</option>
                                <option value="Kelas 1" {{ old('kelas', $menu->kelas ?? '') == 'Kelas 1' ? 'selected' : '' }}>Kelas 1</option>
                                <option value="Kelas 2" {{ old('kelas', $menu->kelas ?? '') == 'Kelas 2' ? 'selected' : '' }}>Kelas 2</option>
                                <option value="Kelas 3" {{ old('kelas', $menu->kelas ?? '') == 'Kelas 3' ? 'selected' : '' }}>Kelas 3</option>
                            </select>
                            @error('kelas') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pasien *</label>
                            <input name="nama_pasien" value="{{ old('nama_pasien', $menu->nama_pasien ?? '') }}" type="text" class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('nama_pasien') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Shift *</label>
                            <select name="shift" class="w-full border border-gray-300 rounded px-3 py-2">
                                <option value="Pagi" {{ old('shift', $menu->shift ?? '') == 'Pagi' ? 'selected' : '' }}>Pagi</option>
                                <option value="Siang" {{ old('shift', $menu->shift ?? '') == 'Siang' ? 'selected' : '' }}>Siang</option>
                                <option value="Sore" {{ old('shift', $menu->shift ?? '') == 'Sore' ? 'selected' : '' }}>Sore</option>
                            </select>
                            @error('shift') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal *</label>
                            <input name="tanggal" value="{{ old('tanggal', $menu->tanggal ?? '') }}" type="date" class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('tanggal') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan</label>
                            <textarea name="catatan" class="w-full border border-gray-300 rounded px-3 py-2 h-20">{{ old('catatan', $menu->catatan ?? '') }}</textarea>
                        </div>

                        <div class="flex gap-2">
                            @if(isset($menu))
                                <a href="{{ route('pemesanan-menu') }}" class="flex-1 text-center px-4 py-2 border border-gray-300 rounded text-gray-700 font-semibold hover:bg-gray-50">Batal</a>
                            @endif
                            <button type="submit" class="flex-1 px-4 py-2 bg-green-600 text-white rounded font-semibold hover:bg-green-700">
                                {{ isset($menu) ? 'Perbarui' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800">Daftar Pemesanan</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">#</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Pasien</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Ruang</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Shift</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($menus as $index => $m)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 font-semibold">{{ $m->nama_pasien }}</td>
                                        <td class="px-4 py-3">{{ $m->ruang }}</td>
                                        <td class="px-4 py-3"><span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">{{ $m->shift }}</span></td>
                                        <td class="px-4 py-3">{{ date('d/m/Y', strtotime($m->tanggal)) }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('pemesanan-menu.edit', $m->id) }}" class="p-2 text-green-600 hover:bg-green-50 rounded">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <form action="{{ route('pemesanan-menu.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">Belum ada pemesanan menu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
