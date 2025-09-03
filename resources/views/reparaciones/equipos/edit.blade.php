@extends('layouts.app')

@section('title', 'Editar Equipo - ' . $equipo->numero_serie)

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-edit text-warning me-2"></i>
            Editar Equipo
        </h1>
        <p class="text-muted">Modifique la información del equipo {{ $equipo->numero_serie }}</p>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <a href="{{ route('equipos.show', $equipo) }}" class="btn btn-outline-primary">
                <i class="fas fa-eye me-2"></i>Ver Detalles
            </a>
            <a href="{{ route('equipos.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('equipos.update', $equipo) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Información del Equipo -->
                <div class="col-lg-6">
                    <h5 class="mb-3">
                        <i class="fas fa-laptop text-primary me-2"></i>
                        Información del Equipo
                    </h5>
                    
                    <div class="mb-3">
                        <label for="numero_serie" class="form-label">Número de Serie <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('numero_serie') is-invalid @enderror" 
                               id="numero_serie" 
                               name="numero_serie" 
                               value="{{ old('numero_serie', $equipo->numero_serie) }}" 
                               required>
                        @error('numero_serie')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="marca" class="form-label">Marca <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('marca') is-invalid @enderror" 
                                   id="marca" 
                                   name="marca" 
                                   value="{{ old('marca', $equipo->marca) }}" 
                                   required>
                            @error('marca')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="modelo" class="form-label">Modelo <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('modelo') is-invalid @enderror" 
                                   id="modelo" 
                                   name="modelo" 
                                   value="{{ old('modelo', $equipo->modelo) }}" 
                                   required>
                            @error('modelo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tipo_equipo" class="form-label">Tipo de Equipo <span class="text-danger">*</span></label>
                        <select class="form-select @error('tipo_equipo') is-invalid @enderror" 
                                id="tipo_equipo" 
                                name="tipo_equipo" 
                                required>
                            <option value="">Seleccione el tipo</option>
                            <option value="Computadora de Escritorio" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Computadora de Escritorio' ? 'selected' : '' }}>Computadora de Escritorio</option>
                            <option value="Laptop" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                            <option value="Impresora" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Impresora' ? 'selected' : '' }}>Impresora</option>
                            <option value="Monitor" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Monitor' ? 'selected' : '' }}>Monitor</option>
                            <option value="Servidor" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Servidor' ? 'selected' : '' }}>Servidor</option>
                            <option value="Tablet" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="Smartphone" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Smartphone' ? 'selected' : '' }}>Smartphone</option>
                            <option value="Otro" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('tipo_equipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                        <select class="form-select @error('estado') is-invalid @enderror" 
                                id="estado" 
                                name="estado" 
                                required>
                            <option value="recibido" {{ old('estado', $equipo->estado) == 'recibido' ? 'selected' : '' }}>Recibido</option>
                            <option value="en_reparacion" {{ old('estado', $equipo->estado) == 'en_reparacion' ? 'selected' : '' }}>En Reparación</option>
                            <option value="reparado" {{ old('estado', $equipo->estado) == 'reparado' ? 'selected' : '' }}>Reparado</option>
                            <option value="entregado" {{ old('estado', $equipo->estado) == 'entregado' ? 'selected' : '' }}>Entregado</option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción del Equipo</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" 
                                  name="descripcion" 
                                  rows="3" 
                                  placeholder="Descripción adicional del equipo, características especiales, etc.">{{ old('descripcion', $equipo->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Información del Cliente -->
                <div class="col-lg-6">
                    <h5 class="mb-3">
                        <i class="fas fa-user text-info me-2"></i>
                        Información del Cliente
                    </h5>

                    <div class="mb-3">
                        <label for="cliente_nombre" class="form-label">Nombre del Cliente <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('cliente_nombre') is-invalid @enderror" 
                               id="cliente_nombre" 
                               name="cliente_nombre" 
                               value="{{ old('cliente_nombre', $equipo->cliente_nombre) }}" 
                               required>
                        @error('cliente_nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cliente_telefono" class="form-label">Teléfono</label>
                        <input type="tel" 
                               class="form-control @error('cliente_telefono') is-invalid @enderror" 
                               id="cliente_telefono" 
                               name="cliente_telefono" 
                               value="{{ old('cliente_telefono', $equipo->cliente_telefono) }}"
                               placeholder="Ej: +1 234 567 8900">
                        @error('cliente_telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cliente_email" class="form-label">Email</label>
                        <input type="email" 
                               class="form-control @error('cliente_email') is-invalid @enderror" 
                               id="cliente_email" 
                               name="cliente_email" 
                               value="{{ old('cliente_email', $equipo->cliente_email) }}"
                               placeholder="cliente@email.com">
                        @error('cliente_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="costo_estimado" class="form-label">Costo Estimado</label>
                        <div class="input-group">
                            <span class="input-group-text">Q</span>
                            <input type="number" 
                                   class="form-control @error('costo_estimado') is-invalid @enderror" 
                                   id="costo_estimado" 
                                   name="costo_estimado" 
                                   value="{{ old('costo_estimado', $equipo->costo_estimado) }}"
                                   step="0.01"
                                   min="0"
                                   placeholder="0.00">
                        </div>
                        @error('costo_estimado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                  id="observaciones" 
                                  name="observaciones" 
                                  rows="3" 
                                  placeholder="Observaciones adicionales sobre el equipo...">{{ old('observaciones', $equipo->observaciones) }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Información de auditoría -->
                    <div class="alert alert-light">
                        <h6 class="alert-heading">Información del Registro</h6>
                        <p class="mb-2"><strong>Fecha de ingreso:</strong> {{ $equipo->fecha_ingreso->format('d/m/Y') }}</p>
                        <p class="mb-2"><strong>Registrado:</strong> {{ $equipo->created_at->format('d/m/Y H:i') }}</p>
                        <p class="mb-0"><strong>Última actualización:</strong> {{ $equipo->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('equipos.show', $equipo) }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            @if($equipo->reparaciones()->whereIn('estado', ['pendiente', 'en_proceso'])->doesntExist())
                                <button type="button" class="btn btn-outline-danger" onclick="confirmarEliminacion()">
                                    <i class="fas fa-trash me-2"></i>Eliminar Equipo
                                </button>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-warning btn-custom">
                            <i class="fas fa-save me-2"></i>Actualizar Equipo
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Formulario oculto para eliminar -->
        @if($equipo->reparaciones()->whereIn('estado', ['pendiente', 'en_proceso'])->doesntExist())
        <form id="eliminarForm" action="{{ route('equipos.destroy', $equipo) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
// Validación del formulario
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="update"]');
    const numeroSerie = document.getElementById('numero_serie');
    
    // Convertir a mayúsculas el número de serie
    numeroSerie.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
    
    // Validación del formulario
    form.addEventListener('submit', function(e) {
        let valid = true;
        const requiredFields = form.querySelectorAll('input[required], select[required]');
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                valid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!valid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos obligatorios.');
        }
    });
});

function confirmarEliminacion() {
    confirmarEliminacionDoble(
        '¿Está seguro de que desea eliminar este equipo?\n\nEsta acción no se puede deshacer y eliminará todo el historial relacionado.',
        'Confirme nuevamente: ¿Realmente desea eliminar el equipo {{ $equipo->numero_serie }}?',
        'eliminarForm'
    );
}
</script>
@endsection