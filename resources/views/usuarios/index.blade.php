@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container-fluid">
    <div class="module-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="module-title">
                    <i class="fas fa-users text-gradient me-3"></i>
                    Gestión de Usuarios
                </h1>
                <p class="module-subtitle">Administra los usuarios del sistema</p>
            </div>
            <div class="col-lg-4 text-end">
                <a href="{{ route('usuarios.create') }}" class="btn btn-light btn-modern" data-bs-toggle="tooltip" title="Crear nuevo usuario">
                    <i class="fas fa-user-plus me-2"></i>Nuevo Usuario
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas Principales -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $estadisticas['total_usuarios'] ?? 0 }}">{{ $estadisticas['total_usuarios'] ?? 0 }}</h3>
                <p class="stat-card-label">Total Usuarios</p>
                <div class="stat-card-trend">
                    <i class="fas fa-chart-line"></i>
                    <span>Base de datos completa</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-card-success">
            <div class="stat-card-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $estadisticas['usuarios_activos'] ?? 0 }}">{{ $estadisticas['usuarios_activos'] ?? 0 }}</h3>
                <p class="stat-card-label">Usuarios Activos</p>
                <div class="stat-card-trend">
                    <i class="fas fa-percentage"></i>
                    <span>{{ $estadisticas['total_usuarios'] > 0 ? round(($estadisticas['usuarios_activos'] / $estadisticas['total_usuarios']) * 100, 1) : 0 }}% del total</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $estadisticas['administradores'] ?? 0 }}">{{ $estadisticas['administradores'] ?? 0 }}</h3>
                <p class="stat-card-label">Administradores</p>
                <div class="stat-card-trend">
                    <i class="fas fa-crown"></i>
                    <span>{{ $estadisticas['total_usuarios'] > 0 ? round(($estadisticas['administradores'] / $estadisticas['total_usuarios']) * 100, 1) : 0 }}% administradores</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-card-info">
            <div class="stat-card-icon">
                <i class="fas fa-user-cog"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $estadisticas['tecnicos'] ?? 0 }}">{{ $estadisticas['tecnicos'] ?? 0 }}</h3>
                <p class="stat-card-label">Técnicos</p>
                <div class="stat-card-trend">
                    <i class="fas fa-tools"></i>
                    <span>{{ $estadisticas['total_usuarios'] > 0 ? round(($estadisticas['tecnicos'] / $estadisticas['total_usuarios']) * 100, 1) : 0 }}% técnicos</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtros y Búsqueda -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('usuarios.index') }}" class="row g-3">
            <!-- Búsqueda -->
            <div class="col-md-4">
                <label for="buscar" class="form-label">Búsqueda</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           id="buscar" 
                           name="buscar" 
                           value="{{ request('buscar') }}" 
                                                       placeholder="Buscar por nombre, usuario o email...">
                </div>
            </div>

            <!-- Filtro por Rol -->
            <div class="col-md-3">
                <label for="rol" class="form-label">Filtrar por Rol</label>
                <select class="form-select" id="rol" name="rol">
                    <option value="">Todos los roles</option>
                    <option value="admin" {{ request('rol') == 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="tecnico" {{ request('rol') == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                    <option value="usuario" {{ request('rol') == 'usuario' ? 'selected' : '' }}>Usuario</option>
                </select>
            </div>

            <!-- Filtro por Estado -->
            <div class="col-md-3">
                <label for="estado" class="form-label">Filtrar por Estado</label>
                <select class="form-select" id="estado" name="estado">
                    <option value="">Todos los estados</option>
                    <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i>Filtrar
                    </button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Limpiar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Lista de Usuarios -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($usuarios->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover modern-table">
                    <thead class="table-dark sticky-top" style="z-index: 1;">
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Fecha de Creación</th>
                            <th width="200px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                        <tr data-user-id="{{ $usuario->id }}">
                                                         <!-- Nombre -->
                             <td>
                                 <div class="d-flex align-items-center">
                                     <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                          style="width: 40px; height: 40px;">
                                         <i class="fas fa-user"></i>
                                     </div>
                                     <div>
                                         <strong>{{ $usuario->name }}</strong>
                                         <br>
                                         <small class="text-muted">
                                             <i class="fas fa-at me-1"></i>{{ $usuario->username }}
                                         </small>
                                         @if($usuario->tecnico)
                                             <br>
                                             <small class="text-info">
                                                 <i class="fas fa-tools me-1"></i>Perfil Técnico
                                             </small>
                                         @endif
                                     </div>
                                 </div>
                             </td>
                            
                            <!-- Correo -->
                            <td>
                                <a href="mailto:{{ $usuario->email }}" class="text-decoration-none">
                                    {{ $usuario->email }}
                                </a>
                            </td>
                            
                            <!-- Rol -->
                            <td>
                                @php
                                    $rolColors = [
                                        'admin' => 'danger',
                                        'tecnico' => 'info', 
                                        'usuario' => 'secondary'
                                    ];
                                    $rolIcons = [
                                        'admin' => 'user-shield',
                                        'tecnico' => 'user-cog',
                                        'usuario' => 'user'
                                    ];
                                @endphp
                                <span class="badge bg-{{ $rolColors[$usuario->rol] ?? 'secondary' }} text-white fs-6">
                                    <i class="fas fa-{{ $rolIcons[$usuario->rol] ?? 'user' }} me-1"></i>
                                    {{ $usuario->rol_label }}
                                </span>
                            </td>
                            
                            <!-- Estado -->
                            <td>
                                <span class="badge bg-{{ $usuario->estado_color }} text-white fs-6" 
                                      id="estado-badge-{{ $usuario->id }}">
                                    <i class="fas fa-{{ $usuario->activo ? 'check-circle' : 'times-circle' }} me-1"></i>
                                    {{ $usuario->estado_label }}
                                </span>
                            </td>
                            
                            <!-- Fecha de Creación -->
                            <td>
                                <div>
                                    <strong>{{ $usuario->created_at->format('d/m/Y') }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $usuario->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                            
                            <!-- Acciones -->
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('usuarios.show', $usuario) }}" 
                                       class="btn btn-sm btn-action btn-info" 
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('usuarios.edit', $usuario) }}" 
                                       class="btn btn-sm btn-action btn-warning" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('usuarios.permissions', $usuario) }}" 
                                       class="btn btn-sm btn-action btn-primary" 
                                       title="Permisos">
                                        <i class="fas fa-user-shield"></i>
                                    </a>
                                    @if($usuario->activo)
                                        <button type="button" 
                                                class="btn btn-sm btn-action btn-secondary" 
                                                onclick="toggleStatus({{ $usuario->id }}, false)"
                                                title="Desactivar">
                                            <i class="fas fa-user-times"></i>
                                        </button>
                                    @else
                                        <button type="button" 
                                                class="btn btn-sm btn-action btn-success" 
                                                onclick="toggleStatus({{ $usuario->id }}, true)"
                                                title="Activar">
                                            <i class="fas fa-user-check"></i>
                                        </button>
                                    @endif
                                    <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar al usuario {{ $usuario->name }}? Esta acción es irreversible.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-action btn-danger" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                {{ $usuarios->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users display-1 text-muted mb-4"></i>
                <h4 class="text-muted">No se encontraron usuarios</h4>
                @if(request()->hasAny(['buscar', 'rol', 'estado']))
                    <p class="text-muted">Intenta ajustar los filtros de búsqueda.</p>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-times me-2"></i>Limpiar Filtros
                    </a>
                @else
                    <p class="text-muted">Registra el primer usuario del sistema.</p>
                    <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-custom">
                        <i class="fas fa-user-plus me-2"></i>Crear Primer Usuario
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Acciones Rápidas -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('usuarios.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-user-plus me-2"></i>Nuevo Usuario
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('tecnicos.index') }}" class="btn btn-info w-100">
                            <i class="fas fa-users-cog me-2"></i>Ver Técnicos
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="button" class="btn btn-outline-secondary w-100" onclick="mostrarProximamente('Importar Usuarios')">
                            <i class="fas fa-upload me-2"></i>Importar
                        </button>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="button" class="btn btn-outline-secondary w-100" onclick="mostrarProximamente('Exportar Usuarios')">
                            <i class="fas fa-download me-2"></i>Exportar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
function toggleStatus(userId, activar) {
    const url = `/usuarios/${userId}/toggle-status`;
    
    fetch(url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Actualizar el badge de estado
            const badge = document.getElementById(`estado-badge-${userId}`);
            const button = document.getElementById(`toggle-btn-${userId}`);
            
            if (data.estado) {
                badge.className = 'badge bg-success text-white fs-6';
                badge.innerHTML = '<i class="fas fa-check-circle me-1"></i>Activo';
                button.className = 'btn btn-outline-danger';
                button.setAttribute('onclick', `toggleStatus(${userId}, false)`);
                button.title = 'Desactivar';
                button.innerHTML = '<i class="fas fa-user-times"></i>';
            } else {
                badge.className = 'badge bg-danger text-white fs-6';
                badge.innerHTML = '<i class="fas fa-times-circle me-1"></i>Inactivo';
                button.className = 'btn btn-outline-success';
                button.setAttribute('onclick', `toggleStatus(${userId}, true)`);
                button.title = 'Activar';
                button.innerHTML = '<i class="fas fa-user-check"></i>';
            }
            
            // Mostrar mensaje de éxito
            showToast('success', data.message);
        } else {
            showToast('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'Error al cambiar el estado del usuario');
    });
}



function showToast(type, message) {
    // Crear toast dinámico
    const toastContainer = document.getElementById('toast-container') || (() => {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
        return container;
    })();
    
    const toastHtml = `
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-${type === 'success' ? 'success' : 'danger'} text-white">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                <strong class="me-auto">${type === 'success' ? 'Éxito' : 'Error'}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    const toastElement = toastContainer.lastElementChild;
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
    
    // Eliminar el toast después de que se oculte
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}
</script>
@endsection

@section('styles')
<style>
/* Variables CSS */
:root {
    --primary-color: #4f46e5;
    --primary-light: #6366f1;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --info-color: #06b6d4;
    --secondary-color: #6b7280;
    --dark-color: #1f2937;
    --light-color: #f8fafc;
    --border-color: #e5e7eb;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --gradient-success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --gradient-warning: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --gradient-info: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    --gradient-danger: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    --gradient-secondary: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
}

/* Stat Cards */
.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: var(--shadow-md);
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--system-gradient);
}

.stat-card-primary::before { background: var(--gradient-primary); }
.stat-card-success::before { background: var(--gradient-success); }
.stat-card-warning::before { background: var(--gradient-warning); }
.stat-card-info::before { background: var(--gradient-info); }
.stat-card-danger::before { background: var(--gradient-danger); }
.stat-card-secondary::before { background: var(--gradient-secondary); }

.stat-card-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
    background: var(--system-gradient);
    color: white;
}

.stat-card-primary .stat-card-icon { background: var(--gradient-primary); }
.stat-card-success .stat-card-icon { background: var(--gradient-success); }
.stat-card-warning .stat-card-icon { background: var(--gradient-warning); }
.stat-card-info .stat-card-icon { background: var(--gradient-info); }
.stat-card-danger .stat-card-icon { background: var(--gradient-danger); }
.stat-card-secondary .stat-card-icon { background: var(--gradient-secondary); }

.stat-card-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    color: var(--dark-color);
}

.stat-card-label {
    font-size: 1rem;
    color: #6b7280;
    margin: 0.5rem 0;
    font-weight: 500;
}

.stat-card-trend {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--success-color);
}

/* Animaciones */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card {
    animation: fadeInUp 0.6s ease-out;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }

/* Responsive para stat cards */
@media (max-width: 768px) {
    .stat-card {
        padding: 1rem;
    }
    
    .stat-card-number {
        font-size: 2rem;
    }
}

.action-buttons { display:flex; gap:0.5rem; justify-content:center; }
.btn-action { width:35px; height:35px; border-radius:8px; display:flex; align-items:center; justify-content:center; transition:all 0.2s ease; border:none; }
.btn-action:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.12); }
.btn-info { background:#06b6d4; color:#fff; }
.btn-warning { background:#f59e0b; color:#fff; }
.btn-success { background:#10b981; color:#fff; }
.btn-secondary { background:#6b7280; color:#fff; }
.btn-danger { background:#ef4444; color:#fff; }
.btn-primary { background:#2563eb; color:#fff; }

.module-header {
    background: var(--system-gradient);
    color: #fff;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
}
.module-title { font-size: 2.0rem; font-weight: 700; margin: 0; }
.module-subtitle { opacity: .9; margin-top: .25rem; }
.btn-modern { border-radius: 25px; padding: .6rem 1.2rem; font-weight: 600; }
.kpi { background-image: linear-gradient(135deg, rgba(255,255,255,0.08), rgba(0,0,0,0.08)); border-radius: 14px; }

.table-responsive {
    border-radius: 15px;
    overflow: hidden;
}

.table th {
    border: none;
    padding: 1rem 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table td {
    padding: 1rem 0.75rem;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
}

.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35rem 0.65rem;
}

.btn-group-sm > .btn {
    padding: 0.375rem 0.5rem;
    font-size: 0.875rem;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group-sm > .btn {
        padding: 0.25rem 0.375rem;
        font-size: 0.8rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
// Función específica para eliminar usuarios
function showDeleteConfirmation(userId, userName, itemType, deleteUrl) {
    console.log('Función de eliminación llamada:', { userId, userName, itemType, deleteUrl });
    
    // Confirmación doble para mayor seguridad
    if (confirm(`¿Está seguro de que desea eliminar este ${itemType.toLowerCase()}?\n\n${itemType}: ${userName}\n\nEsta acción no se puede deshacer y eliminará:\n- La cuenta del usuario\n- Todos sus permisos\n- Su perfil técnico (si existe)`)) {
        if (confirm(`CONFIRMACIÓN FINAL:\n\n¿Realmente desea eliminar al usuario "${userName}"?\n\nEsta acción es IRREVERSIBLE.`)) {
            console.log('Confirmación doble aceptada, procediendo con eliminación...');
            eliminarUsuario(deleteUrl);
        } else {
            console.log('Segunda confirmación cancelada');
        }
    } else {
        console.log('Primera confirmación cancelada');
    }
}

// Función para eliminar usuario
function eliminarUsuario(deleteUrl) {
    console.log('Eliminando usuario con URL:', deleteUrl);
    
    // Obtener token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('Token CSRF no encontrado');
        alert('Error: Token de seguridad no encontrado. Recarga la página e intenta nuevamente.');
        return;
    }
    
    // Crear formulario para enviar la solicitud DELETE
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = deleteUrl;
    form.style.display = 'none';
    
    // Agregar token CSRF
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken.content;
    form.appendChild(csrfInput);
    
    // Agregar método DELETE
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';
    form.appendChild(methodInput);
    
    // Agregar formulario al DOM y enviarlo
    document.body.appendChild(form);
    
    console.log('Enviando formulario de eliminación...');
    
    try {
        form.submit();
    } catch (error) {
        console.error('Error al enviar formulario:', error);
        alert('Error al eliminar el usuario. Intenta nuevamente.');
    }
}

// Función para cambiar estado de usuario (activar/desactivar)
function toggleStatus(userId, newStatus) {
    console.log('Cambiando estado del usuario:', { userId, newStatus });
    
    // Obtener token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('Token CSRF no encontrado');
        alert('Error: Token de seguridad no encontrado. Recarga la página e intenta nuevamente.');
        return;
    }
    
    // Hacer petición AJAX
    fetch(`/usuarios/${userId}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ activo: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar notificación de éxito
            mostrarNotificacion(data.message, 'success');
            
            // Actualizar el botón y el badge
            const button = document.getElementById(`toggle-btn-${userId}`);
            const badge = document.querySelector(`[data-user-id="${userId}"] .badge`);
            
            if (button && badge) {
                if (data.estado) {
                    // Usuario activado
                    button.className = 'btn btn-outline-danger';
                    button.onclick = () => toggleStatus(userId, false);
                    button.title = 'Desactivar';
                    button.innerHTML = '<i class="fas fa-user-times"></i>';
                    
                    badge.className = 'badge bg-success';
                    badge.textContent = 'Activo';
                } else {
                    // Usuario desactivado
                    button.className = 'btn btn-outline-success';
                    button.onclick = () => toggleStatus(userId, true);
                    button.title = 'Activar';
                    button.innerHTML = '<i class="fas fa-user-check"></i>';
                    
                    badge.className = 'badge bg-danger';
                    badge.textContent = 'Inactivo';
                }
            }
        } else {
            mostrarNotificacion(data.message, 'danger');
        }
    })
    .catch(error => {
        console.error('Error al cambiar estado:', error);
        mostrarNotificacion('Error al cambiar el estado del usuario', 'danger');
    });
}

// Función para mostrar notificaciones
function mostrarNotificacion(mensaje, tipo = 'success') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${tipo} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px;';
    
    const iconClass = tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    notification.innerHTML = `
        <i class="fas ${iconClass} me-2"></i>
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Remover automáticamente después de 5 segundos
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Función directa para eliminar usuarios
function eliminarUsuarioDirecto(userId, userName, deleteUrl) {
    console.log('Eliminación directa llamada:', { userId, userName, deleteUrl });
    
    // Confirmación simple pero efectiva
    const confirmacion1 = confirm(`⚠️ ELIMINAR USUARIO ⚠️\n\nUsuario: ${userName}\nID: ${userId}\n\n¿Está seguro de que desea eliminar este usuario?\n\nEsta acción eliminará:\n✗ La cuenta del usuario\n✗ Todos sus permisos\n✗ Su perfil técnico (si existe)\n✗ Todo su historial\n\n¿Continuar?`);
    
    if (confirmacion1) {
        const confirmacion2 = confirm(`🚨 CONFIRMACIÓN FINAL 🚨\n\n¿REALMENTE desea eliminar al usuario "${userName}"?\n\nEsta acción es PERMANENTE e IRREVERSIBLE.\n\n¿Proceder con la eliminación?`);
        
        if (confirmacion2) {
            console.log('Confirmaciones aceptadas, eliminando usuario...');
            
            // Mostrar loading
            const loadingDiv = document.createElement('div');
            loadingDiv.innerHTML = `
                <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center;">
                    <div style="background: white; padding: 2rem; border-radius: 12px; text-align: center;">
                        <i class="fas fa-spinner fa-spin fa-2x text-danger mb-3"></i>
                        <h5>Eliminando usuario...</h5>
                        <p>Por favor espere...</p>
                    </div>
                </div>
            `;
            document.body.appendChild(loadingDiv);
            
            // Crear y enviar formulario
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = deleteUrl;
            form.style.display = 'none';
            
            // Token CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken.content;
                form.appendChild(csrfInput);
            }
            
            // Método DELETE
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            // Enviar
            document.body.appendChild(form);
            form.submit();
        } else {
            console.log('Confirmación final cancelada');
        }
    } else {
        console.log('Primera confirmación cancelada');
    }
}

// Debug: Verificar que las funciones estén cargadas
document.addEventListener('DOMContentLoaded', function() {
    console.log('JavaScript de usuarios cargado correctamente');
    console.log('Funciones disponibles:', {
        showDeleteConfirmation: typeof showDeleteConfirmation,
        toggleStatus: typeof toggleStatus,
        eliminarUsuario: typeof eliminarUsuario,
        eliminarUsuarioDirecto: typeof eliminarUsuarioDirecto
    });
    
    // Verificar que los botones tengan los eventos correctos
    const deleteButtons = document.querySelectorAll('button[onclick*="eliminarUsuarioDirecto"]');
    console.log('Botones de eliminar encontrados:', deleteButtons.length);
    
    deleteButtons.forEach((button, index) => {
        console.log(`Botón ${index + 1}:`, button.getAttribute('onclick'));
    });
    
    // Verificar CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    console.log('CSRF Token disponible:', csrfToken ? 'Sí' : 'No');
    if (csrfToken) {
        console.log('CSRF Token:', csrfToken.content);
    }
});

// Animación de contadores para las tarjetas de estadísticas
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.stat-card-number');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        const duration = 2000; // 2 segundos
        const increment = target / (duration / 16); // 60 FPS
        let current = 0;
        
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };
        
        // Iniciar animación cuando la tarjeta sea visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        observer.observe(counter);
    });
});
</script>
@endsection