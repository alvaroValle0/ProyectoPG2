@extends('layouts.app')

@section('title', 'Imprimir Ticket')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm ticket-preview">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-print me-2"></i>
                        Ticket {{ $ticket->numero_ticket ?? ('#'.$ticket->id) }}
                    </h5>
                </div>
                <div class="card-body ticket-content">
                    <!-- Header del ticket -->
                    <div class="ticket-header">
                        <div class="document-title">TICKET DE SERVICIO</div>
                        <div class="document-subtitle">ORIGINAL Cod.: 01</div>
                    </div>

                    <!-- Información de la empresa -->
                    <div class="company-section">
                        <div class="company-name">HDC, Servicios Electrónicos</div>
                        <div class="company-details">
                            <div>Entrada principal, barrio San Pedro, Zona 4</div>
                            <div>Cabañas, Zacapa</div>
                            <div>Teléfono: (502) 1234-5678</div>
                            <div>NIT: 12345678-9 Resp. Inscripto</div>
                            <div>Ing. Brutos: 12345678-9</div>
                            <div>Inicio Actividad: 01/01/2020</div>
                        </div>
                    </div>

                    <!-- Información del ticket -->
                    <div class="ticket-info-section">
                        <div class="ticket-date-number">
                            <span class="date-label">FECHA: {{ now()->format('d/m/Y') }}</span>
                            <span class="number-label">Nro. T: {{ $ticket->numero_ticket ?? ('#'.$ticket->id) }}</span>
                        </div>
                        <div class="client-info">
                            <div>Cliente: {{ $ticket->reparacion->equipo->nombre_cliente ?? 'Consumidor Final' }}</div>
                            <div>Cond. Ante IVA: Consumidor final</div>
                        </div>
                    </div>

                    <!-- Información del equipo -->
                    <div class="equipment-section">
                        <div class="equipment-title">Equipo a Reparar</div>
                        <div class="equipment-details">
                            <div>{{ $ticket->reparacion->equipo->marca ?? '' }} {{ $ticket->reparacion->equipo->modelo ?? '' }}</div>
                            <div>Serie: {{ $ticket->reparacion->equipo->numero_serie ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <!-- Descripción del servicio -->
                    <div class="service-description">
                        <div class="service-title">Descripción del Servicio</div>
                        <div class="service-text">{{ $ticket->descripcion_servicio ?? 'N/A' }}</div>
                    </div>

                    <!-- Observaciones del técnico -->
                    @if($ticket->observaciones_tecnico)
                    <div class="service-description">
                        <div class="service-title">Observaciones del Técnico</div>
                        <div class="service-text">{{ $ticket->observaciones_tecnico }}</div>
                    </div>
                    @endif

                    <!-- Observaciones del cliente -->
                    @if($ticket->observaciones_cliente)
                    <div class="service-description">
                        <div class="service-title">Observaciones del Cliente</div>
                        <div class="service-text">{{ $ticket->observaciones_cliente }}</div>
                    </div>
                    @endif

                    <!-- Tabla de costos -->
                    @if($ticket->costo_servicio || $ticket->costo_repuestos)
                    <div class="costs-section">
                        <div class="costs-header">
                            <span class="quantity-price">Cantidad / Precio Unit.</span>
                            <span class="description">Descripción</span>
                            <span class="amount">IMPORTE</span>
                        </div>
                        
                        @if($ticket->costo_servicio)
                        <div class="cost-item">
                            <span class="quantity-price">1.00 x {{ number_format($ticket->costo_servicio, 2) }}</span>
                            <span class="description">Servicio de reparación</span>
                            <span class="amount">Q {{ number_format($ticket->costo_servicio, 2) }}</span>
                        </div>
                        @endif
                        
                        @if($ticket->costo_repuestos)
                        <div class="cost-item">
                            <span class="quantity-price">1.00 x {{ number_format($ticket->costo_repuestos, 2) }}</span>
                            <span class="description">Repuestos y materiales</span>
                            <span class="amount">Q {{ number_format($ticket->costo_repuestos, 2) }}</span>
                        </div>
                        @endif
                        
                        <div class="cost-total">
                            <span class="total-label">Total: Q {{ number_format(($ticket->costo_servicio ?? 0) + ($ticket->costo_repuestos ?? 0), 2) }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- Footer del ticket -->
                    <div class="ticket-footer">
                        <div class="footer-line">Gracias por su preferencia</div>
                        <div class="footer-line">Ticket: {{ $ticket->numero_ticket ?? ('#'.$ticket->id) }}</div>
                        <div class="footer-line">Documento generado desde HDC Gestión</div>
                    </div>

                    <!-- Botones de acción (solo en pantalla) -->
                    <div class="text-center mt-4 d-print-none">
                        <button onclick="imprimirTicket()" class="btn btn-primary">
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
/* Estilos para formato de ticket de 80mm */
@media print {
    @page {
        size: 80mm auto;
        margin: 0;
        padding: 0;
    }
    
    * {
        box-sizing: border-box;
    }
    
    body {
        margin: 0 !important;
        padding: 0 !important;
        font-family: 'Courier New', monospace !important;
        font-size: 10px !important;
        line-height: 1.2 !important;
        width: 80mm !important;
        max-width: 80mm !important;
        background: white !important;
    }
    
    .container-fluid {
        width: 80mm !important;
        max-width: 80mm !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .row {
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .col-lg-8 {
        width: 80mm !important;
        max-width: 80mm !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
        margin: 0 !important;
        padding: 0 !important;
        width: 80mm !important;
        max-width: 80mm !important;
        background: white !important;
    }
    
    .card-header {
        background: #000 !important;
        color: #fff !important;
        text-align: center !important;
        padding: 6px 4px !important;
        font-size: 11px !important;
        font-weight: bold !important;
        margin: 0 !important;
    }
    
    .card-body {
        padding: 6px 4px !important;
        font-size: 9px !important;
        margin: 0 !important;
        width: 80mm !important;
        max-width: 80mm !important;
    }
    
    .btn, .card-header .fas, .d-print-none { 
        display: none !important; 
    }
    
    /* Estilos específicos para el contenido del ticket */
    .ticket-content {
        width: 80mm !important;
        max-width: 80mm !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .document-title {
        text-align: center !important;
        font-size: 16px !important;
        font-weight: bold !important;
        margin-bottom: 2px !important;
        text-transform: uppercase !important;
    }
    
    .document-subtitle {
        text-align: center !important;
        font-size: 9px !important;
        margin-bottom: 6px !important;
    }
    
    .company-section {
        border: 1px solid #000 !important;
        padding: 4px !important;
        margin-bottom: 4px !important;
    }
    
    .company-name {
        font-size: 10px !important;
        font-weight: bold !important;
        margin-bottom: 2px !important;
    }
    
    .company-details {
        font-size: 7px !important;
        line-height: 1.2 !important;
    }
    
    .company-details div {
        margin: 1px 0 !important;
    }
    
    .ticket-info-section {
        border: 1px solid #000 !important;
        padding: 4px !important;
        margin-bottom: 4px !important;
    }
    
    .ticket-date-number {
        display: flex !important;
        justify-content: space-between !important;
        font-size: 8px !important;
        margin-bottom: 2px !important;
    }
    
    .client-info {
        font-size: 8px !important;
    }
    
    .client-info div {
        margin: 1px 0 !important;
    }
    
    .equipment-section {
        margin: 4px 0 !important;
        padding: 2px 0 !important;
    }
    
    .equipment-title {
        font-size: 8px !important;
        font-weight: bold !important;
        margin-bottom: 2px !important;
    }
    
    .equipment-details {
        font-size: 8px !important;
    }
    
    .equipment-details div {
        margin: 1px 0 !important;
    }
    
    .service-description {
        margin: 4px 0 !important;
        padding: 2px 0 !important;
    }
    
    .service-title {
        font-size: 8px !important;
        font-weight: bold !important;
        margin-bottom: 2px !important;
    }
    
    .service-text {
        font-size: 8px !important;
        line-height: 1.2 !important;
    }
    
    .costs-section {
        margin: 4px 0 !important;
        border: 1px solid #000 !important;
        padding: 2px !important;
    }
    
    .costs-header {
        display: flex !important;
        justify-content: space-between !important;
        font-size: 7px !important;
        font-weight: bold !important;
        margin-bottom: 2px !important;
        border-bottom: 1px solid #000 !important;
        padding-bottom: 1px !important;
    }
    
    .quantity-price {
        flex: 0 0 35% !important;
    }
    
    .description {
        flex: 0 0 45% !important;
    }
    
    .amount {
        flex: 0 0 20% !important;
        text-align: right !important;
    }
    
    .cost-item {
        display: flex !important;
        justify-content: space-between !important;
        font-size: 7px !important;
        margin: 1px 0 !important;
    }
    
    .cost-total {
        margin-top: 4px !important;
        padding-top: 2px !important;
        border-top: 1px solid #000 !important;
        text-align: right !important;
        font-size: 9px !important;
        font-weight: bold !important;
    }
    
    .ticket-footer {
        text-align: center !important;
        margin-top: 8px !important;
        padding-top: 4px !important;
        border-top: 1px solid #000 !important;
        font-size: 7px !important;
    }
    
    .footer-line {
        margin: 1px 0 !important;
    }
}

/* Estilos para pantalla (vista previa) */
@media screen {
    .ticket-preview {
        width: 80mm;
        max-width: 80mm;
        margin: 20px auto;
        border: 1px solid #ccc;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .ticket-preview .card {
        width: 80mm;
        max-width: 80mm;
    }
}

/* Estilos adicionales para forzar el tamaño de ticket */
@media print {
    html, body {
        width: 80mm !important;
        height: auto !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: visible !important;
    }
    
    /* Forzar que no se use el tamaño de página por defecto */
    @page {
        size: 80mm auto !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    /* Asegurar que el contenido se ajuste al ancho */
    .container-fluid, .row, .col-lg-8, .card, .card-body, .ticket-content {
        width: 80mm !important;
        max-width: 80mm !important;
        min-width: 80mm !important;
    }
    
    /* Evitar que el contenido se desborde */
    * {
        max-width: 80mm !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
    }
}
</style>
@endsection

@section('scripts')
<script>
function imprimirTicket() {
    // Crear una nueva ventana para la impresión
    const ventanaImpresion = window.open('', '_blank', 'width=80mm,height=auto');
    
    // Obtener el contenido del ticket
    const contenidoTicket = document.querySelector('.ticket-content').innerHTML;
    
    // Crear el HTML completo para la ventana de impresión
    const htmlCompleto = `
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Ticket {{ $ticket->numero_ticket ?? ('#'.$ticket->id) }}</title>
            <style>
                @page {
                    size: 80mm auto;
                    margin: 0;
                    padding: 0;
                }
                
                * {
                    box-sizing: border-box;
                    margin: 0;
                    padding: 0;
                }
                
                body {
                    font-family: 'Courier New', monospace;
                    font-size: 10px;
                    line-height: 1.2;
                    width: 80mm;
                    max-width: 80mm;
                    margin: 0;
                    padding: 4px;
                }
                
                .document-title {
                    text-align: center;
                    font-size: 16px;
                    font-weight: bold;
                    margin-bottom: 2px;
                    text-transform: uppercase;
                }
                
                .document-subtitle {
                    text-align: center;
                    font-size: 9px;
                    margin-bottom: 6px;
                }
                
                .company-section {
                    border: 1px solid #000;
                    padding: 4px;
                    margin-bottom: 4px;
                }
                
                .company-name {
                    font-size: 10px;
                    font-weight: bold;
                    margin-bottom: 2px;
                }
                
                .company-details {
                    font-size: 7px;
                    line-height: 1.2;
                }
                
                .company-details div {
                    margin: 1px 0;
                }
                
                .ticket-info-section {
                    border: 1px solid #000;
                    padding: 4px;
                    margin-bottom: 4px;
                }
                
                .ticket-date-number {
                    display: flex;
                    justify-content: space-between;
                    font-size: 8px;
                    margin-bottom: 2px;
                }
                
                .client-info {
                    font-size: 8px;
                }
                
                .client-info div {
                    margin: 1px 0;
                }
                
                .equipment-section {
                    margin: 4px 0;
                    padding: 2px 0;
                }
                
                .equipment-title {
                    font-size: 8px;
                    font-weight: bold;
                    margin-bottom: 2px;
                }
                
                .equipment-details {
                    font-size: 8px;
                }
                
                .equipment-details div {
                    margin: 1px 0;
                }
                
                .service-description {
                    margin: 4px 0;
                    padding: 2px 0;
                }
                
                .service-title {
                    font-size: 8px;
                    font-weight: bold;
                    margin-bottom: 2px;
                }
                
                .service-text {
                    font-size: 8px;
                    line-height: 1.2;
                }
                
                .costs-section {
                    margin: 4px 0;
                    border: 1px solid #000;
                    padding: 2px;
                }
                
                .costs-header {
                    display: flex;
                    justify-content: space-between;
                    font-size: 7px;
                    font-weight: bold;
                    margin-bottom: 2px;
                    border-bottom: 1px solid #000;
                    padding-bottom: 1px;
                }
                
                .quantity-price {
                    flex: 0 0 35%;
                }
                
                .description {
                    flex: 0 0 45%;
                }
                
                .amount {
                    flex: 0 0 20%;
                    text-align: right;
                }
                
                .cost-item {
                    display: flex;
                    justify-content: space-between;
                    font-size: 7px;
                    margin: 1px 0;
                }
                
                .cost-total {
                    margin-top: 4px;
                    padding-top: 2px;
                    border-top: 1px solid #000;
                    text-align: right;
                    font-size: 9px;
                    font-weight: bold;
                }
                
                .ticket-footer {
                    text-align: center;
                    margin-top: 8px;
                    padding-top: 4px;
                    border-top: 1px solid #000;
                    font-size: 7px;
                }
                
                .footer-line {
                    margin: 1px 0;
                }
            </style>
        </head>
        <body>
            ${contenidoTicket}
        </body>
        </html>
    `;
    
    // Escribir el contenido en la nueva ventana
    ventanaImpresion.document.write(htmlCompleto);
    ventanaImpresion.document.close();
    
    // Esperar a que se cargue y luego imprimir
    ventanaImpresion.onload = function() {
        ventanaImpresion.focus();
        ventanaImpresion.print();
        ventanaImpresion.close();
    };
}
</script>
@endsection
