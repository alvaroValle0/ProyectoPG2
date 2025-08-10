@extends('layouts.app')

@section('title', 'Nuevo Equipo')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-plus-circle text-success me-2"></i>
            Registrar Nuevo Equipo
        </h1>
        <p class="text-muted">Registre un nuevo equipo en el sistema</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('equipos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver al Listado
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('equipos.store') }}" method="POST">
            @csrf
            
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
                               value="{{ old('numero_serie') }}" 
                               required
                               placeholder="Ingrese el número de serie">
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
                                   value="{{ old('marca') }}" 
                                   required
                                   placeholder="Ej: HP, Dell, Lenovo">
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
                                   value="{{ old('modelo') }}" 
                                   required
                                   placeholder="Modelo específico">
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
                            <option value="Computadora de Escritorio" {{ old('tipo_equipo') == 'Computadora de Escritorio' ? 'selected' : '' }}>Computadora de Escritorio</option>
                            <option value="Laptop" {{ old('tipo_equipo') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                            <option value="Impresora" {{ old('tipo_equipo') == 'Impresora' ? 'selected' : '' }}>Impresora</option>
                            <option value="Monitor" {{ old('tipo_equipo') == 'Monitor' ? 'selected' : '' }}>Monitor</option>
                            <option value="Servidor" {{ old('tipo_equipo') == 'Servidor' ? 'selected' : '' }}>Servidor</option>
                            <option value="Tablet" {{ old('tipo_equipo') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="Smartphone" {{ old('tipo_equipo') == 'Smartphone' ? 'selected' : '' }}>Smartphone</option>
                            <option value="Otro" {{ old('tipo_equipo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('tipo_equipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="fecha_ingreso" class="form-label">Fecha de Ingreso <span class="text-danger">*</span></label>
                        <input type="date" 
                               class="form-control @error('fecha_ingreso') is-invalid @enderror" 
                               id="fecha_ingreso" 
                               name="fecha_ingreso" 
                               value="{{ old('fecha_ingreso', date('Y-m-d')) }}" 
                               required>
                        @error('fecha_ingreso')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción del Equipo</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" 
                                  name="descripcion" 
                                  rows="3" 
                                  placeholder="Descripción adicional del equipo, características especiales, etc.">{{ old('descripcion') }}</textarea>
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
                               value="{{ old('cliente_nombre') }}" 
                               required
                               placeholder="Nombre completo del cliente">
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
                               value="{{ old('cliente_telefono') }}"
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
                               value="{{ old('cliente_email') }}"
                               placeholder="cliente@email.com">
                        @error('cliente_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="costo_estimado" class="form-label">Costo Estimado</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" 
                                   class="form-control @error('costo_estimado') is-invalid @enderror" 
                                   id="costo_estimado" 
                                   name="costo_estimado" 
                                   value="{{ old('costo_estimado') }}"
                                   step="0.01"
                                   min="0"
                                   placeholder="0.00">
                        </div>
                        @error('costo_estimado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Estimación inicial del costo de reparación</div>
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                  id="observaciones" 
                                  name="observaciones" 
                                  rows="3" 
                                  placeholder="Observaciones adicionales sobre el equipo, problemas reportados por el cliente, etc.">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Información de ayuda -->
                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="fas fa-info-circle me-2"></i>Información Importante
                        </h6>
                        <p class="mb-2">• El equipo se registrará en estado "Recibido"</p>
                        <p class="mb-2">• Se generará automáticamente un código de seguimiento</p>
                        <p class="mb-0">• Los campos marcados con <span class="text-danger">*</span> son obligatorios</p>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('equipos.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-success btn-custom">
                            <i class="fas fa-save me-2"></i>Registrar Equipo
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Validación del formulario
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="store"]');
    const numeroSerie = document.getElementById('numero_serie');
    
    // Convertir a mayúsculas el número de serie
    numeroSerie.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
    
    // Validación del formulario
    form.addEventListener('submit', function(e) {
        let valid = true;
        const requiredFields = form.querySelectorAll('input[required], select[required]');
        
        // Limpiar validaciones previas
        requiredFields.forEach(field => {
            field.classList.remove('is-invalid');
        });
        
        // Validar campos requeridos
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                valid = false;
            }
        });
        
        // Validar email si está presente
        const emailField = document.getElementById('cliente_email');
        if (emailField.value && !isValidEmail(emailField.value)) {
            emailField.classList.add('is-invalid');
            valid = false;
        }
        
        // Validar teléfono si está presente
        const phoneField = document.getElementById('cliente_telefono');
        if (phoneField.value && phoneField.value.length < 7) {
            phoneField.classList.add('is-invalid');
            valid = false;
        }
        
        if (!valid) {
            e.preventDefault();
            alert('Por favor, verifique los campos marcados en rojo.');
            // Scroll al primer campo con error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });
    
    // Validación en tiempo real
    const emailField = document.getElementById('cliente_email');
    emailField.addEventListener('blur', function() {
        if (this.value && !isValidEmail(this.value)) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
    
    // Formatear costo estimado
    const costoField = document.getElementById('costo_estimado');
    costoField.addEventListener('blur', function() {
        if (this.value) {
            this.value = parseFloat(this.value).toFixed(2);
        }
    });
});

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Auto-completar algunos campos comunes
document.getElementById('tipo_equipo').addEventListener('change', function() {
    const tipo = this.value;
    const descripcionField = document.getElementById('descripcion');
    
    if (!descripcionField.value) {
        let descripcionSugerida = '';
        switch(tipo) {
            case 'Laptop':
                descripcionSugerida = 'Computadora portátil para revisión y reparación';
                break;
            case 'Computadora de Escritorio':
                descripcionSugerida = 'Equipo de escritorio para diagnóstico y reparación';
                break;
            case 'Impresora':
                descripcionSugerida = 'Impresora para revisión y mantenimiento';
                break;
            case 'Monitor':
                descripcionSugerida = 'Monitor para diagnóstico y reparación';
                break;
        }
        if (descripcionSugerida) {
            descripcionField.value = descripcionSugerida;
        }
    }
});
</script>
@endsection
