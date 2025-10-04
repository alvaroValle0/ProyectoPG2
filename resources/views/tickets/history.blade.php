@extends('layouts.app')

@section('title', 'Historial de Tickets')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-history text-primary me-2"></i>
            Historial de Tickets
        </h1>
        <p class="text-muted">Registro completo de todas las acciones realizadas en los tickets</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver a Tickets
        </a>
    </div>
</div>

<!-- Estadísticas del Historial -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-primary text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-list-alt display-6 mb-2"></i>
                <h4>{{ number_format($estadisticas['total_acciones']) }}</h4>
                <p class="mb-0">Total Acciones</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-success text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-calendar-day display-6 mb-2"></i>
                <h4>{{ number_format($estadisticas['acciones_hoy']) }}</h4>
                <p class="mb-0">Hoy</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-warning text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-calendar-week display-6 mb-2"></i>
                <h4>{{ number_format($estadisticas['acciones_esta_semana']) }}</h4>
                <p class="mb-0">Esta Semana</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-info text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-calendar-alt display-6 mb-2"></i>
                <h4>{{ number_format($estadisticas['acciones_este_mes']) }}</h4>
                <p class="mb-0">Este Mes</p>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('tickets.historial.general') }}">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Buscar</label>
                    <input type="text" class="form-control" name="buscar" value="{{ request('buscar') }}" 
                           placeholder="Número ticket, usuario, descripción...">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Acción</label>
                    <select class="form-select" name="action">
                        <option value="">Todas las acciones</option>
                        <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Creado</option>
                        <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Actualizado</option>
                        <option value="status_changed" {{ request('action') == 'status_changed' ? 'selected' : '' }}>Estado Cambiado</option>
                        <option value="signed" {{ request('action') == 'signed' ? 'selected' : '' }}>Firmado</option>
                        <option value="delivered" {{ request('action') == 'delivered' ? 'selected' : '' }}>Entregado</option>
                        <option value="cancelled" {{ request('action') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                        <option value="printed" {{ request('action') == 'printed' ? 'selected' : '' }}>Impreso</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Fecha Inicio</label>
                    <input type="date" class="form-control" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Fecha Fin</label>
                    <input type="date" class="form-control" name="fecha_fin" value="{{ request('fecha_fin') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Filtrar
                        </button>
                        <a href="{{ route('tickets.historial.general') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Limpiar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Lista del Historial -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0">
        <h5 class="mb-0">
            <i class="fas fa-history text-primary me-2"></i>
            Registro de Acciones
        </h5>
    </div>
    <div class="card-body p-0">
        @if($historial->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha/Hora</th>
                            <th>Acción</th>
                            <th>Ticket</th>
                            <th>Usuario</th>
                            <th>Descripción</th>
                            <th>IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historial as $accion)
                            <tr>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">{{ $accion->created_at->format('d/m/Y') }}</span>
                                        <small class="text-muted">{{ $accion->created_at->format('H:i:s') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $accion->action_color }}">
                                        <i class="{{ $accion->action_icon }} me-1"></i>
                                        {{ $accion->action_label }}
                                    </span>
                                </td>
                                <td>
                                    @if($accion->ticket)
                                        <a href="{{ route('tickets.show', $accion->ticket) }}" class="text-decoration-none">
                                            {{ $accion->ticket->numero_ticket }}
                                        </a>
                                    @else
                                        <span class="text-muted">Ticket eliminado</span>
                                    @endif
                                </td>
                                <td>
                                    @if($accion->user)
                                        <div class="d-flex align-items-center">
                                            @if($accion->user->avatar_url)
                                                <img src="{{ $accion->user->avatar_url }}" alt="Avatar" class="rounded-circle me-2" width="24" height="24">
                                            @else
                                                <div class="bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                                    <i class="fas fa-user text-white" style="font-size: 10px;"></i>
                                                </div>
                                            @endif
                                            <span>{{ $accion->user->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">Usuario eliminado</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $accion->description }}">
                                        {{ $accion->description }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $accion->ip_address ?? 'N/A' }}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="card-footer bg-transparent border-0">
                {{ $historial->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-history display-1 text-muted mb-4"></i>
                <h4 class="text-muted">No hay registros en el historial</h4>
                <p class="text-muted">No se encontraron acciones que coincidan con los filtros aplicados.</p>
            </div>
        @endif
    </div>
</div>

<!-- Acciones Más Comunes -->
@if($acciones_comunes->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar text-info me-2"></i>
                    Acciones Más Comunes
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($acciones_comunes as $accion)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                <div>
                                    <span class="badge bg-{{ $accion->action === 'created' ? 'success' : ($accion->action === 'updated' ? 'primary' : 'secondary') }} me-2">
                                        {{ ucfirst($accion->action) }}
                                    </span>
                                    <span class="fw-bold">{{ $accion->total }}</span> acciones
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when filters change
    const form = document.querySelector('form[method="GET"]');
    const selects = form.querySelectorAll('select');
    
    selects.forEach(select => {
        select.addEventListener('change', function() {
            form.submit();
        });
    });
});
</script>
@endsection
