<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PMB Masoem University</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
        }

        .header {
            background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
            padding: 20px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #E94B8B 0%, #7B4BE9 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        .header-title {
            color: white;
            font-size: 24px;
            font-weight: 600;
        }

        .header-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 10px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid white;
        }

        .btn-outline {
            background: transparent;
            color: white;
        }

        .btn-outline:hover {
            background: white;
            color: #4A90E2;
        }

        .btn-light {
            background: white;
            color: #4A90E2;
            border-color: white;
        }

        .btn-light:hover {
            background: rgba(255,255,255,0.9);
        }

        .wave-divider {
            height: 60px;
            background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
            position: relative;
        }

        .wave-divider::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: #f5f5f5;
            border-radius: 100% 100% 0 0 / 100% 100% 0 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
            text-align: center;
        }

        .university-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 40px;
        }

        .u-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #4A90E2 0%, #7B4BE9 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: bold;
            color: white;
        }

        .university-name {
            font-size: 48px;
            font-weight: 600;
            color: #333;
        }

        .content {
            background: white;
            padding: 50px 80px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 40px;
        }

        .greeting {
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
        }

        .description {
            font-size: 20px;
            line-height: 1.8;
            color: #555;
            text-align: left;
            max-width: 900px;
            margin: 0 auto;
        }

        .register-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }

        .register-text {
            font-size: 18px;
            color: #666;
        }

        .btn-register {
            padding: 15px 50px;
            background: linear-gradient(135deg, #007BFF 0%, #0056D2 100%);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(0,123,255,0.3);
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,123,255,0.4);
        }

        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
            }

            .content {
                padding: 30px 20px;
            }

            .description {
                font-size: 18px;
            }

            .university-name {
                font-size: 32px;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo-section">
            <div class="logo">M</div>
            <h1 class="header-title">PMB Masoem University</h1>
        </div>
        <div class="header-buttons">
            <a href="{{ route('register') }}" class="btn btn-outline">Register</a>
            <a href="{{ route('login') }}" class="btn btn-light">Login</a>
        </div>
    </header>

    <div class="wave-divider"></div>

    <div class="container">
        <div class="university-logo">
            <div class="u-icon">U</div>
            <h2 class="university-name">Masoem University</h2>
        </div>

        <div class="content">
            <h3 class="greeting">Hallo para calon mahasiswa bahasiswa baru Universitas Ma'soem!</h3>
            <p class="description">
                Kami mengundang anda untuk bergabung dengan kami, disini tersedia 5 Fakultas dengan 11 Program Study yang siap kamu pilih sesuai dengan minat dan bakat. Pendaftaran untuk gelombang pertaman akan dimulai pada tanggal 10 Januari 2026. Pantau terus Media Sosial kami untuk info menarik lainnya.
            </p>
        </div>

        <div class="register-section">
            <span class="register-text">Belum punya akun? Register disini!</span>
            <a href="{{ route('register') }}" class="btn-register">Register</a>
        </div>
    </div>
</body>
</html>