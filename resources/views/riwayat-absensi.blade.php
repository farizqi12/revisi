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
    <style>
        /* Variables */
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --primary-light: #667eea;
            --primary-dark: #764ba2;
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
        }

        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--primary-gradient);
            min-height: 100vh;
            padding-top: 80px;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Effects */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            pointer-events: none;
            z-index: -1;
        }

        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            top: 10%;
            left: 20%;
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            top: 70%;
            right: 10%;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(45deg);
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            bottom: 20%;
            left: 10%;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        /* Navbar */
        .navbar {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            color: white;
            font-size: 1.4rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 0.7rem 1.2rem;
            margin: 0 0.3rem;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .nav-link i {
            margin-right: 8px;
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-2px);
        }

        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            color: white;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        /* Main Content */
        .main-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
        }

        /* Card */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
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
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
        }

        .glass-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .card-title {
            color: white;
            font-weight: 700;
            margin-bottom: 2rem;
            font-size: 1.8rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .card-title i {
            background: var(--success-gradient);
            padding: 12px;
            border-radius: 12px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Table */
        .table-container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 1rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow-x: auto;
        }

        .modern-table {
            width: 100%;
            background: transparent;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .modern-table thead th {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1));
            color: white;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border: none;
            text-align: left;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            white-space: nowrap;
        }

        .modern-table thead th:first-child {
            border-radius: 12px 0 0 12px;
        }

        .modern-table thead th:last-child {
            border-radius: 0 12px 12px 0;
        }

        .modern-table tbody tr {
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            border-radius: 12px;
        }

        .modern-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(4px);
        }

        .modern-table tbody td {
            padding: 1.2rem 1.5rem;
            border: none;
            color: white;
            vertical-align: middle;
            position: relative;
        }

        .modern-table tbody td:first-child {
            border-radius: 12px 0 0 12px;
        }

        .modern-table tbody td:last-child {
            border-radius: 0 12px 12px 0;
        }

        /* Badges & Buttons */
        .modern-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .badge-primary {
            background: var(--primary-gradient);
            color: white;
        }

        .badge-success {
            background: var(--success-gradient);
            color: white;
        }

        .badge-danger {
            background: var(--secondary-gradient);
            color: white;
        }

        .badge-warning {
            background: var(--warning-gradient);
            color: white;
        }

        .badge-info {
            background: linear-gradient(135deg, #00c6fb 0%, #005bea 100%);
            color: white;
        }

        .badge-secondary {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .modern-btn {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .modern-btn i {
            margin-right: 8px;
            font-size: 0.9rem;
        }

        .modern-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .modern-btn:hover::before {
            left: 100%;
        }

        .modern-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .btn-logout {
            background: var(--secondary-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
        }

        .btn-logout i {
            margin-right: 8px;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        /* Alerts */
        .modern-alert {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 1.5rem;
            color: white;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .modern-alert i {
            margin-right: 12px;
            font-size: 1.2rem;
        }

        .modern-alert.alert-success {
            border-left: 4px solid #4CAF50;
        }

        .modern-alert.alert-danger {
            border-left: 4px solid #f44336;
        }

        .modern-alert.alert-warning {
            border-left: 4px solid #FF9800;
        }

        .modern-alert.alert-info {
            border-left: 4px solid #2196F3;
        }

        /* Pagination */
        .pagination {
            justify-content: center;
            margin-top: 2rem;
        }

        .page-link {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            margin: 0 0.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-2px);
        }

        .page-item.active .page-link {
            background: var(--primary-gradient);
            border-color: transparent;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .card-title {
                font-size: 1.6rem;
            }

            .modern-table thead th,
            .modern-table tbody td {
                padding: 1rem;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }

            .glass-card {
                padding: 1.5rem;
            }

            .card-title {
                font-size: 1.4rem;
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }

            .table-container {
                padding: 0.5rem;
            }

            .modern-table {
                font-size: 0.8rem;
            }

            .modern-table thead th,
            .modern-table tbody td {
                padding: 0.8rem;
            }

            .navbar-collapse {
                background: var(--glass-bg);
                backdrop-filter: blur(20px);
                border-radius: 12px;
                margin-top: 1rem;
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .card-title i {
                padding: 8px;
                font-size: 1rem;
            }

            .modern-badge {
                font-size: 0.7rem;
                padding: 0.4rem 0.8rem;
            }

            .modern-table thead th,
            .modern-table tbody td {
                padding: 0.6rem;
                font-size: 0.75rem;
            }

            .modern-table thead th i,
            .modern-table tbody td i {
                display: none;
            }

            .navbar {
                padding: 0.8rem 1rem;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>

<body>
    <!-- Floating Background Shapes -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/dashboard-guru">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
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
                        <a class="nav-link active text-white" href="/riwayat-absensi">
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

    <!-- Main Content -->
    <div class="main-container animate__animated animate__fadeIn">
        <!-- Success Alert -->
        @if (session('success'))
            <div class="modern-alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif

        <!-- Error Alert -->
        @if (session('error'))
            <div class="modern-alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif

        <!-- Main Card -->
        <div class="glass-card animate__animated animate__fadeInUp">
            <h4 class="card-title">
                <i class="fas fa-clipboard-list"></i>
                Riwayat Absensi
            </h4>

            <div class="d-flex justify-content-end gap-2 mb-4 flex-wrap">
                <form method="GET" action="{{ route('riwayat.absen.now') }}" class="w-100 w-md-auto">
                    <input type="hidden" name="filter" value="today">
                    <button type="submit" class="modern-btn w-100">
                        <i class="fas fa-filter"></i> Hari Ini
                    </button>
                </form>

                <form method="GET" action="{{ route('riwayat.absen.sort') }}" class="input-group w-100"
                    style="max-width: 500px;">
                    <select name="year" class="form-select">
                        @foreach (range(date('Y'), date('Y') + 10) as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                    <select name="month" class="form-select">
                        @foreach (range(1, 12) as $month)
                            <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="modern-btn">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('riwayat.absen.export', request()->query()) }}" class="modern-btn"
                        style="background: var(--success-gradient);">
                        <i class="fas fa-file-excel"></i> Export
                    </a>
                </form>
            </div>

            <div class="table-container animate__animated animate__fadeInRight">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-2 d-none d-md-inline"></i>No</th>
                            <th><i class="fas fa-calendar me-2 d-none d-md-inline"></i>Tanggal</th>
                            <th><i class="fas fa-tag me-2 d-none d-md-inline"></i>Tipe</th>
                            <th><i class="fas fa-info-circle me-2 d-none d-md-inline"></i>Status</th>
                            <th><i class="fas fa-map-marker-alt me-2 d-none d-md-inline"></i>Lokasi</th>
                            <th><i class="fas fa-map-pin me-2 d-none d-md-inline"></i>Koordinat</th>
                            <th><i class="fas fa-ellipsis-h me-2 d-none d-md-inline"></i>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensi as $absen)
                            <tr class="animate__animated animate__fadeInUp"
                                style="animation-delay: {{ $loop->index * 0.05 }}s">
                                <td>
                                    <span
                                        class="badge bg-secondary">{{ $loop->iteration + ($absensi->currentPage() - 1) * $absensi->perPage() }}</span>
                                </td>
                                <td>
                                    <div>
                                        <div style="font-weight: 600;">{{ $absen->created_at->format('d/m/Y') }}</div>
                                        <small style="opacity: 0.7;">{{ $absen->created_at->format('H:i:s') }}</small>
                                    </div>
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
                                    <span class="modern-badge badge-{{ $typeConfig['color'] }}">
                                        <i class="fas fa-{{ $typeConfig['icon'] }} me-1"></i>
                                        <span class="d-none d-md-inline">{{ ucfirst($absen->type) }}</span>
                                        <span
                                            class="d-inline d-md-none">{{ substr(ucfirst($absen->type), 0, 1) }}</span>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-2">
                                        <span
                                            class="modern-badge {{ $absen->status_waktu === 'tepat waktu' ? 'badge-success' : 'badge-danger' }}">
                                            <i class="fas fa-clock me-1"></i>
                                            <span
                                                class="d-none d-md-inline">{{ ucfirst($absen->status_waktu) }}</span>
                                            <span
                                                class="d-inline d-md-none">{{ $absen->status_waktu === 'tepat waktu' ? 'Tepat' : 'Terlambat' }}</span>
                                        </span>
                                        <span
                                            class="modern-badge {{ $absen->status_lokasi === 'dalam radius' ? 'badge-success' : 'badge-danger' }}">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            <span
                                                class="d-none d-md-inline">{{ ucfirst($absen->status_lokasi) }}</span>
                                            <span
                                                class="d-inline d-md-none">{{ $absen->status_lokasi === 'dalam radius' ? 'Dalam' : 'Luar' }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    @if ($absen->lokasi)
                                        <div class="d-flex flex-column">
                                            <strong>{{ $absen->lokasi->name }}</strong>
                                            <small style="opacity: 0.7;"
                                                class="d-none d-md-inline">{{ $absen->lokasi->alamat }}</small>
                                            <div class="mt-1">
                                                <span
                                                    class="modern-badge badge-secondary d-none d-md-inline-block">{{ $absen->lokasi->type }}</span>
                                                <span
                                                    class="modern-badge badge-secondary d-none d-md-inline-block">{{ $absen->lokasi->radius }} m</span>

                                            </div>
                                        </div>
                                    @else
                                        <span style="opacity: 0.5;">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="d-none d-md-block">
                                            <strong>Absen:</strong>
                                            {{ number_format($absen->latitude, 6) }},
                                            {{ number_format($absen->longitude, 6) }}
                                        </small>
                                        <small class="d-block d-md-none">
                                            {{ number_format($absen->latitude, 2) }},
                                            {{ number_format($absen->longitude, 2) }}
                                        </small>
                                        @if ($absen->lokasi)
                                            <small class="d-none d-md-block">
                                                <strong>Acuan:</strong>
                                                {{ number_format($absen->lokasi->latitude, 6) }},
                                                {{ number_format($absen->lokasi->longitude, 6) }}
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <button class="modern-btn" style="padding: 0.5rem; min-width: 40px;"
                                        data-bs-toggle="collapse" data-bs-target="#detail-{{ $absen->id }}">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="collapse collapse-row" id="detail-{{ $absen->id }}">
                                <td colspan="7">
                                    <div class="p-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="text-white mb-3"><i
                                                        class="fas fa-info-circle me-2"></i>Detail Absensi</h6>
                                                <ul class="list-unstyled text-white">
                                                    <li class="mb-2"><strong>Durasi:</strong>
                                                        {{ $absen->durasi ?? '-' }}</li>
                                                    <li><strong>Catatan:</strong> {{ $absen->notes ?? '-' }}</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                @if ($absen->lokasi)
                                                    <h6 class="text-white mb-3"><i
                                                            class="fas fa-map-marked-alt me-2"></i>Jam Kerja Lokasi
                                                    </h6>
                                                    <ul class="list-unstyled text-white">
                                                        <li class="mb-2"><strong>Jam Masuk:</strong>
                                                            {{ $absen->lokasi->jam_masuk ?? '-' }}</li>
                                                        <li><strong>Jam Pulang:</strong>
                                                            {{ $absen->lokasi->jam_sampai ?? '-' }}</li>
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4" style="opacity: 0.7;">
                                    <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
                                    Belum ada riwayat absensi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $absensi->links() }}
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animasi saat elemen muncul di viewport
        document.addEventListener('DOMContentLoaded', function() {
            const animateElements = document.querySelectorAll('.animate__animated');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const animation = entry.target.getAttribute('data-animation');
                        entry.target.classList.add(animation);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            animateElements.forEach(element => {
                observer.observe(element);
            });

            // Tangkap semua form submission
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    // Anda bisa menambahkan loading indicator di sini jika diperlukan
                });
            });
        });
    </script>
</body>

</html>
