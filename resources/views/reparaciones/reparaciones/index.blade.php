@extends('layouts.app')

@section('title', 'Gestión de Reparaciones')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-wrench text-primary me-2"></i>
            Gestión de Reparaciones
        </h1>
        <p class="text-muted">Administra todas las órdenes de reparación del sistema</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('reparaciones.create') }}" class="btn btn-primary btn-custom">
            <i class="fas fa-plus me-2"></i>Nueva Reparación
        </a>
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
                <p class="mb-0">Total</p>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Reparaciones -->
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
                                <span class="badge bg-{{ $reparacion->estado_color }} text-white fs-6">
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
                                    <div class="progress mt-1" style="height: 4px;">
                                        <div class="progress-bar bg-{{ $reparacion->estado_color }}" 
                                             style="width: {{ $reparacion->progreso_porcentaje }}%"></div>
                                    </div>
                                @endif
                            </td>
                            
                            <!-- Acciones -->
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <!-- Ver -->
                                    <a href="{{ route('reparaciones.show', $reparacion) }}" 
                                       class="btn btn-outline-primary" 
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <!-- Editar -->
                                    <a href="{{ route('reparaciones.edit', $reparacion) }}" 
                                       class="btn btn-outline-warning" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Imprimir Ticket -->
                                    <button type="button" 
                                            class="btn btn-outline-info" 
                                            onclick="imprimirTicket({{ $reparacion->id }})"
                                            title="Imprimir ticket">
                                        <i class="fas fa-print"></i>
                                    </button>
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
</style>
@endsection