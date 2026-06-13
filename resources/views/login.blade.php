<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - RSUD Kota Malang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { font-family: 'Inter', sans-serif; }
        html, body { 
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body { 
            background: #f5f5f5; 
        }
        .login-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }
        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
            }
            .login-right {
                display: none;
            }
        }
        .login-left {
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .login-form-card {
            background: #ffffff;
            border-radius: 1rem;
            padding: 3rem;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        .login-form-card h1 {
            color: #1f7745;
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
        }
        .login-form-card p {
            color: #6b7280;
            font-size: 0.875rem;
            margin: 0 0 2rem 0;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        .input-field {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: #1f2937;
            background: #ffffff;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            box-sizing: border-box;
        }
        .input-field:focus {
            border-color: #1f7745;
            box-shadow: 0 0 0 3px rgba(31, 119, 69, 0.1);
        }
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }
        .form-footer a {
            color: #1f7745;
            text-decoration: none;
            font-weight: 500;
        }
        .form-footer a:hover {
            text-decoration: underline;
        }
        .btn-login {
            width: 100%;
            padding: 0.85rem 1.5rem;
            border-radius: 0.5rem;
            background-color: #1f7745;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.9rem;
            box-shadow: 0 2px 8px rgba(31, 119, 69, 0.2);
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1.5rem;
        }
        .btn-login:hover {
            background-color: #155e3b;
            transform: translateY(-1px);
        }
        .btn-login:active {
            transform: translateY(0);
        }
        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }
        .divider span {
            background: #ffffff;
            padding: 0 0.75rem;
            color: #9ca3af;
            font-size: 0.75rem;
            position: relative;
            z-index: 1;
        }
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #d1d5db;
            transform: translateY(-50%);
        }
        .social-btn {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            background: #ffffff;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
            cursor: pointer;
            transition: background-color 0.2s ease, border-color 0.2s ease;
            text-decoration: none;
            margin-bottom: 1rem;
            box-sizing: border-box;
        }
        .social-btn:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }
        .terms-text {
            font-size: 0.75rem;
            color: #6b7280;
            text-align: center;
            line-height: 1.4;
        }
        .terms-text a {
            color: #1f7745;
            text-decoration: none;
            font-weight: 500;
        }
        .terms-text a:hover {
            text-decoration: underline;
        }
        .login-right {
            background-image: 
                linear-gradient(180deg, rgba(255,255,255,0.15), rgba(0,0,0,0.35)),
                url('/img/rsud-kota-malang.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            justify-content: stretch;
            position: relative;
            overflow: hidden;
        }
        .hospital-header {
            background: linear-gradient(to bottom, rgba(100, 180, 220, 0.95), rgba(50, 140, 200, 0.9));
            padding: 2rem 1.5rem 1.5rem;
            flex-shrink: 0;
        }
        .hospital-logo-icon {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
        }
        .hospital-logo-icon i {
            font-size: 2.5rem;
            color: #1f7745;
        }
        .hospital-header h2 {
            color: #1f7745;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 0.25rem 0;
        }
        .hospital-header p {
            color: #155e3b;
            font-size: 0.875rem;
            font-weight: 500;
            margin: 0;
        }
        .hospital-image {
            flex: 1;
            background-size: cover;
            background-position: center;
        }
        .hospital-footer {
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.05), rgba(0, 0, 0, 0.3));
            padding: 2rem 1.5rem;
            color: #ffffff;
            flex-shrink: 0;
        }
        .hospital-footer h3 {
            font-size: 1rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
            color: #1f7745;
        }
        .hospital-footer p {
            font-size: 0.875rem;
            line-height: 1.5;
            margin: 0;
            color: #ffffff;
        }
        .error-message {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            padding: 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Side: Login Form -->
        <div class="login-left">
            <div class="login-form-card">
                <h1>Selamat Datang Kembali</h1>
                <p>Silahkan Masuk Untuk Melanjutkan ke Dashboard</p>

                @if ($errors->any())
                    <div class="error-message">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="email" value="{{ old('email') }}" class="input-field" placeholder="Masukkan Username" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="input-field" placeholder="Masukkan Password" required>
                    </div>

                    <div class="form-footer">
                        <span>Ingat saya</span>
                        <a href="#">Lupa Password?</a>
                    </div>

                    <button type="submit" class="btn-login">MASUK</button>
                </form>

                <div class="divider">
                    <span>atau</span>
                </div>

                <a href="{{ route('auth.google') }}" class="social-btn">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Masuk dengan Google
                </a>

                <p class="terms-text">
                    Dengan masuk, Anda setuju dengan <a href="#">kebijakan privasi</a> dan <a href="#">ketentuan layanan</a>.
                </p>
            </div>
        </div>

        <!-- Right Side: Hospital Image & Info -->
        <div class="login-right">
            <div class="hospital-header">
                <div class="hospital-logo-icon">
                    <i class="fas fa-hospital"></i>
                </div>
                <h2>RSUD KOTA MALANG</h2>
                <p>Pelayanan Ramah, Kesehatan Optimal</p>
            </div>
            <div class="hospital-image"></div>
            <div class="hospital-footer">
                <h3>Selamat Datang di Sistem Informasi</h3>
                <h3 style="margin-top: 0; margin-bottom: 1rem;">RSUD KOTA MALANG</h3>
                <p>Sistem terintegrasi untuk mendukung pelayanan kesehatan yang lebih cepat, tepat dan profesional.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Optional: Auto-fill credentials for testing
            // document.querySelector('input[name="email"]').value = 'admin';
            // document.querySelector('input[name="password"]').value = 'AdminSimrsITSK!';
        });
    </script>
</body>
</html>