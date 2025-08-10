@extends('layouts.app')

@section('title', 'Editar Reparación #' . $reparacion->id)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-edit text-warning me-2"></i>
                Editar Reparación #{{ $reparacion->id }}
            </h1>
            <p class="text-muted mb-0">Modifica la información de la reparación</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('reparaciones.show', $reparacion) }}" class="btn btn-outline-info">
                <i class="fas fa-eye me-2"></i>Ver Detalles
            </a>
            <a href="{{ route('reparaciones.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver a Reparaciones
            </a>
        </div>
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
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Editar Información de la Reparación
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('reparaciones.update', $reparacion) }}" method="POST" id="reparacionForm">
                        @csrf
                        @method('PUT')

                        <!-- Información del Equipo (Solo lectura) -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-laptop me-2"></i>Información del Equipo
                            </h6>
                            <div class="bg-light p-3 rounded">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Número de Serie:</strong> {{ $reparacion->equipo->numero_serie }}</p>
                                        <p class="mb-2"><strong>Marca/Modelo:</strong> {{ $reparacion->equipo->marca }} {{ $reparacion->equipo->modelo }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Cliente:</strong> {{ $reparacion->equipo->nombre_cliente }}</p>
                                        <p class="mb-2"><strong>Tipo:</strong> {{ $reparacion->equipo->tipo_equipo }}</p>
                                    </div>
                                </div>
                            </div>
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
                                <option value="">Seleccione un técnico</option>
                                @foreach($tecnicos as $tecnico)
                                    <option value="{{ $tecnico->id }}" 
                                            {{ old('tecnico_id', $reparacion->tecnico_id) == $tecnico->id ? 'selected' : '' }}>
                                        {{ $tecnico->nombre_completo }} 
                                        @if($tecnico->especialidad)
                                            - {{ $tecnico->especialidad }}
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
                                      rows="3" 
                                      required 
                                      placeholder="Describe el problema reportado por el cliente">{{ old('descripcion_problema', $reparacion->descripcion_problema) }}</textarea>
                            @error('descripcion_problema')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Diagnóstico -->
                        <div class="mb-4">
                            <label for="diagnostico" class="form-label">
                                Diagnóstico Técnico
                            </label>
                            <textarea class="form-control @error('diagnostico') is-invalid @enderror" 
                                      id="diagnostico" 
                                      name="diagnostico" 
                                      rows="3" 
                                      placeholder="Diagnóstico técnico del problema">{{ old('diagnostico', $reparacion->diagnostico) }}</textarea>
                            @error('diagnostico')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Solución -->
                        <div class="mb-4">
                            <label for="solucion" class="form-label">
                                Solución Aplicada
                            </label>
                            <textarea class="form-control @error('solucion') is-invalid @enderror" 
                                      id="solucion" 
                                      name="solucion" 
                                      rows="3" 
                                      placeholder="Describe la solución aplicada">{{ old('solucion', $reparacion->solucion) }}</textarea>
                            @error('solucion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Estado y Fechas -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="estado" class="form-label">
                                    Estado <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('estado') is-invalid @enderror" 
                                        id="estado" 
                                        name="estado" 
                                        required>
                                    <option value="pendiente" {{ old('estado', $reparacion->estado) == 'pendiente' ? 'selected' : '' }}>
                                        Pendiente
                                    </option>
                                    <option value="en_proceso" {{ old('estado', $reparacion->estado) == 'en_proceso' ? 'selected' : '' }}>
                                        En Proceso
                                    </option>
                                    <option value="completada" {{ old('estado', $reparacion->estado) == 'completada' ? 'selected' : '' }}>
                                        Completada
                                    </option>
                                    <option value="cancelada" {{ old('estado', $reparacion->estado) == 'cancelada' ? 'selected' : '' }}>
                                        Cancelada
                                    </option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                                <input type="date" 
                                       class="form-control" 
                                       value="{{ $reparacion->fecha_inicio->format('Y-m-d') }}" 
                                       readonly>
                                <small class="text-muted">Solo lectura</small>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="fecha_fin" class="form-label">Fecha de Finalización</label>
                                <input type="date" 
                                       class="form-control @error('fecha_fin') is-invalid @enderror" 
                                       id="fecha_fin" 
                                       name="fecha_fin" 
                                       value="{{ old('fecha_fin', $reparacion->fecha_fin?->format('Y-m-d')) }}"
                                       min="{{ $reparacion->fecha_inicio->format('Y-m-d') }}">
                                @error('fecha_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tiempo y Costo -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="tiempo_estimado_horas" class="form-label">
                                    Tiempo Estimado (horas)
                                </label>
                                <input type="number" 
                                       class="form-control @error('tiempo_estimado_horas') is-invalid @enderror" 
                                       id="tiempo_estimado_horas" 
                                       name="tiempo_estimado_horas" 
                                       value="{{ old('tiempo_estimado_horas', $reparacion->tiempo_estimado_horas) }}"
                                       min="1" 
                                       placeholder="Ej: 8">
                                @error('tiempo_estimado_horas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="tiempo_real_horas" class="form-label">
                                    Tiempo Real (horas)
                                </label>
                                <input type="number" 
                                       class="form-control @error('tiempo_real_horas') is-invalid @enderror" 
                                       id="tiempo_real_horas" 
                                       name="tiempo_real_horas" 
                                       value="{{ old('tiempo_real_horas', $reparacion->tiempo_real_horas) }}"
                                       min="1" 
                                       placeholder="Ej: 6">
                                @error('tiempo_real_horas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="costo" class="form-label">
                                    Costo Total
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" 
                                           class="form-control @error('costo') is-invalid @enderror" 
                                           id="costo" 
                                           name="costo" 
                                           value="{{ old('costo', $reparacion->costo) }}"
                                           step="0.01" 
                                           min="0" 
                                           placeholder="0.00">
                                </div>
                                @error('costo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Repuestos Utilizados -->
                        <div class="mb-4">
                            <label class="form-label">Repuestos Utilizados</label>
                            <div id="repuestosContainer">
                                @if($reparacion->repuestos_utilizados && count($reparacion->repuestos_utilizados) > 0)
                                    @foreach($reparacion->repuestos_utilizados as $index => $repuesto)
                                    <div class="row mb-2 repuesto-row">
                                        <div class="col-md-5">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="repuestos[{{ $index }}][nombre]" 
                                                   value="{{ $repuesto['nombre'] ?? '' }}"
                                                   placeholder="Nombre del repuesto">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" 
                                                   class="form-control" 
                                                   name="repuestos[{{ $index }}][cantidad]" 
                                                   value="{{ $repuesto['cantidad'] ?? 1 }}"
                                                   min="1" 
                                                   placeholder="Cant.">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" 
                                                   class="form-control" 
                                                   name="repuestos[{{ $index }}][precio]" 
                                                   value="{{ $repuesto['precio'] ?? 0 }}"
                                                   step="0.01" 
                                                   min="0" 
                                                   placeholder="Precio">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="eliminarRepuesto(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="row mb-2 repuesto-row">
                                        <div class="col-md-5">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="repuestos[0][nombre]" 
                                                   placeholder="Nombre del repuesto">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" 
                                                   class="form-control" 
                                                   name="repuestos[0][cantidad]" 
                                                   value="1" 
                                                   min="1" 
                                                   placeholder="Cant.">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" 
                                                   class="form-control" 
                                                   name="repuestos[0][precio]" 
                                                   value="0" 
                                                   step="0.01" 
                                                   min="0" 
                                                   placeholder="Precio">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="eliminarRepuesto(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline-success btn-sm mt-2" onclick="agregarRepuesto()">
                                <i class="fas fa-plus me-2"></i>Agregar Repuesto
                            </button>
                        </div>

                        <!-- Observaciones -->
                        <div class="mb-4">
                            <label for="observaciones" class="form-label">Observaciones Adicionales</label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                      id="observaciones" 
                                      name="observaciones" 
                                      rows="3" 
                                      placeholder="Observaciones adicionales sobre la reparación">{{ old('observaciones', $reparacion->observaciones) }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('reparaciones.show', $reparacion) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                                @if(in_array($reparacion->estado, ['pendiente', 'en_proceso']))
                                <button type="button" class="btn btn-outline-danger ms-2" onclick="confirmarCancelacion()">
                                    <i class="fas fa-ban me-2"></i>Cancelar Reparación
                                </button>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-save me-2"></i>Actualizar Reparación
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Panel Lateral -->
        <div class="col-xl-4">
            <!-- Información del Estado -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Estado Actual
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <span class="badge bg-{{ $reparacion->estado_color }} fs-6 mb-3">
                            {{ ucfirst($reparacion->estado) }}
                        </span>
                        
                        @if($reparacion->progreso_porcentaje)
                        <div class="progress mb-3">
                            <div class="progress-bar bg-{{ $reparacion->estado_color }}" 
                                 style="width: {{ $reparacion->progreso_porcentaje }}%">
                                {{ $reparacion->progreso_porcentaje }}%
                            </div>
                        </div>
                        @endif
                        
                        <p class="text-muted mb-0">
                            <strong>Creada:</strong> {{ $reparacion->created_at->format('d/m/Y H:i') }}<br>
                            <strong>Actualizada:</strong> {{ $reparacion->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Acciones Rápidas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('reparaciones.show', $reparacion) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-2"></i>Ver Detalles
                        </a>
                        @if($reparacion->estado == 'completada')
                        <a href="{{ route('reparaciones.ticket', $reparacion) }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-print me-2"></i>Generar Ticket
                        </a>
                        @endif
                        <a href="{{ route('reparaciones.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list me-2"></i>Todas las Reparaciones
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para cancelar reparación -->
<div class="modal fade" id="cancelarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Cancelar Reparación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea cancelar esta reparación?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Esta acción cambiará el estado a "Cancelada" y no se podrá revertir.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, mantener</button>
                <button type="button" class="btn btn-danger" onclick="cancelarReparacion()">Sí, cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Contador para repuestos
let repuestoIndex = {{ $reparacion->repuestos_utilizados ? count($reparacion->repuestos_utilizados) : 1 }};

// Agregar nuevo repuesto
function agregarRepuesto() {
    const container = document.getElementById('repuestosContainer');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 repuesto-row';
    newRow.innerHTML = `
        <div class="col-md-5">
            <input type="text" 
                   class="form-control" 
                   name="repuestos[${repuestoIndex}][nombre]" 
                   placeholder="Nombre del repuesto">
        </div>
        <div class="col-md-2">
            <input type="number" 
                   class="form-control" 
                   name="repuestos[${repuestoIndex}][cantidad]" 
                   value="1" 
                   min="1" 
                   placeholder="Cant.">
        </div>
        <div class="col-md-3">
            <input type="number" 
                   class="form-control" 
                   name="repuestos[${repuestoIndex}][precio]" 
                   value="0" 
                   step="0.01" 
                   min="0" 
                   placeholder="Precio">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="eliminarRepuesto(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
    repuestoIndex++;
}

// Eliminar repuesto
function eliminarRepuesto(button) {
    button.closest('.repuesto-row').remove();
}

// Confirmar cancelación
function confirmarCancelacion() {
    const modal = new bootstrap.Modal(document.getElementById('cancelarModal'));
    modal.show();
}

// Cancelar reparación
function cancelarReparacion() {
    document.getElementById('estado').value = 'cancelada';
    document.getElementById('fecha_fin').value = new Date().toISOString().split('T')[0];
    bootstrap.Modal.getInstance(document.getElementById('cancelarModal')).hide();
    document.getElementById('reparacionForm').submit();
}

// Validación del formulario
document.getElementById('reparacionForm').addEventListener('submit', function(e) {
    const estado = document.getElementById('estado').value;
    const fechaFin = document.getElementById('fecha_fin').value;
    
    // Si el estado es completada, la fecha fin es obligatoria
    if (estado === 'completada' && !fechaFin) {
        e.preventDefault();
        alert('La fecha de finalización es obligatoria cuando el estado es "Completada".');
        document.getElementById('fecha_fin').focus();
        return;
    }
    
    // Confirmar actualización
    if (!confirm('¿Está seguro de que desea actualizar esta reparación?')) {
        e.preventDefault();
    }
});

// Auto-calcular costo total de repuestos
document.addEventListener('input', function(e) {
    if (e.target.matches('input[name*="[precio]"], input[name*="[cantidad]"]')) {
        calcularCostoRepuestos();
    }
});

function calcularCostoRepuestos() {
    let costoTotal = 0;
    const repuestos = document.querySelectorAll('.repuesto-row');
    
    repuestos.forEach(function(row) {
        const cantidad = row.querySelector('input[name*="[cantidad]"]').value || 0;
        const precio = row.querySelector('input[name*="[precio]"]').value || 0;
        costoTotal += parseInt(cantidad) * parseFloat(precio);
    });
    
    // Solo sugerir el costo si el campo está vacío
    const costoField = document.getElementById('costo');
    if (!costoField.value || costoField.value == 0) {
        costoField.value = costoTotal.toFixed(2);
    }
}
</script>
@endsection

@section('styles')
<style>
.repuesto-row {
    background-color: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 10px;
}

.progress {
    height: 1.5rem;
}

.badge {
    padding: 0.5rem 1rem;
}

@media (max-width: 768px) {
    .repuesto-row .col-md-5,
    .repuesto-row .col-md-2,
    .repuesto-row .col-md-3 {
        margin-bottom: 10px;
    }
}
</style>
@endsection
