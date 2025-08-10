@extends('layouts.app')

@section('title', 'Reparación #' . $reparacion->id)

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-wrench text-primary me-2"></i>
            Reparación #{{ $reparacion->id }}
        </h1>
        <p class="text-muted">Detalles completos de la orden de reparación</p>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <a href="{{ route('reparaciones.edit', $reparacion) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
            <button type="button" class="btn btn-info" onclick="imprimirTicket({{ $reparacion->id }})">
                <i class="fas fa-print me-2"></i>Imprimir
            </button>
            <a href="{{ route('reparaciones.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Información Principal -->
    <div class="col-lg-8 mb-4">
        <!-- Estado y Progreso -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle text-primary me-2"></i>
                    Estado de la Reparación
                </h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4>
                            <span class="badge bg-{{ $reparacion->estado_color }} text-white fs-5">
                                @switch($reparacion->estado)
                                    @case('pendiente')
                                        <i class="fas fa-clock me-1"></i>Pendiente
                                        @break
                                    @case('en_proceso')
                                        <i class="fas fa-cogs me-1"></i>En Proceso
                                        @break
                                    @case('completada')
                                        <i class="fas fa-check-circle me-1"></i>Completada
                                        @break
                                    @case('cancelada')
                                        <i class="fas fa-times-circle me-1"></i>Cancelada
                                        @break
                                    @default
                                        {{ ucfirst($reparacion->estado) }}
                                @endswitch
                            </span>
                        </h4>
                        @if($reparacion->es_vencida)
                            <div class="alert alert-danger mt-2">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Reparación Vencida</strong><br>
                                Lleva {{ $reparacion->dias_transcurridos }} días en proceso
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-{{ $reparacion->estado_color }}" 
                                 style="width: {{ $reparacion->progreso_porcentaje }}%">
                                {{ $reparacion->progreso_porcentaje }}%
                            </div>
                        </div>
                        <small class="text-muted mt-1 d-block">Progreso de la reparación</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalles de la Reparación -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-clipboard-list text-primary me-2"></i>
                    Detalles de la Reparación
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Fecha de Inicio</label>
                        <h6 class="mb-0">{{ $reparacion->fecha_inicio->format('d/m/Y') }}</h6>
                        <small class="text-muted">{{ $reparacion->fecha_inicio->diffForHumans() }}</small>
                    </div>
                    @if($reparacion->fecha_fin)
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Fecha de Finalización</label>
                        <h6 class="mb-0">{{ $reparacion->fecha_fin->format('d/m/Y') }}</h6>
                        <small class="text-muted">{{ $reparacion->fecha_fin->diffForHumans() }}</small>
                    </div>
                    @endif
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Tiempo Estimado</label>
                        <h6 class="mb-0">
                            @if($reparacion->tiempo_estimado_horas)
                                {{ $reparacion->tiempo_estimado_horas }} horas
                            @else
                                No especificado
                            @endif
                        </h6>
                    </div>
                    @if($reparacion->tiempo_real_horas)
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Tiempo Real</label>
                        <h6 class="mb-0">{{ $reparacion->tiempo_real_horas }} horas</h6>
                        @if($reparacion->tiempo_estimado_horas)
                            @php
                                $diferencia = $reparacion->tiempo_real_horas - $reparacion->tiempo_estimado_horas;
                            @endphp
                            @if($diferencia > 0)
                                <small class="text-warning">+{{ $diferencia }}h sobre lo estimado</small>
                            @elseif($diferencia < 0)
                                <small class="text-success">{{ abs($diferencia) }}h menos que lo estimado</small>
                            @else
                                <small class="text-success">Tiempo exacto</small>
                            @endif
                        @endif
                    </div>
                    @endif
                </div>

                <hr class="my-3">

                <div class="mb-3">
                    <label class="text-muted small">Descripción del Problema</label>
                    <div class="p-3 bg-light rounded">
                        {{ $reparacion->descripcion_problema }}
                    </div>
                </div>

                @if($reparacion->diagnostico)
                <div class="mb-3">
                    <label class="text-muted small">Diagnóstico</label>
                    <div class="p-3 bg-info bg-opacity-10 rounded">
                        {{ $reparacion->diagnostico }}
                    </div>
                </div>
                @endif

                @if($reparacion->solucion)
                <div class="mb-3">
                    <label class="text-muted small">Solución Aplicada</label>
                    <div class="p-3 bg-success bg-opacity-10 rounded">
                        {{ $reparacion->solucion }}
                    </div>
                </div>
                @endif

                @if($reparacion->observaciones)
                <div class="mb-3">
                    <label class="text-muted small">Observaciones</label>
                    <div class="p-3 bg-warning bg-opacity-10 rounded">
                        {{ $reparacion->observaciones }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Repuestos Utilizados -->
        @if($reparacion->repuestos_utilizados && count($reparacion->repuestos_utilizados) > 0)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-cogs text-primary me-2"></i>
                    Repuestos Utilizados
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Repuesto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalRepuestos = 0; @endphp
                            @foreach($reparacion->repuestos_utilizados as $repuesto)
                            @php 
                                $subtotal = ($repuesto['cantidad'] ?? 1) * ($repuesto['precio'] ?? 0);
                                $totalRepuestos += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ $repuesto['nombre'] ?? 'N/A' }}</td>
                                <td>{{ $repuesto['cantidad'] ?? 1 }}</td>
                                <td>${{ number_format($repuesto['precio'] ?? 0, 2) }}</td>
                                <td><strong>${{ number_format($subtotal, 2) }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <th colspan="3">Total en Repuestos</th>
                                <th>${{ number_format($totalRepuestos, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Información Lateral -->
    <div class="col-lg-4">
        <!-- Información del Equipo -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-laptop text-info me-2"></i>
                    Información del Equipo
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Número de Serie</label>
                    <h6 class="mb-0">{{ $reparacion->equipo->numero_serie }}</h6>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Equipo</label>
                    <h6 class="mb-0">{{ $reparacion->equipo->marca }} {{ $reparacion->equipo->modelo }}</h6>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Tipo</label>
                    <h6 class="mb-0">{{ $reparacion->equipo->tipo_equipo }}</h6>
                </div>
                @if($reparacion->equipo->descripcion)
                <div class="mb-3">
                    <label class="text-muted small">Descripción</label>
                    <p class="mb-0 small">{{ $reparacion->equipo->descripcion }}</p>
                </div>
                @endif
                <div class="text-center mt-3">
                    <a href="{{ route('equipos.show', $reparacion->equipo) }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-eye me-1"></i>Ver Equipo Completo
                    </a>
                </div>
            </div>
        </div>

        <!-- Información del Cliente -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-user text-success me-2"></i>
                    Información del Cliente
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Nombre</label>
                    <h6 class="mb-0">{{ $reparacion->equipo->cliente_nombre }}</h6>
                </div>
                @if($reparacion->equipo->cliente_telefono)
                <div class="mb-3">
                    <label class="text-muted small">Teléfono</label>
                    <h6 class="mb-0">
                        <a href="tel:{{ $reparacion->equipo->cliente_telefono }}" class="text-decoration-none">
                            <i class="fas fa-phone me-2"></i>{{ $reparacion->equipo->cliente_telefono }}
                        </a>
                    </h6>
                </div>
                @endif
                @if($reparacion->equipo->cliente_email)
                <div class="mb-3">
                    <label class="text-muted small">Email</label>
                    <h6 class="mb-0">
                        <a href="mailto:{{ $reparacion->equipo->cliente_email }}" class="text-decoration-none">
                            <i class="fas fa-envelope me-2"></i>{{ $reparacion->equipo->cliente_email }}
                        </a>
                    </h6>
                </div>
                @endif
            </div>
        </div>

        <!-- Información del Técnico -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-user-cog text-warning me-2"></i>
                    Técnico Asignado
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Nombre</label>
                    <h6 class="mb-0">{{ $reparacion->tecnico->nombre_completo }}</h6>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Especialidad</label>
                    <h6 class="mb-0">{{ $reparacion->tecnico->especialidad }}</h6>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('tecnicos.show', $reparacion->tecnico) }}" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-eye me-1"></i>Ver Perfil Técnico
                    </a>
                </div>
            </div>
        </div>

        <!-- Costos -->
        @if($reparacion->costo || $reparacion->equipo->costo_estimado)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-dollar-sign text-success me-2"></i>
                    Información de Costos
                </h5>
            </div>
            <div class="card-body">
                @if($reparacion->equipo->costo_estimado)
                <div class="mb-3">
                    <label class="text-muted small">Costo Estimado Inicial</label>
                    <h6 class="mb-0">${{ number_format($reparacion->equipo->costo_estimado, 2) }}</h6>
                </div>
                @endif
                @if($reparacion->costo)
                <div class="mb-3">
                    <label class="text-muted small">Costo Final de Reparación</label>
                    <h4 class="mb-0 text-success">${{ number_format($reparacion->costo, 2) }}</h4>
                    @if($reparacion->equipo->costo_estimado)
                        @php 
                            $diferencia = $reparacion->costo - $reparacion->equipo->costo_estimado;
                        @endphp
                        @if($diferencia > 0)
                            <small class="text-danger">+${{ number_format($diferencia, 2) }} sobre estimado</small>
                        @elseif($diferencia < 0)
                            <small class="text-success">${{ number_format(abs($diferencia), 2) }} menos que estimado</small>
                        @else
                            <small class="text-success">Exacto al estimado</small>
                        @endif
                    @endif
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Acciones Rápidas -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-bolt text-primary me-2"></i>
                    Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($reparacion->estado !== 'completada' && $reparacion->estado !== 'cancelada')
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-exchange-alt me-2"></i>Cambiar Estado
                            </button>
                            <ul class="dropdown-menu w-100">
                                @if($reparacion->estado !== 'pendiente')
                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $reparacion->id }}, 'pendiente')">
                                        <i class="fas fa-clock me-2"></i>Pendiente
                                    </a></li>
                                @endif
                                @if($reparacion->estado !== 'en_proceso')
                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $reparacion->id }}, 'en_proceso')">
                                        <i class="fas fa-cogs me-2"></i>En Proceso
                                    </a></li>
                                @endif
                                <li><a class="dropdown-item text-success" href="#" onclick="cambiarEstado({{ $reparacion->id }}, 'completada')">
                                    <i class="fas fa-check-circle me-2"></i>Completada
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="cambiarEstado({{ $reparacion->id }}, 'cancelada')">
                                    <i class="fas fa-times-circle me-2"></i>Cancelada
                                </a></li>
                            </ul>
                        </div>
                    @endif
                    
                    <a href="{{ route('reparaciones.edit', $reparacion) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Editar Reparación
                    </a>
                    
                    <button type="button" class="btn btn-info" onclick="imprimirTicket({{ $reparacion->id }})">
                        <i class="fas fa-print me-2"></i>Imprimir Ticket
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function cambiarEstado(reparacionId, nuevoEstado) {
    const estadoTexto = {
        'pendiente': 'Pendiente',
        'en_proceso': 'En Proceso',
        'completada': 'Completada',
        'cancelada': 'Cancelada'
    };
    
    if (confirm(`¿Está seguro de cambiar el estado a "${estadoTexto[nuevoEstado]}"?`)) {
        fetch(`/reparaciones/${reparacionId}/cambiar-estado`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                estado: nuevoEstado
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al cambiar el estado: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cambiar el estado de la reparación');
        });
    }
}

function imprimirTicket(reparacionId) {
    const url = `/reparaciones/${reparacionId}/ticket`;
    const ventana = window.open(url, 'TicketImpresion', 'width=800,height=600,scrollbars=yes');
    
    if (ventana) {
        ventana.focus();
        ventana.onload = function() {
            setTimeout(() => {
                ventana.print();
            }, 500);
        };
    } else {
        alert('Por favor, permite las ventanas emergentes para imprimir el ticket.');
    }
}
</script>
@endsection