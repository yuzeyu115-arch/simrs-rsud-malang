<aside class="app-sidebar flex flex-col">
    <div class="app-brand">
        <div class="logo"><i class="fa-solid fa-hospital"></i></div>
        <div>
            <p class="text-sm font-bold">RSUD KOTA MALANG</p>
            <p class="text-xs text-muted">Pelayanan Ramah, Kesehatan Optimal</p>
        </div>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto custom-scrollbar">
        <a href="{{ url('/dashboard') }}" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-house mr-3"></i>
            Dashboard
        </a>
        <a href="{{ url('/jadwal-operasi') }}" class="nav-item {{ request()->is('jadwal-operasi*') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-check mr-3"></i>
            Jadwal Operasi
        </a>
        <a href="{{ url('/status-operasi') }}" class="nav-item {{ request()->is('status-operasi*') ? 'active' : '' }}">
            <i class="fa-solid fa-heartbeat mr-3"></i>
            Status Operasi
        </a>
        <!-- Bed Manager removed per design request -->
        <a href="{{ url('/farmasi') }}" class="nav-item {{ request()->is('farmasi*') ? 'active' : '' }}">
            <i class="fa-solid fa-pills mr-3"></i>
            Unit Farmasi
        </a>
    </nav>

    <div class="mt-6 pt-6 border-t border-slate-100">
        <a href="{{ url('/logout') }}" class="flex items-center gap-3 text-red-600 hover:text-red-700 font-semibold">
            <i class="fa-solid fa-right-from-bracket"></i>
            Keluar
        </a>
    </div>
</aside>
