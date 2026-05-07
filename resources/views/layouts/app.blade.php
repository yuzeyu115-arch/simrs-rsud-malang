<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SIMRS RSUD Kota Malang</title>
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
              'sidebar-bg': '#ffffff'
            }
          }
        }
      }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        .nav-item.active { background-color: #ecfdf5; color: #059669; border-right: 4px solid #10b981; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-gray-800">
    @include('layouts.partials.sidebar')

    <div class="flex-1 flex flex-col h-full overflow-hidden">
        @include('layouts.partials.navbar')

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50/30 p-6">
            @yield('content')
            
            <footer class="mt-10 py-4 border-t border-gray-200 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} SIMRS RSUD Kota Malang. All Rights Reserved.
            </footer>
        </main>
    </div>
    @stack('scripts')
</body>
</html>