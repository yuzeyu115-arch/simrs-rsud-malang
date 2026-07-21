@extends('layouts.app')

@section('title','Status Operasi')

@section('content')
<div class="status-operasi-page space-y-5">
    @php
        $activeOperation = $operasi ?? (object) [
            'id' => null,
            'nama_ruang' => 'Ruang Operasi A',
            'jenis_tindakan' => 'Appendektomi',
            'dokter_bedah' => 'Dr. Hendra',
            'status' => 'Terjadwal',
            'nama_pasien' => 'Anisa Putri',
            'nomor_rm' => '00012345',
            'tanggal_operasi' => now()->toDateString(),
            'jam_mulai' => '10:30:00',
            'dokter_anestesi' => 'Dr. Maya',
        ];
    @endphp

    {{-- Header --}}
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Status Operasi</p>
            <h1 class="mt-1 text-3xl font-bold text-slate-900">Monitoring Operasi</h1>
            <p class="mt-1.5 text-sm text-slate-600 max-w-2xl">Lihat rincian operasi, kontrol, dan jalankan hitungan mundur saat prosedur dimulai.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ url('/dashboard') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>

    @if(! empty($isFallbackOperation))
        <div class="rounded-2xl border border-amber-100 bg-amber-50 px-4 py-3 text-amber-800 text-sm">
            <i class="fas fa-info-circle mr-2"></i>Data operasi tidak tersedia di database. Menampilkan contoh operasi untuk demonstrasi.
        </div>
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Status Jadwal Operasi</p>
                <h2 class="mt-2 text-3xl font-bold text-slate-900">Ringkasan Operasi Terbaru</h2>
                <p class="mt-2 text-sm text-slate-600 max-w-2xl">Lihat ringkasan komposisi status operasi dan jadwal terdekat.</p>
            </div>
            <div class="grid gap-3 sm:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-center">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Terjadwal</p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">{{ $belum ?? 0 }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-center">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Berjalan</p>
                    <p class="mt-3 text-3xl font-bold text-sky-600">{{ $operasi?->status === 'Berjalan' ? 1 : 0 }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-center">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Selesai</p>
                    <p class="mt-3 text-3xl font-bold text-emerald-600">{{ $selesai ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="mt-6 grid gap-3 sm:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <div class="h-2 rounded-full bg-slate-300 mb-4"></div>
                <p class="text-sm text-slate-600">Terjadwal</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <div class="h-2 rounded-full bg-sky-500 mb-4"></div>
                <p class="text-sm text-slate-600">Berjalan</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <div class="h-2 rounded-full bg-emerald-500 mb-4"></div>
                <p class="text-sm text-slate-600">Selesai</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <div class="h-2 rounded-full bg-amber-400 mb-4"></div>
                <p class="text-sm text-slate-600">Dibatalkan</p>
            </div>
        </div>
    </div>

    @if($operasi)
        {{-- Pasien Info Bar --}}
        <div class="card-panel p-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 shrink-0">
                        <i class="fas fa-user text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-[0.16em] text-slate-400 font-semibold">Pasien</p>
                        <p class="text-base font-black text-slate-900">{{ $activeOperation->nama_pasien ?? 'N/A' }}</p>
                        <p class="text-sm text-slate-500">RM: {{ $activeOperation->nomor_rm ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-x-5 gap-y-3 text-sm">
                    <div>
                        <p class="text-[11px] uppercase tracking-[0.16em] text-slate-400 font-semibold">Jenis Operasi</p>
                        <p class="font-bold text-slate-900 mt-1">{{ $activeOperation->jenis_tindakan ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-[0.16em] text-slate-400 font-semibold">Dokter Bedah</p>
                        <p class="font-bold text-slate-900 mt-1">{{ $activeOperation->dokter_bedah ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-[0.16em] text-slate-400 font-semibold">Dokter Anestesi</p>
                        <p class="font-bold text-slate-900 mt-1">{{ $activeOperation->dokter_anestesi ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-[0.16em] text-slate-400 font-semibold">Jadwal</p>
                        <p class="font-bold text-slate-900 mt-1">{{ \Carbon\Carbon::parse($activeOperation->tanggal_operasi ?? now())->format('d M Y') }} | {{ \Carbon\Carbon::parse($activeOperation->jam_mulai ?? now())->format('H:i') }} WIB</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold
                    {{ ($activeOperation->status ?? '') === 'Berjalan' ? 'bg-emerald-100 text-emerald-700' : (($activeOperation->status ?? '') === 'Selesai' ? 'bg-slate-100 text-slate-600' : 'bg-blue-100 text-blue-700') }}">
                    <span class="w-2 h-2 rounded-full mr-2
                        {{ ($activeOperation->status ?? '') === 'Berjalan' ? 'bg-emerald-500' : (($activeOperation->status ?? '') === 'Selesai' ? 'bg-slate-400' : 'bg-blue-500') }}"></span>
                    {{ $activeOperation->status ?? 'Terjadwal' }}
                </span>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="grid gap-4 lg:grid-cols-[1.45fr_0.95fr]">
            <div class="space-y-4">
                {{-- Status Operasi + Timeline --}}
                <div class="card-panel p-5">
                    <h2 class="mb-4 text-sm font-bold uppercase tracking-[0.18em] text-slate-500">Timeline Operasi</h2>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex h-3.5 w-3.5 shrink-0 items-center justify-center rounded-full bg-emerald-500 shadow-sm"></div>
                            <div class="pt-[1px]">
                                <p class="text-xs font-semibold text-slate-900">Persiapan</p>
                                <p class="text-[11px] text-slate-500 mt-0.5">Tim dan peralatan dipersiapkan untuk operasi.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex h-3.5 w-3.5 shrink-0 items-center justify-center rounded-full bg-blue-500 shadow-sm"></div>
                            <div class="pt-[1px]">
                                <p class="text-xs font-semibold text-slate-900">Pelaksanaan</p>
                                <p class="text-[11px] text-slate-500 mt-0.5">Operasi dimulai dan berjalan dengan pemantauan penuh.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex h-3.5 w-3.5 shrink-0 items-center justify-center rounded-full bg-slate-300 shadow-sm"></div>
                            <div class="pt-[1px]">
                                <p class="text-xs font-semibold text-slate-900">Selesai</p>
                                <p class="text-[11px] text-slate-500 mt-0.5">Tandai operasi selesai setelah prosedur rampung.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kontrol Operasi --}}
                <div class="card-panel p-5">
                    <h2 class="mb-4 text-base font-bold text-slate-900">Kontrol Operasi</h2>
                    <div class="grid gap-3 sm:grid-cols-3">
                        {{-- Tombol Kontrol Operasi - BUKA MODAL BAYANG --}}
                        <button id="btnOpenKontrolModal" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-600 px-4 py-3 text-white font-semibold hover:bg-emerald-700 transition shadow-lg shadow-emerald-500/20 text-sm">
                            <i class="fas fa-play-circle"></i> Kontrol Operasi
                        </button>

                        {{-- Laporan Lembar Dokter --}}
                        @if(!empty($activeOperation->id))
                            <a href="{{ route('laporan-operasi.show', $activeOperation->id) }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-600 px-4 py-3 text-white font-semibold hover:bg-blue-700 transition text-sm">
                                <i class="fas fa-file-medical"></i> Laporan Dokter
                            </a>
                            <a href="{{ route('status-operasi.notify', $activeOperation->id) }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-sky-600 px-4 py-3 text-white font-semibold hover:bg-sky-700 transition text-sm">
                                <i class="fas fa-bell"></i> Kirim Notifikasi
                            </a>
                        @else
                            <button type="button" class="inline-flex cursor-not-allowed items-center justify-center gap-2 rounded-2xl bg-slate-100 px-4 py-3 text-slate-400 font-semibold text-sm" disabled>
                                <i class="fas fa-file-medical"></i> Laporan Dokter
                            </button>
                            <button id="btnOpenKalenderModal" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-sky-600 px-4 py-3 text-white font-semibold hover:bg-sky-700 transition text-sm">
                                <i class="fas fa-calendar"></i> Lihat Jadwal
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-4">
                <div class="card-panel p-5 bg-gradient-to-br from-sky-50 to-white">
                    <h3 class="mb-3 text-base font-bold text-slate-900">Detail Ruang</h3>
                    <div class="space-y-2.5 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Ruang</span>
                            <span class="font-semibold text-slate-900">{{ $activeOperation->nama_ruang ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Operasi</span>
                            <span class="font-semibold text-slate-900">{{ $activeOperation->jenis_tindakan ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Pasien</span>
                            <span class="font-semibold text-slate-900">{{ $activeOperation->nama_pasien ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Dokter Bedah</span>
                            <span class="font-semibold text-slate-900">{{ $activeOperation->dokter_bedah ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-panel p-5">
                    <h3 class="mb-3 text-base font-bold text-slate-900">Estimasi Waktu</h3>
                    <div class="space-y-2.5">
                        <div class="rounded-2xl bg-slate-50 p-3.5">
                            <p class="text-[11px] uppercase tracking-[0.16em] text-slate-500">Mulai</p>
                            <p class="mt-1 text-base font-bold text-slate-900">{{ \Carbon\Carbon::parse($activeOperation->jam_mulai ?? now())->format('H:i') }} WIB</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-3.5">
                            <p class="text-[11px] uppercase tracking-[0.16em] text-slate-500">Estimasi Selesai</p>
                            <p class="mt-1 text-base font-bold text-slate-900">{{ \Carbon\Carbon::parse($activeOperation->jam_mulai ?? now())->addMinutes(30)->format('H:i') }} WIB</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    @else
        <div class="card-panel p-10 text-center">
            <i class="fas fa-info-circle text-5xl text-slate-300 mb-4 block"></i>
            <h2 class="text-2xl font-bold text-slate-900">Tidak Ada Operasi Aktif</h2>
            <p class="mt-2 text-sm text-slate-500">Tidak ada operasi dalam status berjalan atau terjadwal saat ini.</p>
            <a href="{{ route('jadwal-operasi') }}" class="btn-primary mt-6 inline-flex">Lihat Jadwal Operasi</a>
        </div>
    @endif
</div>

{{-- ============================================================ --}}
{{-- MODAL KONTROL OPERASI (Bayang Terbang)                       --}}
{{-- ============================================================ --}}
<div id="kontrolModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background: rgba(15,23,42,0.64); backdrop-filter: blur(5px);">
    <div class="w-full max-w-4xl overflow-hidden rounded-2xl bg-white shadow-2xl" style="animation: slideUp 0.3s ease-out;">

        {{-- Modal Header --}}
        <div class="flex items-start justify-between border-b border-slate-100 p-5">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Kontrol Operasi</p>
                <h2 class="mt-1 text-2xl font-black text-slate-900">{{ $activeOperation->nama_ruang ?? 'Ruang Operasi A' }}</h2>
                <p class="text-sm text-slate-500 mt-1">Pasien: <strong class="text-slate-800">{{ $activeOperation->nama_pasien ?? 'Anisa Putri' }}</strong> &nbsp;|&nbsp; {{ $activeOperation->jenis_tindakan ?? 'Appendektomi' }}</p>
            </div>
            <button id="btnCloseKontrolModal" class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-lg font-bold text-slate-600 transition hover:bg-slate-100">&times;</button>
        </div>

        <div id="operationOverviewPanel">
            <div class="grid gap-4 p-5 md:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 p-4">
                    <p class="mb-4 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">Status Operasi</p>
                    <div class="space-y-3.5">
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <span class="h-4 w-4 rounded-full bg-emerald-600"></span>
                                <span class="h-10 w-px bg-slate-300"></span>
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900">Menunggu Persiapan</p>
                                <p class="text-sm text-slate-500">Persiapan alat, tim dan pasien</p>
                                <p class="text-xs text-slate-400">Selesai: {{ \Carbon\Carbon::parse($activeOperation->jam_mulai ?? now())->subMinutes(12)->format('H:i') }} WIB</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <span class="h-4 w-4 rounded-full bg-indigo-400"></span>
                                <span class="h-10 w-px bg-slate-300"></span>
                            </div>
                            <div>
                                <p class="text-base font-black text-indigo-400">Sedang Berlangsung</p>
                                <p class="text-sm text-slate-500">Persiapan alat, tim dan pasien</p>
                                <p class="text-xs text-slate-400">Selesai: {{ \Carbon\Carbon::parse($activeOperation->jam_mulai ?? now())->format('H:i') }} WIB</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <span class="h-4 w-4 rounded-full bg-slate-300"></span>
                            <div>
                                <p class="text-sm font-black text-slate-900">Operasi Selesai</p>
                                <p class="text-sm text-slate-500">Belum Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 p-4">
                    <p class="mb-4 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">Informasi Operasi</p>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-slate-500">Ruang Operasi</p>
                            <p class="font-black text-slate-900">{{ $activeOperation->nama_ruang ?? 'Ruang Operasi A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500">Jenis Anestesi</p>
                            <p class="font-black text-slate-900">General Anasthesi</p>
                        </div>
                        <div>
                            <p class="text-slate-500">Estimasi Selesai</p>
                            <p class="font-black text-slate-900">{{ \Carbon\Carbon::parse($activeOperation->jam_mulai ?? now())->addMinutes(30)->format('H:i') }} WIB</p>
                        </div>
                    </div>
                    <div class="mt-4 rounded-2xl bg-amber-100 px-4 py-3 text-sm text-slate-900 shadow-sm">
                        <p class="font-black">Catatan !!</p>
                        <p>Pastikan semua alat dan obat tersedia sebelum memulai operasi.</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-3 px-5 pb-5">
                <button id="openTimerPanel" class="flex items-center gap-2 rounded-2xl bg-emerald-600 px-7 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/20 transition hover:bg-emerald-700">
                    <i class="fas fa-door-open"></i> Kamar Operasi Baru
                </button>
                <button id="finishOperationOverview" class="flex items-center gap-2 rounded-2xl bg-rose-600 px-7 py-3 text-sm font-bold text-white shadow-lg shadow-rose-500/20 transition hover:bg-rose-700">
                    <i class="fas fa-stop"></i> Selesai Operasi
                </button>
            </div>
        </div>

        <div id="operationTimerPanel" class="hidden">
            <div class="grid gap-4 p-5 md:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 p-4">
                    <p class="mb-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">Status Operasi</p>
                    <p class="text-lg font-black text-emerald-600">Sedang Berlangsung</p>
                    <p class="text-sm text-slate-500 mt-2">Persiapan alat, tim, dan pasien siap.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 p-4">
                    <p class="mb-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">Informasi Operasi</p>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-slate-500">Ruang</span><span class="font-semibold">{{ $activeOperation->nama_ruang ?? 'Ruang A' }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">Jenis</span><span class="font-semibold">{{ $activeOperation->jenis_tindakan ?? 'N/A' }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">Anestesi</span><span class="font-semibold">{{ $activeOperation->dokter_anestesi ?? 'N/A' }}</span></div>
                    </div>
                </div>

                <div class="flex flex-col items-center justify-center rounded-2xl border border-slate-200 p-4 text-center">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">Waktu Operasi</p>
                    <div id="countdownTimer" class="my-3 text-5xl font-black tabular-nums text-slate-900">30:00</div>
                    <p class="text-xs text-slate-500">Hitung mundur waktu prosedur</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-3 px-5 pb-5">
                <button id="startOperation" class="flex items-center gap-2 rounded-2xl bg-emerald-600 px-7 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/20 transition hover:bg-emerald-700">
                    <i class="fas fa-play"></i> Mulai Operasi
                </button>
                <button id="finishOperation" class="flex items-center gap-2 rounded-2xl bg-rose-600 px-7 py-3 text-sm font-bold text-white shadow-lg shadow-rose-500/20 transition hover:bg-rose-700">
                    <i class="fas fa-stop"></i> Selesai Operasi
                </button>
                <a href="{{ route('ruang-tunggu') }}" class="flex items-center gap-2 rounded-2xl bg-slate-900 px-7 py-3 text-sm font-bold text-white shadow-lg transition hover:bg-slate-800">
                    <i class="fas fa-door-open"></i> Menuju Ke Ruang Tunggu
                </a>
            </div>
        </div>
        <div id="finishNotice" class="mx-5 mb-5 hidden rounded-2xl border border-emerald-100 bg-emerald-50 p-3 text-center text-sm text-emerald-800">
            <i class="fas fa-check-circle mr-2"></i>Operasi telah selesai. Klik tutup untuk kembali ke tampilan awal.
        </div>
    </div>
</div>

<style>
@keyframes slideUp {
    from { opacity:0; transform: translateY(40px) scale(0.97); }
    to   { opacity:1; transform: translateY(0) scale(1); }
}

.status-operasi-page .card-panel {
    border-radius: 1.15rem;
    box-shadow: 0 14px 32px rgba(15, 23, 42, 0.06);
}
</style>

<script>
(function() {
    const openBtn   = document.getElementById('btnOpenKontrolModal');
    const closeBtn  = document.getElementById('btnCloseKontrolModal');
    const modal     = document.getElementById('kontrolModal');
    const overviewPanel = document.getElementById('operationOverviewPanel');
    const timerPanel = document.getElementById('operationTimerPanel');
    const openTimerBtn = document.getElementById('openTimerPanel');
    const startBtn  = document.getElementById('startOperation');
    const finishBtn = document.getElementById('finishOperation');
    const finishOverviewBtn = document.getElementById('finishOperationOverview');
    const countdown = document.getElementById('countdownTimer');
    const notice    = document.getElementById('finishNotice');

    let timerInterval = null;
    let remaining = 1800;

    function fmt(s) {
        return String(Math.floor(s/60)).padStart(2,'0') + ':' + String(s%60).padStart(2,'0');
    }
    function updateTimer() { if (countdown) countdown.textContent = fmt(remaining); }
    function resetTimer() {
        clearInterval(timerInterval); timerInterval = null;
        remaining = 1800; updateTimer();
        if (notice) notice.classList.add('hidden');
        if (overviewPanel) overviewPanel.classList.remove('hidden');
        if (timerPanel) timerPanel.classList.add('hidden');
        if (startBtn) {
            startBtn.disabled = false;
            startBtn.innerHTML = '<i class="fas fa-play"></i> Mulai Operasi';
            startBtn.classList.remove('bg-amber-600','hover:bg-amber-700','opacity-50','cursor-not-allowed');
            startBtn.classList.add('bg-emerald-600','hover:bg-emerald-700');
        }
    }

    if (openBtn && modal) openBtn.addEventListener('click', () => { resetTimer(); modal.classList.remove('hidden'); modal.classList.add('flex'); });
    if (closeBtn && modal) closeBtn.addEventListener('click', () => { modal.classList.add('hidden'); modal.classList.remove('flex'); resetTimer(); });
    if (modal) modal.addEventListener('click', e => { if (e.target === modal) { modal.classList.add('hidden'); modal.classList.remove('flex'); resetTimer(); }});

    if (openTimerBtn) {
        openTimerBtn.addEventListener('click', () => {
            if (overviewPanel) overviewPanel.classList.add('hidden');
            if (timerPanel) timerPanel.classList.remove('hidden');
            if (notice) notice.classList.add('hidden');
            updateTimer();
        });
    }

    if (startBtn) {
        startBtn.addEventListener('click', () => {
            if (!timerInterval) {
                timerInterval = setInterval(() => {
                    remaining = Math.max(0, remaining - 1);
                    updateTimer();
                    if (remaining <= 0) {
                        clearInterval(timerInterval); timerInterval = null;
                        if (notice) { notice.classList.remove('hidden'); notice.textContent = 'Waktu operasi habis. Tekan Selesai Operasi.'; }
                    }
                }, 1000);
                startBtn.innerHTML = '<i class="fas fa-pause"></i> Pause';
                startBtn.classList.remove('bg-emerald-600','hover:bg-emerald-700');
                startBtn.classList.add('bg-amber-600','hover:bg-amber-700');
            } else {
                clearInterval(timerInterval); timerInterval = null;
                startBtn.innerHTML = '<i class="fas fa-play"></i> Lanjutkan';
                startBtn.classList.remove('bg-amber-600','hover:bg-amber-700');
                startBtn.classList.add('bg-emerald-600','hover:bg-emerald-700');
            }
        });
    }

    if (finishBtn) {
        finishBtn.addEventListener('click', () => {
            clearInterval(timerInterval); timerInterval = null;
            if (notice) { notice.classList.remove('hidden'); notice.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Operasi selesai. Klik tutup untuk kembali.'; }
            if (startBtn) { startBtn.disabled = true; startBtn.classList.add('opacity-50','cursor-not-allowed'); }
        });
    }

    if (finishOverviewBtn) {
        finishOverviewBtn.addEventListener('click', () => {
            if (notice) { notice.classList.remove('hidden'); notice.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Operasi selesai. Klik tutup untuk kembali.'; }
        });
    }
})();

// Modal Kalender Jadwal Operasi
function initKalenderModal() {
    const kalenderModal = document.getElementById('kalenderModal');
    const btnOpenKalenderModal = document.getElementById('btnOpenKalenderModal');
    const closeButtons = document.querySelectorAll('#btnCloseKalenderModal');

    if (btnOpenKalenderModal && kalenderModal) {
        btnOpenKalenderModal.addEventListener('click', (e) => {
            e.preventDefault();
            kalenderModal.classList.remove('hidden');
            kalenderModal.classList.add('flex');
        });
    }

    closeButtons.forEach(btn => {
        if (btn && kalenderModal) {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                kalenderModal.classList.add('hidden');
                kalenderModal.classList.remove('flex');
            });
        }
    });

    if (kalenderModal) {
        kalenderModal.addEventListener('click', (e) => {
            if (e.target === kalenderModal) {
                kalenderModal.classList.add('hidden');
                kalenderModal.classList.remove('flex');
            }
        });
    }
}

// Initialize after DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initKalenderModal);
} else {
    initKalenderModal();
}
</script>

{{-- ============================================================ --}}
{{-- MODAL KALENDER JADWAL OPERASI                                --}}
{{-- ============================================================ --}}
<div id="kalenderModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background: rgba(15,23,42,0.64); backdrop-filter: blur(5px);">
    <div class="w-full max-h-[90vh] max-w-5xl overflow-y-auto rounded-2xl bg-white shadow-2xl">

        {{-- Modal Header --}}
        <div class="sticky top-0 flex items-start justify-between border-b border-slate-200 bg-white p-6">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Jadwal Operasi</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-900">Kalender Tahunan</h2>
                <p class="mt-1 text-sm text-slate-600">Lihat semua jadwal operasi dalam setahun.</p>
            </div>
            <button id="btnCloseKalenderModal" class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-lg font-bold text-slate-600 transition hover:bg-slate-100">&times;</button>
        </div>

        {{-- Modal Content --}}
        <div class="p-6 space-y-6">
            {{-- Keterangan --}}
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 mb-3">Keterangan</p>
                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded bg-red-500"></div>
                        <span class="text-sm text-slate-600">Jadwal Operasi</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded bg-slate-200 border border-slate-300"></div>
                        <span class="text-sm text-slate-600">Tanggal Kosong</span>
                    </div>
                </div>
            </div>

            {{-- Kalender Grid --}}
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @php
                    $months = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];
                    $monthNumbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
                    $currentYear = now()->year;
                    
                    $allSchedules = \App\Models\SurgerySchedule::whereYear('tanggal_operasi', $currentYear)
                        ->select('tanggal_operasi')
                        ->get();
                    $scheduleDates = $allSchedules->map(fn($s) => $s->tanggal_operasi->format('Y-m-d'))->toArray();
                @endphp
                
                @foreach($months as $index => $month)
                    @php
                        $monthNum = $monthNumbers[$index];
                        $firstDay = \Carbon\Carbon::createFromDate($currentYear, $monthNum, 1);
                        $daysInMonth = $firstDay->daysInMonth;
                        $startingDayOfWeek = $firstDay->dayOfWeek;
                        $startingDayOfWeek = ($startingDayOfWeek == 0) ? 6 : $startingDayOfWeek - 1;
                    @endphp
                    <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        {{-- Header Bulan --}}
                        <div class="bg-gradient-to-r from-slate-800 to-slate-700 px-4 py-3 text-white">
                            <h3 class="text-sm font-bold uppercase tracking-[0.1em]">{{ $month }}</h3>
                            <p class="text-xs text-slate-300 mt-0.5">{{ $currentYear }}</p>
                        </div>

                        {{-- Calendar Grid --}}
                        <div class="p-3">
                            {{-- Days of Week --}}
                            <div class="grid grid-cols-7 gap-1 mb-2">
                                @foreach(['M', 'T', 'W', 'T', 'F', 'S', 'S'] as $day)
                                    <div class="text-center text-[10px] font-bold text-slate-500 py-1">{{ $day }}</div>
                                @endforeach
                            </div>

                            {{-- Days --}}
                            <div class="grid grid-cols-7 gap-1">
                                @for($i = 0; $i < $startingDayOfWeek; $i++)
                                    <div class="aspect-square"></div>
                                @endfor

                                @for($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $dateStr = sprintf('%04d-%02d-%02d', $currentYear, $monthNum, $day);
                                        $hasSchedule = in_array($dateStr, $scheduleDates);
                                        $isToday = $dateStr === now()->toDateString();
                                    @endphp
                                    <div class="aspect-square flex items-center justify-center rounded text-xs font-semibold
                                        @if($hasSchedule)
                                            bg-red-500 text-white hover:bg-red-600
                                        @elseif($isToday)
                                            border-2 border-blue-500 text-slate-900 bg-blue-50 hover:bg-blue-100
                                        @else
                                            bg-slate-100 text-slate-600 hover:bg-slate-200
                                        @endif
                                        transition cursor-pointer">
                                        {{ $day }}
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Statistik --}}
            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-xl border border-slate-200 bg-gradient-to-br from-slate-50 to-white p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Total Jadwal Tahun {{ $currentYear }}</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ count($scheduleDates) }}</p>
                </div>

                @php
                    $thisMonth = collect($scheduleDates)->filter(fn($date) => 
                        substr($date, 0, 7) === now()->format('Y-m')
                    )->count();
                @endphp
                <div class="rounded-xl border border-slate-200 bg-gradient-to-br from-blue-50 to-white p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Jadwal {{ now()->format('F') }}</p>
                    <p class="mt-2 text-3xl font-bold text-blue-600">{{ $thisMonth }}</p>
                </div>

                @php
                    $average = count($scheduleDates) > 0 ? round(count($scheduleDates) / 12, 1) : 0;
                @endphp
                <div class="rounded-xl border border-slate-200 bg-gradient-to-br from-emerald-50 to-white p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Rata-rata/Bulan</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $average }}</p>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex gap-3 justify-center pt-4">
                <a href="{{ route('jadwal-operasi') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-6 py-3 text-white font-semibold hover:bg-slate-800 transition">
                    <i class="fas fa-list"></i> Kelola Jadwal
                </a>
                <button id="btnCloseKalenderModal" type="button" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-6 py-3 text-slate-900 font-semibold hover:bg-slate-100 transition">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
