@extends('layouts.app')

@section('title', 'Usuario - ' . $usuario->name)

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-user text-primary me-2"></i>
            Perfil de Usuario
        </h1>
        <p class="text-muted">Información detallada de {{ $usuario->name }}</p>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Información Principal -->
    <div class="col-lg-8 mb-4">
        <!-- Información Básica -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-id-card text-primary me-2"></i>
                    Información Básica
                </h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                             style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="badge bg-{{ $usuario->estado_color }} fs-6">
                            <i class="fas fa-{{ $usuario->activo ? 'check-circle' : 'times-circle' }} me-1"></i>
                            {{ $usuario->estado_label }}
                        </span>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Nombre Completo</label>
                                <h5 class="mb-0">{{ $usuario->name }}</h5>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Email</label>
                                <h6 class="mb-0">
                                    <a href="mailto:{{ $usuario->email }}" class="text-decoration-none">
                                        {{ $usuario->email }}
                                    </a>
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Rol en el Sistema</label>
                                @php
                                    $rolColors = ['admin' => 'danger', 'tecnico' => 'info', 'usuario' => 'secondary'];
                                    $rolIcons = ['admin' => 'user-shield', 'tecnico' => 'user-cog', 'usuario' => 'user'];
                                @endphp
                                <span class="badge bg-{{ $rolColors[$usuario->rol] ?? 'secondary' }} text-white fs-6">
                                    <i class="fas fa-{{ $rolIcons[$usuario->rol] ?? 'user' }} me-1"></i>
                                    {{ $usuario->rol_label }}
                                </span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Fecha de Registro</label>
                                <h6 class="mb-0">{{ $usuario->created_at->format('d/m/Y H:i') }}</h6>
                                <small class="text-muted">{{ $usuario->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de Técnico (si aplica) -->
        @if($usuario->tecnico)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-tools text-info me-2"></i>
                    Información como Técnico
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Especialidad</label>
                        <p class="mb-0">{{ $usuario->tecnico->especialidad }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Estado como Técnico</label>
                        <span class="badge bg-{{ $usuario->tecnico->activo ? 'success' : 'danger' }} text-white">
                            {{ $usuario->tecnico->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                    @if($usuario->tecnico->nombres && $usuario->tecnico->apellidos)
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Nombre Completo (Técnico)</label>
                        <p class="mb-0">{{ $usuario->tecnico->nombres }} {{ $usuario->tecnico->apellidos }}</p>
                    </div>
                    @endif
                    @if($usuario->tecnico->telefono)
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Teléfono</label>
                        <p class="mb-0">{{ $usuario->tecnico->telefono }}</p>
                    </div>
                    @endif
                </div>
                
                <div class="mt-3">
                    <a href="{{ route('tecnicos.show', $usuario->tecnico) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye me-2"></i>Ver Perfil Completo de Técnico
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Estadísticas (si es técnico) -->
        @if($estadisticas)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar text-success me-2"></i>
                    Estadísticas como Técnico
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <i class="fas fa-tasks text-primary display-6 mb-2"></i>
                                <h3 class="text-primary">{{ $estadisticas['total_reparaciones'] }}</h3>
                                <p class="text-muted mb-0">Total Reparaciones</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-success">
                            <div class="card-body">
                                <i class="fas fa-check-circle text-success display-6 mb-2"></i>
                                <h3 class="text-success">{{ $estadisticas['reparaciones_completadas'] }}</h3>
                                <p class="text-muted mb-0">Completadas</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card border-info">
                            <div class="card-body">
                                <i class="fas fa-stopwatch text-info display-6 mb-2"></i>
                                <h3 class="text-info">
                                    {{ $estadisticas['promedio_tiempo'] ? $estadisticas['promedio_tiempo'] . 'h' : 'N/A' }}
                                </h3>
                                <p class="text-muted mb-0">Promedio Tiempo</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Panel Lateral -->
    <div class="col-lg-4">
        <!-- Acciones Rápidas -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-bolt text-primary me-2"></i>
                    Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Editar Usuario
                    </a>
                    
                    @if($usuario->activo)
                        <button type="button" 
                                class="btn btn-outline-danger" 
                                onclick="toggleStatus({{ $usuario->id }}, false)">
                            <i class="fas fa-user-times me-2"></i>Desactivar Usuario
                        </button>
                    @else
                        <button type="button" 
                                class="btn btn-outline-success" 
                                onclick="toggleStatus({{ $usuario->id }}, true)">
                            <i class="fas fa-user-check me-2"></i>Activar Usuario
                        </button>
                    @endif
                    
                    @if($usuario->rol === 'tecnico' && !$usuario->tecnico)
                        <a href="{{ route('tecnicos.create') }}?user_id={{ $usuario->id }}" 
                           class="btn btn-info">
                            <i class="fas fa-plus me-2"></i>Crear Perfil Técnico
                        </a>
                    @endif
                    
                    @if($usuario->tecnico)
                        <a href="{{ route('tecnicos.show', $usuario->tecnico) }}" 
                           class="btn btn-outline-info">
                            <i class="fas fa-tools me-2"></i>Ver como Técnico
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Información del Sistema -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle text-info me-2"></i>
                    Información del Sistema
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">ID del Usuario</label>
                    <h6 class="mb-0">#{{ $usuario->id }}</h6>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Última Actualización</label>
                    <h6 class="mb-0">{{ $usuario->updated_at->format('d/m/Y H:i') }}</h6>
                    <small class="text-muted">{{ $usuario->updated_at->diffForHumans() }}</small>
                </div>
                @if($usuario->email_verified_at)
                <div class="mb-3">
                    <label class="text-muted small">Email Verificado</label>
                    <span class="badge bg-success text-white">
                        <i class="fas fa-check-circle me-1"></i>Verificado
                    </span>
                </div>
                @endif
            </div>
        </div>

        <!-- Historial de Actividades -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-history text-secondary me-2"></i>
                    Actividad Reciente
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center py-3">
                    <i class="fas fa-clock display-6 text-muted mb-3"></i>
                    <p class="text-muted">Historial de actividades próximamente</p>
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
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cambiar el estado del usuario');
    });
}
</script>
@endsection

@section('styles')
<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endsection