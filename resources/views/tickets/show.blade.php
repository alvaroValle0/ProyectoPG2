@extends('layouts.app')

@section('title', 'Ticket: ' . $ticket->numero_ticket)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-ticket-alt text-primary me-2"></i>
                Ticket {{ $ticket->numero_ticket }}
            </h1>
            <p class="text-muted mb-0">{{ $ticket->tipo_ticket_label }} - {{ $ticket->estado_label }}</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
            @if($ticket->estado === 'generado')
                <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Editar
                </a>
            @endif
            <a href="{{ route('tickets.imprimir', $ticket) }}" class="btn btn-info" target="_blank">
                <i class="fas fa-print me-2"></i>Imprimir
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Información Principal del Ticket -->
        <div class="col-xl-8">
            <!-- Identificación del Ticket -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-id-card me-2"></i>
                        Identificación del Ticket
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted mb-1">Número de Ticket:</label>
                                <h5 class="text-primary fw-bold">{{ $ticket->numero_ticket }}</h5>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted mb-1">Tipo de Ticket:</label>
                                <span class="badge bg-info fs-6">{{ $ticket->tipo_ticket_label }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted mb-1">Estado:</label>
                                <span class="badge bg-{{ $ticket->estado_color }} fs-6">{{ $ticket->estado_label }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted mb-1">Fecha de Generación:</label>
                                <p class="fw-semibold mb-0">{{ $ticket->fecha_generacion->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Cliente -->
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-user me-2"></i>
                        Información del Cliente
                    </h6>
                </div>
                <div class="card-body">
                    @if($ticket->reparacion && $ticket->reparacion->equipo && $ticket->reparacion->equipo->cliente)
                        @php $cliente = $ticket->reparacion->equipo->cliente; @endphp
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted mb-1">Nombre Completo:</label>
                                    <h6 class="fw-bold mb-0">{{ $cliente->nombre_completo }}</h6>
                                </div>
                                @if($cliente->telefono)
                                <div class="mb-3">
                                    <label class="form-label text-muted mb-1">Teléfono:</label>
                                    <p class="mb-0">
                                        <i class="fas fa-phone text-success me-1"></i>
                                        <a href="tel:{{ $cliente->telefono }}" class="text-decoration-none">{{ $cliente->telefono }}</a>
                                    </p>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if($cliente->email)
                                <div class="mb-3">
                                    <label class="form-label text-muted mb-1">Email:</label>
                                    <p class="mb-0">
                                        <i class="fas fa-envelope text-info me-1"></i>
                                        <a href="mailto:{{ $cliente->email }}" class="text-decoration-none">{{ $cliente->email }}</a>
                                    </p>
                                </div>
                                @endif
                                @if($cliente->dpi)
                                <div class="mb-3">
                                    <label class="form-label text-muted mb-1">DPI:</label>
                                    <p class="mb-0">{{ $cliente->dpi }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @if($cliente->direccion)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-0">
                                    <label class="form-label text-muted mb-1">Dirección:</label>
                                    <p class="mb-0">
                                        <i class="fas fa-map-marker-alt text-warning me-1"></i>
                                        {{ $cliente->direccion }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Información del cliente no disponible
                        </div>
                    @endif
                </div>
            </div>

            <!-- Información del Equipo -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-laptop me-2"></i>
                        Información del Equipo
                    </h6>
                </div>
                <div class="card-body">
                    @if($ticket->reparacion && $ticket->reparacion->equipo)
                        @php $equipo = $ticket->reparacion->equipo; @endphp
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted mb-1">Marca y Modelo:</label>
                                    <h6 class="fw-bold mb-0">{{ $equipo->marca }} {{ $equipo->modelo }}</h6>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted mb-1">Tipo de Equipo:</label>
                                    <p class="mb-0">{{ $equipo->tipo_equipo }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if($equipo->numero_serie)
                                <div class="mb-3">
                                    <label class="form-label text-muted mb-1">Número de Serie:</label>
                                    <p class="mb-0 font-monospace">{{ $equipo->numero_serie }}</p>
                                </div>
                                @endif
                                <div class="mb-3">
                                    <label class="form-label text-muted mb-1">Estado:</label>
                                    <span class="badge bg-{{ $equipo->estado_color }}">{{ ucfirst($equipo->estado) }}</span>
                                </div>
                            </div>
                        </div>
                        @if($equipo->descripcion)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-0">
                                    <label class="form-label text-muted mb-1">Descripción:</label>
                                    <p class="mb-0">{{ $equipo->descripcion }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Información del equipo no disponible
                        </div>
                    @endif
                </div>
            </div>

            <!-- Información del Servicio -->
            <div class="card shadow mb-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-tools me-2"></i>
                        Información del Servicio
                    </h6>
                </div>
                <div class="card-body">
                    @if($ticket->descripcion_servicio)
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Descripción del Servicio:</label>
                        <p class="mb-0">{{ $ticket->descripcion_servicio }}</p>
                    </div>
                    @endif

                    @if($ticket->observaciones_tecnico)
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Observaciones del Técnico:</label>
                        <div class="alert alert-light border-start border-4 border-info">
                            {{ $ticket->observaciones_tecnico }}
                        </div>
                    </div>
                    @endif

                    @if($ticket->observaciones_cliente)
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Observaciones del Cliente:</label>
                        <div class="alert alert-light border-start border-4 border-warning">
                            {{ $ticket->observaciones_cliente }}
                        </div>
                    </div>
                    @endif

                    <!-- Costos -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted mb-1">Costo de Servicio:</label>
                                <h6 class="fw-bold mb-0">
                                    Q{{ number_format($ticket->costo_servicio ?? 0, 2) }}
                                </h6>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted mb-1">Costo de Repuestos:</label>
                                <h6 class="fw-bold mb-0">
                                    Q{{ number_format($ticket->costo_repuestos ?? 0, 2) }}
                                </h6>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted mb-1">Total:</label>
                                <h5 class="fw-bold text-success mb-0">
                                    Q{{ number_format($ticket->total ?? 0, 2) }}
                                </h5>
                            </div>
                        </div>
                    </div>

                    @if($ticket->condiciones_servicio)
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Condiciones del Servicio:</label>
                        <div class="alert alert-info">
                            {{ $ticket->condiciones_servicio }}
                        </div>
                    </div>
                    @endif

                    <div class="mb-0">
                        <label class="form-label text-muted mb-1">Tiempo de Garantía:</label>
                        <p class="mb-0">
                            <i class="fas fa-shield-alt text-success me-1"></i>
                            {{ $ticket->tiempo_garantia_dias }} días
                            @if($ticket->fecha_garantia)
                                <small class="text-muted">(Hasta: {{ $ticket->fecha_garantia->format('d/m/Y') }})</small>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Lateral -->
        <div class="col-xl-4">
            <!-- Estado y Acciones -->
            <div class="card shadow mb-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        Estado y Acciones
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <span class="badge bg-{{ $ticket->estado_color }} fs-5 px-3 py-2">
                            {{ $ticket->estado_label }}
                        </span>
                    </div>

                    <div class="d-grid gap-2">
                        @if($ticket->estado === 'generado')
                            <a href="{{ route('tickets.firmar', $ticket) }}" class="btn btn-success">
                                <i class="fas fa-signature me-2"></i>Firmar Ticket
                            </a>
                        @endif

                        @if($ticket->estado === 'firmado')
                            <form action="{{ route('tickets.marcar-entregado', $ticket) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-check-circle me-2"></i>Marcar como Entregado
                                </button>
                            </form>
                        @endif

                        @if($ticket->estado !== 'anulado')
                            <button type="button" 
                                    class="btn btn-outline-danger" 
                                    onclick="anularTicket({{ $ticket->id }}, '{{ $ticket->numero_ticket }}')">
                                <i class="fas fa-ban me-2"></i>Anular Ticket
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Firma del Cliente -->
            @if($ticket->tiene_firma)
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-signature me-2"></i>
                        Firma del Cliente
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="{{ $ticket->firma_cliente }}" 
                             alt="Firma del cliente" 
                             class="img-fluid border rounded"
                             style="max-height: 150px; max-width: 100%;">
                    </div>
                    
                    @if($ticket->nombre_quien_firma)
                    <div class="mb-2">
                        <label class="form-label text-muted mb-1">Firmado por:</label>
                        <h6 class="fw-bold mb-0">{{ $ticket->nombre_quien_firma }}</h6>
                    </div>
                    @endif

                    @if($ticket->dpi_quien_firma)
                    <div class="mb-2">
                        <label class="form-label text-muted mb-1">DPI:</label>
                        <p class="mb-0">{{ $ticket->dpi_quien_firma }}</p>
                    </div>
                    @endif

                    <div class="mb-0">
                        <label class="form-label text-muted mb-1">Fecha de Firma:</label>
                        <p class="mb-0">{{ $ticket->fecha_firma->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Técnico Asignado -->
            @if($ticket->reparacion && $ticket->reparacion->tecnico)
            <div class="card shadow mb-4">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-user-cog me-2"></i>
                        Técnico Asignado
                    </h6>
                </div>
                <div class="card-body">
                    @php $tecnico = $ticket->reparacion->tecnico; @endphp
                    <div class="text-center">
                        <div class="mb-3">
                            <img src="{{ $tecnico->foto_url }}" 
                                 alt="Foto del técnico" 
                                 class="rounded-circle"
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                        <h6 class="fw-bold mb-1">{{ $tecnico->nombre_completo }}</h6>
                        @if($tecnico->especialidad)
                        <p class="text-muted mb-2">{{ $tecnico->especialidad }}</p>
                        @endif
                        @if($tecnico->telefono)
                        <p class="mb-0">
                            <i class="fas fa-phone text-success me-1"></i>
                            {{ $tecnico->telefono }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Historial de Fechas -->
            <div class="card shadow">
                <div class="card-header bg-light">
                    <h6 class="mb-0 text-dark">
                        <i class="fas fa-history me-2"></i>
                        Historial de Fechas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Ticket Generado</h6>
                                <small class="text-muted">{{ $ticket->fecha_generacion->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>

                        @if($ticket->fecha_firma)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Ticket Firmado</h6>
                                <small class="text-muted">{{ $ticket->fecha_firma->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        @endif

                        @if($ticket->fecha_entrega)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Equipo Entregado</h6>
                                <small class="text-muted">{{ $ticket->fecha_entrega->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
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
.fw-semibold {
    font-weight: 600;
}

.timeline {
    position: relative;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    padding-left: 40px;
    margin-bottom: 1.5rem;
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 5px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content h6 {
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
}

.btn-group .btn {
    border-radius: 0.35rem;
}

.btn-group .btn:not(:last-child) {
    margin-right: 0.5rem;
}
</style>
@endsection