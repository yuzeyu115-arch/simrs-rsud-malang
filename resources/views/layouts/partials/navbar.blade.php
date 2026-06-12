<header class="flex items-center justify-between gap-4 bg-white border-b border-gray-200 px-5 py-4">
    <div class="flex items-center gap-4">
        <button class="text-gray-500 md:hidden"><i class="fa-solid fa-bars"></i></button>
        <div>
            <p class="text-sm text-gray-500">Selamat datang</p>
            <h1 class="text-xl font-semibold text-gray-800">@yield('title')</h1>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <button class="relative p-2 rounded-xl text-gray-500 hover:bg-gray-100">
            <i class="fa-regular fa-bell text-lg"></i>
            <span class="absolute -top-1 -right-1 inline-flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] text-white font-bold">3</span>
        </button>
        <div class="flex items-center gap-3 bg-gray-50 rounded-2xl px-4 py-2">
            <div class="w-10 h-10 rounded-full bg-primary-green flex items-center justify-center text-white">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="text-right">
                <p class="text-sm font-semibold text-gray-800">Tim RSUD</p>
                <p class="text-xs text-gray-500">Dashboard Utama</p>
            </div>
        </div>
    </div>
</header>
