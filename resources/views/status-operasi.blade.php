@extends('layouts.app')

@section('title', 'Status Operasi')

@section('content')
    <div class="page-content">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-slate-900">STATUS OPERASI</h1>
            <div class="flex gap-3">
                <button onclick="location.reload()" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50">
                    <i class="fas fa-refresh mr-2"></i>Refresh
                </button>
            </div>
        </div>

        @if($operasi)
        <div class="grid grid-cols-3 gap-6">
            <!-- Left Column: Main Info -->
            <div class="col-span-2">
                <!-- Operasi Header -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="flex items-center justify-between border-b pb-4 mb-4">
                        <h2 class="text-xl font-bold text-slate-900">Operasi- {{ $operasi->nama_ruang ?? 'Ruang Operasi' }}</h2>
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-semibold rounded-full">● Live Update</span>
                    </div>

                    <!-- Patient & Doctor Info -->
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg">
                            <p class="text-xs text-slate-600 font-semibold mb-1">PASIEN</p>
                            <p class="text-lg font-bold text-slate-900">{{ $operasi->nama_pasien ?? 'N/A' }}</p>
                            <p class="text-xs text-slate-500 mt-1">RM: {{ $operasi->nomor_rm ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-lg">
                            <p class="text-xs text-slate-600 font-semibold mb-1">DOKTER BEDAH</p>
                            <p class="text-lg font-bold text-slate-900">{{ $operasi->dokter_bedah ?? 'N/A' }}</p>
                            <p class="text-xs text-slate-500 mt-1">Spesialis Bedah</p>
                        </div>
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-4 rounded-lg">
                            <p class="text-xs text-slate-600 font-semibold mb-1">TINDAKAN</p>
                            <p class="text-lg font-bold text-slate-900">{{ $operasi->jenis_tindakan ?? 'N/A' }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($operasi->jam_mulai)->format('H:i') }} WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Status Operasi Timeline -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Status Operasi</h3>
                    <div class="space-y-4">
                        <!-- Timeline Item 1 - Completed -->
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-4 h-4 rounded-full bg-green-500 border-4 border-green-100"></div>
                                <div class="w-0.5 h-12 bg-green-300 mt-2"></div>
                            </div>
                            <div class="pb-4">
                                <p class="font-semibold text-slate-900">Persiapan awal, inti dan pasien</p>
                                <p class="text-sm text-slate-500">Selesai - {{ \Carbon\Carbon::parse($operasi->jam_mulai)->format('H:i') }} WIB</p>
                            </div>
                        </div>

                        <!-- Timeline Item 2 - In Progress -->
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-4 h-4 rounded-full {{ $operasi->status === 'Berjalan' ? 'bg-blue-500 border-4 border-blue-100 animate-pulse' : 'bg-gray-300 border-4 border-gray-100' }}"></div>
                                <div class="w-0.5 h-12 {{ $operasi->status === 'Berjalan' ? 'bg-gray-300' : 'bg-gray-300' }} mt-2"></div>
                            </div>
                            <div class="pb-4">
                                <p class="font-semibold text-slate-900">{{ $operasi->status === 'Berjalan' ? 'Sedang Berlangsung' : 'Terjadwal' }}</p>
                                <p class="text-sm text-slate-500">{{ $operasi->status === 'Berjalan' ? 'Sedang' : 'Menunggu' }} - {{ \Carbon\Carbon::parse($operasi->jam_mulai)->format('H:i') }} WIB</p>
                            </div>
                        </div>

                        <!-- Timeline Item 3 - Pending -->
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-4 h-4 rounded-full bg-gray-300 border-4 border-gray-100"></div>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Operasi Selesai</p>
                                <p class="text-sm text-slate-500">Menunggu untuk diselesaikan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Operasi -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Informasi Operasi</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-500 font-semibold mb-1">RUANG OPERASI</p>
                            <p class="text-slate-900 font-semibold">{{ $operasi->nama_ruang ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-semibold mb-1">DOKTER ANESTESI</p>
                            <p class="text-slate-900 font-semibold">{{ $operasi->dokter_anestesi ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-semibold mb-1">TANGGAL OPERASI</p>
                            <p class="text-slate-900 font-semibold">{{ \Carbon\Carbon::parse($operasi->tanggal_operasi)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-semibold mb-1">STATUS</p>
                            <p class="text-slate-900 font-semibold">
                                <span class="px-2 py-1 rounded-full text-xs font-bold 
                                    @if($operasi->status === 'Berjalan') bg-blue-100 text-blue-800
                                    @elseif($operasi->status === 'Selesai') bg-green-100 text-green-800
                                    @elseif($operasi->status === 'Dibatalkan') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif
                                ">
                                    {{ $operasi->status }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Warning Alert -->
                    <div class="mt-4 bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded">
                        <p class="text-sm text-yellow-800">
                            <strong>⚠️ Catatan:</strong> Periksa semua alat dan medan terbileh sebelum melanjutkan.
                        </p>
                    </div>
                </div>

                <!-- Kontrol Operasi -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Kontrol Operasi</h3>
                    <div class="grid grid-cols-2 gap-4">
                                <a href="{{ route('status-operasi.notify', $operasi->id) }}" class="flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-lg hover:shadow-lg transition-all">
                            <i class="fas fa-bell"></i>
                            Kirim Notifikasi
                        </a>
                        <a href="{{ route('status-operasi.print', $operasi->id) }}" target="_blank" class="flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-slate-700 to-slate-900 text-white font-semibold rounded-lg hover:shadow-lg transition-all">
                            <i class="fas fa-print"></i>
                            Cetak Laporan
                        </a>
                        <a href="{{ route('status-operasi.photo', $operasi->id) }}" class="flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-sky-500 to-sky-700 text-white font-semibold rounded-lg hover:shadow-lg transition-all">
                            <i class="fas fa-camera"></i>
                            Foto Prosedur
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Additional Info -->
            <div class="col-span-1">
                <!-- Ruang Operasi Status -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Status Ruang Operasi</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                            <span class="text-sm font-semibold text-slate-700">Ruang A</span>
                            <span class="px-2 py-1 bg-blue-200 text-blue-800 text-xs font-bold rounded">AKTIF</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                            <span class="text-sm font-semibold text-slate-700">Ruang B</span>
                            <span class="px-2 py-1 bg-green-200 text-green-800 text-xs font-bold rounded">SIAP</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-semibold text-slate-700">Ruang C</span>
                            <span class="px-2 py-1 bg-gray-200 text-gray-800 text-xs font-bold rounded">KOSONG</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Tindakan Cepat</h3>
                    <div class="space-y-2">
                        <a href="{{ route('status-operasi.notify', $operasi->id) }}" class="w-full inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition-colors">
                            <i class="fas fa-bell"></i>
                            Kirim Notifikasi
                        </a>
                        <a href="{{ route('status-operasi.print', $operasi->id) }}" target="_blank" class="w-full inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition-colors">
                            <i class="fas fa-file"></i>
                            Cetak Laporan
                        </a>
                        <a href="{{ route('status-operasi.photo', $operasi->id) }}" class="w-full inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition-colors">
                            <i class="fas fa-camera"></i>
                            Foto Prosedur
                        </a>
                    </div>
                </div>

                <!-- Menuju Ke Halaman Ruang Tunggu -->
                <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-xl shadow-sm p-6 text-white">
                    <h3 class="text-lg font-bold mb-2">Menuju Ke Halaman</h3>
                    <p class="text-sm opacity-90 mb-4">Ruang Tunggu</p>
                    <p class="text-xs opacity-80 mb-4">Monitoring ruang tunggu Pasien</p>
                    <a href="{{ route('bed-manager') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-white text-green-600 font-bold rounded-lg hover:bg-gray-100 transition-colors">
                        Lihat Ruang Tunggu
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-xl shadow-sm p-8 text-center">
            <i class="fas fa-info-circle text-4xl text-slate-400 mb-4"></i>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Tidak Ada Operasi Aktif</h3>
            <p class="text-slate-600 mb-6">Saat ini tidak ada operasi yang sedang berlangsung atau terjadwal.</p>
            <a href="{{ route('jadwal-operasi') }}" class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Jadwal Operasi
            </a>
        </div>
        @endif
    </div>

    <style>
        .page-content {
            padding: 2rem;
        }
    </style>
@endsection
