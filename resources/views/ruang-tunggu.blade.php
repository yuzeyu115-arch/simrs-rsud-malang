<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Tunggu – SIMRS RSUD Malang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; }
        .badge-melayani { background: #16a34a; color: #fff; }
        .badge-menunggu  { background: #475569; color: #fff; }
        .badge-resep     { background: #78716c; color: #fff; }
        @keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:.4} }
        .live-dot { animation: pulse-dot 1.5s ease-in-out infinite; }
    </style>
</head>
<body class="min-h-screen p-6">

    {{-- ============================================================ --}}
    {{-- Header Bar                                                    --}}
    {{-- ============================================================ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-6 py-4 mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <p class="font-black text-slate-900 text-lg leading-none">SIMRS RSUD Malang</p>
                <p class="text-xs text-slate-500 mt-0.5">Sistem Informasi Manajemen Rumah Sakit</p>
            </div>
        </div>
        <div class="text-right">
            <p id="clockDate" class="text-sm font-bold text-slate-900 uppercase tracking-wide"></p>
            <p id="clockTime" class="text-xs text-slate-500 mt-0.5 font-semibold"></p>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- Main Content: 2 Column                                        --}}
    {{-- ============================================================ --}}
    <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] gap-6">

        {{-- LEFT: Ringkasan Antrean & Analisis --}}
        <div class="space-y-4">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-lg font-black text-slate-900 mb-6">Ringkasan Antrean &amp; Analisis</h2>

                {{-- Stat: Jumlah Pasien --}}
                <div class="bg-slate-50 rounded-xl p-5 mb-4 text-center border border-slate-100">
                    <p class="text-6xl font-black text-slate-900 tabular-nums" id="totalPasien">42</p>
                    <p class="text-sm text-slate-500 mt-2 font-medium">Jumlah Pasien Mengantri</p>
                </div>

                {{-- Stat: Waktu Tunggu --}}
                <div class="bg-slate-50 rounded-xl p-5 mb-4 text-center border border-slate-100">
                    <p class="text-5xl font-black text-slate-900 tabular-nums">15 <span class="text-2xl font-bold">min</span></p>
                    <p class="text-sm text-slate-500 mt-2 font-medium">Waktu Tunggu Rata-rata</p>
                </div>

                {{-- Stat: Dokter Bertugas --}}
                <div class="bg-slate-50 rounded-xl p-5 text-center border border-slate-100">
                    <p class="text-6xl font-black text-slate-900 tabular-nums">3</p>
                    <p class="text-sm text-slate-500 mt-2 font-medium">Jumlah Dokter Bertugas</p>
                </div>
            </div>

            {{-- Back Button --}}
            <a href="{{ route('dashboard') }}" class="flex items-center justify-center gap-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Dashboard
            </a>
        </div>

        {{-- RIGHT: Daftar Antrean Live --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 live-dot"></div>
                    <h2 class="text-lg font-black text-slate-900">Daftar Antrean Live</h2>
                </div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Update Realtime</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 font-bold text-slate-700 uppercase tracking-[0.12em] text-xs">Layanan</th>
                            <th class="px-6 py-4 font-bold text-slate-700 uppercase tracking-[0.12em] text-xs">Status</th>
                            <th class="px-6 py-4 font-bold text-slate-700 uppercase tracking-[0.12em] text-xs">Dokter</th>
                            <th class="px-6 py-4 font-bold text-slate-700 uppercase tracking-[0.12em] text-xs">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-5">
                                <p class="font-semibold text-slate-900">[Poliklinik Anak]</p>
                            </td>
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold badge-melayani whitespace-nowrap">
                                    SEDANG MELAYANI<br>(A-102)
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <p class="font-medium text-slate-700">dr. Andi</p>
                            </td>
                            <td class="px-6 py-5">
                                <p class="font-semibold text-slate-900 tabular-nums" id="time-1"></p>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-5">
                                <p class="font-semibold text-slate-900">[Poliklinik<br>Penyakit Dalam]</p>
                            </td>
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold badge-menunggu whitespace-nowrap">
                                    MENUNGGU PANGGILAN
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <p class="font-medium text-slate-700">dr. Budi</p>
                            </td>
                            <td class="px-6 py-5">
                                <p class="font-semibold text-slate-900 tabular-nums" id="time-2"></p>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-5">
                                <p class="font-semibold text-slate-900">[Unit Farmasi]</p>
                            </td>
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold badge-resep whitespace-nowrap">
                                    ANTREAN RESEP
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <p class="font-medium text-slate-700">dr. Rina</p>
                            </td>
                            <td class="px-6 py-5">
                                <p class="font-semibold text-slate-900 tabular-nums" id="time-3"></p>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-5">
                                <p class="font-semibold text-slate-900">[Radiologi]</p>
                            </td>
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold badge-menunggu whitespace-nowrap">
                                    MENUNGGU PANGGILAN
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <p class="font-medium text-slate-700">dr. Rina</p>
                            </td>
                            <td class="px-6 py-5">
                                <p class="font-semibold text-slate-900 tabular-nums" id="time-4"></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Total: <strong class="text-slate-700">42</strong> pasien dalam antrean</span>
                <span>Terakhir diperbarui: <strong id="lastUpdate" class="text-slate-700"></strong></span>
            </div>
        </div>
    </div>

    <script>
    (function() {
        const DAYS = ['MINGGU','SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU'];
        const MONTHS = ['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGU','SEP','OKT','NOV','DES'];

        function pad(n) { return String(n).padStart(2,'0'); }

        function tick() {
            const now = new Date();
            const day   = DAYS[now.getDay()];
            const date  = now.getDate();
            const month = MONTHS[now.getMonth()];
            const year  = now.getFullYear();
            const time  = pad(now.getHours()) + ':' + pad(now.getMinutes()) + ' WIB';

            const dateEl = document.getElementById('clockDate');
            const timeEl = document.getElementById('clockTime');
            if (dateEl) dateEl.textContent = day + ', ' + date + ' ' + month + ' ' + year;
            if (timeEl) timeEl.textContent = time;

            // Update antrean times (offset from now)
            const offsets = [0, 3, 5, 10];
            offsets.forEach((off, i) => {
                const t = new Date(now.getTime() + off * 60000);
                const el = document.getElementById('time-' + (i+1));
                if (el) el.textContent = pad(t.getHours()) + ':' + pad(t.getMinutes());
            });

            const lu = document.getElementById('lastUpdate');
            if (lu) lu.textContent = pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
        }

        tick();
        setInterval(tick, 1000);
    })();
    </script>
</body>
</html>
