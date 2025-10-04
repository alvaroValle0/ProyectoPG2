@extends('layouts.app')

@section('title', 'Nueva Reparación')
@section('mobile-title', 'Nueva Reparación')

@section('content')
<div class="container-fluid">
    <!-- Header Minimalista -->
    <div class="minimal-header mb-5">
        <div class="header-content">
            <div class="header-icon-wrapper">
                <i class="fas fa-tools"></i>
            </div>
            <div class="header-text">
                <h1 class="header-title">Nueva Reparación</h1>
                <p class="header-subtitle">Registra una nueva orden de reparación</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('reparaciones.index') }}" class="btn btn-light btn-minimal">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-minimal alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Formulario Principal -->
        <div class="col-xl-8">
            <form action="{{ route('reparaciones.store') }}" method="POST" id="reparacionForm">
                @csrf

                <!-- Selección de Equipo -->
                <div class="input-card">
                    <div class="card-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="card-content">
                        <label for="equipo_id" class="card-label">
                            Equipo a Reparar <span class="required">*</span>
                        </label>
                        <select class="form-control input-minimal @error('equipo_id') is-invalid @enderror" 
                                id="equipo_id" 
                                name="equipo_id" 
                                required>
                            <option value="">Selecciona un equipo</option>
                            @foreach($equipos as $eq)
                                <option value="{{ $eq->id }}" 
                                        {{ (old('equipo_id', $equipo->id ?? '') == $eq->id) ? 'selected' : '' }}
                                        data-cliente="{{ $eq->cliente_nombre }}"
                                        data-telefono="{{ $eq->cliente_telefono }}"
                                        data-marca="{{ $eq->marca }}"
                                        data-modelo="{{ $eq->modelo }}"
                                        data-serie="{{ $eq->numero_serie }}"
                                        data-tipo="{{ $eq->tipo_equipo }}">
                                    {{ $eq->marca }} {{ $eq->modelo }} - {{ $eq->cliente_nombre }}
                                    @if($eq->numero_serie)
                                        (S/N: {{ $eq->numero_serie }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('equipo_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="card-hint">
                            <i class="fas fa-info-circle"></i>
                            Solo equipos disponibles para reparación
                        </div>
                    </div>
                </div>

                <!-- Técnico Asignado -->
                <div class="input-card">
                    <div class="card-icon">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <div class="card-content">
                        <label for="tecnico_id" class="card-label">
                            Técnico Asignado <span class="required">*</span>
                        </label>
                        <select class="form-control input-minimal @error('tecnico_id') is-invalid @enderror" 
                                id="tecnico_id" 
                                name="tecnico_id" 
                                required>
                            <option value="">Selecciona un técnico</option>
                            @foreach($tecnicos as $tec)
                                <option value="{{ $tec->id }}" {{ old('tecnico_id') == $tec->id ? 'selected' : '' }}>
                                    {{ $tec->nombre_completo }}
                                    @if($tec->especialidad)
                                        - {{ $tec->especialidad }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('tecnico_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Descripción del Problema -->
                <div class="input-card">
                    <div class="card-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="card-content">
                        <label for="descripcion_problema" class="card-label">
                            Descripción del Problema <span class="required">*</span>
                        </label>
                        <textarea class="form-control input-minimal @error('descripcion_problema') is-invalid @enderror" 
                                  id="descripcion_problema" 
                                  name="descripcion_problema" 
                                  rows="4"
                                  required
                                  placeholder="Describe detalladamente el problema reportado por el cliente...">{{ old('descripcion_problema') }}</textarea>
                        @error('descripcion_problema')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Diagnóstico Inicial -->
                <div class="input-card">
                    <div class="card-icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div class="card-content">
                        <label for="diagnostico" class="card-label">
                            Diagnóstico Inicial
                        </label>
                        <textarea class="form-control input-minimal @error('diagnostico') is-invalid @enderror" 
                                  id="diagnostico" 
                                  name="diagnostico" 
                                  rows="4"
                                  placeholder="Evaluación técnica inicial del problema...">{{ old('diagnostico') }}</textarea>
                        @error('diagnostico')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Prioridad y Estado -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-card">
                            <div class="card-icon">
                                <i class="fas fa-flag"></i>
                            </div>
                            <div class="card-content">
                                <label for="prioridad" class="card-label">Prioridad</label>
                                <select class="form-control input-minimal @error('prioridad') is-invalid @enderror" 
                                        id="prioridad" 
                                        name="prioridad">
                                    <option value="baja" {{ old('prioridad', 'media') === 'baja' ? 'selected' : '' }}>
                                        🟢 Baja
                                    </option>
                                    <option value="media" {{ old('prioridad', 'media') === 'media' ? 'selected' : '' }}>
                                        🟡 Media
                                    </option>
                                    <option value="alta" {{ old('prioridad') === 'alta' ? 'selected' : '' }}>
                                        🟠 Alta
                                    </option>
                                    <option value="urgente" {{ old('prioridad') === 'urgente' ? 'selected' : '' }}>
                                        🔴 Urgente
                                    </option>
                                </select>
                                @error('prioridad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-card">
                            <div class="card-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="card-content">
                                <label for="estado" class="card-label">Estado Inicial</label>
                                <select class="form-control input-minimal @error('estado') is-invalid @enderror" 
                                        id="estado" 
                                        name="estado">
                                    <option value="pendiente" {{ old('estado', 'pendiente') === 'pendiente' ? 'selected' : '' }}>
                                        ⏳ Pendiente
                                    </option>
                                    <option value="en_proceso" {{ old('estado') === 'en_proceso' ? 'selected' : '' }}>
                                        🔧 En Proceso
                                    </option>
                                    <option value="esperando_repuestos" {{ old('estado') === 'esperando_repuestos' ? 'selected' : '' }}>
                                        📦 Esperando Repuestos
                                    </option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fechas -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-card">
                            <div class="card-icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="card-content">
                                <label for="fecha_inicio" class="card-label">Fecha de Inicio</label>
                                <input type="datetime-local" 
                                       class="form-control input-minimal @error('fecha_inicio') is-invalid @enderror" 
                                       id="fecha_inicio" 
                                       name="fecha_inicio" 
                                       value="{{ old('fecha_inicio', now()->format('Y-m-d\TH:i')) }}">
                                @error('fecha_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-card">
                            <div class="card-icon">
                                <i class="fas fa-flag-checkered"></i>
                            </div>
                            <div class="card-content">
                                <label for="fecha_estimada" class="card-label">Fecha Estimada de Finalización</label>
                                <input type="datetime-local" 
                                       class="form-control input-minimal @error('fecha_estimada') is-invalid @enderror" 
                                       id="fecha_estimada" 
                                       name="fecha_estimada" 
                                       value="{{ old('fecha_estimada') }}">
                                @error('fecha_estimada')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="card-hint">
                                    <i class="fas fa-info-circle"></i>
                                    Opcional - Estimación de cuándo estará lista
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Costo y Autorización -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-card">
                            <div class="card-icon">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div class="card-content">
                                <label for="costo" class="card-label">Costo Estimado (Q)</label>
                                <input type="number" 
                                       class="form-control input-minimal @error('costo') is-invalid @enderror" 
                                       id="costo" 
                                       name="costo" 
                                       step="0.01" 
                                       min="0"
                                       value="{{ old('costo') }}"
                                       placeholder="0.00">
                                @error('costo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-card">
                            <div class="card-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <div class="card-content">
                                <label class="card-label">Autorización del Cliente</label>
                                <div class="checkbox-wrapper">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="cliente_autoriza" 
                                           name="cliente_autoriza" 
                                           value="1"
                                           {{ old('cliente_autoriza') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cliente_autoriza">
                                        El cliente autoriza la reparación con el costo estimado
                                    </label>
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
                        <label for="observaciones" class="card-label">Observaciones Adicionales</label>
                        <textarea class="form-control input-minimal @error('observaciones') is-invalid @enderror" 
                                  id="observaciones" 
                                  name="observaciones" 
                                  rows="3"
                                  placeholder="Cualquier información adicional relevante...">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="action-section">
                    <div class="action-info">
                        <i class="fas fa-info-circle"></i>
                        Los campos marcados con <span class="required">*</span> son obligatorios
                    </div>
                    <div class="action-buttons">
                        <a href="{{ route('reparaciones.index') }}" class="btn btn-outline-secondary btn-action">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary btn-action">
                            <i class="fas fa-wrench"></i>
                            Crear Reparación
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Panel Lateral -->
        <div class="col-xl-4">
            <!-- Información del Equipo -->
            <div class="info-panel" id="infoEquipo" style="display: none;">
                <div class="panel-header">
                    <div class="panel-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h6 class="panel-title">Información del Equipo</h6>
                </div>
                <div class="panel-body">
                    <div class="info-row">
                        <span class="info-label">Cliente:</span>
                        <span class="info-value" id="infoCliente">-</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Teléfono:</span>
                        <span class="info-value" id="infoTelefono">-</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Marca:</span>
                        <span class="info-value" id="infoMarca">-</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Modelo:</span>
                        <span class="info-value" id="infoModelo">-</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Tipo:</span>
                        <span class="info-value" id="infoTipo">-</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Número de Serie:</span>
                        <span class="info-value font-monospace" id="infoSerie">-</span>
                    </div>
                </div>
            </div>

            <!-- Guía Rápida -->
            <div class="guide-panel">
                <div class="panel-header">
                    <div class="panel-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h6 class="panel-title">Guía Rápida</h6>
                </div>
                <div class="panel-body">
                    <div class="guide-section">
                        <h6 class="guide-title">Niveles de Prioridad</h6>
                        <div class="priority-list">
                            <div class="priority-item">
                                <div class="priority-indicator priority-low"></div>
                                <span>Baja - Sin urgencia</span>
                            </div>
                            <div class="priority-item">
                                <div class="priority-indicator priority-medium"></div>
                                <span>Media - Estándar</span>
                            </div>
                            <div class="priority-item">
                                <div class="priority-indicator priority-high"></div>
                                <span>Alta - Importante</span>
                            </div>
                            <div class="priority-item">
                                <div class="priority-indicator priority-urgent"></div>
                                <span>Urgente - Crítico</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="guide-tip">
                        <i class="fas fa-lightbulb"></i>
                        <strong>Tip:</strong> Selecciona el equipo primero para ver su información y poder describir mejor el problema.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const equipoSelect = document.getElementById('equipo_id');
    const infoPanel = document.getElementById('infoEquipo');
    
    // Actualizar información cuando se selecciona un equipo
    equipoSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (this.value) {
            // Mostrar panel de información con animación
            infoPanel.style.display = 'block';
            infoPanel.classList.add('slide-in');
            
            // Llenar información
            document.getElementById('infoCliente').textContent = selectedOption.dataset.cliente || 'N/A';
            document.getElementById('infoTelefono').textContent = selectedOption.dataset.telefono || 'N/A';
            document.getElementById('infoMarca').textContent = selectedOption.dataset.marca || 'N/A';
            document.getElementById('infoModelo').textContent = selectedOption.dataset.modelo || 'N/A';
            document.getElementById('infoTipo').textContent = selectedOption.dataset.tipo || 'N/A';
            document.getElementById('infoSerie').textContent = selectedOption.dataset.serie || 'N/A';
        } else {
            // Ocultar panel
            infoPanel.style.display = 'none';
            infoPanel.classList.remove('slide-in');
        }
    });
    
    // Si hay un equipo preseleccionado, activar la información
    if (equipoSelect.value) {
        equipoSelect.dispatchEvent(new Event('change'));
    }
    
    // Validación del formulario
    document.getElementById('reparacionForm').addEventListener('submit', function(e) {
        const equipoId = equipoSelect.value;
        const tecnicoId = document.getElementById('tecnico_id').value;
        const descripcion = document.getElementById('descripcion_problema').value.trim();
        
        if (!equipoId) {
            e.preventDefault();
            showValidationError('Por favor, selecciona un equipo.', equipoSelect);
            return false;
        }
        
        if (!tecnicoId) {
            e.preventDefault();
            showValidationError('Por favor, selecciona un técnico.', document.getElementById('tecnico_id'));
            return false;
        }
        
        if (!descripcion) {
            e.preventDefault();
            showValidationError('Por favor, describe el problema.', document.getElementById('descripcion_problema'));
            return false;
        }
        
        // Deshabilitar botón para evitar doble envío
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creando...';
        submitBtn.disabled = true;
        
        // Re-habilitar el botón después de 5 segundos por si hay error
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 5000);
    });

    // Auto-establecer fecha estimada (3 días después del inicio)
    document.getElementById('fecha_inicio').addEventListener('change', function() {
        const fechaInicio = new Date(this.value);
        if (fechaInicio) {
            const fechaEstimada = new Date(fechaInicio);
            fechaEstimada.setDate(fechaEstimada.getDate() + 3);
            
            const fechaEstimadaInput = document.getElementById('fecha_estimada');
            if (!fechaEstimadaInput.value) {
                fechaEstimadaInput.value = fechaEstimada.toISOString().slice(0, 16);
            }
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

/* Checkbox Wrapper */
.checkbox-wrapper {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--lighter-color);
    border-radius: var(--radius-sm);
    border: 1px solid var(--border-color);
}

.checkbox-wrapper .form-check-input {
    margin-top: 0.25rem;
    transform: scale(1.2);
}

.checkbox-wrapper .form-check-label {
    margin: 0;
    line-height: 1.5;
    color: var(--text-primary);
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

/* Guide Section */
.guide-section {
    margin-bottom: 1.5rem;
}

.guide-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.priority-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.priority-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem;
    background: var(--lighter-color);
    border-radius: var(--radius-sm);
}

.priority-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.priority-low { background: var(--success-color); }
.priority-medium { background: var(--warning-color); }
.priority-high { background: var(--info-color); }
.priority-urgent { background: var(--danger-color); }

.priority-item span {
    font-size: 0.875rem;
    color: var(--text-primary);
}

.guide-tip {
    background: rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(99, 102, 241, 0.2);
    border-radius: var(--radius-sm);
    padding: 1rem;
    color: var(--primary-color);
    font-size: 0.875rem;
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
}

/* Animations */
.slide-in {
    animation: slideIn 0.4s ease-out;
}

@keyframes slideIn {
    from { 
        opacity: 0; 
        transform: translateY(20px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
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

/* Alert Minimal */
.alert-minimal {
    border-radius: var(--radius-sm);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
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