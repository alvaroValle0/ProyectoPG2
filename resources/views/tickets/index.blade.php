@extends('layouts.app')

@section('title', 'Gestión de Tickets')

@section('content')
<div class="container-fluid">
    <!-- Header del Módulo -->
    <div class="module-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="module-title">
                    <i class="fas fa-ticket-alt text-gradient me-3"></i>
                    Gestión de Tickets
                </h1>
                <p class="module-subtitle">Lista completa de tickets generados en el sistema</p>
            </div>
            <div class="col-lg-4 text-end">
                <a href="{{ route('tickets.create') }}" class="btn btn-light btn-modern" data-bs-toggle="tooltip" title="Crear un nuevo ticket">
                    <i class="fas fa-plus me-2"></i>Nuevo Ticket
                </a>
            </div>
        </div>
    </div>

    <!-- Estadísticas Principales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-card-primary">
                <div class="stat-card-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-number" data-count="{{ $estadisticas['total_tickets'] ?? 0 }}">0</h3>
                    <p class="stat-card-label">Total Tickets</p>
                    <div class="stat-card-trend">
                        <i class="fas fa-chart-line"></i>
                        <span>Base de datos completa</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-card-warning">
                <div class="stat-card-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-number" data-count="{{ $estadisticas['tickets_generados'] ?? 0 }}">0</h3>
                    <p class="stat-card-label">Generados</p>
                    <div class="stat-card-trend">
                        <i class="fas fa-percentage"></i>
                        <span>{{ ($estadisticas['total_tickets'] ?? 0) > 0 ? round((($estadisticas['tickets_generados'] ?? 0) / ($estadisticas['total_tickets'] ?? 1)) * 100, 1) : 0 }}% del total</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-card-success">
                <div class="stat-card-icon">
                    <i class="fas fa-signature"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-number" data-count="{{ $estadisticas['tickets_firmados'] ?? 0 }}">0</h3>
                    <p class="stat-card-label">Firmados</p>
                    <div class="stat-card-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>{{ ($estadisticas['total_tickets'] ?? 0) > 0 ? round((($estadisticas['tickets_firmados'] ?? 0) / ($estadisticas['total_tickets'] ?? 1)) * 100, 1) : 0 }}% firmados</span>
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
                    <h3 class="stat-card-number" data-count="{{ $estadisticas['tickets_entregados'] ?? 0 }}">0</h3>
                    <p class="stat-card-label">Entregados</p>
                    <div class="stat-card-trend">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ ($estadisticas['total_tickets'] ?? 0) > 0 ? round((($estadisticas['tickets_entregados'] ?? 0) / ($estadisticas['total_tickets'] ?? 1)) * 100, 1) : 0 }}% entregados</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Tickets -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if(($tickets ?? collect())->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover modern-table">
                        <thead class="table-dark sticky-top" style="z-index: 1;">
                            <tr>
                                <th>Número</th>
                                <th>Tipo</th>
                                <th>Cliente</th>
                                <th>Equipo</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                            <tr>
                                <td><strong>{{ $ticket->numero_ticket ?? '#'.$ticket->id }}</strong></td>
                                <td>
                                    <span class="badge bg-secondary">{{ $ticket->tipo_ticket_label ?? ucfirst($ticket->tipo_ticket) }}</span>
                                </td>
                                <td>{{ $ticket->reparacion->equipo->cliente->nombre_completo ?? 'N/A' }}</td>
                                <td>{{ $ticket->reparacion->equipo->marca ?? '' }} {{ $ticket->reparacion->equipo->modelo ?? '' }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $ticket->estado_label ?? ucfirst($ticket->estado) }}</span>
                                </td>
                                <td>{{ $ticket->fecha_generacion ? $ticket->fecha_generacion->format('d/m/Y') : 'N/A' }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h"></i> Acciones
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end w-100">
                                            <li><a class="dropdown-item" href="{{ route('tickets.show', $ticket) }}"><i class="fas fa-eye me-2"></i>Ver</a></li>
                                            <li><a class="dropdown-item" href="{{ route('tickets.edit', $ticket) }}"><i class="fas fa-edit me-2"></i>Editar</a></li>
                                            <li><a class="dropdown-item" href="{{ route('tickets.imprimir', $ticket) }}"><i class="fas fa-print me-2"></i>Imprimir</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if(method_exists($tickets, 'links'))
                    <div class="d-flex justify-content-center mt-4">
                        {{ $tickets->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-ticket-alt display-1 text-muted mb-4"></i>
                    <h4 class="text-muted">No hay tickets registrados</h4>
                    <p class="text-muted">Comienza generando tu primer ticket.</p>
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Crear Primer Ticket
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
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

/* Module Header */
.module-header { 
    background: var(--system-gradient); 
    color: #fff; 
    padding: 2rem; 
    border-radius: 15px; 
    box-shadow: 0 10px 20px rgba(0,0,0,0.08); 
}

.module-title { 
    font-size: 2.0rem; 
    font-weight: 700; 
    margin: 0; 
}

.module-subtitle { 
    opacity: .9; 
    margin-top: .25rem; 
}

.btn-modern { 
    border-radius: 25px; 
    padding: .6rem 1.2rem; 
    font-weight: 600; 
}

.kpi { 
    background-image: linear-gradient(135deg, rgba(255,255,255,0.08), rgba(0,0,0,0.08)); 
    border-radius: 14px; 
}

.table-responsive { 
    border-radius: 15px; 
    overflow: hidden; 
}

.modern-table thead th { 
    text-transform: uppercase; 
    letter-spacing: .5px; 
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

/* Responsive */
@media (max-width: 768px) {
    .stat-card {
        padding: 1rem;
    }
    
    .stat-card-number {
        font-size: 2rem;
    }
}
</style>
@endsection


