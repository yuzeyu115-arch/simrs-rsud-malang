@extends('layouts.app')

@section('title','Kalender Jadwal Operasi')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Jadwal Operasi</p>
            <h1 class="mt-1 text-3xl font-bold text-slate-900">Lihat Jadwal</h1>
            <p class="mt-1.5 text-sm text-slate-600 max-w-2xl">Lihat kalender jadwal operasi sepanjang tahun untuk memudahkan perencanaan.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('jadwal-operasi') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Jadwal
            </a>
        </div>
    </div>

    {{-- Keterangan Warna --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 mb-3">Keterangan</p>
        <div class="flex flex-wrap gap-4">
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-red-500"></div>
                <span class="text-sm text-slate-600">Jadwal Operasi</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-slate-200"></div>
                <span class="text-sm text-slate-600">Tanggal Kosong</span>
            </div>
        </div>
    </div>

    {{-- Calendar Grid --}}
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @php
            $months = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];
            $monthNumbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
            $currentYear = now()->year;
            
            // Ambil jadwal operasi dari database
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
                $startingDayOfWeek = $firstDay->dayOfWeek; // 0 = Sunday
                
                // Adjust so Monday is first day
                $startingDayOfWeek = ($startingDayOfWeek == 0) ? 6 : $startingDayOfWeek - 1;
            @endphp
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                {{-- Header Bulan --}}
                <div class="bg-gradient-to-r from-slate-900 to-slate-800 px-4 py-3 text-white">
                    <h3 class="text-sm font-bold uppercase tracking-[0.1em]">{{ $month }}</h3>
                    <p class="text-xs text-slate-300 mt-1">{{ $currentYear }}</p>
                </div>

                {{-- Calendar Grid --}}
                <div class="p-4">
                    {{-- Days of Week Header --}}
                    <div class="grid grid-cols-7 gap-1 mb-2">
                        @foreach(['M', 'T', 'W', 'T', 'F', 'S', 'S'] as $day)
                            <div class="text-center text-[11px] font-bold text-slate-500 py-1">{{ $day }}</div>
                        @endforeach
                    </div>

                    {{-- Days Grid --}}
                    <div class="grid grid-cols-7 gap-1">
                        {{-- Empty cells before first day of month --}}
                        @for($i = 0; $i < $startingDayOfWeek; $i++)
                            <div class="aspect-square"></div>
                        @endfor

                        {{-- Days of month --}}
                        @for($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $dateStr = sprintf('%04d-%02d-%02d', $currentYear, $monthNum, $day);
                                $hasSchedule = in_array($dateStr, $scheduleDates);
                                $isToday = $dateStr === now()->toDateString();
                            @endphp
                            <div class="aspect-square flex items-center justify-center rounded text-sm
                                @if($hasSchedule)
                                    bg-red-500 text-white font-bold hover:bg-red-600
                                @elseif($isToday)
                                    border-2 border-blue-500 text-slate-900 font-semibold bg-blue-50
                                @else
                                    bg-slate-100 text-slate-600 hover:bg-slate-200
                                @endif
                                transition cursor-pointer relative group">
                                {{ $day }}
                                
                                {{-- Tooltip untuk jadwal --}}
                                @if($hasSchedule)
                                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover:block bg-slate-900 text-white text-xs rounded px-2 py-1 whitespace-nowrap z-10">
                                        <i class="fas fa-calendar-check mr-1"></i>Jadwal ada
                                    </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Statistik --}}
    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Total Jadwal</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ count($scheduleDates) }}</p>
                    <p class="mt-1 text-xs text-slate-500">Tahun {{ $currentYear }}</p>
                </div>
                <div class="text-4xl text-slate-200">
                    <i class="fas fa-calendar"></i>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Jadwal Bulan Ini</p>
                    <p class="mt-2 text-3xl font-bold text-blue-600">
                        @php
                            $thisMonth = collect($scheduleDates)->filter(fn($date) => 
                                substr($date, 0, 7) === now()->format('Y-m')
                            )->count();
                        @endphp
                        {{ $thisMonth }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">{{ now()->format('F Y') }}</p>
                </div>
                <div class="text-4xl text-blue-200">
                    <i class="fas fa-list"></i>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Rata-rata per Bulan</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-600">
                        @php
                            $average = count($scheduleDates) > 0 ? round(count($scheduleDates) / 12, 1) : 0;
                        @endphp
                        {{ $average }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">Per bulan</p>
                </div>
                <div class="text-4xl text-emerald-200">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Status --}}
    <div class="grid gap-4 md:grid-cols-4">
        @php
            $statusSelesai = \App\Models\SurgerySchedule::where('status', 'Selesai')->count();
            $statusBerjalan = \App\Models\SurgerySchedule::where('status', 'Berjalan')->count();
            $statusTerjadwal = \App\Models\SurgerySchedule::where('status', 'Terjadwal')->count();
            $statusDibatalkan = \App\Models\SurgerySchedule::where('status', 'Dibatalkan')->count();
        @endphp

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Terjadwal</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $statusTerjadwal }}</p>
                </div>
                <div class="text-4xl text-slate-200">
                    <i class="fas fa-hourglass"></i>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Berjalan</p>
                    <p class="mt-2 text-3xl font-bold text-sky-600">{{ $statusBerjalan }}</p>
                </div>
                <div class="text-4xl text-sky-200">
                    <i class="fas fa-spinner"></i>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Selesai</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $statusSelesai }}</p>
                </div>
                <div class="text-4xl text-emerald-200">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Dibatalkan</p>
                    <p class="mt-2 text-3xl font-bold text-amber-600">{{ $statusDibatalkan }}</p>
                </div>
                <div class="text-4xl text-amber-200">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Jadwal Bulan Ini --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-bold text-slate-900 mb-4">Jadwal Operasi Bulan {{ now()->format('F Y') }}</h2>
        
        @php
            $thisMonthSchedules = \App\Models\SurgerySchedule::whereYear('tanggal_operasi', $currentYear)
                ->whereMonth('tanggal_operasi', now()->month)
                ->orderBy('tanggal_operasi')
                ->orderBy('jam_mulai')
                ->get();
        @endphp

        @if($thisMonthSchedules->count() > 0)
            <div class="space-y-3 max-h-[500px] overflow-y-auto">
                @foreach($thisMonthSchedules as $schedule)
                    @php
                        $statusColor = match($schedule->status) {
                            'Selesai' => 'emerald',
                            'Berjalan' => 'sky',
                            'Dibatalkan' => 'amber',
                            default => 'slate',
                        };
                    @endphp
                    <div class="flex items-start gap-4 p-3 rounded-lg border border-slate-100 hover:border-red-200 hover:bg-red-50 transition">
                        <div class="flex-shrink-0 mt-1">
                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-red-100">
                                <i class="fas fa-calendar-check text-red-600"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $schedule->nama_pasien ?? 'N/A' }}</p>
                                    <p class="text-sm text-slate-600 mt-1">{{ $schedule->jenis_tindakan ?? 'N/A' }}</p>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                                    @if($statusColor === 'emerald')
                                        bg-emerald-100 text-emerald-700
                                    @elseif($statusColor === 'sky')
                                        bg-sky-100 text-sky-700
                                    @elseif($statusColor === 'amber')
                                        bg-amber-100 text-amber-700
                                    @else
                                        bg-slate-100 text-slate-600
                                    @endif
                                ">
                                    {{ $schedule->status }}
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-4 mt-2 text-xs text-slate-500">
                                <span><i class="fas fa-calendar mr-1"></i>{{ $schedule->tanggal_operasi->format('d M Y') }}</span>
                                <span><i class="fas fa-clock mr-1"></i>{{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} WIB</span>
                                <span><i class="fas fa-door-open mr-1"></i>{{ $schedule->operatingRoom?->nama_ruang ?? 'N/A' }}</span>
                                <span><i class="fas fa-user-md mr-1"></i>{{ $schedule->dokterBedah?->nama ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('jadwal-operasi.edit', $schedule->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg hover:bg-blue-100 text-blue-600 transition">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-calendar-times text-4xl text-slate-300 mb-3"></i>
                <p class="text-slate-500">Tidak ada jadwal operasi untuk bulan ini</p>
            </div>
        @endif
    </div>

    {{-- CTA --}}
    <div class="text-center">
        <a href="{{ route('jadwal-operasi') }}" class="btn-primary">
            <i class="fas fa-arrow-right mr-2"></i>Kelola Jadwal Operasi
        </a>
    </div>
</div>

<style>
    .calendar-day-red {
        background-color: rgb(239, 68, 68);
    }
</style>
@endsection
            @php
                $monthNum = $monthNumbers[$index];
                $firstDay = \Carbon\Carbon::createFromDate($currentYear, $monthNum, 1);
                $daysInMonth = $firstDay->daysInMonth;
                $startingDayOfWeek = $firstDay->dayOfWeek; // 0 = Sunday
                
                // Adjust so Monday is first day
                $startingDayOfWeek = ($startingDayOfWeek == 0) ? 6 : $startingDayOfWeek - 1;
            @endphp
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                {{-- Header Bulan --}}
                <div class="bg-gradient-to-r from-slate-900 to-slate-800 px-4 py-3 text-white">
                    <h3 class="text-sm font-bold uppercase tracking-[0.1em]">{{ $month }}</h3>
                    <p class="text-xs text-slate-300 mt-1">{{ $currentYear }}</p>
                </div>

                {{-- Calendar Grid --}}
                <div class="p-4">
                    {{-- Days of Week Header --}}
                    <div class="grid grid-cols-7 gap-1 mb-2">
                        @foreach(['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $day)
                            <div class="text-center text-[11px] font-bold text-slate-500 py-1">{{ $day }}</div>
                        @endforeach
                    </div>

                    {{-- Days Grid --}}
                    <div class="grid grid-cols-7 gap-1">
                        {{-- Empty cells before first day of month --}}
                        @for($i = 0; $i < $startingDayOfWeek; $i++)
                            <div class="aspect-square"></div>
                        @endfor

                        {{-- Days of month --}}
                        @for($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $dateStr = sprintf('%04d-%02d-%02d', $currentYear, $monthNum, $day);
                                $hasSchedule = in_array($dateStr, $scheduleDates);
                                $isToday = $dateStr === now()->toDateString();
                            @endphp
                            <div class="aspect-square flex items-center justify-center rounded
                                @if($hasSchedule)
                                    bg-red-500 text-white font-bold text-sm
                                @elseif($isToday)
                                    border-2 border-blue-500 text-slate-900 font-semibold text-sm
                                @else
                                    bg-slate-100 text-slate-600 text-sm
                                @endif
                                hover:shadow-md transition cursor-pointer relative group">
                                {{ $day }}
                                
                                {{-- Tooltip untuk jadwal --}}
                                @if($hasSchedule)
                                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover:block bg-slate-900 text-white text-xs rounded px-2 py-1 whitespace-nowrap z-10">
                                        <i class="fas fa-calendar-check mr-1"></i>Jadwal ada
                                    </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Statistik --}}
    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Total Jadwal</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ count($scheduleDates) }}</p>
                    <p class="mt-1 text-xs text-slate-500">Tahun {{ $currentYear }}</p>
                </div>
                <div class="text-4xl text-slate-200">
                    <i class="fas fa-calendar"></i>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Jadwal Bulan Ini</p>
                    <p class="mt-2 text-3xl font-bold text-blue-600">
                        @php
                            $thisMonth = collect($scheduleDates)->filter(fn($date) => 
                                substr($date, 0, 7) === now()->format('Y-m')
                            )->count();
                        @endphp
                        {{ $thisMonth }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">{{ now()->format('F Y') }}</p>
                </div>
                <div class="text-4xl text-blue-200">
                    <i class="fas fa-list"></i>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Rata-rata per Bulan</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-600">
                        @php
                            $average = count($scheduleDates) > 0 ? round(count($scheduleDates) / 12, 1) : 0;
                        @endphp
                        {{ $average }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">Per bulan</p>
                </div>
                <div class="text-4xl text-emerald-200">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Jadwal Bulan Ini --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-bold text-slate-900 mb-4">Jadwal Operasi Bulan {{ now()->format('F Y') }}</h2>
        
        @php
            $thisMonthSchedules = \App\Models\SurgerySchedule::whereYear('tanggal_operasi', $currentYear)
                ->whereMonth('tanggal_operasi', now()->month)
                ->orderBy('tanggal_operasi')
                ->orderBy('jam_mulai')
                ->get();
        @endphp

        @if($thisMonthSchedules->count() > 0)
            <div class="space-y-3">
                @foreach($thisMonthSchedules as $schedule)
                    <div class="flex items-start gap-4 p-3 rounded-lg border border-slate-100 hover:border-red-200 hover:bg-red-50 transition">
                        <div class="flex-shrink-0 mt-1">
                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-red-100">
                                <i class="fas fa-calendar-check text-red-600"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-slate-900">{{ $schedule->nama_pasien ?? 'N/A' }}</p>
                            <p class="text-sm text-slate-600 mt-1">{{ $schedule->jenis_tindakan ?? 'N/A' }}</p>
                            <div class="flex flex-wrap gap-4 mt-2 text-xs text-slate-500">
                                <span><i class="fas fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($schedule->tanggal_operasi)->format('d M Y') }}</span>
                                <span><i class="fas fa-clock mr-1"></i>{{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} WIB</span>
                                <span><i class="fas fa-door-open mr-1"></i>{{ $schedule->ruang?->nama_ruang ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('jadwal-operasi.edit', $schedule->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg hover:bg-blue-100 text-blue-600 transition">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-calendar-times text-4xl text-slate-300 mb-3"></i>
                <p class="text-slate-500">Tidak ada jadwal operasi untuk bulan ini</p>
            </div>
        @endif
    </div>

    {{-- CTA --}}
    <div class="text-center">
        <a href="{{ route('jadwal-operasi') }}" class="btn-primary">
            <i class="fas fa-arrow-right mr-2"></i>Kelola Jadwal Operasi
        </a>
    </div>
</div>

<style>
    .calendar-day-red {
        background-color: rgb(239, 68, 68);
    }
</style>
@endsection
