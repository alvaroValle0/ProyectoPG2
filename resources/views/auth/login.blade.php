<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión HDC - Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        (function() {
            try {
                const global = localStorage.getItem('sistemaColores');
                const colores = global ? JSON.parse(global) : null;
                if (colores) {
                    document.documentElement.style.setProperty('--primary', colores.primary);
                    document.documentElement.style.setProperty('--secondary', colores.secondary);
                    document.documentElement.style.setProperty('--success', colores.success);
                }
            } catch (e) {}
        })();
    </script>
    <style>
        :root {
            --primary: #F2AE4E;
            --secondary: #E89A3A;
            --success: #28a745;
            --gradient: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }
        body {
            background: var(--gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.25;
            z-index: 0;
        }
        body::before { width: 320px; height: 320px; background: var(--primary); top: -80px; left: -80px; }
        body::after { width: 280px; height: 280px; background: var(--secondary); bottom: -60px; right: -60px; }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 400px;
            margin: 1rem;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 1rem;
                align-items: flex-start;
                padding-top: 2rem;
            }
            
            .login-card {
                margin: 0;
                border-radius: 15px;
                max-width: none;
                width: 100%;
            }
            
            .login-card .card-body {
                padding: 2rem 1.5rem !important;
            }
            
            .form-control {
                height: 50px;
                font-size: 16px; /* Previene zoom en iOS */
                padding: 15px;
            }
            
            .btn-primary {
                height: 50px;
                font-size: 1.1rem;
                width: 100%;
            }
            
            .social-btn {
                height: 48px;
                font-size: 1rem;
            }
            
            h3 {
                font-size: 1.5rem;
            }
            
            .form-group {
                margin-bottom: 1.5rem;
            }
            
            .logo-section img {
                max-height: 60px !important;
            }
        }
        
        @media (max-width: 480px) {
            .login-card .card-body {
                padding: 1.5rem 1rem !important;
            }
            
            h3 {
                font-size: 1.3rem;
            }
            
            .social-btn {
                font-size: 0.9rem;
                padding: 12px 16px;
            }
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem color-mix(in srgb, var(--primary) 25%, transparent);
        }
        .btn-primary {
            background: var(--gradient);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px color-mix(in srgb, var(--primary) 40%, transparent);
        }
        .social-btn {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .social-btn:hover {
            transform: translateY(-1px);
        }
        .password-toggle {
            background: transparent;
            border: none;
            color: #6c757d;
        }
        .password-toggle:hover { color: var(--primary); }
        .divider {
            position: relative;
            text-align: center;
            margin: 20px 0;
        }
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #dee2e6;
        }
        .divider span {
            background: rgba(255, 255, 255, 0.95);
            padding: 0 15px;
            color: #6c757d;
        }
        .system-title {
            font-size: 2.2rem;
            font-weight: 800;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 0.5rem;
        }
        .system-subtitle {
            font-size: 0.9rem;
            color: #6c757d !important;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        .login-footer {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }
        @media (max-width: 768px) {
            .system-title {
                font-size: 1.8rem;
            }
        }
        .company-logo {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .logo-image {
            max-height: 80px;
            max-width: 150px;
            width: auto;
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
            transition: transform 0.3s ease;
        }
        .logo-image:hover {
            transform: scale(1.05);
        }
        @media (max-width: 768px) {
            .logo-image {
                max-height: 60px;
                max-width: 120px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-card p-4 p-md-5">
                    <div class="text-center mb-4">
                        <!-- Logo/Nombre del Sistema -->
                        <div class="mb-4">
                            <div class="company-logo mb-3">
                                <img src="{{ asset('images/Imagen_de_WhatsApp_2025-08-10_a_las_17.56.17_0b0e759c-removebg-preview.png') }}" 
                                     alt="Gestión HDC Logo" 
                                     class="img-fluid logo-image">
                            </div>
                            <h1 class="system-title" style="background: var(--gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                Gestión HDC
                            </h1>
                            <p class="system-subtitle">Sistema de Gestión Integral</p>
                            <div class="mt-2">
                                <span class="badge" style="background: var(--gradient); font-size: 0.7rem; padding: 4px 12px;">
                                    <i class="fas fa-shield-alt me-1"></i>Acceso Seguro
                                </span>
                            </div>
                        </div>
                        
                        <!-- Título de Login -->
                        <h3 class="fw-bold text-primary mb-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                        </h3>
                        <p class="text-muted">Accede a tu cuenta para continuar</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="fas fa-user me-2"></i>Nombre de Usuario
                            </label>
                            <input type="text" 
                                   class="form-control @error('username') is-invalid @enderror" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username') }}" 
                                   required 
                                   autofocus
                                   placeholder="Ingresa tu nombre de usuario">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Contraseña
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required>
                                <button class="password-toggle" type="button" tabindex="-1" aria-label="Mostrar/Ocultar contraseña" onclick="togglePassword()">
                                    <i id="pwdIcon" class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small id="capsLockHint" class="text-warning d-none"><i class="fas fa-exclamation-triangle me-1"></i>Bloq Mayús está activado</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Recordarme
                            </label>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                            </button>
                        </div>
                    </form>

                    <div class="divider">
                        <span>o</span>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('register') }}" class="btn btn-outline-primary social-btn">
                            <i class="fas fa-user-plus me-2"></i>Crear Cuenta
                        </a>
                    </div>

                    <div class="text-center mt-4">
                        <a href="#" class="text-decoration-none text-muted">
                            <small>¿Olvidaste tu contraseña?</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer del Sistema -->
    <div class="login-footer text-center">
        <div class="mb-1">
            <i class="fas fa-copyright me-1"></i>{{ date('Y') }} Gestión HDC - Sistema de Gestión Integral
        </div>
        <div>
            <small>
                <i class="fas fa-code me-1"></i>Versión 1.0 
                <span class="mx-2">|</span>
                <i class="fas fa-shield-alt me-1"></i>Plataforma Segura
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('pwdIcon');
            if (!input) return;
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            icon.className = isText ? 'fas fa-eye' : 'fas fa-eye-slash';
        }

        (function capsLockListener(){
            const pwd = document.getElementById('password');
            const hint = document.getElementById('capsLockHint');
            if (!pwd || !hint) return;
            pwd.addEventListener('keyup', (e) => {
                const caps = e.getModifierState && e.getModifierState('CapsLock');
                hint.classList.toggle('d-none', !caps);
            });
        })();
    </script>
</body>
</html> 