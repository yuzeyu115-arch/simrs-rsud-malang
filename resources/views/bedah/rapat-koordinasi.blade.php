<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapat Koordinasi KA Bedah - SIMRS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Rapat Koordinasi KA Bedah</h1>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg p-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">{{ isset($meetingItem) ? 'Edit Rapat' : 'Rapat Baru' }}</h2>
                    
                    @php
                        $action = isset($meetingItem) ? route('rapat-koordinasi.update', $meetingItem->id) : route('rapat-koordinasi.store');
                    @endphp
                    <form action="{{ $action }}" method="POST" class="space-y-4">
                        @csrf
                        @if(isset($meetingItem)) @method('PUT') @endif

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Rapat *</label>
                            <input name="judul_rapat" value="{{ old('judul_rapat', $meetingItem->judul_rapat ?? '') }}" type="text" class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('judul_rapat') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Rapat *</label>
                            <input name="tanggal_rapat" value="{{ old('tanggal_rapat', $meetingItem->tanggal_rapat ?? '') }}" type="date" class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('tanggal_rapat') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pimpinan Rapat *</label>
                            <input name="pimpinan_rapat" value="{{ old('pimpinan_rapat', $meetingItem->pimpinan_rapat ?? '') }}" type="text" class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('pimpinan_rapat') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Peserta Rapat *</label>
                            <textarea name="peserta_rapat" class="w-full border border-gray-300 rounded px-3 py-2 h-20" placeholder="Sebutkan nama-nama peserta...">{{ old('peserta_rapat', $meetingItem->peserta_rapat ?? '') }}</textarea>
                            @error('peserta_rapat') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Notulen Hasil *</label>
                            <textarea name="notulen_hasil" class="w-full border border-gray-300 rounded px-3 py-2 h-20">{{ old('notulen_hasil', $meetingItem->notulen_hasil ?? '') }}</textarea>
                            @error('notulen_hasil') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-2">
                            @if(isset($meetingItem))
                                <a href="{{ route('rapat-koordinasi') }}" class="flex-1 text-center px-4 py-2 border border-gray-300 rounded text-gray-700 font-semibold hover:bg-gray-50">Batal</a>
                            @endif
                            <button type="submit" class="flex-1 px-4 py-2 bg-green-600 text-white rounded font-semibold hover:bg-green-700">
                                {{ isset($meetingItem) ? 'Perbarui' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-800">Daftar Rapat</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">#</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Judul</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Pimpinan</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($meetings as $index => $m)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 font-semibold">{{ $m->judul_rapat }}</td>
                                        <td class="px-4 py-3">{{ date('d/m/Y', strtotime($m->tanggal_rapat)) }}</td>
                                        <td class="px-4 py-3">{{ $m->pimpinan_rapat }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('rapat-koordinasi.edit', $m->id) }}" class="p-2 text-green-600 hover:bg-green-50 rounded">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <form action="{{ route('rapat-koordinasi.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus?');" class="inline">
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
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada rapat koordinasi</td>
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
