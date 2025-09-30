<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión HDC - Registrarse</title>
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Contenedor principal */
        .register-container {
            display: flex;
            min-height: 100vh;
        }

        /* Panel izquierdo - Branding */
        .brand-panel {
            flex: 1;
            background: var(--gradient);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 2rem;
            position: relative;
            overflow: hidden;
        }

        /* Patrones de ondas abstractas */
        .brand-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255,255,255,0.08) 0%, transparent 50%),
                radial-gradient(circle at 50% 10%, rgba(255,255,255,0.06) 0%, transparent 40%);
            animation: waveFloat 20s ease-in-out infinite;
        }

        @keyframes waveFloat {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(-20px, -20px) rotate(1deg); }
            66% { transform: translate(20px, -10px) rotate(-1deg); }
        }

        /* Contenido del panel izquierdo */
        .brand-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            max-width: 400px;
        }

        .brand-logo {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: transform 0.3s ease;
        }

        .brand-logo:hover {
            transform: scale(1.05);
        }

        .brand-logo img {
            width: 80px;
            height: auto;
            filter: brightness(0) invert(1);
        }

        .brand-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .brand-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            font-weight: 400;
        }

        .brand-description {
            font-size: 0.95rem;
            opacity: 0.8;
            line-height: 1.6;
            max-width: 300px;
            margin: 0 auto;
        }

        /* Panel derecho - Formulario */
        .form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            background: white;
            position: relative;
        }

        .form-container {
            width: 100%;
            max-width: 450px;
        }

        .form-header {
            margin-bottom: 2rem;
        }

        .form-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            color: #6b7280;
            font-size: 0.95rem;
        }

        /* Formulario */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(242, 174, 78, 0.1);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .password-input-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 4px;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        .terms-group {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .terms-checkbox {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
            margin-top: 0.125rem;
            flex-shrink: 0;
        }

        .terms-label {
            font-size: 0.9rem;
            color: #6b7280;
            cursor: pointer;
            line-height: 1.4;
        }

        .terms-label a {
            color: var(--primary);
            text-decoration: none;
        }

        .terms-label a:hover {
            text-decoration: underline;
        }

        .register-btn {
            width: 100%;
            background: var(--gradient);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .register-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(242, 174, 78, 0.3);
        }

        .register-btn:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: #9ca3af;
            font-size: 0.9rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            padding: 0 1rem;
        }

        .login-btn {
            width: 100%;
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .login-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(242, 174, 78, 0.2);
        }

        /* Alertas de error */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border: none;
        }

        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }

        /* Footer */
        .register-footer {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            color: #9ca3af;
            font-size: 0.8rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .brand-panel {
                padding: 2rem 1.5rem;
            }
            
            .brand-title {
                font-size: 2rem;
            }
            
            .form-panel {
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
            }
            
            .brand-panel {
                flex: none;
                min-height: 35vh;
                padding: 2rem 1rem;
            }
            
            .brand-title {
                font-size: 1.75rem;
            }
            
            .brand-subtitle {
                font-size: 1rem;
            }
            
            .form-panel {
                flex: none;
                min-height: 65vh;
                padding: 2rem 1rem;
            }
            
            .form-container {
                max-width: none;
            }
            
            .form-control {
                font-size: 16px; /* Previene zoom en iOS */
            }
        }

        @media (max-width: 480px) {
            .brand-panel {
                min-height: 30vh;
                padding: 1.5rem 1rem;
            }
            
            .brand-title {
                font-size: 1.5rem;
            }
            
            .brand-logo {
                width: 90px;
                height: 90px;
                margin-bottom: 1rem;
            }
            
            .brand-logo img {
                width: 60px;
            }
            
            .form-panel {
                min-height: 70vh;
                padding: 1.5rem 1rem;
            }
            
            .form-title {
                font-size: 1.5rem;
            }
        }

        /* Animaciones suaves */
        .form-container {
            animation: slideInUp 0.6s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .brand-content {
            animation: fadeInLeft 0.8s ease-out;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Panel izquierdo - Branding -->
        <div class="brand-panel">
            <div class="brand-content">
                <div class="brand-logo">
                                <img src="{{ asset('images/Imagen_de_WhatsApp_2025-08-10_a_las_17.56.17_0b0e759c-removebg-preview.png') }}" 
                         alt="HDC Logo">
                            </div>
                <h1 class="brand-title">HDC</h1>
                <p class="brand-subtitle">Gestión Integral</p>
                <p class="brand-description">
                    Únete a nuestra plataforma profesional. Gestiona equipos, reparaciones y clientes 
                    con herramientas diseñadas para técnicos especializados.
                </p>
                            </div>
                        </div>
                        
        <!-- Panel derecho - Formulario -->
        <div class="form-panel">
            <div class="form-container">
                <div class="form-header">
                    <h2 class="form-title">Crear Cuenta</h2>
                    <p class="form-subtitle">Completa el formulario para acceder al sistema</p>
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

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                    <div class="form-group">
                        <label for="name" class="form-label">Nombre Completo</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                               autofocus
                               placeholder="Ingresa tu nombre completo">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    <div class="form-group">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                            <input type="text" 
                                   class="form-control @error('username') is-invalid @enderror" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username') }}" 
                                   required
                                   placeholder="Ej: juan123">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                               required
                               placeholder="tu@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="password-input-group">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required
                                   placeholder="Mínimo 8 caracteres">
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i id="password-icon" class="fas fa-eye"></i>
                            </button>
                        </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <div class="password-input-group">
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required
                                   placeholder="Repite tu contraseña">
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i id="password_confirmation-icon" class="fas fa-eye"></i>
                            </button>
                        </div>
                        </div>

                    <div class="terms-group">
                        <input type="checkbox" class="terms-checkbox" id="terms" required>
                        <label for="terms" class="terms-label">
                            Acepto los <a href="#" class="text-decoration-none">términos y condiciones</a> del servicio
                            </label>
                        </div>

                    <button type="submit" class="register-btn">
                        CREAR CUENTA
                            </button>
                    </form>

                    <div class="divider">
                        <span>o</span>
                    </div>

                <a href="{{ route('login') }}" class="login-btn">
                    YA TENGO UNA CUENTA
                        </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="register-footer">
        <div class="mb-1">
            <i class="fas fa-copyright me-1"></i>{{ date('Y') }} Gestión HDC
        </div>
        <div>
            <small>
                <i class="fas fa-shield-alt me-1"></i>Plataforma Segura
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');
            if (!field) return;
            
            const isText = field.type === 'text';
            field.type = isText ? 'password' : 'text';
            icon.className = isText ? 'fas fa-eye' : 'fas fa-eye-slash';
        }

        // Animación suave al cargar
        document.addEventListener('DOMContentLoaded', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease-in-out';
            
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html> 