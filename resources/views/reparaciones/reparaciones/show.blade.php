@extends('layouts.app')

@section('title', 'Reparación #' . $reparacion->id)

@section('content')
<div class="container-fluid">
    <div class="module-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="module-title">
                    <i class="fas fa-wrench text-gradient me-3"></i>
                    Reparación #{{ $reparacion->id }}
                </h1>
                <p class="module-subtitle">Detalles completos de la orden de reparación</p>
            </div>
            <div class="col-lg-4 text-end">
                <div class="btn-group">
                    <a href="{{ route('reparaciones.edit', $reparacion) }}" class="btn btn-warning btn-modern" data-bs-toggle="tooltip" title="Editar">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    <button type="button" class="btn btn-info btn-modern" data-bs-toggle="tooltip" title="Imprimir" onclick="imprimirTicket({{ $reparacion->id }})">
                        <i class="fas fa-print me-2"></i>Imprimir
                    </button>
                    @if(in_array($reparacion->estado, ['pendiente', 'en_proceso']))
                    <button type="button" class="btn btn-danger btn-modern" data-bs-toggle="tooltip" title="Cancelar" onclick="cancelarReparacionDirecta({{ $reparacion->id }})">
                        <i class="fas fa-ban me-2"></i>Cancelar
                    </button>
                    @endif
                    <a href="{{ route('reparaciones.index') }}" class="btn btn-outline-light btn-modern" data-bs-toggle="tooltip" title="Volver">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
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
                                <td>Q{{ number_format($repuesto['precio'] ?? 0, 2) }}</td>
                                <td><strong>Q{{ number_format($subtotal, 2) }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <th colspan="3">Total en Repuestos</th>
                                <th>Q{{ number_format($totalRepuestos, 2) }}</th>
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
                    <i class="fas fa-coins text-success me-2"></i>
                    Información de Costos
                </h5>
            </div>
            <div class="card-body">
                @if($reparacion->equipo->costo_estimado)
                <div class="mb-3">
                    <label class="text-muted small">Costo Estimado Inicial</label>
                    <h6 class="mb-0">Q{{ number_format($reparacion->equipo->costo_estimado, 2) }}</h6>
                </div>
                @endif
                @if($reparacion->costo)
                <div class="mb-3">
                    <label class="text-muted small">Costo Final de Reparación</label>
                    <h4 class="mb-0 text-success">Q{{ number_format($reparacion->costo, 2) }}</h4>
                    @if($reparacion->equipo->costo_estimado)
                        @php 
                            $diferencia = $reparacion->costo - $reparacion->equipo->costo_estimado;
                        @endphp
                        @if($diferencia > 0)
                            <small class="text-danger">+Q{{ number_format($diferencia, 2) }} sobre estimado</small>
                        @elseif($diferencia < 0)
                            <small class="text-success">Q{{ number_format(abs($diferencia), 2) }} menos que estimado</small>
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

// Cancelar reparación directamente desde la vista de detalles
function cancelarReparacionDirecta(reparacionId) {
    // Crear modal dinámico
    const modalId = 'cancelarModalDirecta';
    
    // Remover modal existente si hay uno
    const existingModal = document.getElementById(modalId);
    if (existingModal) {
        existingModal.remove();
    }
    
    // Crear nuevo modal
    const modalHTML = `
        <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-ban me-2"></i>
                            Cancelar Reparación #${reparacionId}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                            <h5>¿Está seguro de que desea cancelar esta reparación?</h5>
                            <p class="text-muted">Esta acción no se puede deshacer</p>
                        </div>
                        <div class="alert alert-warning border-0">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Efectos de la cancelación:</strong>
                            <ul class="mb-0 mt-2">
                                <li>El estado cambiará a "Cancelada"</li>
                                <li>Se establecerá la fecha de finalización automáticamente</li>
                                <li>No se podrá revertir esta acción</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-arrow-left me-2"></i>No, volver atrás
                        </button>
                        <button type="button" class="btn btn-danger" id="btnConfirmarCancelarDirecta" onclick="confirmarCancelacionDirecta(${reparacionId})">
                            <span class="btn-text">
                                <i class="fas fa-ban me-2"></i>Sí, cancelar reparación
                            </span>
                            <span class="btn-spinner d-none">
                                <i class="fas fa-spinner fa-spin me-2"></i>Cancelando...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Agregar modal al DOM
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Mostrar modal
    const modal = new bootstrap.Modal(document.getElementById(modalId));
    modal.show();
    
    // Limpiar modal cuando se cierre
    document.getElementById(modalId).addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}

// Confirmar cancelación directa
function confirmarCancelacionDirecta(reparacionId) {
    const btnConfirmar = document.getElementById('btnConfirmarCancelarDirecta');
    const btnText = btnConfirmar.querySelector('.btn-text');
    const btnSpinner = btnConfirmar.querySelector('.btn-spinner');
    
    // Mostrar estado de carga
    btnConfirmar.disabled = true;
    btnText.classList.add('d-none');
    btnSpinner.classList.remove('d-none');
    
    // Hacer petición AJAX
    fetch(`/reparaciones/${reparacionId}/cambiar-estado`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            estado: 'cancelada',
            observaciones: 'Reparación cancelada desde la vista de detalles'
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Cerrar modal
            const modalElement = document.getElementById('cancelarModalDirecta');
            const modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
            
            // Mostrar mensaje de éxito
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
            alertDiv.style.cssText = 'top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; min-width: 400px;';
            alertDiv.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                <strong>¡Reparación cancelada!</strong> La reparación #${reparacionId} ha sido cancelada exitosamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            // Agregar a la página
            document.body.appendChild(alertDiv);
            
            // Recargar después de 3 segundos
            setTimeout(() => {
                window.location.reload();
            }, 3000);
            
            // Auto-dismiss alert
            setTimeout(() => {
                if (alertDiv && alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 8000);
            
        } else {
            throw new Error(data.message || 'Error desconocido');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Mostrar mensaje de error
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed';
        alertDiv.style.cssText = 'top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; min-width: 400px;';
        alertDiv.innerHTML = `
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Error:</strong> No se pudo cancelar la reparación. ${error.message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Auto-dismiss error alert
        setTimeout(() => {
            if (alertDiv && alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 10000);
    })
    .finally(() => {
        // Restaurar estado del botón
        btnConfirmar.disabled = false;
        btnText.classList.remove('d-none');
        btnSpinner.classList.add('d-none');
    });
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
// Inicializar tooltips
document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>
@endsection

@section('styles')
<style>
.module-header{background:var(--system-gradient);color:#fff;padding:2rem;border-radius:15px;box-shadow:0 10px 20px rgba(0,0,0,0.08)}
.module-title{font-size:2.25rem;font-weight:700;margin:0}
.module-subtitle{opacity:.9;margin-top:.25rem}
.btn-modern{border-radius:25px;padding:.5rem 1.25rem;font-weight:600}
</style>
@endsection