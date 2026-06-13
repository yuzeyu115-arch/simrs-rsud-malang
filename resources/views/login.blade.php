<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RSUD Kota Malang</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            width: 100%;
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.1)), url('/img/rs-building.jpg') center/cover no-repeat fixed;
            position: relative;
        }

        /* RSUD Header */
        .rsud-header {
            position: absolute;
            top: 30px;
            left: 50px;
            z-index: 10;
        }

        .rsud-header .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .rsud-header .logo-section img {
            height: 45px;
            width: auto;
        }

        .rsud-header .text-section h2 {
            font-size: 20px;
            font-weight: 700;
            color: #0d5a36;
            margin: 0;
            line-height: 1.2;
            letter-spacing: -0.3px;
        }

        .rsud-header .text-section p {
            font-size: 11px;
            color: #666;
            margin: 2px 0 0 0;
            font-weight: 400;
        }

        /* Main Container */
        .login-main {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            height: 100vh;
            padding: 40px 60px;
        }

        /* Login Card */
        .login-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 50px 45px;
            width: 100%;
            max-width: 430px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
        }

        .card-title {
            text-align: center;
            margin-bottom: 32px;
        }

        .card-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: #0d5a36;
            margin: 0 0 10px 0;
            letter-spacing: -0.5px;
        }

        .card-title p {
            font-size: 14px;
            color: #0d5a36;
            margin: 0;
            font-weight: 500;
            line-height: 1.5;
        }

        /* Form */
        .login-form {
            margin-top: 30px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #999;
            border-radius: 6px;
            font-size: 13px;
            color: #1f2937;
            background: #fafbfc;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }

        .form-group input::placeholder {
            color: #999;
        }

        .form-group input:focus {
            outline: none;
            border-color: #0d5a36;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(13, 90, 54, 0.1);
        }

        .password-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 28px;
        }

        .password-wrapper .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .forgot-password {
            font-size: 12px;
            color: #0d5a36;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
            padding-top: 32px;
        }

        .forgot-password:hover {
            text-decoration: underline;
            color: #084a2a;
        }

        .btn-submit {
            width: 100%;
            padding: 13px 16px;
            background: linear-gradient(135deg, #0d5a36 0%, #084a2a 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 24px;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 4px 15px rgba(13, 90, 54, 0.25);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 90, 54, 0.35);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            margin: 28px 0;
            gap: 12px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            font-size: 12px;
            color: #9ca3af;
            font-weight: 500;
        }

        /* Google Button */
        .btn-google {
            width: 100%;
            padding: 12px 16px;
            background: #ffffff;
            color: #1f2937;
            border: 1.5px solid #ddd;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: 'Poppins', sans-serif;
            margin-bottom: 24px;
        }

        .btn-google:hover {
            background: #f9fafb;
            border-color: #bbb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .btn-google svg {
            width: 17px;
            height: 17px;
        }

        /* Footer Text */
        .footer-text {
            text-align: center;
            font-size: 11px;
            color: #666;
            line-height: 1.6;
            margin-top: 16px;
        }

        .footer-text a {
            color: #0d5a36;
            text-decoration: none;
            font-weight: 600;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        /* Error Message */
        .error-box {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 12px 14px;
            border-radius: 6px;
            margin-bottom: 24px;
            font-size: 12px;
            font-weight: 500;
        }

        .error-box strong {
            display: block;
            margin-bottom: 4px;
        }

        @media (max-width: 1024px) {
            .login-main {
                justify-content: center;
                padding: 20px;
            }

            .rsud-header {
                top: 20px;
                left: 20px;
            }

            .login-card {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- RSUD Header -->
    <div class="rsud-header">
        <div class="logo-section">
            <img src="{{ asset('/img/logo_rs.png') }}" alt="Logo RSUD">
            <div class="text-section">
                <h2>RSUD KOTA MALANG</h2>
                <p>Pelayanan Ramah, Kesehatan Optimal</p>
            </div>
        </div>
    </div>

    <!-- Main Login Section -->
    <div class="login-main">
        <div class="login-card">
            <div class="card-title">
                <h1>Selamat Datang Kembali</h1>
                <p>Silahkan Masuk Untuk Melanjutkan ke Dashboard</p>
            </div>

            @if ($errors->any())
                <div class="error-box">
                    <strong>Login Gagal!</strong>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="login-form">
                @csrf

                <div class="form-group">
                    <label for="email">Username</label>
                    <input 
                        type="text" 
                        id="email" 
                        name="email" 
                        placeholder="Masukkan Username"
                        value="SIMRS"
                        required
                        autofocus
                    >
                </div>

                <div class="password-wrapper">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Masukkan Password"
                            value="SimpleOkITSK!"
                            required
                        >
                    </div>
                    <a href="#" class="forgot-password">Lupa Password?</a>
                </div>

                <button type="submit" class="btn-submit">Masuk</button>
            </form>

            <div class="divider">
                <span>atau</span>
            </div>

            <button type="button" class="btn-google" onclick="alert('Google login sedang tidak tersedia')">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Masuk Dengan Google
            </button>

            <div class="footer-text">
                Dengan masuk, Anda menyetujui <a href="#">kebijakan privasi</a> dan <a href="#">kebijakan penggunaan sistem</a>.
            </div>
        </div>
    </div>
</body>
</html>
