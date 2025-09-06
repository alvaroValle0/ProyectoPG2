@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Reparaciones')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-3">
            <i class="fas fa-tachometer-alt text-primary me-2"></i>
            Dashboard del Sistema
        </h1>
        <p class="text-muted">Resumen general del estado de equipos y reparaciones</p>
    </div>
</div>

<!-- Estadísticas Principales -->
<div class="row mb-4">
    <!-- Equipos -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="display-6 text-primary mb-2">
                    <i class="fas fa-laptop"></i>
                </div>
                <h3 class="mb-1">{{ $estadisticas['equipos']['total'] }}</h3>
                <p class="text-muted mb-0">Total Equipos</p>
                <small class="text-success">
                    <i class="fas fa-arrow-up me-1"></i>
                    {{ $estadisticas['equipos']['recibidos'] }} nuevos este mes
                </small>
            </div>
        </div>
    </div>

    <!-- Reparaciones Activas -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="display-6 text-warning mb-2">
                    <i class="fas fa-wrench"></i>
                </div>
                <h3 class="mb-1">{{ $estadisticas['reparaciones']['en_proceso'] }}</h3>
                <p class="text-muted mb-0">En Reparación</p>
                <small class="text-warning">
                    <i class="fas fa-clock me-1"></i>
                    {{ $estadisticas['reparaciones']['pendientes'] }} pendientes
                </small>
            </div>
        </div>
    </div>

    <!-- Reparaciones Completadas -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="display-6 text-success mb-2">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 class="mb-1">{{ $estadisticas['reparaciones']['completadas'] }}</h3>
                <p class="text-muted mb-0">Completadas</p>
                <small class="text-info">
                    <i class="fas fa-percentage me-1"></i>
                    {{ $estadisticas['reparaciones']['total'] > 0 ? round(($estadisticas['reparaciones']['completadas'] / $estadisticas['reparaciones']['total']) * 100, 1) : 0 }}% tasa éxito
                </small>
            </div>
        </div>
    </div>

    <!-- Reparaciones Vencidas -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="display-6 text-danger mb-2">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="mb-1">{{ $estadisticas['reparaciones']['vencidas'] }}</h3>
                <p class="text-muted mb-0">Vencidas</p>
                <small class="text-danger">
                    <i class="fas fa-calendar-times me-1"></i>
                    Requieren atención
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Contenido Principal -->
<div class="row">
    <!-- Equipos Recientes -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-laptop text-primary me-2"></i>
                        Equipos Recientes
                    </h5>
                    <a href="{{ route('equipos.index') }}" class="btn btn-sm btn-outline-primary">
                        Ver todos
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($equiposRecientes->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($equiposRecientes->take(5) as $equipo)
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $equipo->numero_serie }}</h6>
                                    <p class="mb-1 text-muted">{{ $equipo->marca }} {{ $equipo->modelo }}</p>
                                    <small class="text-muted">{{ $equipo->cliente_nombre }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge badge-estado bg-{{ $equipo->estado_color }} text-white mb-1">
                                        {{ ucfirst($equipo->estado) }}
                                    </span>
                                    <br>
                                    <small class="text-muted">{{ $equipo->fecha_ingreso->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-laptop display-6 text-muted mb-3"></i>
                        <p class="text-muted">No hay equipos registrados aún</p>
                        <a href="{{ route('equipos.create') }}" class="btn btn-primary btn-custom">
                            <i class="fas fa-plus me-2"></i>Registrar Primer Equipo
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Reparaciones Urgentes -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Reparaciones Urgentes
                    </h5>
                    <a href="{{ route('reparaciones.index') }}?vencidas=1" class="btn btn-sm btn-outline-warning">
                        Ver todas
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($reparacionesUrgentes->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($reparacionesUrgentes->take(5) as $reparacion)
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">Reparación #{{ $reparacion->id }}</h6>
                                    <p class="mb-1 text-muted">{{ $reparacion->equipo->numero_serie }}</p>
                                    <small class="text-muted">{{ Str::limit($reparacion->descripcion_problema, 50) }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-danger text-white mb-1">
                                        {{ $reparacion->dias_transcurridos }} días
                                    </span>
                                    <br>
                                    <small class="text-muted">{{ $reparacion->tecnico->nombre_completo ?? 'Sin asignar' }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-check-circle display-6 text-success mb-3"></i>
                        <p class="text-muted">¡Excelente! No hay reparaciones vencidas</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Técnicos y Actividad -->
<div class="row">
    <!-- Técnicos con Mayor Carga -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-users text-info me-2"></i>
                        Carga de Trabajo
                    </h5>
                    <a href="{{ route('tecnicos.carga-trabajo') }}" class="btn btn-sm btn-outline-info">
                        Ver detalle
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($tecnicosCargados->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($tecnicosCargados as $tecnico)
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $tecnico->nombre_completo }}</h6>
                                    <small class="text-muted">{{ $tecnico->especialidad }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-info text-white">
                                        {{ $tecnico->reparaciones_activas_count }} tareas
                                    </span>
                                </div>
                            </div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-info" style="width: {{ min(($tecnico->reparaciones_activas_count / 10) * 100, 100) }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-user-plus display-6 text-muted mb-3"></i>
                        <p class="text-muted">No hay técnicos con tareas asignadas</p>
                        <a href="{{ route('tecnicos.create') }}" class="btn btn-info btn-custom">
                            <i class="fas fa-plus me-2"></i>Registrar Técnico
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="mb-0">
                    <i class="fas fa-history text-success me-2"></i>
                    Actividad Reciente
                </h5>
            </div>
            <div class="card-body">
                @if($actividadReciente->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($actividadReciente as $reparacion)
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Reparación completada</h6>
                                    <p class="mb-1 text-muted">{{ $reparacion->equipo->numero_serie }} - {{ $reparacion->equipo->cliente_nombre }}</p>
                                    <small class="text-muted">Por {{ $reparacion->tecnico->nombre_completo }} - {{ $reparacion->updated_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-clock display-6 text-muted mb-3"></i>
                        <p class="text-muted">No hay actividad reciente</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Aquí puedes agregar gráficos con Chart.js si lo deseas
</script>
@endsection