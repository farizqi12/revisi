<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Leaflet CSS for maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --primary-light: #667eea;
            --primary-dark: #764ba2;
            --secondary-color: #4a5568;
            --accent-color: #48bb78;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --danger-color: #EF4444;
            --glass-bg: rgba(255, 255, 255, 0.95);
            --glass-border: rgba(255, 255, 255, 0.18);
        }

        /* Loading Modal Styles */
        #loadingModal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }

        .loading-content {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(102, 126, 234, 0.2);
            border-top-color: var(--primary-light);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        #loadingText {
            font-weight: 600;
            color: var(--secondary-color);
        }

        /* Notification Container */
        .notification-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1100;
            width: 350px;
            max-width: 100%;
        }

        .custom-alert {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: none;
            overflow: hidden;
            margin-bottom: 15px;
            background-color: #fff !important;
            /* Default solid background */
        }

        .custom-alert.alert-success {
            background-color: #d1fae5 !important;
            color: #065f46 !important;
        }

        .custom-alert.alert-danger,
        .custom-alert.alert-error {
            background-color: #fee2e2 !important;
            color: #991b1b !important;
        }

        .custom-alert.alert-warning {
            background-color: #fef9c3 !important;
            color: #92400e !important;
        }

        .custom-alert.alert-info {
            background-color: #e0f2fe !important;
            color: #0369a1 !important;
        }

        .custom-alert .alert-icon {
            font-size: 1.5rem;
            margin-right: 12px;
        }

        .custom-alert .btn-close {
            position: absolute;
            top: 12px;
            right: 12px;
        }

        /* Body Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-attachment: fixed;
            min-height: 100vh;
            padding-top: 70px;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><radialGradient id="grad" cx="50%" cy="50%" r="50%"><stop offset="0%" style="stop-color:rgba(255,255,255,0.1);stop-opacity:1" /><stop offset="100%" style="stop-color:rgba(255,255,255,0);stop-opacity:1" /></radialGradient></defs><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="20" r="1" fill="rgba(255,255,255,0.08)"/><circle cx="40" cy="60" r="1.5" fill="rgba(255,255,255,0.06)"/><circle cx="90" cy="70" r="1" fill="rgba(255,255,255,0.04)"/><circle cx="10" cy="80" r="2" fill="rgba(255,255,255,0.05)"/></svg>') repeat;
            pointer-events: none;
            z-index: -1;
        }

        /* Navbar */
        .navbar {
            background: var(--primary-gradient);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 2rem;
            backdrop-filter: blur(10px);
        }

        .btn-logout {
            background: #e74c3c;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-logout:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        .navbar-brand {
            font-weight: 600;
            color: white !important;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover i {
            transform: rotate(15deg);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            border-radius: 8px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link i {
            font-size: 0.9em;
            width: 20px;
            text-align: center;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white !important;
            transform: translateY(-2px);
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.2);
            transition: all 0.3s;
        }

        .navbar-toggler:hover {
            transform: scale(1.1);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Main Content */
        .main-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .location-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 8px 32px rgba(102, 126, 234, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            padding: 2.5rem;
            margin-bottom: 2.5rem;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
        }

        .location-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--primary-gradient);
            border-radius: 24px 24px 0 0;
        }

        .location-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.05) 0%, transparent 70%);
            pointer-events: none;
            transition: opacity 0.3s ease;
            opacity: 0;
        }

        .location-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow:
                0 30px 60px rgba(0, 0, 0, 0.15),
                0 12px 40px rgba(102, 126, 234, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .location-card:hover::after {
            opacity: 1;
        }

        .location-title {
            color: var(--primary-dark);
            font-weight: 800;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            font-size: 1.75rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .location-title i {
            margin-right: 15px;
            animation: pulse 2s infinite;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.5em;
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

        /* Info Grid Styles */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 2rem;
        }

        .info-item {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            padding: 20px;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
        }

        .info-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-gradient);
            transition: width 0.3s ease;
        }

        .info-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 100%);
        }

        .info-item:hover::before {
            width: 8px;
        }

        .info-label {
            font-size: 0.85rem;
            color: var(--secondary-color);
            font-weight: 700;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-label i {
            font-size: 0.9em;
            opacity: 0.7;
        }

        .info-value {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0;
            line-height: 1.2;
        }

        /* Status Badges with improved design */
        .status-badge {
            padding: 10px 16px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s ease;
        }

        .status-badge:hover::before {
            left: 100%;
        }

        .status-badge i {
            font-size: 0.9em;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-2px);
            }
        }

        .status-active {
            background: linear-gradient(135deg, var(--success-color), #059669);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .status-inactive {
            background: linear-gradient(135deg, var(--danger-color), #DC2626);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .status-pending {
            background: linear-gradient(135deg, var(--warning-color), #D97706);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        /* Distance Display Enhanced */
        .distance-display {
            font-size: 1rem;
            color: var(--secondary-color);
            background: rgba(255, 255, 255, 0.8);
            padding: 12px 18px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            font-weight: 600;
        }

        .distance-value {
            font-weight: 800;
            color: var(--primary-dark);
            font-size: 1.1em;
        }

        /* Attendance Section Enhanced */
        .attendance-section {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.8));
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 25px;
            margin-top: 20px;
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
        }

        .attendance-section:hover {
            transform: translateY(-2px);
            box-shadow:
                0 12px 40px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.5);
        }

        .attendance-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 16px;
            padding: 16px 32px;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow:
                0 6px 20px rgba(102, 126, 234, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .attendance-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .attendance-btn:hover::before {
            left: 100%;
        }

        .attendance-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow:
                0 10px 30px rgba(102, 126, 234, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .attendance-btn:active {
            transform: translateY(-1px) scale(1.02);
        }

        .attendance-btn:disabled {
            background: linear-gradient(135deg, #e2e8f0, #cbd5e0);
            color: #a0aec0;
            cursor: not-allowed;
            transform: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .attendance-btn:disabled::before {
            display: none;
        }

        .attendance-btn i {
            font-size: 1.1em;
            animation: fingerprint 2s infinite;
        }

        @keyframes fingerprint {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Enhanced Time Info Row */
        .row.mb-3 .info-item {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            border-left: 4px solid var(--primary-gradient);
        }

        /* Enhanced Address Section */
        .mb-3:last-of-type .info-item {
            background: linear-gradient(135deg, rgba(72, 187, 120, 0.05), rgba(56, 178, 172, 0.05));
            border-left: 4px solid var(--accent-color);
            padding: 20px;
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Empty State Enhancement */
        .location-card.text-center {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 2px dashed rgba(102, 126, 234, 0.3);
            padding: 4rem 2rem;
        }

        .location-card.text-center i {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
        }

        .location-card.text-center h3 {
            color: var(--primary-dark);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        /* Responsive Improvements */
        @media (max-width: 992px) {
            .info-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 15px;
            }
        }

        @media (max-width: 768px) {
            .navbar-collapse {
                padding: 1rem;
                background: var(--primary-gradient);
                border-radius: 0 0 15px 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }

            .nav-item {
                margin-bottom: 0.5rem;
            }

            .main-container {
                padding: 1rem;
            }

            .location-card {
                padding: 2rem;
                margin-bottom: 2rem;
            }

            .location-title {
                font-size: 1.5rem;
            }

            .info-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .attendance-section {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
                text-align: center;
            }

            .attendance-btn {
                justify-content: center;
                padding: 14px 24px;
            }

            .notification-container {
                top: 70px;
                right: 10px;
                width: 95%;
            }
        }

        @media (max-width: 576px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .location-title {
                font-size: 1.3rem;
            }

            .location-card {
                padding: 1.5rem;
            }
        }

        /* Additional subtle animations */
        .location-card {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>
   <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/dashboard">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/user-manage">
                        <i class="fas fa-user"></i> Kelola Pengguna </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/kelola-transaksi">
                            <i class="fas fa-piggy-bank me-1"></i> Kelola Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/pantau-absen">
                            <i class="fas fa-calendar-check me-1"></i> Pantau Absen
                        </a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="/atur-absen">
                            <i class="fa-solid fa-location-crosshairs"></i> Atur Lokasi Absen
                        </a>
                    </li>
                </ul>
                <div class="d-flex">
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="btn btn-logout">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- main content --}}
        <div class="location-card">
            <div class="location-title">
                <i class="fas fa-clipboard-list"></i> Riwayat Absensi
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Lokasi</th>
                            <th>Koordinat</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensi as $absen)
                            <tr>
                                <td>{{ $loop->iteration + ($absensi->currentPage() - 1) * $absensi->perPage() }}</td>
                                <td>{{ $absen->user->name }}</td>

                                <td>
                                    {{ $absen->created_at->format('d-m-Y') }}<br>
                                    <small class="text-muted">{{ $absen->created_at->format('H:i:s') }}</small>
                                </td>
                                <td>
                                    @php
                                        $typeConfig = [
                                            'masuk' => ['icon' => 'sign-in-alt', 'color' => 'primary'],
                                            'pulang' => ['icon' => 'sign-out-alt', 'color' => 'info'],
                                            'izin' => ['icon' => 'envelope', 'color' => 'warning'],
                                            'sakit' => ['icon' => 'procedures', 'color' => 'danger'],
                                        ][$absen->type] ?? ['icon' => 'question-circle', 'color' => 'secondary'];
                                    @endphp
                                    <span class="badge bg-{{ $typeConfig['color'] }}">
                                        <i class="fas fa-{{ $typeConfig['icon'] }} me-1"></i>
                                        {{ ucfirst($absen->type) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        <span
                                            class="badge {{ $absen->status_waktu === 'tepat waktu' ? 'bg-success' : 'bg-danger' }}">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ ucfirst($absen->status_waktu) }}
                                        </span>
                                        <span
                                            class="badge {{ $absen->status_lokasi === 'dalam radius' ? 'bg-success' : 'bg-danger' }}">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ ucfirst($absen->status_lokasi) }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    @if ($absen->lokasi)
                                        <div class="d-flex flex-column">
                                            <strong>{{ $absen->lokasi->name }}</strong>
                                            <small class="text-muted">{{ $absen->lokasi->alamat }}</small>
                                            <small>
                                                <span class="badge bg-secondary">{{ $absen->lokasi->type }}</span>
                                                <span class="badge bg-light text-dark">{{ $absen->lokasi->radius }}
                                                    m</span>
                                            </small>
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small>
                                            <strong>Absen:</strong>
                                            {{ number_format($absen->latitude, 6) }},
                                            {{ number_format($absen->longitude, 6) }}
                                        </small>
                                        @if ($absen->lokasi)
                                            <small>
                                                <strong>Acuan:</strong>
                                                {{ number_format($absen->lokasi->latitude, 6) }},
                                                {{ number_format($absen->lokasi->longitude, 6) }}
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse"
                                        data-bs-target="#detail-{{ $absen->id }}">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="collapse bg-light" id="detail-{{ $absen->id }}">
                                <td colspan="7">
                                    <div class="p-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6><i class="fas fa-info-circle me-2"></i>Detail Absensi</h6>
                                                <ul class="list-unstyled">
                                                    <li><strong>Durasi:</strong> {{ $absen->durasi ?? '-' }}</li>
                                                    <li><strong>Catatan:</strong> {{ $absen->notes ?? '-' }}</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                @if ($absen->lokasi)
                                                    <h6><i class="fas fa-map-marked-alt me-2"></i>Jam Kerja Lokasi</h6>
                                                    <ul class="list-unstyled">
                                                        <li><strong>Jam Masuk:</strong>
                                                            {{ $absen->lokasi->jam_masuk ?? '-' }}
                                                        </li>
                                                        <li><strong>Jam Pulang:</strong>
                                                            {{ $absen->lokasi->jam_sampai ?? '-' }}
                                                        </li>
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
                                    Belum ada riwayat absensi hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $absensi->links() }}
                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
        </script>
</body>

</html>
