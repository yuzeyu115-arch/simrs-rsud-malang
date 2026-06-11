<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Tempat Tidur - RSUD Kota Malang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Tempat Tidur</h1>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg p-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">{{ isset($bed) ? 'Edit Tempat Tidur' : 'Tambah Tempat Tidur' }}</h2>
                    
                    @php
                        $action = isset($bed) ? route('bed-manager.update', $bed->id) : route('bed-manager.store');
                    @endphp
                    <form action="{{ $action }}" method="POST" class="space-y-4">
                        @csrf
                        @if(isset($bed)) @method('PUT') @endif

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Gedung *</label>
                            <input name="gedung" value="{{ old('gedung', $bed->gedung ?? '') }}" type="text" class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('gedung') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Lantai *</label>
                            <input name="lantai" value="{{ old('lantai', $bed->lantai ?? '') }}" type="text" class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('lantai') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Ruangan *</label>
                            <input name="ruangan" value="{{ old('ruangan', $bed->ruangan ?? '') }}" type="text" class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('ruangan') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">No. Bed *</label>
                            <input name="no_bed" value="{{ old('no_bed', $bed->no_bed ?? '') }}" type="text" class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('no_bed') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kamar *</label>
                            <select name="jenis_kamar" class="w-full border border-gray-300 rounded px-3 py-2">
                                <option value="">Pilih Jenis</option>
                                <option value="VIP" {{ old('jenis_kamar', $bed->jenis_kamar ?? '') == 'VIP' ? 'selected' : '' }}>VIP</option>
                                <option value="Kelas 1" {{ old('jenis_kamar', $bed->jenis_kamar ?? '') == 'Kelas 1' ? 'selected' : '' }}>Kelas 1</option>
                                <option value="Kelas 2" {{ old('jenis_kamar', $bed->jenis_kamar ?? '') == 'Kelas 2' ? 'selected' : '' }}>Kelas 2</option>
                                <option value="Kelas 3" {{ old('jenis_kamar', $bed->jenis_kamar ?? '') == 'Kelas 3' ? 'selected' : '' }}>Kelas 3</option>
                            </select>
                            @error('jenis_kamar') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        @if(isset($bed))
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full border border-gray-300 rounded px-3 py-2">
                                <option value="Tersedia" {{ old('status', $bed->status ?? '') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Terisi" {{ old('status', $bed->status ?? '') == 'Terisi' ? 'selected' : '' }}>Terisi</option>
                                <option value="Booking" {{ old('status', $bed->status ?? '') == 'Booking' ? 'selected' : '' }}>Booking</option>
                                <option value="Maintenance" {{ old('status', $bed->status ?? '') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pasien</label>
                            <input name="nama_pasien" value="{{ old('nama_pasien', $bed->nama_pasien ?? '') }}" type="text" class="w-full border border-gray-300 rounded px-3 py-2">
                        </div>
                        @endif

                        <div class="flex gap-2">
                            @if(isset($bed))
                                <a href="{{ route('bed-manager-list') }}" class="flex-1 text-center px-4 py-2 border border-gray-300 rounded text-gray-700 font-semibold hover:bg-gray-50">Batal</a>
                            @endif
                            <button type="submit" class="flex-1 px-4 py-2 bg-green-600 text-white rounded font-semibold hover:bg-green-700">
                                {{ isset($bed) ? 'Perbarui' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-800">Daftar Tempat Tidur</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">#</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Lokasi</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">No Bed</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Jenis</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($beds as $index => $b)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3">{{ $b->gedung }} - {{ $b->lantai }} - {{ $b->ruangan }}</td>
                                        <td class="px-4 py-3 font-semibold">{{ $b->no_bed }}</td>
                                        <td class="px-4 py-3">{{ $b->jenis_kamar }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 rounded text-xs font-semibold 
                                                {{ $b->status == 'Tersedia' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ $b->status == 'Terisi' ? 'bg-red-100 text-red-700' : '' }}
                                                {{ $b->status == 'Booking' ? 'bg-blue-100 text-blue-700' : '' }}
                                                {{ $b->status == 'Maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                            ">{{ $b->status }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('bed-manager.edit', $b->id) }}" class="p-2 text-green-600 hover:bg-green-50 rounded">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <form action="{{ route('bed-manager.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Hapus?');" class="inline">
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
                                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">Belum ada data tempat tidur</td>
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
