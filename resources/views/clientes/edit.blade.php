@extends('layouts.app')

@section('title', 'Editar Cliente: ' . $cliente->nombre_completo)

@section('content')
<div class="container-fluid">
    <!-- Header del Formulario -->
    <div class="form-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="form-title">
                    <i class="fas fa-user-edit text-gradient me-3"></i>
                    Editar Cliente
                </h1>
                <p class="form-subtitle">Modifica la información de: <strong>{{ $cliente->nombre_completo }}</strong></p>
            </div>
            <div class="col-lg-4 text-end">
                <div class="btn-group">
                    <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-outline-secondary btn-modern">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                    <a href="{{ route('clientes.index') }}" class="btn btn-outline-primary btn-modern">
                        <i class="fas fa-list me-2"></i>Todos los Clientes
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario Principal -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-card">
                <div class="form-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit text-warning me-2"></i>
                        Actualizar Información del Cliente
                    </h5>
                    <p class="mb-0 text-muted">Modifica los campos que necesites actualizar</p>
                </div>
                <div class="form-card-body">
                    <form action="{{ route('clientes.update', $cliente) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        
                        <!-- Información Personal -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-user text-primary me-2"></i>
                                <h6>Información Personal</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombres" class="form-label">
                                            <i class="fas fa-user me-1"></i>Nombres <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control modern-input @error('nombres') is-invalid @enderror" 
                                               id="nombres" 
                                               name="nombres" 
                                               value="{{ old('nombres', $cliente->nombres) }}" 
                                               placeholder="Ingresa los nombres"
                                               required>
                                        @error('nombres')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apellidos" class="form-label">
                                            <i class="fas fa-user me-1"></i>Apellidos <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control modern-input @error('apellidos') is-invalid @enderror" 
                                               id="apellidos" 
                                               name="apellidos" 
                                               value="{{ old('apellidos', $cliente->apellidos) }}" 
                                               placeholder="Ingresa los apellidos"
                                               required>
                                        @error('apellidos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dpi" class="form-label">
                                            <i class="fas fa-id-card me-1"></i>DPI
                                        </label>
                                        <input type="text" 
                                               class="form-control modern-input @error('dpi') is-invalid @enderror" 
                                               id="dpi" 
                                               name="dpi" 
                                               value="{{ old('dpi', $cliente->dpi) }}" 
                                               placeholder="0000 00000 0000"
                                               maxlength="20">
                                        <small class="form-text text-muted">Formato: 0000 00000 0000</small>
                                        @error('dpi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="estado" class="form-label">
                                            <i class="fas fa-toggle-on me-1"></i>Estado
                                        </label>
                                        <select class="form-select modern-select" id="estado" name="activo">
                                            <option value="1" {{ old('activo', $cliente->activo) == '1' ? 'selected' : '' }}>Activo</option>
                                            <option value="0" {{ old('activo', $cliente->activo) == '0' ? 'selected' : '' }}>Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-address-book text-success me-2"></i>
                                <h6>Información de Contacto</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono" class="form-label">
                                            <i class="fas fa-phone me-1"></i>Teléfono
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-phone"></i>
                                            </span>
                                            <input type="tel" 
                                                   class="form-control modern-input @error('telefono') is-invalid @enderror" 
                                                   id="telefono" 
                                                   name="telefono" 
                                                   value="{{ old('telefono', $cliente->telefono) }}" 
                                                   placeholder="0000-0000"
                                                   maxlength="20">
                                        </div>
                                        @error('telefono')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope me-1"></i>Correo Electrónico
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" 
                                                   class="form-control modern-input @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $cliente->email) }}" 
                                                   placeholder="cliente@email.com">
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Ubicación -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-map-marker-alt text-warning me-2"></i>
                                <h6>Información de Ubicación</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="direccion" class="form-label">
                                            <i class="fas fa-map-marker-alt me-1"></i>Dirección Completa
                                        </label>
                                        <textarea class="form-control modern-textarea @error('direccion') is-invalid @enderror" 
                                                  id="direccion" 
                                                  name="direccion" 
                                                  rows="3" 
                                                  placeholder="Ingresa la dirección completa del cliente">{{ old('direccion', $cliente->direccion) }}</textarea>
                                        @error('direccion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información Adicional -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-sticky-note text-info me-2"></i>
                                <h6>Información Adicional</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="observaciones" class="form-label">
                                            <i class="fas fa-comment me-1"></i>Observaciones
                                        </label>
                                        <textarea class="form-control modern-textarea @error('observaciones') is-invalid @enderror" 
                                                  id="observaciones" 
                                                  name="observaciones" 
                                                  rows="3" 
                                                  placeholder="Agrega observaciones adicionales sobre el cliente">{{ old('observaciones', $cliente->observaciones) }}</textarea>
                                        @error('observaciones')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información del Sistema -->
                        <div class="form-section info-section">
                            <div class="section-header">
                                <i class="fas fa-info-circle text-secondary me-2"></i>
                                <h6>Información del Sistema</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="info-label">Cliente ID:</label>
                                        <span class="info-value">{{ $cliente->id }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="info-label">Fecha de Registro:</label>
                                        <span class="info-value">{{ $cliente->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="info-label">Última Actualización:</label>
                                        <span class="info-value">{{ $cliente->updated_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="info-label">Total Equipos:</label>
                                        <span class="info-value">{{ $cliente->equipos->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-info">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Los campos marcados con <span class="text-danger">*</span> son obligatorios
                                            </small>
                                        </div>
                                        <div class="action-buttons">
                                            <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-outline-secondary btn-modern">
                                                <i class="fas fa-times me-2"></i>Cancelar
                                            </a>
                                            <button type="submit" class="btn btn-warning btn-modern">
                                                <i class="fas fa-save me-2"></i>Actualizar Cliente
                                            </button>
                                        </div>
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
@endsection

@section('styles')
<style>
/* Variables CSS */
:root {
    --primary-color: #4f46e5;
    --primary-light: #6366f1;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --info-color: #06b6d4;
    --secondary-color: #6b7280;
    --dark-color: #1f2937;
    --light-color: #f8fafc;
    --border-color: #e5e7eb;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Form Header */
.form-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: var(--shadow-lg);
}

.form-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.form-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0.5rem 0 0 0;
}

.btn-modern {
    border-radius: 25px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-md);
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-group {
    display: flex;
    gap: 0.5rem;
}

/* Form Card */
.form-card {
    background: white;
    border-radius: 15px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.form-card-header {
    background: var(--light-color);
    padding: 2rem;
    border-bottom: 1px solid var(--border-color);
    text-align: center;
}

.form-card-header h5 {
    margin: 0 0 0.5rem 0;
    font-weight: 600;
    color: var(--dark-color);
    font-size: 1.25rem;
}

.form-card-body {
    padding: 2rem;
}

/* Form Sections */
.form-section {
    margin-bottom: 2.5rem;
    padding: 1.5rem;
    background: var(--light-color);
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.form-section:last-of-type {
    margin-bottom: 2rem;
}

.section-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--primary-color);
}

.section-header h6 {
    margin: 0;
    font-weight: 600;
    color: var(--dark-color);
    font-size: 1.1rem;
}

.section-header i {
    font-size: 1.2rem;
}

/* Info Section */
.info-section {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border: 1px solid #cbd5e1;
}

.info-section .section-header {
    border-bottom-color: var(--secondary-color);
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-label {
    font-weight: 600;
    color: var(--dark-color);
    font-size: 0.875rem;
}

.info-value {
    color: var(--secondary-color);
    font-size: 1rem;
    padding: 0.5rem;
    background: white;
    border-radius: 8px;
    border: 1px solid var(--border-color);
}

/* Form Groups */
.form-group {
    margin-bottom: 1rem;
}

.form-label {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.form-label i {
    margin-right: 0.5rem;
    color: var(--primary-color);
}

.text-danger {
    color: var(--danger-color) !important;
}

/* Modern Inputs */
.modern-input,
.modern-select,
.modern-textarea {
    border: 2px solid var(--border-color);
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.modern-input:focus,
.modern-select:focus,
.modern-textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
    outline: none;
}

.modern-textarea {
    resize: vertical;
    min-height: 100px;
}

/* Input Groups */
.input-group-text {
    background: var(--light-color);
    border: 2px solid var(--border-color);
    border-right: none;
    color: var(--primary-color);
    font-weight: 500;
}

.input-group .modern-input {
    border-left: none;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.input-group .input-group-text {
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
}

/* Form Text */
.form-text {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

/* Invalid Feedback */
.invalid-feedback {
    display: block;
    color: var(--danger-color);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* Form Actions */
.form-actions {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid var(--border-color);
}

.form-info {
    color: #6b7280;
    font-size: 0.875rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-header {
        padding: 1.5rem;
    }
    
    .form-title {
        font-size: 2rem;
    }
    
    .form-card-header,
    .form-card-body {
        padding: 1.5rem;
    }
    
    .form-section {
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .form-actions {
        text-align: center;
    }
    
    .form-info {
        margin-bottom: 1rem;
    }
    
    .btn-group {
        flex-direction: column;
        gap: 0.5rem;
    }
}

/* Animaciones */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-card {
    animation: fadeInUp 0.6s ease-out;
}

.form-section {
    animation: fadeInUp 0.8s ease-out;
}

.form-section:nth-child(1) { animation-delay: 0.1s; }
.form-section:nth-child(2) { animation-delay: 0.2s; }
.form-section:nth-child(3) { animation-delay: 0.3s; }
.form-section:nth-child(4) { animation-delay: 0.4s; }
.form-section:nth-child(5) { animation-delay: 0.5s; }

/* Hover Effects */
.form-section:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    transition: all 0.3s ease;
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
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
            
            if (value.length > 0) {
                // Formato: 0000-0000
                if (value.length <= 4) {
                    value = value;
                } else {
                    value = value.substring(0, 4) + '-' + value.substring(4, 8);
                }
            }
            
            e.target.value = value;
        });
    }

    // Validación del formulario
    const form = document.querySelector('.needs-validation');
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    }

    // Efectos de hover para las secciones
    const sections = document.querySelectorAll('.form-section');
    sections.forEach(section => {
        section.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        section.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Auto-enfoque en el primer campo
    const firstInput = document.querySelector('.modern-input');
    if (firstInput) {
        firstInput.focus();
    }
});

// Función para limpiar el formulario
function limpiarFormulario() {
    document.querySelector('form').reset();
    document.querySelectorAll('.is-invalid').forEach(element => {
        element.classList.remove('is-invalid');
    });
}

// Función para validar email
function validarEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Validación en tiempo real del email
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const email = this.value.trim();
            if (email && !validarEmail(email)) {
                this.classList.add('is-invalid');
                if (!this.nextElementSibling || !this.nextElementSibling.classList.contains('invalid-feedback')) {
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = 'Por favor ingresa un email válido';
                    this.parentNode.appendChild(feedback);
                }
            } else {
                this.classList.remove('is-invalid');
                const feedback = this.parentNode.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.remove();
                }
            }
        });
    }
});
</script>
@endsection