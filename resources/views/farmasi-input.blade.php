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
                <div class="grid grid-cols-2 gap-y-2 gap-x-4 text-sm text-slate-600">
                    <div class="text-slate-500">Nama Pasien</div>
                    <div class="font-semibold text-slate-900 text-right">Anisa Putri</div>

                    <div class="text-slate-500">Tindakan</div>
                    <div class="text-right">Appendektomi</div>

                    <div class="text-slate-500">Dokter Bedah</div>
                    <div class="text-right">dr xxxxxxx</div>

                    <div class="text-slate-500">Ruang Operasi</div>
                    <div class="text-right">OK 01</div>
                </div>
            </div>

            <div class="rounded-2xl bg-white border p-6">
                <h3 class="font-semibold text-slate-900 mb-3">Pilih Paket Obat</h3>
                <div class="flex gap-3 items-center">
                    <select class="input-base flex-1">
                        <option>Pilih</option>
                        @foreach($packages as $pkg)
                            <option>{{ $pkg->nama_paket ?? 'Paket '.$loop->iteration }}</option>
                        @endforeach
                    </select>
                    <button class="btn-secondary inline-flex items-center gap-2"><i class="fas fa-eye"></i> Lihat Detail Paket</button>
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
                    <table class="w-full text-sm text-slate-700 table-auto">
                        <thead class="bg-slate-50 text-left text-xs uppercase tracking-[0.18em] text-slate-500">
                            <tr>
                                <th class="px-4 py-3 w-12">No</th>
                                <th class="px-4 py-3">Nama Obat</th>
                                <th class="px-4 py-3 w-28">Bentuk</th>
                                <th class="px-4 py-3 w-28">Satuan</th>
                                <th class="px-4 py-3 w-28">Jumlah</th>
                                <th class="px-4 py-3 w-16">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @php $sample = $medicines->take(6); @endphp
                            @foreach($sample as $i => $m)
                                <tr>
                                    <td class="px-4 py-3 font-semibold">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3">{{ $m->nama_obat ?? 'Obat '.$i }}</td>
                                    <td class="px-4 py-3">{{ $m->bentuk ?? 'Injeksi' }}</td>
                                    <td class="px-4 py-3">{{ $m->satuan ?? 'Ampul' }}</td>
                                    <td class="px-4 py-3">
                                        <input type="number" class="input-base w-20 text-center" value="1" min="1">
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button class="text-rose-700 hover:text-rose-900"><i class="fas fa-trash"></i></button>
                                    </td>
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
