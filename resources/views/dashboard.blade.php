@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Reparaciones')

@section('content')
<!-- Header del Dashboard -->
<div class="dashboard-header mb-4">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <h1 class="dashboard-title">
                <i class="fas fa-tachometer-alt text-gradient me-3"></i>
                Panel de Control
            </h1>
            <p class="dashboard-subtitle">Bienvenido al sistema de gestión de reparaciones</p>
        </div>
        <div class="col-lg-4 text-end">
            <div class="current-time">
                <i class="fas fa-clock me-2"></i>
                <span id="current-time">{{ now()->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas Principales con Animaciones -->
<div class="row mb-4">
    <!-- Total Equipos -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-icon">
                <i class="fas fa-laptop"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $estadisticas['equipos']['total'] }}">0</h3>
                <p class="stat-card-label">Total Equipos</p>
                <div class="stat-card-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ $estadisticas['equipos']['recibidos'] }} nuevos este mes</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Reparaciones en Proceso -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-icon">
                <i class="fas fa-wrench"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $estadisticas['reparaciones']['en_proceso'] }}">0</h3>
                <p class="stat-card-label">En Reparación</p>
                <div class="stat-card-trend">
                    <i class="fas fa-clock"></i>
                    <span>{{ $estadisticas['reparaciones']['pendientes'] }} pendientes</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Reparaciones Completadas -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card stat-card-success">
            <div class="stat-card-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $estadisticas['reparaciones']['completadas'] }}">0</h3>
                <p class="stat-card-label">Completadas</p>
                <div class="stat-card-trend">
                    <i class="fas fa-percentage"></i>
                    <span>{{ $estadisticas['reparaciones']['total'] > 0 ? round(($estadisticas['reparaciones']['completadas'] / $estadisticas['reparaciones']['total']) * 100, 1) : 0 }}% tasa éxito</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Reparaciones Vencidas -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card stat-card-danger">
            <div class="stat-card-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $estadisticas['reparaciones']['vencidas'] }}">0</h3>
                <p class="stat-card-label">Vencidas</p>
                <div class="stat-card-trend">
                    <i class="fas fa-calendar-times"></i>
                    <span>Requieren atención</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos y Contenido Principal -->
<div class="row mb-4">
    <!-- Gráfico de Equipos por Estado -->
    <div class="col-lg-8 mb-4">
        <div class="chart-card">
            <div class="chart-card-header">
                <h5><i class="fas fa-chart-pie text-primary me-2"></i>Distribución de Equipos por Estado</h5>
                <div class="chart-card-actions">
                    <button class="btn btn-sm btn-outline-primary" onclick="toggleChartType()">
                        <i class="fas fa-exchange-alt"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <canvas id="equiposChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Resumen de Técnicos -->
    <div class="col-lg-4 mb-4">
        <div class="info-card">
            <div class="info-card-header">
                <h5><i class="fas fa-users text-info me-2"></i>Resumen de Técnicos</h5>
            </div>
            <div class="info-card-body">
                <div class="tech-summary">
                    <div class="tech-stat">
                        <div class="tech-stat-number">{{ $estadisticas['tecnicos']['total'] }}</div>
                        <div class="tech-stat-label">Total Técnicos</div>
                    </div>
                    <div class="tech-stat">
                        <div class="tech-stat-number">{{ $estadisticas['tecnicos']['activos'] }}</div>
                        <div class="tech-stat-label">Activos</div>
                    </div>
                </div>
                <div class="tech-activity">
                    <h6>Actividad Reciente</h6>
                    <div class="activity-item">
                        <i class="fas fa-user-check text-success"></i>
                        <span>{{ $estadisticas['tecnicos']['activos'] }} técnicos trabajando</span>
                    </div>
                    <div class="activity-item">
                        <i class="fas fa-tasks text-primary"></i>
                        <span>{{ $estadisticas['reparaciones']['en_proceso'] }} reparaciones activas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contenido Secundario -->
<div class="row">
    <!-- Equipos Recientes -->
    <div class="col-lg-6 mb-4">
        <div class="content-card">
            <div class="content-card-header">
                <h5><i class="fas fa-laptop text-primary me-2"></i>Equipos Recientes</h5>
                <a href="{{ route('equipos.index') }}" class="btn btn-sm btn-outline-primary">
                    Ver todos <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="content-card-body">
                @if($equiposRecientes->count() > 0)
                    <div class="equipment-list">
                        @foreach($equiposRecientes->take(5) as $equipo)
                        <div class="equipment-item">
                            <div class="equipment-icon">
                                <i class="fas fa-laptop"></i>
                            </div>
                            <div class="equipment-details">
                                <h6 class="equipment-title">{{ $equipo->numero_serie }}</h6>
                                <p class="equipment-info">{{ $equipo->marca }} {{ $equipo->modelo }}</p>
                                <small class="equipment-client">{{ $equipo->cliente_nombre }}</small>
                            </div>
                            <div class="equipment-status">
                                <span class="status-badge status-{{ $equipo->estado }}">
                                    {{ ucfirst($equipo->estado) }}
                                </span>
                                <small class="equipment-date">{{ $equipo->fecha_ingreso->format('d/m/Y') }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-laptop"></i>
                        <h6>No hay equipos registrados</h6>
                        <p>Comienza registrando el primer equipo en el sistema</p>
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
        <div class="content-card">
            <div class="content-card-header">
                <h5><i class="fas fa-exclamation-triangle text-warning me-2"></i>Reparaciones Urgentes</h5>
                <a href="{{ route('reparaciones.index') }}?vencidas=1" class="btn btn-sm btn-outline-warning">
                    Ver todas <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="content-card-body">
                @if($reparacionesUrgentes->count() > 0)
                    <div class="urgent-list">
                        @foreach($reparacionesUrgentes->take(5) as $reparacion)
                        <div class="urgent-item">
                            <div class="urgent-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="urgent-details">
                                <h6 class="urgent-title">Reparación #{{ $reparacion->id }}</h6>
                                <p class="urgent-info">{{ $reparacion->equipo->numero_serie }}</p>
                                <small class="urgent-description">{{ Str::limit($reparacion->descripcion_problema, 50) }}</small>
                            </div>
                            <div class="urgent-status">
                                <span class="urgent-badge">
                                    {{ $reparacion->dias_transcurridos }} días
                                </span>
                                <small class="urgent-tech">{{ $reparacion->tecnico->nombre_completo ?? 'Sin asignar' }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state success">
                        <i class="fas fa-check-circle"></i>
                        <h6>¡Excelente!</h6>
                        <p>No hay reparaciones vencidas en este momento</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Actividad Reciente -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="content-card">
            <div class="content-card-header">
                <h5><i class="fas fa-history text-success me-2"></i>Actividad Reciente del Sistema</h5>
            </div>
            <div class="content-card-body">
                @if($actividadReciente->count() > 0)
                    <div class="activity-timeline">
                        @foreach($actividadReciente as $reparacion)
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Reparación completada</h6>
                                <p class="timeline-description">
                                    {{ $reparacion->equipo->numero_serie }} - {{ $reparacion->equipo->cliente_nombre }}
                                </p>
                                <div class="timeline-meta">
                                    <span class="timeline-author">
                                        <i class="fas fa-user me-1"></i>
                                        {{ $reparacion->tecnico->nombre_completo }}
                                    </span>
                                    <span class="timeline-time">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $reparacion->updated_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-clock"></i>
                        <h6>No hay actividad reciente</h6>
                        <p>El sistema está esperando nuevas actividades</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Variables CSS */
:root {
    --primary-color: #4f46e5;
    --primary-light: #6366f1;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --info-color: #06b6d4;
    --dark-color: #1f2937;
    --light-color: #f8fafc;
    --border-color: #e5e7eb;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --gradient-success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --gradient-warning: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --gradient-danger: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
}

/* Dashboard Header */
.dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: var(--shadow-lg);
}

.dashboard-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.dashboard-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0.5rem 0 0 0;
}

.current-time {
    background: rgba(255,255,255,0.2);
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    backdrop-filter: blur(10px);
    font-size: 1.1rem;
    font-weight: 500;
}

/* Stat Cards */
.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: var(--shadow-md);
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.stat-card-primary::before { background: var(--gradient-primary); }
.stat-card-success::before { background: var(--gradient-success); }
.stat-card-warning::before { background: var(--gradient-warning); }
.stat-card-danger::before { background: var(--gradient-danger); }

.stat-card-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
    background: var(--gradient-primary);
    color: white;
}

.stat-card-primary .stat-card-icon { background: var(--gradient-primary); }
.stat-card-success .stat-card-icon { background: var(--gradient-success); }
.stat-card-warning .stat-card-icon { background: var(--gradient-warning); }
.stat-card-danger .stat-card-icon { background: var(--gradient-danger); }

.stat-card-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    color: var(--dark-color);
}

.stat-card-label {
    font-size: 1rem;
    color: #6b7280;
    margin: 0.5rem 0;
    font-weight: 500;
}

.stat-card-trend {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--success-color);
}

/* Chart Card */
.chart-card {
    background: white;
    border-radius: 15px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.chart-card-header {
    background: var(--light-color);
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chart-card-header h5 {
    margin: 0;
    font-weight: 600;
    color: var(--dark-color);
}

.chart-card-body {
    padding: 1.5rem;
}

/* Info Card */
.info-card {
    background: white;
    border-radius: 15px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.info-card-header {
    background: var(--light-color);
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.info-card-header h5 {
    margin: 0;
    font-weight: 600;
    color: var(--dark-color);
}

.info-card-body {
    padding: 1.5rem;
}

.tech-summary {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.tech-stat {
    text-align: center;
    padding: 1rem;
    background: var(--light-color);
    border-radius: 10px;
}

.tech-stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
}

.tech-stat-label {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

.tech-activity h6 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--dark-color);
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-color);
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-item i {
    width: 20px;
    text-align: center;
}

/* Content Cards */
.content-card {
    background: white;
    border-radius: 15px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.content-card-header {
    background: var(--light-color);
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.content-card-header h5 {
    margin: 0;
    font-weight: 600;
    color: var(--dark-color);
}

.content-card-body {
    padding: 1.5rem;
}

/* Equipment List */
.equipment-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.equipment-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--light-color);
    border-radius: 10px;
    transition: all 0.2s ease;
}

.equipment-item:hover {
    background: #e5e7eb;
    transform: translateX(5px);
}

.equipment-icon {
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    color: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.equipment-details {
    flex: 1;
}

.equipment-title {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark-color);
}

.equipment-info {
    margin: 0.25rem 0;
    color: #6b7280;
    font-size: 0.875rem;
}

.equipment-client {
    color: var(--primary-color);
    font-size: 0.75rem;
    font-weight: 500;
}

.equipment-status {
    text-align: right;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 0.5rem;
}

.status-recibido { background: #dbeafe; color: #1e40af; }
.status-en_reparacion { background: #fef3c7; color: #d97706; }
.status-reparado { background: #d1fae5; color: #059669; }
.status-entregado { background: #e0e7ff; color: #7c3aed; }

.equipment-date {
    display: block;
    color: #9ca3af;
    font-size: 0.75rem;
}

/* Urgent List */
.urgent-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.urgent-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #fef2f2;
    border-radius: 10px;
    border-left: 4px solid var(--danger-color);
    transition: all 0.2s ease;
}

.urgent-item:hover {
    background: #fee2e2;
    transform: translateX(5px);
}

.urgent-icon {
    width: 40px;
    height: 40px;
    background: var(--danger-color);
    color: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.urgent-details {
    flex: 1;
}

.urgent-title {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark-color);
}

.urgent-info {
    margin: 0.25rem 0;
    color: #6b7280;
    font-size: 0.875rem;
}

.urgent-description {
    color: #dc2626;
    font-size: 0.75rem;
}

.urgent-status {
    text-align: right;
}

.urgent-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    background: var(--danger-color);
    color: white;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.urgent-tech {
    display: block;
    color: #9ca3af;
    font-size: 0.75rem;
}

/* Activity Timeline */
.activity-timeline {
    position: relative;
}

.activity-timeline::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--border-color);
}

.timeline-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
    position: relative;
}

.timeline-icon {
    width: 40px;
    height: 40px;
    background: var(--success-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1;
    flex-shrink: 0;
}

.timeline-content {
    flex: 1;
    background: var(--light-color);
    padding: 1rem;
    border-radius: 10px;
    border-left: 3px solid var(--success-color);
}

.timeline-title {
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark-color);
}

.timeline-description {
    margin: 0 0 0.75rem 0;
    color: #6b7280;
    font-size: 0.875rem;
}

.timeline-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.75rem;
    color: #9ca3af;
}

.timeline-author, .timeline-time {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* Empty States */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: #9ca3af;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h6 {
    margin: 0 0 0.5rem 0;
    color: #6b7280;
    font-weight: 600;
}

.empty-state p {
    margin: 0 0 1.5rem 0;
    font-size: 0.875rem;
}

.empty-state.success {
    color: var(--success-color);
}

.empty-state.success i {
    color: var(--success-color);
    opacity: 1;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-header {
        padding: 1.5rem;
    }
    
    .dashboard-title {
        font-size: 2rem;
    }
    
    .stat-card {
        padding: 1rem;
    }
    
    .stat-card-number {
        font-size: 2rem;
    }
    
    .content-card-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .tech-summary {
        grid-template-columns: 1fr;
    }
}

/* Animaciones */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card, .chart-card, .info-card, .content-card {
    animation: fadeInUp 0.6s ease-out;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }

/* Hover Effects */
.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Actualizar tiempo en tiempo real
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleDateString('es-ES') + ' ' + now.toLocaleTimeString('es-ES');
    document.getElementById('current-time').textContent = timeString;
}

setInterval(updateTime, 1000);

// Animación de contadores
function animateCounters() {
    const counters = document.querySelectorAll('.stat-card-number');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = Math.floor(current);
        }, 16);
    });
}

// Gráfico de equipos por estado
let chartType = 'doughnut';
let equiposChart;

function initChart() {
    const ctx = document.getElementById('equiposChart').getContext('2d');
    
    const data = {
        labels: ['Recibidos', 'En Reparación', 'Reparados', 'Entregados'],
        datasets: [{
            data: [
                {{ $estadisticas['equipos']['recibidos'] }},
                {{ $estadisticas['equipos']['en_reparacion'] }},
                {{ $estadisticas['equipos']['reparados'] }},
                {{ $estadisticas['equipos']['entregados'] }}
            ],
            backgroundColor: [
                '#3b82f6',
                '#f59e0b',
                '#10b981',
                '#8b5cf6'
            ],
            borderColor: [
                '#1d4ed8',
                '#d97706',
                '#059669',
                '#7c3aed'
            ],
            borderWidth: 2
        }]
    };
    
    const config = {
        type: chartType,
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                }
            },
            elements: {
                arc: {
                    borderWidth: 2
                }
            }
        }
    };
    
    if (equiposChart) {
        equiposChart.destroy();
    }
    
    equiposChart = new Chart(ctx, config);
}

function toggleChartType() {
    chartType = chartType === 'doughnut' ? 'pie' : 'doughnut';
    initChart();
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    animateCounters();
    initChart();
    
    // Agregar efectos de hover a las tarjetas
    const cards = document.querySelectorAll('.stat-card, .content-card, .chart-card, .info-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Efectos de scroll suave
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>
@endsection