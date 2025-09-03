@extends('layouts.app')

@section('title', 'Técnico - ' . $tecnico->nombre_completo)

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-user-cog text-primary me-2"></i>
            Perfil del Técnico
        </h1>
        <p class="text-muted">Información detallada y estadísticas de {{ $tecnico->nombre_completo }}</p>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <a href="{{ route('tecnicos.edit', $tecnico) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
            <a href="{{ route('tecnicos.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Información Principal -->
    <div class="col-lg-8 mb-4">
        <!-- Información Personal -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-user text-primary me-2"></i>
                    Información Personal
                </h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                             style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-user"></i>
                        </div>
                        @if($tecnico->activo)
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check-circle me-1"></i>Activo
                            </span>
                        @else
                            <span class="badge bg-danger fs-6">
                                <i class="fas fa-times-circle me-1"></i>Inactivo
                            </span>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Nombre Completo</label>
                                <h5 class="mb-0">{{ $tecnico->nombre_completo }}</h5>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Email</label>
                                <h6 class="mb-0">{{ $tecnico->user->email }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Especialidad</label>
                                <span class="badge bg-info text-white fs-6">{{ $tecnico->especialidad }}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Fecha de Registro</label>
                                <h6 class="mb-0">{{ $tecnico->created_at->format('d/m/Y') }}</h6>
                                <small class="text-muted">{{ $tecnico->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @if($tecnico->descripcion)
                        <div class="mt-3">
                            <label class="text-muted small">Descripción de Habilidades</label>
                            <p class="mb-0">{{ $tecnico->descripcion }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas de Rendimiento -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line text-success me-2"></i>
                    Estadísticas de Rendimiento
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
                                    @if($estadisticas['promedio_tiempo'])
                                        {{ $estadisticas['promedio_tiempo'] }}h
                                    @else
                                        N/A
                                    @endif
                                </h3>
                                <p class="text-muted mb-0">Promedio Tiempo</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Barra de eficiencia -->
                @if($estadisticas['total_reparaciones'] > 0)
                <div class="mt-3">
                    @php
                        $eficiencia = ($estadisticas['reparaciones_completadas'] / $estadisticas['total_reparaciones']) * 100;
                        $colorEficiencia = $eficiencia >= 90 ? 'success' : ($eficiencia >= 70 ? 'warning' : 'danger');
                    @endphp
                    <label class="text-muted small">Eficiencia General</label>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-{{ $colorEficiencia }}" 
                             style="width: {{ $eficiencia }}%">
                            {{ round($eficiencia, 1) }}% eficiencia
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Reparaciones Recientes -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-history text-info me-2"></i>
                        Reparaciones Recientes
                    </h5>
                    <a href="{{ route('reparaciones.index', ['tecnico_id' => $tecnico->id]) }}" class="btn btn-sm btn-outline-info">
                        Ver todas
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($tecnico->reparaciones && $tecnico->reparaciones->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Cliente</th>
                                    <th>Equipo</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tecnico->reparaciones->take(5) as $reparacion)
                                <tr>
                                    <td><strong>#{{ $reparacion->id }}</strong></td>
                                    <td>{{ $reparacion->equipo->cliente_nombre }}</td>
                                    <td>{{ $reparacion->equipo->marca }} {{ $reparacion->equipo->modelo }}</td>
                                    <td>
                                        <span class="badge bg-{{ $reparacion->estado_color }} text-white">
                                            {{ ucfirst($reparacion->estado) }}
                                        </span>
                                    </td>
                                    <td>{{ $reparacion->fecha_inicio->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('reparaciones.show', $reparacion) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-tools display-6 text-muted mb-3"></i>
                        <p class="text-muted">No hay reparaciones registradas para este técnico.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Panel Lateral -->
    <div class="col-lg-4">


        <!-- Información de Contacto -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-address-card text-info me-2"></i>
                    Información de Contacto
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Email</label>
                    <h6 class="mb-0">
                        <a href="mailto:{{ $tecnico->user->email }}" class="text-decoration-none">
                            <i class="fas fa-envelope me-2"></i>{{ $tecnico->user->email }}
                        </a>
                    </h6>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Usuario del Sistema</label>
                    <h6 class="mb-0">{{ $tecnico->user->name }}</h6>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Rol</label>
                    <span class="badge bg-primary">Técnico Especializado</span>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-bolt text-primary me-2"></i>
                    Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('tecnicos.edit', $tecnico) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Editar Información
                    </a>
                    
                    @if($tecnico->activo)
                        <button type="button" 
                                class="btn btn-outline-danger" 
                                onclick="cambiarEstado({{ $tecnico->id }}, false)">
                            <i class="fas fa-user-times me-2"></i>Desactivar Técnico
                        </button>
                    @else
                        <button type="button" 
                                class="btn btn-outline-success" 
                                onclick="cambiarEstado({{ $tecnico->id }}, true)">
                            <i class="fas fa-user-check me-2"></i>Activar Técnico
                        </button>
                    @endif
                    
                    <a href="{{ route('reparaciones.index', ['tecnico_id' => $tecnico->id]) }}" 
                       class="btn btn-outline-info">
                        <i class="fas fa-list me-2"></i>Ver Todas sus Reparaciones
                    </a>
                    
                    <a href="{{ route('tecnicos.rendimiento', $tecnico) }}" 
                       class="btn btn-outline-secondary">
                        <i class="fas fa-chart-line me-2"></i>Reporte de Rendimiento
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function cambiarEstado(tecnicoId, activar) {
    const accion = activar ? 'activar' : 'desactivar';
    const texto = activar ? 'activar' : 'desactivar';
    
    if (confirm(`¿Está seguro de ${texto} este técnico?`)) {
        const url = `/tecnicos/${tecnicoId}/${accion}`;
        
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
            alert('Error al cambiar el estado del técnico');
        });
    }
}
</script>
@endsection

@section('styles')
<style>
.border-left-primary { border-left: 4px solid #007bff !important; }
.border-left-warning { border-left: 4px solid #ffc107 !important; }
.border-left-success { border-left: 4px solid #28a745 !important; }
.border-left-danger { border-left: 4px solid #dc3545 !important; }
.border-left-info { border-left: 4px solid #17a2b8 !important; }

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endsection