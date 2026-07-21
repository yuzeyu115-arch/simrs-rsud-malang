@extends('layouts.app')

@section('title', 'Edit Jadwal Operasi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Edit Jadwal Operasi</h1>

    <form action="{{ route('jadwal-operasi.update', $jadwalOperasi->id) }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pasien Selection -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Pasien *</label>
                <select name="pasien_id" required class="w-full px-3 py-2 border border-gray-300 rounded @error('pasien_id') border-red-500 @enderror">
                    @foreach($pasiens as $pasien)
                    <option value="{{ $pasien->id }}" {{ $jadwalOperasi->pasien_id == $pasien->id ? 'selected' : '' }}>
                        {{ $pasien->nama_lengkap }} ({{ $pasien->no_rekam_medis }})
                    </option>
                    @endforeach
                </select>
                @error('pasien_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Surgery Type -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Jenis Operasi *</label>
                <input type="text" name="jenis_operasi" required 
                    value="{{ old('jenis_operasi', $jadwalOperasi->jenis_operasi) }}" class="w-full px-3 py-2 border border-gray-300 rounded @error('jenis_operasi') border-red-500 @enderror">
                @error('jenis_operasi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Start Time -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Waktu Mulai *</label>
                <input type="datetime-local" name="waktu_mulai" required 
                    value="{{ old('waktu_mulai', $jadwalOperasi->waktu_mulai->format('Y-m-d\TH:i')) }}" class="w-full px-3 py-2 border border-gray-300 rounded @error('waktu_mulai') border-red-500 @enderror">
                @error('waktu_mulai') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- End Time -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Waktu Selesai *</label>
                <input type="datetime-local" name="waktu_selesai" required 
                    value="{{ old('waktu_selesai', $jadwalOperasi->waktu_selesai->format('Y-m-d\TH:i')) }}" class="w-full px-3 py-2 border border-gray-300 rounded @error('waktu_selesai') border-red-500 @enderror">
                @error('waktu_selesai') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Status *</label>
                <select name="status" required class="w-full px-3 py-2 border border-gray-300 rounded @error('status') border-red-500 @enderror">
                    <option value="scheduled" {{ $jadwalOperasi->status == 'scheduled' ? 'selected' : '' }}>Dijadwalkan</option>
                    <option value="in-progress" {{ $jadwalOperasi->status == 'in-progress' ? 'selected' : '' }}>Sedang Berlangsung</option>
                    <option value="completed" {{ $jadwalOperasi->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ $jadwalOperasi->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Notes -->
        <div class="mt-6">
            <label class="block text-gray-700 font-semibold mb-2">Catatan</label>
            <textarea name="catatan" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded">{{ old('catatan', $jadwalOperasi->catatan) }}</textarea>
        </div>

        <!-- Submit -->
        <div class="mt-6 flex gap-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                Update Jadwal
            </button>
            <a href="{{ route('jadwal-operasi.show', $jadwalOperasi->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
