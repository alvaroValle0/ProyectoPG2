@extends('layouts.app')

@section('title', 'Editar Técnico - ' . $tecnico->nombre_completo)

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-user-edit text-warning me-2"></i>
            Editar Técnico
        </h1>
        <p class="text-muted">Modifica la información de {{ $tecnico->nombre_completo }}</p>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <a href="{{ route('tecnicos.show', $tecnico) }}" class="btn btn-outline-primary">
                <i class="fas fa-eye me-2"></i>Ver Perfil
            </a>
            <a href="{{ route('tecnicos.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('tecnicos.update', $tecnico) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Información Actual del Usuario -->
                <div class="col-lg-6">
                    <h5 class="mb-3">
                        <i class="fas fa-user text-primary me-2"></i>
                        Información del Usuario
                    </h5>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Usuario asociado:</strong> {{ $tecnico->user->name }}<br>
                        <strong>Email:</strong> {{ $tecnico->user->email }}<br>
                        <small class="text-muted">La información del usuario se gestiona desde la administración de usuarios.</small>
                    </div>

                    <div class="card border-light">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                     style="width: 80px; height: 80px; font-size: 2rem;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <h5>{{ $tecnico->nombre_completo }}</h5>
                                <p class="text-muted">{{ $tecnico->user->email }}</p>
                                <small class="text-muted">Registrado: {{ $tecnico->created_at->format('d/m/Y') }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información Técnica Editable -->
                <div class="col-lg-6">
                    <h5 class="mb-3">
                        <i class="fas fa-cog text-info me-2"></i>
                        Información Técnica
                    </h5>

                    <div class="mb-3">
                        <label for="especialidad" class="form-label">Especialidad <span class="text-danger">*</span></label>
                        <select class="form-select @error('especialidad') is-invalid @enderror" 
                                id="especialidad" 
                                name="especialidad" 
                                required>
                            <option value="">Seleccione una especialidad</option>
                            <option value="Hardware y Componentes" {{ old('especialidad', $tecnico->especialidad) == 'Hardware y Componentes' ? 'selected' : '' }}>
                                Hardware y Componentes
                            </option>
                            <option value="Software y Sistemas Operativos" {{ old('especialidad', $tecnico->especialidad) == 'Software y Sistemas Operativos' ? 'selected' : '' }}>
                                Software y Sistemas Operativos
                            </option>
                            <option value="Redes y Conectividad" {{ old('especialidad', $tecnico->especialidad) == 'Redes y Conectividad' ? 'selected' : '' }}>
                                Redes y Conectividad
                            </option>
                            <option value="Equipos Móviles" {{ old('especialidad', $tecnico->especialidad) == 'Equipos Móviles' ? 'selected' : '' }}>
                                Equipos Móviles
                            </option>
                            <option value="Servidores y Infraestructura" {{ old('especialidad', $tecnico->especialidad) == 'Servidores y Infraestructura' ? 'selected' : '' }}>
                                Servidores y Infraestructura
                            </option>
                            <option value="Impresoras y Periféricos" {{ old('especialidad', $tecnico->especialidad) == 'Impresoras y Periféricos' ? 'selected' : '' }}>
                                Impresoras y Periféricos
                            </option>
                            <option value="Seguridad Informática" {{ old('especialidad', $tecnico->especialidad) == 'Seguridad Informática' ? 'selected' : '' }}>
                                Seguridad Informática
                            </option>
                            <option value="Diagnóstico General" {{ old('especialidad', $tecnico->especialidad) == 'Diagnóstico General' ? 'selected' : '' }}>
                                Diagnóstico General
                            </option>
                            <option value="Recuperación de Datos" {{ old('especialidad', $tecnico->especialidad) == 'Recuperación de Datos' ? 'selected' : '' }}>
                                Recuperación de Datos
                            </option>
                        </select>
                        @error('especialidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción de Habilidades</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" 
                                  name="descripcion" 
                                  rows="4" 
                                  placeholder="Describe las habilidades específicas, certificaciones, experiencia, etc.">{{ old('descripcion', $tecnico->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Opcional: Detalla las habilidades y experiencia del técnico</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input @error('activo') is-invalid @enderror" 
                                   type="checkbox" 
                                   id="activo" 
                                   name="activo" 
                                   value="1" 
                                   {{ old('activo', $tecnico->activo) ? 'checked' : '' }}>
                            <label class="form-check-label" for="activo">
                                <strong>Técnico Activo</strong>
                            </label>
                            @error('activo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block">
                                @if($tecnico->activo)
                                    El técnico está activo y puede recibir asignaciones
                                @else
                                    El técnico está inactivo y no recibirá nuevas asignaciones
                                @endif
                            </small>
                        </div>
                    </div>

                    @if($tecnico->reparacionesActivas && $tecnico->reparacionesActivas->count() > 0)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Atención:</strong> Este técnico tiene {{ $tecnico->reparacionesActivas->count() }} reparaciones activas.
                        Si lo desactivas, no podrá recibir nuevas asignaciones, pero debe completar las pendientes.
                    </div>
                    @endif
                </div>
            </div>

            <hr class="my-4">

            <!-- Estadísticas Actuales -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">
                        <i class="fas fa-chart-bar text-success me-2"></i>
                        Estadísticas Actuales
                    </h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card border-primary text-center">
                                <div class="card-body">
                                    <i class="fas fa-tasks text-primary display-6 mb-2"></i>
                                    <h4 class="text-primary">{{ $tecnico->total_reparaciones ?? 0 }}</h4>
                                    <p class="text-muted mb-0">Total Reparaciones</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-success text-center">
                                <div class="card-body">
                                    <i class="fas fa-check-circle text-success display-6 mb-2"></i>
                                    <h4 class="text-success">{{ $tecnico->reparaciones_completadas_count ?? 0 }}</h4>
                                    <p class="text-muted mb-0">Completadas</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-warning text-center">
                                <div class="card-body">
                                    <i class="fas fa-clock text-warning display-6 mb-2"></i>
                                    <h4 class="text-warning">{{ $tecnico->carga_trabajo ?? 0 }}</h4>
                                    <p class="text-muted mb-0">Carga Actual</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-info text-center">
                                <div class="card-body">
                                    <i class="fas fa-stopwatch text-info display-6 mb-2"></i>
                                    <h4 class="text-info">
                                        @if($tecnico->promedio_tiempo_reparacion)
                                            {{ round($tecnico->promedio_tiempo_reparacion, 1) }}h
                                        @else
                                            N/A
                                        @endif
                                    </h4>
                                    <p class="text-muted mb-0">Promedio Tiempo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reparaciones Activas -->
            @if($tecnico->reparacionesActivas && $tecnico->reparacionesActivas->count() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">
                        <i class="fas fa-tasks text-warning me-2"></i>
                        Reparaciones Activas ({{ $tecnico->reparacionesActivas->count() }})
                    </h5>
                    <div class="row">
                        @foreach($tecnico->reparacionesActivas->take(4) as $reparacion)
                        <div class="col-md-6 mb-3">
                            <div class="card border-left-{{ $reparacion->estado_color }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">Reparación #{{ $reparacion->id }}</h6>
                                            <p class="mb-1 text-muted">{{ $reparacion->equipo->cliente_nombre }}</p>
                                            <span class="badge bg-{{ $reparacion->estado_color }} text-white">
                                                {{ ucfirst($reparacion->estado) }}
                                            </span>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted">{{ $reparacion->fecha_inicio->diffForHumans() }}</small>
                                            <br>
                                            <a href="{{ route('reparaciones.show', $reparacion) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($tecnico->reparacionesActivas->count() > 4)
                    <div class="text-center">
                        <a href="{{ route('reparaciones.index', ['tecnico_id' => $tecnico->id]) }}" 
                           class="btn btn-outline-info">
                            <i class="fas fa-list me-2"></i>Ver todas las reparaciones ({{ $tecnico->reparacionesActivas->count() }})
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('tecnicos.show', $tecnico) }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            @if($tecnico->reparacionesActivas->count() == 0)
                                <button type="button" class="btn btn-outline-danger" onclick="confirmarEliminacion()">
                                    <i class="fas fa-trash me-2"></i>Eliminar Técnico
                                </button>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-warning btn-custom">
                            <i class="fas fa-save me-2"></i>Actualizar Técnico
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Formulario oculto para eliminar -->
        @if($tecnico->reparacionesActivas->count() == 0)
        <form id="eliminarForm" action="{{ route('tecnicos.destroy', $tecnico) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
// Validación del formulario
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="update"]');
    const especialidadSelect = document.getElementById('especialidad');
    
    // Validación del formulario
    form.addEventListener('submit', function(e) {
        let valid = true;
        
        if (!especialidadSelect.value) {
            especialidadSelect.classList.add('is-invalid');
            valid = false;
        } else {
            especialidadSelect.classList.remove('is-invalid');
        }
        
        if (!valid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos obligatorios.');
        }
    });
});

function confirmarEliminacion() {
    if (confirm('¿Está seguro de que desea eliminar este técnico?\n\nEsta acción no se puede deshacer y eliminará todo el historial relacionado.')) {
        if (confirm('Confirme nuevamente: ¿Realmente desea eliminar el técnico {{ $tecnico->nombre_completo }}?')) {
            document.getElementById('eliminarForm').submit();
        }
    }
}
</script>
@endsection

@section('styles')
<style>
.border-left-primary { border-left: 4px solid #007bff !important; }
.border-left-warning { border-left: 4px solid #ffc107 !important; }
.border-left-success { border-left: 4px solid #28a745 !important; }
.border-left-danger { border-left: 4px solid #dc3545 !important; }
.border-left-info { border-left: 4px solid #17a2b8 !important; }
</style>
@endsection