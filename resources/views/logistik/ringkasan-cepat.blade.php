<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Logistik Cepat - SimpleOK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Ringkasan Logistik Cepat</h1>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg p-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">Bius Tersedia</p>
                        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $logistics->total_bius_tersedia ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2">Unit</p>
                    </div>
                    <i class="fa-solid fa-syringe text-4xl text-blue-200"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">Cairan Infus</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $logistics->jumlah_cairan_infus ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2">Botol</p>
                    </div>
                    <i class="fa-solid fa-droplet text-4xl text-green-200"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">Alat Bedah Steril</p>
                        <p class="text-3xl font-bold text-purple-600 mt-2">{{ $logistics->jumlah_alat_bedah_steril ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2">Set</p>
                    </div>
                    <i class="fa-solid fa-scissors text-4xl text-purple-200"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Input -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Update Stok Logistik</h2>
                    
                    <form action="{{ route('logistik-ringkasan.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Total Bius Tersedia *</label>
                            <input name="total_bius_tersedia" value="{{ old('total_bius_tersedia', $logistics->total_bius_tersedia ?? 0) }}" type="number" min="0" class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('total_bius_tersedia') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Cairan Infus *</label>
                            <input name="jumlah_cairan_infus" value="{{ old('jumlah_cairan_infus', $logistics->jumlah_cairan_infus ?? 0) }}" type="number" min="0" class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('jumlah_cairan_infus') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Alat Bedah Steril *</label>
                            <input name="jumlah_alat_bedah_steril" value="{{ old('jumlah_alat_bedah_steril', $logistics->jumlah_alat_bedah_steril ?? 0) }}" type="number" min="0" class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('jumlah_alat_bedah_steril') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        @if($logistics)
                        <div class="bg-gray-50 p-3 rounded">
                            <p class="text-xs font-semibold text-gray-600">Terakhir Dicek:</p>
                            <p class="text-sm text-gray-700">{{ $logistics->terakhir_dicek ? date('d/m/Y H:i', strtotime($logistics->terakhir_dicek)) : '-' }}</p>
                        </div>
                        @endif

                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded font-semibold hover:bg-green-700">
                            Simpan Update
                        </button>
                    </form>
                </div>
            </div>

            <!-- History & Info -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Status Logistik</h2>
                    
                    <div class="space-y-4">
                        <div class="border-l-4 border-blue-500 bg-blue-50 p-4 rounded">
                            <p class="font-semibold text-gray-800">Bius (Anestesi)</p>
                            <p class="text-sm text-gray-600 mt-1">Stok saat ini: <span class="font-bold text-blue-600">{{ $logistics->total_bius_tersedia ?? 0 }} Unit</span></p>
                            <p class="text-xs text-gray-500 mt-2">Untuk kebutuhan operasi rutin selama 1-2 minggu</p>
                        </div>

                        <div class="border-l-4 border-green-500 bg-green-50 p-4 rounded">
                            <p class="font-semibold text-gray-800">Cairan Infus</p>
                            <p class="text-sm text-gray-600 mt-1">Stok saat ini: <span class="font-bold text-green-600">{{ $logistics->jumlah_cairan_infus ?? 0 }} Botol</span></p>
                            <p class="text-xs text-gray-500 mt-2">Untuk kebutuhan pasien rawat inap dan operasi</p>
                        </div>

                        <div class="border-l-4 border-purple-500 bg-purple-50 p-4 rounded">
                            <p class="font-semibold text-gray-800">Alat Bedah Steril</p>
                            <p class="text-sm text-gray-600 mt-1">Stok saat ini: <span class="font-bold text-purple-600">{{ $logistics->jumlah_alat_bedah_steril ?? 0 }} Set</span></p>
                            <p class="text-xs text-gray-500 mt-2">Set lengkap untuk operasi minor dan mayor</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
