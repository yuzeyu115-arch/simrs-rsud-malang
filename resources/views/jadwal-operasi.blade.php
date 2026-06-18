@extends('layouts.app')

@section('title','Jadwal Operasi (Bedah)')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Jadwal Operasi</p>
            <h1 class="text-4xl font-bold text-slate-900">Kelola Jadwal Bedah</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Atur jadwal operasi dengan cepat, pantau status, dan kelola tim bedah dalam satu tampilan.</p>
        </div>
        <a href="#jadwalForm" class="btn-primary">Tambah Jadwal</a>
    </div>

    <div class="grid gap-6 xl:grid-cols-5">
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Operasi Hari Ini</p>
            <p class="mt-4 text-4xl font-black text-slate-900">{{ $totalToday ?? 14 }}</p>
            <p class="mt-3 text-sm text-slate-500">Jumlah operasi terjadwal</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Selesai</p>
            <p class="mt-4 text-4xl font-black text-emerald-700">{{ $selesai ?? 6 }}</p>
            <p class="mt-3 text-sm text-slate-500">Operasi selesai</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Berlangsung</p>
            <p class="mt-4 text-4xl font-black text-sky-700">{{ $berlangsung ?? 4 }}</p>
            <p class="mt-3 text-sm text-slate-500">Sedang berlangsung</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Dibatalkan</p>
            <p class="mt-4 text-4xl font-black text-amber-700">{{ $dibatalkan ?? 2 }}</p>
            <p class="mt-3 text-sm text-slate-500">Operasi dibatalkan</p>
        </div>
        <div class="card-stat p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Belum Dimulai</p>
            <p class="mt-4 text-4xl font-black text-rose-700">{{ $belum ?? 2 }}</p>
            <p class="mt-3 text-sm text-slate-500">Menunggu waktu</p>
        </div>
    </div>
    <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="card-panel p-6">
            <div class="flex flex-col gap-2 mb-6">
                <h2 class="text-xl font-bold text-slate-900">Tambah Jadwal Operasi</h2>
                <p class="text-sm text-slate-500">Masukkan detail jadwal operasi yang ingin dijadwalkan.</p>
            </div>
            @php
                $formAction = isset($editingSchedule) ? route('jadwal-operasi.update', $editingSchedule->id) : route('jadwal-operasi.store');
            @endphp
            <form id="jadwalForm" action="{{ $formAction }}" method="POST" class="grid gap-4 lg:grid-cols-2">
                @csrf
                @if(isset($editingSchedule))
                    @method('PUT')
                @endif
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Tanggal Operasi</label>
                    <input name="tanggal_operasi" type="date" value="{{ old('tanggal_operasi', $editingSchedule->tanggal_operasi ?? '') }}" class="input-base">
                    @error('tanggal_operasi')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Jam Mulai</label>
                    <input name="jam_mulai" type="time" value="{{ old('jam_mulai', $editingSchedule->jam_mulai ?? '') }}" class="input-base">
                    @error('jam_mulai')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Ruang Operasi</label>
                    <select name="ruang_id" class="input-base">
                        <option value="">Pilih ruang operasi</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('ruang_id', $editingSchedule->ruang_id ?? '') == $room->id ? 'selected' : '' }}>{{ $room->nama_ruang }}</option>
                        @endforeach
                    </select>
                    @error('ruang_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Nama Pasien</label>
                    <input name="nama_pasien" type="text" value="{{ old('nama_pasien', $editingSchedule->nama_pasien ?? '') }}" class="input-base" placeholder="Nama pasien">
                    @error('nama_pasien')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Nomor RM</label>
                    <input name="nomor_rm" type="text" value="{{ old('nomor_rm', $editingSchedule->nomor_rm ?? '') }}" class="input-base" placeholder="Contoh: 00012345">
                    @error('nomor_rm')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Dokter Bedah</label>
                    <select name="dokter_bedah_id" class="input-base">
                        <option value="">Pilih dokter bedah</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('dokter_bedah_id', $editingSchedule->dokter_bedah_id ?? '') == $doctor->id ? 'selected' : '' }}>{{ $doctor->nama }}</option>
                        @endforeach
                    </select>
                    @error('dokter_bedah_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Dokter Anestesi</label>
                    <select name="dokter_anestesi_id" class="input-base">
                        <option value="">Pilih dokter anestesi</option>
                        @foreach($anesthesias as $anesthesia)
                            <option value="{{ $anesthesia->id }}" {{ old('dokter_anestesi_id', $editingSchedule->dokter_anestesi_id ?? '') == $anesthesia->id ? 'selected' : '' }}>{{ $anesthesia->nama }}</option>
                        @endforeach
                    </select>
                    @error('dokter_anestesi_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="lg:col-span-2">
                    <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Jenis Tindakan</label>
                    <input name="jenis_tindakan" type="text" value="{{ old('jenis_tindakan', $editingSchedule->jenis_tindakan ?? '') }}" class="input-base" placeholder="Contoh: Appendektomi">
                    @error('jenis_tindakan')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                @if(isset($editingSchedule))
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Status</label>
                        <select name="status" class="input-base">
                            <option value="Terjadwal" {{ old('status', $editingSchedule->status) == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                            <option value="Berjalan" {{ old('status', $editingSchedule->status) == 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                            <option value="Selesai" {{ old('status', $editingSchedule->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Dibatalkan" {{ old('status', $editingSchedule->status) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                @endif
                <div class="lg:col-span-2 flex flex-wrap gap-3 justify-end mt-2">
                    @if(isset($editingSchedule))
                        <a href="{{ route('jadwal-operasi') }}" class="btn-secondary">Batal</a>
                    @endif
                    <button type="submit" class="btn-primary">{{ isset($editingSchedule) ? 'Perbarui Jadwal' : 'Simpan Jadwal' }}</button>
                </div>
            </form>
        </div>

        <div class="space-y-6">
            <div class="card-panel p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Ringkasan Operasi</h2>
                <div class="grid gap-4">
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500 font-semibold">Operasi Hari Ini</p>
                        <p class="mt-2 text-2xl font-bold text-slate-900">{{ $totalToday ?? 14 }}</p>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl bg-emerald-50 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-emerald-700">Selesai</p>
                            <p class="mt-2 text-xl font-bold text-emerald-900">{{ $selesai ?? 6 }}</p>
                        </div>
                        <div class="rounded-3xl bg-sky-50 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-sky-700">Berlangsung</p>
                            <p class="mt-2 text-xl font-bold text-sky-900">{{ $berlangsung ?? 4 }}</p>
                        </div>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl bg-amber-50 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-amber-700">Dibatalkan</p>
                            <p class="mt-2 text-xl font-bold text-amber-900">{{ $dibatalkan ?? 2 }}</p>
                        </div>
                        <div class="rounded-3xl bg-rose-50 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-rose-700">Belum Dimulai</p>
                            <p class="mt-2 text-xl font-bold text-rose-900">{{ $belum ?? 2 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-panel p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Detail Operasi Cepat</h2>
                <div class="space-y-4">
                    <div class="rounded-3xl border border-slate-200 bg-white p-4">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold text-slate-900">Ruang Operasi A</p>
                            <span class="text-xs uppercase tracking-[0.2em] text-slate-400">1 Jam lagi</span>
                        </div>
                        <p class="mt-2 text-sm text-slate-600">Operasi pasien Anisa Putri, Bedah Umum.</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-4">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold text-slate-900">Ruang Operasi B</p>
                            <span class="text-xs uppercase tracking-[0.2em] text-emerald-700">Siap</span>
                        </div>
                        <p class="mt-2 text-sm text-slate-600">Persiapan obat dan instrumen selesai.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-panel p-6 overflow-x-auto">
        <h2 class="text-lg font-bold text-slate-900 mb-4">Daftar Jadwal Operasi</h2>
        <table class="w-full min-w-[860px] text-sm text-slate-700">
            <thead class="bg-slate-50 text-left text-xs uppercase tracking-[0.24em] text-slate-500">
                <tr>
                    <th class="px-5 py-4">No.</th>
                    <th class="px-5 py-4">Tanggal</th>
                    <th class="px-5 py-4">Jam</th>
                    <th class="px-5 py-4">Pasien</th>
                    <th class="px-5 py-4">Jenis Operasi</th>
                    <th class="px-5 py-4">Dokter</th>
                    <th class="px-5 py-4">Ruang</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($schedules as $index => $schedule)
                    @php
                        $statusClass = match($schedule->status) {
                            'Selesai' => 'bg-emerald-50 text-emerald-700',
                            'Berjalan' => 'bg-sky-50 text-sky-700',
                            'Dibatalkan' => 'bg-rose-50 text-rose-700',
                            default => 'bg-amber-50 text-amber-700',
                        };
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-4 font-semibold">{{ $index + 1 }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ date('d M Y', strtotime($schedule->tanggal_operasi ?? now())) }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ date('H:i', strtotime($schedule->jam_mulai ?? now())) }}</td>
                        <td class="px-5 py-4 font-semibold text-slate-900">{{ $schedule->nama_pasien ?? '—' }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $schedule->jenis_tindakan ?? '—' }}</td>
                        <td class="px-5 py-4 text-slate-700">{{ $schedule->dokter_bedah ?? '—' }}</td>
                        <td class="px-5 py-4 text-slate-700">{{ $schedule->nama_ruang ?? '—' }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">{{ $schedule->status ?? 'Terjadwal' }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2 justify-center">
                                <a href="{{ route('jadwal-operasi.edit', $schedule->id) }}" class="rounded-3xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-50 transition">Edit</a>
                                <form action="{{ route('jadwal-operasi.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-3xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50 transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-5 py-16 text-center text-slate-400">
                            <i class="fas fa-inbox text-3xl"></i>
                            <p class="mt-3 text-sm">Belum ada jadwal operasi.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
