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
                                <td>{{ $lokasi->alamat ?? '-' }}</td>
                                <td>{{ $lokasi->latitude }}, {{ $lokasi->longitude }}</td>
                                <td>{{ $lokasi->radius }}</td>
                                <td>
                                    <span class="badge {{ $lokasi->is_active ? 'badge-active' : 'badge-inactive' }}">
                                        {{ $lokasi->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-location" data-id="{{ $lokasi->id }}"
                                        data-name="{{ $lokasi->name }}" data-latitude="{{ $lokasi->latitude }}"
                                        data-longitude="{{ $lokasi->longitude }}" data-radius="{{ $lokasi->radius }}"
                                        data-alamat="{{ $lokasi->alamat }}" data-is_active="{{ $lokasi->is_active }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-location" data-id="{{ $lokasi->id }}"
                                        data-name="{{ $lokasi->name }}">
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

    <!-- Add Location Modal -->
    <div class="modal fade" id="addLocationModal" tabindex="-1" aria-labelledby="addLocationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLocationModalLabel">Tambah Lokasi Absen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('lokasi.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lokasi</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <div class="input-group">
                                    <input type="number" step="0.00000001" class="form-control" id="latitude"
                                        name="latitude" required readonly>
                                    <button class="btn btn-outline-secondary" type="button" id="pickLocation">
                                        <i class="fas fa-map-marker-alt"></i> Pilih dari Peta
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="number" step="0.00000001" class="form-control" id="longitude"
                                    name="longitude" required readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="radius" class="form-label">Radius (meter)</label>
                            <input type="number" class="form-control" id="radius" name="radius" value="100"
                                min="1" max="1000" required>
                            <small class="text-muted">Maksimum 1000 meter</small>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" checked>
                            <label class="form-check-label" for="is_active">Aktif</label>
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

    <!-- Edit Location Modal -->
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
                            <label for="editAlamat" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" id="editAlamat" name="alamat" rows="2"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editLatitude" class="form-label">Latitude</label>
                                <div class="input-group">
                                    <input type="number" step="0.00000001" class="form-control" id="editLatitude"
                                        name="latitude" required readonly>
                                    <button class="btn btn-outline-secondary" type="button" id="editPickLocation">
                                        <i class="fas fa-map-marker-alt"></i> Pilih dari Peta
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editLongitude" class="form-label">Longitude</label>
                                <input type="number" step="0.00000001" class="form-control" id="editLongitude"
                                    name="longitude" required readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editRadius" class="form-label">Radius (meter)</label>
                            <input type="number" class="form-control" id="editRadius" name="radius"
                                min="1" max="1000" required>
                            <small class="text-muted">Maksimum 1000 meter</small>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="editIsActive" name="is_active">
                            <label class="form-check-label" for="editIsActive">Aktif</label>
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

    <!-- Delete Location Modal -->
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

    <!-- Map Modal -->
    <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mapModalLabel">Pilih Lokasi di Peta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 position-relative">
                        <input type="text" id="locationSearch" class="form-control" placeholder="Cari lokasi...">
                        <div class="loading-indicator" id="searchLoading">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div id="osmMap" style="height: 500px; width: 100%;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmLocation">Konfirmasi Lokasi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Edit Location Button Handler
            const editButtons = document.querySelectorAll('.edit-location');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const latitude = this.getAttribute('data-latitude');
                    const longitude = this.getAttribute('data-longitude');
                    const radius = this.getAttribute('data-radius');
                    const alamat = this.getAttribute('data-alamat');
                    const is_active = this.getAttribute('data-is_active') === '1';

                    document.getElementById('editName').value = name;
                    document.getElementById('editAlamat').value = alamat || '';
                    document.getElementById('editLatitude').value = latitude;
                    document.getElementById('editLongitude').value = longitude;
                    document.getElementById('editRadius').value = radius;
                    document.getElementById('editIsActive').checked = is_active;

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

            // Handler untuk tombol pilih lokasi di modal tambah
            document.getElementById('pickLocation').addEventListener('click', function() {
                const mapModal = new bootstrap.Modal(document.getElementById('mapModal'));
                mapModal.show();
                currentModal = 'add';

                // Inisialisasi peta saat modal terbuka
                setTimeout(() => {
                    if (!map) {
                        initOSMMap();
                    } else {
                        map.invalidateSize();

                        // Jika sudah ada nilai, set posisi awal
                        const lat = parseFloat(document.getElementById('latitude').value) || -
                        2.5489;
                        const lng = parseFloat(document.getElementById('longitude').value) ||
                            118.0149;
                        const initialPos = L.latLng(lat, lng);
                        map.setView(initialPos, 16);
                        marker.setLatLng(initialPos);
                    }
                }, 500);
            });

            // Handler untuk tombol pilih lokasi di modal edit
            document.getElementById('editPickLocation').addEventListener('click', function() {
                const mapModal = new bootstrap.Modal(document.getElementById('mapModal'));
                mapModal.show();
                currentModal = 'edit';

                // Inisialisasi peta dengan nilai dari form edit
                setTimeout(() => {
                    if (!map) {
                        initOSMMap();
                    } else {
                        map.invalidateSize();
                        const lat = parseFloat(document.getElementById('editLatitude').value) || -
                            2.5489;
                        const lng = parseFloat(document.getElementById('editLongitude').value) ||
                            118.0149;
                        const initialPos = L.latLng(lat, lng);
                        map.setView(initialPos, 16);
                        marker.setLatLng(initialPos);
                    }
                }, 500);
            });
        });

        // Variabel global untuk peta dan modal
        let map;
        let marker;
        let currentModal = 'add'; // 'add' atau 'edit'
        let lastSearchTime = 0;

        function initOSMMap() {
            // Inisialisasi peta dengan view Indonesia
            map = L.map('osmMap').setView([-2.5489, 118.0149], 5);

            // Tambahkan tile layer OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Tambahkan marker
            marker = L.marker(map.getCenter(), {
                draggable: true
            }).addTo(map);

            // Event ketika marker dipindahkan
            marker.on('dragend', function() {
                updateFormFields(marker.getLatLng());
            });

            // Event ketika peta diklik
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateFormFields(e.latlng);
            });

            // Geocoding dengan Nominatim
            document.getElementById('locationSearch').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const query = this.value.trim();

                    // Rate limiting - minimal 1 detik antara pencarian
                    const now = Date.now();
                    if (now - lastSearchTime < 1000) {
                        return;
                    }
                    lastSearchTime = now;

                    if (query.length > 3) {
                        showLoading(true);
                        fetch(
                                `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`
                            )
                            .then(response => response.json())
                            .then(data => {
                                showLoading(false);
                                if (data && data.length > 0) {
                                    const lat = parseFloat(data[0].lat);
                                    const lon = parseFloat(data[0].lon);
                                    const newLatLng = L.latLng(lat, lon);
                                    marker.setLatLng(newLatLng);
                                    map.setView(newLatLng, 16);
                                    updateFormFields(newLatLng);
                                }
                            })
                            .catch(error => {
                                showLoading(false);
                                console.error('Error searching location:', error);
                            });
                    }
                }
            });

            // Handler untuk tombol konfirmasi lokasi
            document.getElementById('confirmLocation').addEventListener('click', function() {
                bootstrap.Modal.getInstance(document.getElementById('mapModal')).hide();
            });
        }

        function updateFormFields(latlng) {
            const prefix = currentModal === 'edit' ? 'edit' : '';
            document.getElementById(`${prefix}Latitude`).value = latlng.lat.toFixed(8);
            document.getElementById(`${prefix}Longitude`).value = latlng.lng.toFixed(8);

            // Reverse geocoding untuk mendapatkan alamat
            showLoading(true);
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latlng.lat}&lon=${latlng.lng}`)
                .then(response => response.json())
                .then(data => {
                    showLoading(false);
                    if (data.display_name) {
                        document.getElementById(`${prefix}Alamat`).value = data.display_name;
                    }
                })
                .catch(error => {
                    showLoading(false);
                    console.error('Error reverse geocoding:', error);
                });
        }

        function showLoading(show) {
            const loadingElement = document.getElementById('searchLoading');
            loadingElement.style.display = show ? 'block' : 'none';
        }
    </script>
</body>

</html>
