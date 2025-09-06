@extends('layouts.app')

@section('title', 'Imprimir Ticket')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-print me-2"></i>
                        Ticket {{ $ticket->numero_ticket ?? ('#'.$ticket->id) }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Cliente:</strong><br>
                            {{ $ticket->reparacion->equipo->cliente->nombre_completo ?? 'N/A' }}<br>
                            {{ $ticket->reparacion->equipo->cliente->telefono ?? '' }}
                        </div>
                        <div class="col-md-6">
                            <strong>Equipo:</strong><br>
                            {{ $ticket->reparacion->equipo->marca ?? '' }} {{ $ticket->reparacion->equipo->modelo ?? '' }}<br>
                            Serie: {{ $ticket->reparacion->equipo->numero_serie ?? '' }}
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <strong>Descripción del Servicio:</strong>
                        <p>{{ $ticket->descripcion_servicio ?? 'N/A' }}</p>
                    </div>

                    @if($ticket->costo_servicio || $ticket->costo_repuestos)
                    <div class="mb-3">
                        <strong>Costos:</strong>
                        <ul class="list-unstyled mb-0">
                            @if($ticket->costo_servicio)
                                <li>Servicio: Q{{ number_format($ticket->costo_servicio, 2) }}</li>
                            @endif
                            @if($ticket->costo_repuestos)
                                <li>Repuestos: Q{{ number_format($ticket->costo_repuestos, 2) }}</li>
                            @endif
                            <li class="fw-bold">Total: Q{{ number_format(($ticket->costo_servicio ?? 0) + ($ticket->costo_repuestos ?? 0), 2) }}</li>
                        </ul>
                    </div>
                    @endif

                    <div class="text-center mt-4">
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print me-2"></i>Imprimir
                        </button>
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
@media print {
    .btn, .card-header { display: none !important; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>
@endsection
