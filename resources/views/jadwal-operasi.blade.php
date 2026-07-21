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
        @php $canInputSchedule = in_array(auth()->user()?->role ?? 'guest', ['tpp','kpp','admin','rekam_medis']); @endphp
        @php $canFinalizeSchedule = in_array(auth()->user()?->role ?? 'guest', ['kpp','admin']); @endphp
    </div>

    @if(session('success'))
        <div class="rounded-3xl border border-emerald-100 bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
    @endif

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-end">
        @if($canInputSchedule)
            <button type="button" id="openJadwalModalTop" class="btn-primary whitespace-nowrap">Tambah Jadwal</button>
        @endif
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
    <div id="jadwalModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/50 p-4 backdrop-blur-sm">
        <div class="w-full max-w-4xl rounded-[2rem] bg-white shadow-2xl ring-1 ring-slate-200">
            <div class="flex items-start justify-between gap-4 border-b border-slate-200 p-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Tambah Jadwal Operasi</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900">Form Jadwal Bedah</h2>
                </div>
                <button type="button" id="closeJadwalModal" class="rounded-full border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-50">Tutup</button>
            </div>
            <div class="p-6">
                @php
                    $formAction = isset($editingSchedule) ? route('jadwal-operasi.update', $editingSchedule->id) : route('jadwal-operasi.store');
                @endphp
                <form id="jadwalForm" action="{{ $formAction }}" method="POST" class="grid gap-4 lg:grid-cols-2">
                    @csrf
                    @if(isset($editingSchedule))
                        @method('PUT')
                    @endif
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Tanggal Operasi <span class="text-rose-500">*</span></label>
                        <input name="tanggal_operasi" type="date" value="{{ old('tanggal_operasi', $editingSchedule->tanggal_operasi ?? '') }}" class="input-base" required>
                        @error('tanggal_operasi')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Jam Mulai <span class="text-rose-500">*</span></label>
                        <input name="jam_mulai" type="time" value="{{ old('jam_mulai', $editingSchedule->jam_mulai ?? '') }}" class="input-base" required>
                        @error('jam_mulai')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Ruang Operasi <span class="text-rose-500">*</span></label>
                        <select name="ruang_id" class="input-base" required>
                            <option value="">Pilih ruang operasi</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('ruang_id', $editingSchedule->ruang_id ?? '') == $room->id ? 'selected' : '' }}>{{ $room->nama_ruang }}</option>
                            @endforeach
                        </select>
                        @error('ruang_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Nama Pasien <span class="text-rose-500">*</span></label>
                        <input name="nama_pasien" type="text" value="{{ old('nama_pasien', $editingSchedule->nama_pasien ?? '') }}" class="input-base" placeholder="Nama pasien" required>
                        @error('nama_pasien')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Nomor RM <span class="text-rose-500">*</span></label>
                        <input name="nomor_rm" type="text" value="{{ old('nomor_rm', $editingSchedule->nomor_rm ?? '') }}" class="input-base" placeholder="Contoh: 00012345" required>
                        @error('nomor_rm')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Dokter Bedah <span class="text-rose-500">*</span></label>
                        <select name="dokter_bedah_id" class="input-base" required>
                            <option value="">Pilih dokter bedah</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('dokter_bedah_id', $editingSchedule->dokter_bedah_id ?? '') == $doctor->id ? 'selected' : '' }}>{{ $doctor->nama }}</option>
                            @endforeach
                        </select>
                        @error('dokter_bedah_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Dokter Anestesi <span class="text-rose-500">*</span></label>
                        <select name="dokter_anestesi_id" class="input-base" required>
                            <option value="">Pilih dokter anestesi</option>
                            @foreach($anesthesias as $anesthesia)
                                <option value="{{ $anesthesia->id }}" {{ old('dokter_anestesi_id', $editingSchedule->dokter_anestesi_id ?? '') == $anesthesia->id ? 'selected' : '' }}>{{ $anesthesia->nama }}</option>
                            @endforeach
                        </select>
                        @error('dokter_anestesi_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Jenis Tindakan <span class="text-rose-500">*</span></label>
                        <div class="space-y-2">
                            <input id="jenisTindakanInput" name="jenis_tindakan" type="text" value="{{ old('jenis_tindakan', $editingSchedule->jenis_tindakan ?? '') }}" class="input-base" list="jenisTindakanOptions" placeholder="Contoh: Appendektomi" required>
                            <datalist id="jenisTindakanOptions">
                                @foreach($availableJenisTindakan as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        @error('jenis_tindakan')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    @if(isset($editingSchedule))
                        <div class="lg:col-span-2">
                            <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Status <span class="text-rose-500">*</span></label>
                            <select name="status" class="input-base" required>
                                <option value="Terjadwal" {{ old('status', $editingSchedule->status) == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                                <option value="Berjalan" {{ old('status', $editingSchedule->status) == 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                                <option value="Selesai" {{ old('status', $editingSchedule->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Dibatalkan" {{ old('status', $editingSchedule->status) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            @error('status')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    @endif
                    <div class="lg:col-span-2 flex flex-wrap gap-3 justify-end mt-2 border-t border-slate-200 pt-4">
                        @if(isset($editingSchedule))
                            <a href="{{ route('jadwal-operasi') }}" class="btn-secondary">Batal</a>
                        @endif
                        <button type="button" class="btn-secondary" id="cancelJadwalModalFooter">Batal</button>
                        @if($canInputSchedule)
                            <button type="submit" class="btn-primary">{{ isset($editingSchedule) ? 'Perbarui Jadwal' : 'Simpan Jadwal' }}</button>
                        @else
                            <button type="button" class="btn-primary opacity-60 cursor-not-allowed" disabled>Hanya melihat</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="space-y-6">
            @if($canFinalizeSchedule && ($schedules->count() ?? 0))
                <div class="card-panel p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Finalisasi KPP</h2>
                    <form id="finalisasiForm" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Pilih Operasi</label>
                            <select id="finalisasiSchedule" class="input-base" required>
                                <option value="">Pilih jadwal</option>
                                @foreach($schedules as $schedule)
                                    <option value="{{ route('jadwal-operasi.finalize', $schedule->id) }}" data-date="{{ $schedule->tanggal_operasi }}" data-time="{{ substr($schedule->jam_mulai, 0, 5) }}">
                                        {{ $schedule->nama_pasien }} - {{ date('d M Y', strtotime($schedule->tanggal_operasi)) }} {{ date('H:i', strtotime($schedule->jam_mulai)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div>
                                <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Tanggal</label>
                                <input id="tanggalPelaksanaan" name="tanggal_pelaksanaan" type="date" class="input-base" required>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Jam</label>
                                <input id="jamPelaksanaan" name="jam_pelaksanaan" type="time" class="input-base" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Status</label>
                            <select name="status" class="input-base" required>
                                <option value="Terjadwal">Terjadwal</option>
                                <option value="Berjalan">Berjalan</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Catatan</label>
                            <textarea name="catatan_finalisasi" rows="3" class="input-base" placeholder="Catatan finalisasi waktu operasi"></textarea>
                        </div>
                        <button type="submit" class="btn-primary w-full justify-center">Finalisasi Waktu</button>
                    </form>
                </div>
            @endif
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
                    <th class="px-5 py-4">Dokter Bedah</th>
                    <th class="px-5 py-4">Dokter Anestesi</th>
                    <th class="px-5 py-4">Ruang</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4">Finalisasi</th>
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
                        <td class="px-5 py-4 text-slate-700">{{ $schedule->dokter_anestesi ?? '—' }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">{{ $schedule->status ?? 'Terjadwal' }}</span>
                        </td>
                        <td class="px-5 py-4 text-xs text-slate-600">
                            @if($schedule->finalized_at ?? null)
                                <span class="font-semibold text-emerald-700">{{ date('d M Y H:i', strtotime($schedule->waktu_pelaksanaan ?? $schedule->finalized_at)) }}</span>
                                <p class="mt-1 text-slate-400">{{ \Illuminate\Support\Str::limit($schedule->catatan_finalisasi ?? '-', 36) }}</p>
                            @else
                                <span class="text-slate-400">Belum difinalisasi</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2 justify-center">
                                @if($canInputSchedule)
                                    <a href="{{ route('jadwal-operasi.edit', $schedule->id) }}" class="rounded-3xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-50 transition">Edit</a>
                                    <form action="{{ route('jadwal-operasi.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-3xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50 transition">Hapus</button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400">Hanya lihat</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="px-5 py-16 text-center text-slate-400">
                            <i class="fas fa-inbox text-3xl"></i>
                            <p class="mt-3 text-sm">Belum ada jadwal operasi.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <div class="mt-6 flex flex-col items-center gap-4">
            {{ $schedules->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const modal = document.getElementById('jadwalModal');
        const openButtons = [document.getElementById('openJadwalModal'), document.getElementById('openJadwalModalTop')];
        const closeButtons = [document.getElementById('closeJadwalModal'), document.getElementById('cancelJadwalModal'), document.getElementById('cancelJadwalModalFooter')];
        const form = document.getElementById('finalisasiForm');
        const select = document.getElementById('finalisasiSchedule');
        const dateInput = document.getElementById('tanggalPelaksanaan');
        const timeInput = document.getElementById('jamPelaksanaan');

        openButtons.forEach(function (button) {
            if (!button || !modal) return;
            button.addEventListener('click', function () {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            });
        });

        closeButtons.forEach(function (button) {
            if (!button || !modal) return;
            button.addEventListener('click', function () {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            });
        });

        if (modal) {
            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        }

        if (!form || !select) return;

        select.addEventListener('change', function () {
            const option = this.options[this.selectedIndex];
            form.action = this.value || '#';
            if (option?.dataset?.date) dateInput.value = option.dataset.date;
            if (option?.dataset?.time) timeInput.value = option.dataset.time;
        });

        form.addEventListener('submit', function (event) {
            if (!select.value) {
                event.preventDefault();
                select.focus();
            }
        });
    })();
</script>
@endpush
