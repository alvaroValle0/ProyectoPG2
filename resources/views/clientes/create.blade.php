@extends('layouts.app')

@section('title', 'Nuevo Cliente')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-user-plus text-primary me-2"></i>
                Nuevo Cliente
            </h1>
            <p class="text-muted mb-0">Registra un nuevo cliente en el sistema</p>
        </div>
        <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver a Clientes
        </a>
    </div>

    <!-- Formulario -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>
                        Información del Cliente
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('clientes.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Información Personal -->
                            <div class="col-lg-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-user me-2"></i>
                                    Información Personal
                                </h6>

                                <div class="mb-3">
                                    <label for="nombres" class="form-label">
                                        Nombres <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('nombres') is-invalid @enderror" 
                                           id="nombres" 
                                           name="nombres" 
                                           value="{{ old('nombres') }}" 
                                           required
                                           placeholder="Ej: Juan Carlos">
                                    @error('nombres')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="apellidos" class="form-label">
                                        Apellidos <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('apellidos') is-invalid @enderror" 
                                           id="apellidos" 
                                           name="apellidos" 
                                           value="{{ old('apellidos') }}" 
                                           required
                                           placeholder="Ej: Pérez López">
                                    @error('apellidos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="dpi" class="form-label">
                                        DPI <small class="text-muted">(Opcional)</small>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('dpi') is-invalid @enderror" 
                                           id="dpi" 
                                           name="dpi" 
                                           value="{{ old('dpi') }}" 
                                           placeholder="0000 00000 0000"
                                           maxlength="20">
                                    @error('dpi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Documento de identificación personal</small>
                                </div>
                            </div>

                            <!-- Información de Contacto -->
                            <div class="col-lg-6">
                                <h6 class="text-info mb-3">
                                    <i class="fas fa-address-book me-2"></i>
                                    Información de Contacto
                                </h6>

                                <div class="mb-3">
                                    <label for="telefono" class="form-label">
                                        Teléfono
                                    </label>
                                    <input type="tel" 
                                           class="form-control @error('telefono') is-invalid @enderror" 
                                           id="telefono" 
                                           name="telefono" 
                                           value="{{ old('telefono') }}" 
                                           placeholder="0000-0000"
                                           maxlength="20">
                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        Correo Electrónico
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="cliente@email.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="direccion" class="form-label">
                                        Dirección
                                    </label>
                                    <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                              id="direccion" 
                                              name="direccion" 
                                              rows="3"
                                              placeholder="Dirección completa del cliente">{{ old('direccion') }}</textarea>
                                    @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-warning mb-3">
                                    <i class="fas fa-sticky-note me-2"></i>
                                    Observaciones Adicionales
                                </h6>

                                <div class="mb-3">
                                    <label for="observaciones" class="form-label">
                                        Observaciones
                                    </label>
                                    <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                              id="observaciones" 
                                              name="observaciones" 
                                              rows="4"
                                              placeholder="Notas adicionales sobre el cliente, preferencias, historial, etc.">{{ old('observaciones') }}</textarea>
                                    @error('observaciones')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="activo" 
                                               name="activo" 
                                               value="1" 
                                               {{ old('activo', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="activo">
                                            Cliente Activo
                                        </label>
                                    </div>
                                    <small class="text-muted">
                                        Los clientes inactivos no aparecerán en las búsquedas por defecto
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Guardar Cliente
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Formateo automático del DPI
    const dpiInput = document.getElementById('dpi');
    if (dpiInput) {
        dpiInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Solo números
            
            if (value.length > 0) {
                // Formato: 0000 00000 0000
                if (value.length <= 4) {
                    value = value;
                } else if (value.length <= 9) {
                    value = value.substring(0, 4) + ' ' + value.substring(4);
                } else {
                    value = value.substring(0, 4) + ' ' + value.substring(4, 9) + ' ' + value.substring(9, 13);
                }
            }
            
            e.target.value = value;
        });
    }

    // Formateo automático del teléfono
    const telefonoInput = document.getElementById('telefono');
    if (telefonoInput) {
        telefonoInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Solo números
            
            if (value.length > 0 && value.length <= 8) {
                // Formato: 0000-0000
                if (value.length > 4) {
                    value = value.substring(0, 4) + '-' + value.substring(4);
                }
            }
            
            e.target.value = value;
        });
    }

    // Validación en tiempo real
    const requiredFields = ['nombres', 'apellidos'];
    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });

            field.addEventListener('input', function() {
                if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                    this.classList.remove('is-invalid');
                }
            });
        }
    });

    // Validación del email
    const emailField = document.getElementById('email');
    if (emailField) {
        emailField.addEventListener('blur', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && !emailRegex.test(this.value)) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }

    // Enfoque en el primer campo
    document.getElementById('nombres').focus();
});
</script>
@endsection

@section('styles')
<style>
.form-label {
    font-weight: 600;
    color: #5a5c69;
}

.card-header {
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.text-danger {
    color: #e74a3b !important;
}

.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.form-check-input:checked {
    background-color: #1cc88a;
    border-color: #1cc88a;
}

.gap-2 {
    gap: 0.5rem !important;
}

h6 {
    border-bottom: 2px solid #f8f9fc;
    padding-bottom: 0.5rem;
    margin-bottom: 1rem !important;
}
</style>
@endsection