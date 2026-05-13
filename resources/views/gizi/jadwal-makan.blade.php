<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Makan - SimpleOK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Jadwal Makan Pasien</h1>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg p-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">{{ isset($jadwalItem) ? 'Edit Jadwal' : 'Tambah Jadwal' }}</h2>
                    
                    @php
                        $action = isset($jadwalItem) ? route('jadwal-makan.update', $jadwalItem->id) : route('jadwal-makan.store');
                    @endphp
                    <form action="{{ $action }}" method="POST" class="space-y-4">
                        @csrf
                        @if(isset($jadwalItem)) @method('PUT') @endif

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Jadwal *</label>
                            <input name="nama" value="{{ old('nama', $jadwalItem->nama ?? '') }}" type="text" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Contoh: Sarapan">
                            @error('nama') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Pesan *</label>
                            <input name="jam_pesan" value="{{ old('jam_pesan', $jadwalItem->jam_pesan ?? '') }}" type="time" class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('jam_pesan') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Shift *</label>
                            <select name="shift" class="w-full border border-gray-300 rounded px-3 py-2">
                                <option value="Pagi" {{ old('shift', $jadwalItem->shift ?? '') == 'Pagi' ? 'selected' : '' }}>Pagi</option>
                                <option value="Siang" {{ old('shift', $jadwalItem->shift ?? '') == 'Siang' ? 'selected' : '' }}>Siang</option>
                                <option value="Sore" {{ old('shift', $jadwalItem->shift ?? '') == 'Sore' ? 'selected' : '' }}>Sore</option>
                            </select>
                            @error('shift') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-2">
                            @if(isset($jadwalItem))
                                <a href="{{ route('jadwal-makan') }}" class="flex-1 text-center px-4 py-2 border border-gray-300 rounded text-gray-700 font-semibold hover:bg-gray-50">Batal</a>
                            @endif
                            <button type="submit" class="flex-1 px-4 py-2 bg-green-600 text-white rounded font-semibold hover:bg-green-700">
                                {{ isset($jadwalItem) ? 'Perbarui' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-800">Daftar Jadwal Makan</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">#</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Jam Pesan</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Shift</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($jadwal as $index => $j)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 font-semibold">{{ $j->nama }}</td>
                                        <td class="px-4 py-3">{{ $j->jam_pesan }}</td>
                                        <td class="px-4 py-3"><span class="px-2 py-1 bg-amber-100 text-amber-700 rounded text-xs font-semibold">{{ $j->shift }}</span></td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('jadwal-makan.edit', $j->id) }}" class="p-2 text-green-600 hover:bg-green-50 rounded">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <form action="{{ route('jadwal-makan.destroy', $j->id) }}" method="POST" onsubmit="return confirm('Hapus?');" class="inline">
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
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada jadwal makan</td>
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
