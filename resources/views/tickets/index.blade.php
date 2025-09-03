@extends('layouts.app')

@section('title', 'Gestión de Tickets')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-ticket-alt text-primary me-2"></i>
            Gestión de Tickets
        </h1>
        <p class="text-muted">Administra los tickets de ingreso, entrega y servicio</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('tickets.create') }}" class="btn btn-primary btn-custom">
            <i class="fas fa-plus me-2"></i>Nuevo Ticket
        </a>
    </div>
</div>

<!-- Estadísticas Rápidas -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-primary text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-ticket-alt display-6 mb-2"></i>
                <h4>{{ $estadisticas['total_tickets'] }}</h4>
                <p class="mb-0">Total Tickets</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-warning text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-clock display-6 mb-2"></i>
                <h4>{{ $estadisticas['tickets_generados'] }}</h4>
                <p class="mb-0">Generados</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-info text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-signature display-6 mb-2"></i>
                <h4>{{ $estadisticas['tickets_firmados'] }}</h4>
                <p class="mb-0">Firmados</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-success text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-check-circle display-6 mb-2"></i>
                <h4>{{ $estadisticas['tickets_entregados'] }}</h4>
                <p class="mb-0">Entregados</p>
            </div>
        </div>
    </div>
</div>

<!-- Filtros y Búsqueda -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('tickets.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado">
                    <option value="">Todos los estados</option>
                    <option value="generado" {{ request('estado') == 'generado' ? 'selected' : '' }}>Generado</option>
                    <option value="firmado" {{ request('estado') == 'firmado' ? 'selected' : '' }}>Firmado</option>
                    <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                    <option value="anulado" {{ request('estado') == 'anulado' ? 'selected' : '' }}>Anulado</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select class="form-select" id="tipo" name="tipo">
                    <option value="">Todos los tipos</option>
                    <option value="ingreso" {{ request('tipo') == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
                    <option value="entrega" {{ request('tipo') == 'entrega' ? 'selected' : '' }}>Entrega</option>
                    <option value="servicio" {{ request('tipo') == 'servicio' ? 'selected' : '' }}>Servicio</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="fecha_inicio" class="form-label">Desde</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
            </div>
            <div class="col-md-2">
                <label for="fecha_fin" class="form-label">Hasta</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ request('fecha_fin') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-2"></i>Filtrar
                </button>
            </div>
        </form>
        
        <!-- Búsqueda Rápida -->
        <div class="row mt-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('tickets.index') }}">
                    <div class="input-group">
                        <input type="text" 
                               class="form-control" 
                               name="buscar" 
                               placeholder="Buscar por número de ticket o cliente..."
                               value="{{ request('buscar') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Limpiar Filtros
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Tickets -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($tickets->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nº Ticket</th>
                            <th>Cliente</th>
                            <th>Equipo</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                        <tr>
                            <td>
                                <strong class="text-primary">#{{ $ticket->numero_ticket }}</strong>
                                @if($ticket->reparacion)
                                    <br><small class="text-muted">Rep. #{{ $ticket->reparacion->id }}</small>
                                @endif
                            </td>
                            
                            <td>
                                @if($ticket->reparacion && $ticket->reparacion->equipo && $ticket->reparacion->equipo->cliente)
                                    <div>
                                        <strong>{{ $ticket->reparacion->equipo->cliente->nombres }} {{ $ticket->reparacion->equipo->cliente->apellidos }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $ticket->reparacion->equipo->cliente->telefono ?? 'Sin teléfono' }}</small>
                                    </div>
                                @else
                                    <span class="text-muted">Cliente no disponible</span>
                                @endif
                            </td>
                            
                            <td>
                                @if($ticket->reparacion && $ticket->reparacion->equipo)
                                    <div>
                                        <strong>{{ $ticket->reparacion->equipo->marca }} {{ $ticket->reparacion->equipo->modelo }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $ticket->reparacion->equipo->numero_serie }}</small>
                                    </div>
                                @else
                                    <span class="text-muted">Equipo no disponible</span>
                                @endif
                            </td>
                            
                            <td>
                                @php
                                    $tipoColors = [
                                        'ingreso' => 'primary',
                                        'entrega' => 'success',
                                        'servicio' => 'info'
                                    ];
                                    $tipoLabels = [
                                        'ingreso' => 'Ingreso',
                                        'entrega' => 'Entrega',
                                        'servicio' => 'Servicio'
                                    ];
                                @endphp
                                <span class="badge bg-{{ $tipoColors[$ticket->tipo_ticket] ?? 'secondary' }} text-white">
                                    {{ $tipoLabels[$ticket->tipo_ticket] ?? ucfirst($ticket->tipo_ticket) }}
                                </span>
                            </td>
                            
                            <td>
                                @php
                                    $estadoColors = [
                                        'generado' => 'warning',
                                        'firmado' => 'info',
                                        'entregado' => 'success',
                                        'anulado' => 'danger'
                                    ];
                                @endphp
                                <span class="badge bg-{{ $estadoColors[$ticket->estado] ?? 'secondary' }} text-white">
                                    {{ ucfirst($ticket->estado) }}
                                </span>
                            </td>
                            
                            <td>
                                <div>
                                    <strong>{{ $ticket->fecha_generacion->format('d/m/Y') }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $ticket->fecha_generacion->diffForHumans() }}</small>
                                </div>
                            </td>
                            
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('tickets.show', $ticket) }}" 
                                       class="btn btn-outline-primary" 
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('tickets.edit', $ticket) }}" 
                                       class="btn btn-outline-warning" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if($ticket->estado == 'generado')
                                        <a href="{{ route('tickets.firmar', $ticket) }}" 
                                           class="btn btn-outline-info" 
                                           title="Firmar">
                                            <i class="fas fa-signature"></i>
                                        </a>
                                    @endif
                                    
                                    @if($ticket->estado == 'firmado')
                                        <button type="button" 
                                                class="btn btn-outline-success" 
                                                onclick="marcarEntregado({{ $ticket->id }})"
                                                title="Marcar como entregado">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    
                                    @if(in_array($ticket->estado, ['generado', 'firmado']))
                                        <button type="button" 
                                                class="btn btn-outline-danger" 
                                                onclick="anularTicket({{ $ticket->id }})"
                                                title="Anular">
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
            <div class="d-flex justify-content-center mt-4">
                {{ $tickets->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-ticket-alt display-1 text-muted mb-4"></i>
                <h4 class="text-muted">No hay tickets registrados</h4>
                <p class="text-muted">Crea el primer ticket para comenzar a gestionar los servicios.</p>
                <a href="{{ route('tickets.create') }}" class="btn btn-primary btn-custom">
                    <i class="fas fa-plus me-2"></i>Crear Primer Ticket
                </a>
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
                        <a href="{{ route('tickets.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>Nuevo Ticket
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('tickets.index', ['estado' => 'generado']) }}" class="btn btn-warning w-100">
                            <i class="fas fa-clock me-2"></i>Tickets Pendientes
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="button" class="btn btn-outline-secondary w-100" onclick="mostrarProximamente('Reportes de Tickets')">
                            <i class="fas fa-chart-line me-2"></i>Reportes
                        </button>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="button" class="btn btn-outline-secondary w-100" onclick="mostrarProximamente('Exportar Tickets')">
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
function marcarEntregado(ticketId) {
    if (confirm('¿Está seguro de marcar este ticket como entregado?')) {
        const url = `/tickets/${ticketId}/marcar-entregado`;
        
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
            alert('Error al marcar el ticket como entregado');
        });
    }
}

function anularTicket(ticketId) {
    if (confirm('¿Está seguro de anular este ticket?\n\nEsta acción no se puede deshacer.')) {
        const url = `/tickets/${ticketId}/anular`;
        
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
            alert('Error al anular el ticket');
        });
    }
}

// Función para eliminar ticket con confirmación
function eliminarTicket(ticketId, ticketName) {
    showDeleteConfirmation(ticketId, ticketName, 'Ticket', `/tickets/${ticketId}`);
}
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
