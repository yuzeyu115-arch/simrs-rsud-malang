<div class="relative inline-block notification-menu">
    @php $unreadCount = $unreadCount ?? (session('unread_notifications') ?? 0); @endphp
    <button type="button" class="notification-toggle relative inline-flex h-12 w-12 items-center justify-center rounded-3xl border border-slate-200 bg-white text-slate-700 shadow-sm hover:shadow-md transition" aria-label="Notifikasi">
        <i class="fa-regular fa-bell text-lg"></i>
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 inline-flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-white text-[10px] font-semibold">{{ $unreadCount }}</span>
        @endif
    </button>

    <div class="notifications-dropdown hidden absolute right-0 mt-3 w-[360px] rounded-[2rem] border border-slate-200 bg-white shadow-2xl z-50 overflow-hidden">
        <div class="px-4 py-4 border-b border-slate-100">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-slate-900">Notifikasi</p>
                    <p class="text-xs text-slate-500">Ringkasan terbaru paling penting</p>
                </div>
                <a href="{{ url('/notifications') }}" class="text-xs font-semibold text-emerald-600 hover:underline">Lihat semua</a>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-2">
                <button type="button" class="notification-tab active" data-target="tab-surgery">Jadwal Operasi</button>
                <button type="button" class="notification-tab" data-target="tab-medicine">Paket Obat</button>
            </div>
        </div>

        <div class="p-4 space-y-3">
            <div id="tab-surgery" class="notification-panel">
                <div class="rounded-[1.5rem] border border-slate-200 bg-emerald-50 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-700 font-semibold">Operasi Hari Ini</p>
                    <p class="mt-2 text-sm text-slate-700">Ruang Operasi A telah terisi 90%. Jadwal operasi berikutnya dalam 45 menit.</p>
                </div>
                <div class="rounded-[1.5rem] border border-slate-200 bg-white p-4 shadow-sm">
                    <p class="text-sm font-semibold text-slate-900">Jadwal Operasi Baru</p>
                    <p class="mt-1 text-xs text-slate-500">Pasien: Anissa Putri • Bedah • Ruang Operasi B</p>
                </div>
                <div class="rounded-[1.5rem] border border-slate-200 bg-white p-4 shadow-sm">
                    <p class="text-sm font-semibold text-slate-900">Perubahan Ruang Operasi</p>
                    <p class="mt-1 text-xs text-slate-500">Ruangan operasi C dipindah ke Ruang Operasi A karena kebersihan.</p>
                </div>
            </div>
            <div id="tab-medicine" class="notification-panel hidden">
                <div class="rounded-[1.5rem] border border-slate-200 bg-white p-4 shadow-sm">
                    <p class="text-sm font-semibold text-slate-900">Paket Obat Siap</p>
                    <p class="mt-1 text-xs text-slate-500">Paket anestesi untuk operasi akan tersedia dalam 20 menit.</p>
                </div>
                <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4">
                    <p class="text-sm font-semibold text-slate-900">Reorder Obat</p>
                    <p class="mt-1 text-xs text-slate-500">Stok obat bius menipis, harap cek farmasi segera.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('click', function (e) {
        document.querySelectorAll('.notification-menu').forEach(function(menu) {
            const button = menu.querySelector('.notification-toggle');
            const dropdown = menu.querySelector('.notifications-dropdown');
            if (!button || !dropdown) return;
            if (button.contains(e.target)) {
                dropdown.classList.toggle('hidden');
            } else if (!dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        if (e.target.matches('.notification-tab')) {
            const tabs = document.querySelectorAll('.notification-tab');
            const panels = document.querySelectorAll('.notification-panel');
            tabs.forEach(tab => tab.classList.remove('active'));
            panels.forEach(panel => panel.classList.add('hidden'));
            e.target.classList.add('active');
            const target = document.getElementById(e.target.dataset.target);
            if (target) target.classList.remove('hidden');
        }
    });
</script>
