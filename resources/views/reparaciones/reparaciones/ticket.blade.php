<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Reparación #{{ $reparacion->id }}</title>
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
        
        .estado-pendiente { 
            background: #dc3545; 
            color: white; 
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 4px;
        }
        .estado-en-proceso { 
            background: #fd7e14; 
            color: white; 
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 4px;
        }
        .estado-completada { 
            background: #212529; 
            color: white; 
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 4px;
        }
        .estado-cancelada { 
            background: #6c757d; 
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
            <div class="subtitulo">Ticket de Reparación</div>
            <div class="numero-ticket">Nº {{ str_pad($reparacion->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div class="subtitulo">{{ now()->format('d/m/Y H:i:s') }}</div>
        </div>

        <!-- Información del Cliente -->
        <div class="seccion">
            <div class="titulo-seccion">DATOS DEL CLIENTE</div>
            <div class="fila">
                <span class="etiqueta">Nombre:</span>
                <span class="valor">{{ $reparacion->equipo->cliente_nombre }}</span>
            </div>
            @if($reparacion->equipo->cliente_telefono)
            <div class="fila">
                <span class="etiqueta">Teléfono:</span>
                <span class="valor">{{ $reparacion->equipo->cliente_telefono }}</span>
            </div>
            @endif
            @if($reparacion->equipo->cliente_email)
            <div class="fila">
                <span class="etiqueta">Email:</span>
                <span class="valor">{{ $reparacion->equipo->cliente_email }}</span>
            </div>
            @endif
        </div>

        <!-- Información del Equipo -->
        <div class="seccion">
            <div class="titulo-seccion">DATOS DEL EQUIPO</div>
            <div class="fila">
                <span class="etiqueta">Tipo:</span>
                <span class="valor">{{ $reparacion->equipo->tipo_equipo }}</span>
            </div>
            <div class="fila">
                <span class="etiqueta">Marca:</span>
                <span class="valor">{{ $reparacion->equipo->marca }}</span>
            </div>
            <div class="fila">
                <span class="etiqueta">Modelo:</span>
                <span class="valor">{{ $reparacion->equipo->modelo }}</span>
            </div>
            <div class="fila">
                <span class="etiqueta">Serie:</span>
                <span class="valor">{{ $reparacion->equipo->numero_serie }}</span>
            </div>
        </div>

        <!-- Información de la Reparación -->
        <div class="seccion">
            <div class="titulo-seccion">DATOS DE LA REPARACIÓN</div>
            <div class="fila">
                <span class="etiqueta">Fecha Ingreso:</span>
                <span class="valor">{{ $reparacion->fecha_inicio->format('d/m/Y') }}</span>
            </div>
            <div class="fila">
                <span class="etiqueta">Técnico:</span>
                <span class="valor">{{ $reparacion->tecnico->nombre_completo }}</span>
            </div>
            <div class="fila">
                <span class="etiqueta">Especialidad:</span>
                <span class="valor">{{ $reparacion->tecnico->especialidad }}</span>
            </div>
            @if($reparacion->tiempo_estimado_horas)
            <div class="fila">
                <span class="etiqueta">Tiempo Est.:</span>
                <span class="valor">{{ $reparacion->tiempo_estimado_horas }}h</span>
            </div>
            @endif
            @if($reparacion->costo)
            <div class="fila">
                <span class="etiqueta">Costo:</span>
                <span class="valor">Q{{ number_format($reparacion->costo, 2) }}</span>
            </div>
            @endif
        </div>

        <!-- Problema Reportado -->
        <div class="seccion">
            <div class="titulo-seccion">PROBLEMA REPORTADO</div>
            <div class="texto-completo">
                {{ $reparacion->descripcion_problema }}
            </div>
        </div>

        @if($reparacion->diagnostico)
        <!-- Diagnóstico -->
        <div class="seccion">
            <div class="titulo-seccion">DIAGNÓSTICO</div>
            <div class="texto-completo">
                {{ $reparacion->diagnostico }}
            </div>
        </div>
        @endif

        @if($reparacion->solucion)
        <!-- Solución -->
        <div class="seccion">
            <div class="titulo-seccion">SOLUCIÓN APLICADA</div>
            <div class="texto-completo">
                {{ $reparacion->solucion }}
            </div>
        </div>
        @endif

        @if($reparacion->repuestos_utilizados && count($reparacion->repuestos_utilizados) > 0)
        <!-- Repuestos -->
        <div class="seccion">
            <div class="titulo-seccion">REPUESTOS UTILIZADOS</div>
            @foreach($reparacion->repuestos_utilizados as $repuesto)
            <div class="fila">
                <span class="etiqueta">{{ $repuesto['nombre'] ?? 'N/A' }}</span>
                <span class="valor">
                    Cant: {{ $repuesto['cantidad'] ?? 1 }}
                    @if(isset($repuesto['precio']))
                        - Q{{ number_format($repuesto['precio'], 2) }}
                    @endif
                </span>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Estado Actual -->
        <div class="seccion">
            <div class="titulo-seccion">ESTADO ACTUAL</div>
            <div class="estado estado-{{ $reparacion->estado }}">
                {{ strtoupper(str_replace('_', ' ', $reparacion->estado)) }}
            </div>
            @if($reparacion->fecha_fin)
            <div class="fila" style="margin-top: 8px;">
                <span class="etiqueta">Fecha Fin:</span>
                <span class="valor">{{ $reparacion->fecha_fin->format('d/m/Y') }}</span>
            </div>
            @endif
        </div>

        @if($reparacion->observaciones)
        <!-- Observaciones -->
        <div class="seccion">
            <div class="titulo-seccion">OBSERVACIONES</div>
            <div class="texto-completo">
                {{ $reparacion->observaciones }}
            </div>
        </div>
        @endif

        <!-- QR Code Placeholder -->
        <div class="seccion">
            <div class="qr-placeholder">
                QR CODE<br>
                #{{ $reparacion->id }}
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