<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        /* CSS Variables */
        :root {
            --primary-gradient: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            --primary-light: #667eea;
            --primary-dark: #764ba2;
            --success-gradient: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            --danger-gradient: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
            --warning-gradient: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
            --info-gradient: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #4facfe 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
            padding-top: 70px;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Navbar (tetap sama) */
        .navbar {
            background: var(--primary-gradient);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 2rem;
            backdrop-filter: blur(10px);
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

        /* Glass Card Effect */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .glass-card:hover::before {
            left: 100%;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px 0 rgba(31, 38, 135, 0.5);
        }

        /* Main Container */
        .main-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Profile Header */
        .profile-header {
            padding: 3rem;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            margin: 0 auto 1.5rem;
            position: relative;
            border-radius: 50%;
            background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #f5576c);
            padding: 4px;
            animation: avatarGlow 3s ease-in-out infinite alternate;
        }

        @keyframes avatarGlow {
            0% {
                box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
            }

            100% {
                box-shadow: 0 0 40px rgba(245, 87, 108, 0.8), 0 0 60px rgba(240, 147, 251, 0.4);
            }
        }

        .profile-avatar img,
        .profile-avatar i {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-name {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
            font-weight: 300;
        }

        /* Info Cards */
        .info-card {
            padding: 2rem;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .info-card h4 {
            color: white;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-card h4 i {
            width: 30px;
            height: 30px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding-left: 1rem;
            margin: 0 -1rem;
        }

        .info-label {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
            min-width: 150px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-value {
            color: white;
            font-weight: 500;
            flex: 1;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            position: relative;
            z-index: 2;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }

        .stat-card:nth-child(1) .stat-icon {
            background: var(--success-gradient);
        }

        .stat-card:nth-child(2) .stat-icon {
            background: var(--info-gradient);
        }

        .stat-card:nth-child(3) .stat-icon {
            background: var(--warning-gradient);
        }

        .stat-card:nth-child(4) .stat-icon {
            background: var(--danger-gradient);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .action-btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            color: white;
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 160px;
            justify-content: center;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.5s;
        }

        .action-btn:hover::before {
            left: 100%;
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            color: white;
        }

        .btn-primary-custom {
            background: var(--primary-gradient);
        }

        .btn-success-custom {
            background: var(--success-gradient);
        }

        .btn-info-custom {
            background: var(--info-gradient);
        }

        /* Responsive Design */
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

            .profile-header {
                padding: 2rem 1rem;
            }

            .profile-name {
                font-size: 2rem;
            }

            .profile-avatar {
                width: 120px;
                height: 120px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .action-btn {
                min-width: 200px;
            }

            .info-label {
                min-width: 120px;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Floating Animation */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Pulse Animation */
        .pulse {
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar (tetap sama) -->
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
                        <a class="nav-link active" href="/profil">
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
        <!-- Profile Header -->
        <div class="glass-card profile-header floating">
            <div class="profile-avatar">
                <i class="fas fa-user-circle fa-4x text-primary"></i>
            </div>
            <h1 class="profile-name">{{ $user->name }}</h1>
            <p class="profile-subtitle">Bergabung sejak {{ $user->created_at->format('F Y') }}</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="glass-card stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-number">248</div>
                <div class="stat-label">Hari Aktif</div>
            </div>
            <div class="glass-card stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">1,240</div>
                <div class="stat-label">Jam Mengajar</div>
            </div>
            <div class="glass-card stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">156</div>
                <div class="stat-label">Siswa Dibimbing</div>
            </div>
            <div class="glass-card stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-number">4.8</div>
                <div class="stat-label">Rating</div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="glass-card info-card">
                    <h4>
                        <i class="fas fa-user"></i>
                        Informasi Dasar
                    </h4>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-signature"></i>
                            Nama Lengkap
                        </div>
                        <div class="info-value">John Doe</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i>
                            Email
                        </div>
                        <div class="info-value">john.doe@example.com</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-at"></i>
                            Username
                        </div>
                        <div class="info-value">johndoe</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-phone"></i>
                            Telepon
                        </div>
                        <div class="info-value">+62 812-3456-7890</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="glass-card info-card">
                    <h4>
                        <i class="fas fa-briefcase"></i>
                        Informasi Profesional
                    </h4>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-chalkboard-teacher"></i>
                            Mata Pelajaran
                        </div>
                        <div class="info-value">Matematika</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-school"></i>
                            Sekolah
                        </div>
                        <div class="info-value">SMA Negeri 1 Jakarta</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-calendar-alt"></i>
                            Tanggal Bergabung
                        </div>
                        <div class="info-value">15 Januari 2023</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-id-badge"></i>
                            ID Pegawai
                        </div>
                        <div class="info-value">EMP-2023-001</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="glass-card info-card">
            <div class="action-buttons">
                <a href="/edit-profil" class="action-btn btn-primary-custom">
                    <i class="fas fa-edit"></i>
                    Edit Profil
                </a>
                <a href="/change-password" class="action-btn btn-success-custom">
                    <i class="fas fa-key"></i>
                    Ubah Password
                </a>
                <a href="/settings" class="action-btn btn-info-custom">
                    <i class="fas fa-cog"></i>
                    Pengaturan
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enhanced animations and interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Intersection Observer for scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationDelay = Math.random() * 0.5 + 's';
                        entry.target.classList.add('animate__fadeInUp');
                    }
                });
            }, observerOptions);

            // Observe all glass cards
            document.querySelectorAll('.glass-card').forEach(card => {
                observer.observe(card);
            });

            // Add hover effects to info items
            document.querySelectorAll('.info-item').forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(10px)';
                });
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });

            // Animated counters for stats
            function animateCounter(element, target, duration = 2000) {
                let start = 0;
                const increment = target / (duration / 16);
                const timer = setInterval(() => {
                    start += increment;
                    if (start >= target) {
                        element.textContent = target;
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(start);
                    }
                }, 16);
            }

            // Trigger counter animation when stats come into view
            const statsObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const numberElement = entry.target.querySelector('.stat-number');
                        const targetValue = parseInt(numberElement.textContent);
                        numberElement.textContent = '0';
                        animateCounter(numberElement, targetValue);
                        statsObserver.unobserve(entry.target);
                    }
                });
            });

            document.querySelectorAll('.stat-card').forEach(card => {
                statsObserver.observe(card);
            });

            // Floating animation trigger
            setInterval(() => {
                document.querySelectorAll('.floating').forEach(element => {
                    element.style.animationDuration = (Math.random() * 2 + 2) + 's';
                });
            }, 3000);

            // Loading functionality (preserved from original)
            document.querySelectorAll('a[href^="/"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.target === '_blank' || this.href.includes('#')) return;
                    if (e.ctrlKey || e.metaKey) return;

                    e.preventDefault();

                    // Add loading effect
                    document.body.style.opacity = '0.7';
                    document.body.style.pointerEvents = 'none';

                    setTimeout(() => {
                        window.location.href = this.href;
                    }, 300);
                });
            });

            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    document.body.style.opacity = '0.7';
                    document.body.style.pointerEvents = 'none';
                });
            });
        });

        // Particle effect on hover for glass cards
        document.querySelectorAll('.glass-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>

</html>
