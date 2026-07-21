@extends('layouts.app')

@section('title', 'Tambah Jadwal Operasi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Tambah Jadwal Operasi</h1>

    <form action="{{ route('jadwal-operasi.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pasien Selection -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Pasien *</label>
                <select name="pasien_id" required class="w-full px-3 py-2 border border-gray-300 rounded @error('pasien_id') border-red-500 @enderror">
                    <option value="">Pilih Pasien</option>
                    @foreach($pasiens as $pasien)
                    <option value="{{ $pasien->id }}" {{ old('pasien_id') == $pasien->id ? 'selected' : '' }}>
                        {{ $pasien->nama_lengkap }} ({{ $pasien->no_rekam_medis }})
                    </option>
                    @endforeach
                </select>
                @error('pasien_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Surgery Type -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Jenis Operasi *</label>
                <input type="text" name="jenis_operasi" required placeholder="Mis: Operasi Usus Buntu" 
                    value="{{ old('jenis_operasi') }}" class="w-full px-3 py-2 border border-gray-300 rounded @error('jenis_operasi') border-red-500 @enderror">
                @error('jenis_operasi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Operating Room -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Ruang Operasi *</label>
                <select name="ruang_operasi_id" required class="w-full px-3 py-2 border border-gray-300 rounded @error('ruang_operasi_id') border-red-500 @enderror">
                    <option value="">Pilih Ruang Operasi</option>
                    @foreach($ruangOperasis as $ruang)
                    <option value="{{ $ruang->id }}" {{ old('ruang_operasi_id') == $ruang->id ? 'selected' : '' }}>
                        {{ $ruang->nama_ruang }}
                    </option>
                    @endforeach
                </select>
                @error('ruang_operasi_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Bed -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Tempat Tidur (Opsional)</label>
                <select name="bed_id" class="w-full px-3 py-2 border border-gray-300 rounded">
                    <option value="">Pilih Tempat Tidur</option>
                    @foreach($beds as $bed)
                    <option value="{{ $bed->id }}" {{ old('bed_id') == $bed->id ? 'selected' : '' }}>
                        {{ $bed->nama_bed }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Start Time -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Waktu Mulai *</label>
                <input type="datetime-local" name="waktu_mulai" required 
                    value="{{ old('waktu_mulai') }}" class="w-full px-3 py-2 border border-gray-300 rounded @error('waktu_mulai') border-red-500 @enderror">
                @error('waktu_mulai') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- End Time -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Waktu Selesai *</label>
                <input type="datetime-local" name="waktu_selesai" required 
                    value="{{ old('waktu_selesai') }}" class="w-full px-3 py-2 border border-gray-300 rounded @error('waktu_selesai') border-red-500 @enderror">
                @error('waktu_selesai') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Notes -->
        <div class="mt-6">
            <label class="block text-gray-700 font-semibold mb-2">Catatan (Opsional)</label>
            <textarea name="catatan" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded" placeholder="Masukkan catatan penting">{{ old('catatan') }}</textarea>
        </div>

        <!-- Submit -->
        <div class="mt-6 flex gap-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                Simpan Jadwal
            </button>
            <a href="{{ route('jadwal-operasi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
