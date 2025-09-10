@extends('layouts.app')

@section('title', 'Detalles del Equipo - ' . $equipo->numero_serie)

@section('content')
<div class="container-fluid">
    <div class="module-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="module-title">
                    <i class="fas fa-laptop text-gradient me-3"></i>
                    Detalles del Equipo
                </h1>
                <p class="module-subtitle">Información completa y historial del equipo {{ $equipo->numero_serie }}</p>
            </div>
            <div class="col-lg-4 text-end">
                <div class="btn-group">
                    <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-warning btn-modern" data-bs-toggle="tooltip" title="Editar">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    <a href="{{ route('equipos.index') }}" class="btn btn-outline-light btn-modern" data-bs-toggle="tooltip" title="Volver">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Información Principal del Equipo -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle text-primary me-2"></i>
                    Información del Equipo
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Número de Serie</label>
                        <h6 class="mb-0">{{ $equipo->numero_serie }}</h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Estado Actual</label>
                        <div>
                            <span class="badge bg-{{ $equipo->estado_color }} text-white fs-6">
                                {{ ucfirst(str_replace('_', ' ', $equipo->estado)) }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Marca</label>
                        <h6 class="mb-0">{{ $equipo->marca }}</h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Modelo</label>
                        <h6 class="mb-0">{{ $equipo->modelo }}</h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Tipo de Equipo</label>
                        <h6 class="mb-0">{{ $equipo->tipo_equipo }}</h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Fecha de Ingreso</label>
                        <h6 class="mb-0">{{ $equipo->fecha_ingreso->format('d/m/Y') }}</h6>
                    </div>
                    @if($equipo->descripcion)
                    <div class="col-12 mb-3">
                        <label class="text-muted small">Descripción</label>
                        <p class="mb-0">{{ $equipo->descripcion }}</p>
                    </div>
                    @endif
                    @if($equipo->observaciones)
                    <div class="col-12 mb-3">
                        <label class="text-muted small">Observaciones</label>
                        <p class="mb-0">{{ $equipo->observaciones }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Historial de Reparaciones -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-transparent border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-history text-info me-2"></i>
                        Historial de Reparaciones
                    </h5>
                    @if(in_array($equipo->estado, ['recibido', 'en_reparacion']))
                        <a href="{{ route('reparaciones.create', ['equipo_id' => $equipo->id]) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-plus me-2"></i>Nueva Reparación
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if($equipo->reparaciones->count() > 0)
                    <div class="timeline">
                        @foreach($equipo->reparaciones->sortByDesc('created_at') as $reparacion)
                        <div class="timeline-item mb-4">
                            <div class="row">
                                <div class="col-md-2 text-center">
                                    <div class="timeline-icon bg-{{ $reparacion->estado_color }} text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-wrench"></i>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">{{ $reparacion->created_at->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="card border-left-{{ $reparacion->estado_color }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="mb-0">Reparación #{{ $reparacion->id }}</h6>
                                                <span class="badge bg-{{ $reparacion->estado_color }} text-white">
                                                    {{ ucfirst($reparacion->estado) }}
                                                </span>
                                            </div>
                                            <p class="text-muted mb-2">{{ $reparacion->descripcion_problema }}</p>
                                            @if($reparacion->diagnostico)
                                                <p class="mb-2"><strong>Diagnóstico:</strong> {{ $reparacion->diagnostico }}</p>
                                            @endif
                                            @if($reparacion->solucion)
                                                <p class="mb-2"><strong>Solución:</strong> {{ $reparacion->solucion }}</p>
                                            @endif
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="fas fa-user me-1"></i>
                                                    {{ $reparacion->tecnico->nombre_completo }}
                                                </small>
                                                <a href="{{ route('reparaciones.show', $reparacion) }}" class="btn btn-sm btn-outline-primary">
                                                    Ver detalles
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-tools display-6 text-muted mb-3"></i>
                        <h6 class="text-muted">No hay reparaciones registradas</h6>
                        <p class="text-muted">Este equipo aún no tiene historial de reparaciones.</p>
                        <a href="{{ route('reparaciones.create', ['equipo_id' => $equipo->id]) }}" class="btn btn-success btn-custom">
                            <i class="fas fa-plus me-2"></i>Primera Reparación
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Información del Cliente y Acciones -->
    <div class="col-lg-4">
        <!-- Información del Cliente -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-user text-info me-2"></i>
                    Información del Cliente
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Nombre</label>
                    <h6 class="mb-0">{{ $equipo->cliente_nombre }}</h6>
                </div>
                @if($equipo->cliente_telefono)
                <div class="mb-3">
                    <label class="text-muted small">Teléfono</label>
                    <h6 class="mb-0">
                        <a href="tel:{{ $equipo->cliente_telefono }}" class="text-decoration-none">
                            <i class="fas fa-phone me-2"></i>{{ $equipo->cliente_telefono }}
                        </a>
                    </h6>
                </div>
                @endif
                @if($equipo->cliente_email)
                <div class="mb-3">
                    <label class="text-muted small">Email</label>
                    <h6 class="mb-0">
                        <a href="mailto:{{ $equipo->cliente_email }}" class="text-decoration-none">
                            <i class="fas fa-envelope me-2"></i>{{ $equipo->cliente_email }}
                        </a>
                    </h6>
                </div>
                @endif
                @if($equipo->costo_estimado)
                <div class="mb-3">
                    <label class="text-muted small">Costo Estimado</label>
                    <h6 class="mb-0 text-success">Q{{ number_format($equipo->costo_estimado, 2) }}</h6>
                </div>
                @endif
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($equipo->estado !== 'entregado')
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-exchange-alt me-2"></i>Cambiar Estado
                            </button>
                            <ul class="dropdown-menu w-100">
                                @if($equipo->estado !== 'recibido')
                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $equipo->id }}, 'recibido')">
                                        <i class="fas fa-inbox me-2"></i>Recibido
                                    </a></li>
                                @endif
                                @if($equipo->estado !== 'en_reparacion')
                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $equipo->id }}, 'en_reparacion')">
                                        <i class="fas fa-wrench me-2"></i>En Reparación
                                    </a></li>
                                @endif
                                @if($equipo->estado !== 'reparado')
                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $equipo->id }}, 'reparado')">
                                        <i class="fas fa-check me-2"></i>Reparado
                                    </a></li>
                                @endif
                                <li><a class="dropdown-item text-success" href="#" onclick="cambiarEstado({{ $equipo->id }}, 'entregado')">
                                    <i class="fas fa-handshake me-2"></i>Entregado
                                </a></li>
                            </ul>
                        </div>
                    @endif
                    
                    @if(in_array($equipo->estado, ['recibido', 'en_reparacion']))
                        <a href="{{ route('reparaciones.create', ['equipo_id' => $equipo->id]) }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Nueva Reparación
                        </a>
                    @endif
                    
                    <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Editar Equipo
                    </a>
                </div>
            </div>
        </div>

        <!-- Estadísticas del Equipo -->
        @if($equipo->reparaciones->count() > 0)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar text-success me-2"></i>
                    Estadísticas
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <h4 class="text-primary">{{ $equipo->reparaciones->count() }}</h4>
                        <small class="text-muted">Reparaciones</small>
                    </div>
                    <div class="col-6 mb-3">
                        <h4 class="text-success">{{ $equipo->reparaciones->where('estado', 'completada')->count() }}</h4>
                        <small class="text-muted">Completadas</small>
                    </div>
                    <div class="col-12">
                        <h4 class="text-info">Q{{ number_format($equipo->reparaciones->sum('costo'), 2) }}</h4>
                        <small class="text-muted">Costo Total</small>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
// Inicializar tooltips
document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
function cambiarEstado(equipoId, nuevoEstado) {
    const estadoTexto = {
        'recibido': 'Recibido',
        'en_reparacion': 'En Reparación',
        'reparado': 'Reparado',
        'entregado': 'Entregado'
    };
    
    if (confirm(`¿Está seguro de cambiar el estado a "${estadoTexto[nuevoEstado]}"?`)) {
        fetch(`/equipos/${equipoId}/cambiar-estado`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                estado: nuevoEstado
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al cambiar el estado: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cambiar el estado del equipo');
        });
    }
}
</script>
@endsection

@section('styles')
<style>
.module-header { background: var(--system-gradient); color: #fff; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.08); }
.module-title { font-size: 2.25rem; font-weight: 700; margin: 0; }
.module-subtitle { opacity: .9; margin-top: .25rem; }
.btn-modern { border-radius: 25px; padding: .5rem 1.25rem; font-weight: 600; }
.border-left-primary { border-left: 4px solid #007bff !important; }
.border-left-warning { border-left: 4px solid #ffc107 !important; }
.border-left-success { border-left: 4px solid #28a745 !important; }
.border-left-danger { border-left: 4px solid #dc3545 !important; }
.border-left-info { border-left: 4px solid #17a2b8 !important; }

.timeline-item {
    position: relative;
}
.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 19px;
    top: 50px;
    width: 2px;
    height: calc(100% - 50px);
    background: #dee2e6;
}
</style>
@endsection