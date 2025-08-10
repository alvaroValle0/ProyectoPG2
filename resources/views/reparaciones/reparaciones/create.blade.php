@extends('layouts.app')

@section('title', 'Nueva Reparación')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-plus-circle text-success me-2"></i>
                Registrar Nueva Reparación
            </h1>
            <p class="text-muted mb-0">Crea una nueva orden de reparación para un equipo</p>
        </div>
        <a href="{{ route('reparaciones.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver a Reparaciones
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Formulario Principal -->
        <div class="col-xl-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Información de la Reparación
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('reparaciones.store') }}" method="POST" id="reparacionForm">
                        @csrf

                        <!-- Selección de Equipo -->
                        <div class="mb-4">
                            <label for="equipo_id" class="form-label">
                                Equipo a Reparar <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('equipo_id') is-invalid @enderror" 
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
                            <small class="text-muted">Solo se muestran equipos disponibles para reparación</small>
                        </div>

                        <!-- Técnico Asignado -->
                        <div class="mb-4">
                            <label for="tecnico_id" class="form-label">
                                Técnico Asignado <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('tecnico_id') is-invalid @enderror" 
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

                        <!-- Descripción del Problema -->
                        <div class="mb-4">
                            <label for="descripcion_problema" class="form-label">
                                Descripción del Problema <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('descripcion_problema') is-invalid @enderror" 
                                      id="descripcion_problema" 
                                      name="descripcion_problema" 
                                      rows="4"
                                      required
                                      placeholder="Describe detalladamente el problema reportado por el cliente...">{{ old('descripcion_problema') }}</textarea>
                            @error('descripcion_problema')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Diagnóstico Inicial -->
                        <div class="mb-4">
                            <label for="diagnostico" class="form-label">
                                Diagnóstico Inicial
                            </label>
                            <textarea class="form-control @error('diagnostico') is-invalid @enderror" 
                                      id="diagnostico" 
                                      name="diagnostico" 
                                      rows="4"
                                      placeholder="Evaluación técnica inicial del problema...">{{ old('diagnostico') }}</textarea>
                            @error('diagnostico')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Prioridad y Estado -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="prioridad" class="form-label">
                                    Prioridad
                                </label>
                                <select class="form-select @error('prioridad') is-invalid @enderror" 
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

                            <div class="col-md-6">
                                <label for="estado" class="form-label">
                                    Estado Inicial
                                </label>
                                <select class="form-select @error('estado') is-invalid @enderror" 
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

                        <!-- Fechas -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="fecha_inicio" class="form-label">
                                    Fecha de Inicio
                                </label>
                                <input type="datetime-local" 
                                       class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                       id="fecha_inicio" 
                                       name="fecha_inicio" 
                                       value="{{ old('fecha_inicio', now()->format('Y-m-d\TH:i')) }}">
                                @error('fecha_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="fecha_estimada" class="form-label">
                                    Fecha Estimada de Finalización
                                </label>
                                <input type="datetime-local" 
                                       class="form-control @error('fecha_estimada') is-invalid @enderror" 
                                       id="fecha_estimada" 
                                       name="fecha_estimada" 
                                       value="{{ old('fecha_estimada') }}">
                                @error('fecha_estimada')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Opcional - Estimación de cuándo estará lista</small>
                            </div>
                        </div>

                        <!-- Costo Estimado -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="costo" class="form-label">
                                    Costo Estimado (Q)
                                </label>
                                <input type="number" 
                                       class="form-control @error('costo') is-invalid @enderror" 
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

                            <div class="col-md-6">
                                <label class="form-label">Autorización del Cliente</label>
                                <div class="form-check">
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

                        <!-- Observaciones -->
                        <div class="mb-4">
                            <label for="observaciones" class="form-label">
                                Observaciones Adicionales
                            </label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                      id="observaciones" 
                                      name="observaciones" 
                                      rows="3"
                                      placeholder="Cualquier información adicional relevante...">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('reparaciones.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-wrench me-2"></i>Crear Reparación
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Panel Lateral - Información del Equipo -->
        <div class="col-xl-4">
            <div class="card shadow" id="infoEquipo" style="display: none;">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-laptop me-2"></i>
                        Información del Equipo
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Cliente:</label>
                        <h6 class="fw-bold" id="infoCliente">-</h6>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Teléfono:</label>
                        <p class="mb-0" id="infoTelefono">-</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Marca:</label>
                        <p class="mb-0" id="infoMarca">-</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Modelo:</label>
                        <p class="mb-0" id="infoModelo">-</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Tipo:</label>
                        <p class="mb-0" id="infoTipo">-</p>
                    </div>
                    
                    <div class="mb-0">
                        <label class="form-label text-muted mb-1">Número de Serie:</label>
                        <p class="mb-0 font-monospace" id="infoSerie">-</p>
                    </div>
                </div>
            </div>

            <!-- Guía Rápida -->
            <div class="card shadow mt-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0 text-dark">
                        <i class="fas fa-question-circle me-2"></i>
                        Guía Rápida
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Prioridades:</strong>
                        <ul class="small mt-2 mb-0">
                            <li><span class="text-success">●</span> <strong>Baja:</strong> Sin urgencia</li>
                            <li><span class="text-warning">●</span> <strong>Media:</strong> Estándar</li>
                            <li><span class="text-primary">●</span> <strong>Alta:</strong> Importante</li>
                            <li><span class="text-danger">●</span> <strong>Urgente:</strong> Crítico</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-info small">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>Tip:</strong> Selecciona el equipo primero para ver su información y poder describirr mejor el problema.
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
            // Mostrar panel de información
            infoPanel.style.display = 'block';
            
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
            alert('Por favor, selecciona un equipo.');
            equipoSelect.focus();
            return false;
        }
        
        if (!tecnicoId) {
            e.preventDefault();
            alert('Por favor, selecciona un técnico.');
            document.getElementById('tecnico_id').focus();
            return false;
        }
        
        if (!descripcion) {
            e.preventDefault();
            alert('Por favor, describe el problema.');
            document.getElementById('descripcion_problema').focus();
            return false;
        }
        
        // Deshabilitar botón para evitar doble envío
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creando...';
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
});
</script>
@endsection

@section('styles')
<style>
.form-label {
    font-weight: 600;
    color: #495057;
}

.btn-lg {
    padding: 0.75rem 2rem;
    font-size: 1.1rem;
}

.gap-3 {
    gap: 1rem !important;
}

#infoEquipo {
    position: sticky;
    top: 2rem;
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    border-bottom: none;
}

.form-control:focus,
.form-select:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

.alert-info {
    background-color: rgba(13, 202, 240, 0.1);
    border-color: rgba(13, 202, 240, 0.2);
    color: #055160;
}

.text-muted {
    color: #6c757d !important;
}

.form-check-input {
    transform: scale(1.2);
}

.form-check-label {
    margin-left: 0.5rem;
}

@media (max-width: 1200px) {
    #infoEquipo {
        position: static;
    }
}
</style>
@endsection