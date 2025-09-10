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

    <!-- Estadísticas Rápidas -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 bg-primary text-white h-100 kpi">
                <div class="card-body text-center">
                    <i class="fas fa-ticket-alt display-6 mb-2"></i>
                    <h4>{{ $estadisticas['total_tickets'] ?? 0 }}</h4>
                    <p class="mb-0">Total Tickets</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 bg-warning text-white h-100 kpi">
                <div class="card-body text-center">
                    <i class="fas fa-file-alt display-6 mb-2"></i>
                    <h4>{{ $estadisticas['tickets_generados'] ?? 0 }}</h4>
                    <p class="mb-0">Generados</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 bg-success text-white h-100 kpi">
                <div class="card-body text-center">
                    <i class="fas fa-signature display-6 mb-2"></i>
                    <h4>{{ $estadisticas['tickets_firmados'] ?? 0 }}</h4>
                    <p class="mb-0">Firmados</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 bg-info text-white h-100 kpi">
                <div class="card-body text-center">
                    <i class="fas fa-handshake display-6 mb-2"></i>
                    <h4>{{ $estadisticas['tickets_entregados'] ?? 0 }}</h4>
                    <p class="mb-0">Entregados</p>
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

@section('styles')
<style>
.module-header { background: var(--system-gradient); color: #fff; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.08); }
.module-title { font-size: 2.0rem; font-weight: 700; margin: 0; }
.module-subtitle { opacity: .9; margin-top: .25rem; }
.btn-modern { border-radius: 25px; padding: .6rem 1.2rem; font-weight: 600; }
.kpi { background-image: linear-gradient(135deg, rgba(255,255,255,0.08), rgba(0,0,0,0.08)); border-radius: 14px; }
.table-responsive { border-radius: 15px; overflow: hidden; }
.modern-table thead th { text-transform: uppercase; letter-spacing: .5px; }
</style>
@endsection


