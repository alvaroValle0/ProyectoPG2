<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket {{ $ticket->numero_ticket }} - Impresión</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: white;
        }

        .ticket-container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 20px;
            background: white;
        }

        /* Header */
        .ticket-header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }

        .company-info {
            font-size: 11px;
            color: #666;
            margin-bottom: 15px;
        }

        .ticket-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .ticket-number {
            font-size: 16px;
            color: #007bff;
            font-weight: bold;
        }

        /* Secciones */
        .section {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }

        .section-header {
            background: #f8f9fa;
            padding: 10px 15px;
            font-weight: bold;
            font-size: 13px;
            color: #495057;
            border-bottom: 1px solid #ddd;
        }

        .section-content {
            padding: 15px;
        }

        .section-content.two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .section-content.three-columns {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
        }

        /* Campos */
        .field {
            margin-bottom: 12px;
        }

        .field-label {
            font-weight: bold;
            color: #495057;
            font-size: 11px;
            margin-bottom: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .field-value {
            color: #333;
            font-size: 12px;
            line-height: 1.3;
        }

        .field-value.large {
            font-size: 14px;
            font-weight: bold;
        }

        .field-value.price {
            font-size: 14px;
            font-weight: bold;
            color: #28a745;
        }

        /* Estados y badges */
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-generado { background: #fff3cd; color: #856404; }
        .status-firmado { background: #d1ecf1; color: #0c5460; }
        .status-entregado { background: #d4edda; color: #155724; }
        .status-anulado { background: #f8d7da; color: #721c24; }

        /* Firma */
        .signature-section {
            margin-top: 30px;
            border: 2px solid #007bff;
            border-radius: 5px;
            padding: 20px;
            background: #f8f9fa;
        }

        .signature-container {
            text-align: center;
            margin: 20px 0;
        }

        .signature-image {
            max-width: 300px;
            max-height: 150px;
            border: 1px solid #ddd;
            border-radius: 3px;
            background: white;
            padding: 10px;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin: 30px auto 10px;
            width: 300px;
        }

        .signature-text {
            text-align: center;
            font-size: 11px;
            color: #666;
        }

        /* Tabla de costos */
        .cost-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .cost-table th,
        .cost-table td {
            padding: 8px 12px;
            text-align: right;
            border-bottom: 1px solid #ddd;
        }

        .cost-table th {
            background: #f8f9fa;
            font-weight: bold;
            text-align: left;
            font-size: 11px;
        }

        .cost-table .total-row {
            background: #e9ecef;
            font-weight: bold;
            font-size: 13px;
        }

        /* Footer */
        .ticket-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #007bff;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .warranty-info {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }

        .warranty-info .warranty-title {
            font-weight: bold;
            color: #856404;
            margin-bottom: 8px;
            font-size: 12px;
        }

        .warranty-info .warranty-text {
            font-size: 11px;
            color: #856404;
            line-height: 1.4;
        }

        /* Print styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            
            .ticket-container {
                margin: 0;
                padding: 15px;
                max-width: none;
            }
            
            .section {
                break-inside: avoid;
            }
            
            .no-print {
                display: none !important;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .section-content.two-columns,
            .section-content.three-columns {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            
            .ticket-container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <!-- Header -->
        <div class="ticket-header">
            <div class="company-name">SISTEMA DE GESTIÓN DE REPARACIONES</div>
            <div class="company-info">
                Servicios Técnicos Especializados<br>
                Teléfono: (502) 0000-0000 | Email: info@empresa.com
            </div>
            <div class="ticket-title">{{ $ticket->tipo_ticket_label }}</div>
            <div class="ticket-number">{{ $ticket->numero_ticket }}</div>
        </div>

        <!-- Información del Ticket -->
        <div class="section">
            <div class="section-header">
                📋 IDENTIFICACIÓN DEL TICKET
            </div>
            <div class="section-content three-columns">
                <div class="field">
                    <div class="field-label">Número de Ticket</div>
                    <div class="field-value large">{{ $ticket->numero_ticket }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Tipo de Ticket</div>
                    <div class="field-value">{{ $ticket->tipo_ticket_label }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Estado</div>
                    <div class="field-value">
                        <span class="status-badge status-{{ $ticket->estado }}">{{ $ticket->estado_label }}</span>
                    </div>
                </div>
                <div class="field">
                    <div class="field-label">Fecha de Generación</div>
                    <div class="field-value">{{ $ticket->fecha_generacion->format('d/m/Y H:i') }}</div>
                </div>
                @if($ticket->fecha_firma)
                <div class="field">
                    <div class="field-label">Fecha de Firma</div>
                    <div class="field-value">{{ $ticket->fecha_firma->format('d/m/Y H:i') }}</div>
                </div>
                @endif
                @if($ticket->fecha_entrega)
                <div class="field">
                    <div class="field-label">Fecha de Entrega</div>
                    <div class="field-value">{{ $ticket->fecha_entrega->format('d/m/Y H:i') }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Información del Cliente -->
        @if($ticket->reparacion && $ticket->reparacion->equipo && $ticket->reparacion->equipo->cliente)
            @php $cliente = $ticket->reparacion->equipo->cliente; @endphp
            <div class="section">
                <div class="section-header">
                    👤 INFORMACIÓN DEL CLIENTE
                </div>
                <div class="section-content two-columns">
                    <div class="field">
                        <div class="field-label">Nombre Completo</div>
                        <div class="field-value large">{{ $cliente->nombre_completo }}</div>
                    </div>
                    @if($cliente->dpi)
                    <div class="field">
                        <div class="field-label">DPI</div>
                        <div class="field-value">{{ $cliente->dpi }}</div>
                    </div>
                    @endif
                    @if($cliente->telefono)
                    <div class="field">
                        <div class="field-label">Teléfono</div>
                        <div class="field-value">{{ $cliente->telefono }}</div>
                    </div>
                    @endif
                    @if($cliente->email)
                    <div class="field">
                        <div class="field-label">Correo Electrónico</div>
                        <div class="field-value">{{ $cliente->email }}</div>
                    </div>
                    @endif
                    @if($cliente->direccion)
                    <div class="field" style="grid-column: 1 / -1;">
                        <div class="field-label">Dirección</div>
                        <div class="field-value">{{ $cliente->direccion }}</div>
                    </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Información del Equipo -->
        @if($ticket->reparacion && $ticket->reparacion->equipo)
            @php $equipo = $ticket->reparacion->equipo; @endphp
            <div class="section">
                <div class="section-header">
                    💻 INFORMACIÓN DEL EQUIPO
                </div>
                <div class="section-content two-columns">
                    <div class="field">
                        <div class="field-label">Marca y Modelo</div>
                        <div class="field-value large">{{ $equipo->marca }} {{ $equipo->modelo }}</div>
                    </div>
                    <div class="field">
                        <div class="field-label">Tipo de Equipo</div>
                        <div class="field-value">{{ $equipo->tipo_equipo }}</div>
                    </div>
                    @if($equipo->numero_serie)
                    <div class="field">
                        <div class="field-label">Número de Serie</div>
                        <div class="field-value">{{ $equipo->numero_serie }}</div>
                    </div>
                    @endif
                    <div class="field">
                        <div class="field-label">Estado del Equipo</div>
                        <div class="field-value">{{ ucfirst($equipo->estado) }}</div>
                    </div>
                    @if($equipo->descripcion)
                    <div class="field" style="grid-column: 1 / -1;">
                        <div class="field-label">Descripción del Equipo</div>
                        <div class="field-value">{{ $equipo->descripcion }}</div>
                    </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Información del Servicio -->
        <div class="section">
            <div class="section-header">
                🔧 INFORMACIÓN DEL SERVICIO
            </div>
            <div class="section-content">
                @if($ticket->descripcion_servicio)
                <div class="field">
                    <div class="field-label">Descripción del Servicio</div>
                    <div class="field-value">{{ $ticket->descripcion_servicio }}</div>
                </div>
                @endif

                @if($ticket->observaciones_tecnico)
                <div class="field">
                    <div class="field-label">Observaciones del Técnico</div>
                    <div class="field-value">{{ $ticket->observaciones_tecnico }}</div>
                </div>
                @endif

                @if($ticket->observaciones_cliente)
                <div class="field">
                    <div class="field-label">Observaciones del Cliente</div>
                    <div class="field-value">{{ $ticket->observaciones_cliente }}</div>
                </div>
                @endif

                <!-- Técnico Asignado -->
                @if($ticket->reparacion && $ticket->reparacion->tecnico)
                    @php $tecnico = $ticket->reparacion->tecnico; @endphp
                    <div class="field">
                        <div class="field-label">Técnico Asignado</div>
                        <div class="field-value">{{ $tecnico->nombre_completo }}
                            @if($tecnico->especialidad)
                                - {{ $tecnico->especialidad }}
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Tabla de Costos -->
                <table class="cost-table">
                    <tr>
                        <th>Concepto</th>
                        <th style="text-align: right;">Monto</th>
                    </tr>
                    <tr>
                        <td>Costo de Servicio</td>
                        <td>Q{{ number_format($ticket->costo_servicio ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Costo de Repuestos</td>
                        <td>Q{{ number_format($ticket->costo_repuestos ?? 0, 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td>TOTAL</td>
                        <td>Q{{ number_format($ticket->total ?? 0, 2) }}</td>
                    </tr>
                </table>

                @if($ticket->condiciones_servicio)
                <div class="field">
                    <div class="field-label">Condiciones del Servicio</div>
                    <div class="field-value">{{ $ticket->condiciones_servicio }}</div>
                </div>
                @endif

                @if($ticket->observaciones_generales)
                <div class="field">
                    <div class="field-label">Observaciones Generales</div>
                    <div class="field-value">{{ $ticket->observaciones_generales }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Información de Garantía -->
        <div class="warranty-info">
            <div class="warranty-title">🛡️ INFORMACIÓN DE GARANTÍA</div>
            <div class="warranty-text">
                <strong>Tiempo de Garantía:</strong> {{ $ticket->tiempo_garantia_dias }} días
                @if($ticket->fecha_garantia)
                    (Válida hasta: {{ $ticket->fecha_garantia->format('d/m/Y') }})
                @endif
                <br><br>
                La garantía cubre únicamente defectos de fabricación o fallas relacionadas con la reparación realizada. 
                No incluye daños por mal uso, accidentes, líquidos o modificaciones no autorizadas.
            </div>
        </div>

        <!-- Firma del Cliente -->
        @if($ticket->tiene_firma)
        <div class="signature-section">
            <div class="section-header" style="background: #007bff; color: white; margin: -20px -20px 20px -20px; padding: 10px 20px;">
                ✍️ FIRMA DEL CLIENTE
            </div>
            
            <div class="signature-container">
                <div style="margin-bottom: 15px;">
                    <img src="{{ $ticket->firma_cliente }}" 
                         alt="Firma del cliente" 
                         class="signature-image">
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 20px;">
                    <div>
                        <div class="signature-line"></div>
                        <div class="signature-text">
                            <strong>{{ $ticket->nombre_quien_firma ?? 'Nombre del Cliente' }}</strong><br>
                            @if($ticket->dpi_quien_firma)
                                DPI: {{ $ticket->dpi_quien_firma }}<br>
                            @endif
                            Fecha: {{ $ticket->fecha_firma->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    <div>
                        <div class="signature-line"></div>
                        <div class="signature-text">
                            <strong>Técnico Responsable</strong><br>
                            @if($ticket->reparacion && $ticket->reparacion->tecnico)
                                {{ $ticket->reparacion->tecnico->nombre_completo }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="margin-top: 20px; font-size: 11px; text-align: center; color: #666;">
                Al firmar este documento, el cliente confirma haber recibido el equipo en condiciones satisfactorias 
                y acepta las condiciones del servicio y garantía especificadas.
            </div>
        </div>
        @else
        <!-- Espacio para firma manual -->
        <div class="signature-section">
            <div class="section-header" style="background: #6c757d; color: white; margin: -20px -20px 20px -20px; padding: 10px 20px;">
                ✍️ ESPACIO PARA FIRMA DEL CLIENTE
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin: 40px 0;">
                <div>
                    <div class="signature-line"></div>
                    <div class="signature-text">
                        <strong>Firma del Cliente</strong><br>
                        @if($ticket->reparacion && $ticket->reparacion->equipo && $ticket->reparacion->equipo->cliente)
                            {{ $ticket->reparacion->equipo->cliente->nombre_completo }}
                        @endif
                        <br>Fecha: _______________
                    </div>
                </div>
                <div>
                    <div class="signature-line"></div>
                    <div class="signature-text">
                        <strong>Técnico Responsable</strong><br>
                        @if($ticket->reparacion && $ticket->reparacion->tecnico)
                            {{ $ticket->reparacion->tecnico->nombre_completo }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="ticket-footer">
            <div>
                Este documento es generado automáticamente por el Sistema de Gestión de Reparaciones<br>
                Fecha de impresión: {{ now()->format('d/m/Y H:i:s') }} | 
                Ticket: {{ $ticket->numero_ticket }}
            </div>
        </div>
    </div>

    <!-- Botón de imprimir (solo en pantalla) -->
    <div class="no-print" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
        <button onclick="window.print()" 
                style="background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 14px;">
            🖨️ Imprimir Ticket
        </button>
        <button onclick="window.close()" 
                style="background: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 14px; margin-left: 10px;">
            ❌ Cerrar
        </button>
    </div>

    <script>
        // Auto-imprimir cuando se carga la página (opcional)
        // window.addEventListener('load', function() {
        //     setTimeout(() => window.print(), 1000);
        // });
    </script>
</body>
</html>