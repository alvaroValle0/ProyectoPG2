@extends('layouts.app')

@section('title', 'Editar Cliente: ' . $cliente->nombre_completo)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-user-edit text-warning me-2"></i>
                Editar Cliente
            </h1>
            <p class="text-muted mb-0">Modifica la información de: <strong>{{ $cliente->nombre_completo }}</strong></p>
        </div>
        <div class="btn-group">
            <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
            <a href="{{ route('clientes.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-list me-2"></i>Todos los Clientes
            </a>
        </div>
    </div>

    <!-- Formulario -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i>
                        Actualizar Información del Cliente
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
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
                                           value="{{ old('nombres', $cliente->nombres) }}" 
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
                                           value="{{ old('apellidos', $cliente->apellidos) }}" 
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
                                           value="{{ old('dpi', $cliente->dpi) }}" 
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
                                           value="{{ old('telefono', $cliente->telefono) }}" 
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
                                           value="{{ old('email', $cliente->email) }}" 
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
                                              placeholder="Dirección completa del cliente">{{ old('direccion', $cliente->direccion) }}</textarea>
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
                                              placeholder="Notas adicionales sobre el cliente, preferencias, historial, etc.">{{ old('observaciones', $cliente->observaciones) }}</textarea>
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
                                               {{ old('activo', $cliente->activo) ? 'checked' : '' }}>
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

                        <!-- Información de Registro -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card bg-light mb-4">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-2">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Información de Registro
                                        </h6>
                                        <div class="row text-sm">
                                            <div class="col-md-6">
                                                <strong>Creado:</strong> {{ $cliente->created_at->format('d/m/Y H:i') }}
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Última modificación:</strong> {{ $cliente->updated_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <!-- Botón de eliminar (si no tiene reparaciones) -->
                                        @if($cliente->reparaciones->count() === 0 && $cliente->equipos->count() === 0)
                                        <button type="button" 
                                                class="btn btn-outline-danger" 
                                                onclick="eliminarCliente({{ $cliente->id }}, '{{ $cliente->nombre_completo }}')">
                                            <i class="fas fa-trash me-2"></i>Eliminar Cliente
                                        </button>
                                        @else
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            No se puede eliminar: tiene {{ $cliente->reparaciones->count() }} reparaciones y {{ $cliente->equipos->count() }} equipos asociados
                                        </small>
                                        @endif
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-save me-2"></i>Actualizar Cliente
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
@if($cliente->reparaciones->count() === 0 && $cliente->equipos->count() === 0)
<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true" style="z-index: 1055;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="eliminarModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <h6>¿Estás seguro de que deseas eliminar al cliente?</h6>
                    <p class="fw-bold text-danger">{{ $cliente->nombre_completo }}</p>
                </div>
                <div class="alert alert-warning border-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Advertencia:</strong> Esta acción no se puede deshacer y eliminará permanentemente toda la información del cliente.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <form id="eliminarForm" method="POST" action="{{ route('clientes.destroy', $cliente) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="btnEliminar">
                        <i class="fas fa-trash me-2"></i>Eliminar Cliente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
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
});

@if($cliente->reparaciones->count() === 0 && $cliente->equipos->count() === 0)
function eliminarCliente(clienteId, clienteNombre) {
    try {
        // Limpiar cualquier modal previo
        const existingModal = bootstrap.Modal.getInstance(document.getElementById('eliminarModal'));
        if (existingModal) {
            existingModal.dispose();
        }
        
        // Crear y mostrar el modal
        const modalElement = document.getElementById('eliminarModal');
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement, {
                backdrop: 'static',
                keyboard: false
            });
            modal.show();
        }
    } catch (error) {
        console.error('Error al abrir modal de eliminación:', error);
        // Fallback con confirm si el modal falla
        if (confirm(`¿Estás seguro de que deseas eliminar al cliente "${clienteNombre}"?\n\nEsta acción no se puede deshacer.`)) {
            document.getElementById('eliminarForm').submit();
        }
    }
}

// Mejorar el manejo del formulario de eliminación
document.addEventListener('DOMContentLoaded', function() {
    const eliminarForm = document.getElementById('eliminarForm');
    if (eliminarForm) {
        eliminarForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Eliminando...';
                
                // Prevenir doble click
                setTimeout(() => {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-trash me-2"></i>Eliminar Cliente';
                    }
                }, 5000);
            }
        });
    }
});
@endif
</script>
@endsection

@section('styles')
<style>
.form-label {
    font-weight: 600;
    color: #5a5c69;
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,0.125);
}

.text-danger {
    color: #e74a3b !important;
}

.form-control:focus {
    border-color: #f6c23e;
    box-shadow: 0 0 0 0.2rem rgba(246, 194, 62, 0.25);
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

.text-sm {
    font-size: 0.875rem;
}

.bg-light {
    background-color: #f8f9fc !important;
}

.btn-group .btn {
    border-radius: 0.35rem;
}

.btn-group .btn:not(:last-child) {
    margin-right: 0.5rem;
}
</style>
@endsection