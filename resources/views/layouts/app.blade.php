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
    <!-- Script para aplicar colores inmediatamente -->
    <script>
        // Aplicar colores inmediatamente al cargar la página
        (function() {
            const coloresGuardados = localStorage.getItem('sistemaColores');
            if (coloresGuardados) {
                try {
                    const colores = JSON.parse(coloresGuardados);
                    
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
                        body { background: ${colores.primary} !important; }
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
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: var(--system-primary);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(39, 219, 159, 0.2);
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
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .sidebar-menu {
            padding: 1rem 0;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            max-height: calc(100vh - 120px);
            /* Scrollbar personalizado */
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
        }
        /* Scrollbar para WebKit browsers (Chrome, Safari, Edge) */
        .sidebar-menu::-webkit-scrollbar {
            width: 8px;
        }
        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
            border-radius: 10px;
        }
        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            border: 2px solid transparent;
            background-clip: content-box;
        }
        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
            background-clip: content-box;
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
            background: rgba(255, 255, 255, 0.25);
            color: #ffffff;
            border-left-color: #ffffff;
        }
        .sidebar-item i {
            width: 20px;
            margin-right: 10px;
        }
        .sidebar .text-muted {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
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
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 300px; /* Ancho ligeramente mayor en móviles */
            }
            .sidebar-menu {
                max-height: calc(100vh - 100px); /* Más espacio para scroll en móviles */
            }
            .main-content {
                margin-left: 0;
            }
        }
        
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
            background: linear-gradient(to bottom, transparent, rgba(242, 174, 78, 0.1));
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
            @if(\App\Helpers\PermissionHelper::can('create_equipo'))
            <a href="{{ route('equipos.create') }}" class="sidebar-item {{ request()->routeIs('equipos.create') ? 'active' : '' }}">
                <i class="fas fa-plus-circle"></i>
                Nuevo Equipo
            </a>
            @endif
            @endif
            
            @if(isset($modules['reparaciones']))
            <a href="{{ route('reparaciones.index') }}" class="sidebar-item {{ request()->routeIs('reparaciones.*') ? 'active' : '' }}">
                <i class="fas fa-wrench"></i>
                Gestión de Reparaciones
            </a>
            @if(\App\Helpers\PermissionHelper::can('create_reparacion'))
            <a href="{{ route('reparaciones.create') }}" class="sidebar-item {{ request()->routeIs('reparaciones.create') ? 'active' : '' }}">
                <i class="fas fa-tools"></i>
                Nueva Reparación
            </a>
            @endif
            @if(auth()->user()->esTecnico())
            <a href="{{ route('reparaciones.mis-tareas') }}" class="sidebar-item {{ request()->routeIs('reparaciones.mis-tareas') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i>
                Mis Tareas
            </a>
            @endif
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
            @if(\App\Helpers\PermissionHelper::can('manage_tecnicos'))
            <a href="{{ route('tecnicos.create') }}" class="sidebar-item {{ request()->routeIs('tecnicos.create') ? 'active' : '' }}">
                <i class="fas fa-user-plus"></i>
                Nuevo Técnico
            </a>
            <a href="{{ route('tecnicos.carga-trabajo') }}" class="sidebar-item {{ request()->routeIs('tecnicos.carga-trabajo') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                Carga de Trabajo
            </a>
            @endif
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

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light mb-4">
            <div class="container-fluid">
                <button class="btn btn-outline-primary me-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="d-flex align-items-center ms-auto">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center user-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                 style="width: 32px; height: 32px; font-size: 0.875rem; background: #27DB9F;">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                            <span class="d-md-none">Cuenta</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li class="dropdown-header">
                                <div class="d-flex align-items-center">
                                    <div class="text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                         style="width: 24px; height: 24px; font-size: 0.75rem; background: #27DB9F;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ auth()->user()->name }}</div>
                                        <small class="text-muted">{{ auth()->user()->email }}</small>
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
                            @if(auth()->user()->esTecnico())
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('reparaciones.mis-tareas') }}">
                                    <i class="fas fa-tasks me-2" style="color: #27DB9F;"></i> 
                                    Mis Tareas
                                </a>
                            </li>
                            @endif
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
    
    <!-- Sistema de eliminación unificado -->
    <script src="{{ asset('js/eliminacion.js') }}"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Sidebar toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
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