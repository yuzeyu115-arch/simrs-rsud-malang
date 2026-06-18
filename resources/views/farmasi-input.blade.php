@extends('layouts.app')

@section('title','Input Paket Obat')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Unit Farmasi</p>
            <h1 class="text-4xl font-bold text-slate-900">Input Paket Obat</h1>
            <p class="mt-2 text-sm text-slate-600">Manajemen pemberian obat pasca-operasi tindakan bedah terencana.</p>
        </div>
        <div>
            <a href="{{ route('farmasi') }}" class="btn-secondary">Kembali</a>
            <button class="btn-primary">Simpan Paket</button>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[0.48fr_0.52fr]">
        <div class="space-y-6">
            <div class="rounded-2xl bg-white border p-6">
                <h3 class="font-semibold text-slate-900 mb-3">Informasi Pasien</h3>
                <div class="text-sm text-slate-600">
                    <p><strong>Nama Pasien</strong> <span class="float-right font-semibold">Anisa Putri</span></p>
                    <p class="mt-2"><strong>Tindakan</strong> <span class="float-right">Appendektomi</span></p>
                    <p class="mt-2"><strong>Dokter Bedah</strong> <span class="float-right">dr xxxxxxx</span></p>
                    <p class="mt-2"><strong>Ruang Operasi</strong> <span class="float-right">OK 01</span></p>
                </div>
            </div>

            <div class="rounded-2xl bg-white border p-6">
                <h3 class="font-semibold text-slate-900 mb-3">Pilih Paket Obat</h3>
                <div class="grid gap-3">
                    <select class="input-base">
                        <option>Pilih</option>
                        @foreach($packages as $pkg)
                            <option>{{ $pkg->nama_paket ?? 'Paket '.$loop->iteration }}</option>
                        @endforeach
                    </select>
                    <button class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-800 rounded-xl font-semibold"> <i class="fas fa-eye"></i> Lihat Detail Paket</button>
                </div>
            </div>

            <div class="rounded-2xl bg-emerald-50 p-4 text-sm text-emerald-800">
                Pastikan stok obat tersedia di inventory sebelum melakukan konfirmasi paket.
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="rounded-2xl bg-white border p-4 text-center">
                    <p class="text-xs text-slate-500 uppercase">Stok Farmasi</p>
                    <p class="mt-2 font-bold text-slate-900">Tersedia Lengkap</p>
                </div>
                <div class="rounded-2xl bg-white border p-4 text-center">
                    <p class="text-xs text-slate-500 uppercase">Kontraindikasi</p>
                    <p class="mt-2 font-bold text-slate-900">Tidak Ditemukan</p>
                </div>
                <div class="rounded-2xl bg-white border p-4 text-center">
                    <p class="text-xs text-slate-500 uppercase">Terakhir Update</p>
                    <p class="mt-2 font-bold text-slate-900">Baru Saja</p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white border p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-slate-900">Data Obat dalam Paket</h3>
                <a href="#" class="text-emerald-700 font-semibold">Tambah Obat Manual</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-slate-700">
                    <thead class="bg-slate-50 text-left text-xs uppercase tracking-[0.18em] text-slate-500">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Nama Obat</th>
                            <th class="px-4 py-3">Bentuk</th>
                            <th class="px-4 py-3">Satuan</th>
                            <th class="px-4 py-3">Jumlah</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @php
                            $sample = $medicines->take(6);
                        @endphp
                        @foreach($sample as $i => $m)
                            <tr>
                                <td class="px-4 py-3 font-semibold">{{ $i + 1 }}</td>
                                <td class="px-4 py-3">{{ $m->nama_obat ?? 'Obat '.$i }}</td>
                                <td class="px-4 py-3">{{ $m->bentuk ?? 'Injeksi' }}</td>
                                <td class="px-4 py-3">{{ $m->satuan ?? 'Ampul' }}</td>
                                <td class="px-4 py-3"><input type="number" class="input-base w-20" value="1" min="1"></td>
                                <td class="px-4 py-3"><button class="text-rose-700"><i class="fas fa-trash"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm text-slate-500">* Data sinkron dengan stok Unit Farmasi Kamar Bedah</div>
                <div class="flex gap-3">
                    <button class="rounded-2xl border px-4 py-2">Batalkan</button>
                    <button class="btn-primary">Simpan & Verifikasi</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
