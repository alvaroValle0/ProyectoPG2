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
    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(135deg, #F2AE4E 0%, #E89A3A 100%);
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
            background: rgba(242, 174, 78, 0.95);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(242, 174, 78, 0.2);
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
            background: linear-gradient(45deg, #F2AE4E, #E89A3A);
            border: none;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(242, 174, 78, 0.3);
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
            background: linear-gradient(45deg, #F2AE4E, #E89A3A);
            margin: -0.75rem -0rem 0.5rem -0rem;
            border-radius: 10px 10px 0 0;
            color: white;
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
            background: rgba(242, 174, 78, 0.1);
            color: #F2AE4E;
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
            border: 2px solid rgba(242, 174, 78, 0.3);
            color: #F2AE4E;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .user-dropdown-btn:hover {
            background: rgba(242, 174, 78, 0.1);
            border-color: #F2AE4E;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(242, 174, 78, 0.2);
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
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            
            <!-- Clientes -->
            <a href="{{ route('clientes.index') }}" class="sidebar-item {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                Clientes
            </a>
            
            <!-- Equipos y Reparaciones -->
            <div class="sidebar-item text-muted small fw-bold mt-3 mb-2">
                <i class="fas fa-laptop me-2"></i>EQUIPOS Y REPARACIONES
            </div>
            <a href="{{ route('equipos.index') }}" class="sidebar-item {{ request()->routeIs('equipos.*') ? 'active' : '' }}">
                <i class="fas fa-laptop"></i>
                Gestión de Equipos
            </a>
            <a href="{{ route('equipos.create') }}" class="sidebar-item {{ request()->routeIs('equipos.create') ? 'active' : '' }}">
                <i class="fas fa-plus-circle"></i>
                Nuevo Equipo
            </a>
            <a href="{{ route('reparaciones.index') }}" class="sidebar-item {{ request()->routeIs('reparaciones.*') ? 'active' : '' }}">
                <i class="fas fa-wrench"></i>
                Gestión de Reparaciones
            </a>
            <a href="{{ route('reparaciones.create') }}" class="sidebar-item {{ request()->routeIs('reparaciones.create') ? 'active' : '' }}">
                <i class="fas fa-tools"></i>
                Nueva Reparación
            </a>
            @if(auth()->user()->esTecnico())
            <a href="{{ route('reparaciones.mis-tareas') }}" class="sidebar-item {{ request()->routeIs('reparaciones.mis-tareas') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i>
                Mis Tareas
            </a>
            @endif
            
            <!-- Inventario -->
            <a href="#" class="sidebar-item" onclick="mostrarProximamente('Inventario')">
                <i class="fas fa-boxes"></i>
                Inventario
            </a>
            
            <!-- Proveedores -->
            <a href="#" class="sidebar-item" onclick="mostrarProximamente('Proveedores')">
                <i class="fas fa-truck"></i>
                Proveedores
            </a>
            
            <!-- Tickets -->
            <a href="{{ route('tickets.index') }}" class="sidebar-item {{ request()->routeIs('tickets.*') ? 'active' : '' }}">
                <i class="fas fa-ticket-alt"></i>
                Tickets
            </a>
            
            <!-- Técnicos / Usuarios -->
            <div class="sidebar-item text-muted small fw-bold mt-3 mb-2">
                <i class="fas fa-user-cog me-2"></i>TÉCNICOS / USUARIOS
            </div>
            <a href="{{ route('tecnicos.index') }}" class="sidebar-item {{ request()->routeIs('tecnicos.*') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i>
                Gestión de Técnicos
            </a>
            <a href="{{ route('tecnicos.create') }}" class="sidebar-item {{ request()->routeIs('tecnicos.create') ? 'active' : '' }}">
                <i class="fas fa-user-plus"></i>
                Nuevo Técnico
            </a>
            <a href="{{ route('tecnicos.carga-trabajo') }}" class="sidebar-item {{ request()->routeIs('tecnicos.carga-trabajo') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                Carga de Trabajo
            </a>
            <a href="{{ route('usuarios.index') }}" class="sidebar-item {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                Gestión de Usuarios
            </a>
            
            <!-- Reportes -->
            <a href="#" class="sidebar-item" onclick="mostrarProximamente('Reportes')">
                <i class="fas fa-chart-line"></i>
                Reportes
            </a>
            
            <!-- Facturación -->
            <a href="#" class="sidebar-item" onclick="mostrarProximamente('Facturación')">
                <i class="fas fa-file-invoice"></i>
                Facturación
            </a>
            
            <!-- Agenda -->
            <a href="#" class="sidebar-item" onclick="mostrarProximamente('Agenda')">
                <i class="fas fa-calendar-alt"></i>
                Agenda
            </a>
            
            <!-- Configuración -->
            <a href="#" class="sidebar-item" onclick="mostrarProximamente('Configuración')">
                <i class="fas fa-cog"></i>
                Configuración
            </a>
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
                                 style="width: 32px; height: 32px; font-size: 0.875rem; background: linear-gradient(45deg, #F2AE4E, #E89A3A);">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                            <span class="d-md-none">Cuenta</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li class="dropdown-header">
                                <div class="d-flex align-items-center">
                                    <div class="text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                         style="width: 24px; height: 24px; font-size: 0.75rem; background: linear-gradient(45deg, #F2AE4E, #E89A3A);">
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
                                    <i class="fas fa-user-cog me-2" style="color: #F2AE4E;"></i> 
                                    Mi Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2" style="color: #F2AE4E;"></i> 
                                    Dashboard
                                </a>
                            </li>
                            @if(auth()->user()->esTecnico())
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('reparaciones.mis-tareas') }}">
                                    <i class="fas fa-tasks me-2" style="color: #F2AE4E;"></i> 
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
                            <div class="modal-header text-white" style="background: linear-gradient(45deg, #F2AE4E, #E89A3A);">
                                <h5 class="modal-title">
                                    <i class="fas fa-rocket me-2"></i>
                                    Módulo en Desarrollo
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-cogs display-1 mb-3" style="color: #F2AE4E;"></i>
                                </div>
                                <h4 style="color: #F2AE4E;">${modulo}</h4>
                                <p class="text-muted mb-3">
                                    Este módulo está siendo desarrollado y estará disponible próximamente.
                                </p>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Mientras tanto, puedes usar los módulos de <strong>Equipos y Reparaciones</strong> que están completamente funcionales.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn text-white" style="background: linear-gradient(45deg, #F2AE4E, #E89A3A);" data-bs-dismiss="modal">
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
    
    @yield('scripts')
</body>
</html>