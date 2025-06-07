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
            --primary-gradient: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            --primary-light: #667eea;
            --primary-dark: #764ba2;
            --secondary-color: #4a5568;
            --accent-color: #48bb78;
        }

        /* Loading Modal Styles - Improved */
        #loadingModal .modal-content {
            background: transparent;
            border: none;
        }

        #loadingModal .modal-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        #loadingSpinner {
            width: 4rem;
            height: 4rem;
            border-width: 0.5rem;
            border-color: rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        #loadingMessage {
            font-weight: 600;
            font-size: 1.1rem;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 12px 24px;
            border-radius: 30px;
            margin-top: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
            max-width: 80%;
        }

        /* Notification Container - New */
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

        /* Rest of your existing styles remain the same */
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

        .location-card::before {
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

        .location-title {
            color: var(--primary-dark);
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            font-size: 1.5rem;
        }

        .location-title i {
            margin-right: 12px;
            animation: wave 2s infinite;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
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

        /* Data Display Styles */
        .data-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 1.5rem;
        }

        .data-item {
            background: rgba(245, 245, 245, 0.7);
            border-radius: 10px;
            padding: 15px;
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary-light);
        }

        .data-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            background: rgba(245, 245, 245, 0.9);
        }

        .data-label {
            font-size: 0.85rem;
            color: var(--secondary-color);
            font-weight: 600;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0;
        }

        .data-value.highlight {
            color: var(--primary-dark);
        }

        .data-icon {
            font-size: 1.2rem;
            margin-right: 8px;
            color: var(--primary-light);
        }

        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
        }

        .status-badge i {
            margin-right: 5px;
            font-size: 0.7rem;
        }

        .status-active {
            background-color: rgba(72, 187, 120, 0.1);
            color: #2f855a;
        }

        .status-inactive {
            background-color: rgba(229, 62, 62, 0.1);
            color: #c53030;
        }

        .status-pending {
            background-color: rgba(237, 137, 54, 0.1);
            color: #9c4221;
        }

        /* Time Indicators */
        .time-indicator {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 8px;
            background: rgba(102, 126, 234, 0.08);
            margin-bottom: 5px;
        }

        .time-indicator i {
            margin-right: 8px;
            color: var(--primary-light);
        }

        .time-label {
            font-size: 0.85rem;
            color: var(--secondary-color);
            margin-right: 5px;
        }

        .time-value {
            font-weight: 600;
            color: #2d3748;
        }

        /* Map Container */
        .map-container {
            height: 300px;
            border-radius: 12px;
            overflow: hidden;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .map-overlay {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1000;
            background: white;
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .map-overlay i {
            color: var(--primary-light);
            margin-right: 5px;
        }

        /* Distance and Attendance Section */
        .attendance-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-top: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .distance-info {
            display: flex;
            align-items: center;
        }

        .distance-icon {
            font-size: 1.5rem;
            color: var(--primary-light);
            margin-right: 10px;
        }

        .distance-text {
            font-size: 0.9rem;
            color: var(--secondary-color);
            margin-right: 5px;
        }

        .distance-value {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--primary-dark);
        }

        .attendance-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 6px rgba(102, 126, 234, 0.2);
        }

        .attendance-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(102, 126, 234, 0.3);
        }

        .attendance-btn:disabled {
            background: #e2e8f0;
            color: #a0aec0;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .data-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
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

            .data-grid {
                grid-template-columns: 1fr 1fr;
            }

            .attendance-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .notification-container {
                top: 70px;
                right: 10px;
                width: 95%;
            }
        }

        @media (max-width: 576px) {
            .data-grid {
                grid-template-columns: 1fr;
            }

            .location-title {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <!-- Notification Container -->
    <div class="notification-container"></div>

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
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle alert-icon"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle alert-icon"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @forelse ($lokasis as $index => $lokasi)
            <div class="location-card card-hover animate__animated animate__fadeIn mb-4">
                <h2 class="location-title">
                    <i class="fas fa-map-marker-alt"></i> {{ $lokasi->name }}
                </h2>

                <!-- Data Grid -->
                <div class="data-grid">
                    <div class="data-item">
                        <div class="data-label">
                            <i class="fas fa-tag data-icon"></i> Jenis Lokasi
                        </div>
                        <p class="data-value">
                            {{ ucfirst(str_replace('-', ' ', $lokasi->type)) }}
                        </p>
                    </div>

                    <div class="data-item">
                        <div class="data-label">
                            <i class="fas fa-bullseye data-icon"></i> Radius Absensi
                        </div>
                        <p class="data-value highlight">
                            {{ $lokasi->radius }} meter
                        </p>
                    </div>

                    <div class="data-item">
                        <div class="data-label">
                            <i class="fas fa-power-off data-icon"></i> Status
                        </div>
                        <span
                            class="status-badge {{ $lokasi->status == 'enable' ? 'status-active' : 'status-inactive' }}">
                            <i
                                class="fas {{ $lokasi->status == 'enable' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                            {{ $lokasi->status == 'enable' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    <div class="data-item">
                        <div class="data-label">
                            <i class="fas fa-map-pin data-icon"></i> Koordinat
                        </div>
                        <p class="data-value">
                            {{ number_format($lokasi->latitude, 6) }}, {{ number_format($lokasi->longitude, 6) }}
                        </p>
                    </div>
                </div>

                <!-- Time Indicators -->
                <div class="mb-3">
                    <div class="time-indicator">
                        <i class="fas fa-sign-in-alt"></i>
                        <span class="time-label">Jam Masuk:</span>
                        <span class="time-value">{{ $lokasi->jam_masuk ?? '--:--' }}</span>
                    </div>
                    <div class="time-indicator">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="time-label">Batas Jam Masuk:</span>
                        <span class="time-value">{{ $lokasi->jam_sampai ?? '--:--' }}</span>
                    </div>
                </div>

                <!-- Address -->
                <div class="mb-3">
                    <div class="data-label">
                        <i class="fas fa-map-marker-alt me-2"></i> Alamat Lengkap
                    </div>
                    <div class="p-3 bg-light rounded">
                        {{ $lokasi->alamat ?? 'Alamat tidak tersedia' }}
                    </div>
                </div>

                <!-- Map Container -->
                <div class="map-container" id="map{{ $index }}">
                    <div class="map-overlay">
                        <i class="fas fa-info-circle"></i> Radius: {{ $lokasi->radius }}m
                    </div>
                </div>

                <!-- Attendance Section -->
                <div class="attendance-section">
                    <div class="distance-info">
                        <i class="fas fa-arrows-alt-h distance-icon"></i>
                        <span class="distance-text">Jarak dari lokasi:</span>
                        <span id="distance{{ $index }}" class="distance-value">-</span>
                    </div>
                    <div>
                        <span id="locationStatus{{ $index }}" class="status-badge status-pending me-3">
                            <i class="fas fa-sync-alt fa-spin"></i> Mendeteksi lokasi...
                        </span>
                        <button id="attendanceBtn{{ $index }}" class="attendance-btn" disabled>
                            <i class="fas fa-fingerprint"></i> Absen Sekarang
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="location-card">
                <h2 class="location-title">
                    <i class="fas fa-map-marked-alt"></i> Tidak Ada Lokasi
                </h2>
                <div class="text-center py-4">
                    <i class="fas fa-map-marker-slash fa-3x mb-3" style="color: #a0aec0;"></i>
                    <p class="text-muted">Tidak ada lokasi absensi yang tersedia saat ini.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Loading Modal - Improved -->
    <div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div id="loadingSpinner" class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div id="loadingMessage" class="mt-3">Memproses...</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS for maps -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @forelse ($lokasis as $index => $lokasi)
                initializeLocation(
                    {{ $index }},
                    {{ $lokasi->latitude }},
                    {{ $lokasi->longitude }},
                    {{ $lokasi->radius }},
                    {{ $lokasi->id }}
                );
            @empty
            @endforelse

            const animateElements = document.querySelectorAll('.animate__animated');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add(entry.target.dataset.animation);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            animateElements.forEach(element => {
                observer.observe(element);
            });
        });

        function initializeLocation(index, targetLat, targetLng, radius, lokasiId) {
            const mapId = `map${index}`;
            const distanceId = `distance${index}`;
            const statusId = `locationStatus${index}`;
            const btnId = `attendanceBtn${index}`;

            const map = L.map(mapId).setView([targetLat, targetLng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const targetMarker = L.circleMarker([targetLat, targetLng], {
                radius: 8,
                fillColor: "#667eea",
                color: "#ffffff",
                weight: 2,
                opacity: 1,
                fillOpacity: 0.8
            }).addTo(map);

            targetMarker.bindPopup(`<b>Lokasi Absen</b><br>${radius}m radius`).openPopup();

            L.circle([targetLat, targetLng], {
                color: '#667eea',
                fillColor: '#667eea',
                fillOpacity: 0.2,
                radius: radius
            }).addTo(map);

            let userMarker = null;
            let accuracyCircle = null;

            function updateLocation(position) {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;
                const accuracy = position.coords.accuracy;

                const distance = calculateDistance(userLat, userLng, targetLat, targetLng);
                document.getElementById(distanceId).textContent = `${Math.round(distance)}m`;

                if (userMarker) {
                    userMarker.setLatLng([userLat, userLng]);
                } else {
                    userMarker = L.circleMarker([userLat, userLng], {
                        radius: 6,
                        fillColor: "#48bb78",
                        color: "#ffffff",
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.8
                    }).addTo(map).bindPopup("<b>Posisi Anda</b>").openPopup();
                }

                if (accuracyCircle) {
                    accuracyCircle.setLatLng([userLat, userLng]);
                    accuracyCircle.setRadius(accuracy);
                } else {
                    accuracyCircle = L.circle([userLat, userLng], {
                        color: '#48bb78',
                        fillColor: '#48bb78',
                        fillOpacity: 0.2,
                        radius: accuracy
                    }).addTo(map);
                }

                const isWithinRadius = distance <= (radius + accuracy);
                const statusElement = document.getElementById(statusId);
                const button = document.getElementById(btnId);

                if (isWithinRadius) {
                    statusElement.className = "status-badge status-active";
                    statusElement.innerHTML = '<i class="fas fa-check-circle"></i> Dalam jangkauan';
                    button.disabled = false;
                } else {
                    statusElement.className = "status-badge status-inactive";
                    statusElement.innerHTML = '<i class="fas fa-times-circle"></i> Di luar jangkauan';
                    button.disabled = true;
                }

                const group = new L.featureGroup([targetMarker, userMarker, accuracyCircle]);
                map.fitBounds(group.getBounds().pad(0.5));
            }

            function handleLocationError(error) {
                const statusElement = document.getElementById(statusId);
                const button = document.getElementById(btnId);

                statusElement.className = "status-badge status-inactive";

                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        statusElement.innerHTML = '<i class="fas fa-ban"></i> Akses lokasi ditolak';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        statusElement.innerHTML = '<i class="fas fa-question-circle"></i> Lokasi tidak tersedia';
                        break;
                    case error.TIMEOUT:
                        statusElement.innerHTML = '<i class="fas fa-clock"></i> Timeout';
                        break;
                    default:
                        statusElement.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Error tidak diketahui';
                        break;
                }

                button.disabled = true;
            }

            if (navigator.geolocation) {
                const options = {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                };

                navigator.geolocation.watchPosition(updateLocation, handleLocationError, options);

                document.getElementById(btnId).addEventListener('click', function() {
                    const loadingModal = showLoading('Mencatat absensi...');
                    
                    navigator.geolocation.getCurrentPosition(function(position) {
                        fetch('{{ route('absen.store') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    lokasi_id: lokasiId,
                                    latitude: position.coords.latitude,
                                    longitude: position.coords.longitude
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                hideLoading(loadingModal);
                                showNotification('success', data.message || 'Absensi berhasil dicatat!');
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            })
                            .catch(error => {
                                hideLoading(loadingModal);
                                console.error('Error:', error);
                                showNotification('danger', 'Terjadi kesalahan saat mencatat absensi: ' + error.message);
                            });
                    }, (error) => {
                        hideLoading(loadingModal);
                        showNotification('danger', 'Gagal mendapatkan lokasi: ' + error.message);
                    });
                });
            } else {
                document.getElementById(statusId).innerHTML =
                    '<i class="fas fa-exclamation-triangle"></i> Geolocation tidak didukung';
                document.getElementById(btnId).disabled = true;
            }
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371e3;
            const φ1 = lat1 * Math.PI / 180;
            const φ2 = lat2 * Math.PI / 180;
            const Δφ = (lat2 - lat1) * Math.PI / 180;
            const Δλ = (lon2 - lon1) * Math.PI / 180;

            const a = Math.sin(Δφ / 2) ** 2 +
                Math.cos(φ1) * Math.cos(φ2) *
                Math.sin(Δλ / 2) ** 2;
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            return R * c;
        }

        // Improved Loading Modal Functions
        function showLoading(message) {
            const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
            document.getElementById('loadingMessage').textContent = message;
            loadingModal.show();
            return loadingModal;
        }

        function hideLoading(modal) {
            modal.hide();
        }

        // Improved Notification System
        function showNotification(type, message) {
            const alertTypes = {
                'success': {
                    icon: 'fa-check-circle',
                    color: 'success'
                },
                'danger': {
                    icon: 'fa-exclamation-circle',
                    color: 'danger'
                },
                'warning': {
                    icon: 'fa-exclamation-triangle',
                    color: 'warning'
                },
                'info': {
                    icon: 'fa-info-circle',
                    color: 'info'
                }
            };

            const alertConfig = alertTypes[type] || alertTypes.info;
            
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${alertConfig.color} alert-dismissible fade show custom-alert animate__animated animate__fadeInRight`;
            alertDiv.role = 'alert';
            
            alertDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas ${alertConfig.icon} alert-icon"></i>
                    <div>${message}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

            const container = document.querySelector('.notification-container');
            container.insertBefore(alertDiv, container.firstChild);

            // Auto dismiss after 5 seconds
            setTimeout(() => {
                alertDiv.classList.add('animate__fadeOutRight');
                setTimeout(() => {
                    alertDiv.remove();
                }, 500);
            }, 5000);
        }
    </script>
</body>
</html>