<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestión HDC - Sistema de Gestión Integral')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- CSS Responsive para móviles -->
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    <!-- CSS Optimizado para touch -->
    <link href="{{ asset('css/touch-optimized.css') }}" rel="stylesheet">
    <!-- Script para aplicar colores inmediatamente (global o por módulo) -->
    <script>
        (function() {
            try {
                // Detectar módulo actual por URL: /modulo/...
                const path = (window.location.pathname || '/').replace(/\/+$/, '');
                const moduleName = (path.split('/')[1] || 'dashboard').toLowerCase();

                // 1) Intentar colores por módulo
                const moduleKey = 'sistemaColores_module_' + moduleName;
                let colores = null;
                const mod = localStorage.getItem(moduleKey);
                if (mod) {
                    colores = JSON.parse(mod);
                }

                // 2) Si no hay por módulo, usar global
                if (!colores) {
                    const global = localStorage.getItem('sistemaColores');
                    if (global) {
                        colores = JSON.parse(global);
                    }
                }

                if (!colores) return; // Nada que aplicar

                // Actualizar variables CSS del sistema
                document.documentElement.style.setProperty('--system-primary', colores.primary);
                document.documentElement.style.setProperty('--system-secondary', colores.secondary);
                document.documentElement.style.setProperty('--system-success', colores.success);
                document.documentElement.style.setProperty('--system-warning', colores.warning);
                document.documentElement.style.setProperty('--system-danger', colores.danger);
                document.documentElement.style.setProperty('--system-info', colores.info);

                // También actualizar variables Bootstrap
                document.documentElement.style.setProperty('--bs-primary', colores.primary);
                document.documentElement.style.setProperty('--bs-secondary', colores.secondary);
                document.documentElement.style.setProperty('--bs-success', colores.success);
                document.documentElement.style.setProperty('--bs-warning', colores.warning);
                document.documentElement.style.setProperty('--bs-danger', colores.danger);
                document.documentElement.style.setProperty('--bs-info', colores.info);

                const style = document.createElement('style');
                style.textContent = `
                    .sidebar { background: ${colores.primary} !important; }
                    .btn-primary { background-color: ${colores.primary} !important; border-color: ${colores.primary} !important; }
                    .btn-secondary { background-color: ${colores.secondary} !important; border-color: ${colores.secondary} !important; }
                    .btn-success { background-color: ${colores.success} !important; border-color: ${colores.success} !important; }
                    .btn-warning { background-color: ${colores.warning} !important; border-color: ${colores.warning} !important; }
                    .btn-danger { background-color: ${colores.danger} !important; border-color: ${colores.danger} !important; }
                    .btn-info { background-color: ${colores.info} !important; border-color: ${colores.info} !important; }
                    .bg-primary { background-color: ${colores.primary} !important; }
                    .bg-secondary { background-color: ${colores.secondary} !important; }
                    .bg-success { background-color: ${colores.success} !important; }
                    .bg-warning { background-color: ${colores.warning} !important; }
                    .bg-danger { background-color: ${colores.danger} !important; }
                    .bg-info { background-color: ${colores.info} !important; }
                    .text-primary { color: ${colores.primary} !important; }
                    .text-secondary { color: ${colores.secondary} !important; }
                    .text-success { color: ${colores.success} !important; }
                    .text-warning { color: ${colores.warning} !important; }
                    .text-danger { color: ${colores.danger} !important; }
                    .text-info { color: ${colores.info} !important; }
                `;
                document.head.appendChild(style);
            } catch (e) {
                console.error('Error al aplicar colores iniciales:', e);
            }
        })();
    </script>
    
    <!-- Custom CSS -->
    <style>
        :root {
            --system-primary: #27DB9F;
            --system-secondary: #764ba2;
            --system-success: #28a745;
            --system-warning: #ffc107;
            --system-danger: #dc3545;
            --system-info: #17a2b8;
            --system-gradient: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-secondary) 100%);
        }
        
        body {
            background: var(--system-primary);
            min-height: 100vh;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 1040;
        }

        /* Aplicación de gradiente del sistema a encabezados y elementos comunes */
        .bg-gradient-primary,
        .module-header,
        .form-header,
        .preview-header,
        .card-header.bg-primary {
            background: var(--system-gradient) !important;
        }

        /* Borde superior y iconos de tarjetas estadísticas/avatares con gradiente dinámico */
        .stat-card::before,
        .stat-card .stat-card-icon,
        .avatar-circle {
            background: var(--system-gradient) !important;
        }
        /* Sidebar Moderno con Glassmorphism */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 300px;
            height: 100vh;
            background: linear-gradient(135deg, 
                rgba(30, 30, 46, 0.95) 0%, 
                rgba(44, 62, 80, 0.95) 25%,
                rgba(52, 73, 94, 0.95) 50%,
                rgba(44, 62, 80, 0.95) 75%,
                rgba(30, 30, 46, 0.95) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 
                0 25px 45px rgba(0, 0, 0, 0.2),
                0 0 0 1px rgba(255, 255, 255, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 20%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 226, 0.3) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .sidebar.collapsed {
            transform: translateX(-100%);
            box-shadow: none;
        }
        
        .sidebar-header {
            position: relative;
            padding: 2rem 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            backdrop-filter: blur(10px);
            z-index: 2;
        }
        
        .sidebar-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #27DB9F, transparent);
        }
        
        .sidebar-menu {
            padding: 1.5rem 0;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            max-height: calc(100vh - 140px);
            position: relative;
            z-index: 2;
            
            /* Scrollbar moderno */
            scrollbar-width: thin;
            scrollbar-color: rgba(39, 219, 159, 0.3) transparent;
        }
        
        /* Scrollbar personalizado para WebKit */
        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-menu::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, rgba(39, 219, 159, 0.5), rgba(39, 219, 159, 0.2));
            border-radius: 10px;
        }
        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, rgba(39, 219, 159, 0.8), rgba(39, 219, 159, 0.4));
        }
        
        /* Items del menú con diseño moderno */
        .sidebar-item {
            position: relative;
            margin: 0.25rem 1rem;
            padding: 1rem 1.25rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            font-weight: 500;
            letter-spacing: 0.5px;
            background: transparent;
            border: 1px solid transparent;
            overflow: hidden;
        }
        
        .sidebar-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s ease;
        }
        
        .sidebar-item:hover::before {
            left: 100%;
        }
        
        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            transform: translateX(8px) scale(1.02);
            border-color: rgba(39, 219, 159, 0.3);
            box-shadow: 
                0 8px 25px rgba(0, 0, 0, 0.15),
                0 0 20px rgba(39, 219, 159, 0.1);
            text-decoration: none;
        }
        
        .sidebar-item.active {
            background: linear-gradient(135deg, 
                rgba(39, 219, 159, 0.2) 0%, 
                rgba(39, 219, 159, 0.1) 100%);
            color: #ffffff;
            border-color: rgba(39, 219, 159, 0.5);
            box-shadow: 
                0 8px 25px rgba(39, 219, 159, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }
        
        .sidebar-item.active::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: linear-gradient(180deg, #27DB9F, #22c495);
            border-radius: 2px 0 0 2px;
        }
        
        .sidebar-item i {
            margin-right: 1rem;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        
        .sidebar-item:hover i {
            transform: scale(1.1);
            color: #27DB9F;
        }
        
        .sidebar-item.active i {
            color: #27DB9F;
        }
        
        /* Separadores de sección */
        .sidebar .text-muted {
            margin: 1.5rem 1rem 0.5rem 1rem !important;
            padding: 0.5rem 1.25rem !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 1.5px !important;
            color: rgba(255, 255, 255, 0.5) !important;
            background: rgba(255, 255, 255, 0.03) !important;
            border-radius: 8px !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            transition: all 0.3s ease !important;
        }
        
        .sidebar .text-muted:hover {
            transform: none !important;
            background: rgba(255, 255, 255, 0.05) !important;
            color: rgba(255, 255, 255, 0.7) !important;
        }
        .main-content {
            margin-left: 300px;
            padding: 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1;
        }
        .main-content.expanded {
            margin-left: 0;
        }
        .content-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .btn-custom {
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: #27DB9F;
            border: none;
            color: #ffffff;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(39, 219, 159, 0.3);
            background: #22c495;
        }
        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
        }
        .badge-estado {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 500;
        }
        /* Media queries específicas del layout ya están en responsive.css */
        
        /* Mejoras adicionales para el scroll */
        .sidebar-menu {
            /* Smooth scrolling */
            scroll-behavior: smooth;
        }
        
        /* Indicador visual de que hay más contenido abajo */
        .sidebar-menu::after {
            content: '';
            display: block;
            height: 1rem;
            background: linear-gradient(to bottom, transparent, rgba(39, 219, 159, 0.1));
            position: sticky;
            bottom: 0;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        /* Mostrar indicador cuando hay scroll disponible */
        .sidebar-menu.has-scroll::after {
            opacity: 1;
        }
        
        /* Ocultar indicador cuando se está en la parte inferior */
        .sidebar-menu.at-bottom::after {
            opacity: 0;
        }
        
        /* Animaciones de entrada para los items del menú */
        @keyframes slideInFromLeft {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .sidebar-item {
            animation: slideInFromLeft 0.3s ease forwards;
        }
        
        .sidebar-item:nth-child(1) { animation-delay: 0.1s; }
        .sidebar-item:nth-child(2) { animation-delay: 0.15s; }
        .sidebar-item:nth-child(3) { animation-delay: 0.2s; }
        .sidebar-item:nth-child(4) { animation-delay: 0.25s; }
        .sidebar-item:nth-child(5) { animation-delay: 0.3s; }
        .sidebar-item:nth-child(6) { animation-delay: 0.35s; }
        .sidebar-item:nth-child(7) { animation-delay: 0.4s; }
        .sidebar-item:nth-child(8) { animation-delay: 0.45s; }
        .sidebar-item:nth-child(9) { animation-delay: 0.5s; }
        .sidebar-item:nth-child(10) { animation-delay: 0.55s; }
        
        /* Estilos para el dropdown del usuario */
        .dropdown-menu {
            z-index: 1050;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-radius: 10px;
            min-width: 250px;
            padding: 0.75rem 0;
            margin-top: 0.5rem;
        }
        
        .dropdown-header {
            padding: 0.75rem 1rem;
            background: #27DB9F;
            margin: -0.75rem -0rem 0.5rem -0rem;
            border-radius: 10px 10px 0 0;
            color: #ffffff;
            border-bottom: 1px solid rgba(39, 219, 159, 0.2);
        }
        
        .dropdown-item {
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        
        .dropdown-item:hover, .dropdown-item:focus {
            background: rgba(39, 219, 159, 0.1);
            color: #27DB9F;
            transform: translateX(5px);
        }
        
        .dropdown-item.text-danger:hover {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        .dropdown-toggle::after {
            margin-left: 0.5rem;
        }
        
        /* Asegurar que el navbar no corte el dropdown */
        .navbar .container-fluid {
            overflow: visible;
        }
        
        .main-content {
            overflow: visible;
        }
        
        /* Estilos adicionales para el botón del usuario */
        .user-dropdown-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(39, 219, 159, 0.3);
            color: #27DB9F;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .user-dropdown-btn:hover {
            background: rgba(39, 219, 159, 0.1);
            border-color: #27DB9F;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(39, 219, 159, 0.2);
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Navbar móvil -->
    <nav class="navbar navbar-expand-lg d-lg-none" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); position: fixed; top: 0; left: 0; right: 0; z-index: 9999;">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="{{ route('dashboard') }}">
                <img src="{{ asset('images/Imagen_de_WhatsApp_2025-08-10_a_las_17.56.17_0b0e759c-removebg-preview.png') }}" 
                     alt="Logo" 
                     style="max-height: 35px; max-width: 120px; object-fit: contain; margin-right: 0.5rem;">
                <span class="fw-bold">HDC</span>
            </a>
            
            <button class="navbar-toggler" type="button" onclick="toggleSidebar()" aria-label="Abrir menú">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="dropdown ms-auto">
                <button class="btn user-dropdown-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user me-2"></i>
                    {{ auth()->user()->name ?? 'Usuario' }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">{{ auth()->user()->name ?? 'Usuario' }}</h6></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Perfil</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Configuración</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Overlay para cerrar sidebar en móvil -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="d-flex align-items-center justify-content-center mb-2">
                <img src="{{ asset('images/Imagen_de_WhatsApp_2025-08-10_a_las_17.56.17_0b0e759c-removebg-preview.png') }}" 
                     alt="Logo" 
                     style="max-height: 50px; max-width: 200px; object-fit: contain;">
            </div>
            <h5 class="mb-0 text-center text-white">Gestión HDC</h5>
            <small class="text-muted d-block text-center">Sistema de Gestión Integral</small>
        </div>
        
        <div class="sidebar-menu">
            @php
                $modules = \App\Helpers\PermissionHelper::getAvailableModules();
            @endphp
            
            <!-- Dashboard -->
            @if(isset($modules['dashboard']))
            <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            @endif
            
            <!-- Clientes -->
            @if(isset($modules['clientes']))
            <a href="{{ route('clientes.index') }}" class="sidebar-item {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                Clientes
            </a>
            @endif
            
            <!-- Equipos y Reparaciones -->
            @if(isset($modules['equipos']) || isset($modules['reparaciones']))
            <div class="sidebar-item text-muted small fw-bold mt-3 mb-2">
                <i class="fas fa-laptop me-2"></i>EQUIPOS Y REPARACIONES
            </div>
            @endif
            
            @if(isset($modules['equipos']))
            <a href="{{ route('equipos.index') }}" class="sidebar-item {{ request()->routeIs('equipos.*') ? 'active' : '' }}">
                <i class="fas fa-laptop"></i>
                Gestión de Equipos
            </a>
            @endif
            
            @if(isset($modules['reparaciones']))
            <a href="{{ route('reparaciones.index') }}" class="sidebar-item {{ request()->routeIs('reparaciones.*') ? 'active' : '' }}">
                <i class="fas fa-wrench"></i>
                Gestión de Reparaciones
            </a>
            <a href="{{ route('reparaciones.mis-tareas') }}" class="sidebar-item {{ request()->routeIs('reparaciones.mis-tareas') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i>
                Mis Tareas
            </a>
            @endif
            
            <!-- Inventario -->
            @if(isset($modules['inventario']))
            <a href="{{ route('inventario.index') }}" class="sidebar-item {{ request()->routeIs('inventario.*') ? 'active' : '' }}">
                <i class="fas fa-boxes"></i>
                Inventario
            </a>
            @endif
            
            <!-- Tickets -->
            @if(isset($modules['tickets']))
            <a href="{{ route('tickets.index') }}" class="sidebar-item {{ request()->routeIs('tickets.*') ? 'active' : '' }}">
                <i class="fas fa-ticket-alt"></i>
                Tickets
            </a>
            @endif
            
            <!-- Técnicos / Usuarios -->
            @if(isset($modules['tecnicos']) || isset($modules['usuarios']))
            <div class="sidebar-item text-muted small fw-bold mt-3 mb-2">
                <i class="fas fa-user-cog me-2"></i>TÉCNICOS / USUARIOS
            </div>
            @endif
            
            @if(isset($modules['tecnicos']))
            <a href="{{ route('tecnicos.index') }}" class="sidebar-item {{ request()->routeIs('tecnicos.*') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i>
                Gestión de Técnicos
            </a>
            <a href="{{ route('tecnicos.carga-trabajo') }}" class="sidebar-item {{ request()->routeIs('tecnicos.carga-trabajo') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                Carga de Trabajo
            </a>
            @endif
            
            @if(isset($modules['usuarios']))
            <a href="{{ route('usuarios.index') }}" class="sidebar-item {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                Gestión de Usuarios
            </a>
            @endif
            
            <!-- Reportes -->
            @if(\App\Helpers\PermissionHelper::can('view_reports'))
            <a href="#" class="sidebar-item" onclick="mostrarProximamente('Reportes')">
                <i class="fas fa-chart-line"></i>
                Reportes
            </a>
            @endif
            
            <!-- Configuración -->
            @if(isset($modules['configuracion']))
            <a href="{{ route('configuracion.index') }}" class="sidebar-item {{ request()->routeIs('configuracion.*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                Configuración
            </a>
            @endif
        </div>
    </div>

    <!-- Overlay para cerrar sidebar en móvil -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light mb-4">
            <div class="container-fluid">
                <button class="btn btn-outline-primary me-3 navbar-toggler" id="sidebarToggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="d-flex align-items-center ms-auto">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center user-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(auth()->user()->avatar_url)
                                <img src="{{ auth()->user()->avatar_url }}" 
                                     alt="Avatar" 
                                     class="rounded-circle me-2"
                                     style="width: 32px; height: 32px; object-fit: cover;">
                            @else
                                <div class="text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                     style="width: 32px; height: 32px; font-size: 0.875rem; background: #27DB9F;">
                                    {{ auth()->user()->iniciales }}
                                </div>
                            @endif
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                            <span class="d-md-none">Cuenta</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li class="dropdown-header">
                                <div class="d-flex align-items-center">
                                    @if(auth()->user()->avatar_url)
                                        <img src="{{ auth()->user()->avatar_url }}" 
                                             alt="Avatar" 
                                             class="rounded-circle me-2"
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                             style="width: 40px; height: 40px; font-size: 1rem; background: #27DB9F;">
                                            {{ auth()->user()->iniciales }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ auth()->user()->name }}</div>
                                        <small class="text-muted">{{ auth()->user()->email }}</small>
                                        <small class="badge bg-{{ auth()->user()->estado_color }}">{{ auth()->user()->rol_label }}</small>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('perfil') }}">
                                    <i class="fas fa-user-cog me-2" style="color: #27DB9F;"></i> 
                                    Mi Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2" style="color: #27DB9F;"></i> 
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('reparaciones.mis-tareas') }}">
                                    <i class="fas fa-tasks me-2" style="color: #27DB9F;"></i> 
                                    Mis Tareas
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item d-flex align-items-center text-danger" onclick="return confirm('¿Estás seguro de que deseas cerrar sesión?')">
                                        <i class="fas fa-sign-out-alt me-2"></i> 
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="content-card p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts para navegación móvil -->
    <script>
        // Manejo del sidebar móvil
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
            
            // Prevenir scroll del body cuando el sidebar está abierto
            if (sidebar.classList.contains('show')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }
        
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }
        
        // Cerrar sidebar al hacer clic en un enlace (móvil)
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('.sidebar-item');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        closeSidebar();
                    }
                });
            });
            
            // Cerrar sidebar al redimensionar ventana
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    closeSidebar();
                }
            });
            
            // Detectar swipe para cerrar sidebar
            let startX = 0;
            let currentX = 0;
            let sidebarElement = document.getElementById('sidebar');
            
            sidebarElement.addEventListener('touchstart', function(e) {
                startX = e.touches[0].clientX;
            });
            
            sidebarElement.addEventListener('touchmove', function(e) {
                currentX = e.touches[0].clientX;
                const diffX = startX - currentX;
                
                // Si el swipe es hacia la izquierda y suficiente
                if (diffX > 50) {
                    closeSidebar();
                }
            });
        });
    </script>
    
    <!-- Sistema de eliminación unificado -->
    <script src="{{ asset('js/eliminacion.js') }}"></script>
    
    <!-- Sistema de tablas móviles -->
    <script src="{{ asset('js/mobile-tables.js') }}"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Sidebar toggle mejorado para móviles
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const overlay = document.getElementById('sidebarOverlay');
            
            // En móviles usar show/hide, en desktop usar collapsed/expanded
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            }
        });

        // Cerrar sidebar al hacer click en el overlay
        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        });

        // Cerrar sidebar al redimensionar ventana
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        });

        // Asegurar que el dropdown del usuario esté siempre visible
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.querySelector('.dropdown');
            const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
            const dropdownMenu = dropdown.querySelector('.dropdown-menu');
            
            // Forzar la visibilidad del dropdown
            dropdownToggle.style.visibility = 'visible';
            dropdownToggle.style.opacity = '1';
            dropdownToggle.style.pointerEvents = 'auto';
            
            // Ajustar posición del dropdown menu cuando se abra
            dropdownToggle.addEventListener('click', function() {
                setTimeout(() => {
                    if (dropdownMenu.classList.contains('show')) {
                        dropdownMenu.style.position = 'absolute';
                        dropdownMenu.style.top = '100%';
                        dropdownMenu.style.right = '0';
                        dropdownMenu.style.left = 'auto';
                        dropdownMenu.style.zIndex = '1050';
                    }
                }, 10);
            });
        });

        // Función para detectar si el sidebar menu tiene scroll disponible
        function checkSidebarScroll() {
            const sidebarMenu = document.querySelector('.sidebar-menu');
            if (sidebarMenu) {
                const hasScroll = sidebarMenu.scrollHeight > sidebarMenu.clientHeight;
                
                if (hasScroll) {
                    sidebarMenu.classList.add('has-scroll');
                } else {
                    sidebarMenu.classList.remove('has-scroll');
                }
                
                // Agregar evento de scroll para efectos adicionales
                sidebarMenu.addEventListener('scroll', function() {
                    const scrollTop = this.scrollTop;
                    const scrollHeight = this.scrollHeight;
                    const clientHeight = this.clientHeight;
                    
                    // Agregar sombra en la parte superior cuando se hace scroll hacia abajo
                    if (scrollTop > 10) {
                        this.style.boxShadow = 'inset 0 10px 10px -10px rgba(0, 0, 0, 0.1)';
                    } else {
                        this.style.boxShadow = 'none';
                    }
                    
                    // Ocultar el indicador inferior cuando se llega al final
                    const isAtBottom = Math.abs(scrollHeight - clientHeight - scrollTop) < 3;
                    if (isAtBottom) {
                        this.classList.add('at-bottom');
                    } else {
                        this.classList.remove('at-bottom');
                    }
                });
            }
        }

        // Ejecutar al cargar la página
        document.addEventListener('DOMContentLoaded', checkSidebarScroll);
        
        // Ejecutar cuando se redimensiona la ventana
        window.addEventListener('resize', checkSidebarScroll);

        // CSRF token setup for AJAX
        if (typeof $ !== 'undefined') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        // Función para mostrar módulos próximamente
        function mostrarProximamente(modulo) {
            // Crear modal dinámico
            const modalHTML = `
                <div class="modal fade" id="proximamenteModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header text-white" style="background: #27DB9F;">
                                <h5 class="modal-title">
                                    <i class="fas fa-rocket me-2"></i>
                                    Módulo en Desarrollo
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-cogs display-1 mb-3" style="color: #27DB9F;"></i>
                                </div>
                                <h4 style="color: #27DB9F;">${modulo}</h4>
                                <p class="text-muted mb-3">
                                    Este módulo está siendo desarrollado y estará disponible próximamente.
                                </p>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Mientras tanto, puedes usar los módulos de <strong>Equipos y Reparaciones</strong> que están completamente funcionales.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn text-white" style="background: #27DB9F;" data-bs-dismiss="modal">
                                    <i class="fas fa-check me-2"></i>Entendido
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Eliminar modal anterior si existe
            const existingModal = document.getElementById('proximamenteModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // Agregar modal al body
            document.body.insertAdjacentHTML('beforeend', modalHTML);
            
            // Mostrar modal
            const modal = new bootstrap.Modal(document.getElementById('proximamenteModal'));
            modal.show();
            
            // Limpiar modal al cerrarse
            document.getElementById('proximamenteModal').addEventListener('hidden.bs.modal', function() {
                this.remove();
            });
        }
    </script>
    
    <!-- Modal universal de eliminación -->
    <div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true" style="z-index: 1055;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="eliminarModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Confirmar Eliminación
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                        <h6>¿Estás seguro de que deseas eliminar este elemento?</h6>
                        <p class="fw-bold text-danger" id="clienteNombre"></p>
                    </div>
                    <div class="alert alert-warning border-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Advertencia:</strong> Esta acción no se puede deshacer y eliminará permanentemente toda la información.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" id="btnEliminarConfirmar">
                        <i class="fas fa-trash me-2"></i>Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario oculto para eliminación -->
    <form id="eliminarForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Script global para aplicación de colores del sistema -->
    <script>
        // Función global para aplicar colores al sistema
        function aplicarColoresGlobales(colores) {
            console.log('Aplicando colores globales:', colores);
            
            // Crear o actualizar CSS variables con aplicación global
            const style = document.createElement('style');
            style.id = 'global-theme-styles';
            style.textContent = `
                :root {
                    --bs-primary: ${colores.primary} !important;
                    --bs-secondary: ${colores.secondary} !important;
                    --bs-success: ${colores.success} !important;
                    --bs-warning: ${colores.warning} !important;
                    --bs-danger: ${colores.danger} !important;
                    --bs-info: ${colores.info} !important;
                }
                
                /* Aplicación global de colores de fondo */
                .bg-primary, .bg-primary * { background-color: ${colores.primary} !important; }
                .bg-secondary, .bg-secondary * { background-color: ${colores.secondary} !important; }
                .bg-success, .bg-success * { background-color: ${colores.success} !important; }
                .bg-warning, .bg-warning * { background-color: ${colores.warning} !important; }
                .bg-danger, .bg-danger * { background-color: ${colores.danger} !important; }
                .bg-info, .bg-info * { background-color: ${colores.info} !important; }
                
                /* Aplicación global de colores de texto */
                .text-primary, .text-primary * { color: ${colores.primary} !important; }
                .text-secondary, .text-secondary * { color: ${colores.secondary} !important; }
                .text-success, .text-success * { color: ${colores.success} !important; }
                .text-warning, .text-warning * { color: ${colores.warning} !important; }
                .text-danger, .text-danger * { color: ${colores.danger} !important; }
                .text-info, .text-info * { color: ${colores.info} !important; }
                
                /* Aplicación global de botones */
                .btn-primary { 
                    background-color: ${colores.primary} !important; 
                    border-color: ${colores.primary} !important; 
                }
                .btn-secondary { 
                    background-color: ${colores.secondary} !important; 
                    border-color: ${colores.secondary} !important; 
                }
                .btn-success { 
                    background-color: ${colores.success} !important; 
                    border-color: ${colores.success} !important; 
                }
                .btn-warning { 
                    background-color: ${colores.warning} !important; 
                    border-color: ${colores.warning} !important; 
                }
                .btn-danger { 
                    background-color: ${colores.danger} !important; 
                    border-color: ${colores.danger} !important; 
                }
                .btn-info { 
                    background-color: ${colores.info} !important; 
                    border-color: ${colores.info} !important; 
                }
                
                /* Aplicación global de elementos de navegación */
                .navbar, .navbar * { background: rgba(255, 255, 255, 0.95) !important; }
                .sidebar, .sidebar * { background: ${colores.primary} !important; }
                .nav-link.active, .nav-link.active * { background-color: ${colores.primary} !important; color: white !important; }
                
                /* Aplicación global de badges */
                .badge.bg-primary { background-color: ${colores.primary} !important; }
                .badge.bg-secondary { background-color: ${colores.secondary} !important; }
                .badge.bg-success { background-color: ${colores.success} !important; }
                .badge.bg-warning { background-color: ${colores.warning} !important; }
                .badge.bg-danger { background-color: ${colores.danger} !important; }
                .badge.bg-info { background-color: ${colores.info} !important; }
                
                /* Aplicación global de alertas */
                .alert-primary { background-color: ${colores.primary} !important; border-color: ${colores.primary} !important; }
                .alert-secondary { background-color: ${colores.secondary} !important; border-color: ${colores.secondary} !important; }
                .alert-success { background-color: ${colores.success} !important; border-color: ${colores.success} !important; }
                .alert-warning { background-color: ${colores.warning} !important; border-color: ${colores.warning} !important; }
                .alert-danger { background-color: ${colores.danger} !important; border-color: ${colores.danger} !important; }
                .alert-info { background-color: ${colores.info} !important; border-color: ${colores.info} !important; }
                
                /* Aplicación global de bordes */
                .border-primary { border-color: ${colores.primary} !important; }
                .border-secondary { border-color: ${colores.secondary} !important; }
                .border-success { border-color: ${colores.success} !important; }
                .border-warning { border-color: ${colores.warning} !important; }
                .border-danger { border-color: ${colores.danger} !important; }
                .border-info { border-color: ${colores.info} !important; }
                
                /* Aplicación global de hover effects */
                .btn-primary:hover { background-color: ${colores.primary} !important; opacity: 0.9; }
                .btn-secondary:hover { background-color: ${colores.secondary} !important; opacity: 0.9; }
                .btn-success:hover { background-color: ${colores.success} !important; opacity: 0.9; }
                .btn-warning:hover { background-color: ${colores.warning} !important; opacity: 0.9; }
                .btn-danger:hover { background-color: ${colores.danger} !important; opacity: 0.9; }
                .btn-info:hover { background-color: ${colores.info} !important; opacity: 0.9; }
                
                /* Aplicación global de elementos específicos del sistema */
                .card-header.bg-primary { background-color: ${colores.primary} !important; }
                .card-header.bg-secondary { background-color: ${colores.secondary} !important; }
                .card-header.bg-success { background-color: ${colores.success} !important; }
                .card-header.bg-warning { background-color: ${colores.warning} !important; }
                .card-header.bg-danger { background-color: ${colores.danger} !important; }
                .card-header.bg-info { background-color: ${colores.info} !important; }
                
                /* Aplicación global de progress bars */
                .progress-bar.bg-primary { background-color: ${colores.primary} !important; }
                .progress-bar.bg-secondary { background-color: ${colores.secondary} !important; }
                .progress-bar.bg-success { background-color: ${colores.success} !important; }
                .progress-bar.bg-warning { background-color: ${colores.warning} !important; }
                .progress-bar.bg-danger { background-color: ${colores.danger} !important; }
                .progress-bar.bg-info { background-color: ${colores.info} !important; }
                
                /* Aplicación global de list group items */
                .list-group-item.list-group-item-primary { background-color: ${colores.primary} !important; color: white !important; }
                .list-group-item.list-group-item-secondary { background-color: ${colores.secondary} !important; color: white !important; }
                .list-group-item.list-group-item-success { background-color: ${colores.success} !important; color: white !important; }
                .list-group-item.list-group-item-warning { background-color: ${colores.warning} !important; color: white !important; }
                .list-group-item.list-group-item-danger { background-color: ${colores.danger} !important; color: white !important; }
                .list-group-item.list-group-item-info { background-color: ${colores.info} !important; color: white !important; }
                
                /* Aplicación global de tooltips */
                .tooltip-inner { background-color: ${colores.primary} !important; }
                
                /* Aplicación global de dropdowns */
                .dropdown-item.active, .dropdown-item:active { background-color: ${colores.primary} !important; }
                
                /* Aplicación global de pagination */
                .page-item.active .page-link { background-color: ${colores.primary} !important; border-color: ${colores.primary} !important; }
                
                /* Aplicación global de form controls */
                .form-control:focus { border-color: ${colores.primary} !important; box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important; }
                .form-select:focus { border-color: ${colores.primary} !important; box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important; }
                
                /* Aplicación global de custom checkboxes y radios */
                .form-check-input:checked { background-color: ${colores.primary} !important; border-color: ${colores.primary} !important; }
                
                /* Aplicación global de switches */
                .form-check-input:checked { background-color: ${colores.primary} !important; border-color: ${colores.primary} !important; }
                
                /* Aplicación global de spinners */
                .spinner-border.text-primary { color: ${colores.primary} !important; }
                .spinner-border.text-secondary { color: ${colores.secondary} !important; }
                .spinner-border.text-success { color: ${colores.success} !important; }
                .spinner-border.text-warning { color: ${colores.warning} !important; }
                .spinner-border.text-danger { color: ${colores.danger} !important; }
                .spinner-border.text-info { color: ${colores.info} !important; }
                
                /* Aplicación específica para el sidebar del sistema */
                .sidebar { background: ${colores.primary} !important; }
                .sidebar-item:hover { background: rgba(255, 255, 255, 0.2) !important; }
                .sidebar-item.active { background: rgba(255, 255, 255, 0.25) !important; }
                
                /* Aplicación específica para el body */
                body { background: ${colores.primary} !important; }
                
                /* Sobrescribir estilos estáticos del sistema */
                body { background: ${colores.primary} !important; }
                .sidebar { background: ${colores.primary} !important; }
                .sidebar-item:hover { background: rgba(255, 255, 255, 0.2) !important; }
                .sidebar-item.active { background: rgba(255, 255, 255, 0.25) !important; }
                
                /* Prevenir cambios de color durante transiciones */
                * { transition: none !important; }
                .btn, .card, .sidebar, .navbar, body { transition: none !important; }
                
                /* Forzar colores en elementos específicos del sistema */
                .btn-custom { background-color: inherit !important; }
                .card { background-color: inherit !important; }
            `;
            
            // Remover estilos anteriores si existen
            const existingStyle = document.getElementById('global-theme-styles');
            if (existingStyle) {
                existingStyle.remove();
            }
            
            // Agregar nuevos estilos al head del documento con alta prioridad
            document.head.insertBefore(style, document.head.firstChild);
            
            // Forzar actualización de todos los elementos
            document.querySelectorAll('*').forEach(element => {
                element.style.setProperty('--bs-primary', colores.primary);
                element.style.setProperty('--bs-secondary', colores.secondary);
                element.style.setProperty('--bs-success', colores.success);
                element.style.setProperty('--bs-warning', colores.warning);
                element.style.setProperty('--bs-danger', colores.danger);
                element.style.setProperty('--bs-info', colores.info);
            });
            
            console.log('Colores globales aplicados correctamente');
        }
        
        // Cargar colores inmediatamente al cargar la página (sin esperar DOMContentLoaded)
        (function() {
            console.log('Cargando colores globales del sistema inmediatamente...');
            
            // Intentar cargar desde localStorage primero para evitar parpadeo
            const coloresGuardados = localStorage.getItem('sistemaColores');
            if (coloresGuardados) {
                try {
                    const colores = JSON.parse(coloresGuardados);
                    aplicarColoresGlobales(colores);
                    console.log('Colores del localStorage aplicados inmediatamente');
                } catch (e) {
                    console.error('Error al parsear colores del localStorage:', e);
                }
            }
            
            // Luego intentar cargar desde el backend
            fetch('/configuracion/colores')
                .then(response => {
                    console.log('Respuesta del servidor:', response);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(colores => {
                    console.log('Colores recibidos del backend:', colores);
                    if (colores && Object.keys(colores).length > 0) {
                        aplicarColoresGlobales(colores);
                        localStorage.setItem('sistemaColores', JSON.stringify(colores));
                        console.log('Colores del backend aplicados globalmente');
                    }
                })
                .catch(error => {
                    console.error('Error al cargar colores del backend:', error);
                });
        })();
        
        // También cargar en DOMContentLoaded como respaldo
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOMContentLoaded - verificando colores...');
            
            // Solo aplicar si no se han aplicado ya
            if (!document.getElementById('global-theme-styles')) {
                const coloresGuardados = localStorage.getItem('sistemaColores');
                if (coloresGuardados) {
                    try {
                        const colores = JSON.parse(coloresGuardados);
                        aplicarColoresGlobales(colores);
                        console.log('Colores aplicados en DOMContentLoaded');
                    } catch (e) {
                        console.error('Error al parsear colores:', e);
                    }
                }
            }
        });
    </script>

    @yield('scripts')
</body>
</html>