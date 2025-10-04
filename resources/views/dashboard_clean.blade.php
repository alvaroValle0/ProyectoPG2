@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Reparaciones')
@section('mobile-title', 'Dashboard')

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


<style>
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


