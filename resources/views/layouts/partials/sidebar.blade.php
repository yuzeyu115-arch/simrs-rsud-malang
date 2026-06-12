<aside class="w-72 bg-white border-r border-gray-200 flex flex-col p-6 shadow-sm">
    <div class="mb-8 flex items-center gap-3">
        <div class="w-11 h-11 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-sm">
            <i class="fa-solid fa-hospital"></i>
        </div>
        <div>
            <p class="text-lg font-bold text-gray-900">RSUD</p>
            <p class="text-xs uppercase tracking-[0.2em] text-gray-400">Kota Malang</p>
        </div>
    </div>

    <nav class="flex-1 space-y-2 overflow-y-auto custom-scrollbar pr-1">
        <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->is('dashboard') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ url('/jadwal-operasi') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->is('jadwal-operasi*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fa-solid fa-calendar-check"></i>
            <span>Jadwal Operasi</span>
        </a>
        <a href="{{ url('/bed-manager') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->is('bed-manager*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fa-solid fa-bed"></i>
            <span>Bed Manager</span>
        </a>
        <a href="{{ url('/farmasi') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->is('farmasi*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fa-solid fa-pills"></i>
            <span>Farmasi</span>
        </a>
    </nav>

    <div class="mt-6 pt-6 border-t border-gray-200">
        <a href="{{ url('/logout') }}" class="flex items-center gap-3 text-red-600 hover:text-red-700 font-semibold">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Keluar</span>
        </a>
    </div>
</aside>
