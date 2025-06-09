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
        }

        /* Navbar */
        .navbar {
            background: var(--primary-gradient);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 2rem;
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

        .balance-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }


        .balance-info {
            flex: 1;
        }

        .balance-actions {
            display: flex;
            gap: 10px;
            margin-left: 15px;
        }

        .balance-action-btn {
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .balance-action-btn i {
            font-size: 0.9rem;
        }

        .topup-btn {
            background-color: rgba(102, 126, 234, 0.1);
            color: var(--primary-dark);
        }

        .topup-btn:hover {
            background-color: rgba(102, 126, 234, 0.2);
            transform: translateY(-2px);
        }

        .withdraw-btn {
            background-color: rgba(234, 102, 102, 0.1);
            color: #e74c3c;
        }

        .withdraw-btn:hover {
            background-color: rgba(234, 102, 102, 0.2);
            transform: translateY(-2px);
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
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
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
    <!-- Navbar-guru -->
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
    <!-- Main Content -->
    <div class="main-container animate__animated animate__fadeIn">
        <div class="welcome-card card-hover">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="welcome-title mb-3">
                        <i class="fas fa-hand-paper"></i>Selamat Datang, <span
                            class="text-gradient">{{ $username }}</span>
                    </h2>
                    <p class="text-muted mb-4">Anda telah berhasil login ke sistem kami</p>
                </div>
                <a href="" class="text-decoration-none">
                    <div class="user-avatar overflow-hidden">
                        @if (!empty($userPhotoUrl))
                            <img src="{{ $userPhotoUrl }}" alt="Foto Profil" class="w-100 h-100"
                                style="object-fit: cover;">
                        @else
                            <i class="fas fa-user-circle fa-3x text-primary"></i>
                        @endif
                    </div>
                </a>
            </div>
            <div class="balance-card">
                <div class="balance-content">
                    <div class="balance-info">
                        <p class="mb-1 text-muted">Total Saldo</p>
                        <h3 class="mb-0 text-dark">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                        <div class="balance-footer mt-2">
                            <span class="badge bg-light text-success">
                                <i class="fas fa-arrow-up me-1"></i> Aktif
                            </span>
                            <small class="text-muted ms-2">Update terakhir: sekarang</small>
                        </div>
                    </div>
                    <div class="balance-actions">
                        <a href="/topup" class="balance-action-btn topup-btn text-decoration-none">
                            <i class="fas fa-coins"></i>
                            <span>Top Up</span>
                        </a>
                        <a href="/topup-penarikan" class="balance-action-btn withdraw-btn text-decoration-none">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Penarikan</span>
                        </a>
                    </div>
                    <div class="balance-icon">
                        <a href="/riwayat-topup" class="text-decoration-none">
                            <i class="fas fa-wallet fa-2x text-success"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="action-grid mt-4">
                <a href="/absensi" class="action-btn btn-outline-success text-decoration-none">
                    <i class="fas fa-fingerprint text-success"></i>
                    <span>Absen Masuk</span>
                </a>
                <a href="/absensipulang" class="action-btn btn-outline-danger text-decoration-none">
                    <i class="fas fa-sign-out-alt text-danger"></i>
                    <span>Absen Pulang</span>
                </a>
                <a href="/izin" class="action-btn btn-outline-secondary text-decoration-none">
                    <i class="fas fa-procedures text-secondary"></i>
                    <span>Izin</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Panggil Komponen Loading Modal -->
    <x-loading-modal />

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

            // Tambahkan animasi hover untuk tombol aksi
            const actionButtons = document.querySelectorAll('.action-btn');
            actionButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    const icon = this.querySelector('i');
                    icon.style.transform = 'scale(1.2)';
                });
                button.addEventListener('mouseleave', function() {
                    const icon = this.querySelector('i');
                    icon.style.transform = 'scale(1)';
                });
            });

            // Tangkap semua klik link
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
