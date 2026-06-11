<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSUD Kota Malang - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: #f5f5f0;
        }
        .login-card {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.14), 0 8px 14px -8px rgba(0, 0, 0, 0.12);
        }
        .btn-masuk {
            background-color: #0b7d4c;
        }
        .btn-masuk:hover {
            background-color: #095f3d;
        }
        .text-rs-green {
            color: #0b7d4c;
        }
        .bg-cream {
            background-color: #f6f8f2;
        }
        input::placeholder {
            color: #94a3b8;
        }
        .login-bg {
            background: linear-gradient(180deg, rgba(4, 87, 58, 0.72), rgba(0, 0, 0, 0.4));
        }
        .login-logo {
            width: 4rem;
            height: 4rem;
            object-fit: contain;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-0 m-0 overflow-hidden bg-cream">
    <div class="flex flex-col lg:flex-row w-full min-h-screen">
        
        <!-- Left Section - Login Form -->
        <div class="w-full lg:w-[45%] flex items-center justify-center p-6 lg:p-12 relative z-10">
            <div class="bg-white rounded-3xl p-10 lg:p-14 w-full max-w-lg login-card">
                <div class="text-center mb-10">
                    <h1 class="text-4xl font-bold text-rs-green mb-2 tracking-tight">Selamat Datang Kembali</h1>
                    <p class="text-[#388e3c] font-medium">Silahkan Masuk Untuk Melanjutkan ke Dashboard</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg shadow-sm">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm font-medium">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-800 ml-1">Username</label>
                        <input 
                            type="text" 
                            name="email" 
                            value="SimrsITSK!"
                            required 
                            class="w-full px-5 py-3.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all duration-200"
                            placeholder="Masukkan Username"
                        >
                    </div>

                    <div class="space-y-2 relative">
                        <label class="block text-sm font-bold text-gray-800 ml-1">Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            value="simpleok"
                            required 
                            class="w-full px-5 py-3.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all duration-200"
                            placeholder="Masukkan Password"
                        >
                        <div class="flex justify-end mt-1">
                            <a href="#" data-title="Lupa Password" data-body="Proses reset kata sandi belum aktif. Silakan hubungi administrator." class="text-[10px] font-bold text-green-700 hover:text-green-800 transition-colors uppercase tracking-wider">
                                Lupa Password?
                            </a>
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full btn-masuk text-white font-black py-4 px-4 rounded-xl transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg text-lg tracking-widest mt-4"
                    >
                        MASUK
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-10">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-400 font-medium lowercase">atau</span>
                    </div>
                </div>

                <!-- Google Login -->
                <a 
                    href="{{ route('auth.google') }}" 
                    onclick="handleGoogleLogin(event)"
                    class="w-full flex items-center justify-center gap-3 bg-white border border-gray-300 hover:bg-gray-50 text-gray-600 font-bold py-4 px-4 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md"
                >
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-5 h-5" alt="Google">
                    <span class="text-gray-500">Masuk Dengan Google</span>
                </a>

                <!-- Footer Disclaimer -->
                <div class="mt-10 text-center">
                    <p class="text-[11px] text-gray-400 leading-relaxed">
                        Dengan masuk, Anda menyetujui <a href="#" data-title="Kebijakan Privasi" data-body="Kebijakan privasi belum tersedia di tampilan ini." class="text-green-600 font-bold hover:underline">kebijakan privasi</a> dan<br>
                        <a href="#" data-title="Ketentuan Penggunaan" data-body="Ketentuan penggunaan belum tersedia di tampilan ini." class="text-green-600 font-bold hover:underline">ketentuan penggunaan</a> sistem.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Section - Image & Info -->
        <div class="hidden lg:block w-full lg:w-[55%] relative overflow-hidden login-bg">
            <img src="{{ asset('img/rsud-kota-malang.webp') }}" alt="RSUD Kota Malang" class="absolute inset-0 w-full h-full object-cover opacity-80">
            
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/30"></div>

            <!-- Top Logo Section -->
            <div class="absolute top-12 left-12 flex items-center gap-4 bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20">
                <img src="{{ asset('img/logo.png') }}" alt="RSUD Kota Malang Logo" class="login-logo">
                <div>
                    <h2 class="text-white text-2xl font-black tracking-tight leading-none">RSUD Kota Malang</h2>
                    <p class="text-green-200 text-sm font-medium mt-1">Pelayanan Terpadu dan Profesional</p>
                </div>
            </div>

            <!-- Bottom Content -->
            <div class="absolute bottom-16 left-12 right-12 max-w-2xl">
                <div class="space-y-2">
                    <h3 class="text-white text-3xl font-black leading-tight">
                        Selamat Datang di Sistem Informasi<br>
                            <span class="text-green-300">RSUD Kota Malang</span>
                        </h3>
                        <p class="text-gray-200 text-lg font-light leading-relaxed opacity-90">
                            Sistem informasi layanan rumah sakit untuk mendukung pelayanan kesehatan yang lebih cepat, tepat, dan terintegrasi.
            <!-- Green Decorative Line -->
            <div class="absolute top-0 right-0 w-2 h-full bg-green-600/50"></div>
        </div>
    </div>
    <!-- Google Login Loading Overlay -->
    <div id="google-loading" class="fixed inset-0 bg-white/80 backdrop-blur-md z-[100] flex flex-col items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="relative w-24 h-24 mb-6">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-full h-full animate-pulse" alt="Google">
            <div class="absolute inset-0 border-4 border-green-500/30 border-t-green-600 rounded-full animate-spin"></div>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 tracking-tight">Menghubungkan ke Google...</h3>
        <p class="text-gray-500 mt-2 font-medium">Mohon tunggu sebentar</p>
    </div>

    <script>
        function handleGoogleLogin(e) {
            const overlay = document.getElementById('google-loading');
            overlay.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.add('opacity-100');
            }, 10);
        }
    </script>
</body>
</html>