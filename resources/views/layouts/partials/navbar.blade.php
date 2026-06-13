<header class="flex flex-col gap-4 px-6 py-4">
    <div class="flex items-center justify-between">
        <div class="min-w-0">
            <p class="text-sm font-semibold text-emerald-700">@yield('title')</p>
            <p class="text-xs text-muted">Ringkasan aktivitas rumah sakit hari ini.</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden md:flex items-center gap-3 rounded-full border border-slate-200 bg-white px-4 py-2 shadow-sm search-box">
                <i class="fa-solid fa-search text-slate-400"></i>
                <input id="globalSearch" type="search" placeholder="Pencarian Cepat..." class="border-0 bg-transparent p-0 text-sm text-slate-700 outline-none focus:ring-0 w-72" autocomplete="off">
            </div>

            <a href="{{ url('/jadwal-operasi/create') }}" class="btn-primary mr-2">+ Jadwal Operasi</a>
            <a href="{{ url('/status-operasi') }}" class="btn-primary secondary mr-2">+ Status Operasi</a>

            <div class="relative">
                @include('layouts.partials.notification-button')
            </div>

            <div class="flex items-center gap-3 rounded-3xl bg-white px-4 py-2 shadow-sm">
                <div class="h-11 w-11 rounded-full bg-emerald-600 text-white flex items-center justify-center text-lg shadow-sm">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-slate-900">Dr. RSUD</p>
                    <p class="text-xs text-slate-500">Admin Utama</p>
                </div>
            </div>
        </div>
    </div>

    <div id="searchResults" class="hidden absolute left-1/2 top-full z-50 mt-3 w-[560px] -translate-x-1/2 rounded-3xl border border-slate-200 bg-white shadow-xl"></div>
</header>
