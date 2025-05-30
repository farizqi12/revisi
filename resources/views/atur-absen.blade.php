<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Lokasi Absen</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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

        /* Map Container */
        #osmMap {
            height: 500px;
            width: 100%;
            border-radius: 10px;
            z-index: 0;
        }

        .location-marker {
            background-color: var(--primary-light);
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            cursor: move;
        }

        .radius-circle {
            stroke: var(--primary-light);
            stroke-width: 2;
            fill: rgba(102, 126, 234, 0.2);
            pointer-events: none;
        }

        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.1);
        }

        .badge-active {
            background-color: #4CAF50;
            color: white;
        }

        .badge-inactive {
            background-color: #e74c3c;
            color: white;
        }

        .badge-sekolah {
            background-color: #3b82f6;
            color: white;
        }

        .badge-dinas-luar {
            background-color: #f59e0b;
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
    <!-- Tambahkan setelah CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
                        <a class="nav-link" href="/kelola-transaksi">
                            <i class="fas fa-piggy-bank me-1"></i> Kelola Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-calendar-check me-1"></i> Pantau Absen
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
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
        <!-- Toast notifications -->
        <div class="toast-container">
            @if (session('success'))
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-success text-white">
                        <strong class="me-auto">Sukses</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-danger text-white">
                        <strong class="me-auto">Error</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
        </div>

        <!-- Card Daftar Lokasi -->
        <div class="card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="card-title">
                    <i class="fa-solid fa-location-crosshairs me-2"></i>Daftar Lokasi Absen
                </h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLocationModal">
                    <i class="fas fa-plus me-1"></i> Tambah Lokasi
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Lokasi</th>
                            <th>Tipe</th>
                            <th>Alamat</th>
                            <th>Koordinat</th>
                            <th>Radius (m)</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lokasis as $index => $lokasi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $lokasi->name }}</td>
                                <td>
                                    <span
                                        class="badge {{ $lokasi->type === 'sekolah' ? 'badge-sekolah' : 'badge-dinas-luar' }}">
                                        {{ $lokasi->type === 'sekolah' ? 'Sekolah' : 'Dinas Luar' }}
                                    </span>
                                </td>
                                <td>{{ $lokasi->alamat ?? '-' }}</td>
                                <td>{{ number_format($lokasi->latitude, 6) }},
                                    {{ number_format($lokasi->longitude, 6) }}</td>
                                <td>{{ $lokasi->radius }}</td>
                                <td>
                                    <span
                                        class="badge {{ $lokasi->status === 'enable' ? 'badge-active' : 'badge-inactive' }}">
                                        {{ $lokasi->status === 'enable' ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-location" data-id="{{ $lokasi->id }}"
                                        data-name="{{ $lokasi->name }}" data-type="{{ $lokasi->type }}"
                                        data-latitude="{{ $lokasi->latitude }}"
                                        data-longitude="{{ $lokasi->longitude }}" data-radius="{{ $lokasi->radius }}"
                                        data-alamat="{{ $lokasi->alamat }}" data-status="{{ $lokasi->status }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-location"
                                        data-id="{{ $lokasi->id }}" data-name="{{ $lokasi->name }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Lokasi -->
    <div class="modal fade" id="addLocationModal" tabindex="-1" aria-labelledby="addLocationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLocationModalLabel">Tambah Lokasi Absen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('lokasi.store') }}" method="POST" id="addLocationForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lokasi</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Tipe Lokasi</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="sekolah">Sekolah</option>
                                <option value="dinas-luar">Dinas Luar</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pilih Lokasi</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="locationSearchInput"
                                    placeholder="Cari lokasi...">
                                <button class="btn btn-outline-secondary" type="button" id="pickLocationBtn">
                                    <i class="fas fa-map-marker-alt"></i> Pilih dari Peta
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" required
                                    readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" required
                                    readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="radius" class="form-label">Radius (meter)</label>
                            <input type="number" class="form-control" id="radius" name="radius" value="100"
                                min="10" max="1000" required>
                            <small class="text-muted">Minimal 10 meter, maksimal 1000 meter</small>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="enable">Aktif</option>
                                <option value="disable">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Lokasi -->
    <div class="modal fade" id="editLocationModal" tabindex="-1" aria-labelledby="editLocationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLocationModalLabel">Edit Lokasi Absen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="editLocationForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nama Lokasi</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editType" class="form-label">Tipe Lokasi</label>
                            <select class="form-select" id="editType" name="type" required>
                                <option value="sekolah">Sekolah</option>
                                <option value="dinas-luar">Dinas Luar</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editAlamat" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" id="editAlamat" name="alamat" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pilih Lokasi</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="editLocationSearchInput"
                                    placeholder="Cari lokasi...">
                                <button class="btn btn-outline-secondary" type="button" id="editPickLocationBtn">
                                    <i class="fas fa-map-marker-alt"></i> Pilih dari Peta
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editLatitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="editLatitude" name="latitude"
                                    required readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editLongitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="editLongitude" name="longitude"
                                    required readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editRadius" class="form-label">Radius (meter)</label>
                            <input type="number" class="form-control" id="editRadius" name="radius"
                                min="10" max="1000" required>
                            <small class="text-muted">Minimal 10 meter, maksimal 1000 meter</small>
                        </div>
                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Status</label>
                            <select class="form-select" id="editStatus" name="status" required>
                                <option value="enable">Aktif</option>
                                <option value="disable">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Lokasi -->
    <div class="modal fade" id="deleteLocationModal" tabindex="-1" aria-labelledby="deleteLocationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteLocationModalLabel">Hapus Lokasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="deleteLocationForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Anda yakin ingin menghapus lokasi <strong id="deleteLocationName"></strong>?</p>
                        <p class="text-danger">Penghapusan lokasi akan mempengaruhi data absensi yang terkait.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Peta OpenStreetMap -->
    <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mapModalLabel">Pilih Lokasi di Peta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="osmMap"></div>
                    <div class="mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="autoFillAddress" checked>
                            <label class="form-check-label" for="autoFillAddress">
                                Isi alamat otomatis berdasarkan lokasi yang dipilih
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmLocationBtn">Konfirmasi Lokasi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Leaflet Geocoder -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize toasts
            const toastElList = [].slice.call(document.querySelectorAll('.toast'))
            const toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl, {
                    autohide: true,
                    delay: 5000
                })
            });
            toastList.forEach(toast => toast.show());

            // Edit Location Button Handler
            const editButtons = document.querySelectorAll('.edit-location');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const type = this.getAttribute('data-type');
                    const latitude = this.getAttribute('data-latitude');
                    const longitude = this.getAttribute('data-longitude');
                    const radius = this.getAttribute('data-radius');
                    const alamat = this.getAttribute('data-alamat');
                    const status = this.getAttribute('data-status');

                    document.getElementById('editName').value = name;
                    document.getElementById('editType').value = type;
                    document.getElementById('editAlamat').value = alamat || '';
                    document.getElementById('editLatitude').value = latitude;
                    document.getElementById('editLongitude').value = longitude;
                    document.getElementById('editRadius').value = radius;
                    document.getElementById('editStatus').value = status;
                    document.getElementById('editLocationSearchInput').value = alamat || '';

                    // Set form action URL
                    document.getElementById('editLocationForm').action = `/atur-absen/${id}`;

                    const editModal = new bootstrap.Modal(document.getElementById(
                        'editLocationModal'));
                    editModal.show();
                });
            });

            // Delete Location Button Handler
            const deleteButtons = document.querySelectorAll('.delete-location');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');

                    document.getElementById('deleteLocationName').textContent = name;
                    document.getElementById('deleteLocationForm').action = `/atur-absen/${id}`;

                    const deleteModal = new bootstrap.Modal(document.getElementById(
                        'deleteLocationModal'));
                    deleteModal.show();
                });
            });

            // Map functionality
            let map, marker, circle, currentForm = null;
            let geocoder = L.Control.Geocoder.nominatim();

            // Initialize OpenStreetMap
            function initOSMMap() {
                if (map) return;

                // Default to Surabaya coordinates
                const defaultLat = -7.2575;
                const defaultLng = 112.7521;
                const defaultZoom = 13;

                map = L.map('osmMap').setView([defaultLat, defaultLng], defaultZoom);

                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Add geocoder control
                L.Control.geocoder({
                    defaultMarkGeocode: false,
                    position: 'topright',
                    placeholder: 'Cari lokasi...',
                    errorMessage: 'Lokasi tidak ditemukan',
                    geocoder: geocoder
                }).on('markgeocode', function(e) {
                    const center = e.geocode.center;
                    map.setView(center, 16);
                    updateMarkerPosition(center);
                    if (document.getElementById('autoFillAddress').checked) {
                        updateAddressField(e.geocode.name);
                    }
                }).addTo(map);

                // Create marker with custom icon
                const markerIcon = L.divIcon({
                    className: 'location-marker',
                    iconSize: [26, 26]
                });

                marker = L.marker(map.getCenter(), {
                    draggable: true,
                    icon: markerIcon
                }).addTo(map);

                // Create circle
                circle = L.circle(map.getCenter(), {
                    radius: 100,
                    className: 'radius-circle'
                }).addTo(map);

                // Event listeners
                marker.on('dragend', function() {
                    updateCirclePosition();
                    if (document.getElementById('autoFillAddress').checked) {
                        reverseGeocode(marker.getLatLng());
                    }
                });

                map.on('click', function(e) {
                    marker.setLatLng(e.latlng);
                    updateCirclePosition();
                    if (document.getElementById('autoFillAddress').checked) {
                        reverseGeocode(e.latlng);
                    }
                });

                // Update radius when input changes
                document.getElementById('radius')?.addEventListener('input', updateCirclePosition);
                document.getElementById('editRadius')?.addEventListener('input', updateCirclePosition);
            }

            function updateMarkerPosition(latlng) {
                marker.setLatLng(latlng);
                updateCirclePosition();
            }

            function updateCirclePosition() {
                const radius = currentForm === 'edit' ?
                    parseInt(document.getElementById('editRadius').value) || 100 :
                    parseInt(document.getElementById('radius').value) || 100;

                circle.setLatLng(marker.getLatLng());
                circle.setRadius(radius);
            }

            function updateAddressField(address) {
                const addressInput = currentForm === 'edit' ?
                    document.getElementById('editAlamat') :
                    document.getElementById('alamat');
                addressInput.value = address;
            }

            function reverseGeocode(latlng) {
                geocoder.reverse(latlng, map.options.crs.scale(map.getZoom()), results => {
                    if (results && results.length > 0) {
                        updateAddressField(results[0].name);
                    }
                });
            }

            // Show map modal when pick location button is clicked
            document.getElementById('pickLocationBtn')?.addEventListener('click', showMapModal);
            document.getElementById('editPickLocationBtn')?.addEventListener('click', showMapModal);

            function showMapModal() {
                currentForm = this.id === 'pickLocationBtn' ? 'add' : 'edit';
                const mapModal = new bootstrap.Modal(document.getElementById('mapModal'));
                mapModal.show();

                // Initialize map when modal is shown
                mapModal._element.addEventListener('shown.bs.modal', function() {
                    initOSMMap();
                    map.invalidateSize();

                    // Set initial position based on form values
                    const latInput = document.getElementById(currentForm === 'edit' ? 'editLatitude' :
                        'latitude');
                    const lngInput = document.getElementById(currentForm === 'edit' ? 'editLongitude' :
                        'longitude');
                    const radiusInput = document.getElementById(currentForm === 'edit' ? 'editRadius' :
                        'radius');

                    const lat = latInput.value ? parseFloat(latInput.value) : -7.2575;
                    const lng = lngInput.value ? parseFloat(lngInput.value) : 112.7521;
                    const radius = radiusInput.value ? parseInt(radiusInput.value) : 100;

                    const initialPos = L.latLng(lat, lng);
                    map.setView(initialPos, 16);
                    marker.setLatLng(initialPos);
                    circle.setLatLng(initialPos);
                    circle.setRadius(radius);
                });
            }

            // Confirm location selection
            document.getElementById('confirmLocationBtn')?.addEventListener('click', function() {
                const latLng = marker.getLatLng();
                const lat = latLng.lat.toFixed(8);
                const lng = latLng.lng.toFixed(8);

                if (currentForm === 'edit') {
                    document.getElementById('editLatitude').value = lat;
                    document.getElementById('editLongitude').value = lng;
                } else {
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                }

                bootstrap.Modal.getInstance(document.getElementById('mapModal')).hide();
            });

            // Search location from input field
            document.getElementById('locationSearchInput')?.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchLocation(this.value, 'add');
                }
            });

            document.getElementById('editLocationSearchInput')?.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchLocation(this.value, 'edit');
                }
            });

            function searchLocation(query, formType) {
                if (!query) return;

                geocoder.geocode(query, results => {
                    if (results && results.length > 0) {
                        const firstResult = results[0];
                        const latLng = firstResult.center;

                        if (formType === 'edit') {
                            document.getElementById('editLatitude').value = latLng.lat.toFixed(8);
                            document.getElementById('editLongitude').value = latLng.lng.toFixed(8);
                            document.getElementById('editAlamat').value = firstResult.name;
                        } else {
                            document.getElementById('latitude').value = latLng.lat.toFixed(8);
                            document.getElementById('longitude').value = latLng.lng.toFixed(8);
                            document.getElementById('alamat').value = firstResult.name;
                        }

                        // If map is open, update marker position
                        if (map) {
                            map.setView(latLng, 16);
                            marker.setLatLng(latLng);
                            updateCirclePosition();
                        }
                    }
                });
            }

            // Form validation
            document.getElementById('addLocationForm')?.addEventListener('submit', function(e) {
                const lat = parseFloat(document.getElementById('latitude').value);
                const lng = parseFloat(document.getElementById('longitude').value);

                if (isNaN(lat) || isNaN(lng)) {
                    e.preventDefault();
                    alert('Silakan pilih lokasi di peta terlebih dahulu');
                }
            });

            document.getElementById('editLocationForm')?.addEventListener('submit', function(e) {
                const lat = parseFloat(document.getElementById('editLatitude').value);
                const lng = parseFloat(document.getElementById('editLongitude').value);

                if (isNaN(lat) || isNaN(lng)) {
                    e.preventDefault();
                    alert('Silakan pilih lokasi di peta terlebih dahulu');
                }
            });
        });
    </script>
</body>

</html>
