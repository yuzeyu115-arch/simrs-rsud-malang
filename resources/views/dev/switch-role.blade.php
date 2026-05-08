<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dev: Switch Role</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50 flex items-start justify-center p-8">
    <div class="w-full max-w-2xl bg-white p-6 rounded-lg shadow">
        <h1 class="text-xl font-bold mb-4">Dev: Quick Switch Role</h1>
        @if(session('error'))
            <div class="text-red-600 font-bold mb-3">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="text-green-600 font-bold mb-3">{{ session('success') }}</div>
        @endif
        <p class="text-sm text-gray-600 mb-4">Klik username untuk langsung login sebagai user contoh (dibuat oleh seeder).</p>
        <div class="grid grid-cols-2 gap-3">
            @foreach($roles as $r)
                <a href="/dev/login-as/{{ $r }}" class="block p-3 bg-gray-50 rounded hover:bg-gray-100 border">Login as {{ $r }}</a>
            @endforeach
        </div>
        <p class="text-xs text-gray-400 mt-4">Hanya gunakan di lingkungan dev/local.</p>
    </div>
</body>
</html>