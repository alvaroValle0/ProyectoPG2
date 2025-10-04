@extends('layouts.app')

@section('title', 'Historial del Ticket')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-history text-primary me-2"></i>
            Historial del Ticket {{ $ticket->numero_ticket ?? ('#'.$ticket->id) }}
        </h1>
        <p class="text-muted">Registro completo de todas las acciones realizadas en este ticket</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver al Ticket
        </a>
        <a href="{{ route('tickets.historial.general') }}" class="btn btn-outline-primary">
            <i class="fas fa-list me-2"></i>Historial General
        </a>
    </div>
</div>

<!-- Información del Ticket -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fas fa-ticket-alt me-2"></i>
            Información del Ticket
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Número:</strong> {{ $ticket->numero_ticket ?? ('#'.$ticket->id) }}</p>
                <p><strong>Tipo:</strong> {{ $ticket->tipo_ticket_label }}</p>
                <p><strong>Estado:</strong> <span class="badge bg-{{ $ticket->estado_color }}">{{ $ticket->estado_label }}</span></p>
            </div>
            <div class="col-md-6">
                <p><strong>Fecha de Creación:</strong> {{ $ticket->fecha_generacion->format('d/m/Y H:i:s') }}</p>
                <p><strong>Cliente:</strong> {{ $ticket->reparacion->equipo->cliente->nombre_completo ?? 'N/A' }}</p>
                <p><strong>Equipo:</strong> {{ $ticket->reparacion->equipo->marca ?? '' }} {{ $ticket->reparacion->equipo->modelo ?? '' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Lista del Historial -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0">
        <h5 class="mb-0">
            <i class="fas fa-clock text-info me-2"></i>
            Registro de Acciones ({{ $historial->count() }} acciones)
        </h5>
    </div>
    <div class="card-body p-0">
        @if($historial->count() > 0)
            <div class="timeline">
                @foreach($historial as $index => $accion)
                    <div class="timeline-item {{ $index === 0 ? 'timeline-item-active' : '' }}">
                        <div class="timeline-marker">
                            <i class="{{ $accion->action_icon }}"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-1">
                                        <span class="badge bg-{{ $accion->action_color }}">
                                            {{ $accion->action_label }}
                                        </span>
                                    </h6>
                                    <small class="text-muted">
                                        {{ $accion->created_at->format('d/m/Y H:i:s') }}
                                    </small>
                                </div>
                            </div>
                            <div class="timeline-body">
                                <p class="mb-2">{{ $accion->description }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        @if($accion->user)
                                            @if($accion->user->avatar_url)
                                                <img src="{{ $accion->user->avatar_url }}" alt="Avatar" class="rounded-circle me-2" width="24" height="24">
                                            @else
                                                <div class="bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                                    <i class="fas fa-user text-white" style="font-size: 10px;"></i>
                                                </div>
                                            @endif
                                            <small class="text-muted">{{ $accion->user->name }}</small>
                                        @else
                                            <small class="text-muted">Usuario eliminado</small>
                                        @endif
                                    </div>
                                    @if($accion->ip_address)
                                        <small class="text-muted">{{ $accion->ip_address }}</small>
                                    @endif
                                </div>
                                
                                <!-- Mostrar cambios si existen -->
                                @if($accion->old_data || $accion->new_data)
                                    <div class="mt-3">
                                        <button class="btn btn-sm btn-outline-info" type="button" data-bs-toggle="collapse" data-bs-target="#changes-{{ $accion->id }}" aria-expanded="false">
                                            <i class="fas fa-eye me-1"></i>Ver Cambios
                                        </button>
                                        <div class="collapse mt-2" id="changes-{{ $accion->id }}">
                                            <div class="card card-body">
                                                @if($accion->old_data)
                                                    <h6 class="text-danger">Valores Anteriores:</h6>
                                                    <pre class="small">{{ json_encode($accion->old_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                @endif
                                                @if($accion->new_data)
                                                    <h6 class="text-success">Valores Nuevos:</h6>
                                                    <pre class="small">{{ json_encode($accion->new_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-history display-1 text-muted mb-4"></i>
                <h4 class="text-muted">No hay historial disponible</h4>
                <p class="text-muted">Este ticket no tiene registros de acciones.</p>
            </div>
        @endif
    </div>
</div>

@endsection

@section('styles')
<style>
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
    padding-left: 40px;
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 0;
    width: 32px;
    height: 32px;
    background: #e9ecef;
    border: 3px solid #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    z-index: 2;
}

.timeline-item-active .timeline-marker {
    background: #007bff;
    color: white;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 32px;
    bottom: -30px;
    width: 2px;
    background: #e9ecef;
    z-index: 1;
}

.timeline-content {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.timeline-item-active .timeline-content {
    border-color: #007bff;
    box-shadow: 0 4px 8px rgba(0,123,255,0.1);
}

.timeline-header h6 {
    margin: 0;
}

.timeline-body p {
    margin-bottom: 10px;
    color: #495057;
}

pre {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 4px;
    font-size: 12px;
    max-height: 200px;
    overflow-y: auto;
}
</style>
@endsection
