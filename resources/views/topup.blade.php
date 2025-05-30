<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Topup</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        :root {
            --primary-gradient: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            --primary-light: #667eea;
            --primary-dark: #764ba2;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding-top: 70px;
            opacity: 0;
            animation: fadeIn 1s ease-in-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Navbar */
        .navbar {
            background: var(--primary-gradient);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 2rem;
            transform: translateY(-20px);
            opacity: 0;
            animation: slideDown 0.8s ease-out 0.3s forwards;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
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
            transform: translateY(20px);
            opacity: 0;
            animation: slideUp 0.8s ease-out 0.6s forwards;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .welcome-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
            border: none;
            transition: all 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--primary-gradient);
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .welcome-title {
            color: var(--primary-dark);
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .welcome-title i {
            margin-right: 10px;
            animation: wave 2s infinite;
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

        .text-gradient {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        .balance-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1.5rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .balance-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
            pointer-events: none;
        }

        .balance-icon {
            background: rgba(72, 187, 120, 0.1);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .user-avatar {
            background: rgba(102, 126, 234, 0.1);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .balance-footer {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            position: relative;
            padding: 4px;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .user-avatar img {
            border-radius: 50%;
            background: white;
            padding: 2px;
            transition: transform 0.3s ease;
        }

        .user-avatar:hover {
            transform: scale(1.05);
        }

        .user-avatar:hover img {
            transform: scale(0.95);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .balance-card:hover {
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
            transform: scale(1.01);
        }

        .balance-card:hover .balance-icon {
            transform: rotate(15deg);
        }

        /* Action Buttons */
        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 2rem;
        }

        .action-btn {
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            position: relative;
            overflow: hidden;
            border: none;
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .action-btn i {
            font-size: 1.5rem;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .action-btn span {
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .action-btn:hover i {
            transform: scale(1.2);
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .action-btn:hover::before {
            transform: scaleX(1);
        }

        /* Badges */
        .badge {
            padding: 6px 10px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        /* Responsive */
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

            .welcome-card .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .user-avatar {
                margin-top: 1rem;
                align-self: flex-end;
            }

            .action-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .action-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar Guru-->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/dashboard-guru">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-user"></i> Profil Saya </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/riwayat-topup">
                            <i class="fas fa-history"></i> Riwayat Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-calendar-check me-1"></i> Pantau Absen
                        </a>
                    </li>
                </ul>
                <div class="d-flex">
                    <form method="POST" action="/logout" id="logoutForm">
                        @csrf
                        <button type="submit" class="btn btn-logout">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="welcome-card card-hover animate__animated" data-animation="animate__fadeInDown">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="welcome-title">
                        <i class="fas fa-wallet"></i>
                        Permintaan Menabung
                    </h2>
                </div>
                <div class="user-avatar">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=667eea&color=fff"
                        alt="User Avatar" width="50" height="50">
                </div>
            </div>
            <div class="balance-card mt-4 d-flex align-items-center gap-3">
                <div class="balance-icon">
                    <i class="fas fa-coins text-success fs-3"></i>
                </div>
                <div>
                    <div class="text-muted">Saldo Anda</div>
                    <div class="fs-4 fw-bold text-gradient">
                        Rp{{ number_format($saldo, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-hover animate__animated" data-animation="animate__fadeInUp">
            <div class="card-body">
                <form action="{{ route('topup.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label for="amount" class="form-label fw-semibold">Jumlah Setoran</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" min="1000" step="1000" class="form-control" id="amount"
                                name="amount" placeholder="Minimal Rp1.000 (Ex: 1000)" required>
                        </div>
                        <small class="text-muted">Minimal setoran Rp1.000</small>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Keterangan (Opsional)</label>
                        <input type="text" class="form-control" id="description" name="description"
                            placeholder="Tambahkan keterangan jika perlu" maxlength="255">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-money-bill-wave me-1"></i> Ajukan Permintaan Menabung
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Panggil Komponen Loading Modal -->
    <x-loading-modal></x-loading-modal>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle all button clicks (except dropdown toggles and already handled buttons)
            document.querySelectorAll('button:not([data-bs-toggle]), input[type="submit"]').forEach(button => {
                button.addEventListener('click', function(e) {
                    // Skip if button is disabled or already handled by form submission
                    if (this.disabled || this.closest('form')) return;

                    // Skip if it's a dropdown toggle
                    if (this.getAttribute('data-bs-toggle') === 'dropdown') return;

                    showLoading('Memproses permintaan...');
                });
            });

            // Special handling for logout button
            const logoutForm = document.getElementById('logoutForm');
            if (logoutForm) {
                logoutForm.addEventListener('submit', function() {
                    showLoading('Sedang keluar...');
                });
            }

            // Handle navigation links (complementing the component's handler)
            document.querySelectorAll('a.nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Skip if already handled by component's script
                    if (this.target === '_blank' || this.href.includes('#') || e.ctrlKey || e
                        .metaKey) return;

                    // Special case for active navigation
                    if (!this.classList.contains('active')) {
                        e.preventDefault();
                        showLoading('Memuat halaman...');
                        setTimeout(() => window.location.href = this.href, 100);
                    }
                });
            });

            // Animation initialization (your existing code)
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
            document.querySelectorAll('a[href^="/"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Abaikan jika target blank atau anchor link
                    if (this.target === '_blank' || this.href.includes('#')) return;

                    // Abaikan jika Ctrl atau Cmd diklik (untuk buka tab baru)
                    if (e.ctrlKey || e.metaKey) return;

                    e.preventDefault();
                    showLoading('Memuat halaman...');

                    // Redirect setelah sedikit delay untuk memastikan modal muncul
                    setTimeout(() => {
                        window.location.href = this.href;
                    }, 100);
                });
            });

            // Tangkap semua form submission
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    showLoading('Memproses...');
                });
            });

            // Tangkap event sebelum unload (navigasi atau refresh)
            window.addEventListener('beforeunload', function() {
                showLoading('Memuat...');
            });
        });
    </script>
</body>

</html>
