@extends('layouts.app')

@section('title', 'Gestión de Reparaciones')

@section('content')
<div class="container-fluid">
    <div class="module-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="module-title">
                    <i class="fas fa-wrench text-gradient me-3"></i>
                    Gestión de Reparaciones
                </h1>
                <p class="module-subtitle">Administra todas las órdenes de reparación del sistema</p>
            </div>
            <div class="col-lg-4 text-end">
                <a href="{{ route('reparaciones.create') }}" class="btn btn-primary btn-lg btn-modern">
                    <i class="fas fa-plus me-2"></i>Nueva Reparación
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Buscador Rápido -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('reparaciones.index') }}" id="busquedaForm">
            <div class="row align-items-end">
                <div class="col-md-4 mb-3">
                    <label class="form-label">
                        <i class="fas fa-search me-1"></i>Búsqueda Rápida
                    </label>
                    <input type="text" 
                           name="buscar" 
                           class="form-control" 
                           placeholder="Buscar por Nº, cliente, equipo, técnico..." 
                           value="{{ request('buscar') }}"
                           id="buscarInput">
                    <small class="text-muted">Busca en cualquier campo</small>
                </div>
                <div class="col-md-2 mb-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i>Buscar
                    </button>
                </div>
                <div class="col-md-6 mb-3 text-end">
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#filtrosAvanzados">
                        <i class="fas fa-filter me-1"></i>Filtros Avanzados
                    </button>
                    @if(request()->hasAny(['estado', 'tecnico_id', 'fecha_desde', 'fecha_hasta', 'cliente', 'buscar']))
                        <a href="{{ route('reparaciones.index') }}" class="btn btn-outline-warning">
                            <i class="fas fa-times me-1"></i>Limpiar Filtros
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Filtros Avanzados (Colapsable) -->
<div class="collapse {{ request()->hasAny(['estado', 'tecnico_id', 'fecha_desde', 'fecha_hasta', 'cliente']) ? 'show' : '' }}" id="filtrosAvanzados">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0">
                <i class="fas fa-sliders-h me-2"></i>Filtros Avanzados
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reparaciones.index') }}">
                <!-- Mantener búsqueda si existe -->
                @if(request('buscar'))
                    <input type="hidden" name="buscar" value="{{ request('buscar') }}">
                @endif
                
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
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
                        <label class="form-label">Técnico</label>
                        <select name="tecnico_id" class="form-select">
                            <option value="">Todos los técnicos</option>
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}" {{ request('tecnico_id') == $tecnico->id ? 'selected' : '' }}>
                                    {{ $tecnico->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Cliente</label>
                        <input type="text" 
                               name="cliente" 
                               class="form-control" 
                               placeholder="Nombre del cliente" 
                               value="{{ request('cliente') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Acciones Rápidas</label>
                        <div class="d-grid">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-filter me-1"></i>Aplicar
                                </button>
                                <button type="button" class="btn btn-outline-warning" onclick="limpiarFiltros()">
                                    <i class="fas fa-eraser me-1"></i>Limpiar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr class="my-3">
                
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Fecha Desde</label>
                        <input type="date" 
                               name="fecha_desde" 
                               class="form-control" 
                               value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fecha Hasta</label>
                        <input type="date" 
                               name="fecha_hasta" 
                               class="form-control" 
                               value="{{ request('fecha_hasta') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Filtros Especiales</label>
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="vencidas" 
                                   value="1" 
                                   {{ request('vencidas') ? 'checked' : '' }}
                                   id="vencidas">
                            <label class="form-check-label text-danger" for="vencidas">
                                <i class="fas fa-exclamation-triangle me-1"></i>Solo reparaciones vencidas
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Estadísticas Principales -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-card-danger">
            <div class="stat-card-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $reparaciones->where('estado', 'pendiente')->count() }}">0</h3>
                <p class="stat-card-label">Pendientes</p>
                <div class="stat-card-trend">
                    <i class="fas fa-chart-line"></i>
                    <span>{{ $reparaciones->total() > 0 ? round(($reparaciones->where('estado', 'pendiente')->count() / $reparaciones->total()) * 100, 1) : 0 }}% del total</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-icon">
                <i class="fas fa-cogs"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $reparaciones->where('estado', 'en_proceso')->count() }}">0</h3>
                <p class="stat-card-label">En Proceso</p>
                <div class="stat-card-trend">
                    <i class="fas fa-percentage"></i>
                    <span>{{ $reparaciones->total() > 0 ? round(($reparaciones->where('estado', 'en_proceso')->count() / $reparaciones->total()) * 100, 1) : 0 }}% del total</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-card-success">
            <div class="stat-card-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $reparaciones->where('estado', 'completada')->count() }}">0</h3>
                <p class="stat-card-label">Completadas</p>
                <div class="stat-card-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ $reparaciones->total() > 0 ? round(($reparaciones->where('estado', 'completada')->count() / $reparaciones->total()) * 100, 1) : 0 }}% completadas</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-card-info">
            <div class="stat-card-icon">
                <i class="fas fa-list"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $reparaciones->total() }}">0</h3>
                <p class="stat-card-label">Total Reparaciones</p>
                <div class="stat-card-trend">
                    <i class="fas fa-chart-line"></i>
                    <span>Base de datos completa</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Reparaciones -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($reparaciones->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover modern-table">
                    <thead class="table-dark">
                        <tr>
                            <th>Nº Reparación</th>
                            <th>Cliente</th>
                            <th>Equipo (Marca/Modelo)</th>
                            <th>Técnico Asignado</th>
                            <th>Fecha de Ingreso</th>
                            <th>Estado Actual</th>
                            <th width="180px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reparaciones as $reparacion)
                        <tr>
                            <!-- Nº Reparación -->
                            <td>
                                <strong class="text-primary">#{{ $reparacion->id }}</strong>
                                @if($reparacion->es_vencida)
                                    <br>
                                    <small class="badge bg-danger">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Vencida
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
                            
                            <!-- Técnico Asignado -->
                            <td>
                                <div>
                                    <strong>{{ $reparacion->tecnico->nombre_completo }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $reparacion->tecnico->especialidad }}</small>
                                </div>
                            </td>
                            
                            <!-- Fecha de Ingreso -->
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
                            
                            <!-- Acciones -->
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <!-- Ver -->
                                    <a href="{{ route('reparaciones.show', $reparacion) }}" 
                                       class="btn btn-outline-primary" 
                                       title="Ver detalles" data-bs-toggle="tooltip">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <!-- Editar -->
                                    <a href="{{ route('reparaciones.edit', $reparacion) }}" 
                                       class="btn btn-outline-warning" 
                                       title="Editar" data-bs-toggle="tooltip">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Imprimir Ticket -->
                                    <button type="button" 
                                            class="btn btn-outline-info" 
                                            onclick="imprimirTicket({{ $reparacion->id }})"
                                            title="Imprimir ticket" data-bs-toggle="tooltip">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    
                                    <!-- Cancelar Reparación -->
                                    @if(in_array($reparacion->estado, ['pendiente', 'en_proceso']))
                                    <button type="button" 
                                            class="btn btn-outline-danger" 
                                            onclick="cancelarReparacionRapida({{ $reparacion->id }}, '{{ $reparacion->equipo->marca }} {{ $reparacion->equipo->modelo }}')"
                                            title="Cancelar reparación" data-bs-toggle="tooltip">
                                        <i class="fas fa-times"></i>
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
                    de {{ $reparaciones->total() }} reparaciones
                </div>
                <div>
                    {{ $reparaciones->appends(request()->query())->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-tools display-1 text-muted mb-4"></i>
                <h4 class="text-muted">No se encontraron reparaciones</h4>
                <p class="text-muted">
                    @if(request()->hasAny(['estado', 'tecnico_id', 'fecha_desde', 'fecha_hasta', 'cliente', 'buscar']))
                        No hay reparaciones que coincidan con los filtros aplicados.
                    @else
                        No hay reparaciones registradas en el sistema.
                    @endif
                </p>
                <div class="mt-3">
                    @if(request()->hasAny(['estado', 'tecnico_id', 'fecha_desde', 'fecha_hasta', 'cliente', 'buscar']))
                        <a href="{{ route('reparaciones.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-times me-2"></i>Limpiar Filtros
                        </a>
                    @endif
                    <a href="{{ route('reparaciones.create') }}" class="btn btn-primary btn-custom">
                        <i class="fas fa-plus me-2"></i>Crear Primera Reparación
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
// Función para limpiar filtros
function limpiarFiltros() {
    window.location.href = '{{ route("reparaciones.index") }}';
}

// Función para imprimir ticket
function imprimirTicket(reparacionId) {
    // Crear ventana de impresión con el ticket
    const url = `/reparaciones/${reparacionId}/ticket`;
    const ventana = window.open(url, 'TicketImpresion', 'width=800,height=600,scrollbars=yes');
    
    if (ventana) {
        ventana.focus();
        // Esperar a que cargue y luego imprimir
        ventana.onload = function() {
            setTimeout(() => {
                ventana.print();
            }, 500);
        };
    } else {
        alert('Por favor, permite las ventanas emergentes para imprimir el ticket.');
    }
}

// Búsqueda en tiempo real (opcional)
let timeoutId;
document.getElementById('buscarInput').addEventListener('input', function() {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => {
        if (this.value.length > 2 || this.value.length === 0) {
            document.getElementById('busquedaForm').submit();
        }
    }, 800);
});

// Atajos de teclado
document.addEventListener('keydown', function(e) {
    // Ctrl + F para enfocar búsqueda
    if (e.ctrlKey && e.key === 'f') {
        e.preventDefault();
        document.getElementById('buscarInput').focus();
    }
    
    // Escape para limpiar filtros
    if (e.key === 'Escape') {
        limpiarFiltros();
    }
});

// Cancelar reparación desde la tabla (acción rápida)
function cancelarReparacionRapida(reparacionId, equipoInfo) {
    // Crear modal dinámico para confirmación
    const modalId = 'cancelarModal' + reparacionId;
    
    // Remover modal existente si hay uno
    const existingModal = document.getElementById(modalId);
    if (existingModal) {
        existingModal.remove();
    }
    
    // Crear nuevo modal
    const modalHTML = `
        <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Cancelar Reparación #${reparacionId}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-ban fa-3x text-danger mb-3"></i>
                            <h6>¿Está seguro de que desea cancelar esta reparación?</h6>
                            <p class="fw-bold text-dark">${equipoInfo}</p>
                        </div>
                        <div class="alert alert-warning border-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Advertencia:</strong> Esta acción cambiará el estado a "Cancelada" y establecerá la fecha de finalización automáticamente.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>No, mantener
                        </button>
                        <button type="button" class="btn btn-danger" id="btnConfirmarCancelar${reparacionId}" onclick="confirmarCancelacionRapida(${reparacionId})">
                            <span class="btn-text">
                                <i class="fas fa-ban me-2"></i>Sí, cancelar
                            </span>
                            <span class="btn-spinner d-none">
                                <i class="fas fa-spinner fa-spin me-2"></i>Cancelando...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Agregar modal al DOM
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Mostrar modal
    const modal = new bootstrap.Modal(document.getElementById(modalId));
    modal.show();
    
    // Limpiar modal cuando se cierre
    document.getElementById(modalId).addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}

// Confirmar cancelación desde modal dinámico
function confirmarCancelacionRapida(reparacionId) {
    const btnConfirmar = document.getElementById('btnConfirmarCancelar' + reparacionId);
    const btnText = btnConfirmar.querySelector('.btn-text');
    const btnSpinner = btnConfirmar.querySelector('.btn-spinner');
    
    // Mostrar loading
    btnConfirmar.disabled = true;
    btnText.classList.add('d-none');
    btnSpinner.classList.remove('d-none');
    
    // Hacer petición AJAX
    fetch(`/reparaciones/${reparacionId}/cambiar-estado`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            estado: 'cancelada',
            observaciones: 'Reparación cancelada desde la gestión de reparaciones'
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Cerrar modal
            const modalElement = document.getElementById('cancelarModal' + reparacionId);
            const modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
            
            // Mostrar mensaje de éxito
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show';
            alertDiv.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                <strong>¡Éxito!</strong> La reparación #${reparacionId} ha sido cancelada exitosamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            // Insertar mensaje en la parte superior
            const firstElement = document.querySelector('.row.mb-4') || document.body.firstChild;
            if (firstElement && firstElement.parentNode) {
                firstElement.parentNode.insertBefore(alertDiv, firstElement);
            }
            
            // Recargar la página después de 2 segundos para ver los cambios
            setTimeout(() => {
                window.location.reload();
            }, 2000);
            
            // Auto-dismiss alert
            setTimeout(() => {
                if (alertDiv && alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
            
            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
            
        } else {
            throw new Error(data.message || 'Error desconocido');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Mostrar mensaje de error
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.innerHTML = `
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Error:</strong> No se pudo cancelar la reparación. ${error.message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const firstElement = document.querySelector('.row.mb-4') || document.body.firstChild;
        if (firstElement && firstElement.parentNode) {
            firstElement.parentNode.insertBefore(alertDiv, firstElement);
        }
        
        // Auto-dismiss error alert
        setTimeout(() => {
            if (alertDiv && alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 7000);
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    })
    .finally(() => {
        // Restaurar estado del botón
        btnConfirmar.disabled = false;
        btnText.classList.remove('d-none');
        btnSpinner.classList.add('d-none');
    });
}

// Inicializar tooltips Bootstrap
document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
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

/* Module Header */
.module-header {
    background: var(--system-gradient);
    color: #fff;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
}
.module-title { font-size: 2.25rem; font-weight: 700; margin: 0; }
.module-subtitle { opacity: .9; margin-top: .25rem; }
.btn-modern { border-radius: 25px; padding: .75rem 1.5rem; font-weight: 600; }
.modern-table thead th { background: #f8fafc; border: none; text-transform: uppercase; letter-spacing: .5px; }
.modern-table tbody tr:hover { background: rgba(0,0,0,0.02); transform: scale(1.005); }
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
    color: #333 !important;
}

.table td {
    padding: 1rem 0.75rem;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
    color: #333 !important;
}

.table td strong {
    color: #333 !important;
}

.table td small {
    color: #666 !important;
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

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group-sm > .btn {
        padding: 0.25rem 0.375rem;
        font-size: 0.8rem;
    }
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

/* Responsive mejorado para estados */
@media (max-width: 768px) {
    .estado-badge {
        min-width: 80px;
        padding: 6px 8px !important;
        font-size: 0.75rem !important;
    }
    
    .estado-reparacion {
        min-width: 90px;
    }
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
</style>
@endsection