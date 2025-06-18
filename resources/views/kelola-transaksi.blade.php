<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Transaksi</title>
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

        /* Invoice POS Styles */
        .invoice-pos {
            width: 80mm;
            /* Lebar standar struk POS */
            font-family: 'Courier New', monospace;
            padding: 10px;
            margin: 0 auto;
            background: white;
        }

        .invoice-pos .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }

        .invoice-pos .title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .invoice-pos .subtitle {
            font-size: 12px;
            margin-bottom: 10px;
        }

        .invoice-pos .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .invoice-pos .transaction-info {
            margin-bottom: 10px;
        }

        .invoice-pos .transaction-info div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }

        .invoice-pos .transaction-info .label {
            font-weight: bold;
        }

        .invoice-pos .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 10px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #printArea,
            #printArea * {
                visibility: visible;
            }

            #printArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }
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

        .btn-warning {
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(241, 196, 15, 0.3);
        }

        @media print {
            body * {
                display: none !important;
            }

            body #printArea,
            body #printArea * {
                display: block !important;
                visibility: visible !important;
            }

            #printArea {
                position: fixed;
                left: 0;
                top: 0;
                margin: 0;
                padding: 10px;
                width: 80mm;
                height: auto;
                background: white;
                z-index: 9999;
            }

            .no-print {
                display: none !important;
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

        .badge-menunggu {
            background-color: #f39c12;
            color: white;
        }

        .badge-diterima {
            background-color: #2ecc71;
            color: white;
        }

        .badge-ditolak {
            background-color: #e74c3c;
            color: white;
        }

        .badge-dibatalkan {
            background-color: #95a5a6;
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

        .transaction-type {
            font-weight: 600;
        }

        .transaction-type.setoran {
            color: #28a745;
        }

        .transaction-type.penarikan {
            color: #dc3545;
        }

        .transaction-type.transfer {
            color: #17a2b8;
        }

        .transaction-type.pembayaran {
            color: #6f42c1;
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
    <!-- Navbar -->
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
                        <a class="nav-link active" href="/kelola-transaksi">
                            <i class="fas fa-piggy-bank me-1"></i> Kelola Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pantau-absen">
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

        <div class="card">
            <div class="card-body">
                <!-- Search Box -->
                <div class="search-box mb-4">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari transaksi...">
                </div>

                <!-- Filter Form -->
                <form action="{{ route('admin.transaksi.filter') }}" method="GET" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>
                                    Menunggu
                                </option>
                                <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>
                                    Diterima
                                </option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jenis</label>
                            <select name="jenis" class="form-select">
                                <option value="">Semua Jenis</option>
                                <option value="setoran" {{ request('jenis') == 'setoran' ? 'selected' : '' }}>Setoran
                                </option>
                                <option value="penarikan" {{ request('jenis') == 'penarikan' ? 'selected' : '' }}>
                                    Penarikan
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Pengguna</label>
                            <select name="user_id" class="form-select">
                                <option value="">Semua Pengguna</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal_awal" class="form-control"
                                value="{{ request('tanggal_awal') }}">
                            <small class="text-muted">Tanggal Awal</small>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <input type="date" name="tanggal_akhir" class="form-control"
                                value="{{ request('tanggal_akhir') }}">
                            <small class="text-muted">Tanggal Akhir</small>
                        </div>
                        <div class="col-md-3 align-self-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <a href="/kelola-transaksi" class="btn btn-secondary">
                                <i class="fas fa-sync-alt me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Transactions Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pengguna</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksis as $transaksi)
                                <tr>
                                    <td>{{ $loop->iteration + ($transaksis->currentPage() - 1) * $transaksis->perPage() }}
                                    </td>
                                    <td>{{ $transaksi->tabungan->user->name }}</td>
                                    <td>
                                        <span class="transaction-type {{ $transaksi->jenis }}">
                                            {{ ucfirst($transaksi->jenis) }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $transaksi->status }}">
                                            {{ $statuses[$transaksi->status] }}
                                        </span>
                                    </td>
                                    <td>{{ $transaksi->created_at->format('d M Y H:i') }}</td>
                                    <td>{{ Str::limit($transaksi->keterangan, 30) }}</td>
                                    <td>
                                        @if ($transaksi->status == 'menunggu')
                                            <button class="btn btn-sm btn-success verify-btn" data-bs-toggle="modal"
                                                data-bs-target="#verifyModal" data-id="{{ $transaksi->id }}">
                                                <i class="fas fa-check"></i> Terima
                                            </button>
                                            <button class="btn btn-sm btn-danger reject-btn" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal" data-id="{{ $transaksi->id }}">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        @elseif($transaksi->status == 'diterima')
                                            <button class="btn btn-sm btn-primary print-btn" data-bs-toggle="modal"
                                                data-bs-target="#printModal" data-id="{{ $transaksi->id }}">
                                                <i class="fas fa-print"></i> Cetak
                                            </button>
                                        @else
                                            <span class="text-muted">Tidak ada aksi</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $transaksis->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Print Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printModalLabel">Cetak Invoice Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="invoiceContent" class="p-3">
                        <!-- Invoice content will be loaded here via AJAX -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="printInvoice()">
                        <i class="fas fa-print"></i> Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden div for printing -->
    <div id="printArea" style="display:none;"></div>

    <!-- Verify Modal -->
    <div class="modal fade" id="verifyModal" tabindex="-1" aria-labelledby="verifyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalLabel">Verifikasi Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="verifyForm" method="POST"
                    action="{{ route('admin.transaksi.update', ['id' => '__ID__']) }}">
                    @csrf
                    <input type="hidden" name="status" value="diterima">
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menerima transaksi ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Ya, Terima</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Tolak Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="rejectForm" method="POST"
                    action="{{ route('admin.transaksi.update', ['id' => '__ID__']) }}">
                    @csrf
                    <input type="hidden" name="status" value="ditolak">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rejectReason" class="form-label">Alasan Penolakan</label>
                            <textarea class="form-control" id="rejectReason" name="keterangan" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-loading-modal></x-loading-modal>
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Print Modal
        const printModal = document.getElementById('printModal');
        if (printModal) {
            printModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');

                // Load invoice content via AJAX
                fetch(`/transaksi/${id}/invoice`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('invoiceContent').innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('invoiceContent').innerHTML =
                            '<div class="alert alert-danger">Gagal memuat data invoice</div>';
                    });
            });
        }

        // Print function
        function printInvoice() {
            const invoiceContent = document.getElementById('invoiceContent').innerHTML;
            const printWindow = window.open('', '_blank');

            printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Invoice Transaksi</title>
            <style>
                body { 
                    font-family: 'Courier New', monospace;
                    margin: 0;
                    padding: 10px;
                    width: 80mm;
                }
                .invoice-pos {
                    width: 100%;
                    padding: 5px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 5px;
                    border-bottom: 1px dashed #000;
                    padding-bottom: 5px;
                }
                .divider {
                    border-top: 1px dashed #000;
                    margin: 5px 0;
                }
                .transaction-info div {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 2px;
                }
                .label {
                    font-weight: bold;
                }
                @page {
                    size: 80mm auto;
                    margin: 0;
                }
            </style>
        </head>
        <body onload="window.print();window.close()">
            ${invoiceContent}
        </body>
        </html>
    `);
            printWindow.document.close();

            // Close modal after printing
            const modal = bootstrap.Modal.getInstance(document.getElementById('printModal'));
            modal.hide();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchValue = this.value.toLowerCase();
                    const rows = document.querySelectorAll('tbody tr');

                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchValue) ? '' : 'none';
                    });
                });
            }

            // Verify Modal
            const verifyModal = document.getElementById('verifyModal');
            if (verifyModal) {
                verifyModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const form = document.getElementById('verifyForm');
                    form.action = form.action.replace('__ID__', id);
                });
            }

            // Reject Modal
            const rejectModal = document.getElementById('rejectModal');
            if (rejectModal) {
                rejectModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const form = document.getElementById('rejectForm');
                    form.action = form.action.replace('__ID__', id);
                });
            }
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
