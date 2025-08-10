@extends('layouts.app')

@section('title', 'Cliente: ' . $cliente->nombre_completo)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-user text-primary me-2"></i>
                {{ $cliente->nombre_completo }}
            </h1>
            <p class="text-muted mb-0">Información detallada del cliente</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Información Principal del Cliente -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-user me-2"></i>
                        Información Personal
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Avatar y nombre -->
                    <div class="text-center mb-4">
                        <div class="avatar-lg d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white fw-bold mb-3"
                             style="width: 80px; height: 80px; font-size: 2rem;">
                            {{ $cliente->getIniciales() }}
                        </div>
                        <h5 class="mb-1">{{ $cliente->nombre_completo }}</h5>
                        <span class="badge bg-{{ $cliente->estado_color }} fs-6">
                            {{ $cliente->estado_label }}
                        </span>
                    </div>

                    <!-- Información básica -->
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-muted mb-1">Nombres:</label>
                            <p class="fw-semibold mb-0">{{ $cliente->nombres }}</p>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted mb-1">Apellidos:</label>
                            <p class="fw-semibold mb-0">{{ $cliente->apellidos }}</p>
                        </div>
                        @if($cliente->dpi)
                        <div class="col-12">
                            <label class="form-label text-muted mb-1">DPI:</label>
                            <p class="fw-semibold mb-0">
                                <i class="fas fa-id-card text-info me-2"></i>
                                {{ $cliente->dpi }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-address-book me-2"></i>
                        Contacto
                    </h6>
                </div>
                <div class="card-body">
                    @if($cliente->telefono)
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Teléfono:</label>
                        <p class="fw-semibold mb-0">
                            <i class="fas fa-phone text-success me-2"></i>
                            <a href="tel:{{ $cliente->telefono }}" class="text-decoration-none">
                                {{ $cliente->telefono }}
                            </a>
                        </p>
                    </div>
                    @endif

                    @if($cliente->email)
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Email:</label>
                        <p class="fw-semibold mb-0">
                            <i class="fas fa-envelope text-info me-2"></i>
                            <a href="mailto:{{ $cliente->email }}" class="text-decoration-none">
                                {{ $cliente->email }}
                            </a>
                        </p>
                    </div>
                    @endif

                    @if($cliente->direccion)
                    <div class="mb-0">
                        <label class="form-label text-muted mb-1">Dirección:</label>
                        <p class="fw-semibold mb-0">
                            <i class="fas fa-map-marker-alt text-warning me-2"></i>
                            {{ $cliente->direccion }}
                        </p>
                    </div>
                    @endif

                    @if(!$cliente->telefono && !$cliente->email && !$cliente->direccion)
                    <div class="text-center text-muted">
                        <i class="fas fa-info-circle mb-2"></i>
                        <p class="mb-0">Sin información de contacto registrada</p>
                    </div>
                    @endif
                </div>
            </div>

            @if($cliente->observaciones)
            <!-- Observaciones -->
            <div class="card shadow mb-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-sticky-note me-2"></i>
                        Observaciones
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0 text-muted">{{ $cliente->observaciones }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Estadísticas y Actividades -->
        <div class="col-xl-8 col-lg-7">
            <!-- Estadísticas -->
            <div class="row mb-4">
                <div class="col-sm-6 col-xl-3 mb-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Reparaciones
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $estadisticas['total_reparaciones'] }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tools fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3 mb-3">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pendientes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $estadisticas['reparaciones_pendientes'] }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3 mb-3">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Equipos
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $estadisticas['total_equipos'] }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-laptop fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3 mb-3">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Cliente desde
                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        {{ $cliente->created_at->format('M Y') }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Última Reparación -->
            @if($estadisticas['ultima_reparacion'])
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-clock me-2"></i>
                        Última Reparación
                    </h6>
                </div>
                <div class="card-body">
                    @php $ultimaReparacion = $estadisticas['ultima_reparacion']; @endphp
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h6 class="mb-1">Reparación #{{ $ultimaReparacion->id }}</h6>
                            <p class="text-muted mb-1">
                                <strong>Equipo:</strong> {{ $ultimaReparacion->equipo->marca ?? 'N/A' }} {{ $ultimaReparacion->equipo->modelo ?? '' }}
                            </p>
                            <p class="text-muted mb-0">
                                <strong>Problema:</strong> {{ Str::limit($ultimaReparacion->problema_reportado, 50) }}
                            </p>
                        </div>
                        <div class="col-md-3 text-center">
                            <span class="badge bg-{{ $ultimaReparacion->estado === 'entregado' ? 'success' : 'warning' }} fs-6">
                                {{ ucfirst($ultimaReparacion->estado) }}
                            </span>
                        </div>
                        <div class="col-md-3 text-end">
                            <small class="text-muted">{{ $ultimaReparacion->created_at->diffForHumans() }}</small>
                            <br>
                            <a href="{{ route('reparaciones.show', $ultimaReparacion) }}" class="btn btn-sm btn-outline-primary">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Reparaciones Recientes -->
            @if($cliente->reparaciones->count() > 0)
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Historial de Reparaciones
                        <span class="badge bg-primary ms-2">{{ $cliente->reparaciones->count() }}</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Equipo</th>
                                    <th>Problema</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cliente->reparaciones->take(5) as $reparacion)
                                <tr>
                                    <td>{{ $reparacion->id }}</td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $reparacion->equipo->marca ?? 'N/A' }} {{ $reparacion->equipo->modelo ?? '' }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>{{ Str::limit($reparacion->problema_reportado, 30) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $reparacion->estado === 'entregado' ? 'success' : 'warning' }}">
                                            {{ ucfirst($reparacion->estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $reparacion->created_at->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('reparaciones.show', $reparacion) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($cliente->reparaciones->count() > 5)
                    <div class="text-center mt-3">
                        <a href="{{ route('reparaciones.index', ['cliente' => $cliente->id]) }}" 
                           class="btn btn-outline-primary btn-sm">
                            Ver todas las reparaciones ({{ $cliente->reparaciones->count() }})
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="card shadow">
                <div class="card-body text-center py-5">
                    <i class="fas fa-tools fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Sin reparaciones registradas</h5>
                    <p class="text-muted">Este cliente aún no tiene reparaciones en el sistema</p>
                    <a href="{{ route('reparaciones.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nueva Reparación
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.avatar-lg {
    width: 80px;
    height: 80px;
    font-size: 2rem;
}

.fw-semibold {
    font-weight: 600;
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,.125);
}

.form-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table th {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #5a5c69;
    border-top: none;
}

.table td {
    vertical-align: middle;
}

.btn-group .btn {
    border-radius: 0.35rem;
}

.btn-group .btn:not(:last-child) {
    margin-right: 0.5rem;
}
</style>
@endsection