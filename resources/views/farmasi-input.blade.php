@extends('layouts.app')

@section('title','Input Paket Obat')

@push('styles')
<style>
    .form-row { display: grid; gap: 1rem; grid-template-columns: 1fr; }
    .form-row.sm\:grid-cols-2 { grid-template-columns: repeat(1, minmax(0,1fr)); }
    .form-row.sm\:grid-cols-2 > * { min-width: 0; }
    @media (min-width: 640px) { .form-row.sm\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0,1fr)); } }
    .form-label { display: block; margin-bottom: .5rem; font-size: .8rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: .14em; }
    .form-control { width: 100%; border-radius: 1rem; border: 1px solid #e2e8f0; padding: 1rem 1.1rem; background: #ffffff; color: #0f172a; }
    .form-control:focus { outline: none; border-color: #10b981; box-shadow: 0 0 0 4px rgba(16,185,129,0.12); }
    .table-strip tr:nth-child(even){ background: #f8fafc; }
    .table-strip th, .table-strip td { padding: 1rem 1.25rem; text-align: left; }
    .table-strip th { text-transform: uppercase; letter-spacing: .16em; font-size: .71rem; color: #64748b; }
    .badge-pill { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: .55rem .9rem; font-size: .72rem; font-weight: 700; }
    .badge-waiting { background: #fef3c7; color: #92400e; }
    .badge-ready { background: #dcfce7; color: #166534; }
    .badge-picked { background: #dbeafe; color: #1d4ed8; }
</style>
@endpush

@section('content')
<div class="space-y-8">
    <div class="page-band">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Unit Farmasi</p>
                <h1 class="text-3xl font-extrabold text-slate-900">Input Paket Obat</h1>
                <p class="mt-2 text-sm text-slate-600">Form input paket obat untuk operasi dengan verifikasi stok dan informasi pasien.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('farmasi') }}" class="btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[0.48fr_0.52fr]">
        @php $canInputFarmasi = auth()->user()?->role === 'farmasi'; @endphp
        <div class="space-y-6">
            <div class="card-panel p-6">
                <div class="flex items-start gap-4">
                    <div class="h-16 w-16 rounded-3xl bg-slate-100 flex items-center justify-center text-slate-500 text-2xl">
                        <i class="fas fa-pills"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Informasi Paket</p>
                        <h2 class="text-2xl font-bold text-slate-900 mt-3">Pengaturan Paket Obat Operasi</h2>
                        <p class="mt-3 text-sm text-slate-500">Masukkan nama paket, jenis obat, jumlah, dan instruksi untuk tim farmasi.</p>
                    </div>
                </div>
            </div>

            <div class="card-panel p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-5">Buat Paket Baru</h2>
                @if($canInputFarmasi)
                <form action="{{ route('farmasi.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="form-label" for="nama_paket">Nama Paket</label>
                        <input id="nama_paket" name="nama_paket" type="text" class="form-control" placeholder="Contoh: Paket Anestesi Umum" required>
                    </div>
                    <div>
                        <label class="form-label" for="jenis_obat">Jenis Obat</label>
                        <input id="jenis_obat" name="jenis_obat" type="text" class="form-control" placeholder="Contoh: Analgesik, Antibiotik" required>
                    </div>
                    <div>
                        <label class="form-label" for="total_paket">Jumlah Item</label>
                        <input id="total_paket" name="total_paket" type="number" min="1" value="1" class="form-control" required>
                    </div>
                    <div class="form-row sm:grid-cols-2">
                        <div>
                            <label class="form-label" for="preoperatif">Instruksi Preoperatif</label>
                            <input id="preoperatif" name="preoperatif" type="text" class="form-control" placeholder="Contoh: Puasa 8 jam">
                        </div>
                        <div>
                            <label class="form-label" for="intraoperatif">Instruksi Intraoperatif</label>
                            <input id="intraoperatif" name="intraoperatif" type="text" class="form-control" placeholder="Contoh: Siapkan infus">
                        </div>
                    </div>
                    <div>
                        <label class="form-label" for="postoperatif">Instruksi Postoperatif</label>
                        <input id="postoperatif" name="postoperatif" type="text" class="form-control" placeholder="Contoh: Observasi 24 jam">
                    </div>
                    <div class="flex flex-wrap gap-3 mt-2">
                        <button type="submit" class="btn-primary">Simpan Paket</button>
                    </div>
                </form>
                @else
                    <div class="rounded-lg border border-slate-200 p-6 bg-slate-50 text-center">
                        <p class="text-lg font-semibold">Akses Terbatas</p>
                        <p class="mt-2 text-sm text-slate-600">Anda tidak memiliki izin untuk membuat paket obat. Hubungi Unit Farmasi jika perlu.</p>
                        <div class="mt-4">
                            <a href="{{ route('farmasi') }}" class="btn-secondary">Kembali</a>
                        </div>
                    </div>
                @endif
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 text-center">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Total Paket</p>
                    <p class="mt-3 text-3xl font-black text-slate-900">{{ $summary['total_paket'] ?? 0 }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 text-center">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Status Menunggu</p>
                    <p class="mt-3 text-3xl font-black text-emerald-700">{{ $summary['waiting'] ?? 0 }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 text-center">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Siap Diambil</p>
                    <p class="mt-3 text-3xl font-black text-slate-900">{{ $summary['ready'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="card-panel p-6">
            <div class="mb-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500 font-semibold">Data Obat dalam Paket</p>
                <h2 class="text-xl font-bold text-slate-900 mt-2">Item Obat Tersedia</h2>
            </div>

            <div class="overflow-x-auto rounded-3xl border border-slate-200">
                <table class="table-strip w-full text-slate-700">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Bentuk</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sample = $medicines->take(8); @endphp
                        @forelse($sample as $i => $medicine)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td class="font-semibold text-slate-900">{{ $medicine->nama_obat ?? 'Obat '.($i + 1) }}</td>
                                <td>{{ $medicine->bentuk ?? 'Tablet' }}</td>
                                <td>{{ $medicine->satuan ?? 'Kapsul' }}</td>
                                <td>{{ $medicine->stok_obat ?? 1 }}</td>
                                <td><span class="badge-pill {{ ($medicine->status ?? 'Tersedia') === 'Tersedia' ? 'badge-ready' : (($medicine->status ?? '') === 'Menipis' ? 'badge-waiting' : 'badge-picked') }}">{{ $medicine->status ?? 'Tersedia' }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-slate-400">Belum ada data obat tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">* Data diambil dari stok farmasi dan dapat diverifikasi lebih lanjut.</p>
                <div class="flex flex-wrap gap-3">
                    <button class="btn-secondary">Batalkan</button>
                    <button class="btn-primary">Simpan & Verifikasi</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
