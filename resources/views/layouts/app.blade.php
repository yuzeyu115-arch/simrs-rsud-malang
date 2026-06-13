<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - RSUD Kota Malang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              'pastel-green': '#d1fae5',
              'pastel-green-light': '#ecfdf5',
              'primary-green': '#10b981',
              'primary-green-hover': '#059669',
              'sidebar-bg': '#ffffff',
              'page-bg': '#f8f0ee'
            }
          }
        }
      }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root{
            --fg:#1b1b18;
            --muted:#6b7280;
            --bg: #f4ebe9; /* page background */
            --frame-pink: #e7b8b8; /* outer frame / header accent */
            --card-bg: #ffffff;
            --card-border: rgba(148,163,184,0.12);
            --primary: #10b981; /* Figma green */
            --primary-600: #059669;
            --primary-700: #047857;
            --accent-line: #d1fae5;
            --shadow-lg: 0 24px 52px rgba(15,23,42,0.08);
            --radius-lg: 1.5rem;
        }
        html,body{height:100%}
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--fg);
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
        }
        /* Outer pink frame like the design */
        .app-frame { background-clip: padding-box; }

        /* Sidebar */
        .app-sidebar { width: 220px; background: var(--card-bg); border-right: 1px solid rgba(0,0,0,0.03); padding:1.25rem; }
        .app-brand { display:flex; gap:.6rem; align-items:center; margin-bottom:1.25rem }
        .app-brand .logo { width:40px; height:40px; border-radius:8px; background:var(--primary); display:flex;align-items:center;justify-content:center;color:#fff }
        .nav-item { display:block; padding:.6rem .8rem; border-radius:.8rem; color:var(--fg); font-weight:600; margin-bottom:.45rem; }
        .nav-item.active { background: var(--primary-600); color:#fff; box-shadow: 0 8px 18px rgba(5,150,105,0.08); }

        /* Topbar */
        .topbar { display:flex; align-items:center; gap:1rem; padding: .8rem 1rem; background:transparent }
        .search-box { flex:1; max-width:520px; }
        .search-input { width:100%; border-radius:999px; padding:.6rem 1rem; border:1px solid #e6e6e6; background:#fff }

        /* Card */
        .card-panel {
            border-radius: var(--radius-lg);
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            box-shadow: var(--shadow-lg);
        }

        /* Buttons */
        .btn-primary {
            display:inline-flex; align-items:center; gap:.5rem; border-radius:1rem;
            background:var(--primary); color:#fff; padding:.75rem 1rem; font-weight:700; box-shadow: 0 10px 18px rgba(16,185,129,0.18);
            transition: transform 180ms ease, background-color 180ms ease, box-shadow 180ms ease;
        }
        .btn-primary:hover {
            background:var(--primary-600);
            transform: translateY(-1px);
        }
        .btn-primary.secondary { background:var(--primary-700); }
        .btn-secondary {
            display:inline-flex; align-items:center; justify-content:center; gap:.45rem; border-radius:1rem;
            background:#fff; color:#0f172a; padding:.75rem 1rem; border:1px solid rgba(148,163,184,0.22); font-weight:700;
            box-shadow: 0 8px 18px rgba(15,23,42,0.06);
            transition: transform 180ms ease, border-color 180ms ease, background-color 180ms ease;
        }
        .btn-secondary:hover {
            background:#f8fafc;
            transform: translateY(-1px);
        }
        .btn-danger { background:#ef4444; color:#fff; border-radius:1rem; padding:.65rem .95rem; }

        /* Inputs */
        .input-base { width:100%; border-radius:1rem; padding:.85rem 1rem; border:1px solid #e6e6e6; background:#fff; transition: border-color 180ms ease, box-shadow 180ms ease; }
        .input-base:focus { outline:none; border-color: rgba(16,185,129,0.4); box-shadow: 0 0 0 4px rgba(16,185,129,0.12); }

        .card-panel {
            border-radius: 1.75rem;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            box-shadow: var(--shadow-lg);
        }
        .card-stat {
            border-radius: 1.75rem;
            background: #ffffff;
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.06);
        }
        .notification-tab {
            width: 100%; border-radius: 1rem; border: 1px solid #e2e8f0; background: #f8fafc;
            color: #334155; padding: .75rem .9rem; font-size: .8rem; font-weight: 700;
            transition: background-color 180ms ease, color 180ms ease, border-color 180ms ease;
        }
        .notification-tab.active {
            background: #10b981; color: #ffffff; border-color: #10b981;
        }

        /* Outer application layout */
        .app-sidebar { width: 260px; background: var(--card-bg); border-right: 1px solid rgba(148,163,184,0.15); padding: 1.5rem; }
        .app-sidebar .app-brand { margin-bottom: 1.5rem; }
        .nav-item { display:block; padding:.9rem 1rem; border-radius:1.25rem; color:var(--fg); font-weight:600; margin-bottom:.5rem; transition: background-color 180ms ease, color 180ms ease, transform 180ms ease; }
        .nav-item:hover { background: #f8fafc; transform: translateX(1px); }
        .nav-item.active { background: rgba(16,185,129,0.12); color: #0f172a; }

        .topbar { display:flex; align-items:center; gap:1rem; padding: 1rem 1.25rem; background: transparent; }
        .search-input { width:100%; border-radius:999px; padding:.75rem 1rem; border:1px solid #e2e8f0; background:#ffffff; }

        .custom-scrollbar::-webkit-scrollbar { width:8px; height:8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:9999px; }

        /* Cards, badges and small components */
        .badge { display:inline-block; padding:.25rem .5rem; border-radius:999px; background:#f1f5f9; color:var(--muted); font-weight:700; font-size:.75rem }
        .status-pill { border-radius:999px; padding:.35rem .55rem; font-weight:700; font-size:.75rem }

        /* Notifications dropdown look */
        .notifications-dropdown { min-width:360px; max-width:420px; border-radius:1rem; box-shadow:0 18px 40px rgba(15,23,42,0.12); }

        /* Utility */
        .text-muted{ color:var(--muted) }
        .small { font-size:.85rem }

        /* scrollbars */
        .custom-scrollbar::-webkit-scrollbar { width:8px; height:8px }
        .custom-scrollbar::-webkit-scrollbar-thumb { background:#d1d5db; border-radius:9999px }
    </style>
    @stack('styles')
</head>
<body class="flex min-h-screen overflow-hidden text-slate-800 bg-[#FDFDFC]">
  @include('layouts.partials.sidebar')

  <div class="flex-1 flex flex-col h-full overflow-hidden">
    @include('layouts.partials.navbar')

    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#f7efe9] p-6">
      @yield('content')
      <footer class="mt-10 py-4 border-t border-slate-200 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} RSUD Kota Malang. All Rights Reserved.
      </footer>
    </main>
  </div>

    @include('partials.generic-modal')
    <script src="/js/global-buttons.js"></script>
    @stack('scripts')
</body>
</html>
