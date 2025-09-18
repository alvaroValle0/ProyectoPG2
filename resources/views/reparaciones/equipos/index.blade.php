@extends('layouts.app')

@section('title', 'Gestión de Equipos')

@section('content')
<div class="container-fluid">
    <div class="module-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="module-title">
                    <i class="fas fa-laptop text-gradient me-3"></i>
                    Gestión de Equipos
                </h1>
                <p class="module-subtitle">Lista completa de equipos registrados en el sistema</p>
            </div>
            <div class="col-lg-4 text-end">
                @if(\App\Helpers\PermissionHelper::can('create_equipo'))
                <a href="{{ route('equipos.create') }}" class="btn btn-primary btn-lg btn-modern">
                    <i class="fas fa-plus me-2"></i>Nuevo Equipo
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('equipos.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select">
                    <option value="">Todos los estados</option>
                    <option value="recibido" {{ request('estado') == 'recibido' ? 'selected' : '' }}>Recibido</option>
                    <option value="en_reparacion" {{ request('estado') == 'en_reparacion' ? 'selected' : '' }}>En Reparación</option>
                    <option value="reparado" {{ request('estado') == 'reparado' ? 'selected' : '' }}>Reparado</option>
                    <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Cliente</label>
                <input type="text" name="cliente" class="form-control" placeholder="Nombre del cliente" value="{{ request('cliente') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Número de Serie</label>
                <input type="text" name="numero_serie" class="form-control" placeholder="Serie" value="{{ request('numero_serie') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Fecha Desde</label>
                <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search me-2"></i>Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Estadísticas Principales -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-icon">
                <i class="fas fa-laptop"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $equipos->total() }}">0</h3>
                <p class="stat-card-label">Total Equipos</p>
                <div class="stat-card-trend">
                    <i class="fas fa-chart-line"></i>
                    <span>Inventario completo</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-icon">
                <i class="fas fa-wrench"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $equipos->where('estado', 'en_reparacion')->count() }}">0</h3>
                <p class="stat-card-label">En Reparación</p>
                <div class="stat-card-trend">
                    <i class="fas fa-percentage"></i>
                    <span>{{ $equipos->total() > 0 ? round(($equipos->where('estado', 'en_reparacion')->count() / $equipos->total()) * 100, 1) : 0 }}% del total</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-card-success">
            <div class="stat-card-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $equipos->where('estado', 'reparado')->count() }}">0</h3>
                <p class="stat-card-label">Reparados</p>
                <div class="stat-card-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ $equipos->total() > 0 ? round(($equipos->where('estado', 'reparado')->count() / $equipos->total()) * 100, 1) : 0 }}% completados</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-card-info">
            <div class="stat-card-icon">
                <i class="fas fa-handshake"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $equipos->where('estado', 'entregado')->count() }}">0</h3>
                <p class="stat-card-label">Entregados</p>
                <div class="stat-card-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ $equipos->total() > 0 ? round(($equipos->where('estado', 'entregado')->count() / $equipos->total()) * 100, 1) : 0 }}% entregados</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Equipos -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($equipos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover modern-table">
                    <thead>
                        <tr>
                            <th>Número de Serie</th>
                            <th>Equipo</th>
                            <th>Cliente</th>
                            <th>Fecha Ingreso</th>
                            <th>Estado</th>
                            <th>Técnico Asignado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipos as $equipo)
                        <tr>
                            <td>
                                <strong>{{ $equipo->numero_serie }}</strong>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $equipo->marca }} {{ $equipo->modelo }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $equipo->tipo_equipo }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $equipo->cliente_nombre }}</strong>
                                    @if($equipo->cliente_telefono)
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-phone me-1"></i>{{ $equipo->cliente_telefono }}
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $equipo->fecha_ingreso->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $equipo->estado_color }} text-white">
                                    {{ ucfirst(str_replace('_', ' ', $equipo->estado)) }}
                                </span>
                            </td>
                            <td>
                                @if($equipo->tecnico_asignado)
                                    <div>
                                        <strong>{{ $equipo->tecnico_asignado->nombre_completo }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $equipo->tecnico_asignado->especialidad }}</small>
                                    </div>
                                @else
                                    <small class="text-muted">Sin asignar</small>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('equipos.show', $equipo) }}" class="btn btn-outline-primary" title="Ver detalles" data-bs-toggle="tooltip">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(\App\Helpers\PermissionHelper::can('edit_equipo'))
                                    <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-outline-warning" title="Editar" data-bs-toggle="tooltip">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    @if(\App\Helpers\PermissionHelper::can('create_reparacion') && in_array($equipo->estado, ['recibido', 'en_reparacion']))
                                        <a href="{{ route('reparaciones.create', ['equipo_id' => $equipo->id]) }}" class="btn btn-outline-success" title="Nueva reparación" data-bs-toggle="tooltip">
                                            <i class="fas fa-wrench"></i>
                                        </a>
                                    @endif
                                    @if(\App\Helpers\PermissionHelper::can('delete_equipo'))
                                    <form action="{{ route('equipos.destroy', $equipo) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar el equipo {{ $equipo->marca }} {{ $equipo->modelo }} ({{ $equipo->numero_serie }})?\n\nEsta acción no se puede deshacer.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Eliminar equipo" data-bs-toggle="tooltip">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                {{ $equipos->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-laptop display-1 text-muted mb-4"></i>
                <h4 class="text-muted">No se encontraron equipos</h4>
                <p class="text-muted">No hay equipos que coincidan con los filtros aplicados.</p>
                <a href="{{ route('equipos.create') }}" class="btn btn-primary btn-custom">
                    <i class="fas fa-plus me-2"></i>Registrar Primer Equipo
                </a>
            </div>
        @endif
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
    --gradient-info: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
}

/* Module Header */
.module-header { 
    background: var(--system-gradient); 
    color: #fff; 
    padding: 2rem; 
    border-radius: 15px; 
    box-shadow: 0 10px 20px rgba(0,0,0,0.08); 
}

.module-title { 
    font-size: 2.25rem; 
    font-weight: 700; 
    margin: 0; 
}

.module-subtitle { 
    opacity: .9; 
    margin-top: .25rem; 
}

.btn-modern { 
    border-radius: 25px; 
    padding: .75rem 1.5rem; 
    font-weight: 600; 
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

/* Table Styles */
.modern-table thead th { 
    background: #f8fafc; 
    border: none; 
    text-transform: uppercase; 
    letter-spacing: .5px; 
}

.modern-table tbody tr:hover { 
    background: rgba(0,0,0,0.02); 
    transform: scale(1.005); 
}

.btn-outline-danger {
    transition: all 0.3s ease;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
    transform: scale(1.05);
}

.btn-group-sm > .btn {
    padding: 0.375rem 0.5rem;
    font-size: 0.875rem;
}

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

@media (max-width: 768px) {
    .btn-group-sm > .btn {
        padding: 0.25rem 0.375rem;
        font-size: 0.8rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .stat-card {
        padding: 1rem;
    }
    
    .stat-card-number {
        font-size: 2rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
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
            counter.textContent = Math.floor(current).toLocaleString();
        }, 16);
    });
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function () {
    // Inicializar tooltips Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Inicializar animación de contadores
    animateCounters();
    
    // Agregar efectos de hover a las tarjetas
    const cards = document.querySelectorAll('.stat-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Script para cambio rápido de estado
function cambiarEstado(equipoId, nuevoEstado) {
    if (confirm('¿Está seguro de cambiar el estado del equipo?')) {
        fetch(`/equipos/${equipoId}/cambiar-estado`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                estado: nuevoEstado
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al cambiar el estado: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cambiar el estado del equipo');
        });
    }
}

// El botón de eliminar ahora usa un formulario inline con confirmación nativa
</script>
@endsection