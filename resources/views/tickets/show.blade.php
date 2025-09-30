@extends('layouts.app')

@section('title', 'Detalle de Ticket')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-ticket-alt text-primary me-2"></i>
                            Ticket {{ $ticket->numero_ticket ?? ('#'.$ticket->id) }}
                        </h5>
                        <small class="text-muted">Estado: {{ $ticket->estado_label ?? ucfirst($ticket->estado) }}</small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list me-1"></i>Listado
                        </a>
                        <a href="{{ route('tickets.imprimir', $ticket) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-print me-1"></i>Imprimir
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Cliente</h6>
                            <div class="text-muted">
                                {{ $ticket->reparacion->equipo->nombre_cliente ?? 'N/A' }}<br>
                                {{ $ticket->reparacion->equipo->telefono_cliente ?? '' }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Equipo</h6>
                            <div class="text-muted">
                                {{ $ticket->reparacion->equipo->marca ?? '' }} {{ $ticket->reparacion->equipo->modelo ?? '' }}<br>
                                Serie: {{ $ticket->reparacion->equipo->numero_serie ?? '' }}
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6 class="fw-bold mb-2">Descripción del servicio</h6>
                    <p class="mb-0">{{ $ticket->descripcion_servicio ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


