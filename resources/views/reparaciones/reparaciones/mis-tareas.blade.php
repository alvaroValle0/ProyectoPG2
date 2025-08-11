@extends('layouts.app')

@section('title', 'Mis Tareas')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-tasks text-primary me-2"></i>
            Mis Tareas
        </h1>
        <p class="text-muted">Gestiona las reparaciones asignadas a ti</p>
    </div>
    <div class="col-md-4 text-end">
        <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-outline-info" onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-1"></i>Actualizar
            </button>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('reparaciones.mis-tareas') }}" id="filtrosForm">
            <div class="row align-items-end g-3">
                <div class="col-md-3">
                    <label class="form-label">
                        <i class="fas fa-filter me-1"></i>Estado
                    </label>
                    <select name="estado" class="form-select" onchange="this.form.submit()">
                        <option value="">Todos los estados</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>
                            Pendiente
                        </option>
                        <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>
                            En Proceso
                        </option>
                        <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>
                            Completada
                        </option>
                        <option value="cancelada" {{ request('estado') == 'cancelada' ? 'selected' : '' }}>
                            Cancelada
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha Desde</label>
                    <input type="date" 
                           name="fecha_desde" 
                           class="form-control" 
                           value="{{ request('fecha_desde') }}"
                           onchange="this.form.submit()">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha Hasta</label>
                    <input type="date" 
                           name="fecha_hasta" 
                           class="form-control" 
                           value="{{ request('fecha_hasta') }}"
                           onchange="this.form.submit()">
                </div>
                <div class="col-md-3">
                    <div class="d-grid">
                        @if(request()->hasAny(['estado', 'fecha_desde', 'fecha_hasta']))
                            <a href="{{ route('reparaciones.mis-tareas') }}" class="btn btn-outline-warning">
                                <i class="fas fa-times me-1"></i>Limpiar Filtros
                            </a>
                        @else
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i>Aplicar Filtros
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Estadísticas Rápidas -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-danger text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-clock display-6 mb-2"></i>
                <h4>{{ $reparaciones->where('estado', 'pendiente')->count() }}</h4>
                <p class="mb-0">Pendientes</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-warning text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-cogs display-6 mb-2"></i>
                <h4>{{ $reparaciones->where('estado', 'en_proceso')->count() }}</h4>
                <p class="mb-0">En Proceso</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-success text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-check-circle display-6 mb-2"></i>
                <h4>{{ $reparaciones->where('estado', 'completada')->count() }}</h4>
                <p class="mb-0">Completadas</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-info text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-list display-6 mb-2"></i>
                <h4>{{ $reparaciones->total() }}</h4>
                <p class="mb-0">Total Asignadas</p>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Mis Tareas -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($reparaciones->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nº Reparación</th>
                            <th>Cliente</th>
                            <th>Equipo (Marca/Modelo)</th>
                            <th>Fecha de Asignación</th>
                            <th>Estado Actual</th>
                            <th>Tiempo Transcurrido</th>
                            <th width="200px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reparaciones as $reparacion)
                        <tr>
                            <!-- Nº Reparación -->
                            <td>
                                <strong class="text-primary">#{{ $reparacion->id }}</strong>
                                @if($reparacion->fecha_inicio < now()->subDays(7) && in_array($reparacion->estado, ['pendiente', 'en_proceso']))
                                    <br>
                                    <small class="badge bg-danger">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Atrasada
                                    </small>
                                @endif
                            </td>
                            
                            <!-- Cliente -->
                            <td>
                                <div>
                                    <strong>{{ $reparacion->equipo->cliente_nombre }}</strong>
                                    @if($reparacion->equipo->cliente_telefono)
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-phone me-1"></i>{{ $reparacion->equipo->cliente_telefono }}
                                        </small>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Equipo (Marca/Modelo) -->
                            <td>
                                <div>
                                    <strong>{{ $reparacion->equipo->marca }} {{ $reparacion->equipo->modelo }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-barcode me-1"></i>{{ $reparacion->equipo->numero_serie }}
                                    </small>
                                    <br>
                                    <small class="badge bg-light text-dark">{{ $reparacion->equipo->tipo_equipo }}</small>
                                </div>
                            </td>
                            
                            <!-- Fecha de Asignación -->
                            <td>
                                <div>
                                    <strong>{{ $reparacion->fecha_inicio->format('d/m/Y') }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $reparacion->fecha_inicio->diffForHumans() }}
                                    </small>
                                    @if($reparacion->fecha_fin)
                                        <br>
                                        <small class="text-success">
                                            <i class="fas fa-flag-checkered me-1"></i>
                                            Finalizada: {{ $reparacion->fecha_fin->format('d/m/Y') }}
                                        </small>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Estado Actual -->
                            <td>
                                <div class="estado-reparacion">
                                    <span class="badge bg-{{ $reparacion->estado_color }} text-white fs-6 estado-badge">
                                        @switch($reparacion->estado)
                                            @case('pendiente')
                                                <i class="fas fa-clock me-1"></i>Pendiente
                                                @break
                                            @case('en_proceso')
                                                <i class="fas fa-cogs me-1"></i>En Proceso
                                                @break
                                            @case('completada')
                                                <i class="fas fa-check-circle me-1"></i>Completada
                                                @break
                                            @case('cancelada')
                                                <i class="fas fa-times-circle me-1"></i>Cancelada
                                                @break
                                            @default
                                                {{ ucfirst($reparacion->estado) }}
                                        @endswitch
                                    </span>
                                    @if($reparacion->progreso_porcentaje > 0 && $reparacion->estado !== 'completada')
                                        <div class="progress mt-2" style="height: 6px;">
                                            <div class="progress-bar bg-{{ $reparacion->estado_color }}" 
                                                 style="width: {{ $reparacion->progreso_porcentaje }}%"></div>
                                        </div>
                                        <small class="text-muted d-block mt-1">{{ $reparacion->progreso_porcentaje }}% completado</small>
                                    @endif
                                </div>
                            </td>

                            <!-- Tiempo Transcurrido -->
                            <td>
                                @php
                                    $fechaFin = $reparacion->fecha_fin ?? now();
                                    $diasTranscurridos = $reparacion->fecha_inicio->diffInDays($fechaFin);
                                @endphp
                                <div class="text-center">
                                    <strong class="text-{{ $diasTranscurridos > 7 ? 'danger' : ($diasTranscurridos > 3 ? 'warning' : 'success') }}">
                                        {{ $diasTranscurridos }} días
                                    </strong>
                                    @if($diasTranscurridos > 7 && in_array($reparacion->estado, ['pendiente', 'en_proceso']))
                                        <br>
                                        <small class="text-danger">
                                            <i class="fas fa-exclamation-triangle"></i> Requiere atención
                                        </small>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Acciones -->
                            <td>
                                <div class="btn-group-vertical btn-group-sm w-100" role="group">
                                    <!-- Ver -->
                                    <a href="{{ route('reparaciones.show', $reparacion) }}" 
                                       class="btn btn-outline-primary mb-1" 
                                       title="Ver detalles">
                                        <i class="fas fa-eye me-1"></i>Ver Detalles
                                    </a>
                                    
                                    <!-- Editar (solo para reparaciones pendientes o en proceso) -->
                                    @if(in_array($reparacion->estado, ['pendiente', 'en_proceso']))
                                    <a href="{{ route('reparaciones.edit', $reparacion) }}" 
                                       class="btn btn-outline-warning mb-1" 
                                       title="Editar">
                                        <i class="fas fa-edit me-1"></i>Actualizar
                                    </a>
                                    @endif
                                    
                                    <!-- Cambiar estado rápido -->
                                    @if($reparacion->estado == 'pendiente')
                                    <button type="button" 
                                            class="btn btn-outline-success mb-1" 
                                            onclick="cambiarEstadoRapido({{ $reparacion->id }}, 'en_proceso')"
                                            title="Marcar como en proceso">
                                        <i class="fas fa-play me-1"></i>Iniciar
                                    </button>
                                    @elseif($reparacion->estado == 'en_proceso')
                                    <button type="button" 
                                            class="btn btn-outline-success mb-1" 
                                            onclick="cambiarEstadoRapido({{ $reparacion->id }}, 'completada')"
                                            title="Marcar como completada">
                                        <i class="fas fa-check me-1"></i>Completar
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Mostrando {{ $reparaciones->firstItem() }} a {{ $reparaciones->lastItem() }} 
                    de {{ $reparaciones->total() }} tareas
                </div>
                <div>
                    {{ $reparaciones->appends(request()->query())->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-tasks display-1 text-muted mb-4"></i>
                <h4 class="text-muted">No tienes tareas asignadas</h4>
                <p class="text-muted">
                    @if(request()->hasAny(['estado', 'fecha_desde', 'fecha_hasta']))
                        No hay reparaciones que coincidan con los filtros aplicados.
                    @else
                        Actualmente no tienes reparaciones asignadas.
                    @endif
                </p>
                @if(request()->hasAny(['estado', 'fecha_desde', 'fecha_hasta']))
                    <div class="mt-3">
                        <a href="{{ route('reparaciones.mis-tareas') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Limpiar Filtros
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
// Función para cambiar estado rápido
function cambiarEstadoRapido(reparacionId, nuevoEstado) {
    const estadoTexto = {
        'en_proceso': 'En Proceso',
        'completada': 'Completada'
    };
    
    if (confirm(`¿Está seguro de cambiar el estado a "${estadoTexto[nuevoEstado]}"?`)) {
        // Mostrar loading en el botón
        const botones = document.querySelectorAll(`button[onclick*="${reparacionId}"]`);
        botones.forEach(btn => {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Procesando...';
        });
        
        // Hacer petición AJAX
        fetch(`/reparaciones/${reparacionId}/cambiar-estado`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                estado: nuevoEstado,
                observaciones: `Estado cambiado a ${estadoTexto[nuevoEstado]} desde Mis Tareas`
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar mensaje de éxito
                mostrarAlerta('success', `¡Éxito! La reparación #${reparacionId} ha sido marcada como "${estadoTexto[nuevoEstado]}".`);
                
                // Recargar la página después de 1.5 segundos
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                throw new Error(data.message || 'Error desconocido');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarAlerta('danger', `Error: No se pudo cambiar el estado. ${error.message}`);
            
            // Restaurar botones
            botones.forEach(btn => {
                btn.disabled = false;
                btn.innerHTML = btn.getAttribute('data-original-html') || 'Acción';
            });
        });
    }
}

// Función para mostrar alertas
function mostrarAlerta(tipo, mensaje) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <i class="fas fa-${tipo === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insertar mensaje en la parte superior
    const firstElement = document.querySelector('.row.mb-4') || document.body.firstChild;
    if (firstElement && firstElement.parentNode) {
        firstElement.parentNode.insertBefore(alertDiv, firstElement);
    }
    
    // Auto-dismiss alert
    setTimeout(() => {
        if (alertDiv && alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Auto-refresh cada 5 minutos para mantener actualizada la información
setInterval(() => {
    // Solo refrescar si no hay modales abiertos
    if (!document.querySelector('.modal.show')) {
        const ahora = new Date();
        const minutos = ahora.getMinutes();
        
        // Solo refrescar en minutos múltiplos de 5
        if (minutos % 5 === 0) {
            window.location.reload();
        }
    }
}, 60000); // Verificar cada minuto

// Guardar HTML original de los botones para restaurar en caso de error
document.addEventListener('DOMContentLoaded', function() {
    const botones = document.querySelectorAll('button[onclick*="cambiarEstadoRapido"]');
    botones.forEach(btn => {
        btn.setAttribute('data-original-html', btn.innerHTML);
    });
});

// Atajos de teclado para técnicos
document.addEventListener('keydown', function(e) {
    // Ctrl + R para recargar
    if (e.ctrlKey && e.key === 'r') {
        e.preventDefault();
        window.location.reload();
    }
    
    // Escape para limpiar filtros
    if (e.key === 'Escape') {
        window.location.href = '{{ route("reparaciones.mis-tareas") }}';
    }
});
</script>
@endsection

@section('styles')
<style>
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

.btn-group-vertical > .btn {
    margin-bottom: 2px;
}

.btn-group-sm > .btn {
    padding: 0.375rem 0.5rem;
    font-size: 0.875rem;
}

.progress {
    background-color: rgba(0, 0, 0, 0.1);
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

/* Estilos mejorados para badges de estado de reparaciones */
.estado-badge {
    font-weight: 600 !important;
    padding: 8px 12px !important;
    font-size: 0.875rem !important;
    border-radius: 6px !important;
    min-width: 100px;
    text-align: center;
    display: inline-block;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Colores específicos para estados con mejor contraste */
.bg-danger {
    background-color: #dc3545 !important;
    border: 2px solid #b02a37 !important;
}

.bg-warning {
    background-color: #fd7e14 !important;
    border: 2px solid #fd7e14 !important;
    color: white !important;
}

.bg-success {
    background-color: #198754 !important;
    border: 2px solid #157347 !important;
}

.bg-secondary {
    background-color: #6c757d !important;
    border: 2px solid #5c636a !important;
}

/* Contenedor de estado mejorado */
.estado-reparacion {
    text-align: center;
    min-width: 120px;
}

/* Barra de progreso con mejor visibilidad */
.progress {
    border-radius: 4px;
    background-color: #e9ecef;
    overflow: hidden;
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
}

.progress-bar {
    transition: width 0.3s ease;
}

/* Hover effect para badges */
.estado-badge:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    transition: all 0.2s ease;
}

/* Iconos en badges */
.estado-badge i {
    margin-right: 4px;
}

/* Estilos específicos para mis tareas */
.btn-group-vertical .btn {
    border-radius: 4px !important;
    margin-bottom: 3px;
}

.btn-group-vertical .btn:last-child {
    margin-bottom: 0;
}

/* Indicadores de tiempo */
.text-warning {
    color: #fd7e14 !important;
}

.text-danger {
    color: #dc3545 !important;
}

.text-success {
    color: #198754 !important;
}

/* Responsive mejorado */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group-vertical > .btn {
        padding: 0.25rem 0.375rem;
        font-size: 0.8rem;
        margin-bottom: 2px;
    }
    
    .estado-badge {
        min-width: 80px;
        padding: 6px 8px !important;
        font-size: 0.75rem !important;
    }
    
    .estado-reparacion {
        min-width: 90px;
    }
}

/* Animaciones para las alertas */
.alert {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Estilos para el auto-refresh indicator */
.auto-refresh-indicator {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
    padding: 5px 10px;
    background: rgba(0, 123, 255, 0.8);
    color: white;
    border-radius: 4px;
    font-size: 0.75rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.auto-refresh-indicator.show {
    opacity: 1;
}
</style>
@endsection
