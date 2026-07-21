@extends('layouts.app')

@section('title','DPJB CPPT')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">DPJB</p>
            <h1 class="text-4xl font-bold text-slate-900">Observasi Dokter & CPPT</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Isi lembar observasi dokter dan Catatan Perkembangan Pasien Terintegrasi untuk jadwal operasi.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('dashboard') }}" class="btn-secondary">Kembali ke Dashboard</a>
            <a href="{{ route('jadwal-operasi') }}" class="btn-primary">Lihat Jadwal</a>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-3xl border border-emerald-100 bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
    @endif

    <div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
        <div class="card-panel p-6">
            <h2 class="text-xl font-bold text-slate-900">Input Catatan Klinis</h2>
            <form action="{{ route('dpjb.cppt.store') }}" method="POST" class="mt-6 space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 mb-2">Jadwal Operasi</label>
                    <select name="surgery_schedule_id" class="input-base" required>
                        <option value="">Pilih pasien operasi</option>
                        @foreach($schedules as $schedule)
                            <option value="{{ $schedule->id }}" @selected(old('surgery_schedule_id') == $schedule->id)>
                                {{ $schedule->nama_pasien }} - RM {{ $schedule->nomor_rm }} - {{ date('d M Y', strtotime($schedule->tanggal_operasi)) }} {{ date('H:i', strtotime($schedule->jam_mulai)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('surgery_schedule_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 mb-2">Lembar Observasi Dokter</label>
                    <textarea name="lembar_observasi" rows="5" class="input-base" placeholder="Kondisi pra/intra/pasca operasi, tanda vital, instruksi khusus..." required>{{ old('lembar_observasi') }}</textarea>
                    @error('lembar_observasi')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 mb-2">CPPT</label>
                    <textarea name="cppt" rows="5" class="input-base" placeholder="SOAP, asesmen, rencana terapi, dan tindak lanjut..." required>{{ old('cppt') }}</textarea>
                    @error('cppt')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn-primary">Simpan Catatan</button>
                </div>
            </form>
        </div>

        <div class="card-panel p-6">
            <h2 class="text-xl font-bold text-slate-900">Catatan Terbaru</h2>
            <div class="mt-6 space-y-4">
                @forelse($notes as $note)
                    <div class="rounded-3xl border border-slate-200 bg-white p-5">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-bold text-slate-900">{{ $note->nama_pasien }} <span class="text-sm font-medium text-slate-500">RM {{ $note->nomor_rm }}</span></p>
                                <p class="text-xs text-slate-500">DPJB: {{ $note->dokter ?? 'Dokter' }} - {{ date('d M Y H:i', strtotime($note->created_at)) }}</p>
                            </div>
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Tersimpan</span>
                        </div>
                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Observasi</p>
                                <p class="mt-2 text-sm text-slate-700">{{ \Illuminate\Support\Str::limit($note->lembar_observasi, 160) }}</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">CPPT</p>
                                <p class="mt-2 text-sm text-slate-700">{{ \Illuminate\Support\Str::limit($note->cppt, 160) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-10 text-center text-slate-500">Belum ada catatan DPJB.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
