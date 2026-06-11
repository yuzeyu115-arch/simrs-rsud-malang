<div class="w-64 bg-white h-screen border-r border-gray-100 flex flex-col">
    <div class="p-6 flex items-center space-x-3">
        <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center text-white">
            <i class="fa-solid fa-hospital"></i>
        </div>
        <span class="text-xl font-bold text-gray-800">RSUD Malang</span>
    </div>

    <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mt-4 mb-2">Utama</p>
        <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3 p-3 rounded-xl bg-emerald-50 text-emerald-600 font-medium">
            <i class="fa-solid fa-chart-pie w-5"></i> <span>Dashboard KPI</span>
        </a>
        <a href="#" class="flex items-center space-x-3 p-3 rounded-xl text-gray-600 hover:bg-gray-50 transition">
            <i class="fa-solid fa-calendar-check w-5"></i> <span>Jadwal Operasi</span>
        </a>
        
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mt-6 mb-2">Aktivitas & Logistik</p>
        <a href="#" class="flex items-center space-x-3 p-3 rounded-xl text-gray-600 hover:bg-gray-50 transition">
            <i class="fa-solid fa-pills w-5"></i> <span>Farmasi & Obat</span>
        </a>
        </nav>

    <div class="p-4 border-t border-gray-100">
        <a href="{{ url('/') }}" class="flex items-center space-x-3 p-3 rounded-xl text-red-500 hover:bg-red-50 transition">
            <i class="fa-solid fa-right-from-bracket w-5"></i> <span>Logout</span>
        </a>
    </div>
</div>