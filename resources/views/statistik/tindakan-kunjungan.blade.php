<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Tindakan & Kunjungan - SIMRS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Statistik Tindakan & Kunjungan</h1>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg p-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Tambah Data Statistik</h2>
                    
                    <form action="{{ route('statistik-kunjungan.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal *</label>
                            <input name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" type="date" class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('tanggal') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Kunjungan *</label>
                            <input name="jumlah_kunjungan" value="{{ old('jumlah_kunjungan', '0') }}" type="number" min="0" class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('jumlah_kunjungan') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Operasi *</label>
                            <input name="jumlah_operasi" value="{{ old('jumlah_operasi', '0') }}" type="number" min="0" class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('jumlah_operasi') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tindakan Terbanyak</label>
                            <input name="tindakan_terbanyak" value="{{ old('tindakan_terbanyak') }}" type="text" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Contoh: Appendektomi">
                            @error('tindakan_terbanyak') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded font-semibold hover:bg-green-700">
                            Simpan Data
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Grafik Statistik</h2>
                    <canvas id="statisticChart"></canvas>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-800">Data Statistik</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Kunjungan</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Operasi</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Tindakan Terbanyak</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($stats as $s)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 font-semibold">{{ date('d/m/Y', strtotime($s->tanggal)) }}</td>
                                        <td class="px-4 py-3"><span class="px-2 py-1 bg-blue-100 text-blue-700 rounded font-semibold">{{ $s->jumlah_kunjungan }}</span></td>
                                        <td class="px-4 py-3"><span class="px-2 py-1 bg-green-100 text-green-700 rounded font-semibold">{{ $s->jumlah_operasi }}</span></td>
                                        <td class="px-4 py-3">{{ $s->tindakan_terbanyak ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada data statistik</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const stats = @json($stats);
        const labels = stats.map(s => new Date(s.tanggal).toLocaleDateString('id-ID')).reverse();
        const kunjungan = stats.map(s => s.jumlah_kunjungan).reverse();
        const operasi = stats.map(s => s.jumlah_operasi).reverse();

        const ctx = document.getElementById('statisticChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Kunjungan',
                        data: kunjungan,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4
                    },
                    {
                        label: 'Operasi',
                        data: operasi,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>
