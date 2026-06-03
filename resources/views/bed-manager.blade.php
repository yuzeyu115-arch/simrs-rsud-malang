<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bed Manager - SimpleOK RSUD</title>
    
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
        body { font-family: 'Inter', sans-serif; background-color: #f3f4ee; }
        .table-row-hover:hover { background-color: #f8fafc; }
        /* Custom active menu item based on design */
        .sidebar-active {
            background-color: #e8f5e9;
            color: #1b5e20;
            font-weight: 700;
        }
    </style>
</head>
<body class="flex overflow-hidden h-screen">

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
            <a href="{{ url('/bed-manager') }}" class="flex items-center space-x-3 p-3 rounded-xl sidebar-active transition-all text-sm">
                 <i class="fa-solid fa-bed w-5 text-primary-green"></i> <span>Bed Manager</span>
            </a>

            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-6 mb-2">LOGISTIK</p>
            <a href="{{ url('/farmasi') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-pills w-5"></i> <span>Farmasi & Obat</span>
            </a>
            <a href="{{ url('/gizi') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-utensils w-5"></i> <span>Gizi</span>
            </a>

            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-6 mb-2 text-gray-400">JANJI TEMU</p>
            <a href="{{ url('/janji-temu') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-calendar-plus w-5"></i> <span>Add Appointment</span>
            </a>
              <a href="#" data-title="Daftar Janji Temu" data-body="Daftar janji temu belum tersedia di UI saat ini." class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
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
        <div class="sticky top-0 bg-white/80 backdrop-blur-md border-b border-gray-100 px-8 py-4 z-10 flex justify-end items-center">
            <div class="flex items-center space-x-6">
                <button class="relative text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                </button>
                <div class="h-8 w-px bg-gray-200"></div>
                <div class="flex items-center space-x-3 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-800 leading-none">Dr. Devia Amanda</p>
                        <p class="text-xs text-gray-500 mt-1">Kepala Bedah Umum</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Devia+Amanda&background=10b981&color=fff" class="w-10 h-10 rounded-full shadow-sm" alt="Profile">
                </div>
            </div>
        </div>

        <div class="p-8">
            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-3xl font-black text-[#1b5e20] tracking-tight">Bed Manager</h2>
                <p class="text-sm font-medium text-green-700 mt-1">Kelola Informasi Ketersediaan Tempat Tidur Rumah Sakit.</p>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-5 gap-4 mb-8">
                <!-- Card 1 -->
                <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-gray-100 flex flex-col justify-center min-h-[100px]">
                    <p class="text-[10px] font-bold text-gray-800 mb-1">Total Tempat Tidur</p>
                    <div class="flex items-baseline justify-center">
                        <h3 class="text-3xl font-black text-black">120</h3>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-gray-100 flex flex-col justify-center min-h-[100px]">
                    <p class="text-[10px] font-bold text-gray-800 mb-1">Terisi</p>
                    <div class="flex items-baseline justify-center">
                        <h3 class="text-3xl font-black text-blue-600">78</h3>
                        <span class="text-xs font-bold text-gray-400 ml-1">(65%)</span>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-gray-100 flex flex-col justify-center min-h-[100px]">
                    <p class="text-[10px] font-bold text-gray-800 mb-1">Tersedia</p>
                    <div class="flex items-baseline justify-center">
                        <h3 class="text-3xl font-black text-green-500">42</h3>
                        <span class="text-xs font-bold text-gray-400 ml-1">(35%)</span>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-gray-100 flex flex-col justify-center min-h-[100px]">
                    <p class="text-[10px] font-bold text-gray-800 mb-1">Dalam Pembersihan</p>
                    <div class="flex items-baseline justify-center">
                        <h3 class="text-3xl font-black text-purple-800">6</h3>
                        <span class="text-xs font-bold text-gray-400 ml-1">(2%)</span>
                    </div>
                </div>
                <!-- Card 5 -->
                <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-gray-100 flex flex-col justify-center min-h-[100px]">
                    <p class="text-[10px] font-bold text-gray-800 mb-1">Tidak Tersedia</p>
                    <div class="flex items-baseline justify-center">
                        <h3 class="text-3xl font-black text-red-600">2</h3>
                        <span class="text-xs font-bold text-gray-400 ml-1">(2%)</span>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl p-4 mb-6 shadow-sm border border-gray-100 flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Gedung</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 bg-white">
                        <option>Semua Gedung</option>
                        <option>Gedung A</option>
                        <option>Gedung B</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Lantai</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 bg-white">
                        <option>Semua Lantai</option>
                        <option>Lantai 1</option>
                        <option>Lantai 2</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Jenis Kamar</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 bg-white">
                        <option>Semua Jenis Kamar</option>
                        <option>VIP</option>
                        <option>Kelas I</option>
                        <option>Kelas II</option>
                        <option>Kelas III</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Status</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 bg-white">
                        <option>Semua Status</option>
                        <option>Terisi</option>
                        <option>Tersedia</option>
                        <option>Reservasi</option>
                        <option>Dalam Pembersihan</option>
                        <option>Tidak Tersedia</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 text-transparent select-none">.</label>
                    <input type="text" placeholder="Cari kamar/Bed.." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                </div>
                <div class="ml-auto">
                    <button class="bg-[#1b5e20] hover:bg-[#164919] text-white px-6 py-2.5 rounded-lg text-sm font-bold transition-all shadow-md">
                        Refresh
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-green-800">Daftar Jadwal Operasi</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-xs font-bold text-gray-800">
                                <th class="p-4 w-12">No.</th>
                                <th class="p-4">Gedung</th>
                                <th class="p-4">Lantai</th>
                                <th class="p-4">Ruangan</th>
                                <th class="p-4">No.Bed</th>
                                <th class="p-4">Jenis Kamar</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4">Pasien</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm font-semibold text-gray-800 divide-y divide-gray-100">
                            <!-- Row 1 -->
                            <tr class="table-row-hover">
                                <td class="p-4">1.</td>
                                <td class="p-4">Gedung A</td>
                                <td class="p-4">Lantai 1</td>
                                <td class="p-4">Kamar A101</td>
                                <td class="p-4">A101-01</td>
                                <td class="p-4">VIP</td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2 py-1 rounded bg-blue-100 text-blue-600 text-[10px] font-black uppercase tracking-wider">Terisi</span>
                                </td>
                                <td class="p-4">Siti Aisyah</td>
                            </tr>
                            <!-- Row 2 -->
                            <tr class="table-row-hover">
                                <td class="p-4">2.</td>
                                <td class="p-4">Gedung A</td>
                                <td class="p-4">Lantai 1</td>
                                <td class="p-4">Kamar A101</td>
                                <td class="p-4">A101-02</td>
                                <td class="p-4">VIP</td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2 py-1 rounded bg-[#e0f5c9] text-green-700 text-[10px] font-black uppercase tracking-wider">Tersedia</span>
                                </td>
                                <td class="p-4">-</td>
                            </tr>
                            <!-- Row 3 -->
                            <tr class="table-row-hover">
                                <td class="p-4">3.</td>
                                <td class="p-4">Gedung A</td>
                                <td class="p-4">Lantai 1</td>
                                <td class="p-4">Kamar A102</td>
                                <td class="p-4">A102-01</td>
                                <td class="p-4">Kelas I</td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2 py-1 rounded bg-blue-100 text-blue-600 text-[10px] font-black uppercase tracking-wider">Terisi</span>
                                </td>
                                <td class="p-4">Budi Santoso</td>
                            </tr>
                            <!-- Row 4 -->
                            <tr class="table-row-hover">
                                <td class="p-4">4.</td>
                                <td class="p-4">Gedung A</td>
                                <td class="p-4">Lantai 1</td>
                                <td class="p-4">Kamar A102</td>
                                <td class="p-4">A102-02</td>
                                <td class="p-4">Kelas I</td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2 py-1 rounded bg-yellow-100 text-yellow-600 text-[10px] font-black uppercase tracking-wider">Reservasi</span>
                                </td>
                                <td class="p-4">-</td>
                            </tr>
                            <!-- Row 5 -->
                            <tr class="table-row-hover">
                                <td class="p-4">5.</td>
                                <td class="p-4">Gedung B</td>
                                <td class="p-4">Lantai 2</td>
                                <td class="p-4">Kamar B201</td>
                                <td class="p-4">B201-01</td>
                                <td class="p-4">Kelas II</td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2 py-1 rounded bg-purple-100 text-purple-600 text-[10px] font-black uppercase tracking-wider">Dalam Pembersihan</span>
                                </td>
                                <td class="p-4">-</td>
                            </tr>
                            <!-- Row 6 -->
                            <tr class="table-row-hover">
                                <td class="p-4">6.</td>
                                <td class="p-4">Gedung B</td>
                                <td class="p-4">Lantai 2</td>
                                <td class="p-4">Kamar B201</td>
                                <td class="p-4">B201-02</td>
                                <td class="p-4">Kelas II</td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2 py-1 rounded bg-blue-100 text-blue-600 text-[10px] font-black uppercase tracking-wider">Terisi</span>
                                </td>
                                <td class="p-4">Dewi Lestari</td>
                            </tr>
                            <!-- Row 7 -->
                            <tr class="table-row-hover">
                                <td class="p-4">7.</td>
                                <td class="p-4">Gedung B</td>
                                <td class="p-4">Lantai 2</td>
                                <td class="p-4">Kamar B202</td>
                                <td class="p-4">B202-01</td>
                                <td class="p-4">Kelas III</td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2 py-1 rounded bg-[#e0f5c9] text-green-700 text-[10px] font-black uppercase tracking-wider">Tersedia</span>
                                </td>
                                <td class="p-4">-</td>
                            </tr>
                            <!-- Row 8 -->
                            <tr class="table-row-hover">
                                <td class="p-4">8.</td>
                                <td class="p-4">Gedung B</td>
                                <td class="p-4">Lantai 2</td>
                                <td class="p-4">Kamar B202</td>
                                <td class="p-4">B202-02</td>
                                <td class="p-4">Kelas III</td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2 py-1 rounded bg-red-100 text-red-600 text-[10px] font-black uppercase tracking-wider">Tidak Tersedia</span>
                                </td>
                                <td class="p-4">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </main>

</body>
</html>
