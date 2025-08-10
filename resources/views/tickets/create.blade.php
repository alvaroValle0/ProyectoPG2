@extends('layouts.app')

@section('title', 'Nuevo Ticket')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-plus-circle text-success me-2"></i>
                Generar Nuevo Ticket
            </h1>
            <p class="text-muted mb-0">Crea un ticket de servicio para una reparación</p>
        </div>
        <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver a Tickets
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
                        Información del Ticket
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('tickets.store') }}" method="POST" id="ticketForm">
                        @csrf

                        <!-- Selección de Reparación -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="reparacion_id" class="form-label">
                                    Reparación <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('reparacion_id') is-invalid @enderror" 
                                        id="reparacion_id" 
                                        name="reparacion_id" 
                                        required>
                                    <option value="">Selecciona una reparación</option>
                                    @foreach($reparaciones as $rep)
                                        <option value="{{ $rep->id }}" 
                                                {{ (old('reparacion_id', $reparacion->id ?? '') == $rep->id) ? 'selected' : '' }}
                                                data-cliente="{{ $rep->equipo->cliente->nombre_completo ?? 'N/A' }}"
                                                data-equipo="{{ $rep->equipo->marca }} {{ $rep->equipo->modelo }}"
                                                data-descripcion="{{ $rep->descripcion_problema }}"
                                                data-diagnostico="{{ $rep->diagnostico }}"
                                                data-costo="{{ $rep->costo }}">
                                            #{{ $rep->id }} - {{ $rep->equipo->cliente->nombre_completo ?? 'Cliente N/A' }} 
                                            ({{ $rep->equipo->marca }} {{ $rep->equipo->modelo }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('reparacion_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Solo se muestran reparaciones sin tickets generados</small>
                            </div>

                            <div class="col-md-6">
                                <label for="tipo_ticket" class="form-label">
                                    Tipo de Ticket <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('tipo_ticket') is-invalid @enderror" 
                                        id="tipo_ticket" 
                                        name="tipo_ticket" 
                                        required>
                                    <option value="">Selecciona el tipo</option>
                                    <option value="ingreso" {{ old('tipo_ticket') === 'ingreso' ? 'selected' : '' }}>
                                        📥 Ticket de Ingreso
                                    </option>
                                    <option value="servicio" {{ old('tipo_ticket', 'servicio') === 'servicio' ? 'selected' : '' }}>
                                        🔧 Ticket de Servicio
                                    </option>
                                    <option value="entrega" {{ old('tipo_ticket') === 'entrega' ? 'selected' : '' }}>
                                        📤 Ticket de Entrega
                                    </option>
                                </select>
                                @error('tipo_ticket')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Descripción del Servicio -->
                        <div class="mb-4">
                            <label for="descripcion_servicio" class="form-label">
                                Descripción del Servicio
                            </label>
                            <textarea class="form-control @error('descripcion_servicio') is-invalid @enderror" 
                                      id="descripcion_servicio" 
                                      name="descripcion_servicio" 
                                      rows="4"
                                      placeholder="Describe detalladamente el servicio realizado...">{{ old('descripcion_servicio') }}</textarea>
                            @error('descripcion_servicio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Observaciones -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="observaciones_tecnico" class="form-label">
                                    Observaciones del Técnico
                                </label>
                                <textarea class="form-control @error('observaciones_tecnico') is-invalid @enderror" 
                                          id="observaciones_tecnico" 
                                          name="observaciones_tecnico" 
                                          rows="4"
                                          placeholder="Observaciones técnicas, recomendaciones...">{{ old('observaciones_tecnico') }}</textarea>
                                @error('observaciones_tecnico')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="observaciones_cliente" class="form-label">
                                    Observaciones del Cliente
                                </label>
                                <textarea class="form-control @error('observaciones_cliente') is-invalid @enderror" 
                                          id="observaciones_cliente" 
                                          name="observaciones_cliente" 
                                          rows="4"
                                          placeholder="Comentarios o solicitudes especiales del cliente...">{{ old('observaciones_cliente') }}</textarea>
                                @error('observaciones_cliente')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Costos -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="costo_servicio" class="form-label">
                                    Costo de Servicio (Q)
                                </label>
                                <input type="number" 
                                       class="form-control @error('costo_servicio') is-invalid @enderror" 
                                       id="costo_servicio" 
                                       name="costo_servicio" 
                                       step="0.01" 
                                       min="0"
                                       value="{{ old('costo_servicio') }}"
                                       placeholder="0.00">
                                @error('costo_servicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="costo_repuestos" class="form-label">
                                    Costo de Repuestos (Q)
                                </label>
                                <input type="number" 
                                       class="form-control @error('costo_repuestos') is-invalid @enderror" 
                                       id="costo_repuestos" 
                                       name="costo_repuestos" 
                                       step="0.01" 
                                       min="0"
                                       value="{{ old('costo_repuestos') }}"
                                       placeholder="0.00">
                                @error('costo_repuestos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Total Calculado</label>
                                <div class="input-group">
                                    <span class="input-group-text">Q</span>
                                    <input type="text" 
                                           class="form-control bg-light" 
                                           id="total_calculado" 
                                           readonly 
                                           value="0.00">
                                </div>
                                <small class="text-muted">Se calcula automáticamente</small>
                            </div>
                        </div>

                        <!-- Condiciones y Garantía -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label for="condiciones_servicio" class="form-label">
                                    Condiciones del Servicio
                                </label>
                                <textarea class="form-control @error('condiciones_servicio') is-invalid @enderror" 
                                          id="condiciones_servicio" 
                                          name="condiciones_servicio" 
                                          rows="3"
                                          placeholder="Condiciones especiales, limitaciones, requisitos...">{{ old('condiciones_servicio', 'La garantía no cubre daños por mal uso, accidentes, líquidos o modificaciones no autorizadas.') }}</textarea>
                                @error('condiciones_servicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="tiempo_garantia_dias" class="form-label">
                                    Tiempo de Garantía (días)
                                </label>
                                <input type="number" 
                                       class="form-control @error('tiempo_garantia_dias') is-invalid @enderror" 
                                       id="tiempo_garantia_dias" 
                                       name="tiempo_garantia_dias" 
                                       min="0" 
                                       max="365"
                                       value="{{ old('tiempo_garantia_dias', 30) }}">
                                @error('tiempo_garantia_dias')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Observaciones Generales -->
                        <div class="mb-4">
                            <label for="observaciones_generales" class="form-label">
                                Observaciones Generales
                            </label>
                            <textarea class="form-control @error('observaciones_generales') is-invalid @enderror" 
                                      id="observaciones_generales" 
                                      name="observaciones_generales" 
                                      rows="3"
                                      placeholder="Cualquier información adicional relevante...">{{ old('observaciones_generales') }}</textarea>
                            @error('observaciones_generales')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-ticket-alt me-2"></i>Generar Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Panel Lateral - Información de la Reparación -->
        <div class="col-xl-4">
            <div class="card shadow" id="infoReparacion" style="display: none;">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Información de la Reparación
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Cliente:</label>
                        <h6 class="fw-bold" id="infoCliente">-</h6>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Equipo:</label>
                        <p class="mb-0" id="infoEquipo">-</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Problema Reportado:</label>
                        <p class="mb-0" id="infoDescripcion">-</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Diagnóstico:</label>
                        <p class="mb-0" id="infoDiagnostico">-</p>
                    </div>
                    
                    <div class="mb-0">
                        <label class="form-label text-muted mb-1">Costo Estimado:</label>
                        <h6 class="fw-bold text-success" id="infoCosto">-</h6>
                    </div>
                </div>
            </div>

            <!-- Ayuda -->
            <div class="card shadow mt-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0 text-dark">
                        <i class="fas fa-question-circle me-2"></i>
                        Ayuda
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Tipos de Ticket:</strong>
                        <ul class="small mt-2 mb-0">
                            <li><strong>Ingreso:</strong> Para equipos que ingresan al taller</li>
                            <li><strong>Servicio:</strong> Para equipos ya reparados</li>
                            <li><strong>Entrega:</strong> Para la entrega del equipo reparado</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-info small">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>Tip:</strong> Selecciona primero la reparación para auto-completar algunos campos con la información existente.
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
    const reparacionSelect = document.getElementById('reparacion_id');
    const infoPanel = document.getElementById('infoReparacion');
    
    // Campos de costos
    const costoServicio = document.getElementById('costo_servicio');
    const costoRepuestos = document.getElementById('costo_repuestos');
    const totalCalculado = document.getElementById('total_calculado');
    
    // Campos auto-completables
    const descripcionServicio = document.getElementById('descripcion_servicio');
    const observacionesTecnico = document.getElementById('observaciones_tecnico');
    
    // Actualizar información cuando se selecciona una reparación
    reparacionSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (this.value) {
            // Mostrar panel de información
            infoPanel.style.display = 'block';
            
            // Llenar información
            document.getElementById('infoCliente').textContent = selectedOption.dataset.cliente || 'N/A';
            document.getElementById('infoEquipo').textContent = selectedOption.dataset.equipo || 'N/A';
            document.getElementById('infoDescripcion').textContent = selectedOption.dataset.descripcion || 'Sin descripción';
            document.getElementById('infoDiagnostico').textContent = selectedOption.dataset.diagnostico || 'Sin diagnóstico';
            
            const costo = selectedOption.dataset.costo;
            document.getElementById('infoCosto').textContent = costo ? `Q${parseFloat(costo).toFixed(2)}` : 'No especificado';
            
            // Auto-completar campos del formulario
            if (selectedOption.dataset.descripcion && !descripcionServicio.value) {
                descripcionServicio.value = selectedOption.dataset.descripcion;
            }
            
            if (selectedOption.dataset.diagnostico && !observacionesTecnico.value) {
                observacionesTecnico.value = selectedOption.dataset.diagnostico;
            }
            
            if (costo && !costoServicio.value) {
                costoServicio.value = parseFloat(costo).toFixed(2);
                calcularTotal();
            }
        } else {
            // Ocultar panel
            infoPanel.style.display = 'none';
        }
    });
    
    // Calcular total automáticamente
    function calcularTotal() {
        const servicio = parseFloat(costoServicio.value) || 0;
        const repuestos = parseFloat(costoRepuestos.value) || 0;
        const total = servicio + repuestos;
        totalCalculado.value = total.toFixed(2);
    }
    
    costoServicio.addEventListener('input', calcularTotal);
    costoRepuestos.addEventListener('input', calcularTotal);
    
    // Si hay una reparación preseleccionada, activar la información
    if (reparacionSelect.value) {
        reparacionSelect.dispatchEvent(new Event('change'));
    }
    
    // Validación del formulario
    document.getElementById('ticketForm').addEventListener('submit', function(e) {
        const reparacionId = reparacionSelect.value;
        const tipoTicket = document.getElementById('tipo_ticket').value;
        
        if (!reparacionId) {
            e.preventDefault();
            alert('Por favor, selecciona una reparación.');
            reparacionSelect.focus();
            return false;
        }
        
        if (!tipoTicket) {
            e.preventDefault();
            alert('Por favor, selecciona el tipo de ticket.');
            document.getElementById('tipo_ticket').focus();
            return false;
        }
        
        // Deshabilitar botón para evitar doble envío
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generando...';
        submitBtn.disabled = true;
        
        // Re-habilitar el botón después de 5 segundos por si hay error
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 5000);
    });
    
    // Calcular total inicial
    calcularTotal();
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

#infoReparacion {
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

#total_calculado {
    font-weight: bold;
    color: #28a745;
}

@media (max-width: 1200px) {
    #infoReparacion {
        position: static;
    }
}
</style>
@endsection