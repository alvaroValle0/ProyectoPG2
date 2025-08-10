<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Sistema de Gestión</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .main-content {
            padding: 2rem;
        }
        .content-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            border: none;
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .btn-custom {
            border-radius: 25px;
            padding: 0.5rem 2rem;
            font-weight: 600;
        }
        .navbar-text {
            font-size: 0.95rem;
        }
        .btn-outline-danger:hover {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }
        @media (max-width: 768px) {
            .navbar-text {
                font-size: 0.9rem;
                margin-bottom: 0.5rem;
            }
            .nav-item {
                margin-bottom: 0.25rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt text-primary me-2"></i>
                Sistema de Gestión
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Información del usuario -->
                    <li class="nav-item">
                        <span class="navbar-text me-3">
                            <i class="fas fa-user-circle text-primary me-2"></i>
                            Bienvenido, <strong>{{ auth()->user()->name }}</strong>
                        </span>
                    </li>
                    
                    <!-- Botón directo de cerrar sesión -->
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres cerrar sesión?')">
                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                            </button>
                        </form>
                    </li>
                    
                    <!-- Dropdown adicional para otras opciones -->
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle btn btn-outline-secondary btn-sm" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cog"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#" onclick="mostrarProximamente('Perfil')"><i class="fas fa-user me-2"></i>Mi Perfil</a></li>
                            <li><a class="dropdown-item" href="#" onclick="mostrarProximamente('Configuración')"><i class="fas fa-cog me-2"></i>Configuración</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-muted" href="#"><i class="fas fa-info-circle me-2"></i>Versión 1.0.0</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            
            <!-- Mensaje de bienvenida -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="content-card p-4">
                        <h1 class="h3 mb-3">
                            <i class="fas fa-tachometer-alt text-primary me-2"></i>
                            Dashboard Principal
                        </h1>
                        <p class="text-muted mb-0">Bienvenido de vuelta, {{ auth()->user()->name }}. Aquí tienes un resumen de tu sistema.</p>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card h-100 border-0">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-users display-6"></i>
                                </div>
                            </div>
                            <h4 class="text-primary">{{ \App\Models\User::count() }}</h4>
                            <p class="text-muted mb-0">Usuarios Registrados</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card h-100 border-0">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-check-circle display-6"></i>
                                </div>
                            </div>
                            <h4 class="text-success">0</h4>
                            <p class="text-muted mb-0">Tareas Completadas</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card h-100 border-0">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-clock display-6"></i>
                                </div>
                            </div>
                            <h4 class="text-warning">0</h4>
                            <p class="text-muted mb-0">Tareas Pendientes</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card h-100 border-0">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-chart-line display-6"></i>
                                </div>
                            </div>
                            <h4 class="text-info">100%</h4>
                            <p class="text-muted mb-0">Sistema Activo</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="content-card p-4">
                        <h5 class="mb-3">
                            <i class="fas fa-bolt text-warning me-2"></i>
                            Acciones Rápidas
                        </h5>
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <button class="btn btn-primary w-100 btn-custom" onclick="mostrarProximamente('Nuevo Proyecto')">
                                    <i class="fas fa-plus me-2"></i>Nuevo Proyecto
                                </button>
                            </div>
                            <div class="col-md-3 mb-2">
                                <button class="btn btn-success w-100 btn-custom" onclick="mostrarProximamente('Gestión de Usuarios')">
                                    <i class="fas fa-users me-2"></i>Gestión de Usuarios
                                </button>
                            </div>
                            <div class="col-md-3 mb-2">
                                <button class="btn btn-info w-100 btn-custom" onclick="mostrarProximamente('Reportes')">
                                    <i class="fas fa-chart-bar me-2"></i>Reportes
                                </button>
                            </div>
                            <div class="col-md-3 mb-2">
                                <button class="btn btn-warning w-100 btn-custom" onclick="mostrarProximamente('Configuración')">
                                    <i class="fas fa-cog me-2"></i>Configuración
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="row">
                <div class="col-md-6">
                    <div class="content-card p-4">
                        <h5 class="mb-3">
                            <i class="fas fa-info-circle text-info me-2"></i>
                            Información del Sistema
                        </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between bg-transparent">
                                <span>Versión:</span>
                                <strong>1.0.0</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between bg-transparent">
                                <span>Laravel:</span>
                                <strong>{{ app()->version() }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between bg-transparent">
                                <span>PHP:</span>
                                <strong>{{ phpversion() }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between bg-transparent">
                                <span>Usuario Actual:</span>
                                <strong>{{ auth()->user()->email }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="content-card p-4">
                        <h5 class="mb-3">
                            <i class="fas fa-calendar text-primary me-2"></i>
                            Actividad Reciente
                        </h5>
                        <div class="text-center py-4">
                            <i class="fas fa-history display-4 text-muted mb-3"></i>
                            <p class="text-muted">No hay actividad reciente</p>
                            <small class="text-muted">La actividad aparecerá aquí conforme uses el sistema</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function mostrarProximamente(feature) {
            alert('La función "' + feature + '" estará disponible próximamente.');
        }
    </script>
</body>
</html>