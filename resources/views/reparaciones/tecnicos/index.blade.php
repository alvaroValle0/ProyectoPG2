@extends('layouts.app')

@section('title', 'Gestión de Técnicos')

@section('content')
<div class="container-fluid">
    <div class="module-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="module-title">
                    <i class="fas fa-users-cog text-gradient me-3"></i>
                    Gestión de Técnicos
                </h1>
                <p class="module-subtitle">Administra el equipo de técnicos especializados</p>
            </div>
            <div class="col-lg-4 text-end">
                <a href="{{ route('tecnicos.create') }}" class="btn btn-light btn-modern" data-bs-toggle="tooltip" title="Registrar nuevo técnico">
                    <i class="fas fa-user-plus me-2"></i>Nuevo Técnico
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas Principales -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $tecnicos->total() }}">0</h3>
                <p class="stat-card-label">Total Técnicos</p>
                <div class="stat-card-trend">
                    <i class="fas fa-chart-line"></i>
                    <span>Base de datos completa</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-card-success">
            <div class="stat-card-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $tecnicos->where('activo', true)->count() }}">0</h3>
                <p class="stat-card-label">Activos</p>
                <div class="stat-card-trend">
                    <i class="fas fa-percentage"></i>
                    <span>{{ $tecnicos->total() > 0 ? round(($tecnicos->where('activo', true)->count() / $tecnicos->total()) * 100, 1) : 0 }}% del total</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-icon">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $tecnicos->sum(function($t) { return $t->reparacionesActivas ? $t->reparacionesActivas->count() : 0; }) }}">0</h3>
                <p class="stat-card-label">Tareas Activas</p>
                <div class="stat-card-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>En proceso de trabajo</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-card-info">
            <div class="stat-card-icon">
                <i class="fas fa-tools"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $tecnicos->where('activo', false)->count() }}">0</h3>
                <p class="stat-card-label">Inactivos</p>
                <div class="stat-card-trend">
                    <i class="fas fa-pause-circle"></i>
                    <span>{{ $tecnicos->total() > 0 ? round(($tecnicos->where('activo', false)->count() / $tecnicos->total()) * 100, 1) : 0 }}% inactivos</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Técnicos -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($tecnicos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover modern-table">
                    <thead class="table-dark sticky-top" style="z-index: 1;">
                        <tr>
                            <th>Técnico</th>
                            <th>Especialidad</th>
                            <th>Estado</th>
                            <th>Carga de Trabajo</th>
                            <th>Estadísticas</th>
                            <th>Fecha Registro</th>
                            <th width="150px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tecnicos as $tecnico)
                        <tr>
                            <!-- Información del Técnico -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $tecnico->nombre_completo }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $tecnico->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Especialidad -->
                            <td>
                                <span class="badge bg-light text-dark fs-6">
                                    <i class="fas fa-cog me-1"></i>{{ $tecnico->especialidad }}
                                </span>
                                @if($tecnico->descripcion)
                                    <br>
                                    <small class="text-muted">{{ Str::limit($tecnico->descripcion, 50) }}</small>
                                @endif
                            </td>
                            
                            <!-- Estado -->
                            <td>
                                @if($tecnico->activo)
                                    <span class="badge bg-success text-white fs-6">
                                        <span class="status-dot me-1"></span>
                                        <i class="fas fa-check-circle me-1"></i>Activo
                                    </span>
                                @else
                                    <span class="badge bg-danger text-white fs-6">
                                        <span class="status-dot me-1"></span>
                                        <i class="fas fa-times-circle me-1"></i>Inactivo
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Carga de Trabajo -->
                            <td>
                                @php
                                    $carga = $tecnico->reparacionesActivas ? $tecnico->reparacionesActivas->count() : 0;
                                    $maxCarga = 10; // Carga máxima recomendada
                                    $porcentaje = min(($carga / $maxCarga) * 100, 100);
                                    $colorCarga = $porcentaje > 80 ? 'danger' : ($porcentaje > 50 ? 'warning' : 'success');
                                @endphp
                                <div>
                                    <strong class="text-{{ $colorCarga }}">{{ $carga }} tareas</strong>
                                    <div class="progress mt-1" style="height: 8px;">
                                        <div class="progress-bar bg-{{ $colorCarga }}" 
                                             style="width: {{ $porcentaje }}%"></div>
                                    </div>
                                    <small class="text-muted">{{ round($porcentaje, 1) }}% capacidad</small>
                                </div>
                            </td>
                            
                            <!-- Estadísticas -->
                            <td>
                                <div>
                                    <strong class="text-success">{{ $tecnico->reparaciones_completadas_count ?? 0 }}</strong> completadas
                                    <br>
                                    <small class="text-muted">
                                        @if($tecnico->promedio_tiempo_reparacion)
                                            Promedio: {{ round($tecnico->promedio_tiempo_reparacion, 1) }}h
                                        @else
                                            Sin promedio aún
                                        @endif
                                    </small>
                                </div>
                            </td>
                            
                            <!-- Fecha Registro -->
                            <td>
                                <div>
                                    <strong>{{ $tecnico->created_at->format('d/m/Y') }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $tecnico->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                            
                            <!-- Acciones -->
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('tecnicos.show', $tecnico) }}" 
                                       class="btn btn-sm btn-action btn-info" 
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('tecnicos.edit', $tecnico) }}" 
                                       class="btn btn-sm btn-action btn-warning" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($tecnico->activo)
                                        <button type="button" 
                                                class="btn btn-sm btn-action btn-secondary" 
                                                onclick="cambiarEstado({{ $tecnico->id }}, false)"
                                                title="Desactivar">
                                            <i class="fas fa-user-times"></i>
                                        </button>
                                    @else
                                        <button type="button" 
                                                class="btn btn-sm btn-action btn-success" 
                                                onclick="cambiarEstado({{ $tecnico->id }}, true)"
                                                title="Activar">
                                            <i class="fas fa-user-check"></i>
                                        </button>
                                    @endif
                                    <form action="{{ route('tecnicos.destroy', $tecnico) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-action btn-danger" 
                                                onclick="return confirm('¿Eliminar al técnico {{ $tecnico->nombre_completo }}? Esta acción es irreversible.')"
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                {{ $tecnicos->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users-cog display-1 text-muted mb-4"></i>
                <h4 class="text-muted">No hay técnicos registrados</h4>
                <p class="text-muted">Registra el primer técnico para comenzar a gestionar reparaciones.</p>
                <a href="{{ route('tecnicos.create') }}" class="btn btn-primary btn-custom">
                    <i class="fas fa-user-plus me-2"></i>Registrar Primer Técnico
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Acciones Rápidas -->
<div class="row mt-4">
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
                        <a href="{{ route('tecnicos.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-user-plus me-2"></i>Nuevo Técnico
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('tecnicos.carga-trabajo') }}" class="btn btn-info w-100">
                            <i class="fas fa-chart-bar me-2"></i>Carga de Trabajo
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="button" class="btn btn-outline-secondary w-100" onclick="mostrarProximamente('Reportes de Técnicos')">
                            <i class="fas fa-chart-line me-2"></i>Reportes
                        </button>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="button" class="btn btn-outline-secondary w-100" onclick="mostrarProximamente('Exportar Datos')">
                            <i class="fas fa-download me-2"></i>Exportar
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
function cambiarEstado(tecnicoId, activar) {
    const accion = activar ? 'activar' : 'desactivar';
    const texto = activar ? 'activar' : 'desactivar';
    
    if (confirm(`¿Está seguro de ${texto} este técnico?`)) {
        const url = `/tecnicos/${tecnicoId}/${accion}`;
        
        fetch(url, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cambiar el estado del técnico');
        });
    }
}

// Actualización automática de la página cada 30 segundos para refrescar carga de trabajo
setInterval(() => {
    // Solo si no hay modales abiertos
    if (!document.querySelector('.modal.show')) {
        location.reload();
    }
}, 30000);

// Animación de contadores para las tarjetas de estadísticas
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.stat-card-number');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        const duration = 2000; // 2 segundos
        const increment = target / (duration / 16); // 60 FPS
        let current = 0;
        
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };
        
        // Iniciar animación cuando la tarjeta sea visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        observer.observe(counter);
    });
});
</script>
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
    --secondary-color: #6b7280;
    --dark-color: #1f2937;
    --light-color: #f8fafc;
    --border-color: #e5e7eb;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --gradient-success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --gradient-warning: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --gradient-info: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    --gradient-danger: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    --gradient-secondary: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
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
    background: var(--system-gradient);
}

.stat-card-primary::before { background: var(--gradient-primary); }
.stat-card-success::before { background: var(--gradient-success); }
.stat-card-warning::before { background: var(--gradient-warning); }
.stat-card-info::before { background: var(--gradient-info); }
.stat-card-danger::before { background: var(--gradient-danger); }
.stat-card-secondary::before { background: var(--gradient-secondary); }

.stat-card-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
    background: var(--system-gradient);
    color: white;
}

.stat-card-primary .stat-card-icon { background: var(--gradient-primary); }
.stat-card-success .stat-card-icon { background: var(--gradient-success); }
.stat-card-warning .stat-card-icon { background: var(--gradient-warning); }
.stat-card-info .stat-card-icon { background: var(--gradient-info); }
.stat-card-danger .stat-card-icon { background: var(--gradient-danger); }
.stat-card-secondary .stat-card-icon { background: var(--gradient-secondary); }

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

.stat-card {
    animation: fadeInUp 0.6s ease-out;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }

/* Responsive para stat cards */
@media (max-width: 768px) {
    .stat-card {
        padding: 1rem;
    }
    
    .stat-card-number {
        font-size: 2rem;
    }
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}
.btn-action {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    border: none;
}
.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.12);
}
.btn-info { background: #06b6d4; color: #fff; }
.btn-warning { background: #f59e0b; color: #fff; }
.btn-success { background: #10b981; color: #fff; }
.btn-secondary { background: #6b7280; color: #fff; }
.btn-danger { background: #ef4444; color: #fff; }
.module-header {
    background: var(--system-gradient);
    color: #fff;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
}
.module-title { font-size: 2.0rem; font-weight: 700; margin: 0; }
.module-subtitle { opacity: .9; margin-top: .25rem; }
.btn-modern { border-radius: 25px; padding: .6rem 1.2rem; font-weight: 600; }

.table-responsive {
    border-radius: 15px;
    overflow: hidden;
}

.table th {
    border: none;
    padding: 1rem 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table td {
    padding: 1rem 0.75rem;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
}

.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.progress {
    background-color: rgba(0, 0, 0, 0.1);
}

.badge {
    font-size: 0.75rem;
    padding: 0.35rem 0.65rem;
}

.btn-group-sm > .btn {
    padding: 0.375rem 0.5rem;
    font-size: 0.875rem;
}

/* Indicador tipo dot */
.status-dot { display:inline-block; width:10px; height:10px; border-radius:50%; background: currentColor; }

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group-sm > .btn {
        padding: 0.25rem 0.375rem;
        font-size: 0.8rem;
    }
}
</style>
@endsection