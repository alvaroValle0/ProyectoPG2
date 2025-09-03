@extends('layouts.app')

@section('title', 'Ticket #' . $ticket->numero_ticket)

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-ticket-alt text-primary me-2"></i>
            Ticket #{{ $ticket->numero_ticket }}
        </h1>
        <p class="text-muted">Detalles completos del ticket de servicio</p>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
            <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Información Principal -->
    <div class="col-lg-8 mb-4">
        <!-- Estado del Ticket -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle text-primary me-2"></i>
                    Estado del Ticket
                </h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                             style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        @php
                            $estadoColors = [
                                'generado' => 'warning',
                                'firmado' => 'info',
                                'entregado' => 'success',
                                'anulado' => 'danger'
                            ];
                        @endphp
                        <span class="badge bg-{{ $estadoColors[$ticket->estado] ?? 'secondary' }} fs-6">
                            {{ ucfirst($ticket->estado) }}
                        </span>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Número de Ticket</label>
                                <h5 class="mb-0">#{{ $ticket->numero_ticket }}</h5>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Tipo de Ticket</label>
                                @php
                                    $tipoLabels = [
                                        'ingreso' => 'Ingreso de Equipo',
                                        'entrega' => 'Entrega de Equipo',
                                        'servicio' => 'Servicio Técnico'
                                    ];
                                @endphp
                                <h6 class="mb-0">{{ $tipoLabels[$ticket->tipo_ticket] ?? ucfirst($ticket->tipo_ticket) }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Fecha de Generación</label>
                                <h6 class="mb-0">{{ $ticket->fecha_generacion->format('d/m/Y H:i') }}</h6>
                                <small class="text-muted">{{ $ticket->fecha_generacion->diffForHumans() }}</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Última Actualización</label>
                                <h6 class="mb-0">{{ $ticket->updated_at->format('d/m/Y H:i') }}</h6>
                                <small class="text-muted">{{ $ticket->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Servicio -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-tools text-success me-2"></i>
                    Información del Servicio
                </h5>
            </div>
            <div class="card-body">
                @if($ticket->descripcion_servicio)
                <div class="mb-3">
                    <label class="text-muted small">Descripción del Servicio</label>
                    <p class="mb-0">{{ $ticket->descripcion_servicio }}</p>
                </div>
                @endif

                @if($ticket->observaciones_tecnico)
                <div class="mb-3">
                    <label class="text-muted small">Observaciones del Técnico</label>
                    <p class="mb-0">{{ $ticket->observaciones_tecnico }}</p>
                </div>
                @endif

                @if($ticket->observaciones_cliente)
                <div class="mb-3">
                    <label class="text-muted small">Observaciones del Cliente</label>
                    <p class="mb-0">{{ $ticket->observaciones_cliente }}</p>
                </div>
                @endif

                @if($ticket->condiciones_servicio)
                <div class="mb-3">
                    <label class="text-muted small">Condiciones del Servicio</label>
                    <p class="mb-0">{{ $ticket->condiciones_servicio }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Información de Costos -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-dollar-sign text-success me-2"></i>
                    Información de Costos
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4 mb-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <i class="fas fa-tools text-primary display-6 mb-2"></i>
                                <h4 class="text-primary">Q{{ number_format($ticket->costo_servicio ?? 0, 2) }}</h4>
                                <p class="text-muted mb-0">Costo del Servicio</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-info">
                            <div class="card-body">
                                <i class="fas fa-cogs text-info display-6 mb-2"></i>
                                <h4 class="text-info">Q{{ number_format($ticket->costo_repuestos ?? 0, 2) }}</h4>
                                <p class="text-muted mb-0">Costo de Repuestos</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-success">
                            <div class="card-body">
                                <i class="fas fa-calculator text-success display-6 mb-2"></i>
                                <h4 class="text-success">Q{{ number_format(($ticket->costo_servicio ?? 0) + ($ticket->costo_repuestos ?? 0), 2) }}</h4>
                                <p class="text-muted mb-0">Total</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($ticket->tiempo_garantia_dias)
                <div class="text-center mt-3">
                    <span class="badge bg-warning text-dark fs-6">
                        <i class="fas fa-shield-alt me-2"></i>
                        Garantía: {{ $ticket->tiempo_garantia_dias }} días
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Panel Lateral -->
    <div class="col-lg-4">
        <!-- Información de la Reparación -->
        @if($ticket->reparacion)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-tools text-warning me-2"></i>
                    Reparación Asociada
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Número de Reparación</label>
                    <h6 class="mb-0">
                        <a href="{{ route('reparaciones.show', $ticket->reparacion) }}" class="text-decoration-none">
                            #{{ $ticket->reparacion->id }}
                        </a>
                    </h6>
                </div>
                
                @if($ticket->reparacion->equipo)
                <div class="mb-3">
                    <label class="text-muted small">Equipo</label>
                    <h6 class="mb-0">{{ $ticket->reparacion->equipo->marca }} {{ $ticket->reparacion->equipo->modelo }}</h6>
                    <small class="text-muted">{{ $ticket->reparacion->equipo->numero_serie }}</small>
                </div>
                @endif

                @if($ticket->reparacion->equipo && $ticket->reparacion->equipo->cliente)
                <div class="mb-3">
                    <label class="text-muted small">Cliente</label>
                    <h6 class="mb-0">{{ $ticket->reparacion->equipo->cliente->nombres }} {{ $ticket->reparacion->equipo->cliente->apellidos }}</h6>
                    <small class="text-muted">{{ $ticket->reparacion->equipo->cliente->telefono ?? 'Sin teléfono' }}</small>
                </div>
                @endif

                <div class="mb-3">
                    <label class="text-muted small">Estado de la Reparación</label>
                    <span class="badge bg-{{ $ticket->reparacion->estado_color }} text-white">
                        {{ ucfirst($ticket->reparacion->estado) }}
                    </span>
                </div>

                @if($ticket->reparacion->tecnico)
                <div class="mb-3">
                    <label class="text-muted small">Técnico Asignado</label>
                    <h6 class="mb-0">{{ $ticket->reparacion->tecnico->nombre_completo }}</h6>
                    <small class="text-muted">{{ $ticket->reparacion->tecnico->especialidad }}</small>
                </div>
                @endif
            </div>
        </div>
        @endif

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
                    <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Editar Ticket
                    </a>
                    
                    @if($ticket->estado == 'generado')
                        <a href="{{ route('tickets.firmar', $ticket) }}" class="btn btn-info">
                            <i class="fas fa-signature me-2"></i>Firmar Ticket
                        </a>
                    @endif
                    
                    @if($ticket->estado == 'firmado')
                        <button type="button" 
                                class="btn btn-success" 
                                onclick="marcarEntregado({{ $ticket->id }})">
                            <i class="fas fa-check me-2"></i>Marcar como Entregado
                        </button>
                    @endif
                    
                    @if(in_array($ticket->estado, ['generado', 'firmado']))
                        <button type="button" 
                                class="btn btn-outline-danger" 
                                onclick="anularTicket({{ $ticket->id }})">
                            <i class="fas fa-times me-2"></i>Anular Ticket
                        </button>
                    @endif
                    
                    <a href="{{ route('tickets.imprimir', $ticket) }}" class="btn btn-outline-primary">
                        <i class="fas fa-print me-2"></i>Imprimir Ticket
                    </a>
                </div>
            </div>
        </div>

        <!-- Historial de Estados -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-history text-secondary me-2"></i>
                    Historial de Estados
                </h5>
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
                    
                    @if($ticket->estado == 'firmado' || $ticket->estado == 'entregado')
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Ticket Firmado</h6>
                            <small class="text-muted">{{ $ticket->fecha_firma ? $ticket->fecha_firma->format('d/m/Y H:i') : 'Fecha no disponible' }}</small>
                        </div>
                    </div>
                    @endif
                    
                    @if($ticket->estado == 'entregado')
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Ticket Entregado</h6>
                            <small class="text-muted">{{ $ticket->fecha_entrega ? $ticket->fecha_entrega->format('d/m/Y H:i') : 'Fecha no disponible' }}</small>
                        </div>
                    </div>
                    @endif
                    
                    @if($ticket->estado == 'anulado')
                    <div class="timeline-item">
                        <div class="timeline-marker bg-danger"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Ticket Anulado</h6>
                            <small class="text-muted">{{ $ticket->updated_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                    @endif
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
</script>
@endsection

@section('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 3px #dee2e6;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: -29px;
    top: 12px;
    width: 2px;
    height: calc(100% + 8px);
    background-color: #dee2e6;
}

.timeline-content h6 {
    margin-bottom: 5px;
    font-weight: 600;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endsection
