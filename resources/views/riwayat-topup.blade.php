<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Topup</title>
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

        .saldo-info {
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 1.1rem;
            border-left: 4px solid var(--primary-light);
        }

        .badge-setoran {
            background-color: #28a745;
            color: white;
        }

        .badge-penarikan {
            background-color: #dc3545;
            color: white;
        }

        .badge-menunggu {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-diterima {
            background-color: #28a745;
            color: white;
        }

        .badge-ditolak {
            background-color: #dc3545;
            color: white;
        }

        .transaction-amount {
            font-weight: 600;
        }

        .transaction-amount.setoran {
            color: #28a745;
        }

        .transaction-amount.penarikan {
            color: #dc3545;
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
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white !important;
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.2);
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

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
            border: none;
            transition: all 0.5s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .card-title {
            color: var(--primary-dark);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-danger {
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        .btn-success {
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }

        .btn-logout {
            background: #e74c3c;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
        }

        .btn-logout:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead th {
            background: var(--primary-light);
            color: white;
            border: none;
        }

        .table tbody tr {
            transition: all 0.3s;
        }

        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.1);
        }

        .badge-kepala-sekolah {
            background-color: #764ba2;
            color: white;
        }

        .badge-guru {
            background-color: #667eea;
            color: white;
        }

        .badge-murid {
            background-color: #4CAF50;
            color: white;
        }

        .search-box {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .search-box input {
            padding-left: 40px;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: none;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #667eea;
        }

        /* Modal styles */
        .modal-header {
            background: var(--primary-gradient);
            color: white;
            border-radius: 15px 15px 0 0;
        }

        .modal-title {
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-collapse {
                padding: 1rem;
                background: var(--primary-gradient);
                border-radius: 0 0 15px 15px;
            }

            .nav-item {
                margin-bottom: 0.5rem;
            }

            .main-container {
                padding: 1rem;
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
                        <a class="nav-link" href="#">
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

        <div class="main-container animate__animated animate__fadeIn">
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

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4"><i class="fas fa-history me-2"></i>Riwayat Transaksi</h4>

                    @if (!$tabungan)
                        <div class="alert alert-warning">
                            Anda belum memiliki rekening tabungan.
                        </div>
                    @else
                        <div class="saldo-info">
                            <i class="fas fa-wallet me-2"></i>
                            <strong>Saldo Saat Ini:</strong>
                            <span class="ms-2">Rp {{ number_format($tabungan->saldo, 0, ',', '.') }}</span>
                        </div>

                        @if ($transactions->isEmpty())
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> Anda belum memiliki riwayat transaksi.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Jenis</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $index => $transaksi)
                                            <tr>
                                                <td>{{ $transactions->firstItem() + $index }}</td>
                                                <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $transaksi->jenis }}">
                                                        {{ ucfirst($transaksi->jenis) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="transaction-amount {{ $transaksi->jenis }}">
                                                        Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $transaksi->status }}">
                                                        @if ($transaksi->status == 'menunggu')
                                                            Menunggu
                                                        @elseif($transaksi->status == 'diterima')
                                                            Diterima
                                                        @else
                                                            Ditolak
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>{{ $transaksi->keterangan ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                {{ $transactions->links() }}
                            </div>
                        @endif
                    @endif
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
            });
        </script>
</body>

</html>
