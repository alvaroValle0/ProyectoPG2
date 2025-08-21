<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión HDC - Sistema de Gestión Integral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #F2AE4E 0%, #E89A3A 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .btn-primary {
            background: linear-gradient(135deg, #F2AE4E 0%, #E89A3A 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(242, 174, 78, 0.4);
        }
        .btn-outline-primary {
            border: 2px solid #F2AE4E;
            color: #F2AE4E;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            background: transparent;
        }
        .btn-outline-primary:hover {
            transform: translateY(-2px);
            background: #F2AE4E;
            border-color: #F2AE4E;
            color: white;
        }
        .welcome-footer {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }
        .system-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #F2AE4E 0%, #E89A3A 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        @media (max-width: 768px) {
            .system-title {
                font-size: 2rem;
            }
        }
        .company-logo {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .logo-image {
            max-height: 120px;
            max-width: 200px;
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
                max-height: 80px;
                max-width: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="welcome-card p-5 text-center">
                    <div class="mb-4">
                        <div class="company-logo mb-4">
                            <img src="{{ asset('images/Imagen_de_WhatsApp_2025-08-10_a_las_17.56.17_0b0e759c-removebg-preview.png') }}" 
                                 alt="Gestión HDC Logo" 
                                 class="img-fluid logo-image">
                        </div>
                        <h1 class="system-title">Bienvenido a Gestión HDC</h1>
                        <p class="lead text-muted">Sistema de Gestión Integral</p>
                        <div class="mt-3">
                            <span class="badge px-3 py-2" style="background: linear-gradient(135deg, #F2AE4E 0%, #E89A3A 100%);">
                                <i class="fas fa-shield-alt me-2"></i>Plataforma Profesional
                            </span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('login') }}" class="btn btn-primary w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('register') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-user-plus me-2"></i>Registrarse
                            </a>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="row g-2 text-muted small">
                            <div class="col-md-6">
                                <i class="fas fa-users text-success me-2"></i>
                                Gestión de Clientes
                            </div>
                            <div class="col-md-6">
                                <i class="fas fa-laptop text-info me-2"></i>
                                Control de Equipos
                            </div>
                            <div class="col-md-6">
                                <i class="fas fa-wrench text-warning me-2"></i>
                                Reparaciones
                            </div>
                            <div class="col-md-6">
                                <i class="fas fa-chart-bar text-primary me-2"></i>
                                Reportes
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer del Sistema -->
    <div class="welcome-footer text-center">
        <div class="mb-1">
            <i class="fas fa-copyright me-1"></i>{{ date('Y') }} Gestión HDC - Sistema de Gestión Integral
        </div>
        <div>
            <small>
                <i class="fas fa-code me-1"></i>Versión 1.0 
                <span class="mx-2">|</span>
                <i class="fas fa-rocket me-1"></i>Plataforma Completa
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
