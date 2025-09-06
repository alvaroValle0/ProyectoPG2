@extends('layouts.app')

@section('title', 'Carga de Trabajo de Técnicos')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-chart-bar text-primary me-2"></i>
            Carga de Trabajo de Técnicos
        </h1>
        <p class="text-muted">Monitorea la distribución de tareas y rendimiento del equipo técnico</p>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <a href="{{ route('tecnicos.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-users me-2"></i>Ver Técnicos
            </a>
            <a href="{{ route('reparaciones.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-wrench me-2"></i>Ver Reparaciones
            </a>
        </div>
    </div>
</div>

<!-- Estadísticas Generales -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-primary text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-users display-6 mb-2"></i>
                <h4>{{ $tecnicos->count() }}</h4>
                <p class="mb-0">Total Técnicos</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-success text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-user-check display-6 mb-2"></i>
                <h4>{{ $tecnicos->where('activo', true)->count() }}</h4>
                <p class="mb-0">Técnicos Activos</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-warning text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-tasks display-6 mb-2"></i>
                <h4>{{ $tecnicos->sum('carga_trabajo') }}</h4>
                <p class="mb-0">Tareas Totales</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-info text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-balance-scale display-6 mb-2"></i>
                <h4>{{ $tecnicos->where('activo', true)->count() > 0 ? round($tecnicos->sum('carga_trabajo') / $tecnicos->where('activo', true)->count(), 1) : 0 }}</h4>
                <p class="mb-0">Promedio por Técnico</p>
            </div>
        </div>
    </div>
</div>

<!-- Carga de Trabajo Individual -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-transparent border-0">
        <h5 class="mb-0">
            <i class="fas fa-chart-bar text-primary me-2"></i>
            Distribución de Carga de Trabajo
        </h5>
    </div>
    <div class="card-body">
        @if($tecnicos->count() > 0)
            <div class="row">
                @foreach($tecnicos as $tecnico)
                @php
                    $maxCarga = 15; // Carga máxima recomendada
                    $porcentaje = $tecnico['carga_trabajo'] > 0 ? min(($tecnico['carga_trabajo'] / $maxCarga) * 100, 100) : 0;
                    $colorCarga = $porcentaje > 80 ? 'danger' : ($porcentaje > 60 ? 'warning' : ($porcentaje > 30 ? 'info' : 'success'));
                    $estadoCarga = $porcentaje > 80 ? 'Sobrecargado' : ($porcentaje > 60 ? 'Alta carga' : ($porcentaje > 30 ? 'Carga normal' : 'Carga baja'));
                @endphp
                <div class="col-lg-6 mb-4">
                    <div class="card border-{{ $colorCarga }} h-100">
                        <div class="card-body">
                            <!-- Header del técnico -->
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-{{ $colorCarga }} text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $tecnico['nombre'] }}</h6>
                                    <small class="text-muted">{{ $tecnico['especialidad'] }}</small>
                                    @if(!$tecnico['activo'])
                                        <br><span class="badge bg-secondary">Inactivo</span>
                                    @endif
                                </div>
                                <div class="text-end">
                                    <h4 class="text-{{ $colorCarga }} mb-0">{{ $tecnico['carga_trabajo'] }}</h4>
                                    <small class="text-muted">tareas</small>
                                </div>
                            </div>

                            <!-- Barra de progreso de carga -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Capacidad de trabajo</small>
                                    <small class="text-{{ $colorCarga }}">{{ $estadoCarga }}</small>
                                </div>
                                <div class="progress" style="height: 12px;">
                                    <div class="progress-bar bg-{{ $colorCarga }}" 
                                         style="width: {{ $porcentaje }}%"
                                         title="{{ round($porcentaje, 1) }}% de capacidad">
                                    </div>
                                </div>
                                <small class="text-muted">{{ round($porcentaje, 1) }}% de capacidad máxima</small>
                            </div>

                            <!-- Lista de reparaciones activas -->
                            @if(count($tecnico['reparaciones_activas']) > 0)
                                <div class="mb-3">
                                    <h6 class="text-muted mb-2">Reparaciones Activas:</h6>
                                    <div class="list-group list-group-flush">
                                        @foreach($tecnico['reparaciones_activas']->take(3) as $reparacion)
                                        <div class="list-group-item px-0 py-2 border-start-0 border-end-0">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong class="small">#{{ $reparacion->id }} - {{ $reparacion->equipo->cliente_nombre }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $reparacion->equipo->marca }} {{ $reparacion->equipo->modelo }}</small>
                                                </div>
                                                <div class="text-end">
                                                    <span class="badge bg-{{ $reparacion->estado_color }} text-white">
                                                        {{ ucfirst($reparacion->estado) }}
                                                    </span>
                                                    @if($reparacion->es_vencida)
                                                        <br><small class="text-danger">Vencida</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @if($tecnico['reparaciones_activas']->count() > 3)
                                        <div class="list-group-item px-0 py-2 text-center border-start-0 border-end-0">
                                            <small class="text-muted">
                                                +{{ $tecnico['reparaciones_activas']->count() - 3 }} reparaciones más...
                                            </small>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <i class="fas fa-check-circle text-success display-6 mb-2"></i>
                                    <p class="text-success mb-0"><strong>Sin tareas pendientes</strong></p>
                                    <small class="text-muted">Disponible para nuevas asignaciones</small>
                                </div>
                            @endif

                            <!-- Acciones -->
                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ route('tecnicos.show', $tecnico['id']) }}" 
                                   class="btn btn-outline-primary btn-sm flex-fill">
                                    <i class="fas fa-eye me-1"></i>Ver Perfil
                                </a>
                                <a href="{{ route('reparaciones.index', ['tecnico_id' => $tecnico['id']]) }}" 
                                   class="btn btn-outline-info btn-sm flex-fill">
                                    <i class="fas fa-list me-1"></i>Sus Tareas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Resumen y Recomendaciones -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-lightbulb text-warning me-2"></i>
                                Análisis y Recomendaciones
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @php
                                    $sobrecargados = $tecnicos->filter(function($t) { return $t['carga_trabajo'] > 12; })->count();
                                    $disponibles = $tecnicos->filter(function($t) { return $t['carga_trabajo'] < 5 && $t['activo']; })->count();
                                    $cargaTotal = $tecnicos->sum('carga_trabajo');
                                    $tecnicosActivos = $tecnicos->where('activo', true)->count();
                                @endphp
                                
                                <div class="col-md-4">
                                    <div class="text-center">
                                        @if($sobrecargados > 0)
                                            <i class="fas fa-exclamation-triangle text-danger display-6 mb-2"></i>
                                            <h6 class="text-danger">{{ $sobrecargados }} técnico(s) sobrecargado(s)</h6>
                                            <small class="text-muted">Considera redistribuir algunas tareas</small>
                                        @else
                                            <i class="fas fa-check-circle text-success display-6 mb-2"></i>
                                            <h6 class="text-success">Carga equilibrada</h6>
                                            <small class="text-muted">Ningún técnico está sobrecargado</small>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="text-center">
                                        @if($disponibles > 0)
                                            <i class="fas fa-user-plus text-success display-6 mb-2"></i>
                                            <h6 class="text-success">{{ $disponibles }} técnico(s) disponible(s)</h6>
                                            <small class="text-muted">Pueden recibir más asignaciones</small>
                                        @else
                                            <i class="fas fa-users text-info display-6 mb-2"></i>
                                            <h6 class="text-info">Todos están ocupados</h6>
                                            <small class="text-muted">Considera contratar más técnicos</small>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="text-center">
                                        @if($tecnicosActivos > 0)
                                            @php $eficiencia = ($cargaTotal / ($tecnicosActivos * 10)) * 100; @endphp
                                            <i class="fas fa-chart-line text-info display-6 mb-2"></i>
                                            <h6 class="text-info">{{ round($eficiencia, 1) }}% de eficiencia</h6>
                                            <small class="text-muted">Utilización del equipo técnico</small>
                                        @else
                                            <i class="fas fa-ban text-danger display-6 mb-2"></i>
                                            <h6 class="text-danger">Sin técnicos activos</h6>
                                            <small class="text-muted">Activa al menos un técnico</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users display-1 text-muted mb-4"></i>
                <h4 class="text-muted">No hay técnicos registrados</h4>
                <p class="text-muted">Registra técnicos para poder monitorear la carga de trabajo.</p>
                <a href="{{ route('tecnicos.create') }}" class="btn btn-primary btn-custom">
                    <i class="fas fa-user-plus me-2"></i>Registrar Primer Técnico
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Acciones Rápidas -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('reparaciones.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>Nueva Reparación
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('tecnicos.create') }}" class="btn btn-success w-100">
                            <i class="fas fa-user-plus me-2"></i>Nuevo Técnico
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="button" class="btn btn-outline-secondary w-100" onclick="mostrarProximamente('Redistribuir Tareas')">
                            <i class="fas fa-exchange-alt me-2"></i>Redistribuir Tareas
                        </button>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="button" class="btn btn-outline-secondary w-100" onclick="mostrarProximamente('Exportar Reporte')">
                            <i class="fas fa-download me-2"></i>Exportar Reporte
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Actualización automática cada 30 segundos
setInterval(() => {
    if (!document.querySelector('.modal.show')) {
        location.reload();
    }
}, 30000);

// Función para mostrar alertas de funcionalidades próximas
function mostrarProximamente(funcionalidad) {
    alert('La funcionalidad "' + funcionalidad + '" estará disponible próximamente.');
}

// Tooltip para barras de progreso
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips si están disponibles
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
</script>
@endsection

@section('styles')
<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.progress {
    background-color: rgba(0, 0, 0, 0.1);
}

.list-group-item {
    background-color: transparent;
}

@media (max-width: 768px) {
    .col-lg-6 {
        margin-bottom: 1rem;
    }
}
</style>
@endsection