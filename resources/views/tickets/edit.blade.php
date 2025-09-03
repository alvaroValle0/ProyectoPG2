@extends('layouts.app')

@section('title', 'Editar Ticket #' . $ticket->numero_ticket)

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-edit text-warning me-2"></i>
            Editar Ticket #{{ $ticket->numero_ticket }}
        </h1>
        <p class="text-muted">Modifica la información del ticket de servicio</p>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-primary">
                <i class="fas fa-eye me-2"></i>Ver Ticket
            </a>
            <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('tickets.update', $ticket) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Información del Ticket -->
                <div class="col-lg-6">
                    <h5 class="mb-3">
                        <i class="fas fa-ticket-alt text-primary me-2"></i>
                        Información del Ticket
                    </h5>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Ticket:</strong> #{{ $ticket->numero_ticket }}<br>
                        <strong>Estado actual:</strong> 
                        <span class="badge bg-{{ $ticket->estado == 'generado' ? 'warning' : ($ticket->estado == 'firmado' ? 'info' : ($ticket->estado == 'entregado' ? 'success' : 'danger')) }}">
                            {{ ucfirst($ticket->estado) }}
                        </span><br>
                        <strong>Fecha de generación:</strong> {{ $ticket->fecha_generacion->format('d/m/Y H:i') }}
                    </div>

                    <div class="mb-3">
                        <label for="tipo_ticket" class="form-label">Tipo de Ticket <span class="text-danger">*</span></label>
                        <select class="form-select @error('tipo_ticket') is-invalid @enderror" 
                                id="tipo_ticket" 
                                name="tipo_ticket" 
                                required>
                            <option value="">Seleccione el tipo</option>
                            <option value="ingreso" {{ old('tipo_ticket', $ticket->tipo_ticket) == 'ingreso' ? 'selected' : '' }}>Ingreso de Equipo</option>
                            <option value="entrega" {{ old('tipo_ticket', $ticket->tipo_ticket) == 'entrega' ? 'selected' : '' }}>Entrega de Equipo</option>
                            <option value="servicio" {{ old('tipo_ticket', $ticket->tipo_ticket) == 'servicio' ? 'selected' : '' }}>Servicio Técnico</option>
                        </select>
                        @error('tipo_ticket')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion_servicio" class="form-label">Descripción del Servicio</label>
                        <textarea class="form-control @error('descripcion_servicio') is-invalid @enderror" 
                                  id="descripcion_servicio" 
                                  name="descripcion_servicio" 
                                  rows="3" 
                                  placeholder="Describe el servicio realizado o a realizar...">{{ old('descripcion_servicio', $ticket->descripcion_servicio) }}</textarea>
                        @error('descripcion_servicio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="observaciones_tecnico" class="form-label">Observaciones del Técnico</label>
                        <textarea class="form-control @error('observaciones_tecnico') is-invalid @enderror" 
                                  id="observaciones_tecnico" 
                                  name="observaciones_tecnico" 
                                  rows="3" 
                                  placeholder="Observaciones técnicas, recomendaciones...">{{ old('observaciones_tecnico', $ticket->observaciones_tecnico) }}</textarea>
                        @error('observaciones_tecnico')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Información de Costos -->
                <div class="col-lg-6">
                    <h5 class="mb-3">
                        <i class="fas fa-dollar-sign text-success me-2"></i>
                        Información de Costos
                    </h5>

                    <div class="mb-3">
                        <label for="costo_servicio" class="form-label">Costo del Servicio</label>
                        <div class="input-group">
                            <span class="input-group-text">Q</span>
                            <input type="number" 
                                   class="form-control @error('costo_servicio') is-invalid @enderror" 
                                   id="costo_servicio" 
                                   name="costo_servicio" 
                                   step="0.01" 
                                   min="0" 
                                   value="{{ old('costo_servicio', $ticket->costo_servicio) }}" 
                                   placeholder="0.00">
                        </div>
                        @error('costo_servicio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="costo_repuestos" class="form-label">Costo de Repuestos</label>
                        <div class="input-group">
                            <span class="input-group-text">Q</span>
                            <input type="number" 
                                   class="form-control @error('costo_repuestos') is-invalid @enderror" 
                                   id="costo_repuestos" 
                                   name="costo_repuestos" 
                                   step="0.01" 
                                   min="0" 
                                   value="{{ old('costo_repuestos', $ticket->costo_repuestos) }}" 
                                   placeholder="0.00">
                        </div>
                        @error('costo_repuestos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tiempo_garantia_dias" class="form-label">Garantía (días)</label>
                        <input type="number" 
                               class="form-control @error('tiempo_garantia_dias') is-invalid @enderror" 
                               id="tiempo_garantia_dias" 
                               name="tiempo_garantia_dias" 
                               min="0" 
                               max="365" 
                               value="{{ old('tiempo_garantia_dias', $ticket->tiempo_garantia_dias) }}">
                        @error('tiempo_garantia_dias')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Días de garantía del servicio</small>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- Condiciones y Observaciones -->
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="condiciones_servicio" class="form-label">Condiciones del Servicio</label>
                        <textarea class="form-control @error('condiciones_servicio') is-invalid @enderror" 
                                  id="condiciones_servicio" 
                                  name="condiciones_servicio" 
                                  rows="3" 
                                  placeholder="Términos y condiciones del servicio...">{{ old('condiciones_servicio', $ticket->condiciones_servicio) }}</textarea>
                        @error('condiciones_servicio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="observaciones_cliente" class="form-label">Observaciones del Cliente</label>
                        <textarea class="form-control @error('observaciones_cliente') is-invalid @enderror" 
                                  id="observaciones_cliente" 
                                  name="observaciones_cliente" 
                                  rows="3" 
                                  placeholder="Observaciones o comentarios del cliente...">{{ old('observaciones_cliente', $ticket->observaciones_cliente) }}</textarea>
                        @error('observaciones_cliente')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Información de la Reparación -->
            @if($ticket->reparacion)
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">
                        <i class="fas fa-tools text-warning me-2"></i>
                        Reparación Asociada
                    </h5>
                    <div class="alert alert-warning">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Reparación:</strong><br>
                                <a href="{{ route('reparaciones.show', $ticket->reparacion) }}" class="text-decoration-none">
                                    #{{ $ticket->reparacion->id }}
                                </a>
                            </div>
                            <div class="col-md-3">
                                <strong>Cliente:</strong><br>
                                @if($ticket->reparacion->equipo && $ticket->reparacion->equipo->cliente)
                                    {{ $ticket->reparacion->equipo->cliente->nombres }} {{ $ticket->reparacion->equipo->equipo->cliente->apellidos }}
                                @else
                                    No disponible
                                @endif
                            </div>
                            <div class="col-md-3">
                                <strong>Equipo:</strong><br>
                                @if($ticket->reparacion->equipo)
                                    {{ $ticket->reparacion->equipo->marca }} {{ $ticket->reparacion->equipo->modelo }}
                                @else
                                    No disponible
                                @endif
                            </div>
                            <div class="col-md-3">
                                <strong>Estado:</strong><br>
                                <span class="badge bg-{{ $ticket->reparacion->estado_color }}">{{ ucfirst($ticket->reparacion->estado) }}</span>
                            </div>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            <i class="fas fa-info-circle me-1"></i>
                            La reparación asociada no se puede cambiar desde esta vista
                        </small>
                    </div>
                </div>
            </div>
            @endif

            <!-- Botones de Acción -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            @if($ticket->estado == 'generado')
                                <button type="button" class="btn btn-outline-danger" onclick="confirmarEliminacion()">
                                    <i class="fas fa-trash me-2"></i>Eliminar Ticket
                                </button>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-warning btn-custom">
                            <i class="fas fa-save me-2"></i>Actualizar Ticket
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Formulario oculto para eliminar -->
        @if($ticket->estado == 'generado')
        <form id="eliminarForm" action="{{ route('tickets.destroy', $ticket) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        @endif
    </div>
</div>

<!-- Información Adicional -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Información del Ticket
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li><i class="fas fa-check text-success me-2"></i>Puedes modificar la información del servicio</li>
                    <li><i class="fas fa-check text-success me-2"></i>Los costos se pueden actualizar</li>
                    <li><i class="fas fa-check text-success me-2"></i>Las condiciones se pueden modificar</li>
                    <li><i class="fas fa-check text-success me-2"></i>La garantía se puede ajustar</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-warning">
            <div class="card-header bg-warning text-white">
                <h6 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Notas Importantes
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li><i class="fas fa-arrow-right text-warning me-2"></i>No se puede cambiar la reparación asociada</li>
                    <li><i class="fas fa-arrow-right text-warning me-2"></i>El estado se gestiona desde las acciones</li>
                    <li><i class="fas fa-arrow-right text-warning me-2"></i>Solo se pueden eliminar tickets generados</li>
                    <li><i class="fas fa-arrow-right text-warning me-2"></i>Los cambios se registran en el historial</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const tipoTicketSelect = document.getElementById('tipo_ticket');
    
    // Validación del formulario
    form.addEventListener('submit', function(e) {
        let valid = true;
        
        if (!tipoTicketSelect.value) {
            tipoTicketSelect.classList.add('is-invalid');
            valid = false;
        } else {
            tipoTicketSelect.classList.remove('is-invalid');
        }
        
        if (!valid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos obligatorios.');
        }
    });
    
    // Actualizar información cuando se selecciona el tipo de ticket
    tipoTicketSelect.addEventListener('change', function() {
        if (this.value) {
            this.classList.remove('is-invalid');
        }
    });
});

function confirmarEliminacion() {
    if (confirm('¿Está seguro de que desea eliminar este ticket?\n\nEsta acción no se puede deshacer.')) {
        if (confirm('Confirme nuevamente: ¿Realmente desea eliminar el ticket #{{ $ticket->numero_ticket }}?')) {
            document.getElementById('eliminarForm').submit();
        }
    }
}
</script>
@endsection

@section('styles')
<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.form-control:focus, .form-select:focus {
    border-color: #27DB9F;
    box-shadow: 0 0 0 0.2rem rgba(39, 219, 159, 0.25);
}

.btn-custom {
    background: linear-gradient(45deg, #ffc107, #fd7e14);
    border: none;
    color: white;
    transition: all 0.3s ease;
}

.btn-custom:hover {
    background: linear-gradient(45deg, #fd7e14, #ffc107);
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(255, 193, 7, 0.4);
}
</style>
@endsection
