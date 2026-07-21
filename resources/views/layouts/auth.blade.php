<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - RSUD Kota Malang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = { theme: { extend: { colors: { 'pastel-green': '#d1fae5', 'primary-green': '#10b981' } } } }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root{ --primary:#10b981; --primary-600:#059669; --bg:#f4ebe9 }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg); }
        .auth-card { max-width: 520px; margin: 3.5rem auto; border-radius: 1.5rem; background: #ffffff; border: 1px solid rgba(148,163,184,0.12); box-shadow: 0 24px 48px rgba(15,23,42,0.06); }
        .input-field { width:100%; border-radius:12px; border:1px solid #e6e6e6; padding:0.75rem 1rem; }
        .btn-primary { display:inline-flex; align-items:center; justify-content:center; gap:0.5rem; border-radius:12px; background:var(--primary); color:#fff; padding:0.75rem 1rem; font-weight:700; }
        .social-btn { width:100%; display:inline-flex; align-items:center; gap:.6rem; justify-content:center; border-radius:12px; border:1px solid #e6e6e6; padding:.6rem 1rem; background:#fff }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-[#f4ebe9] flex items-center justify-center p-6">
    <main class="w-full px-4">
        <div class="auth-card p-8">
            @yield('auth-content')
        </div>
        <p class="mt-6 text-center text-xs text-slate-400">© {{ date('Y') }} RSUD Kota Malang</p>
    </main>
    @stack('scripts')
</body>
</html>
