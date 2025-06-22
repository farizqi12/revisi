<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            --primary-light: #667eea;
            --primary-dark: #764ba2;
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            --shadow-light: 0 8px 32px rgba(31, 38, 135, 0.37);
            --shadow-hover: 0 15px 35px rgba(31, 38, 135, 0.25);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding-top: 80px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 119, 198, 0.2) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        /* Glassmorphism Navbar */
            * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .navbar {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            box-shadow: var(--shadow-light);
            padding: 1rem 2rem;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            color: white !important;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand i {
            background: linear-gradient(45deg, #fff, #f0f0f0);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-right: 12px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            padding: 0.6rem 1.2rem;
            margin: 0 0.3rem;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-logout {
            background: var(--secondary-gradient);
            border: none;
            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 600;
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(245, 87, 108, 0.3);
        }

        .btn-logout:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(245, 87, 108, 0.4);
            filter: brightness(1.1);
        }

        /* Main Container */
        .main-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: var(--shadow-light);
            padding: 2rem;
            margin-bottom: 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
        }

        .glass-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .welcome-title {
            color: white;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .welcome-title i {
            margin-right: 15px;
            animation: wave 2s infinite;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        @keyframes wave {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(15deg);
            }

            75% {
                transform: rotate(-15deg);
            }
        }

        .text-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }

        /* Enhanced User Avatar */
        .user-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            padding: 3px;
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .user-avatar::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            transition: all 0.6s;
            opacity: 0;
        }

        .user-avatar:hover::before {
            opacity: 1;
            animation: shine 0.6s ease-in-out;
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
        }

        .user-avatar img {
            border-radius: 50%;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .user-avatar:hover {
            transform: scale(1.08);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
        }

        /* Enhanced Balance Card */
        .balance-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.1) 100%);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 2rem;
            margin-top: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .balance-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.8s;
        }

        .balance-card:hover::after {
            left: 100%;
        }

        .balance-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .balance-info h3 {
            color: white;
            font-weight: 700;
            font-size: 2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .balance-actions {
            display: flex;
            gap: 12px;
            margin-left: 20px;
        }

        .balance-action-btn {
            border: none;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
            text-decoration: none;
        }

        .topup-btn {
            background: rgba(76, 175, 80, 0.2);
            color: #4CAF50;
            border: 1px solid rgba(76, 175, 80, 0.3);
        }

        .topup-btn:hover {
            background: rgba(76, 175, 80, 0.3);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(76, 175, 80, 0.3);
            color: #4CAF50;
        }

        .withdraw-btn {
            background: rgba(244, 67, 54, 0.2);
            color: #f44336;
            border: 1px solid rgba(244, 67, 54, 0.3);
        }

        .withdraw-btn:hover {
            background: rgba(244, 67, 54, 0.3);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(244, 67, 54, 0.3);
            color: #f44336;
        }

        .balance-icon {
            background: rgba(255, 193, 7, 0.2);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.4s ease;
            border: 1px solid rgba(255, 193, 7, 0.3);
            backdrop-filter: blur(10px);
        }

        .balance-icon:hover {
            transform: rotate(15deg) scale(1.1);
            background: rgba(255, 193, 7, 0.3);
        }

        /* Enhanced Action Grid */
        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 2rem;
        }

        .action-btn {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 2rem 1.5rem;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            min-height: 140px;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .action-btn:hover::before {
            transform: scaleX(1);
        }

        .action-btn i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
        }

        .action-btn span {
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .action-btn:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .action-btn:hover i {
            transform: scale(1.2) rotate(5deg);
        }

        /* Enhanced Badges */
        .badge {
            padding: 8px 12px;
            font-weight: 600;
            border-radius: 8px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .bg-light {
            background: rgba(255, 255, 255, 0.2) !important;
            color: #4CAF50 !important;
        }

        /* Statistics Card Enhancement */
        .stats-card {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 2rem;
            margin-top: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 1rem;
        }

        .stat-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .chart-section {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 3rem;
            align-items: center;
            margin-top: 2rem;
        }

        .chart-container {
            position: relative;
            width: 100%;
            max-width: 500px;
            height: 350px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .chart-container:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .chart-legend {
            display: flex;
            flex-direction: column;
            gap: 15px;
            min-width: 200px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .legend-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(10px);
        }

        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .legend-color::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            right: 2px;
            bottom: 2px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), transparent);
        }

        .legend-content {
            flex: 1;
        }

        .legend-label {
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 2px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .legend-value {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .chart-title {
            text-align: center;
            color: white;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }


        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar-collapse {
                background: var(--glass-bg);
                backdrop-filter: blur(15px);
                border-radius: 0 0 20px 20px;
                margin-top: 1rem;
                border: 1px solid var(--glass-border);
                padding: 1rem;
            }

            .main-container {
                padding: 1rem;
            }

            .glass-card {
                padding: 1.5rem;
            }

            .welcome-title {
                font-size: 1.5rem;
            }

            .balance-content {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .balance-actions {
                margin-left: 0;
                justify-content: center;
            }

            .action-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .chart-container {
                height: 250px;
                padding: 15px;
            }

            .legend-item {
                min-width: 100px;
                padding: 10px 12px;
            }

            .legend-label {
                font-size: 0.85rem;
            }

            .legend-value {
                font-size: 0.8rem;
            }
        }

        /* Floating Animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Loading Animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <!-- Enhanced Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/dashboard-guru">
                <i class="fas fa-tachometer-alt"></i>Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/profil">
                            <i class="fas fa-user"></i> Profil Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/riwayat-topup">
                            <i class="fas fa-history"></i> Riwayat Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/riwayat-absensi">
                            <i class="fas fa-clipboard-list"></i> Riwayat Absensi
                        </a>
                    </li>
                </ul>
                <div class="d-flex">
                    <form method="POST" action="/logout" id="logoutForm">
                        @csrf
                        <button type="submit" class="btn btn-logout">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Enhanced Main Content -->
    <div class="main-container animate__animated animate__fadeIn">
        <!-- Welcome Card -->
        <div class="glass-card floating">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div class="flex-grow-1">
                    <h2 class="welcome-title mb-3">
                        <i class="fas fa-hand-paper"></i>Selamat Datang,
                        <span class="text-gradient">{{ $username }}</span>
                    </h2>
                    <p class="text-light mb-4 opacity-75">Anda telah berhasil login ke sistem kami</p>
                </div>
                <a href="/profil" class="text-decoration-none">
                    <div class="user-avatar">
                        @if (!empty($userPhotoUrl))
                            <img src="{{ $userPhotoUrl }}" alt="Foto Profil">
                        @else
                            <i class="fas fa-user-circle fa-3x text-white"></i>
                        @endif
                    </div>
                </a>
            </div>

            <!-- Enhanced Balance Card -->
            <div class="balance-card">
                <div class="balance-content">
                    <div class="balance-info flex-grow-1">
                        <p class="mb-2 text-light opacity-75">Total Saldo</p>
                        <h3 class="mb-2">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <span class="badge bg-light">
                                <i class="fas fa-arrow-up me-1"></i> Aktif
                            </span>
                            <small class="text-light opacity-75">Update terakhir: sekarang</small>
                        </div>
                    </div>
                    <div class="balance-actions">
                        <a href="/topup" class="balance-action-btn topup-btn">
                            <i class="fas fa-coins"></i>
                            Top Up
                        </a>
                        <a href="/topup-penarikan" class="balance-action-btn withdraw-btn">
                            <i class="fas fa-money-bill-wave"></i>
                            Penarikan
                        </a>
                        <div class="balance-icon">
                            <a href="/riwayat-topup" class="text-decoration-none">
                                <i class="fas fa-wallet fa-2x text-warning"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Enhanced Action Grid -->
            <div class="action-grid">
                <a href="/absensi" class="action-btn">
                    <i class="fas fa-fingerprint text-success"></i>
                    <span>Absen Masuk</span>
                </a>
                <a href="/absensipulang" class="action-btn">
                    <i class="fas fa-sign-out-alt text-danger"></i>
                    <span>Absen Pulang</span>
                </a>
                <a href="/absensi-izin" class="action-btn">
                    <i class="fas fa-procedures text-info"></i>
                    <span>Izin</span>
                </a>
            </div>
        </div>

        <!-- Enhanced Statistics Card -->
        <div class="glass-card floating" style="animation-delay: 0.2s;">
            <h3 class="welcome-title mb-4">
                <i class="fas fa-chart-line"></i> Statistik Kerja
            </h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">{{ $totalJamKerja }}</div>
                    <div class="stat-label">Total Jam Kerja</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $hariAktifKerja }}</div>
                    <div class="stat-label">Hari Aktif Kerja</div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="glass-card" style="max-width: 900px; width: 100%;">
                <section class="chart-section">
                    <div class="chart-container">
                        <div class="chart-title">Statistik Absensi</div>
                        <canvas id="absensiChart" width="400" height="350"></canvas>
                    </div>

                    <div class="chart-legend">
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #36A2EB;"></div>
                            <div class="legend-content">
                                <div class="legend-label">Masuk</div>
                                <div class="legend-value">
                                    {{ round(($absensiData['masuk'] / max(1, $absensiData['masuk'] + $absensiData['izin'] + $absensiData['sakit'])) * 100) }}%
                                </div>
                            </div>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #FFCE56;"></div>
                            <div class="legend-content">
                                <div class="legend-label">Izin</div>
                                <div class="legend-value">
                                    {{ round(($absensiData['izin'] / max(1, $absensiData['masuk'] + $absensiData['izin'] + $absensiData['sakit'])) * 100) }}%
                                </div>
                            </div>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #FF6384;"></div>
                            <div class="legend-content">
                                <div class="legend-label">Sakit</div>
                                <div class="legend-value">
                                    {{ round(($absensiData['sakit'] / max(1, $absensiData['masuk'] + $absensiData['izin'] + $absensiData['sakit'])) * 100) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Panggil Komponen Loading Modal -->
    <x-loading-modal />

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enhanced animations and interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Stagger animation for cards
            const cards = document.querySelectorAll('.glass-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });

            // Parallax effect for background
            let ticking = false;

            function updateParallax() {
                const scrolled = window.pageYOffset;
                const parallax = document.querySelector('body::before');
                if (parallax) {
                    parallax.style.transform = `translateY(${scrolled * 0.5}px)`;
                }
                ticking = false;
            }

            function requestTick() {
                if (!ticking) {
                    requestAnimationFrame(updateParallax);
                    ticking = true;
                }
            }

            window.addEventListener('scroll', requestTick);

            // Enhanced hover effects for action buttons
            const actionButtons = document.querySelectorAll('.action-btn');
            actionButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });

                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Add smooth reveal animation on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all cards for scroll animations
            document.querySelectorAll('.glass-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
        });

        // Enhanced loading function (assumes this exists in your loading modal component)
        function showLoading(message = 'Loading...') {
            // This function should be implemented in your loading modal component
            console.log('Loading:', message);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('absensiChart').getContext('2d');
            const absensiData = @json($absensiData);

            const total = absensiData.masuk + absensiData.izin + absensiData.sakit;

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: [
                        `Masuk (${absensiData.masuk} - ${Math.round((absensiData.masuk/total)*100)}%)`,
                        `Izin (${absensiData.izin} - ${Math.round((absensiData.izin/total)*100)}%)`,
                        `Sakit (${absensiData.sakit} - ${Math.round((absensiData.sakit/total)*100)}%)`
                    ],
                    datasets: [{
                        data: [absensiData.masuk, absensiData.izin, absensiData.sakit],
                        backgroundColor: [
                            '#36A2EB', // Biru untuk Masuk
                            '#FFCE56', // Kuning untuk Izin
                            '#FF6384' // Merah untuk Sakit
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${percentage}%`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
