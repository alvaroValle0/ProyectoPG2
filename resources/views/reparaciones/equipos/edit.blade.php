@extends('layouts.app')

@section('title', 'Editar Equipo - ' . $equipo->numero_serie)

@section('content')
<div class="container-fluid">
    <!-- Header Minimalista -->
    <div class="minimal-header mb-5">
        <div class="header-content">
            <div class="header-icon-wrapper">
                <i class="fas fa-laptop"></i>
            </div>
            <div class="header-text">
                <h1 class="header-title">Editar Equipo</h1>
                <p class="header-subtitle">Modificar información de {{ $equipo->numero_serie }}</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('equipos.index') }}" class="btn btn-light btn-minimal">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>
    </div>

        @if ($errors->any())
        <div class="alert alert-danger alert-minimal alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                    <strong>Se encontraron {{ $errors->count() }} errores:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if (session('success'))
        <div class="alert alert-success alert-minimal alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
        <!-- Formulario Principal -->
        <div class="col-xl-8">
                <form action="{{ route('equipos.update', $equipo) }}" method="POST" id="equipoEditForm">
                    @csrf
                    @method('PUT')

                <!-- Información del Equipo -->
                <div class="input-card">
                    <div class="card-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="card-content">
                        <label for="numero_serie" class="card-label">
                            Número de Serie <span class="required">*</span>
                                    </label>
                                    <input type="text"
                               class="form-control input-minimal @error('numero_serie') is-invalid @enderror"
                                           id="numero_serie"
                                           name="numero_serie"
                                           value="{{ old('numero_serie', $equipo->numero_serie) }}"
                                           placeholder="Ingrese el número de serie"
                                           required>
                        @error('numero_serie')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="card-hint">
                            <i class="fas fa-info-circle"></i>
                            Identificador único del equipo
                                    </div>
                                </div>
                            </div>

                <!-- Marca y Modelo -->
                <div class="row g-3">
                            <div class="col-md-6">
                        <div class="input-card">
                            <div class="card-icon">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div class="card-content">
                                <label for="marca" class="card-label">
                                    Marca <span class="required">*</span>
                                    </label>
                                    <input type="text"
                                       class="form-control input-minimal @error('marca') is-invalid @enderror"
                                           id="marca"
                                           name="marca"
                                           value="{{ old('marca', $equipo->marca) }}"
                                           placeholder="Marca del equipo"
                                           list="marcas-list"
                                           required>
                                    <datalist id="marcas-list">
                                        <option value="HP">
                                        <option value="Dell">
                                        <option value="Lenovo">
                                        <option value="ASUS">
                                        <option value="Acer">
                                        <option value="Apple">
                                        <option value="Samsung">
                                        <option value="MSI">
                                        <option value="LG">
                                        <option value="Sony">
                                    </datalist>
                                @error('marca')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                        <div class="input-card">
                            <div class="card-icon">
                                <i class="fas fa-cube"></i>
                            </div>
                            <div class="card-content">
                                <label for="modelo" class="card-label">
                                    Modelo <span class="required">*</span>
                                    </label>
                                    <input type="text"
                                       class="form-control input-minimal @error('modelo') is-invalid @enderror"
                                           id="modelo"
                                           name="modelo"
                                           value="{{ old('modelo', $equipo->modelo) }}"
                                           placeholder="Modelo específico"
                                           required>
                                @error('modelo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                                    </div>
                                </div>
                            </div>

                <!-- Tipo de Equipo -->
                <div class="input-card">
                    <div class="card-icon">
                        <i class="fas fa-desktop"></i>
                    </div>
                    <div class="card-content">
                        <label for="tipo_equipo" class="card-label">
                            Tipo de Equipo <span class="required">*</span>
                                    </label>
                        <select class="form-control input-minimal @error('tipo_equipo') is-invalid @enderror"
                                            id="tipo_equipo"
                                            name="tipo_equipo"
                                            required>
                                        <option value="">Seleccione el tipo de equipo</option>
                                        <option value="Laptop" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Laptop' ? 'selected' : '' }}>💻 Laptop</option>
                                        <option value="Computadora de Escritorio" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Computadora de Escritorio' ? 'selected' : '' }}>🖥️ Computadora de Escritorio</option>
                                        <option value="Impresora" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Impresora' ? 'selected' : '' }}>🖨️ Impresora</option>
                                        <option value="Monitor" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Monitor' ? 'selected' : '' }}>🖥️ Monitor</option>
                                        <option value="Servidor" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Servidor' ? 'selected' : '' }}>🗄️ Servidor</option>
                                        <option value="Tablet" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Tablet' ? 'selected' : '' }}>📱 Tablet</option>
                                        <option value="Smartphone" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Smartphone' ? 'selected' : '' }}>📱 Smartphone</option>
                                        <option value="Otro" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Otro' ? 'selected' : '' }}>⚙️ Otro</option>
                                    </select>
                        @error('tipo_equipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                                </div>
                            </div>

                <!-- Descripción del Equipo -->
                <div class="input-card">
                    <div class="card-icon">
                        <i class="fas fa-align-left"></i>
                    </div>
                    <div class="card-content">
                        <label for="descripcion" class="card-label">
                                        Descripción del Equipo
                                    </label>
                        <textarea class="form-control input-minimal @error('descripcion') is-invalid @enderror"
                                              id="descripcion"
                                              name="descripcion"
                                  rows="4"
                                              placeholder="Características, estado físico, accesorios incluidos..."
                                              maxlength="500">{{ old('descripcion', $equipo->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="card-hint">
                            <i class="fas fa-info-circle"></i>
                            Detalles técnicos del equipo (máximo 500 caracteres)
                            </div>
                        </div>
                    </div>

                <!-- Información del Cliente -->
                <div class="input-card">
                    <div class="card-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="card-content">
                        <label for="cliente_nombre" class="card-label">
                            Nombre del Cliente <span class="required">*</span>
                                    </label>
                                    <input type="text"
                               class="form-control input-minimal @error('cliente_nombre') is-invalid @enderror"
                                           id="cliente_nombre"
                                           name="cliente_nombre"
                                           value="{{ old('cliente_nombre', $equipo->cliente_nombre) }}"
                                           placeholder="Nombre completo del cliente"
                                           required>
                        @error('cliente_nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                                </div>
                            </div>
                            
                <!-- Contacto del Cliente -->
                <div class="row g-3">
                            <div class="col-md-6">
                        <div class="input-card">
                            <div class="card-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="card-content">
                                <label for="cliente_telefono" class="card-label">
                                        Teléfono
                                    </label>
                                    <input type="tel"
                                       class="form-control input-minimal @error('cliente_telefono') is-invalid @enderror"
                                           id="cliente_telefono"
                                           name="cliente_telefono"
                                           value="{{ old('cliente_telefono', $equipo->cliente_telefono) }}"
                                           placeholder="+502 1234 5678">
                                @error('cliente_telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                        <div class="input-card">
                            <div class="card-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="card-content">
                                <label for="cliente_email" class="card-label">
                                        Correo Electrónico
                                    </label>
                                    <input type="email"
                                       class="form-control input-minimal @error('cliente_email') is-invalid @enderror"
                                           id="cliente_email"
                                           name="cliente_email"
                                           value="{{ old('cliente_email', $equipo->cliente_email) }}"
                                           placeholder="cliente@correo.com">
                                @error('cliente_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                                    </div>
                                </div>
                            </div>
                            
                <!-- Estado y Costo -->
                <div class="row g-3">
                            <div class="col-md-6">
                        <div class="input-card">
                            <div class="card-icon">
                                <i class="fas fa-flag"></i>
                            </div>
                            <div class="card-content">
                                <label for="estado" class="card-label">
                                    Estado del Equipo <span class="required">*</span>
                                </label>
                                <select class="form-control input-minimal @error('estado') is-invalid @enderror"
                                        id="estado"
                                        name="estado"
                                        required>
                                    <option value="recibido" {{ old('estado', $equipo->estado) == 'recibido' ? 'selected' : '' }}>🔴 Recibido</option>
                                    <option value="en_reparacion" {{ old('estado', $equipo->estado) == 'en_reparacion' ? 'selected' : '' }}>🟡 En Reparación</option>
                                    <option value="reparado" {{ old('estado', $equipo->estado) == 'reparado' ? 'selected' : '' }}>🟢 Reparado</option>
                                    <option value="entregado" {{ old('estado', $equipo->estado) == 'entregado' ? 'selected' : '' }}>⚪ Entregado</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-card">
                            <div class="card-icon">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div class="card-content">
                                <label for="costo_estimado" class="card-label">
                                        Costo Estimado (Q)
                                    </label>
                                    <input type="number"
                                       class="form-control input-minimal @error('costo_estimado') is-invalid @enderror"
                                           id="costo_estimado"
                                           name="costo_estimado"
                                           value="{{ old('costo_estimado', $equipo->costo_estimado) }}"
                                           step="0.01"
                                           min="0"
                                           placeholder="0.00">
                                @error('costo_estimado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="card-hint">
                                    <i class="fas fa-info-circle"></i>
                                    Costo estimado de la reparación
                                </div>
                            </div>
                                    </div>
                                </div>
                            </div>
                            
                <!-- Observaciones -->
                <div class="input-card">
                    <div class="card-icon">
                        <i class="fas fa-sticky-note"></i>
                    </div>
                    <div class="card-content">
                        <label for="observaciones" class="card-label">
                                        Observaciones
                                    </label>
                        <textarea class="form-control input-minimal @error('observaciones') is-invalid @enderror"
                                              id="observaciones"
                                              name="observaciones"
                                  rows="3"
                                              placeholder="Problemas reportados, condiciones especiales, notas importantes..."
                                              maxlength="1000">{{ old('observaciones', $equipo->observaciones) }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="card-hint">
                            <i class="fas fa-info-circle"></i>
                            Información adicional del servicio (máximo 1000 caracteres)
                                    </div>
                                    </div>
                                </div>

                <!-- Botones de Acción -->
                <div class="action-section">
                    <div class="action-info">
                        <i class="fas fa-info-circle"></i>
                        Los campos marcados con <span class="required">*</span> son obligatorios
                            </div>
                    <div class="action-buttons">
                        <a href="{{ route('equipos.index') }}" class="btn btn-outline-secondary btn-action">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary btn-action">
                            <i class="fas fa-save"></i>
                            Guardar Cambios
                        </button>
                        </div>
                </div>
            </form>
                    </div>
                    
        <!-- Panel Lateral -->
        <div class="col-xl-4">
            <!-- Información del Equipo -->
            <div class="info-panel">
                <div class="panel-header">
                    <div class="panel-icon">
                        <i class="fas fa-laptop"></i>
                                    </div>
                    <h6 class="panel-title">Información del Equipo</h6>
                                </div>
                <div class="panel-body">
                    <div class="info-row">
                        <span class="info-label">Equipo:</span>
                        <span class="info-value" id="preview-equipo">{{ $equipo->marca }} {{ $equipo->modelo }}</span>
                            </div>
                            
                    <div class="info-row">
                        <span class="info-label">Serie:</span>
                        <span class="info-value" id="preview-serie">{{ $equipo->numero_serie }}</span>
                                </div>
                    
                    <div class="info-row">
                        <span class="info-label">Tipo:</span>
                        <span class="info-value" id="preview-tipo">{{ $equipo->tipo_equipo }}</span>
            </div>
            
                    <div class="info-row">
                        <span class="info-label">Cliente:</span>
                        <span class="info-value" id="preview-cliente">{{ $equipo->cliente_nombre }}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Estado:</span>
                        <span class="info-value" id="preview-estado">{{ ucfirst(str_replace('_', ' ', $equipo->estado)) }}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Costo:</span>
                        <span class="info-value" id="preview-costo">Q {{ number_format($equipo->costo_estimado ?? 0, 2) }}</span>
                    </div>
                </div>
                    </div>
                    
            <!-- Información del Registro -->
            <div class="guide-panel">
                <div class="panel-header">
                    <div class="panel-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h6 class="panel-title">Información del Registro</h6>
                </div>
                <div class="panel-body">
                    <div class="info-row">
                        <span class="info-label">Fecha de Ingreso:</span>
                        <span class="info-value">{{ $equipo->fecha_ingreso->format('d/m/Y') }}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Registrado:</span>
                        <span class="info-value">{{ $equipo->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Última Actualización:</span>
                        <span class="info-value">{{ $equipo->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    @if($equipo->reparaciones->count() > 0)
                    <div class="info-row">
                        <span class="info-label">Reparaciones:</span>
                        <span class="info-value">{{ $equipo->reparaciones->count() }} registro(s)</span>
                    </div>
                    @endif
            </div>
        </div>

            <!-- Acciones Rápidas -->
            <div class="guide-panel">
                <div class="panel-header">
                    <div class="panel-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h6 class="panel-title">Acciones Rápidas</h6>
                </div>
                <div class="panel-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('equipos.show', $equipo) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-2"></i>Ver Detalles
                        </a>
                        
            @if($equipo->reparaciones()->whereIn('estado', ['pendiente', 'en_proceso'])->doesntExist())
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmarEliminacion()">
                            <i class="fas fa-trash me-2"></i>Eliminar Equipo
            </button>
            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>

        <!-- Formulario oculto para eliminar -->
        @if($equipo->reparaciones()->whereIn('estado', ['pendiente', 'en_proceso'])->doesntExist())
        <form id="eliminarForm" action="{{ route('equipos.destroy', $equipo) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        @endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario
    document.getElementById('equipoEditForm').addEventListener('submit', function(e) {
        const numeroSerie = document.getElementById('numero_serie').value.trim();
        const marca = document.getElementById('marca').value.trim();
        const modelo = document.getElementById('modelo').value.trim();
        const tipoEquipo = document.getElementById('tipo_equipo').value;
        const clienteNombre = document.getElementById('cliente_nombre').value.trim();
        const estado = document.getElementById('estado').value;
        
        if (!numeroSerie) {
            e.preventDefault();
            showValidationError('Por favor, ingrese el número de serie.', document.getElementById('numero_serie'));
            return false;
        }
        
        if (!marca) {
            e.preventDefault();
            showValidationError('Por favor, ingrese la marca.', document.getElementById('marca'));
            return false;
        }
        
        if (!modelo) {
            e.preventDefault();
            showValidationError('Por favor, ingrese el modelo.', document.getElementById('modelo'));
            return false;
        }
        
        if (!tipoEquipo) {
                e.preventDefault();
            showValidationError('Por favor, seleccione el tipo de equipo.', document.getElementById('tipo_equipo'));
            return false;
        }
        
        if (!clienteNombre) {
                    e.preventDefault();
            showValidationError('Por favor, ingrese el nombre del cliente.', document.getElementById('cliente_nombre'));
            return false;
        }
        
        if (!estado) {
                    e.preventDefault();
            showValidationError('Por favor, seleccione el estado.', document.getElementById('estado'));
            return false;
        }
        
        // Deshabilitar botón para evitar doble envío
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        submitBtn.disabled = true;
        
        // Re-habilitar el botón después de 5 segundos por si hay error
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 5000);
    });

    // Actualizar vista previa en tiempo real
    function updatePreview() {
        const marca = document.getElementById('marca').value || '{{ $equipo->marca }}';
        const modelo = document.getElementById('modelo').value || '{{ $equipo->modelo }}';
        const numeroSerie = document.getElementById('numero_serie').value || '{{ $equipo->numero_serie }}';
        const tipoEquipo = document.getElementById('tipo_equipo').value || '{{ $equipo->tipo_equipo }}';
        const clienteNombre = document.getElementById('cliente_nombre').value || '{{ $equipo->cliente_nombre }}';
        const estado = document.getElementById('estado').value || '{{ $equipo->estado }}';
        const costo = document.getElementById('costo_estimado').value || '{{ $equipo->costo_estimado ?? 0 }}';
        
        document.getElementById('preview-equipo').textContent = `${marca} ${modelo}`;
        document.getElementById('preview-serie').textContent = numeroSerie;
        document.getElementById('preview-tipo').textContent = tipoEquipo;
        document.getElementById('preview-cliente').textContent = clienteNombre;
        document.getElementById('preview-estado').textContent = estado.replace('_', ' ').charAt(0).toUpperCase() + estado.replace('_', ' ').slice(1);
        document.getElementById('preview-costo').textContent = `Q ${parseFloat(costo || 0).toFixed(2)}`;
    }

    // Escuchar cambios en los campos
    const fields = ['numero_serie', 'marca', 'modelo', 'tipo_equipo', 'cliente_nombre', 'estado', 'costo_estimado'];
    fields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
            if (field) {
            field.addEventListener('input', updatePreview);
            field.addEventListener('change', updatePreview);
        }
    });

    // Función para mostrar errores de validación
    function showValidationError(message, element) {
        // Crear toast de error
        const toast = document.createElement('div');
        toast.className = 'validation-toast';
        toast.innerHTML = `
            <i class="fas fa-exclamation-circle"></i>
            ${message}
        `;
        document.body.appendChild(toast);
        
        // Mostrar toast
        setTimeout(() => toast.classList.add('show'), 100);
        
        // Remover toast después de 3 segundos
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
        
        // Enfocar elemento
        element.focus();
        element.classList.add('is-invalid');
        
        // Remover clase de error después de 3 segundos
        setTimeout(() => element.classList.remove('is-invalid'), 3000);
    }
});

// Función de confirmación de eliminación
function confirmarEliminacion() {
    if (confirm('¿Está seguro de que desea eliminar este equipo?\n\nEsta acción no se puede deshacer y eliminará todo el historial relacionado.')) {
        if (confirm('Confirme nuevamente: ¿Realmente desea eliminar el equipo {{ $equipo->numero_serie }}?')) {
            document.getElementById('eliminarForm').submit();
        }
    }
}
</script>
@endsection

@section('styles')
<style>
/* Variables CSS */
:root {
    --primary-color: #6366f1;
    --primary-light: #818cf8;
    --primary-dark: #4f46e5;
    --secondary-color: #64748b;
    --success-color: #22c55e;
    --warning-color: #eab308;
    --danger-color: #ef4444;
    --info-color: #06b6d4;
    --light-color: #f8fafc;
    --lighter-color: #f1f5f9;
    --border-color: #e2e8f0;
    --text-primary: #1e293b;
    --text-secondary: #64748b;
    --text-muted: #94a3b8;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
}

/* Minimal Header */
.minimal-header {
    background: white;
    border-radius: var(--radius-lg);
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.header-icon-wrapper {
    width: 60px;
    height: 60px;
    background: var(--lighter-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    font-size: 1.5rem;
}

.header-title {
    font-size: 2rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.header-subtitle {
    color: var(--text-secondary);
    margin: 0.25rem 0 0 0;
    font-size: 1rem;
}

.header-actions {
    display: flex;
    gap: 1rem;
}

/* Input Cards */
.input-card {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    gap: 1.5rem;
    align-items: flex-start;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.input-card:hover {
    border-color: var(--primary-light);
    box-shadow: var(--shadow-md);
}

.card-icon {
    width: 40px;
    height: 40px;
    background: var(--lighter-color);
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    font-size: 1.1rem;
    flex-shrink: 0;
}

.card-content {
    flex: 1;
}

.card-label {
    display: block;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.required {
    color: var(--danger-color);
    font-weight: 700;
}

.card-hint {
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Minimal Inputs */
.input-minimal {
    border: 2px solid var(--border-color);
    border-radius: var(--radius-sm);
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
    color: var(--text-primary);
}

.input-minimal:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    outline: none;
}

.input-minimal::placeholder {
    color: var(--text-muted);
}

textarea.input-minimal {
    resize: vertical;
    min-height: 120px;
}

/* Action Section */
.action-section {
    background: var(--lighter-color);
    border-radius: var(--radius-md);
    padding: 2rem;
    margin-top: 2rem;
    border: 1px solid var(--border-color);
}

.action-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin-bottom: 1.5rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

/* Buttons */
.btn-minimal {
    background: white;
    border: 1px solid var(--border-color);
    color: var(--text-secondary);
    border-radius: var(--radius-sm);
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-minimal:hover {
    background: var(--lighter-color);
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.btn-action {
    border-radius: var(--radius-sm);
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background: var(--primary-dark);
    border-color: var(--primary-dark);
}

.btn-outline-secondary {
    border-color: var(--border-color);
    color: var(--text-secondary);
}

.btn-outline-secondary:hover {
    background: var(--lighter-color);
    border-color: var(--text-secondary);
}

/* Info Panels */
.info-panel,
.guide-panel {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.panel-header {
    background: var(--lighter-color);
    padding: 1.25rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.panel-icon {
    width: 32px;
    height: 32px;
    background: var(--primary-color);
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
}

.panel-title {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
}

.panel-body {
    padding: 1.25rem;
}

/* Info Rows */
.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-color);
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 500;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.info-value {
    color: var(--text-primary);
    font-weight: 500;
    text-align: right;
}

/* Alert Minimal */
.alert-minimal {
    border-radius: var(--radius-sm);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
}

/* Validation Toast */
.validation-toast {
            position: fixed;
    top: 20px;
    right: 20px;
    background: var(--danger-color);
            color: white;
    padding: 1rem 1.5rem;
    border-radius: var(--radius-sm);
    box-shadow: var(--shadow-lg);
    z-index: 9999;
    transform: translateX(400px);
    transition: transform 0.3s ease;
            display: flex;
            align-items: center;
    gap: 0.5rem;
}

.validation-toast.show {
    transform: translateX(0);
}

/* Invalid Feedback */
.invalid-feedback {
    color: var(--danger-color);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.is-invalid {
    border-color: var(--danger-color) !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
}

/* Responsive */
@media (max-width: 1200px) {
    .header-title {
        font-size: 1.75rem;
    }
    
    .input-card {
        padding: 1.25rem;
    }
}

@media (max-width: 768px) {
    .minimal-header {
        flex-direction: column;
        gap: 1.5rem;
        text-align: center;
    }
    
    .header-content {
        flex-direction: column;
        text-align: center;
    }
    
    .input-card {
        flex-direction: column;
        gap: 1rem;
    }
    
    .card-icon {
        align-self: center;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-action {
        width: 100%;
        justify-content: center;
    }
}

/* Font Awesome Icons */
.fas {
    font-weight: 900;
}
</style>
@endsection
