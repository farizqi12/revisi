<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 15px;
        }

        .login-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: none;
            overflow: hidden;
            transition: all 0.5s ease;
            background: white;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 25px;
            border-bottom: none;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
            object-fit: contain;
        }

        .card-header h3 {
            margin: 0;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .card-body {
            padding: 30px;
            background: white;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 15px 12px 40px;
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
            border-color: #667eea;
        }

        .btn-login {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            background: linear-gradient(90deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(118, 75, 162, 0.3);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 16px;
        }

        /* Perubahan pada CSS floating label dan input icon */
        .floating-label {
            position: relative;
            margin-bottom: 25px;
        }

        .floating-label .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 16px;
            transition: all 0.3s;
            z-index: 2;
        }

        .floating-label input:focus~.input-icon,
        .floating-label input:not(:placeholder-shown)~.input-icon {
            top: 15px;
            transform: translateY(0);
            font-size: 14px;
        }

        .floating-label label {
            position: absolute;
            top: 12px;
            left: 40px;
            color: #999;
            transition: all 0.3s;
            pointer-events: none;
            background: white;
            padding: 0 5px;
            z-index: 1;
        }

        .floating-label input:focus+label,
        .floating-label input:not(:placeholder-shown)+label {
            top: -10px;
            left: 35px;
            font-size: 12px;
            color: #667eea;
            z-index: 3;
        }

        .animate-delay-1 {
            animation-delay: 0.1s;
        }

        .animate-delay-2 {
            animation-delay: 0.2s;
        }

        .animate-delay-3 {
            animation-delay: 0.3s;
        }

        .alert {
            border-radius: 8px;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .card-header {
                padding: 20px;
            }

            .card-body {
                padding: 25px;
            }

            .logo {
                width: 70px;
                height: 70px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="card login-card animate__animated animate__fadeInUp">
            <div class="card-header animate__animated animate__fadeInDown">
                <img src="{{ asset('img/logo.png') }}" alt="Logo Sistem" class="logo">
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

                    <div class="mb-3 floating-label animate__animated animate__fadeIn animate-delay-1">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="text" class="form-control" id="username" name="username" placeholder=" "
                            required>
                        <label for="email">Username</label>
                        <div class="invalid-feedback">
                            Harap masukkan Username yang valid
                        </div>
                    </div>

                    <div class="mb-3 floating-label animate__animated animate__fadeIn animate-delay-2">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" class="form-control" id="password" name="password" placeholder=" "
                            required>
                        <label for="password">Password</label>
                        <div class="invalid-feedback">
                            Harap masukkan password
                        </div>
                    </div>
                    <div class="form-check mb-3 animate__animated animate__fadeIn animate-delay-3">
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
    <div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-body text-center p-5">
                    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h5 class="mt-3">Memproses login...</h5>
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
    </script>
</body>

</html>
