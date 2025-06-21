<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding-top: 80px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Elements */
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
            color: white !important;
            font-size: 1.4rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            padding: 0.7rem 1.2rem;
            margin: 0 0.3rem;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
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
        }

        .navbar-toggler {
            border: none;
            padding: 0.5rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        /* Main Container */
        .main-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
        }

        /* Glass Card Effect */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
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
        }

        /* Saldo Info */
        .saldo-info {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1));
            backdrop-filter: blur(10px);
            padding: 1.5rem 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            font-size: 1.2rem;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .saldo-info::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) rotate(45deg);
            }
        }

        .saldo-amount {
            font-weight: 700;
            font-size: 1.4rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Modern Table */
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

        /* Modern Badges */
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
        }

        .badge-setoran {
            background: var(--success-gradient);
            color: white;
        }

        .badge-penarikan {
            background: var(--secondary-gradient);
            color: white;
        }

        .badge-menunggu {
            background: var(--warning-gradient);
            color: white;
        }

        .badge-diterima {
            background: var(--success-gradient);
            color: white;
        }

        .badge-ditolak {
            background: var(--secondary-gradient);
            color: white;
        }

        /* Transaction Amount */
        .transaction-amount {
            font-weight: 700;
            font-size: 1.1rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            display: inline-block;
        }

        .transaction-amount.setoran {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        }

        .transaction-amount.penarikan {
            background: linear-gradient(135deg, #f44336, #d32f2f);
            color: white;
            box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
        }

        /* Modern Buttons */
        .modern-btn {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
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

        /* Loading Animation */
        .loading-dots {
            display: inline-block;
        }

        .loading-dots::after {
            content: '';
            animation: dots 1.5s steps(5, end) infinite;
        }

        @keyframes dots {

            0%,
            20% {
                content: '.';
            }

            40% {
                content: '..';
            }

            60% {
                content: '...';
            }

            90%,
            100% {
                content: '';
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }

            .glass-card {
                padding: 1.5rem;
            }

            .card-title {
                font-size: 1.5rem;
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }

            .saldo-info {
                text-align: center;
                font-size: 1rem;
            }

            .saldo-amount {
                font-size: 1.2rem;
            }

            .table-container {
                padding: 0.5rem;
            }

            .modern-table {
                font-size: 0.8rem;
            }

            .modern-table thead th,
            .modern-table tbody td {
                padding: 0.8rem 0.5rem;
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
                padding: 0.3rem 0.8rem;
            }

            .transaction-amount {
                font-size: 0.9rem;
                padding: 0.3rem 0.8rem;
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
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars" style="color: white;"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/profil">
                            <i class="fas fa-user me-2"></i>Profil Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/riwayat-topup">
                            <i class="fas fa-history me-2"></i>Riwayat Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/riwayat-absensi">
                            <i class="fas fa-clipboard-list me-2"></i>Riwayat Absensi
                        </a>
                    </li>
                </ul>
                <div class="d-flex">
                    <form method="POST" action="/logout" id="logoutForm">
                        @csrf
                        <button type="submit" class="btn btn-logout">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
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
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif

        <!-- Error Alert -->
        @if (session('error'))
            <div class="modern-alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif

        <!-- Main Card -->
        <div class="glass-card animate__animated animate__fadeInUp">
            <h4 class="card-title">
                <i class="fas fa-history"></i>
                Riwayat Transaksi
            </h4>

            @if (!$tabungan)
                <div class="modern-alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Anda belum memiliki rekening tabungan.
                </div>
            @else
                <!-- Saldo Info -->
                <div class="saldo-info animate__animated animate__fadeInLeft">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-wallet fa-2x"></i>
                            <div>
                                <div style="font-size: 0.9rem; opacity: 0.8;">Saldo Saat Ini</div>
                                <div class="saldo-amount">Rp {{ number_format($tabungan->saldo, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <small style="opacity: 0.7;">Terakhir diperbarui</small><br>
                            <small>{{ now()->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                </div>

                @if ($transactions->isEmpty())
                    <div class="modern-alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Anda belum memiliki riwayat transaksi.
                    </div>
                @else
                    <!-- Transaction Table -->
                    <div class="table-container animate__animated animate__fadeInRight">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag me-2"></i>No</th>
                                    <th><i class="fas fa-calendar me-2"></i>Tanggal</th>
                                    <th><i class="fas fa-tag me-2"></i>Jenis</th>
                                    <th><i class="fas fa-money-bill-wave me-2"></i>Jumlah</th>
                                    <th><i class="fas fa-info-circle me-2"></i>Status</th>
                                    <th><i class="fas fa-sticky-note me-2"></i>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $index => $transaksi)
                                    <tr class="animate__animated animate__fadeInUp"
                                        style="animation-delay: {{ $index * 0.1 }}s">
                                        <td>
                                            <span
                                                class="badge bg-secondary">{{ $transactions->firstItem() + $index }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <div style="font-weight: 600;">
                                                    {{ $transaksi->created_at->format('d/m/Y') }}</div>
                                                <small
                                                    style="opacity: 0.7;">{{ $transaksi->created_at->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="modern-badge badge-{{ $transaksi->jenis }}">
                                                <i
                                                    class="fas fa-{{ $transaksi->jenis == 'setoran' ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                                                {{ ucfirst($transaksi->jenis) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="transaction-amount {{ $transaksi->jenis }}">
                                                {{ $transaksi->jenis == 'setoran' ? '+' : '-' }}Rp
                                                {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="modern-badge badge-{{ $transaksi->status }}">
                                                <i
                                                    class="fas fa-{{ $transaksi->status == 'menunggu' ? 'clock' : ($transaksi->status == 'diterima' ? 'check' : 'times') }} me-1"></i>
                                                @if ($transaksi->status == 'menunggu')
                                                    Menunggu
                                                @elseif($transaksi->status == 'diterima')
                                                    Diterima
                                                @else
                                                    Ditolak
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <span style="opacity: {{ $transaksi->keterangan ? '1' : '0.5' }}">
                                                {{ $transaksi->keterangan ?? 'Tidak ada keterangan' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $transactions->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Loading Modal Component -->
    <x-loading-modal></x-loading-modal>


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

            // Search functionality
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('tbody tr');

            // Submit form saat mengetik (dengan delay)
            let searchTimer;
            searchInput.addEventListener('keyup', function() {
                clearTimeout(searchTimer);
                showLoading('Mencari pengguna...');
                searchTimer = setTimeout(() => {
                    searchForm.submit();
                }, 250); // Delay 500ms setelah berhenti mengetik
            });

            // Edit User Modal
            const editButtons = document.querySelectorAll('.edit-user');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const username = this.getAttribute('data-username');
                    const role = this.getAttribute('data-role');

                    document.getElementById('editId').value = id;
                    document.getElementById('editName').value = name;
                    document.getElementById('editUsername').value = username;
                    document.getElementById('editRole').value = role;

                    const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                    editModal.show();
                });
            });

            // Delete User Modal
            const deleteButtons = document.querySelectorAll('.delete-user');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');

                    document.getElementById('deleteId').value = id;
                    document.getElementById('deleteUserName').textContent = name;

                    const deleteModal = new bootstrap.Modal(document.getElementById(
                        'deleteUserModal'));
                    deleteModal.show();
                });
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
