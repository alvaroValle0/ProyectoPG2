<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket {{ $ticket->numero_ticket ?? ('#'.$ticket->id) }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background: #fff;
            padding: 15px;
        }
        
        .ticket {
            max-width: 400px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 15px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        
        .empresa {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .subtitulo {
            font-size: 10px;
            margin-bottom: 5px;
        }
        
        .numero-ticket {
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }
        
        .seccion {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #000;
        }
        
        .seccion:last-child {
            border-bottom: none;
        }
        
        .titulo-seccion {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 8px;
            font-size: 13px;
        }
        
        .fila {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            flex-wrap: wrap;
        }
        
        .etiqueta {
            font-weight: bold;
            min-width: 120px;
        }
        
        .valor {
            flex: 1;
            text-align: right;
        }
        
        .texto-completo {
            width: 100%;
            margin-top: 5px;
            padding: 5px;
            background: #f5f5f5;
            border: 1px solid #ddd;
            word-wrap: break-word;
        }
        
        .estado {
            padding: 2px 8px;
            border: 1px solid #000;
            text-align: center;
            font-weight: bold;
        }
        
        .estado-generado { 
            background: #ffc107; 
            color: black; 
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 4px;
        }
        .estado-firmado { 
            background: #17a2b8; 
            color: white; 
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 4px;
        }
        .estado-entregado { 
            background: #28a745; 
            color: white; 
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 4px;
        }
        .estado-anulado { 
            background: #dc3545; 
            color: white; 
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 4px;
        }
        
        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #000;
        }
        
        .qr-placeholder {
            width: 60px;
            height: 60px;
            border: 1px solid #000;
            margin: 10px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .ticket {
                border: none;
                max-width: none;
                width: 100%;
            }
            
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="ticket">
        <!-- Header -->
        <div class="header">
            <div class="empresa">HDC SERVICIOS ELECTRONICOS</div>
            <div class="subtitulo">Ticket de Servicio</div>
            <div class="numero-ticket">Nº {{ $ticket->numero_ticket ?? ('#'.$ticket->id) }}</div>
            <div class="subtitulo">{{ $ticket->fecha_generacion ? $ticket->fecha_generacion->format('d/m/Y H:i:s') : now()->format('d/m/Y H:i:s') }}</div>
        </div>

        <!-- Información del Cliente -->
        <div class="seccion">
            <div class="titulo-seccion">DATOS DEL CLIENTE</div>
            <div class="fila">
                <span class="etiqueta">Nombre:</span>
                <span class="valor">{{ $ticket->reparacion->equipo->cliente->nombre_completo ?? 'Consumidor Final' }}</span>
            </div>
            @if($ticket->reparacion->equipo->cliente->telefono ?? false)
            <div class="fila">
                <span class="etiqueta">Teléfono:</span>
                <span class="valor">{{ $ticket->reparacion->equipo->cliente->telefono }}</span>
            </div>
            @endif
            @if($ticket->reparacion->equipo->cliente->email ?? false)
            <div class="fila">
                <span class="etiqueta">Email:</span>
                <span class="valor">{{ $ticket->reparacion->equipo->cliente->email }}</span>
            </div>
            @endif
        </div>

        <!-- Información del Equipo -->
        <div class="seccion">
            <div class="titulo-seccion">DATOS DEL EQUIPO</div>
            <div class="fila">
                <span class="etiqueta">Tipo:</span>
                <span class="valor">{{ $ticket->reparacion->equipo->tipo_equipo ?? 'N/A' }}</span>
            </div>
            <div class="fila">
                <span class="etiqueta">Marca:</span>
                <span class="valor">{{ $ticket->reparacion->equipo->marca ?? 'N/A' }}</span>
            </div>
            <div class="fila">
                <span class="etiqueta">Modelo:</span>
                <span class="valor">{{ $ticket->reparacion->equipo->modelo ?? 'N/A' }}</span>
            </div>
            <div class="fila">
                <span class="etiqueta">Serie:</span>
                <span class="valor">{{ $ticket->reparacion->equipo->numero_serie ?? 'N/A' }}</span>
            </div>
        </div>

        <!-- Información del Ticket -->
        <div class="seccion">
            <div class="titulo-seccion">DATOS DEL TICKET</div>
            <div class="fila">
                <span class="etiqueta">Tipo:</span>
                <span class="valor">{{ ucfirst($ticket->tipo_ticket ?? 'servicio') }}</span>
            </div>
            <div class="fila">
                <span class="etiqueta">Fecha Generación:</span>
                <span class="valor">{{ $ticket->fecha_generacion ? $ticket->fecha_generacion->format('d/m/Y') : now()->format('d/m/Y') }}</span>
            </div>
            @if($ticket->fecha_firma)
            <div class="fila">
                <span class="etiqueta">Fecha Firma:</span>
                <span class="valor">{{ $ticket->fecha_firma->format('d/m/Y') }}</span>
            </div>
            @endif
            @if($ticket->fecha_entrega)
            <div class="fila">
                <span class="etiqueta">Fecha Entrega:</span>
                <span class="valor">{{ $ticket->fecha_entrega->format('d/m/Y') }}</span>
            </div>
            @endif
            @if($ticket->reparacion->tecnico ?? false)
            <div class="fila">
                <span class="etiqueta">Técnico:</span>
                <span class="valor">{{ $ticket->reparacion->tecnico->nombre_completo }}</span>
            </div>
            @endif
            @if($ticket->reparacion->tecnico->especialidad ?? false)
            <div class="fila">
                <span class="etiqueta">Especialidad:</span>
                <span class="valor">{{ $ticket->reparacion->tecnico->especialidad }}</span>
            </div>
            @endif
            @if($ticket->tiempo_garantia_dias)
            <div class="fila">
                <span class="etiqueta">Garantía:</span>
                <span class="valor">{{ $ticket->tiempo_garantia_dias }} días</span>
            </div>
            @endif
        </div>

        <!-- Descripción del Servicio -->
        <div class="seccion">
            <div class="titulo-seccion">DESCRIPCIÓN DEL SERVICIO</div>
            <div class="texto-completo">
                {{ $ticket->descripcion_servicio ?? 'Sin descripción' }}
            </div>
        </div>

        @if($ticket->observaciones_tecnico)
        <!-- Observaciones del Técnico -->
        <div class="seccion">
            <div class="titulo-seccion">OBSERVACIONES DEL TÉCNICO</div>
            <div class="texto-completo">
                {{ $ticket->observaciones_tecnico }}
            </div>
        </div>
        @endif

        @if($ticket->observaciones_cliente)
        <!-- Observaciones del Cliente -->
        <div class="seccion">
            <div class="titulo-seccion">OBSERVACIONES DEL CLIENTE</div>
            <div class="texto-completo">
                {{ $ticket->observaciones_cliente }}
            </div>
        </div>
        @endif

        @if($ticket->costo_servicio || $ticket->costo_repuestos)
        <!-- Costos -->
        <div class="seccion">
            <div class="titulo-seccion">DETALLE DE COSTOS</div>
            @if($ticket->costo_servicio)
            <div class="fila">
                <span class="etiqueta">Costo Servicio:</span>
                <span class="valor">Q{{ number_format($ticket->costo_servicio, 2) }}</span>
            </div>
            @endif
            @if($ticket->costo_repuestos)
            <div class="fila">
                <span class="etiqueta">Costo Repuestos:</span>
                <span class="valor">Q{{ number_format($ticket->costo_repuestos, 2) }}</span>
            </div>
            @endif
            @if($ticket->total)
            <div class="fila">
                <span class="etiqueta">Total:</span>
                <span class="valor">Q{{ number_format($ticket->total, 2) }}</span>
            </div>
            @endif
        </div>
        @endif

        <!-- Estado Actual -->
        <div class="seccion">
            <div class="titulo-seccion">ESTADO ACTUAL</div>
            <div class="estado estado-{{ $ticket->estado ?? 'generado' }}">
                {{ strtoupper(str_replace('_', ' ', $ticket->estado ?? 'generado')) }}
            </div>
        </div>

        @if($ticket->condiciones_servicio)
        <!-- Condiciones del Servicio -->
        <div class="seccion">
            <div class="titulo-seccion">CONDICIONES DEL SERVICIO</div>
            <div class="texto-completo">
                {{ $ticket->condiciones_servicio }}
            </div>
        </div>
        @endif

        @if($ticket->observaciones_generales)
        <!-- Observaciones Generales -->
        <div class="seccion">
            <div class="titulo-seccion">OBSERVACIONES GENERALES</div>
            <div class="texto-completo">
                {{ $ticket->observaciones_generales }}
            </div>
        </div>
        @endif

        <!-- QR Code Placeholder -->
        <div class="seccion">
            <div class="qr-placeholder">
                QR CODE<br>
                {{ $ticket->numero_ticket ?? ('#'.$ticket->id) }}
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div><strong>¡Gracias por confiar en nosotros!</strong></div>
            <div>hdcservicioselectronicos@gmail.com</div>
            <div>3241-1713 | Lesly Xiomara Aquino Ramírez</div>
            <div style="margin-top: 10px;">
                <strong>IMPORTANTE:</strong> Conserve este ticket para recoger su equipo
            </div>
        </div>
    </div>

    <!-- Botones de acción (no se imprimen) -->
    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; margin: 5px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
            🖨️ Imprimir
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; margin: 5px; background: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer;">
            ❌ Cerrar
        </button>
    </div>

    <script>
        // Auto-enfocar para impresión
        window.onload = function() {
            window.focus();
        };
        
        // Cerrar ventana después de imprimir
        window.onafterprint = function() {
            setTimeout(() => {
                window.close();
            }, 1000);
        };
    </script>
</body>
</html>
