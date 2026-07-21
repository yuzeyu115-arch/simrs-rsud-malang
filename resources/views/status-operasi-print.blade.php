<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Lembar Dokter</title>
    <!-- Use Tailwind CSS for simplicity or standard CSS. Let's use Tailwind via CDN for quick matching of the complex UI -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; color: #0f172a; }
        .print-only { display: none; }
        @media print {
            body { background-color: white; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
            .print-only { display: block; }
            .shadow-sm, .shadow-md, .shadow-lg { box-shadow: none !important; border: 1px solid #e2e8f0; }
        }
    </style>
</head>
<body class="p-4 md:p-8">

    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500 mb-1">LAPORAN LEMBAR DOKTER</p>
                <h1 class="text-3xl font-black text-slate-900">Detail Hasil pemeriksaan pra operasi dan pasca operasi pasien.</h1>
            </div>
        </div>

        @php
            $activeOperation = $operasi ?? (object) [
                'nama_pasien' => 'Anisa Putri',
                'nomor_rm' => '2345678',
                'status' => 'Selesai',
                'nama_ruang' => 'Ruang Operasi A',
                'jenis_tindakan' => 'Apendektomi',
                'tanggal_operasi' => now()->toDateString(),
            ];
        @endphp

        <!-- Patient Header Card -->
        <div class="bg-white rounded-3xl p-6 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 rounded-full bg-slate-200 overflow-hidden shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($activeOperation->nama_pasien) }}&background=e2e8f0&color=475569" alt="Avatar" class="w-full h-full object-cover">
                </div>
                <div class="flex flex-wrap gap-8">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 mb-1">Nama Pasien</p>
                        <p class="text-sm font-bold text-slate-900">{{ $activeOperation->nama_pasien }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 mb-1">No. Rekam Medis</p>
                        <p class="text-sm font-bold text-slate-900">{{ $activeOperation->nomor_rm }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 mb-1">Status</p>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-bold text-emerald-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span> {{ $activeOperation->status }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 mb-1">Ruang</p>
                        <p class="text-sm font-bold text-slate-900">{{ $activeOperation->nama_ruang }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 mb-1">Jenis Operasi</p>
                        <p class="text-sm font-bold text-slate-900">{{ $activeOperation->jenis_tindakan }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 mb-1">Tanggal</p>
                        <p class="text-sm font-bold text-slate-900">{{ \Carbon\Carbon::parse($activeOperation->tanggal_operasi)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="no-print flex flex-wrap gap-3 shrink-0">
                <a href="{{ route('dashboard') }}" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-6 py-3 rounded-2xl font-bold text-sm transition shadow-sm flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button onclick="window.print()" class="bg-[#1e293b] hover:bg-slate-800 text-white px-6 py-3 rounded-2xl font-bold text-sm transition shadow-md flex items-center gap-2">
                    <i class="fas fa-print"></i> Cetak Laporan
                </button>
            </div>
        </div>

        <!-- Main Content 2 Columns -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
            
            <!-- PRA OPERASI -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-slate-50 border-b border-slate-100 p-6">
                    <h2 class="text-xl font-black text-slate-900">Pra Operasi</h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Ringkasan Pra Operasi -->
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2"><i class="fas fa-file-medical text-slate-400"></i> Ringkasan Pra Operasi</h3>
                        
                        <div class="border border-slate-200 rounded-xl overflow-hidden">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold border-b border-slate-200">Pemeriksaan Pra Operasi</th>
                                        <th class="px-4 py-3 font-semibold border-b border-slate-200">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <tr>
                                        <td class="px-4 py-3 font-semibold text-slate-900">Anamnesis</td>
                                        <td class="px-4 py-3 text-slate-600">Pasien mengeluh nyeri perut kanan bawah, mual (+)</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 font-semibold text-slate-900">Pemeriksaan Fisik</td>
                                        <td class="px-4 py-3 text-slate-600">TD: 120/80 mmHg, Nadi: 88x/mnt, Nyeri tekan McBurney (+)</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 font-semibold text-slate-900">Lab</td>
                                        <td class="px-4 py-3 text-slate-600">Hb: 12.5 g/dL, Leukosit: 14.000 /uL</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 font-semibold text-slate-900">Radiologi</td>
                                        <td class="px-4 py-3 text-slate-600">USG Abdomen: Tampak radang apendiks</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Persiapan Operasi -->
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2"><i class="fas fa-tasks text-slate-400"></i> Persiapan Operasi</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Persiapan Pasien -->
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                <p class="text-xs font-bold uppercase text-slate-500 mb-3">Persiapan Pasien</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start gap-2 text-sm text-slate-700">
                                        <i class="fas fa-check-square text-emerald-500 mt-0.5"></i> Puasa 8 jam
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-slate-700">
                                        <i class="fas fa-check-square text-emerald-500 mt-0.5"></i> Cukur area operasi
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-slate-700">
                                        <i class="fas fa-check-square text-emerald-500 mt-0.5"></i> Informed consent ditandatangani
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-slate-700">
                                        <i class="fas fa-check-square text-emerald-500 mt-0.5"></i> Pemasangan IV line
                                    </li>
                                </ul>
                            </div>
                            <!-- Persiapan Alat -->
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                <p class="text-xs font-bold uppercase text-slate-500 mb-3">Persiapan Alat</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start gap-2 text-sm text-slate-700">
                                        <i class="fas fa-check-square text-emerald-500 mt-0.5"></i> Set instrumen bedah dasar
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-slate-700">
                                        <i class="fas fa-check-square text-emerald-500 mt-0.5"></i> Set laparotomi / appendektomi
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-slate-700">
                                        <i class="fas fa-check-square text-emerald-500 mt-0.5"></i> Cauter machine siap
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-slate-700">
                                        <i class="fas fa-check-square text-emerald-500 mt-0.5"></i> Suction berfungsi baik
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PASCA OPERASI -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-slate-50 border-b border-slate-100 p-6">
                    <h2 class="text-xl font-black text-slate-900">Pasca Operasi</h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Ringkasan Pasca Operasi -->
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2"><i class="fas fa-file-medical text-slate-400"></i> Ringkasan Pasca Operasi</h3>
                        
                        <div class="border border-slate-200 rounded-xl overflow-hidden">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold border-b border-slate-200">Tindakan Pasca Operasi</th>
                                        <th class="px-4 py-3 font-semibold border-b border-slate-200">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <tr>
                                        <td class="px-4 py-3 font-semibold text-slate-900">Observasi TTV</td>
                                        <td class="px-4 py-3 text-slate-600">TD: 110/70, Nadi: 80x/m, RR: 18x/m, Suhu: 36.5°C</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 font-semibold text-slate-900">Perawatan Luka</td>
                                        <td class="px-4 py-3 text-slate-600">Luka operasi kering, terpasang drainase (-)</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 font-semibold text-slate-900">Terapi Cairan</td>
                                        <td class="px-4 py-3 text-slate-600">IVFD RL 20 tpm</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 font-semibold text-slate-900">Medikamentosa</td>
                                        <td class="px-4 py-3 text-slate-600">Inj. Ceftriaxone 1g/12j, Inj. Ketorolac 30mg/8j</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Catatan Dokter -->
                    <div>
                        <div class="bg-[#e8f5e9] border border-[#c8e6c9] rounded-2xl p-5 relative overflow-hidden">
                            <!-- Background decoration -->
                            <i class="fas fa-stethoscope absolute -bottom-4 -right-4 text-7xl text-[#c8e6c9] opacity-30 transform -rotate-12"></i>
                            
                            <h3 class="text-sm font-bold text-[#2e7d32] mb-2 flex items-center gap-2 relative z-10"><i class="fas fa-pen-nib"></i> Catatan Dokter</h3>
                            <p class="text-sm text-[#1b5e20] leading-relaxed relative z-10">
                                Operasi berjalan lancar tanpa komplikasi. Apendiks tampak hiperemis dan membesar, tidak perforasi. Pasien stabil saat dipindahkan ke Recovery Room. Pantau tanda vital tiap 2 jam, waspadai perdarahan. Mobilisasi bertahap setelah 24 jam post op.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
