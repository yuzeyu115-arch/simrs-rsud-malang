@extends('layouts.app')

@section('title','Input Paket Obat')

@push('styles')
<style>
    /* small helpers to mimic the design spacing and card look */
    .page-band { background: #eaf3e8; border-radius: 12px; padding: 22px; }
    .card-soft { border-radius: 18px; background: #fff; box-shadow: 0 6px 20px rgba(2,6,23,0.06); }
    .stat-pill { border-radius: 12px; background: #f8faf8; padding: 14px; }
</style>
@endpush

@section('content')
<div class="space-y-8">
    <div class="page-band">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Input Paket Obat</p>
                <h1 class="text-3xl font-extrabold text-slate-900">Manajemen pemberian obat pasca-operasi</h1>
                <p class="mt-1 text-sm text-slate-600">Atur paket, verifikasi stok, dan kirim ke ruang operasi.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('farmasi') }}" class="btn-secondary">Kembali</a>
                <button class="btn-primary">Simpan Paket</button>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[0.45fr_0.55fr]">
        <!-- Left Column -->
        <div class="space-y-6">
            <div class="card-soft p-6">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-slate-900">Informasi Pasien</h3>
                            <p class="text-xs text-slate-400">No RM xxxxxxx</p>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-x-4 text-sm text-slate-600">
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
                </div>
            </div>

            <div class="card-soft p-6">
                <h3 class="font-semibold text-slate-900 mb-3">Pilih Paket Obat</h3>
                <div class="grid gap-3">
                    <label class="text-xs text-slate-500">Kategori Obat</label>
                    <div class="flex gap-3">
                        <select class="input-base flex-1">
                            <option>Pilih</option>
                            @foreach($packages as $pkg)
                                <option>{{ $pkg->nama_paket ?? 'Paket '.$loop->iteration }}</option>
                            @endforeach
                        </select>
                        <button class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-800 rounded-xl font-semibold"> <i class="fas fa-eye"></i> Lihat Detail Paket</button>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-emerald-50 p-4 text-sm text-emerald-800">Pastikan stok obat tersedia di inventory sebelum melakukan konfirmasi paket.</div>

            <div class="grid grid-cols-3 gap-4">
                <div class="stat-pill text-center">
                    <p class="text-xs uppercase text-slate-500">Stok Farmasi</p>
                    <p class="mt-2 font-bold text-slate-900">Tersedia Lengkap</p>
                </div>
                <div class="stat-pill text-center">
                    @section('content')
                    <div class="min-h-screen bg-[#e6bcbc] p-6">
                        <div class="max-w-[1200px] mx-auto grid grid-cols-[220px_1fr] gap-6">
                            <!-- Sidebar (visual only, per design) -->
                            <aside class="h-full">
                                <div class="flex flex-col h-full">
                                    <div class="mb-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 bg-white rounded-md flex items-center justify-center">
                                                <img src="/css/img/logo.png" alt="logo" class="w-10" onerror="this.style.display='none'">
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold">RSUD KOTA MALANG</div>
                                                <div class="text-xs text-slate-700">Pelayanan Ramah, Kesehatan Optimal</div>
                                            </div>
                                        </div>
                                    </div>

                                    <nav class="bg-white card-soft p-4 rounded-xl">
                                        <ul class="space-y-2 text-sm">
                                            <li class="px-3 py-2 rounded bg-emerald-100 font-semibold">Dashboard</li>
                                            <li class="px-3 py-2 rounded">Jadwal Operasi</li>
                                            <li class="px-3 py-2 rounded">Bed Manager</li>
                                            <li class="px-3 py-2 rounded bg-emerald-600 text-white">Unit Farmasi</li>
                                        </ul>
                                    </nav>

                                    <div class="mt-auto text-sm text-rose-600 font-semibold">Keluar</div>
                                </div>
                            </aside>

                            <!-- Main content area -->
                            <main>
                                <div class="page-band card-soft p-6 mb-6">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h1 class="text-2xl font-extrabold text-slate-900">Input Paket Obat</h1>
                                            <p class="mt-1 text-sm text-slate-600">Manajemen pemberian obat pasca-operasi tindakan bedah terencana.</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <button class="btn-primary">Simpan Paket</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid gap-6 lg:grid-cols-[0.45fr_0.55fr]">
                                    <!-- Left Column content (Informasi & paket) -->
                                    <div class="space-y-6">
                                        <div class="card-soft p-6">
                                            <div class="flex items-start gap-4">
                                                <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between">
                                                        <h3 class="font-semibold text-slate-900">Informasi Pasien</h3>
                                                        <p class="text-xs text-slate-400">No RM xxxxxxx</p>
                                                    </div>
                                                    <div class="mt-4 grid grid-cols-2 gap-x-4 text-sm text-slate-600">
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
                                            </div>
                                        </div>

                                        <div class="card-soft p-6">
                                            <h3 class="font-semibold text-slate-900 mb-3">Pilih Paket Obat</h3>
                                            <div class="grid gap-3">
                                                <label class="text-xs text-slate-500">Kategori Obat</label>
                                                <div class="flex gap-3">
                                                    <select class="input-base flex-1">
                                                        <option>Pilih</option>
                                                        @foreach($packages as $pkg)
                                                            <option>{{ $pkg->nama_paket ?? 'Paket '.$loop->iteration }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-800 rounded-xl font-semibold"> <i class="fas fa-eye"></i> Lihat Detail Paket</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="rounded-xl bg-emerald-50 p-4 text-sm text-emerald-800">Pastikan stok obat tersedia di inventory sebelum melakukan konfirmasi paket.</div>

                                        <div class="grid grid-cols-3 gap-4">
                                            <div class="stat-pill text-center">
                                                <p class="text-xs uppercase text-slate-500">Stok Farmasi</p>
                                                <p class="mt-2 font-bold text-slate-900">Tersedia Lengkap</p>
                                            </div>
                                            <div class="stat-pill text-center">
                                                <p class="text-xs uppercase text-slate-500">Kontraindikasi</p>
                                                <p class="mt-2 font-bold text-slate-900">Tidak Ditemukan</p>
                                            </div>
                                            <div class="stat-pill text-center">
                                                <p class="text-xs uppercase text-slate-500">Terakhir Update</p>
                                                @extends('layouts.app')

                                                @section('title','Input Paket Obat')

                                                @push('styles')
                                                <style>
                                                    .page-band { background: #eaf3e8; border-radius: 12px; padding: 22px; }
                                                    .card-soft { border-radius: 18px; background: #fff; box-shadow: 0 6px 20px rgba(2,6,23,0.06); }
                                                    .stat-pill { border-radius: 12px; background: #f8faf8; padding: 14px; }
                                                </style>
                                                @endpush

                                                @section('content')
                                                <div class="min-h-screen bg-[#e6bcbc] p-6">
                                                    <div class="max-w-[1200px] mx-auto grid grid-cols-[220px_1fr] gap-6">
                                                        <!-- Sidebar (visual only) -->
                                                        <aside class="h-full">
                                                            <div class="flex flex-col h-full">
                                                                <div class="mb-6">
                                                                    <div class="flex items-center gap-3">
                                                                        <div class="w-12 h-12 bg-white rounded-md flex items-center justify-center">
                                                                            <img src="/css/img/logo.png" alt="logo" class="w-10" onerror="this.style.display='none'">
                                                                        </div>
                                                                        <div>
                                                                            <div class="text-sm font-bold">RSUD KOTA MALANG</div>
                                                                            <div class="text-xs text-slate-700">Pelayanan Ramah, Kesehatan Optimal</div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <nav class="bg-white card-soft p-4 rounded-xl">
                                                                    <ul class="space-y-2 text-sm">
                                                                        <li class="px-3 py-2 rounded bg-emerald-100 font-semibold">Dashboard</li>
                                                                        <li class="px-3 py-2 rounded">Jadwal Operasi</li>
                                                                        <li class="px-3 py-2 rounded bg-emerald-600 text-white">Unit Farmasi</li>
                                                                    </ul>
                                                                </nav>

                                                                <div class="mt-auto text-sm text-rose-600 font-semibold">Keluar</div>
                                                            </div>
                                                        </aside>

                                                        <main>
                                                            <div class="page-band card-soft p-6 mb-6">
                                                                <div class="flex items-center justify-between">
                                                                    <div>
                                                                        <h1 class="text-2xl font-extrabold text-slate-900">Input Paket Obat</h1>
                                                                        <p class="mt-1 text-sm text-slate-600">Manajemen pemberian obat pasca-operasi.</p>
                                                                    </div>
                                                                    <div class="flex items-center gap-3">
                                                                        <a href="{{ route('farmasi') }}" class="btn-secondary">Kembali</a>
                                                                        <button class="btn-primary">Simpan Paket</button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="grid gap-6 lg:grid-cols-[0.45fr_0.55fr]">
                                                                <div class="space-y-6">
                                                                    <div class="card-soft p-6">
                                                                        <div class="flex items-start gap-4">
                                                                            <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                                                                <i class="fas fa-user"></i>
                                                                            </div>
                                                                            <div class="flex-1">
                                                                                <div class="flex items-center justify-between">
                                                                                    <h3 class="font-semibold text-slate-900">Informasi Pasien</h3>
                                                                                    <p class="text-xs text-slate-400">No RM xxxxxxx</p>
                                                                                </div>
                                                                                <div class="mt-4 grid grid-cols-2 gap-x-4 text-sm text-slate-600">
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
                                                                        </div>
                                                                    </div>

                                                                    <div class="card-soft p-6">
                                                                        <h3 class="font-semibold text-slate-900 mb-3">Pilih Paket Obat</h3>
                                                                        <div class="grid gap-3">
                                                                            <label class="text-xs text-slate-500">Kategori Obat</label>
                                                                            <div class="flex gap-3">
                                                                                <select class="input-base flex-1">
                                                                                    <option>Pilih</option>
                                                                                    @foreach($packages as $pkg)
                                                                                        <option>{{ $pkg->nama_paket ?? 'Paket '.$loop->iteration }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <button class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-800 rounded-xl font-semibold"> <i class="fas fa-eye"></i> Lihat Detail Paket</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="rounded-xl bg-emerald-50 p-4 text-sm text-emerald-800">Pastikan stok obat tersedia di inventory sebelum melakukan konfirmasi paket.</div>

                                                                    <div class="grid grid-cols-3 gap-4">
                                                                        <div class="stat-pill text-center">
                                                                            <p class="text-xs uppercase text-slate-500">Stok Farmasi</p>
                                                                            <p class="mt-2 font-bold text-slate-900">Tersedia Lengkap</p>
                                                                        </div>
                                                                        <div class="stat-pill text-center">
                                                                            <p class="text-xs uppercase text-slate-500">Kontraindikasi</p>
                                                                            <p class="mt-2 font-bold text-slate-900">Tidak Ditemukan</p>
                                                                        </div>
                                                                        <div class="stat-pill text-center">
                                                                            <p class="text-xs uppercase text-slate-500">Terakhir Update</p>
                                                                            <p class="mt-2 font-bold text-slate-900">Baru Saja</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div>
                                                                    <div class="card-soft overflow-hidden">
                                                                        <div class="px-6 py-4 border-b bg-white flex items-center justify-between">
                                                                            <div>
                                                                                <h3 class="font-semibold text-slate-900">Data Obat dalam Paket</h3>
                                                                                <p class="text-xs text-slate-500">Total {{ $summary['total_paket'] ?? 0 }} Item Obat Terpilih</p>
                                                                            </div>
                                                                            <a href="#" class="text-emerald-700 font-semibold">Tambah Obat Manual</a>
                                                                        </div>

                                                                        <div class="overflow-x-auto p-6">
                                                                            <table class="w-full text-sm text-slate-700">
                                                                                <thead class="bg-slate-50 text-left text-xs uppercase tracking-[0.18em] text-slate-500">
                                                                                    <tr>
                                                                                        <th class="px-4 py-3 w-12">No</th>
                                                                                        <th class="px-4 py-3">Nama Obat</th>
                                                                                        <th class="px-4 py-3 w-28">Bentuk</th>
                                                                                        <th class="px-4 py-3 w-28">Satuan</th>
                                                                                        <th class="px-4 py-3 w-24">Jumlah</th>
                                                                                        <th class="px-4 py-3 w-16">Aksi</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody class="divide-y divide-slate-200">
                                                                                    @php $sample = $medicines->take(6); @endphp
                                                                                    @foreach($sample as $i => $m)
                                                                                        <tr class="align-middle">
                                                                                            <td class="px-4 py-3 font-semibold">0{{ $i + 1 }}</td>
                                                                                            <td class="px-4 py-3 font-semibold text-slate-900">{{ $m->nama_obat ?? 'Obat '.$i }}</td>
                                                                                            <td class="px-4 py-3">{{ $m->bentuk ?? 'Injeksi' }}</td>
                                                                                            <td class="px-4 py-3">{{ $m->satuan ?? 'Ampul' }}</td>
                                                                                            <td class="px-4 py-3"><input type="number" class="input-base w-20 text-center" value="1" min="1"></td>
                                                                                            <td class="px-4 py-3 text-center"><button class="text-rose-700 hover:text-rose-900"><i class="fas fa-trash"></i></button></td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                        <div class="px-6 py-4 bg-white border-t flex items-center justify-between">
                                                                            <div class="text-sm text-slate-500">* Data sinkron dengan stok Unit Farmasi Kamar Bedah</div>
                                                                            <div class="flex items-center gap-3">
                                                                                <button class="rounded-2xl border px-4 py-2">Batalkan</button>
                                                                                <button class="btn-primary">Simpan & Verifikasi</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </main>
                                                    </div>
                                                </div>
                                                @endsection
