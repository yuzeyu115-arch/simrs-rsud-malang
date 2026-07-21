<header class="flex flex-col gap-4 px-6 py-4">
    <div class="flex items-center justify-between rounded-[1.5rem] border border-slate-200/80 bg-white/85 px-4 py-3 shadow-sm backdrop-blur">
        <div class="min-w-0">
            <p class="text-sm font-semibold text-emerald-700">@yield('title')</p>
            <p class="text-xs text-muted">Ringkasan aktivitas rumah sakit hari ini.</p>
        </div>

        <!-- Mobile menu toggle -->
        <button id="mobileMenuBtn" class="md:hidden mr-3 p-2 rounded-lg bg-white shadow-sm">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="flex items-center gap-3">
            <a id="openStatusPage" href="{{ url('/status-operasi') }}" class="btn-secondary mr-2">Status Operasi</a>

            <div class="relative">
                @include('layouts.partials.notification-button')
            </div>

            <a href="{{ route('profile') }}" class="flex items-center gap-3 rounded-3xl bg-slate-50 px-4 py-2 shadow-sm ring-1 ring-slate-200 hover:shadow-md transition-shadow">
                <div class="h-11 w-11 rounded-full bg-gradient-to-br from-emerald-600 to-emerald-700 text-white flex items-center justify-center text-lg shadow-sm">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-slate-900">{{ auth()->user()?->name ?? 'Dr. RSUD' }}</p>
                    <p class="text-xs text-slate-500">{{ auth()->user()?->role ? ucfirst(auth()->user()->role) : 'Admin Utama' }}</p>
                </div>
            </a>
        </div>
    </div>

</header>
<script>
    // Ensure clicks always navigate (workaround for overlay/JS blocks)
    (function(){
        var btn = document.getElementById('openStatusPage');
        if(btn){
            btn.addEventListener('click', function(e){
                // let anchor behave normally, but enforce location change
                window.location.href = this.href;
            });
        }
    })();

    // Mobile sidebar toggle
    (function(){
        var mobileBtn = document.getElementById('mobileMenuBtn');
        var sidebar = document.querySelector('.app-sidebar');
        mobileBtn?.addEventListener('click', function(e){
            if(sidebar) {
                sidebar.classList.toggle('open');
                document.body.classList.toggle('sidebar-open');
            }
        });
    })();
</script>
