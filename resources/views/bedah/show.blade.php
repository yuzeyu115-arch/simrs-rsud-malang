@extends('layouts.app')

@section('title', 'Detail Jadwal Operasi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Detail Jadwal Operasi</h1>
        <div class="flex gap-2">
            @if(auth()->user()?->hasRole(['admin', 'ka_bedah']))
            <a href="{{ route('jadwal-operasi.edit', $jadwalOperasi->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
            @endif
            <a href="{{ route('jadwal-operasi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="md:col-span-2 bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Informasi Operasi</h2>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-gray-500">Pasien</label>
                    <p class="font-semibold">{{ $jadwalOperasi->pasien->nama_lengkap }}</p>
                </div>
                <div>
                    <label class="text-gray-500">No. Rekam Medis</label>
                    <p class="font-semibold">{{ $jadwalOperasi->pasien->no_rekam_medis }}</p>
                </div>
                <div>
                    <label class="text-gray-500">Jenis Operasi</label>
                    <p class="font-semibold">{{ $jadwalOperasi->jenis_operasi }}</p>
                </div>
                <div>
                    <label class="text-gray-500">Ruang Operasi</label>
                    <p class="font-semibold">{{ $jadwalOperasi->ruangOperasi->nama_ruang ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="text-gray-500">Waktu Mulai</label>
                    <p class="font-semibold">{{ $jadwalOperasi->waktu_mulai->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="text-gray-500">Waktu Selesai</label>
                    <p class="font-semibold">{{ $jadwalOperasi->waktu_selesai->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="text-gray-500">Durasi</label>
                    <p class="font-semibold">{{ $jadwalOperasi->waktu_mulai->diffInMinutes($jadwalOperasi->waktu_selesai) }} menit</p>
                </div>
                <div>
                    <label class="text-gray-500">Status</label>
                    <p>
                        @switch($jadwalOperasi->status)
                            @case('scheduled')
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full">Dijadwalkan</span>
                                @break
                            @case('in-progress')
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full">Sedang Berlangsung</span>
                                @break
                            @case('completed')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full">Selesai</span>
                                @break
                            @case('cancelled')
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full">Dibatalkan</span>
                                @break
                        @endswitch
                    </p>
                </div>
            </div>

            @if($jadwalOperasi->catatan)
            <div class="mt-4 p-4 bg-gray-50 rounded">
                <label class="text-gray-500">Catatan</label>
                <p>{{ $jadwalOperasi->catatan }}</p>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Surgical Team -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-xl font-bold mb-4">Tim Operasi</h3>
                @forelse($jadwalOperasi->timOperasi as $team)
                <div class="mb-3 p-3 bg-gray-50 rounded">
                    <p class="font-semibold">{{ $team->name }}</p>
                    <p class="text-sm text-gray-600 capitalize">{{ $team->pivot->peran }}</p>
                </div>
                @empty
                <p class="text-gray-500">Tim belum ditambahkan</p>
                @endforelse

                @if(auth()->user()?->hasRole(['admin', 'ka_bedah']))
                <button type="button" onclick="document.getElementById('addTeamModal').classList.remove('hidden')" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    + Tambah Tim
                </button>
                @endif
            </div>

            <!-- Used Equipment -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-bold mb-4">Alat yang Digunakan</h3>
                @forelse($jadwalOperasi->pemakaianOperasi as $equipment)
                <div class="mb-3 p-3 bg-gray-50 rounded">
                    <p class="font-semibold">{{ $equipment->inventaris->nama_inventaris ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600">Qty: {{ $equipment->jumlah }}</p>
                </div>
                @empty
                <p class="text-gray-500">Belum ada alat yang tercatat</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Add Team Modal -->
<div id="addTeamModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-xl font-bold mb-4">Tambah Tim Operasi</h3>
        <form action="{{ route('jadwal-operasi.add-team', $jadwalOperasi->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Staf Medis</label>
                <select name="user_id" required class="w-full px-3 py-2 border border-gray-300 rounded">
                    <option value="">Pilih Staf</option>
                    @foreach($staffs as $staff)
                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Peran</label>
                <select name="peran" required class="w-full px-3 py-2 border border-gray-300 rounded">
                    <option value="dokter_bedah">Dokter Bedah</option>
                    <option value="dokter_anestesi">Dokter Anestesi</option>
                    <option value="perawat">Perawat</option>
                    <option value="pembantu">Pembantu</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded">
                    Tambah
                </button>
                <button type="button" onclick="document.getElementById('addTeamModal').classList.add('hidden')" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 rounded">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
