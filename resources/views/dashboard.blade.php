@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Reparaciones')

@section('content')
<div class="container-fluid">
    <!-- Header Mejorado -->
    <div class="dashboard-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-7">
                <div class="welcome-section">
                    <h1 class="dashboard-title">
                        <i class="fas fa-tachometer-alt me-2 me-lg-3"></i>
                        <span class="d-none d-sm-inline">Dashboard del Sistema</span>
                        <span class="d-inline d-sm-none">Dashboard</span>
                    </h1>
                    <p class="dashboard-subtitle">
                        <i class="fas fa-calendar-alt me-2"></i>
                        <span class="d-none d-md-inline">{{ now()->format('l, d \d\e F \d\e Y') }}</span>
                        <span class="d-inline d-md-none">{{ now()->format('d/m/Y') }}</span>
                    </p>
                    <div class="quick-stats">
                        <span class="stat-item" id="current-time">
                            <i class="fas fa-clock text-info"></i>
                            <span id="time-display">{{ now()->format('H:i:s') }}</span>
                        </span>
                        <span class="stat-item d-none d-md-inline">
                            <i class="fas fa-user text-primary"></i>
                            {{ Str::limit(auth()->user()->name, 15) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-5">
                <div class="action-buttons">
                    <a href="{{ route('reparaciones.index') }}" class="btn btn-primary btn-modern me-2 mb-2 mb-md-0" data-bs-toggle="tooltip" title="Ir a Reparaciones">
                        <i class="fas fa-wrench me-2"></i>
                        <span class="d-none d-sm-inline">Reparaciones</span>
                        <span class="d-inline d-sm-none">Rep</span>
                    </a>
                    <a href="{{ route('equipos.create') }}" class="btn btn-success btn-modern" data-bs-toggle="tooltip" title="Nuevo Equipo">
                        <i class="fas fa-plus me-2"></i>
                        <span class="d-none d-sm-inline">Nuevo</span>
                        <span class="d-inline d-sm-none">+</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas Principales Mejoradas -->
<div class="row mb-4">
    <!-- Equipos -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-icon">
                <i class="fas fa-laptop"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-number">{{ $estadisticas['equipos']['total'] }}</h3>
                <p class="stat-label">Total Equipos</p>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up text-success"></i>
                    <span class="text-success">+{{ $estadisticas['equipos']['recibidos'] }} este mes</span>
                </div>
            </div>
            <div class="stat-card-chart">
                <canvas id="equiposChart" width="60" height="40"></canvas>
            </div>
        </div>
    </div>

    <!-- Reparaciones Activas -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-icon">
                <i class="fas fa-wrench"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-number">{{ $estadisticas['reparaciones']['en_proceso'] }}</h3>
                <p class="stat-label">En Reparación</p>
                <div class="stat-trend">
                    <i class="fas fa-clock text-warning"></i>
                    <span class="text-warning">{{ $estadisticas['reparaciones']['pendientes'] }} pendientes</span>
                </div>
            </div>
            <div class="stat-card-chart">
                <canvas id="reparacionesChart" width="60" height="40"></canvas>
            </div>
        </div>
    </div>

    <!-- Reparaciones Completadas -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
        <div class="stat-card stat-card-success">
            <div class="stat-card-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-number">{{ $estadisticas['reparaciones']['completadas'] }}</h3>
                <p class="stat-label">Completadas</p>
                <div class="stat-trend">
                    <i class="fas fa-percentage text-success"></i>
                    <span class="text-success">{{ $estadisticas['reparaciones']['total'] > 0 ? round(($estadisticas['reparaciones']['completadas'] / $estadisticas['reparaciones']['total']) * 100, 1) : 0 }}% tasa éxito</span>
                </div>
            </div>
            <div class="stat-card-chart">
                <canvas id="completadasChart" width="60" height="40"></canvas>
            </div>
        </div>
    </div>

    <!-- Reparaciones Vencidas -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
        <div class="stat-card stat-card-danger">
            <div class="stat-card-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-number">{{ $estadisticas['reparaciones']['vencidas'] }}</h3>
                <p class="stat-label">Vencidas</p>
                <div class="stat-trend">
                    <i class="fas fa-exclamation text-danger"></i>
                    <span class="text-danger">Requieren atención</span>
                </div>
            </div>
            <div class="stat-card-chart">
                <canvas id="vencidasChart" width="60" height="40"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos Principales -->
<div class="row mb-4">
    <div class="col-lg-8 mb-4">
        <div class="chart-card">
            <div class="chart-header">
                <h5 class="chart-title">
                    <i class="fas fa-chart-line me-2"></i>
                    Estado de Equipos
                </h5>
                <div class="chart-actions">
                    <button class="btn btn-sm btn-outline-primary" onclick="toggleChart('equipos')">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </button>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="equiposEstadoChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="chart-card">
            <div class="chart-header">
                <h5 class="chart-title">
                    <i class="fas fa-chart-pie me-2"></i>
                    Reparaciones por Mes
                </h5>
            </div>
            <div class="chart-body">
                <canvas id="reparacionesMesChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Contenido Principal -->
<div class="row">
    <!-- Equipos Recientes -->
    <div class="col-lg-6 mb-4">
        <div class="modern-card">
            <div class="modern-card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="card-title-section">
                        <h5 class="modern-card-title">
                            <i class="fas fa-laptop text-primary me-2"></i>
                            Equipos Recientes
                        </h5>
                        <p class="modern-card-subtitle">Últimos equipos registrados</p>
                    </div>
                    <a href="{{ route('equipos.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-arrow-right me-1"></i>Ver todos
                    </a>
                </div>
            </div>
            <div class="modern-card-body">
                @if($equiposRecientes->count() > 0)
                    <div class="modern-list">
                        @foreach($equiposRecientes->take(5) as $equipo)
                        <div class="modern-list-item">
                            <div class="list-item-icon">
                                <i class="fas fa-laptop text-primary"></i>
                            </div>
                            <div class="list-item-content">
                                <h6 class="list-item-title">{{ $equipo->numero_serie }}</h6>
                                <p class="list-item-subtitle">{{ $equipo->marca }} {{ $equipo->modelo }}</p>
                                <small class="list-item-meta">
                                    <i class="fas fa-user me-1"></i>{{ $equipo->cliente_nombre }}
                                </small>
                            </div>
                            <div class="list-item-actions">
                                <span class="status-badge status-{{ $equipo->estado }}">
                                    {{ ucfirst($equipo->estado) }}
                                </span>
                                <small class="text-muted d-block mt-1">
                                    {{ $equipo->fecha_ingreso->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <h6 class="empty-state-title">No hay equipos registrados</h6>
                        <p class="empty-state-text">Comienza registrando tu primer equipo</p>
                        <a href="{{ route('equipos.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Registrar Equipo
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Reparaciones Urgentes -->
    <div class="col-lg-6 mb-4">
        <div class="modern-card">
            <div class="modern-card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="card-title-section">
                        <h5 class="modern-card-title">
                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                            Reparaciones Urgentes
                        </h5>
                        <p class="modern-card-subtitle">Requieren atención inmediata</p>
                    </div>
                    <a href="{{ route('reparaciones.index') }}?vencidas=1" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-arrow-right me-1"></i>Ver todas
                    </a>
                </div>
            </div>
            <div class="modern-card-body">
                @if($reparacionesUrgentes->count() > 0)
                    <div class="modern-list">
                        @foreach($reparacionesUrgentes->take(5) as $reparacion)
                        <div class="modern-list-item urgent-item">
                            <div class="list-item-icon">
                                <i class="fas fa-wrench text-warning"></i>
                            </div>
                            <div class="list-item-content">
                                <h6 class="list-item-title">Reparación #{{ $reparacion->id }}</h6>
                                <p class="list-item-subtitle">{{ $reparacion->equipo->numero_serie }}</p>
                                <small class="list-item-meta">
                                    {{ Str::limit($reparacion->descripcion_problema, 50) }}
                                </small>
                            </div>
                            <div class="list-item-actions">
                                <span class="urgency-badge">
                                    {{ $reparacion->dias_transcurridos }} días
                                </span>
                                <small class="text-muted d-block mt-1">
                                    {{ $reparacion->tecnico->nombre_completo ?? 'Sin asignar' }}
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state success-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                        <h6 class="empty-state-title">¡Excelente!</h6>
                        <p class="empty-state-text">No hay reparaciones vencidas</p>
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
        <div class="modern-card">
            <div class="modern-card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="card-title-section">
                        <h5 class="modern-card-title">
                            <i class="fas fa-users text-info me-2"></i>
                            Carga de Trabajo
                        </h5>
                        <p class="modern-card-subtitle">Distribución de tareas por técnico</p>
                    </div>
                    <a href="{{ route('tecnicos.carga-trabajo') }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-arrow-right me-1"></i>Ver detalle
                    </a>
                </div>
            </div>
            <div class="modern-card-body">
                @if($tecnicosCargados->count() > 0)
                    <div class="workload-list">
                        @foreach($tecnicosCargados as $tecnico)
                        <div class="workload-item">
                            <div class="workload-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="workload-content">
                                <h6 class="workload-name">{{ $tecnico->nombre_completo }}</h6>
                                <p class="workload-specialty">{{ $tecnico->especialidad }}</p>
                                <div class="workload-progress">
                                    <div class="progress-bar-container">
                                        <div class="progress-bar-fill" style="width: {{ min(($tecnico->reparaciones_activas_count / 10) * 100, 100) }}%"></div>
                                    </div>
                                    <span class="workload-count">{{ $tecnico->reparaciones_activas_count }} tareas</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h6 class="empty-state-title">No hay técnicos activos</h6>
                        <p class="empty-state-text">Registra técnicos para comenzar</p>
                        <a href="{{ route('tecnicos.create') }}" class="btn btn-info">
                            <i class="fas fa-plus me-2"></i>Registrar Técnico
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="col-lg-6 mb-4">
        <div class="modern-card">
            <div class="modern-card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="card-title-section">
                        <h5 class="modern-card-title">
                            <i class="fas fa-history text-success me-2"></i>
                            Actividad Reciente
                        </h5>
                        <p class="modern-card-subtitle">Últimas reparaciones completadas</p>
                    </div>
                </div>
            </div>
            <div class="modern-card-body">
                @if($actividadReciente->count() > 0)
                    <div class="activity-timeline">
                        @foreach($actividadReciente as $reparacion)
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                            <div class="activity-content">
                                <h6 class="activity-title">Reparación completada</h6>
                                <p class="activity-description">
                                    {{ $reparacion->equipo->numero_serie }} - {{ $reparacion->equipo->cliente_nombre }}
                                </p>
                                <small class="activity-meta">
                                    Por {{ $reparacion->tecnico->nombre_completo }} • {{ $reparacion->updated_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h6 class="empty-state-title">No hay actividad reciente</h6>
                        <p class="empty-state-text">Las actividades aparecerán aquí</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal de Tutorial Simple -->
<div class="tutorial-modal" id="tutorialModal" style="display: none;">
    <div class="tutorial-overlay-simple"></div>
    <div class="tutorial-content-simple">
        <div class="tutorial-header-simple">
            <h5 id="tutorialTitle">Tutorial del Dashboard</h5>
            <button type="button" class="btn-close-tutorial" onclick="closeTutorial()">&times;</button>
        </div>
        <div class="tutorial-body-simple">
            <p id="tutorialDescription">Aquí puedes ver las estadísticas principales del sistema.</p>
        </div>
        <div class="tutorial-footer-simple">
            <div class="tutorial-pagination">
                <span id="tutorialStep">1 de 13</span>
            </div>
            <div class="tutorial-buttons">
                <button type="button" class="btn-tutorial-prev" onclick="prevStep()" id="prevBtn" style="display: none;">Anterior</button>
                <button type="button" class="btn-tutorial-next" onclick="nextStep()" id="nextBtn">Siguiente</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Tutorial Modal Simple */
.tutorial-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
}

.tutorial-overlay-simple {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
}

.tutorial-content-simple {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    min-width: 400px;
    max-width: 500px;
}

.tutorial-header-simple {
    padding: 20px 20px 10px 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.tutorial-header-simple h5 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.btn-close-tutorial {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #999;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-close-tutorial:hover {
    color: #333;
}

.tutorial-body-simple {
    padding: 20px;
}

.tutorial-body-simple p {
    margin: 0;
    color: #666;
    line-height: 1.5;
}

.tutorial-footer-simple {
    padding: 10px 20px 20px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.tutorial-pagination {
    color: #999;
    font-size: 14px;
}

.tutorial-buttons {
    display: flex;
    gap: 10px;
}

.btn-tutorial-prev,
.btn-tutorial-next {
    padding: 8px 16px;
    border: 1px solid #ddd;
    background: #f8f9fa;
    color: #333;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.btn-tutorial-next {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.btn-tutorial-prev:hover {
    background: #e9ecef;
}

.btn-tutorial-next:hover {
    background: #0056b3;
}

/* Highlight del elemento */
.tutorial-highlight {
    position: relative;
    z-index: 10000;
    outline: 3px solid #007bff;
    outline-offset: 2px;
    background: rgba(0, 123, 255, 0.1);
    border-radius: 4px;
    animation: tutorial-pulse 2s infinite;
}

.tutorial-highlight::before {
    content: '';
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    background: rgba(0, 123, 255, 0.1);
    border-radius: 8px;
    z-index: -1;
}

/* Animación de pulso */
@keyframes tutorial-pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(0, 123, 255, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(0, 123, 255, 0);
    }
}

/* Indicador de flecha */
.tutorial-arrow {
    position: fixed;
    width: 0;
    height: 0;
    z-index: 10001;
    pointer-events: none;
}

.tutorial-arrow-up {
    border-left: 15px solid transparent;
    border-right: 15px solid transparent;
    border-bottom: 15px solid white;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
}

.tutorial-arrow-down {
    border-left: 15px solid transparent;
    border-right: 15px solid transparent;
    border-top: 15px solid white;
    filter: drop-shadow(0 -2px 4px rgba(0,0,0,0.2));
}

.tutorial-arrow-left {
    border-top: 15px solid transparent;
    border-bottom: 15px solid transparent;
    border-right: 15px solid white;
    filter: drop-shadow(2px 0 4px rgba(0,0,0,0.2));
}

.tutorial-arrow-right {
    border-top: 15px solid transparent;
    border-bottom: 15px solid transparent;
    border-left: 15px solid white;
    filter: drop-shadow(-2px 0 4px rgba(0,0,0,0.2));
}
</style>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Actualizar reloj cada segundo
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('es-GT', {
            hour12: false,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        const timeDisplay = document.getElementById('time-display');
        if (timeDisplay) {
            timeDisplay.textContent = timeString;
        }
    }
    
    // Actualizar inmediatamente y luego cada segundo
    updateClock();
    setInterval(updateClock, 1000);
    // Datos para los gráficos
    const equiposPorEstado = @json($equiposPorEstado);
    const reparacionesPorMes = @json($reparacionesPorMes);
    
    // Gráfico de estado de equipos
    const equiposCtx = document.getElementById('equiposEstadoChart').getContext('2d');
    new Chart(equiposCtx, {
        type: 'doughnut',
        data: {
            labels: ['Recibidos', 'En Reparación', 'Reparados', 'Entregados'],
            datasets: [{
                data: [
                    equiposPorEstado.recibido || 0,
                    equiposPorEstado.en_reparacion || 0,
                    equiposPorEstado.reparado || 0,
                    equiposPorEstado.entregado || 0
                ],
                backgroundColor: [
                    '#17a2b8',
                    '#ffc107',
                    '#28a745',
                    '#6f42c1'
                ],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Gráfico de reparaciones por mes
    const reparacionesCtx = document.getElementById('reparacionesMesChart').getContext('2d');
    const meses = Object.keys(reparacionesPorMes).map(mes => {
        const fecha = new Date(mes + '-01');
        return fecha.toLocaleDateString('es-ES', { month: 'short', year: '2-digit' });
    });
    const valores = Object.values(reparacionesPorMes);
    
    new Chart(reparacionesCtx, {
        type: 'line',
        data: {
            labels: meses,
            datasets: [{
                label: 'Reparaciones',
                data: valores,
                borderColor: '#27DB9F',
                backgroundColor: 'rgba(39, 219, 159, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#27DB9F',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Gráficos pequeños en las tarjetas de estadísticas
    createMiniCharts();
    
    // Animaciones de entrada
    animateCards();
});

function createMiniCharts() {
    // Gráfico mini para equipos
    const equiposMiniCtx = document.getElementById('equiposChart').getContext('2d');
    new Chart(equiposMiniCtx, {
        type: 'line',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            datasets: [{
                data: [12, 19, 3, 5, 2, 3],
                borderColor: '#fff',
                backgroundColor: 'rgba(255,255,255,0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 0
            }]
        },
        options: {
            responsive: false,
            plugins: { legend: { display: false } },
            scales: { x: { display: false }, y: { display: false } }
        }
    });

    // Repetir para otros gráficos mini...
    ['reparacionesChart', 'completadasChart', 'vencidasChart'].forEach(id => {
        const ctx = document.getElementById(id).getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [{
                    data: [Math.random() * 10, Math.random() * 10, Math.random() * 10, Math.random() * 10, Math.random() * 10, Math.random() * 10],
                    borderColor: '#fff',
                    backgroundColor: 'rgba(255,255,255,0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: false,
                plugins: { legend: { display: false } },
                scales: { x: { display: false }, y: { display: false } }
            }
        });
    });
}

function animateCards() {
    const cards = document.querySelectorAll('.stat-card, .modern-card, .chart-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

function toggleChart(type) {
    // Función para expandir gráficos
    console.log('Toggle chart:', type);
}

// Mostrar/ocultar botón de tutorial según si ya fue completado
document.addEventListener('DOMContentLoaded', function() {
    const tutorialBtn = document.getElementById('tutorialBtn');
    const resetBtn = document.getElementById('resetTutorialBtn');
    
    if (tutorialBtn && window.shouldShowTutorialButton) {
        if (window.shouldShowTutorialButton('dashboard')) {
            tutorialBtn.style.display = 'flex';
        } else {
            tutorialBtn.style.display = 'none';
            // Mostrar botón de reinicio si el tutorial ya fue completado
            if (resetBtn) {
                resetBtn.style.display = 'flex';
            }
        }
    }
});

// Función para reiniciar tutorial
function resetTutorial() {
    if (window.tutorialSystem && window.tutorialSystem.resetCompleted) {
        window.tutorialSystem.resetCompleted('dashboard');
        
        // Mostrar botón de tutorial y ocultar botón de reinicio
        const tutorialBtn = document.getElementById('tutorialBtn');
        const resetBtn = document.getElementById('resetTutorialBtn');
        
        if (tutorialBtn) tutorialBtn.style.display = 'flex';
        if (resetBtn) resetBtn.style.display = 'none';
        
        // Mostrar notificación
        if (window.mobileUtils) {
            window.mobileUtils.showNotification('Tutorial reiniciado. Puedes iniciarlo nuevamente.', 'info', 3000);
        }
    }
}

// Tutorial Completo del Dashboard
let currentTutorialStep = 0;
const tutorialSteps = [
    {
        title: "🏠 Dashboard del Sistema",
        description: "Bienvenido al centro de control principal de HDC. Aquí tienes acceso a toda la información importante del sistema de gestión de equipos y reparaciones.",
        target: ".dashboard-title"
    },
    {
        title: "⏰ Información en Tiempo Real",
        description: "Este reloj se actualiza automáticamente cada segundo con la hora actual del sistema. También muestra tu usuario activo para confirmar tu sesión.",
        target: "#current-time"
    },
    {
        title: "🚀 Acciones Rápidas",
        description: "Estos botones te permiten acceder directamente a las funciones más importantes: ir a reparaciones o crear un nuevo equipo sin navegar por menús.",
        target: ".action-buttons"
    },
    {
        title: "📊 Total de Equipos",
        description: "Esta tarjeta azul muestra el número total de equipos registrados en el sistema. Incluye una tendencia que indica cuántos equipos nuevos se registraron este mes.",
        target: ".stat-card-primary"
    },
    {
        title: "🔧 Reparaciones en Proceso",
        description: "Esta tarjeta amarilla muestra cuántas reparaciones están actualmente en proceso. También indica cuántas están pendientes de iniciar.",
        target: ".stat-card-warning"
    },
    {
        title: "✅ Reparaciones Completadas",
        description: "Esta tarjeta verde muestra el número de reparaciones exitosamente completadas y la tasa de éxito en porcentaje.",
        target: ".stat-card-success"
    },
    {
        title: "🚨 Reparaciones Vencidas",
        description: "Esta tarjeta roja muestra las reparaciones que han superado su fecha límite y requieren atención inmediata del equipo técnico.",
        target: ".stat-card-danger"
    },
    {
        title: "📈 Gráfico de Estado de Equipos",
        description: "Este gráfico de líneas muestra la distribución actual de todos los equipos según su estado: recibidos, en reparación, completados, etc.",
        target: "#equiposEstadoChart"
    },
    {
        title: "🥧 Gráfico de Reparaciones por Mes",
        description: "Este gráfico circular te muestra la tendencia de reparaciones por mes, ayudándote a identificar patrones y planificar recursos.",
        target: "#reparacionesMesChart"
    },
    {
        title: "💻 Equipos Recientes",
        description: "Esta sección muestra los últimos 5 equipos registrados en el sistema, con información del cliente, modelo y estado actual.",
        target: "h5:contains('Equipos Recientes')"
    },
    {
        title: "⚠️ Reparaciones Urgentes",
        description: "Aquí se muestran las reparaciones que requieren atención inmediata, incluyendo cuántos días han transcurrido desde su registro.",
        target: "h5:contains('Reparaciones Urgentes')"
    },
    {
        title: "👥 Carga de Trabajo de Técnicos",
        description: "Esta sección muestra cómo está distribuida la carga de trabajo entre los técnicos, con barras de progreso que indican su nivel de ocupación.",
        target: "h5:contains('Carga de Trabajo')"
    },
    {
        title: "📋 Actividad Reciente",
        description: "Esta línea de tiempo muestra las últimas reparaciones completadas, con información del técnico responsable y cuándo se completó.",
        target: "h5:contains('Actividad Reciente')"
    }
];

function startSimpleTutorial() {
    document.getElementById('tutorialModal').style.display = 'block';
    currentTutorialStep = 0;
    showTutorialStep();
}

function showTutorialStep() {
    const step = tutorialSteps[currentTutorialStep];
    document.getElementById('tutorialTitle').textContent = step.title;
    document.getElementById('tutorialDescription').textContent = step.description;
    document.getElementById('tutorialStep').textContent = `${currentTutorialStep + 1} de ${tutorialSteps.length}`;
    
    // Remover highlight anterior
    document.querySelectorAll('.tutorial-highlight').forEach(el => {
        el.classList.remove('tutorial-highlight');
    });
    
    // Función para encontrar elementos por texto
    function findElementByText(text) {
        const elements = document.querySelectorAll('h5');
        for (let el of elements) {
            if (el.textContent.includes(text)) {
                return el.closest('.modern-card') || el.closest('.chart-card') || el;
            }
        }
        return null;
    }
    
    // Agregar highlight al elemento actual
    let targetElement = null;
    
    if (step.target.includes(':contains')) {
        const text = step.target.match(/:contains\('([^']+)'\)/)[1];
        targetElement = findElementByText(text);
    } else {
        targetElement = document.querySelector(step.target);
    }
    
    if (targetElement) {
        targetElement.classList.add('tutorial-highlight');
        targetElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Posicionar el modal cerca del elemento resaltado
        positionModalNearElement(targetElement);
    }
    
    // Mostrar/ocultar botones
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    if (currentTutorialStep === 0) {
        prevBtn.style.display = 'none';
    } else {
        prevBtn.style.display = 'inline-block';
    }
    
    if (currentTutorialStep === tutorialSteps.length - 1) {
        nextBtn.textContent = 'Finalizar';
    } else {
        nextBtn.textContent = 'Siguiente';
    }
}

function nextStep() {
    if (currentTutorialStep < tutorialSteps.length - 1) {
        currentTutorialStep++;
        showTutorialStep();
    } else {
        closeTutorial();
    }
}

function prevStep() {
    if (currentTutorialStep > 0) {
        currentTutorialStep--;
        showTutorialStep();
    }
}

function positionModalNearElement(element) {
    const modal = document.querySelector('.tutorial-content-simple');
    const elementRect = element.getBoundingClientRect();
    const modalRect = modal.getBoundingClientRect();
    const windowWidth = window.innerWidth;
    const windowHeight = window.innerHeight;
    
    // Dimensiones del modal
    const modalWidth = 400; // min-width del modal
    const modalHeight = 200; // altura estimada del modal
    const margin = 20; // margen mínimo del modal
    
    let top, left, arrowDirection;
    
    // Calcular posición horizontal
    if (elementRect.left + elementRect.width + modalWidth + margin < windowWidth) {
        // Espacio a la derecha del elemento
        left = elementRect.right + margin;
        arrowDirection = 'left';
    } else if (elementRect.left - modalWidth - margin > 0) {
        // Espacio a la izquierda del elemento
        left = elementRect.left - modalWidth - margin;
        arrowDirection = 'right';
    } else {
        // Centrar horizontalmente si no hay espacio
        left = (windowWidth - modalWidth) / 2;
        arrowDirection = 'up';
    }
    
    // Calcular posición vertical
    if (elementRect.top + modalHeight + margin < windowHeight) {
        // Espacio debajo del elemento
        top = elementRect.top;
        if (!arrowDirection || arrowDirection === 'up') arrowDirection = 'up';
    } else if (elementRect.bottom - modalHeight - margin > 0) {
        // Espacio arriba del elemento
        top = elementRect.bottom - modalHeight;
        if (!arrowDirection || arrowDirection === 'up') arrowDirection = 'down';
    } else {
        // Centrar verticalmente si no hay espacio
        top = (windowHeight - modalHeight) / 2;
        arrowDirection = 'up';
    }
    
    // Asegurar que el modal no se salga de la pantalla
    top = Math.max(margin, Math.min(top, windowHeight - modalHeight - margin));
    left = Math.max(margin, Math.min(left, windowWidth - modalWidth - margin));
    
    // Aplicar la posición
    modal.style.position = 'fixed';
    modal.style.top = top + 'px';
    modal.style.left = left + 'px';
    modal.style.transform = 'none';
    modal.style.transition = 'top 0.3s ease, left 0.3s ease';
    
    // Crear flecha apuntando al elemento
    createArrow(element, modal, arrowDirection);
}

function createArrow(element, modal, direction) {
    // Remover flecha anterior
    const existingArrow = document.querySelector('.tutorial-arrow');
    if (existingArrow) {
        existingArrow.remove();
    }
    
    const arrow = document.createElement('div');
    arrow.className = 'tutorial-arrow tutorial-arrow-' + direction;
    
    const elementRect = element.getBoundingClientRect();
    const modalRect = modal.getBoundingClientRect();
    
    // Posicionar la flecha según la dirección
    switch (direction) {
        case 'up':
            arrow.style.top = (modalRect.bottom - 5) + 'px';
            arrow.style.left = (modalRect.left + modalRect.width / 2 - 15) + 'px';
            break;
        case 'down':
            arrow.style.top = (modalRect.top - 20) + 'px';
            arrow.style.left = (modalRect.left + modalRect.width / 2 - 15) + 'px';
            break;
        case 'left':
            arrow.style.top = (modalRect.top + modalRect.height / 2 - 15) + 'px';
            arrow.style.left = (modalRect.right - 5) + 'px';
            break;
        case 'right':
            arrow.style.top = (modalRect.top + modalRect.height / 2 - 15) + 'px';
            arrow.style.left = (modalRect.left - 20) + 'px';
            break;
    }
    
    document.body.appendChild(arrow);
}

function closeTutorial() {
    document.getElementById('tutorialModal').style.display = 'none';
    document.querySelectorAll('.tutorial-highlight').forEach(el => {
        el.classList.remove('tutorial-highlight');
    });
    
    // Limpiar flecha
    const existingArrow = document.querySelector('.tutorial-arrow');
    if (existingArrow) {
        existingArrow.remove();
    }
    
    // Resetear posición del modal
    const modal = document.querySelector('.tutorial-content-simple');
    modal.style.position = 'absolute';
    modal.style.top = '50%';
    modal.style.left = '50%';
    modal.style.transform = 'translate(-50%, -50%)';
}

// Reemplazar la función del tutorial anterior
window.startDashboardTutorial = startSimpleTutorial;
</script>
@endsection

@section('tutorial-button')
<button class="tutorial-button" onclick="startDashboardTutorial()" id="tutorialBtn" style="display: none;">
    <i class="fas fa-graduation-cap"></i>
    <span>Tutorial</span>
</button>

<!-- Botón para reiniciar tutorial (solo para admins) -->
@if(auth()->user()->role === 'admin')
<button class="tutorial-button" onclick="resetTutorial()" id="resetTutorialBtn" style="display: none; top: 60%; background: #6b7280;">
    <i class="fas fa-redo"></i>
    <span>Reiniciar</span>
</button>
@endif
@endsection

@section('styles')
<style>
/* Header del Dashboard */
.dashboard-header {
    background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-secondary) 100%);
    color: #fff;
    padding: 2.5rem;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.dashboard-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    position: relative;
    z-index: 2;
}

.dashboard-subtitle {
    opacity: 0.9;
    margin: 0.5rem 0 1rem 0;
    font-size: 1.1rem;
    position: relative;
    z-index: 2;
}

.quick-stats {
    display: flex;
    gap: 2rem;
    position: relative;
    z-index: 2;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    opacity: 0.9;
}

.action-buttons {
    position: relative;
    z-index: 2;
}

.btn-modern {
    border-radius: 25px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Tarjetas de Estadísticas */
.stat-card {
    background: #fff;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12);
}

.stat-card-primary { border-left: 5px solid #17a2b8; }
.stat-card-warning { border-left: 5px solid #ffc107; }
.stat-card-success { border-left: 5px solid #28a745; }
.stat-card-danger { border-left: 5px solid #dc3545; }

.stat-card-icon {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    opacity: 0.1;
}

.stat-card-primary .stat-card-icon { background: #17a2b8; color: #17a2b8; }
.stat-card-warning .stat-card-icon { background: #ffc107; color: #ffc107; }
.stat-card-success .stat-card-icon { background: #28a745; color: #28a745; }
.stat-card-danger .stat-card-icon { background: #dc3545; color: #dc3545; }

.stat-card-content {
    flex: 1;
    z-index: 2;
    position: relative;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
    color: #2c3e50;
}

.stat-label {
    font-size: 1rem;
    color: #6c757d;
    margin: 0 0 1rem 0;
    font-weight: 500;
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    font-weight: 500;
}

.stat-card-chart {
    position: absolute;
    bottom: 0;
    right: 0;
    opacity: 0.3;
}

/* Tarjetas Modernas */
.modern-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
}

.modern-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.12);
}

.modern-card-header {
    padding: 1.5rem 1.5rem 0 1.5rem;
    border-bottom: 1px solid #f8f9fa;
}

.modern-card-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
    color: #2c3e50;
}

.modern-card-subtitle {
    font-size: 0.9rem;
    color: #6c757d;
    margin: 0.25rem 0 0 0;
}

.modern-card-body {
    padding: 1.5rem;
}

/* Listas Modernas */
.modern-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.modern-list-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.modern-list-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.urgent-item {
    border-left: 4px solid #ffc107;
    background: #fff8e1;
}

.list-item-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(23, 162, 184, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #17a2b8;
    font-size: 1.1rem;
}

.list-item-content {
    flex: 1;
}

.list-item-title {
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
    color: #2c3e50;
}

.list-item-subtitle {
    font-size: 0.9rem;
    color: #6c757d;
    margin: 0 0 0.25rem 0;
}

.list-item-meta {
    font-size: 0.8rem;
    color: #adb5bd;
}

.list-item-actions {
    text-align: right;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-recibido { background: #17a2b8; color: #fff; }
.status-en_reparacion { background: #ffc107; color: #212529; }
.status-reparado { background: #28a745; color: #fff; }
.status-entregado { background: #6f42c1; color: #fff; }

.urgency-badge {
    background: #dc3545;
    color: #fff;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

/* Estados Vacíos */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem auto;
    font-size: 2rem;
    color: #adb5bd;
}

.empty-state-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #495057;
    margin: 0 0 0.5rem 0;
}

.empty-state-text {
    color: #6c757d;
    margin: 0 0 1.5rem 0;
}

.success-state .empty-state-icon {
    background: #d4edda;
    color: #28a745;
}

/* Carga de Trabajo */
.workload-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.workload-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
}

.workload-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: #17a2b8;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.workload-content {
    flex: 1;
}

.workload-name {
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
    color: #2c3e50;
}

.workload-specialty {
    font-size: 0.9rem;
    color: #6c757d;
    margin: 0 0 0.75rem 0;
}

.workload-progress {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.progress-bar-container {
    flex: 1;
    height: 6px;
    background: #e9ecef;
    border-radius: 3px;
    overflow: hidden;
}

.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #17a2b8, #20c997);
    border-radius: 3px;
    transition: width 0.3s ease;
}

.workload-count {
    font-size: 0.9rem;
    font-weight: 600;
    color: #17a2b8;
    min-width: 60px;
    text-align: right;
}

/* Timeline de Actividad */
.activity-timeline {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    position: relative;
}

.activity-item::before {
    content: '';
    position: absolute;
    left: 2.5rem;
    top: 3rem;
    bottom: -1rem;
    width: 2px;
    background: #e9ecef;
}

.activity-item:last-child::before {
    display: none;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #d4edda;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #28a745;
    font-size: 1.1rem;
    position: relative;
    z-index: 2;
}

.activity-content {
    flex: 1;
}

.activity-title {
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
    color: #2c3e50;
}

.activity-description {
    font-size: 0.9rem;
    color: #6c757d;
    margin: 0 0 0.25rem 0;
}

.activity-meta {
    font-size: 0.8rem;
    color: #adb5bd;
}

/* Gráficos */
.chart-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.3s ease;
}

.chart-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.12);
}

.chart-header {
    padding: 1.5rem 1.5rem 0 1.5rem;
    display: flex;
    justify-content: between;
    align-items: center;
}

.chart-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
    color: #2c3e50;
}

.chart-actions {
    margin-left: auto;
}

.chart-body {
    padding: 1.5rem;
    position: relative;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-title {
        font-size: 2rem;
    }
    
    .quick-stats {
        flex-direction: column;
        gap: 1rem;
    }
    
    .action-buttons {
        margin-top: 1rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .modern-list-item,
    .workload-item,
    .activity-item {
        flex-direction: column;
        text-align: center;
    }
    
    .list-item-actions,
    .workload-progress {
        margin-top: 0.5rem;
    }
}
</style>
@endsection