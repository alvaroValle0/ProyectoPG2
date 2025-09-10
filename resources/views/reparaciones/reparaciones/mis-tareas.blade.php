@extends('layouts.app')

@section('title', 'Mis Tareas')

@section('content')
<div class="container-fluid">
    <div class="module-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="module-title">
                    <i class="fas fa-tasks text-gradient me-3"></i>
                    Mis Tareas
                </h1>
                <p class="module-subtitle">Gestiona tus reparaciones con una vista clara y accionable</p>
            </div>
            <div class="col-lg-4 text-end">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('reparaciones.mis-tareas.exportar', request()->query()) }}" class="btn btn-outline-light btn-modern" data-bs-toggle="tooltip" title="Exportar listado (CSV)">
                        <i class="fas fa-file-csv me-2"></i>Exportar
                    </a>
                    <button type="button" class="btn btn-light btn-modern" onclick="window.location.reload()" data-bs-toggle="tooltip" title="Recargar la lista">
                        <i class="fas fa-sync-alt me-2"></i>Actualizar
                    </button>
                </div>
            </div>
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
                    <label class="form-label">Ordenar por</label>
                    <select name="orden" class="form-select" onchange="this.form.submit()">
                        <option value="recientes" {{ ($orden ?? request('orden')) == 'recientes' ? 'selected' : '' }}>Más recientes</option>
                        <option value="antiguas" {{ ($orden ?? request('orden')) == 'antiguas' ? 'selected' : '' }}>Más antiguas</option>
                        <option value="estado_asc" {{ ($orden ?? request('orden')) == 'estado_asc' ? 'selected' : '' }}>Estado (A-Z)</option>
                        <option value="estado_desc" {{ ($orden ?? request('orden')) == 'estado_desc' ? 'selected' : '' }}>Estado (Z-A)</option>
                    </select>
                </div>
            </div>

            <div class="row align-items-end g-3 mt-2">
                <div class="col-md-6">
                    <label class="form-label">Búsqueda rápida</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="buscar" class="form-control" placeholder="ID, serie, cliente, marca, modelo, descripción..." value="{{ request('buscar') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="chkAtrasadas" name="atrasadas" value="1" {{ request('atrasadas') ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="form-check-label" for="chkAtrasadas">
                            Mostrar solo atrasadas
                        </label>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('reparaciones.mis-tareas') }}" class="btn btn-outline-warning">
                            <i class="fas fa-times me-1"></i>Limpiar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i>Aplicar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
</div>

<!-- Estadísticas Rápidas -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-danger text-white h-100 kpi">
            <div class="card-body text-center">
                <i class="fas fa-clock display-6 mb-2"></i>
                <h4>{{ $kpis['pendientes'] ?? $reparaciones->where('estado', 'pendiente')->count() }}</h4>
                <p class="mb-0">Pendientes</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-warning text-white h-100 kpi">
            <div class="card-body text-center">
                <i class="fas fa-cogs display-6 mb-2"></i>
                <h4>{{ $kpis['en_proceso'] ?? $reparaciones->where('estado', 'en_proceso')->count() }}</h4>
                <p class="mb-0">En Proceso</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-success text-white h-100 kpi">
            <div class="card-body text-center">
                <i class="fas fa-check-circle display-6 mb-2"></i>
                <h4>{{ $kpis['completadas'] ?? $reparaciones->where('estado', 'completada')->count() }}</h4>
                <p class="mb-0">Completadas</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-info text-white h-100 kpi">
            <div class="card-body text-center">
                <i class="fas fa-list display-6 mb-2"></i>
                <h4>{{ $kpis['total'] ?? $reparaciones->total() }}</h4>
                <p class="mb-0">Total Asignadas</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-secondary text-white h-100 kpi">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle display-6 mb-2"></i>
                <h4>{{ $kpis['atrasadas'] ?? 0 }}</h4>
                <p class="mb-0">Atrasadas</p>
            </div>
        </div>
    </div>
</div>

<!-- Leyenda de estados -->
<div class="d-flex flex-wrap align-items-center mb-3 gap-2">
    <span class="badge bg-danger"><i class="fas fa-clock me-1"></i>Pendiente</span>
    <span class="badge bg-warning"><i class="fas fa-cogs me-1"></i>En Proceso</span>
    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Completada</span>
    <span class="badge bg-secondary"><i class="fas fa-times-circle me-1"></i>Cancelada</span>
    <span class="text-muted ms-2">Leyenda de estados</span>
    <div class="ms-auto form-check form-switch">
        <input class="form-check-input" type="checkbox" id="switchCompacto">
        <label class="form-check-label" for="switchCompacto">Modo compacto</label>
    </div>
    
    
</div>

<!-- Tabla de Mis Tareas -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($reparaciones->count() > 0)
            <div class="table-responsive">
                @php
                    $chips = [];
                    if(request('estado')) $chips[] = ['label' => 'Estado: ' . ucfirst(str_replace('_',' ',request('estado'))), 'param' => 'estado'];
                    if(request('fecha_desde')) $chips[] = ['label' => 'Desde: ' . request('fecha_desde'), 'param' => 'fecha_desde'];
                    if(request('fecha_hasta')) $chips[] = ['label' => 'Hasta: ' . request('fecha_hasta'), 'param' => 'fecha_hasta'];
                    if(request('buscar')) $chips[] = ['label' => 'Buscar: ' . request('buscar'), 'param' => 'buscar'];
                    if(request('atrasadas')) $chips[] = ['label' => 'Solo atrasadas', 'param' => 'atrasadas'];
                @endphp
                @if(count($chips))
                    <div class="mb-2">
                        @foreach($chips as $chip)
                            <a href="{{ request()->fullUrlWithQuery([$chip['param'] => null]) }}" class="badge bg-light text-dark me-1" title="Quitar filtro">
                                <i class="fas fa-filter me-1"></i>{{ $chip['label'] }}
                                <i class="fas fa-times ms-1"></i>
                            </a>
                        @endforeach
                    </div>
                @endif

                <div class="d-flex justify-content-end mb-2">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-columns me-1"></i> Columnas
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-2" style="min-width: 220px;">
                            <div class="form-check">
                                <input class="form-check-input chk-col" type="checkbox" value="col-cliente" id="colCliente" checked>
                                <label class="form-check-label" for="colCliente">Cliente</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input chk-col" type="checkbox" value="col-equipo" id="colEquipo" checked>
                                <label class="form-check-label" for="colEquipo">Equipo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input chk-col" type="checkbox" value="col-fecha" id="colFecha" checked>
                                <label class="form-check-label" for="colFecha">Fecha de Asignación</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input chk-col" type="checkbox" value="col-estado" id="colEstado" checked>
                                <label class="form-check-label" for="colEstado">Estado</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input chk-col" type="checkbox" value="col-tiempo" id="colTiempo" checked>
                                <label class="form-check-label" for="colTiempo">Tiempo</label>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-hover modern-table" id="tablaTareas">
                    <thead class="table-dark sticky-top" style="z-index: 1;">
                        <tr>
                            <th class="col-num">Nº Reparación</th>
                            <th class="col-cliente">Cliente</th>
                            <th class="col-equipo">Equipo (Marca/Modelo)</th>
                            <th class="col-fecha">Fecha de Asignación</th>
                            <th class="col-estado">Estado Actual</th>
                            <th class="col-tiempo">Tiempo Transcurrido</th>
                            <th width="200px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reparaciones as $reparacion)
                        <tr onclick="window.location='{{ route('reparaciones.show', $reparacion) }}'" style="cursor: pointer;">
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
                            <td class="col-cliente">
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
                            <td class="col-equipo">
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
                            <td class="col-fecha">
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
                            <td class="col-estado">
                                <div class="estado-reparacion">
                                    <span class="badge bg-{{ $reparacion->estado_color }} text-white fs-6 estado-badge">
                                        <span class="status-dot me-1 bg-{{ $reparacion->estado_color }}"></span>
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
                            <td class="col-tiempo">
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
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="event.stopPropagation();">
                                        <i class="fas fa-ellipsis-h"></i> Acciones
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end w-100">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('reparaciones.show', $reparacion) }}" onclick="event.stopPropagation();">
                                                <i class="fas fa-eye me-2"></i>Ver detalles
                                            </a>
                                        </li>
                                        @if(in_array($reparacion->estado, ['pendiente', 'en_proceso']))
                                        <li>
                                            <a class="dropdown-item" href="{{ route('reparaciones.edit', $reparacion) }}" onclick="event.stopPropagation();">
                                                <i class="fas fa-edit me-2"></i>Actualizar
                                            </a>
                                        </li>
                                        @endif
                                        @if($reparacion->estado == 'pendiente')
                                        <li>
                                            <a class="dropdown-item text-success" href="#" onclick="event.preventDefault(); event.stopPropagation(); cambiarEstadoRapido({{ $reparacion->id }}, 'en_proceso');">
                                                <i class="fas fa-play me-2"></i>Iniciar
                                            </a>
                                        </li>
                                        @elseif($reparacion->estado == 'en_proceso')
                                        <li>
                                            <a class="dropdown-item text-success" href="#" onclick="event.preventDefault(); event.stopPropagation(); cambiarEstadoRapido({{ $reparacion->id }}, 'completada');">
                                                <i class="fas fa-check me-2"></i>Completar
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
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
                <div class="d-flex align-items-center gap-2">
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('reparaciones.mis-tareas.exportar', request()->query()) }}">
                        <i class="fas fa-file-csv me-1"></i> Exportar CSV
                    </a>
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

// Tooltips y modo compacto
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Modo compacto para tabla
    const switchCompacto = document.getElementById('switchCompacto');
    if (switchCompacto) {
        switchCompacto.addEventListener('change', function() {
            const tabla = document.getElementById('tablaTareas');
            if (!tabla) return;
            if (this.checked) {
                tabla.classList.add('table-sm');
                localStorage.setItem('misTareas.modoCompacto', '1');
            } else {
                tabla.classList.remove('table-sm');
                localStorage.removeItem('misTareas.modoCompacto');
            }
        });
        // Restaurar preferencia
        if (localStorage.getItem('misTareas.modoCompacto') === '1') {
            switchCompacto.checked = true;
            document.getElementById('tablaTareas')?.classList.add('table-sm');
        }
    }

    // Selector de columnas con persistencia
    const checkboxes = document.querySelectorAll('.chk-col');
    const applyColumnsVisibility = () => {
        const hidden = JSON.parse(localStorage.getItem('misTareas.hiddenCols') || '[]');
        ['col-cliente','col-equipo','col-fecha','col-estado','col-tiempo'].forEach(cls => {
            const hide = hidden.includes(cls);
            document.querySelectorAll('.' + cls).forEach(el => {
                el.style.display = hide ? 'none' : '';
            });
        });
        checkboxes.forEach(cb => {
            cb.checked = !hidden.includes(cb.value);
        });
    };
    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            const hidden = JSON.parse(localStorage.getItem('misTareas.hiddenCols') || '[]');
            if (!cb.checked && !hidden.includes(cb.value)) hidden.push(cb.value);
            if (cb.checked) {
                const idx = hidden.indexOf(cb.value);
                if (idx >= 0) hidden.splice(idx, 1);
            }
            localStorage.setItem('misTareas.hiddenCols', JSON.stringify(hidden));
            applyColumnsVisibility();
        });
    });
    applyColumnsVisibility();
});
</script>
@endsection

@section('styles')
<style>
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

/* KPIs con sutil gradiente y realce */
.kpi {
    background-image: linear-gradient(135deg, rgba(255,255,255,0.08), rgba(0,0,0,0.08));
    border-radius: 14px;
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

/* Indicador tipo dot para estado */
.status-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: currentColor;
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
