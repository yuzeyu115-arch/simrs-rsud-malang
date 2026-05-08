<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pemesanan Baru - SIMRS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="mb-6">
            <a href="{{ route('pemesanan-menu') }}" class="text-sm text-gray-500 hover:underline">← Kembali ke Pemesanan Menu</a>
            <h1 class="text-3xl font-bold text-gray-800 mt-3">Buat Pemesanan Baru</h1>
            <p class="text-gray-600 mt-1">Isi data pasien dan pilih ruang, shift, dan tanggal.</p>
        </div>

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">
                Mohon perbaiki kesalahan pada form.
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('pemesanan-menu.store') }}" method="POST" class="grid grid-cols-1 gap-4">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ruang *</label>
                    <input name="ruang" type="text" value="{{ old('ruang') }}" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Contoh: Bedah A / ICU">
                    @error('ruang') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas *</label>
                    <select name="kelas" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Pilih Kelas</option>
                        <option value="VIP" {{ old('kelas') == 'VIP' ? 'selected' : '' }}>VIP</option>
                        <option value="Kelas 1" {{ old('kelas') == 'Kelas 1' ? 'selected' : '' }}>Kelas 1</option>
                        <option value="Kelas 2" {{ old('kelas') == 'Kelas 2' ? 'selected' : '' }}>Kelas 2</option>
                        <option value="Kelas 3" {{ old('kelas') == 'Kelas 3' ? 'selected' : '' }}>Kelas 3</option>
                    </select>
                    @error('kelas') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pasien *</label>
                    <input name="nama_pasien" type="text" value="{{ old('nama_pasien') }}" class="w-full border border-gray-300 rounded px-3 py-2">
                    @error('nama_pasien') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Shift *</label>
                        <select name="shift" class="w-full border border-gray-300 rounded px-3 py-2">
                            <option value="Pagi" {{ old('shift') == 'Pagi' ? 'selected' : '' }}>Pagi</option>
                            <option value="Siang" {{ old('shift') == 'Siang' ? 'selected' : '' }}>Siang</option>
                            <option value="Sore" {{ old('shift') == 'Sore' ? 'selected' : '' }}>Sore</option>
                        </select>
                        @error('shift') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal *</label>
                        <input name="tanggal" type="date" value="{{ old('tanggal') }}" class="w-full border border-gray-300 rounded px-3 py-2">
                        @error('tanggal') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan (opsional)</label>
                    <textarea name="catatan" class="w-full border border-gray-300 rounded px-3 py-2 h-28">{{ old('catatan') }}</textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('pemesanan-menu') }}" class="px-4 py-2 border rounded text-gray-700">Batal</a>
                    <button type="submit" class="px-5 py-2 bg-green-600 text-white rounded">Buat Pemesanan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
