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
            --fg:#0f172a;
            --muted:#6b7280;
            --bg: #f5efe9;
            --surface: rgba(255,255,255,0.88);
            --surface-strong: #ffffff;
            --card-border: rgba(148,163,184,0.18);
            --primary: #10b981;
            --primary-600: #059669;
            --primary-700: #047857;
            --accent-line: #d1fae5;
            --shadow-lg: 0 24px 52px rgba(15,23,42,0.08);
            --shadow-md: 0 12px 24px rgba(15,23,42,0.07);
            --radius-lg: 1.5rem;
            --radius-xl: 1.75rem;
        }
        html,body{height:100%}
        * { box-sizing: border-box; }
        body {
            margin:0;
            font-family: 'Inter', sans-serif;
            background:
                radial-gradient(circle at top right, rgba(16,185,129,0.14), transparent 26%),
                linear-gradient(180deg, #fbf9f7 0%, #f7efe9 100%);
            color: var(--fg);
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
            scroll-behavior: smooth;
        }

        .app-frame { background-clip: padding-box; }

        /* Sidebar */
        .app-sidebar {
            width: 260px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border-right: 1px solid rgba(148,163,184,0.18);
            padding: 1.35rem;
            box-shadow: inset -1px 0 0 rgba(15,23,42,0.03);
            flex-shrink: 0;
        }
        .app-brand { display:flex; gap:.75rem; align-items:center; margin-bottom:1.5rem; }
        .app-brand .logo { width:40px; height:40px; border-radius:10px; background:var(--primary); display:flex;align-items:center;justify-content:center;color:#fff }
        .nav-item {
            display:block; padding:.8rem .95rem; border-radius:1rem; color:#0f172a;
            font-weight:700; margin-bottom:.45rem; border:1px solid rgba(148,163,184,0.16);
            background: rgba(255,255,255,0.9); transition: all 180ms ease;
        }
        .nav-item:hover { background: #f8fafc; color:#0f172a; transform: translateX(2px); }
        .nav-item.active {
            background: linear-gradient(135deg, rgba(16,185,129,0.16), rgba(5,150,105,0.14));
            color:#047857; box-shadow: 0 10px 20px rgba(16,185,129,0.12); border-color: rgba(16,185,129,0.22);
        }

        /* Topbar */
        .topbar { display:flex; align-items:center; gap:1rem; padding: .8rem 1rem; background:transparent }

        /* Card */
        .card-panel {
            border-radius: var(--radius-xl);
            background: var(--surface);
            border: 1px solid var(--card-border);
            box-shadow: var(--shadow-md);
            backdrop-filter: blur(8px);
        }

        /* Buttons */
        .btn-primary {
            display:inline-flex; align-items:center; justify-content:center; gap:.5rem; border-radius:1rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-600)); color:#fff; padding:.78rem 1rem; font-weight:800;
            box-shadow: 0 12px 24px rgba(16,185,129,0.2); border:1px solid rgba(16,185,129,0.15);
            transition: transform 180ms ease, box-shadow 180ms ease, filter 180ms ease;
        }
        .btn-primary:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
            box-shadow: 0 16px 28px rgba(16,185,129,0.24);
        }
        .btn-primary.secondary { background: linear-gradient(135deg, var(--primary-700), var(--primary-600)); }
        .btn-secondary {
            display:inline-flex; align-items:center; justify-content:center; gap:.45rem; border-radius:1rem;
            background: rgba(255,255,255,0.9); color:#0f172a; padding:.78rem 1rem; border:1px solid rgba(148,163,184,0.22); font-weight:800;
            box-shadow: 0 8px 18px rgba(15,23,42,0.05);
            transition: transform 180ms ease, border-color 180ms ease, background-color 180ms ease;
        }
        .btn-secondary:hover {
            background:#f8fafc;
            transform: translateY(-1px);
            border-color: rgba(16,185,129,0.35);
        }
        .btn-danger { background:#ef4444; color:#fff; border-radius:1rem; padding:.65rem .95rem; }

        /* Inputs */
        .input-base {
            width:100%; border-radius:1rem; padding:.85rem 1rem; border:1px solid #d8e0ea; background:rgba(255,255,255,0.96);
            transition: border-color 180ms ease, box-shadow 180ms ease, background-color 180ms ease;
            box-shadow: inset 0 1px 1px rgba(15,23,42,0.03);
        }
        .input-base:focus { outline:none; border-color: rgba(16,185,129,0.45); box-shadow: 0 0 0 4px rgba(16,185,129,0.14); background:#fff; }

        .card-stat {
            border-radius: 1.75rem;
            background: linear-gradient(180deg, #ffffff, #fbfdff);
            border: 1px solid rgba(148, 163, 184, 0.18);
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

        .badge { display:inline-block; padding:.25rem .5rem; border-radius:999px; background:#f1f5f9; color:var(--muted); font-weight:700; font-size:.75rem }
        .status-pill { border-radius:999px; padding:.35rem .55rem; font-weight:700; font-size:.75rem }
        .notifications-dropdown { min-width:360px; max-width:420px; border-radius:1rem; box-shadow:0 18px 40px rgba(15,23,42,0.12); }
        .text-muted{ color:var(--muted) }
        .small { font-size:.85rem }
        .custom-scrollbar::-webkit-scrollbar { width:8px; height:8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:9999px; }

        @media (max-width: 900px) {
          .app-sidebar { transform: translateX(-110%); position:fixed; left:0; top:0; bottom:0; z-index:50; width:260px; transition: transform 240ms ease; }
          .app-sidebar.open { transform: translateX(0); }
          body.sidebar-open { overflow: hidden; }
        }
    </style>
    @stack('styles')
</head>
<body class="flex min-h-screen overflow-x-hidden overflow-y-auto text-slate-800 bg-[#FDFDFC]">
  @include('layouts.partials.sidebar')

  <div class="flex-1 flex flex-col h-full min-h-screen">
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
