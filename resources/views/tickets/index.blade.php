@extends('layouts.app')

@section('title', 'Gestión de Tickets')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-ticket-alt text-primary me-2"></i>
                Gestión de Tickets
            </h1>
            <p class="text-muted mb-0">Administra los tickets de servicio y entrega</p>
        </div>
        <a href="{{ route('tickets.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus me-2"></i>Nuevo Ticket
        </a>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Tickets
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($estadisticas['total_tickets']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Generados
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($estadisticas['tickets_generados']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Firmados
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($estadisticas['tickets_firmados']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-signature fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Entregados
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($estadisticas['tickets_entregados']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tickets.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="buscar" class="form-label">Búsqueda Rápida</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               id="buscar" 
                               name="buscar" 
                               value="{{ request('buscar') }}"
                               placeholder="Nº ticket, cliente...">
                    </div>
                </div>

                <div class="col-md-2">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select" id="estado" name="estado">
                        <option value="">Todos</option>
                        <option value="generado" {{ request('estado') === 'generado' ? 'selected' : '' }}>Generado</option>
                        <option value="firmado" {{ request('estado') === 'firmado' ? 'selected' : '' }}>Firmado</option>
                        <option value="entregado" {{ request('estado') === 'entregado' ? 'selected' : '' }}>Entregado</option>
                        <option value="anulado" {{ request('estado') === 'anulado' ? 'selected' : '' }}>Anulado</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" id="tipo" name="tipo">
                        <option value="">Todos</option>
                        <option value="ingreso" {{ request('tipo') === 'ingreso' ? 'selected' : '' }}>Ingreso</option>
                        <option value="entrega" {{ request('tipo') === 'entrega' ? 'selected' : '' }}>Entrega</option>
                        <option value="servicio" {{ request('tipo') === 'servicio' ? 'selected' : '' }}>Servicio</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                    <input type="date" 
                           class="form-control" 
                           id="fecha_inicio" 
                           name="fecha_inicio" 
                           value="{{ request('fecha_inicio') }}">
                </div>

                <div class="col-md-2">
                    <label for="fecha_fin" class="form-label">Fecha Fin</label>
                    <input type="date" 
                           class="form-control" 
                           id="fecha_fin" 
                           name="fecha_fin" 
                           value="{{ request('fecha_fin') }}">
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-filter me-1"></i>Filtrar
                    </button>
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de Tickets -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Lista de Tickets
                <span class="badge bg-primary ms-2">{{ $tickets->total() }}</span>
            </h6>
        </div>
        <div class="card-body">
            @if($tickets->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="120">Nº Ticket</th>
                                <th>Cliente</th>
                                <th>Equipo</th>
                                <th width="100">Tipo</th>
                                <th width="80">Total</th>
                                <th width="100">Estado</th>
                                <th width="100">Fecha</th>
                                <th width="150">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                            <tr>
                                <td class="text-center">
                                    <strong class="text-primary">{{ $ticket->numero_ticket }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $ticket->tipo_ticket_label }}</small>
                                </td>
                                <td>
                                    @if($ticket->reparacion && $ticket->reparacion->equipo && $ticket->reparacion->equipo->cliente)
                                        <h6 class="mb-0">{{ $ticket->reparacion->equipo->cliente->nombre_completo }}</h6>
                                        @if($ticket->reparacion->equipo->cliente->telefono)
                                            <small class="text-muted">
                                                <i class="fas fa-phone me-1"></i>{{ $ticket->reparacion->equipo->cliente->telefono }}
                                            </small>
                                        @endif
                                    @else
                                        <span class="text-muted">Cliente no disponible</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ticket->reparacion && $ticket->reparacion->equipo)
                                        <div>{{ $ticket->reparacion->equipo->marca }} {{ $ticket->reparacion->equipo->modelo }}</div>
                                        <small class="text-muted">{{ $ticket->reparacion->equipo->tipo_equipo }}</small>
                                    @else
                                        <span class="text-muted">Equipo no disponible</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">
                                        {{ ucfirst($ticket->tipo_ticket) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    @if($ticket->total)
                                        <strong>Q{{ number_format($ticket->total, 2) }}</strong>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $ticket->estado_color }}">
                                        {{ $ticket->estado_label }}
                                    </span>
                                    @if($ticket->tiene_firma)
                                        <br><small class="text-success"><i class="fas fa-signature"></i> Firmado</small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div>{{ $ticket->fecha_generacion->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $ticket->fecha_generacion->format('H:i') }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('tickets.show', $ticket) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           title="Ver ticket">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($ticket->estado === 'generado')
                                            <a href="{{ route('tickets.edit', $ticket) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif

                                        <a href="{{ route('tickets.imprimir', $ticket) }}" 
                                           class="btn btn-sm btn-outline-secondary" 
                                           title="Imprimir"
                                           target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>

                                        @if($ticket->estado === 'generado')
                                            <a href="{{ route('tickets.firmar', $ticket) }}" 
                                               class="btn btn-sm btn-outline-success" 
                                               title="Firmar">
                                                <i class="fas fa-signature"></i>
                                            </a>
                                        @endif

                                        @if($ticket->estado !== 'anulado')
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    onclick="anularTicket({{ $ticket->id }}, '{{ $ticket->numero_ticket }}')"
                                                    title="Anular">
                                                <i class="fas fa-ban"></i>
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
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Mostrando {{ $tickets->firstItem() }} a {{ $tickets->lastItem() }} 
                        de {{ $tickets->total() }} resultados
                    </div>
                    {{ $tickets->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No hay tickets registrados</h5>
                    <p class="text-muted">Comienza generando tu primer ticket</p>
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Crear Ticket
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de confirmación para anular -->
<div class="modal fade" id="anularModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Anular Ticket</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas anular el ticket <strong id="ticketNumero"></strong>?</p>
                <div class="mb-3">
                    <label for="motivoAnulacion" class="form-label">Motivo de anulación</label>
                    <textarea class="form-control" id="motivoAnulacion" rows="3" placeholder="Especifica el motivo..."></textarea>
                </div>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Esta acción no se puede deshacer.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="anularForm" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="motivo" id="motivoInput">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-ban me-2"></i>Anular Ticket
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function anularTicket(ticketId, ticketNumero) {
    document.getElementById('ticketNumero').textContent = ticketNumero;
    document.getElementById('anularForm').action = `/tickets/${ticketId}/anular`;
    
    const modal = new bootstrap.Modal(document.getElementById('anularModal'));
    modal.show();
    
    // Sincronizar motivo con el input hidden
    document.getElementById('motivoAnulacion').addEventListener('input', function() {
        document.getElementById('motivoInput').value = this.value;
    });
}
</script>
@endsection

@section('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.075) !important;
}

.btn-group .btn {
    margin-right: 0.25rem;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>
@endsection