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
            margin-left: 280px;
            transition: margin-left 0.3s ease;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: rgba(18, 147, 252, 0.95);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(18, 147, 252, 0.2);
            z-index: 1000;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .sidebar.collapsed {
            transform: translateX(-100%);
        }
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        .sidebar-menu {
            padding: 1rem 0;
            flex: 1;
            overflow-y: auto;
        }
        .sidebar-item {
            padding: 0.75rem 1.5rem;
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border-left-color: #ffffff;
            text-decoration: none;
        }
        .sidebar-item.active {
            background: rgba(255, 255, 255, 0.3);
            color: #ffffff;
            border-left-color: #ffffff;
        }
        .sidebar-item i {
            width: 20px;
            margin-right: 10px;
        }
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
        }
        .main-content.expanded {
            margin-left: 0;
        }
        .navbar.expanded {
            margin-left: 0;
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
        .menu-toggle {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: background-color 0.3s ease;
        }
        .menu-toggle:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .navbar {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
            }
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
    <!-- Overlay para móviles -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4 class="mb-0 text-white">
                <i class="fas fa-tachometer-alt me-2"></i>
                <span>Panel</span>
            </h4>
            <small class="text-white-50">Sistema de Gestión</small>
    </div>
        
        <div class="sidebar-menu">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="sidebar-item active">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            
            <!-- Gestión de Usuarios -->
            <a href="#" class="sidebar-item" onclick="mostrarProximamente('Usuarios')">
                <i class="fas fa-users"></i>
                Usuarios
            </a>
            
            <!-- Proyectos -->
            <a href="#" class="sidebar-item" onclick="mostrarProximamente('Proyectos')">
                <i class="fas fa-project-diagram"></i>
                Proyectos
            </a>
            
            <!-- Tareas -->
            <a href="#" class="sidebar-item" onclick="mostrarProximamente('Tareas')">
                <i class="fas fa-tasks"></i>
                Tareas
            </a>
            
            <!-- Calendario -->
            <a href="#" class="sidebar-item" onclick="mostrarProximamente('Calendario')">
                <i class="fas fa-calendar-alt"></i>
                Calendario
            </a>
            
            <!-- Reportes -->
            <a href="#" class="sidebar-item" onclick="mostrarProximamente('Reportes')">
                <i class="fas fa-chart-bar"></i>
                Reportes
            </a>
            
            <!-- Configuración -->
            <a href="#" class="sidebar-item" onclick="mostrarProximamente('Configuración')">
                <i class="fas fa-cog"></i>
                Configuración
            </a>
            
            <!-- Ayuda -->
            <a href="#" class="sidebar-item" onclick="mostrarProximamente('Ayuda')">
                <i class="fas fa-question-circle"></i>
                Ayuda
            </a>
</div>

        <!-- Botón toggle para móviles (dentro del sidebar) -->
        <div class="p-3 border-top border-white border-opacity-25">
            <button class="menu-toggle w-100" onclick="toggleSidebar()">
                <i class="fas fa-times"></i> Cerrar Menú
            </button>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
        <div class="container-fluid">
            <!-- Botón toggle para móviles -->
            <button class="btn btn-outline-primary d-lg-none me-2" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            
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
    <div class="main-content" id="mainContent">
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
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const navbar = document.getElementById('navbar');
            const mainContent = document.getElementById('mainContent');
            const overlay = document.getElementById('sidebarOverlay');
            
            // Toggle classes
            sidebar.classList.toggle('show');
            
            // Para móviles, mostrar/ocultar overlay
            if (window.innerWidth <= 768) {
                overlay.classList.toggle('show');
            } else {
                // Para desktop, colapsar el sidebar completamente
                sidebar.classList.toggle('collapsed');
                navbar.classList.toggle('expanded');
                mainContent.classList.toggle('expanded');
            }
        }
        
        // Cerrar sidebar cuando se hace clic fuera en móviles
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isToggleButton = event.target.closest('.btn-outline-primary');
            
            if (window.innerWidth <= 768 && !isClickInsideSidebar && !isToggleButton && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        });
        
        // Actualizar el item activo del menú
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const sidebarItems = document.querySelectorAll('.sidebar-item');
            
            sidebarItems.forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('href') === currentPath) {
                    item.classList.add('active');
                }
            });
        });
</script>
</body>
</html>