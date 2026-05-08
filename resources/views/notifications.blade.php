<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - SIMRS RSUD Kota Malang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { colors: { 'primary-green': '#10b981' } } } }
    </script>
    <style>body { font-family: 'Inter', sans-serif; background-color:#f7f9f7; }</style>
</head>
<body class="bg-gray-50 flex overflow-hidden h-screen">

    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col flex-shrink-0 shadow-sm z-20">
        <div class="p-6 flex items-center space-x-3">
            <div class="w-8 h-8 bg-primary-green rounded-lg flex items-center justify-center text-white shadow-md">
                <i class="fa-solid fa-hospital"></i>
            </div>
            <span class="text-xl font-bold text-gray-800 tracking-tight">SIMRS</span>
        </div>
        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 mt-4 mb-2">UTAMA</p>
            <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition-all text-sm font-semibold">
                 <i class="fa-solid fa-house w-5"></i> <span>Dashboard</span>
            </a>
            <div class="mt-auto pt-10 px-3 pb-8">
                <a href="{{ url('/logout') }}" class="flex items-center space-x-3 text-red-500 font-bold text-sm hover:underline">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </nav>
    </aside>

    <main class="flex-1 overflow-y-auto">
        <div class="sticky top-0 bg-white/80 backdrop-blur-md border-b border-gray-100 px-8 py-4 z-10 flex justify-between items-center">
            <h2 class="text-2xl font-black text-[#1b5e20] tracking-tight">Notifikasi</h2>
            <div class="flex items-center space-x-4">
                <a href="{{ url('/dashboard') }}" class="text-sm text-gray-500 hover:underline">Kembali ke Dashboard</a>
            </div>
        </div>

        <div class="p-8">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Pusat Notifikasi</h3>
                @php
                    $notes = [];
                    try {
                        $notes = isset($notifications) ? $notifications : (\Illuminate\Support\Facades\DB::table('notifications')->orderBy('created_at','desc')->limit(50)->get() ?? []);
                    } catch (\Exception $e) {
                        // fallback sample
                        $notes = collect([
                            (object)['id'=>1,'title'=>'Audit Inventaris Obat','body'=>'Audit stok bius dijadwalkan besok 08:00','created_at'=>now()],
                            (object)['id'=>2,'title'=>'Rapat Koordinasi','body'=>'Rapat koordinasi departemen bedah pukul 14:00','created_at'=>now()->subHour()]
                        );
                    }
                @endphp

                @if(count($notes) == 0)
                    <div class="p-6 text-center text-gray-500">Belum ada notifikasi.</div>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach($notes as $note)
                            <div class="p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-bold text-gray-800">{{ $note->title ?? ($note->data->title ?? 'Notifikasi') }}</h4>
                                        <p class="text-xs text-gray-500 mt-1">{{ $note->created_at ?? now() }}</p>
                                    </div>
                                    <div class="text-sm text-gray-400">#{{ $note->id ?? '' }}</div>
                                </div>
                                <p class="text-sm text-gray-600 mt-3">{{ $note->body ?? ($note->data->message ?? '') }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>

</body>
</html>
