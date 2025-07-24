<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Absensi dan Tabungan Sekolah berbasis web untuk mengelola kehadiran dan keuangan siswa.">
    <meta name="keywords" content="absensi, tabungan, sekolah, laravel, sistem informasi">
    <title>Login Sistem</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --background-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            --shadow-color: rgba(102, 126, 234, 0.15);
            --border-radius: 20px;
            --transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--background-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="60" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="30" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="90" r="1" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            animation: float 20s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 15px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            border-radius: var(--border-radius);
            box-shadow: 
                0 20px 60px var(--shadow-color),
                0 8px 20px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .login-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 
                0 30px 80px var(--shadow-color),
                0 15px 35px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .card-header {
            background: var(--primary-gradient);
            color: white;
            text-align: center;
            padding: 40px 30px;
            border-bottom: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(180deg); }
        }

        .logo {
            width: 90px;
            height: 90px;
            margin-bottom: 20px;
            object-fit: contain;
            border-radius: 50%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: var(--transition);
            position: relative;
            z-index: 1;
        }

        .logo::before {
            content: '🔐';
            font-size: 40px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .card-header h3 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 1px;
            font-size: 1.5rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }

        .card-body {
            padding: 40px 35px;
            background: rgba(255, 255, 255, 0.95);
            position: relative;
        }

        .floating-label {
            position: relative;
            margin-bottom: 30px;
        }

        .floating-label input {
            width: 100%;
            padding: 18px 20px 18px 55px;
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 15px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.9);
            transition: var(--transition);
            backdrop-filter: blur(10px);
        }

        .floating-label input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 
                0 0 0 4px rgba(102, 126, 234, 0.1),
                0 8px 25px rgba(102, 126, 234, 0.15);
            background: white;
            transform: translateY(-2px);
        }

        .floating-label input:not(:placeholder-shown) {
            border-color: #667eea;
            background: white;
        }

        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 18px;
            transition: var(--transition);
            z-index: 2;
        }

        .floating-label input:focus ~ .input-icon,
        .floating-label input:not(:placeholder-shown) ~ .input-icon {
            color: #764ba2;
            transform: translateY(-50%) scale(1.1);
        }

        .floating-label label {
            position: absolute;
            top: 18px;
            left: 55px;
            color: #666;
            transition: var(--transition);
            pointer-events: none;
            background: transparent;
            padding: 0 8px;
            font-weight: 500;
            font-size: 16px;
        }

        .floating-label input:focus + label,
        .floating-label input:not(:placeholder-shown) + label {
            top: -12px;
            left: 45px;
            font-size: 13px;
            color: #667eea;
            font-weight: 600;
            background: white;
            padding: 2px 8px;
            border-radius: 8px;
        }

        .form-check {
            margin-bottom: 25px;
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .form-check-label {
            font-weight: 500;
            color: #555;
            cursor: pointer;
        }

        .btn-login {
            background: var(--primary-gradient);
            border: none;
            border-radius: 15px;
            padding: 18px 30px;
            font-weight: 700;
            color: white;
            width: 100%;
            transition: var(--transition);
            letter-spacing: 1px;
            font-size: 16px;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            background: var(--secondary-gradient);
            transform: translateY(-3px);
            box-shadow: 
                0 15px 35px rgba(118, 75, 162, 0.4),
                0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .alert {
            border-radius: 15px;
            border: none;
            backdrop-filter: blur(10px);
            margin-bottom: 25px;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }

        .invalid-feedback {
            font-weight: 500;
            font-size: 14px;
        }

        /* Loading Modal Improvements */
        .modal-content {
            border-radius: var(--border-radius);
            border: none;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
        }

        .spinner-border {
            width: 4rem !important;
            height: 4rem !important;
            border-width: 0.4em;
        }

        .spinner-border.text-primary {
            --bs-spinner-border-color: var(--primary-gradient);
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .login-container {
                max-width: 100%;
                padding: 10px;
            }
            
            .card-header {
                padding: 30px 20px;
            }

            .card-body {
                padding: 30px 25px;
            }

            .logo {
                width: 80px;
                height: 80px;
                margin-bottom: 15px;
            }

            .card-header h3 {
                font-size: 1.3rem;
            }

            .floating-label input {
                padding: 16px 18px 16px 50px;
                font-size: 15px;
            }

            .floating-label label {
                left: 50px;
                font-size: 15px;
            }

            .floating-label input:focus + label,
            .floating-label input:not(:placeholder-shown) + label {
                left: 40px;
                font-size: 12px;
            }

            .btn-login {
                padding: 16px 25px;
                font-size: 15px;
            }
        }

        @media (max-width: 380px) {
            .floating-label input {
                padding: 14px 16px 14px 45px;
            }
            
            .input-icon {
                left: 16px;
                font-size: 16px;
            }
            
            .floating-label label {
                left: 45px;
            }
            
            .floating-label input:focus + label,
            .floating-label input:not(:placeholder-shown) + label {
                left: 35px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="card login-card animate__animated animate__fadeInUp">
            <div class="card-header animate__animated animate__fadeInDown">
                <div class="logo"></div>
                <h3>Login Sistem</h3>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger animate__animated animate__shakeX">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="/login" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <div class="floating-label animate__animated animate__fadeIn animate-delay-1">
                        <input type="text" class="form-control" id="username" name="username" placeholder=" " required>
                        <label for="username">Username</label>
                        <i class="fas fa-user input-icon"></i>
                        <div class="invalid-feedback">
                            Harap masukkan Username yang valid
                        </div>
                    </div>

                    <div class="floating-label animate__animated animate__fadeIn animate-delay-2">
                        <input type="password" class="form-control" id="password" name="password" placeholder=" " required>
                        <label for="password">Password</label>
                        <i class="fas fa-lock input-icon"></i>
                        <div class="invalid-feedback">
                            Harap masukkan password
                        </div>
                    </div>

                    <div class="form-check animate__animated animate__fadeIn animate-delay-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Ingat saya
                        </label>
                    </div>

                    <div class="d-grid gap-2 animate__animated animate__fadeIn animate-delay-3">
                        <button type="submit" class="btn btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-body text-center p-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h5 class="mt-4 fw-bold text-muted">Memproses login...</h5>
                    <p class="text-muted mb-0">Mohon tunggu sebentar</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            // Validasi form sebelum menampilkan loading modal
            const form = this;
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            if (!username || !password) {
                e.preventDefault();
                e.stopPropagation();
                form.classList.add('was-validated');
                return false;
            }

            // Tampilkan modal loading hanya jika form valid
            const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
            loadingModal.show();

            return true;
        });

        // Form validation
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                            // Jangan tampilkan loading modal jika form tidak valid
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        // Add smooth interactions
        document.querySelectorAll('.floating-label input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    </script>
</body>

</html>