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
                            {{ $ticket->reparacion->equipo->nombre_cliente ?? 'N/A' }}<br>
                            {{ $ticket->reparacion->equipo->telefono_cliente ?? '' }}
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

                    @if($ticket->estado === 'firmado' && $ticket->firma_cliente)
                    <div class="signature-section">
                        <h6 class="mb-3"><i class="fas fa-signature me-2"></i>Firma del Cliente</h6>
                        <div class="text-center">
                            <img src="data:image/png;base64,{{ $ticket->firma_cliente }}" 
                                 alt="Firma del Cliente" 
                                 class="signature-image">
                        </div>
                        @if($ticket->nombre_quien_firma)
                            <div class="signature-info">
                                <p class="mb-1"><strong>Firmado por:</strong> {{ $ticket->nombre_quien_firma }}</p>
                                @if($ticket->dpi_quien_firma)
                                    <p class="mb-1"><strong>DPI:</strong> {{ $ticket->dpi_quien_firma }}</p>
                                @endif
                                <p class="mb-0"><strong>Fecha de firma:</strong> {{ $ticket->fecha_firma ? $ticket->fecha_firma->format('d/m/Y H:i') : 'N/A' }}</p>
                            </div>
                        @endif
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
    
    /* Estilos para la firma en impresión */
    .signature-section {
        page-break-inside: avoid;
        margin-top: 20px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .signature-image {
        max-width: 250px !important;
        max-height: 120px !important;
        border: 1px solid #333 !important;
        border-radius: 4px !important;
    }
}

/* Estilos para pantalla */
.signature-section {
    margin-top: 20px;
    padding: 15px;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
}

.signature-image {
    max-width: 300px;
    max-height: 150px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.signature-info {
    margin-top: 10px;
    font-size: 0.9rem;
    color: #6c757d;
}
</style>
@endsection
