<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Gizi - SimpleOK RSUD</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-green': '#10b981',
                        'primary-green-hover': '#059669',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f7f9f7; }
        .sidebar-active {
            background-color: #e8f5e9;
            color: #1b5e20;
            font-weight: 700;
        }
        .table-header { background-color: #f8fafc; }
        .btn-lihat {
            border: 1px solid #10b981;
            color: #10b981;
            padding: 2px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
        }
        .btn-lihat:hover {
            background-color: #10b981;
            color: white;
        }
    </style>
</head>
<body class="flex overflow-hidden h-screen text-gray-800">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col flex-shrink-0 shadow-sm z-20">
        <div class="p-6 flex items-center space-x-3">
            <div class="w-8 h-8 bg-primary-green rounded-lg flex items-center justify-center text-white shadow-md">
                <i class="fa-solid fa-hospital"></i>
            </div>
            <span class="text-xl font-bold text-gray-800 tracking-tight">SimpleOK</span>
        </div>

        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-4 mb-2">UTAMA</p>
            <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-house w-5"></i> <span>Dashboard KPI</span>
            </a>
            <a href="{{ url('/jadwal-operasi') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-calendar-check w-5"></i> <span>Jadwal Operasi (Bedah)</span>
            </a>
            <a href="{{ url('/bed-manager') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-bed w-5"></i> <span>Bed Manager</span>
            </a>

            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-6 mb-2">LOGISTIK</p>
            <a href="{{ url('/farmasi') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-pills w-5"></i> <span>Farmasi & Obat</span>
            </a>
            <a href="{{ url('/gizi') }}" class="flex items-center space-x-3 p-3 rounded-xl sidebar-active transition-all text-sm">
                 <i class="fa-solid fa-utensils w-5 text-primary-green"></i> <span>Gizi</span>
            </a>

            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-6 mb-2 text-gray-400">JANJI TEMU</p>
            <a href="{{ url('/janji-temu') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-calendar-plus w-5"></i> <span>Add Appointment</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-list-check w-5"></i> <span>List Appointment</span>
            </a>

            <div class="mt-auto pt-10 px-3 pb-8">
                <a href="{{ url('/logout') }}" class="flex items-center space-x-3 text-red-500 font-bold text-sm hover:underline">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <!-- Topbar -->
        <div class="sticky top-0 px-8 py-4 z-10 flex justify-between items-center bg-white border-b border-gray-50">
            <button class="text-gray-500 text-xl"><i class="fa-solid fa-bars"></i></button>
            <div class="flex items-center space-x-6">
                <div class="relative text-gray-400">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[8px] font-bold w-4 h-4 rounded-full flex items-center justify-center">3</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-800 leading-none">Dr. Devia Amanda</p>
                        <p class="text-[10px] text-gray-400 font-bold mt-1 uppercase">Kepala Bedah Umum</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Devia+Amanda&background=10b981&color=fff" class="w-10 h-10 rounded-full" alt="Profile">
                    <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
                </div>
            </div>
        </div>

        <div class="p-8 space-y-8">
            
            <!-- Header -->
            <div>
                <h2 class="text-3xl font-black text-[#1b5e20] tracking-tight">Dashboard Gizi</h2>
                <p class="text-sm font-semibold text-gray-500 mt-1">Kelola pemesanan menu, laporan pemesanan, dan jadwal makan pasien.</p>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-50 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-600 text-xl">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Pesanan Hari Ini</p>
                        <h3 class="text-2xl font-black">48 <span class="text-xs font-bold text-gray-400">pesanan</span></h3>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-50 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-xl">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Laporan Hari Ini</p>
                        <h3 class="text-2xl font-black">48 <span class="text-xs font-bold text-gray-400">laporan</span></h3>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-50 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-orange-600 text-xl">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Jadwal Makan Hari Ini</p>
                        <h3 class="text-2xl font-black">92 <span class="text-xs font-bold text-gray-400">jadwal</span></h3>
                    </div>
                </div>
            </div>

            <!-- Table 1: Pemesanan Menu -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 flex justify-between items-center border-b border-gray-50">
                    <h4 class="text-lg font-black text-green-900">1. Pemesanan Menu</h4>
                    <button class="bg-[#1b5e20] text-white px-4 py-2 rounded-lg text-xs font-bold flex items-center space-x-2">
                        <i class="fa-solid fa-plus"></i>
                        <span>Buat Pemesanan Baru</span>
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                            <tr>
                                <th class="p-4 w-12 text-center">No</th>
                                <th class="p-4">Ruang</th>
                                <th class="p-4">Kelas</th>
                                <th class="p-4">Nama Pasien</th>
                                <th class="p-4">Shift</th>
                                <th class="p-4">Tanggal</th>
                                <th class="p-4">Catatan</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs font-bold text-gray-700 divide-y divide-gray-50">
                            <tr>
                                <td class="p-4 text-center">1</td>
                                <td class="p-4">Bedah A</td>
                                <td class="p-4">Kelas 1</td>
                                <td class="p-4">Anisa Putri</td>
                                <td class="p-4">Pagi</td>
                                <td class="p-4">18 Mei 2025</td>
                                <td class="p-4">DM Rendah Gula</td>
                                <td class="p-4 text-center"><button class="btn-lihat">Lihat</button></td>
                            </tr>
                            <tr>
                                <td class="p-4 text-center">2</td>
                                <td class="p-4">ICU</td>
                                <td class="p-4">Kelas VIP</td>
                                <td class="p-4">Budi Santoso</td>
                                <td class="p-4">Siang</td>
                                <td class="p-4">18 Mei 2025</td>
                                <td class="p-4">MP-ASI Saring</td>
                                <td class="p-4 text-center"><button class="btn-lihat">Lihat</button></td>
                            </tr>
                            <tr>
                                <td class="p-4 text-center">3</td>
                                <td class="p-4">Anak</td>
                                <td class="p-4">Kelas 2</td>
                                <td class="p-4">Citra Wulandari</td>
                                <td class="p-4">Malam</td>
                                <td class="p-4">18 Mei 2025</td>
                                <td class="p-4">Alergi Telur</td>
                                <td class="p-4 text-center"><button class="btn-lihat">Lihat</button></td>
                            </tr>
                            <tr>
                                <td class="p-4 text-center">4</td>
                                <td class="p-4">Internal</td>
                                <td class="p-4">Kelas 3</td>
                                <td class="p-4">Dewi Lestari</td>
                                <td class="p-4">Pagi</td>
                                <td class="p-4">19 Mei 2025</td>
                                <td class="p-4">Diet Rendah Garam</td>
                                <td class="p-4 text-center"><button class="btn-lihat">Lihat</button></td>
                            </tr>
                            <tr>
                                <td class="p-4 text-center">5</td>
                                <td class="p-4">Bedah B</td>
                                <td class="p-4">Kelas 1</td>
                                <td class="p-4">Fajar Nugroho</td>
                                <td class="p-4">Siang</td>
                                <td class="p-4">19 Mei 2025</td>
                                <td class="p-4">Lunak Tinggi Protein</td>
                                <td class="p-4 text-center"><button class="btn-lihat">Lihat</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Table 2: Laporan Pemesanan Menu -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-50">
                    <h4 class="text-lg font-black text-green-900">2. Laporan Pemesanan Menu</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                            <tr>
                                <th class="p-4 w-12 text-center">No</th>
                                <th class="p-4">Nama</th>
                                <th class="p-4 text-center">Jam Pesan</th>
                                <th class="p-4 text-center">Jam Kirim</th>
                                <th class="p-4 text-center">Jam Lapor</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs font-bold text-gray-700 divide-y divide-gray-50 text-center">
                            <tr class="text-left">
                                <td class="p-4 text-center">1</td>
                                <td class="p-4">Anisa Putri</td>
                                <td class="p-4 text-center text-gray-500 font-semibold">18 Mei 2025, 07:30</td>
                                <td class="p-4 text-center text-gray-500 font-semibold">18 Mei 2025, 08:15</td>
                                <td class="p-4 text-center text-gray-500 font-semibold">18 Mei 2025, 08:25</td>
                                <td class="p-4 text-center"><button class="btn-lihat">Lihat</button></td>
                            </tr>
                            <tr class="text-left">
                                <td class="p-4 text-center">2</td>
                                <td class="p-4">Budi Santoso</td>
                                <td class="p-4 text-center text-gray-500 font-semibold">18 Mei 2025, 11:00</td>
                                <td class="p-4 text-center text-gray-500 font-semibold">18 Mei 2025, 11:45</td>
                                <td class="p-4 text-center text-gray-500 font-semibold">18 Mei 2025, 11:55</td>
                                <td class="p-4 text-center"><button class="btn-lihat">Lihat</button></td>
                            </tr>
                            <tr class="text-left">
                                <td class="p-4 text-center">3</td>
                                <td class="p-4">Citra Wulandari</td>
                                <td class="p-4 text-center text-gray-500 font-semibold">18 Mei 2025, 17:30</td>
                                <td class="p-4 text-center text-gray-500 font-semibold">18 Mei 2025, 18:10</td>
                                <td class="p-4 text-center text-gray-500 font-semibold">18 Mei 2025, 18:20</td>
                                <td class="p-4 text-center"><button class="btn-lihat">Lihat</button></td>
                            </tr>
                            <tr class="text-left">
                                <td class="p-4 text-center">4</td>
                                <td class="p-4">Dewi Lestari</td>
                                <td class="p-4 text-center text-gray-500 font-semibold">19 Mei 2025, 07:15</td>
                                <td class="p-4 text-center text-gray-500 font-semibold">19 Mei 2025, 08:00</td>
                                <td class="p-4 text-center text-gray-500 font-semibold">19 Mei 2025, 08:10</td>
                                <td class="p-4 text-center"><button class="btn-lihat">Lihat</button></td>
                            </tr>
                            <tr class="text-left">
                                <td class="p-4 text-center">5</td>
                                <td class="p-4">Fajar Nugroho</td>
                                <td class="p-4 text-center text-gray-500 font-semibold">19 Mei 2025, 11:05</td>
                                <td class="p-4 text-center text-gray-500 font-semibold">19 Mei 2025, 11:50</td>
                                <td class="p-4 text-center text-gray-500 font-semibold">19 Mei 2025, 12:00</td>
                                <td class="p-4 text-center"><button class="btn-lihat">Lihat</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Table 3: Jadwal Makan -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-50">
                    <h4 class="text-lg font-black text-green-900">3. Jadwal Makan</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                            <tr>
                                <th class="p-4 w-12 text-center">No</th>
                                <th class="p-4">Nama</th>
                                <th class="p-4 text-center">Jam Pesan</th>
                                <th class="p-4 text-center">Jam Kirim</th>
                                <th class="p-4 text-center">Jam Lapor</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs font-bold text-gray-700 divide-y divide-gray-50">
                            <tr>
                                <td class="p-4 text-center">1</td>
                                <td class="p-4">Anisa Putri</td>
                                <td class="p-4 text-center font-semibold">07:30</td>
                                <td class="p-4 text-center font-semibold">08:15</td>
                                <td class="p-4 text-center font-semibold">08:25</td>
                                <td class="p-4 text-center"><button class="btn-lihat">Lihat</button></td>
                            </tr>
                            <tr>
                                <td class="p-4 text-center">2</td>
                                <td class="p-4">Budi Santoso</td>
                                <td class="p-4 text-center font-semibold">11:00</td>
                                <td class="p-4 text-center font-semibold">11:45</td>
                                <td class="p-4 text-center font-semibold">11:55</td>
                                <td class="p-4 text-center"><button class="btn-lihat">Lihat</button></td>
                            </tr>
                            <tr>
                                <td class="p-4 text-center">3</td>
                                <td class="p-4">Citra Wulandari</td>
                                <td class="p-4 text-center font-semibold">17:30</td>
                                <td class="p-4 text-center font-semibold">18:10</td>
                                <td class="p-4 text-center font-semibold">18:20</td>
                                <td class="p-4 text-center"><button class="btn-lihat">Lihat</button></td>
                            </tr>
                            <tr>
                                <td class="p-4 text-center">4</td>
                                <td class="p-4">Dewi Lestari</td>
                                <td class="p-4 text-center font-semibold">07:15</td>
                                <td class="p-4 text-center font-semibold">08:00</td>
                                <td class="p-4 text-center font-semibold">08:10</td>
                                <td class="p-4 text-center"><button class="btn-lihat">Lihat</button></td>
                            </tr>
                            <tr>
                                <td class="p-4 text-center">5</td>
                                <td class="p-4">Fajar Nugroho</td>
                                <td class="p-4 text-center font-semibold">11:05</td>
                                <td class="p-4 text-center font-semibold">11:50</td>
                                <td class="p-4 text-center font-semibold">12:00</td>
                                <td class="p-4 text-center"><button class="btn-lihat">Lihat</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
