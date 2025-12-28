@extends('layouts.app')

@section('title', 'Nuevo Proveedor')

@section('content')
<div class="container-fluid">
    <!-- Header del Formulario -->
    <div class="form-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="form-title">
                    <i class="fas fa-truck text-gradient me-3"></i>
                    Nuevo Proveedor
                </h1>
                <p class="form-subtitle">Registra un nuevo proveedor en el sistema de gestión</p>
            </div>
            <div class="col-lg-4 text-end">
                <a href="{{ route('proveedores.index') }}" class="btn btn-outline-secondary btn-modern">
                    <i class="fas fa-arrow-left me-2"></i>Volver a Proveedores
                </a>
            </div>
        </div>
    </div>

    <!-- Formulario Principal -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-card">
                <div class="form-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-truck text-primary me-2"></i>
                        Información del Proveedor
                    </h5>
                    <p class="mb-0 text-muted">Completa todos los campos requeridos para registrar el proveedor</p>
                </div>
                <div class="form-card-body">
                    <form action="{{ route('proveedores.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        
                        <!-- 1. Identificación del proveedor -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-building text-primary me-2"></i>
                                <h6>1. Identificación del Proveedor</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="nombre_empresa" class="form-label">
                                            <i class="fas fa-building me-1"></i>Nombre de la Empresa <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control modern-input @error('nombre_empresa') is-invalid @enderror" 
                                               id="nombre_empresa" 
                                               name="nombre_empresa" 
                                               value="{{ old('nombre_empresa') }}" 
                                               placeholder="Ingresa el nombre completo de la empresa"
                                               required>
                                        @error('nombre_empresa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nit" class="form-label">
                                            <i class="fas fa-id-card me-1"></i>NIT
                                        </label>
                                        <input type="text" 
                                               class="form-control modern-input @error('nit') is-invalid @enderror" 
                                               id="nit" 
                                               name="nit" 
                                               value="{{ old('nit') }}" 
                                               placeholder="00000000-0">
                                        @error('nit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_proveedor" class="form-label">
                                            <i class="fas fa-industry me-1"></i>Tipo de Proveedor <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select modern-select @error('tipo_proveedor') is-invalid @enderror" 
                                                id="tipo_proveedor" 
                                                name="tipo_proveedor" 
                                                required>
                                            <option value="">Selecciona el tipo de proveedor</option>
                                            @foreach($tiposProveedor as $valor => $etiqueta)
                                                <option value="{{ $valor }}" {{ old('tipo_proveedor') === $valor ? 'selected' : '' }}>
                                                    {{ $etiqueta }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('tipo_proveedor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-toggle-on me-1"></i>Estado del Proveedor
                                        </label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="activo" 
                                                   name="activo" 
                                                   value="1" 
                                                   {{ old('activo', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="activo">
                                                <span class="status-indicator status-active">Activo</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Datos de contacto -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-address-book text-primary me-2"></i>
                                <h6>2. Datos de Contacto</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre_contacto" class="form-label">
                                            <i class="fas fa-user me-1"></i>Nombre del Contacto
                                        </label>
                                        <input type="text" 
                                               class="form-control modern-input @error('nombre_contacto') is-invalid @enderror" 
                                               id="nombre_contacto" 
                                               name="nombre_contacto" 
                                               value="{{ old('nombre_contacto') }}" 
                                               placeholder="Nombre de la persona de contacto">
                                        @error('nombre_contacto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre_representante" class="form-label">
                                            <i class="fas fa-user-tie me-1"></i>Nombre del Representante
                                        </label>
                                        <input type="text" 
                                               class="form-control modern-input @error('nombre_representante') is-invalid @enderror" 
                                               id="nombre_representante" 
                                               name="nombre_representante" 
                                               value="{{ old('nombre_representante') }}" 
                                               placeholder="Nombre del representante legal">
                                        @error('nombre_representante')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telefono_fijo" class="form-label">
                                            <i class="fas fa-phone me-1"></i>Teléfono Fijo
                                        </label>
                                        <input type="tel" 
                                               class="form-control modern-input @error('telefono_fijo') is-invalid @enderror" 
                                               id="telefono_fijo" 
                                               name="telefono_fijo" 
                                               value="{{ old('telefono_fijo') }}" 
                                               placeholder="0000-0000"
                                               maxlength="20">
                                        @error('telefono_fijo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telefono_movil" class="form-label">
                                            <i class="fas fa-mobile-alt me-1"></i>Teléfono Móvil
                                        </label>
                                        <input type="tel" 
                                               class="form-control modern-input @error('telefono_movil') is-invalid @enderror" 
                                               id="telefono_movil" 
                                               name="telefono_movil" 
                                               value="{{ old('telefono_movil') }}" 
                                               placeholder="0000-0000"
                                               maxlength="20">
                                        @error('telefono_movil')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telefono" class="form-label">
                                            <i class="fas fa-phone me-1"></i>Teléfono Principal
                                        </label>
                                        <input type="tel" 
                                               class="form-control modern-input @error('telefono') is-invalid @enderror" 
                                               id="telefono" 
                                               name="telefono" 
                                               value="{{ old('telefono') }}" 
                                               placeholder="0000-0000"
                                               maxlength="20">
                                        @error('telefono')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope me-1"></i>Correo Electrónico Principal
                                        </label>
                                        <input type="email" 
                                               class="form-control modern-input @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email') }}" 
                                               placeholder="correo@empresa.com">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email_alternativo" class="form-label">
                                            <i class="fas fa-envelope-open me-1"></i>Correo Electrónico Alternativo
                                        </label>
                                        <input type="email" 
                                               class="form-control modern-input @error('email_alternativo') is-invalid @enderror" 
                                               id="email_alternativo" 
                                               name="email_alternativo" 
                                               value="{{ old('email_alternativo') }}" 
                                               placeholder="alternativo@empresa.com">
                                        @error('email_alternativo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="direccion" class="form-label">
                                            <i class="fas fa-map-marker-alt me-1"></i>Dirección Física
                                        </label>
                                        <textarea class="form-control modern-input @error('direccion') is-invalid @enderror" 
                                                  id="direccion" 
                                                  name="direccion" 
                                                  rows="3" 
                                                  placeholder="Ingresa la dirección completa de la empresa">{{ old('direccion') }}</textarea>
                                        @error('direccion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pagina_web" class="form-label">
                                            <i class="fas fa-globe me-1"></i>Página Web
                                        </label>
                                        <input type="url" 
                                               class="form-control modern-input @error('pagina_web') is-invalid @enderror" 
                                               id="pagina_web" 
                                               name="pagina_web" 
                                               value="{{ old('pagina_web') }}" 
                                               placeholder="https://www.empresa.com">
                                        @error('pagina_web')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Información de productos/servicios -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-boxes text-primary me-2"></i>
                                <h6>3. Información de Productos/Servicios</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="categoria_productos" class="form-label">
                                            <i class="fas fa-tags me-1"></i>Categoría de Productos/Servicios
                                        </label>
                                        <input type="text" 
                                               class="form-control modern-input @error('categoria_productos') is-invalid @enderror" 
                                               id="categoria_productos" 
                                               name="categoria_productos" 
                                               value="{{ old('categoria_productos') }}" 
                                               placeholder="Ej: Equipos de cómputo, software, hardware">
                                        @error('categoria_productos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tiempo_entrega_promedio" class="form-label">
                                            <i class="fas fa-clock me-1"></i>Tiempo Promedio de Entrega
                                        </label>
                                        <input type="text" 
                                               class="form-control modern-input @error('tiempo_entrega_promedio') is-invalid @enderror" 
                                               id="tiempo_entrega_promedio" 
                                               name="tiempo_entrega_promedio" 
                                               value="{{ old('tiempo_entrega_promedio') }}" 
                                               placeholder="Ej: 24 horas, 3-5 días">
                                        @error('tiempo_entrega_promedio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="condiciones_pago" class="form-label">
                                            <i class="fas fa-credit-card me-1"></i>Condiciones de Pago
                                        </label>
                                        <input type="text" 
                                               class="form-control modern-input @error('condiciones_pago') is-invalid @enderror" 
                                               id="condiciones_pago" 
                                               name="condiciones_pago" 
                                               value="{{ old('condiciones_pago') }}" 
                                               placeholder="Ej: Contado, Crédito 15/30 días">
                                        @error('condiciones_pago')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="descripcion_general" class="form-label">
                                            <i class="fas fa-list me-1"></i>Descripción General
                                        </label>
                                        <textarea class="form-control modern-input @error('descripcion_general') is-invalid @enderror" 
                                                  id="descripcion_general" 
                                                  name="descripcion_general" 
                                                  rows="4" 
                                                  placeholder="Describe los productos/servicios que ofrece este proveedor">{{ old('descripcion_general') }}</textarea>
                                        @error('descripcion_general')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="observaciones" class="form-label">
                                            <i class="fas fa-sticky-note me-1"></i>Observaciones
                                        </label>
                                        <textarea class="form-control modern-input @error('observaciones') is-invalid @enderror" 
                                                  id="observaciones" 
                                                  name="observaciones" 
                                                  rows="3" 
                                                  placeholder="Información adicional sobre el proveedor">{{ old('observaciones') }}</textarea>
                                        @error('observaciones')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-3">
                                        <a href="{{ route('proveedores.index') }}" class="btn btn-outline-secondary btn-lg">
                                            <i class="fas fa-times me-2"></i>Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save me-2"></i>Guardar Proveedor
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
@endsection

@section('styles')
<style>
/* Variables CSS para el formulario */
:root {
    --primary-color: #4f46e5;
    --primary-light: #6366f1;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --info-color: #06b6d4;
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
    background: var(--gradient-primary);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-lg);
}

.form-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
}

.form-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0.5rem 0 0 0;
}

/* Form Card */
.form-card {
    background: white;
    border-radius: 15px;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    border: none;
}

.form-card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--border-color);
}

.form-card-header h5 {
    font-weight: 600;
    color: var(--dark-color);
    margin: 0;
}

.form-card-body {
    padding: 2rem;
}

/* Form Sections */
.form-section {
    margin-bottom: 2.5rem;
    padding: 1.5rem;
    background: #f8fafc;
    border-radius: 12px;
    border-left: 4px solid var(--primary-color);
}

.section-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #e2e8f0;
}

.section-header h6 {
    font-weight: 600;
    color: var(--dark-color);
    margin: 0;
    font-size: 1.1rem;
}

.section-header i {
    font-size: 1.2rem;
    margin-right: 0.5rem;
}

/* Form Groups */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.form-label i {
    color: var(--primary-color);
    margin-right: 0.5rem;
    width: 16px;
}

/* Modern Inputs */
.modern-input,
.modern-select {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.modern-input:focus,
.modern-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    outline: none;
}

.modern-input::placeholder {
    color: #9ca3af;
    font-style: italic;
}

/* Form Switch */
.form-check-input:checked {
    background-color: var(--success-color);
    border-color: var(--success-color);
}

.status-indicator {
    font-weight: 600;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
}

.status-active {
    background: #d1fae5;
    color: #059669;
}

/* Form Actions */
.form-actions {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid #e2e8f0;
}

/* Buttons */
.btn-modern {
    border-radius: 8px;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
    border: none;
    box-shadow: var(--shadow-sm);
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-primary {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background: var(--primary-light);
    border-color: var(--primary-light);
}

/* Validation */
.is-invalid {
    border-color: var(--danger-color) !important;
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: var(--danger-color);
}

/* Responsive */
@media (max-width: 768px) {
    .form-header {
        padding: 1.5rem;
        text-align: center;
    }
    
    .form-title {
        font-size: 1.5rem;
    }
    
    .form-card-body {
        padding: 1.5rem;
    }
    
    .form-section {
        padding: 1rem;
    }
    
    .form-actions .d-flex {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario
    const form = document.querySelector('.needs-validation');
    
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        form.classList.add('was-validated');
    });
    
    // Animaciones suaves
    const sections = document.querySelectorAll('.form-section');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            section.style.transition = 'all 0.5s ease';
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Efectos de hover en los inputs
    const inputs = document.querySelectorAll('.modern-input, .modern-select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });
});
</script>
@endsection