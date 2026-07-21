@extends('layouts.app')

@section('title', 'Jadwal Operasi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Jadwal Operasi</h1>
        @if(auth()->user()?->hasRole(['admin', 'dokter_bedah', 'ka_bedah']))
        <a href="{{ route('jadwal-operasi.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Tambah Jadwal
        </a>
        @endif
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form method="GET" action="{{ route('jadwal-operasi.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded">
                    <option value="">Semua Status</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Dijadwalkan</option>
                    <option value="in-progress" {{ request('status') == 'in-progress' ? 'selected' : '' }}>Sedang Berlangsung</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Tanggal Mulai</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Tanggal Akhir</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Surgery Schedules Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Pasien</th>
                    <th class="px-6 py-3 text-left font-semibold">Jenis Operasi</th>
                    <th class="px-6 py-3 text-left font-semibold">Ruang</th>
                    <th class="px-6 py-3 text-left font-semibold">Jadwal</th>
                    <th class="px-6 py-3 text-left font-semibold">Status</th>
                    <th class="px-6 py-3 text-left font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($jadwalOperasis as $jadwal)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">{{ $jadwal->pasien->nama_lengkap }}</td>
                    <td class="px-6 py-3">{{ $jadwal->jenis_operasi }}</td>
                    <td class="px-6 py-3">{{ $jadwal->ruangOperasi->nama_ruang ?? 'N/A' }}</td>
                    <td class="px-6 py-3">
                        <small>{{ $jadwal->waktu_mulai->format('d/m/Y H:i') }}</small><br>
                        <small class="text-gray-500">{{ $jadwal->waktu_selesai->format('H:i') }}</small>
                    </td>
                    <td class="px-6 py-3">
                        @switch($jadwal->status)
                            @case('scheduled')
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">Dijadwalkan</span>
                                @break
                            @case('in-progress')
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs">Berlangsung</span>
                                @break
                            @case('completed')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs">Selesai</span>
                                @break
                            @case('cancelled')
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs">Dibatalkan</span>
                                @break
                        @endswitch
                    </td>
                    <td class="px-6 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('jadwal-operasi.show', $jadwal->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Lihat
                            </a>
                            @if(auth()->user()?->hasRole(['admin', 'ka_bedah']))
                            <a href="{{ route('jadwal-operasi.edit', $jadwal->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                Edit
                            </a>
                            <form action="{{ route('jadwal-operasi.destroy', $jadwal->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data jadwal operasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $jadwalOperasis->links() }}
    </div>
</div>
@endsection
