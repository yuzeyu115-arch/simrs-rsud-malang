<aside class="app-sidebar flex flex-col">
    <div class="app-brand">
        <div style="width:56px; height:56px; display:flex;align-items:center;justify-content:center;">
            <img src="{{ asset('img/img/logo rsud.png') }}" alt="Logo RSUD" title="RSUD Kota Malang" class="logo-img" style="width:56px;height:56px;object-fit:contain;border-radius:8px;background:#ffffff;padding:4px;display:block;" />
        </div>
        <div>
            <p class="text-sm font-bold text-white">RSUD KOTA MALANG</p>
            <p class="text-xs text-slate-300">Pelayanan Ramah, Kesehatan Optimal</p>
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
        @php $role = auth()->user()?->role ?? 'guest'; @endphp
        @if(in_array($role, ['dokter','admin'], true))
            <a href="{{ route('dpjb.cppt') }}" class="nav-item {{ request()->is('dpjb*') ? 'active' : '' }}">
                <i class="fa-solid fa-notes-medical mr-3"></i>
                Observasi & CPPT
            </a>
        @endif
        @if(in_array($role, ['anestesi','admin'], true))
            <a href="{{ route('anestesi.paket-obat') }}" class="nav-item {{ request()->is('anestesi*') ? 'active' : '' }}">
                <i class="fa-solid fa-syringe mr-3"></i>
                Paket Anestesi
            </a>
        @endif
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
