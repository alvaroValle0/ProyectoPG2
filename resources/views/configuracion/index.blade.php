@extends('layouts.app')

@section('title', 'Configuración del Sistema')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-cog text-primary me-2"></i>
            Configuración del Sistema
        </h1>
        <p class="text-muted">Administra la configuración general del sistema</p>
    </div>
</div>

<!-- Estadísticas del Sistema -->
<div class="row mb-4">
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card border-0 bg-primary text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-users display-6 mb-2"></i>
                <h4>{{ $estadisticas['total_usuarios'] }}</h4>
                <p class="mb-0">Usuarios</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card border-0 bg-success text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-laptop display-6 mb-2"></i>
                <h4>{{ $estadisticas['total_equipos'] }}</h4>
                <p class="mb-0">Equipos</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card border-0 bg-warning text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-wrench display-6 mb-2"></i>
                <h4>{{ $estadisticas['reparaciones_pendientes'] }}</h4>
                <p class="mb-0">Pendientes</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card border-0 bg-info text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-user-cog display-6 mb-2"></i>
                <h4>{{ $estadisticas['tecnicos_activos'] }}</h4>
                <p class="mb-0">Técnicos</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card border-0 bg-secondary text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-user-friends display-6 mb-2"></i>
                <h4>{{ $estadisticas['clientes_activos'] }}</h4>
                <p class="mb-0">Clientes</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card border-0 bg-dark text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-database display-6 mb-2"></i>
                <h4>{{ $estadisticas['usuarios_activos'] }}</h4>
                <p class="mb-0">Activos</p>
            </div>
        </div>
    </div>
</div>

<!-- Secciones de Configuración -->
<div class="row">
    <!-- Configuración General -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-building display-4 text-primary"></i>
                </div>
                <h5 class="card-title">Configuración General</h5>
                <p class="card-text text-muted">
                    Configura la información de la empresa, moneda, zona horaria y otros parámetros básicos.
                </p>
                <a href="{{ route('configuracion.general') }}" class="btn btn-primary btn-custom">
                    <i class="fas fa-edit me-2"></i>Configurar
                </a>
            </div>
        </div>
    </div>

    <!-- Configuración del Sistema -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-server display-4 text-success"></i>
                </div>
                <h5 class="card-title">Configuración del Sistema</h5>
                <p class="card-text text-muted">
                    Configura parámetros de seguridad, sesiones, mantenimiento y otros ajustes del sistema.
                </p>
                <a href="{{ route('configuracion.sistema') }}" class="btn btn-success btn-custom">
                    <i class="fas fa-cogs me-2"></i>Configurar
                </a>
            </div>
        </div>
    </div>

    <!-- Notificaciones -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-bell display-4 text-warning"></i>
                </div>
                <h5 class="card-title">Notificaciones</h5>
                <p class="card-text text-muted">
                    Configura las notificaciones por email y alertas del sistema.
                </p>
                <a href="{{ route('configuracion.notificaciones') }}" class="btn btn-warning btn-custom">
                    <i class="fas fa-envelope me-2"></i>Configurar
                </a>
            </div>
        </div>
    </div>

    <!-- Backup y Respaldo -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-database display-4 text-info"></i>
                </div>
                <h5 class="card-title">Backup y Respaldo</h5>
                <p class="card-text text-muted">
                    Gestiona los respaldos de la base de datos y configura backups automáticos.
                </p>
                <a href="{{ route('configuracion.backup') }}" class="btn btn-info btn-custom">
                    <i class="fas fa-download me-2"></i>Gestionar
                </a>
            </div>
        </div>
    </div>

    <!-- Logs del Sistema -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-file-alt display-4 text-secondary"></i>
                </div>
                <h5 class="card-title">Logs del Sistema</h5>
                <p class="card-text text-muted">
                    Visualiza y gestiona los logs del sistema para monitoreo y depuración.
                </p>
                <a href="{{ route('configuracion.logs') }}" class="btn btn-secondary btn-custom">
                    <i class="fas fa-eye me-2"></i>Ver Logs
                </a>
            </div>
        </div>
    </div>

    <!-- Información del Sistema -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-info-circle display-4 text-dark"></i>
                </div>
                <h5 class="card-title">Información del Sistema</h5>
                <p class="card-text text-muted">
                    Información sobre la versión del sistema, dependencias y estado general.
                </p>
                <button type="button" class="btn btn-dark btn-custom" onclick="mostrarInfoSistema()">
                    <i class="fas fa-info me-2"></i>Ver Info
                </button>
            </div>
        </div>
    </div>

    <!-- Personalización de Colores -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-palette display-4 text-danger"></i>
                </div>
                <h5 class="card-title">Personalización de Colores</h5>
                <p class="card-text text-muted">
                    Personaliza los colores del sistema, temas y apariencia visual.
                </p>
                <button type="button" class="btn btn-danger btn-custom" onclick="mostrarConfiguracionColores()">
                    <i class="fas fa-paint-brush me-2"></i>Personalizar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Configuración Actual -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-list text-primary me-2"></i>
                    Configuración Actual
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Información de la Empresa</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Nombre:</strong> {{ $configuraciones['nombre_empresa'] ?? 'No configurado' }}
                            </li>
                            <li class="mb-2">
                                <strong>Email:</strong> {{ $configuraciones['email_empresa'] ?? 'No configurado' }}
                            </li>
                            <li class="mb-2">
                                <strong>Teléfono:</strong> {{ $configuraciones['telefono_empresa'] ?? 'No configurado' }}
                            </li>
                            <li class="mb-2">
                                <strong>Moneda:</strong> {{ $configuraciones['moneda'] ?? 'GTQ' }}
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Configuración del Sistema</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Zona Horaria:</strong> {{ $configuraciones['zona_horaria'] ?? 'America/Guatemala' }}
                            </li>
                            <li class="mb-2">
                                <strong>Idioma:</strong> {{ $configuraciones['idioma'] ?? 'es' }}
                            </li>
                            <li class="mb-2">
                                <strong>Modo Mantenimiento:</strong> 
                                <span class="badge bg-{{ $configuraciones['mantenimiento'] ?? false ? 'danger' : 'success' }}">
                                    {{ $configuraciones['mantenimiento'] ?? false ? 'Activado' : 'Desactivado' }}
                                </span>
                            </li>
                            <li class="mb-2">
                                <strong>Registro de Usuarios:</strong> 
                                <span class="badge bg-{{ $configuraciones['registro_usuarios'] ?? true ? 'success' : 'danger' }}">
                                    {{ $configuraciones['registro_usuarios'] ?? true ? 'Permitido' : 'Bloqueado' }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function mostrarInfoSistema() {
    // Crear modal con información del sistema
    const modalHTML = `
        <div class="modal fade" id="infoSistemaModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background: #27DB9F;">
                        <h5 class="modal-title">
                            <i class="fas fa-info-circle me-2"></i>
                            Información del Sistema
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Información del Servidor</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><strong>Sistema Operativo:</strong> {{ php_uname('s') }}</li>
                                    <li class="mb-2"><strong>Versión PHP:</strong> {{ phpversion() }}</li>
                                    <li class="mb-2"><strong>Servidor Web:</strong> {{ $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' }}</li>
                                    <li class="mb-2"><strong>Base de Datos:</strong> MySQL</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Información de Laravel</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><strong>Versión Laravel:</strong> {{ app()->version() }}</li>
                                    <li class="mb-2"><strong>Entorno:</strong> {{ app()->environment() }}</li>
                                    <li class="mb-2"><strong>Debug:</strong> {{ config('app.debug') ? 'Activado' : 'Desactivado' }}</li>
                                    <li class="mb-2"><strong>Cache:</strong> {{ config('cache.default') }}</li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Recursos del Sistema</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <div class="h4 text-primary">{{ ini_get('memory_limit') }}</div>
                                            <small class="text-muted">Límite de Memoria</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <div class="h4 text-success">{{ ini_get('max_execution_time') }}s</div>
                                            <small class="text-muted">Tiempo de Ejecución</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <div class="h4 text-info">{{ ini_get('upload_max_filesize') }}</div>
                                            <small class="text-muted">Tamaño Máximo de Archivo</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Eliminar modal anterior si existe
    const existingModal = document.getElementById('infoSistemaModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Agregar modal al body
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Mostrar modal
    const modal = new bootstrap.Modal(document.getElementById('infoSistemaModal'));
    modal.show();
    
    // Limpiar modal al cerrarse
    document.getElementById('infoSistemaModal').addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}

function mostrarConfiguracionColores() {
    // Crear modal para configuración de colores
    const modalHTML = `
        <div class="modal fade" id="configuracionColoresModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <h5 class="modal-title">
                            <i class="fas fa-palette me-2"></i>
                            Personalización de Colores del Sistema
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Temas Predefinidos -->
                            <div class="col-md-6 mb-4">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-palette me-2"></i>
                                    Temas Predefinidos
                                </h6>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <div class="theme-card" data-theme="default" onclick="aplicarTema('default')">
                                            <div class="theme-preview" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                <div class="theme-dots">
                                                    <span class="dot" style="background: #fff;"></span>
                                                    <span class="dot" style="background: #fff;"></span>
                                                    <span class="dot" style="background: #fff;"></span>
                                                </div>
                                            </div>
                                            <div class="theme-info">
                                                <h6>Clásico</h6>
                                                <small class="text-muted">Tema por defecto</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="theme-card" data-theme="dark" onclick="aplicarTema('dark')">
                                            <div class="theme-preview" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);">
                                                <div class="theme-dots">
                                                    <span class="dot" style="background: #ecf0f1;"></span>
                                                    <span class="dot" style="background: #ecf0f1;"></span>
                                                    <span class="dot" style="background: #ecf0f1;"></span>
                                                </div>
                                            </div>
                                            <div class="theme-info">
                                                <h6>Oscuro</h6>
                                                <small class="text-muted">Tema elegante</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="theme-card" data-theme="green" onclick="aplicarTema('green')">
                                            <div class="theme-preview" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                                                <div class="theme-dots">
                                                    <span class="dot" style="background: #fff;"></span>
                                                    <span class="dot" style="background: #fff;"></span>
                                                    <span class="dot" style="background: #fff;"></span>
                                                </div>
                                            </div>
                                            <div class="theme-info">
                                                <h6>Verde</h6>
                                                <small class="text-muted">Tema natural</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="theme-card" data-theme="orange" onclick="aplicarTema('orange')">
                                            <div class="theme-preview" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                                <div class="theme-dots">
                                                    <span class="dot" style="background: #fff;"></span>
                                                    <span class="dot" style="background: #fff;"></span>
                                                    <span class="dot" style="background: #fff;"></span>
                                                </div>
                                            </div>
                                            <div class="theme-info">
                                                <h6>Coral</h6>
                                                <small class="text-muted">Tema vibrante</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="theme-card" data-theme="blue" onclick="aplicarTema('blue')">
                                            <div class="theme-preview" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                                <div class="theme-dots">
                                                    <span class="dot" style="background: #fff;"></span>
                                                    <span class="dot" style="background: #fff;"></span>
                                                    <span class="dot" style="background: #fff;"></span>
                                                </div>
                                            </div>
                                            <div class="theme-info">
                                                <h6>Azul</h6>
                                                <small class="text-muted">Tema profesional</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="theme-card" data-theme="purple" onclick="aplicarTema('purple')">
                                            <div class="theme-preview" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                                                <div class="theme-dots">
                                                    <span class="dot" style="background: #6c757d;"></span>
                                                    <span class="dot" style="background: #6c757d;"></span>
                                                    <span class="dot" style="background: #6c757d;"></span>
                                                </div>
                                            </div>
                                            <div class="theme-info">
                                                <h6>Pastel</h6>
                                                <small class="text-muted">Tema suave</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Personalización Avanzada -->
                            <div class="col-md-6 mb-4">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-sliders-h me-2"></i>
                                    Personalización Avanzada
                                </h6>
                                <div class="mb-3">
                                    <label class="form-label">Color Principal</label>
                                    <input type="color" class="form-control form-control-color w-100" id="colorPrincipal" value="#667eea" onchange="actualizarColorPersonalizado()">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Color Secundario</label>
                                    <input type="color" class="form-control form-control-color w-100" id="colorSecundario" value="#764ba2" onchange="actualizarColorPersonalizado()">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Color de Éxito</label>
                                    <input type="color" class="form-control form-control-color w-100" id="colorExito" value="#28a745" onchange="actualizarColorPersonalizado()">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Color de Advertencia</label>
                                    <input type="color" class="form-control form-control-color w-100" id="colorAdvertencia" value="#ffc107" onchange="actualizarColorPersonalizado()">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Color de Peligro</label>
                                    <input type="color" class="form-control form-control-color w-100" id="colorPeligro" value="#dc3545" onchange="actualizarColorPersonalizado()">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Color de Información</label>
                                    <input type="color" class="form-control form-control-color w-100" id="colorInfo" value="#17a2b8" onchange="actualizarColorPersonalizado()">
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-primary" onclick="aplicarColoresPersonalizados()">
                                        <i class="fas fa-check me-2"></i>Aplicar Colores Personalizados
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="restaurarColoresPorDefecto()">
                                        <i class="fas fa-undo me-2"></i>Restaurar Colores por Defecto
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Vista Previa -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-eye me-2"></i>
                                    Vista Previa
                                </h6>
                                <div class="preview-container">
                                    <div class="preview-header" id="previewHeader">
                                        <div class="preview-nav">
                                            <div class="preview-logo">Logo</div>
                                            <div class="preview-menu">
                                                <span class="preview-menu-item">Dashboard</span>
                                                <span class="preview-menu-item">Usuarios</span>
                                                <span class="preview-menu-item">Configuración</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="preview-content">
                                        <div class="preview-sidebar" id="previewSidebar">
                                            <div class="preview-sidebar-item active">Dashboard</div>
                                            <div class="preview-sidebar-item">Usuarios</div>
                                            <div class="preview-sidebar-item">Equipos</div>
                                            <div class="preview-sidebar-item">Reparaciones</div>
                                        </div>
                                        <div class="preview-main">
                                            <div class="preview-card">
                                                <h5>Tarjeta de Ejemplo</h5>
                                                <p>Esta es una vista previa de cómo se verán los colores en el sistema.</p>
                                                <button class="preview-btn btn-primary">Botón Primario</button>
                                                <button class="preview-btn btn-success">Botón Éxito</button>
                                                <button class="preview-btn btn-warning">Botón Advertencia</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cerrar
                        </button>
                        <button type="button" class="btn btn-primary" onclick="guardarConfiguracionColores()">
                            <i class="fas fa-save me-2"></i>Guardar Configuración
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Eliminar modal anterior si existe
    const existingModal = document.getElementById('configuracionColoresModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Agregar modal al body
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Mostrar modal
    const modal = new bootstrap.Modal(document.getElementById('configuracionColoresModal'));
    modal.show();
    
    // Limpiar modal al cerrarse
    document.getElementById('configuracionColoresModal').addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}

function aplicarTema(tema) {
    const temas = {
        default: {
            primary: '#667eea',
            secondary: '#764ba2',
            success: '#28a745',
            warning: '#ffc107',
            danger: '#dc3545',
            info: '#17a2b8'
        },
        dark: {
            primary: '#2c3e50',
            secondary: '#34495e',
            success: '#27ae60',
            warning: '#f39c12',
            danger: '#e74c3c',
            info: '#3498db'
        },
        green: {
            primary: '#11998e',
            secondary: '#38ef7d',
            success: '#27ae60',
            warning: '#f39c12',
            danger: '#e74c3c',
            info: '#3498db'
        },
        orange: {
            primary: '#f093fb',
            secondary: '#f5576c',
            success: '#27ae60',
            warning: '#f39c12',
            danger: '#e74c3c',
            info: '#3498db'
        },
        blue: {
            primary: '#4facfe',
            secondary: '#00f2fe',
            success: '#27ae60',
            warning: '#f39c12',
            danger: '#e74c3c',
            info: '#17a2b8'
        },
        purple: {
            primary: '#a8edea',
            secondary: '#fed6e3',
            success: '#27ae60',
            warning: '#f39c12',
            danger: '#e74c3c',
            info: '#3498db'
        }
    };

    const colores = temas[tema];
    
    // Actualizar inputs de color
    document.getElementById('colorPrincipal').value = colores.primary;
    document.getElementById('colorSecundario').value = colores.secondary;
    document.getElementById('colorExito').value = colores.success;
    document.getElementById('colorAdvertencia').value = colores.warning;
    document.getElementById('colorPeligro').value = colores.danger;
    document.getElementById('colorInfo').value = colores.info;
    
    // Aplicar colores a la vista previa
    actualizarVistaPrevia(colores);
    
    // Marcar tema como activo
    document.querySelectorAll('.theme-card').forEach(card => {
        card.classList.remove('active');
    });
    document.querySelector(`[data-theme="${tema}"]`).classList.add('active');
}

function actualizarColorPersonalizado() {
    const colores = {
        primary: document.getElementById('colorPrincipal').value,
        secondary: document.getElementById('colorSecundario').value,
        success: document.getElementById('colorExito').value,
        warning: document.getElementById('colorAdvertencia').value,
        danger: document.getElementById('colorPeligro').value,
        info: document.getElementById('colorInfo').value
    };
    
    actualizarVistaPrevia(colores);
}

function actualizarVistaPrevia(colores) {
    const header = document.getElementById('previewHeader');
    const sidebar = document.getElementById('previewSidebar');
    
    if (header) {
        header.style.background = `linear-gradient(135deg, ${colores.primary} 0%, ${colores.secondary} 100%)`;
    }
    
    if (sidebar) {
        sidebar.style.background = colores.primary;
    }
    
    // Actualizar botones de vista previa
    const btnPrimary = document.querySelector('.preview-btn.btn-primary');
    const btnSuccess = document.querySelector('.preview-btn.btn-success');
    const btnWarning = document.querySelector('.preview-btn.btn-warning');
    
    if (btnPrimary) btnPrimary.style.background = colores.primary;
    if (btnSuccess) btnSuccess.style.background = colores.success;
    if (btnWarning) btnWarning.style.background = colores.warning;
}

function aplicarColoresPersonalizados() {
    const colores = {
        primary: document.getElementById('colorPrincipal').value,
        secondary: document.getElementById('colorSecundario').value,
        success: document.getElementById('colorExito').value,
        warning: document.getElementById('colorAdvertencia').value,
        danger: document.getElementById('colorPeligro').value,
        info: document.getElementById('colorInfo').value
    };
    
    // Aplicar colores al sistema actual (local y global)
    aplicarColoresAlSistema(colores);
    if (typeof aplicarColoresGlobales === 'function') {
        aplicarColoresGlobales(colores);
    }
    
    // Mostrar notificación
    mostrarNotificacion('Colores personalizados aplicados correctamente en todo el sistema', 'success');
}

function restaurarColoresPorDefecto() {
    const coloresDefault = {
        primary: '#667eea',
        secondary: '#764ba2',
        success: '#28a745',
        warning: '#ffc107',
        danger: '#dc3545',
        info: '#17a2b8'
    };
    
    aplicarTema('default');
    aplicarColoresAlSistema(coloresDefault);
    if (typeof aplicarColoresGlobales === 'function') {
        aplicarColoresGlobales(coloresDefault);
    }
    mostrarNotificacion('Colores por defecto restaurados en todo el sistema', 'info');
}

function aplicarColoresAlSistema(colores) {
    console.log('Aplicando colores globalmente:', colores);
    
    // Crear o actualizar CSS variables con aplicación global
    const style = document.createElement('style');
    style.id = 'custom-theme-styles';
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
    `;
    
    // Remover estilos anteriores si existen
    const existingStyle = document.getElementById('custom-theme-styles');
    if (existingStyle) {
        existingStyle.remove();
    }
    
    // Agregar nuevos estilos al head del documento
    document.head.appendChild(style);
    
    // Forzar actualización de todos los elementos
    document.querySelectorAll('*').forEach(element => {
        element.style.setProperty('--bs-primary', colores.primary);
        element.style.setProperty('--bs-secondary', colores.secondary);
        element.style.setProperty('--bs-success', colores.success);
        element.style.setProperty('--bs-warning', colores.warning);
        element.style.setProperty('--bs-danger', colores.danger);
        element.style.setProperty('--bs-info', colores.info);
    });
    
    console.log('Colores aplicados globalmente correctamente');
}

function guardarConfiguracionColores() {
    console.log('Guardando configuración de colores...');
    
    const colores = {
        primary: document.getElementById('colorPrincipal').value,
        secondary: document.getElementById('colorSecundario').value,
        success: document.getElementById('colorExito').value,
        warning: document.getElementById('colorAdvertencia').value,
        danger: document.getElementById('colorPeligro').value,
        info: document.getElementById('colorInfo').value
    };
    
    console.log('Colores a guardar:', colores);
    
    // Guardar en localStorage para persistencia
    localStorage.setItem('sistemaColores', JSON.stringify(colores));
    
    // Aplicar colores inmediatamente para feedback visual (local y global)
    aplicarColoresAlSistema(colores);
    if (typeof aplicarColoresGlobales === 'function') {
        aplicarColoresGlobales(colores);
    }
    
    // Guardar en el backend
    fetch('{{ route("configuracion.guardar-colores") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(colores)
    })
    .then(response => {
        console.log('Respuesta del servidor:', response);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Datos recibidos:', data);
        if (data.success) {
            // Cerrar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('configuracionColoresModal'));
            if (modal) {
                modal.hide();
            }
            
            // Mostrar notificación
            mostrarNotificacion('Configuración de colores guardada correctamente. Los cambios se aplicarán en todo el sistema.', 'success');
            
            // Recargar la página para aplicar cambios globales
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            mostrarNotificacion('Error al guardar la configuración: ' + (data.message || 'Error desconocido'), 'error');
        }
    })
    .catch(error => {
        console.error('Error al guardar colores:', error);
        mostrarNotificacion('Error al guardar la configuración: ' + error.message, 'error');
    });
}

function mostrarNotificacion(mensaje, tipo) {
    const toastHTML = `
        <div class="toast align-items-center text-white bg-${tipo} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-${tipo === 'success' ? 'check-circle' : tipo === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                    ${mensaje}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    // Crear contenedor de toasts si no existe
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }
    
    // Agregar toast
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    
    // Mostrar toast
    const toastElement = toastContainer.lastElementChild;
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
    
    // Remover toast después de que se oculte
    toastElement.addEventListener('hidden.bs.toast', function() {
        this.remove();
    });
}

// Cargar colores guardados al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    console.log('Cargando colores del sistema...');
    
    // Intentar cargar desde el backend primero
    fetch('{{ route("configuracion.obtener-colores") }}')
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
                aplicarColoresAlSistema(colores);
                localStorage.setItem('sistemaColores', JSON.stringify(colores));
                console.log('Colores del backend aplicados correctamente');
            } else {
                console.log('No hay colores en el backend, intentando localStorage...');
                // Si no hay colores en el backend, intentar cargar desde localStorage
                const coloresGuardados = localStorage.getItem('sistemaColores');
                if (coloresGuardados) {
                    const colores = JSON.parse(coloresGuardados);
                    aplicarColoresAlSistema(colores);
                    console.log('Colores del localStorage aplicados correctamente');
                } else {
                    console.log('No hay colores guardados, usando colores por defecto');
                }
            }
        })
        .catch(error => {
            console.error('Error al cargar colores del backend:', error);
            // Fallback a localStorage
            const coloresGuardados = localStorage.getItem('sistemaColores');
            if (coloresGuardados) {
                const colores = JSON.parse(coloresGuardados);
                aplicarColoresAlSistema(colores);
                console.log('Colores del localStorage aplicados como fallback');
            } else {
                console.log('No hay colores guardados, usando colores por defecto');
            }
        });
});
</script>
@endsection

@section('styles')
<style>
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
}

.btn-custom {
    border-radius: 25px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.display-4 {
    font-size: 2.5rem;
}

.display-6 {
    font-size: 1.5rem;
}

/* Estilos para configuración de colores */
.theme-card {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    overflow: hidden;
}

.theme-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    border-color: #007bff;
}

.theme-card.active {
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
}

.theme-preview {
    height: 80px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.theme-dots {
    display: flex;
    gap: 8px;
}

.dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #fff;
}

.theme-info {
    padding: 15px;
    text-align: center;
    background: #fff;
}

.theme-info h6 {
    margin: 0;
    font-weight: 600;
}

.theme-info small {
    color: #6c757d;
}

/* Vista previa */
.preview-container {
    border: 1px solid #dee2e6;
    border-radius: 10px;
    overflow: hidden;
    background: #f8f9fa;
}

.preview-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px;
}

.preview-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.preview-logo {
    font-weight: bold;
    font-size: 1.2rem;
}

.preview-menu {
    display: flex;
    gap: 20px;
}

.preview-menu-item {
    cursor: pointer;
    padding: 5px 10px;
    border-radius: 5px;
    transition: background 0.3s ease;
}

.preview-menu-item:hover {
    background: rgba(255, 255, 255, 0.2);
}

.preview-content {
    display: flex;
    min-height: 200px;
}

.preview-sidebar {
    width: 200px;
    background: #667eea;
    color: white;
    padding: 15px;
}

.preview-sidebar-item {
    padding: 10px;
    margin-bottom: 5px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.preview-sidebar-item:hover {
    background: rgba(255, 255, 255, 0.1);
}

.preview-sidebar-item.active {
    background: rgba(255, 255, 255, 0.2);
    font-weight: bold;
}

.preview-main {
    flex: 1;
    padding: 20px;
    background: white;
}

.preview-card {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.preview-card h5 {
    margin-bottom: 10px;
    color: #333;
}

.preview-card p {
    color: #6c757d;
    margin-bottom: 15px;
}

.preview-btn {
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    margin-right: 10px;
    color: white;
    cursor: pointer;
    font-size: 0.9rem;
}

/* Inputs de color */
.form-control-color {
    height: 50px;
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: border-color 0.3s ease;
}

.form-control-color:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Responsive */
@media (max-width: 768px) {
    .preview-content {
        flex-direction: column;
    }
    
    .preview-sidebar {
        width: 100%;
        height: auto;
    }
    
    .preview-menu {
        gap: 10px;
    }
    
    .preview-menu-item {
        font-size: 0.9rem;
    }
}
</style>
@endsection
