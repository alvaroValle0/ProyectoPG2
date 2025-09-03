@extends('layouts.app')

@section('title', 'Crear Nuevo Ticket')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-plus text-primary me-2"></i>
            Crear Nuevo Ticket
        </h1>
        <p class="text-muted">Genera un nuevo ticket para una reparación o servicio</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('tickets.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <!-- Selección de Reparación -->
                <div class="col-lg-6">
                    <h5 class="mb-3">
                        <i class="fas fa-tools text-primary me-2"></i>
                        Seleccionar Reparación
                    </h5>
                    
                    <div class="mb-3">
                        <label for="reparacion_id" class="form-label">Reparación <span class="text-danger">*</span></label>
                        <select class="form-select @error('reparacion_id') is-invalid @enderror" 
                                id="reparacion_id" 
                                name="reparacion_id" 
                                required>
                            <option value="">Seleccione una reparación</option>
                            @foreach($reparaciones as $reparacion)
                                <option value="{{ $reparacion->id }}" 
                                        {{ old('reparacion_id', $reparacionId) == $reparacion->id ? 'selected' : '' }}>
                                    Rep. #{{ $reparacion->id }} - 
                                    {{ $reparacion->equipo->cliente->nombres }} {{ $reparacion->equipo->cliente->apellidos }} - 
                                    {{ $reparacion->equipo->marca }} {{ $reparacion->equipo->modelo }}
                                </option>
                            @endforeach
                        </select>
                        @error('reparacion_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Selecciona la reparación para la cual generar el ticket</small>
                    </div>

                    @if($reparacion)
                    <div class="alert alert-info">
                        <h6 class="mb-2">Reparación Seleccionada:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Cliente:</strong><br>
                                {{ $reparacion->equipo->cliente->nombres }} {{ $reparacion->equipo->equipo->cliente->apellidos }}
                            </div>
                            <div class="col-md-6">
                                <strong>Equipo:</strong><br>
                                {{ $reparacion->equipo->marca }} {{ $reparacion->equipo->modelo }}
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <strong>Estado:</strong><br>
                                <span class="badge bg-{{ $reparacion->estado_color }}">{{ ucfirst($reparacion->estado) }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Técnico:</strong><br>
                                {{ $reparacion->tecnico->nombre_completo ?? 'No asignado' }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Configuración del Ticket -->
                <div class="col-lg-6">
                    <h5 class="mb-3">
                        <i class="fas fa-cog text-info me-2"></i>
                        Configuración del Ticket
                    </h5>

                    <div class="mb-3">
                        <label for="tipo_ticket" class="form-label">Tipo de Ticket <span class="text-danger">*</span></label>
                        <select class="form-select @error('tipo_ticket') is-invalid @enderror" 
                                id="tipo_ticket" 
                                name="tipo_ticket" 
                                required>
                            <option value="">Seleccione el tipo</option>
                            <option value="ingreso" {{ old('tipo_ticket') == 'ingreso' ? 'selected' : '' }}>Ingreso de Equipo</option>
                            <option value="entrega" {{ old('tipo_ticket') == 'entrega' ? 'selected' : '' }}>Entrega de Equipo</option>
                            <option value="servicio" {{ old('tipo_ticket') == 'servicio' ? 'selected' : '' }}>Servicio Técnico</option>
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
                                  placeholder="Describe el servicio realizado o a realizar...">{{ old('descripcion_servicio') }}</textarea>
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
                                  placeholder="Observaciones técnicas, recomendaciones...">{{ old('observaciones_tecnico') }}</textarea>
                        @error('observaciones_tecnico')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- Información de Costos -->
            <div class="row">
                <div class="col-12">
                    <h5 class="mb-3">
                        <i class="fas fa-dollar-sign text-success me-2"></i>
                        Información de Costos
                    </h5>
                </div>
                <div class="col-md-6">
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
                                   value="{{ old('costo_servicio') }}" 
                                   placeholder="0.00">
                        </div>
                        @error('costo_servicio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
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
                                   value="{{ old('costo_repuestos') }}" 
                                   placeholder="0.00">
                        </div>
                        @error('costo_repuestos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Condiciones y Garantía -->
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="condiciones_servicio" class="form-label">Condiciones del Servicio</label>
                        <textarea class="form-control @error('condiciones_servicio') is-invalid @enderror" 
                                  id="condiciones_servicio" 
                                  name="condiciones_servicio" 
                                  rows="3" 
                                  placeholder="Términos y condiciones del servicio...">{{ old('condiciones_servicio') }}</textarea>
                        @error('condiciones_servicio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="tiempo_garantia_dias" class="form-label">Garantía (días)</label>
                        <input type="number" 
                               class="form-control @error('tiempo_garantia_dias') is-invalid @enderror" 
                               id="tiempo_garantia_dias" 
                               name="tiempo_garantia_dias" 
                               min="0" 
                               max="365" 
                               value="{{ old('tiempo_garantia_dias', 30) }}">
                        @error('tiempo_garantia_dias')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Días de garantía del servicio</small>
                    </div>
                </div>
            </div>

            <!-- Observaciones del Cliente -->
            <div class="mb-3">
                <label for="observaciones_cliente" class="form-label">Observaciones del Cliente</label>
                <textarea class="form-control @error('observaciones_cliente') is-invalid @enderror" 
                          id="observaciones_cliente" 
                          name="observaciones_cliente" 
                          rows="3" 
                          placeholder="Observaciones o comentarios del cliente...">{{ old('observaciones_cliente') }}</textarea>
                @error('observaciones_cliente')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Botones de Acción -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary btn-custom">
                            <i class="fas fa-save me-2"></i>Crear Ticket
                        </button>
                    </div>
                </div>
            </div>
        </form>
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
                    <li><i class="fas fa-check text-success me-2"></i>Se generará un número único de ticket</li>
                    <li><i class="fas fa-check text-success me-2"></i>El ticket quedará en estado "Generado"</li>
                    <li><i class="fas fa-check text-success me-2"></i>Podrás imprimirlo y firmarlo posteriormente</li>
                    <li><i class="fas fa-check text-success me-2"></i>Se vinculará automáticamente a la reparación</li>
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
                    <li><i class="fas fa-arrow-right text-warning me-2"></i>Verifica que la reparación esté en estado válido</li>
                    <li><i class="fas fa-arrow-right text-warning me-2"></i>Los costos son opcionales pero recomendados</li>
                    <li><i class="fas fa-arrow-right text-warning me-2"></i>La garantía por defecto es de 30 días</li>
                    <li><i class="fas fa-arrow-right text-warning me-2"></i>Puedes editar el ticket después de crearlo</li>
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
    const reparacionSelect = document.getElementById('reparacion_id');
    const tipoTicketSelect = document.getElementById('tipo_ticket');
    
    // Validación del formulario
    form.addEventListener('submit', function(e) {
        let valid = true;
        
        if (!reparacionSelect.value) {
            reparacionSelect.classList.add('is-invalid');
            valid = false;
        } else {
            reparacionSelect.classList.remove('is-invalid');
        }
        
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
    
    // Actualizar información cuando se selecciona una reparación
    reparacionSelect.addEventListener('change', function() {
        if (this.value) {
            // Aquí podrías hacer una llamada AJAX para obtener más detalles
            // Por ahora solo removemos la validación
            this.classList.remove('is-invalid');
        }
    });
    
    // Actualizar información cuando se selecciona el tipo de ticket
    tipoTicketSelect.addEventListener('change', function() {
        if (this.value) {
            this.classList.remove('is-invalid');
        }
    });
});
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
    background: linear-gradient(45deg, #27DB9F, #20c997);
    border: none;
    color: white;
    transition: all 0.3s ease;
}

.btn-custom:hover {
    background: linear-gradient(45deg, #20c997, #27DB9F);
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(39, 219, 159, 0.4);
}
</style>
@endsection
