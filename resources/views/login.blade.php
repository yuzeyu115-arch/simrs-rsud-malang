<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SimpleOK - RSUD Kota Malang</title>
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
            font-family: 'Poppins', sans-serif;
            overflow: hidden; /* Mengunci layar agar tidak scroll */
        }

        body {
            min-height: 100vh;
            position: relative;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.15), rgba(0, 0, 0, 0.35)), url('{{ asset('img/img/rsud_kota_malang_simrs.jpg') }}') center/cover no-repeat fixed;
        }

        /* --- RSUD Header (Pojok Kiri Atas) --- */
        .rsud-header {
            position: absolute;
            top: 30px;
            left: 30px;
            z-index: 10;
        }

        .rsud-header .logo-section {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .rsud-header .logo-section img {
            height: 52px;
            width: auto;
            display: block;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
        }

        .rsud-header .text-section h2 {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
            line-height: 1.2;
            text-transform: uppercase;
            text-shadow: 0 2px 4px rgba(0,0,0,0.6);
        }

        .rsud-header .text-section p {
            font-size: 12px;
            color: #ffffff;
            margin-top: 2px;
            font-weight: 400;
            text-shadow: 0 1px 3px rgba(0,0,0,0.5);
        }

        /* --- Main Layout --- */
        .login-main {
            display: flex;
            align-items: center;
            justify-content: flex-end; 
            min-height: 100vh;
            padding: 30px;
            width: 100%;
        }

        /* --- Login Grid (Ramping & Pas Frame) --- */
        .login-grid {
            width: 100%;
            max-width: 315px; 
            margin-right: 45px; 
        }

        /* --- Card Putih --- */
        .login-card {
            background: rgba(255, 255, 255, 0.96);
            border-radius: 24px;
            padding: 22px 20px; /* Dioptimalkan agar lebih compact */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
            width: 100%;
        }

        .card-title {
            text-align: center;
            margin-bottom: 14px;
        }

        .card-title h1 {
            font-size: 22px; 
            font-weight: 700;
            color: #0d5a36;
            margin-bottom: 2px;
        }

        .card-title p {
            font-size: 11px;
            color: #475569;
            line-height: 1.4;
        }

        /* --- Form Input --- */
        .login-form {
            margin-top: 8px;
        }

        .form-group {
            margin-bottom: 10px; 
        }

        .form-group label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 3px;
        }

        .form-group input {
            width: 100%;
            padding: 8px 12px; 
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 12.5px;
            color: #1f2937;
            background: #f8fafc;
            transition: all 0.2s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #0d5a36;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(13, 90, 54, 0.1);
        }

        /* --- Button Submit --- */
        .btn-submit {
            width: 100%;
            padding: 9px; 
            background: #0d5a36;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 6px 16px rgba(13, 90, 54, 0.15);
            margin-top: 4px;
        }

        .btn-submit:hover {
            background: #0a492c;
            transform: translateY(-1px);
        }

        /* --- Footer Card --- */
        .footer-text {
            text-align: center;
            font-size: 10px;
            color: #64748b;
            line-height: 1.4;
            margin-top: 12px;
        }

        .footer-text a {
            color: #0d5a36;
            text-decoration: none;
            font-weight: 600;
        }

        /* --- Error Box --- */
        .error-box {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 8px;
            border-radius: 6px;
            margin-bottom: 10px;
            font-size: 11.5px;
            list-style: none;
        }
    </style>
</head>
<body>

    <div class="rsud-header">
        <div class="logo-section">
            <img src="{{ asset('img/img/logo rsud.png') }}" alt="Logo RSUD Kota Malang" title="RSUD Kota Malang" loading="lazy">
            <div class="text-section">
                <h2>RSUD KOTA MALANG</h2>
                <p>Pelayanan Ramah, Kesehatan Optimal</p>
            </div>
        </div>
    </div>

    <div class="login-main">
        <div class="login-grid">
            <div class="login-card">
                <div class="card-title">
                    <h1>Selamat Datang</h1>
                    <p>Silahkan masuk sesuai jobdesk anda masing-masing</p>
                </div>

                @if ($errors->any())
                    <ul class="error-box">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="login-form">
                    @csrf

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            placeholder="Contoh: TPPSimpleOk"
                            value="{{ old('username') }}"
                            required
                            autofocus
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Masukkan Password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn-submit">Masuk</button>
                </form>

                <script>
                    // Ensure Enter submits form from any input
                    (function(){
                        var form = document.querySelector('.login-form');
                        form.addEventListener('keydown', function(e){
                            if (e.key === 'Enter') {
                                e.preventDefault();
                                form.submit();
                            }
                        });
                    })();
                </script>

                <div class="footer-text">
                    Sistem Informasi Digital IBS <br>
                    <strong>SimpleOK RSUD Kota Malang</strong>
                </div>
            </div>
        </div>
    </div>

</body>
</html>