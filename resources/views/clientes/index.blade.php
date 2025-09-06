@extends('layouts.app')

@section('title', 'Gestión de Clientes')

@section('content')
<div class="container-fluid">
    <!-- Header del Módulo -->
    <div class="module-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="module-title">
                    <i class="fas fa-users text-gradient me-3"></i>
                Gestión de Clientes
            </h1>
                <p class="module-subtitle">Administra y organiza la información de tus clientes de manera eficiente</p>
        </div>
            <div class="col-lg-4 text-end">
                <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-lg btn-modern">
            <i class="fas fa-plus me-2"></i>Nuevo Cliente
        </a>
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
                    <h3 class="stat-card-number" data-count="{{ $estadisticas['total_clientes'] }}">0</h3>
                    <p class="stat-card-label">Total Clientes</p>
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
                    <h3 class="stat-card-number" data-count="{{ $estadisticas['clientes_activos'] }}">0</h3>
                    <p class="stat-card-label">Clientes Activos</p>
                    <div class="stat-card-trend">
                        <i class="fas fa-percentage"></i>
                        <span>{{ $estadisticas['total_clientes'] > 0 ? round(($estadisticas['clientes_activos'] / $estadisticas['total_clientes']) * 100, 1) : 0 }}% del total</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-card-info">
                <div class="stat-card-icon">
                    <i class="fas fa-envelope"></i>
                            </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-number" data-count="{{ $estadisticas['clientes_con_email'] }}">0</h3>
                    <p class="stat-card-label">Con Email</p>
                    <div class="stat-card-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>{{ $estadisticas['total_clientes'] > 0 ? round(($estadisticas['clientes_con_email'] / $estadisticas['total_clientes']) * 100, 1) : 0 }}% cobertura</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-card-warning">
                <div class="stat-card-icon">
                    <i class="fas fa-phone"></i>
                            </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-number" data-count="{{ $estadisticas['clientes_con_telefono'] }}">0</h3>
                    <p class="stat-card-label">Con Teléfono</p>
                    <div class="stat-card-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>{{ $estadisticas['total_clientes'] > 0 ? round(($estadisticas['clientes_con_telefono'] / $estadisticas['total_clientes']) * 100, 1) : 0 }}% cobertura</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros y Búsqueda Avanzada -->
    <div class="filters-card mb-4">
        <div class="filters-card-header">
            <h5><i class="fas fa-filter text-primary me-2"></i>Filtros y Búsqueda</h5>
            <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filtersCollapse">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
        <div class="collapse show" id="filtersCollapse">
            <div class="filters-card-body">
            <form method="GET" action="{{ route('clientes.index') }}" class="row g-3">
                    <div class="col-lg-4">
                        <label for="buscar" class="form-label">
                            <i class="fas fa-search me-1"></i>Búsqueda Rápida
                        </label>
                        <div class="search-input-group">
                        <input type="text" 
                                   class="form-control search-input" 
                               id="buscar" 
                               name="buscar" 
                               value="{{ request('buscar') }}"
                               placeholder="Nombre, teléfono, email, DPI...">
                            <button type="submit" class="search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                </div>

                    <div class="col-lg-2">
                        <label for="estado" class="form-label">
                            <i class="fas fa-toggle-on me-1"></i>Estado
                        </label>
                        <select class="form-select modern-select" id="estado" name="estado">
                            <option value="">Todos</option>
                        <option value="activo" {{ request('estado') === 'activo' ? 'selected' : '' }}>Activos</option>
                        <option value="inactivo" {{ request('estado') === 'inactivo' ? 'selected' : '' }}>Inactivos</option>
                    </select>
                </div>

                    <div class="col-lg-2">
                        <label for="con_direccion" class="form-label">
                            <i class="fas fa-map-marker-alt me-1"></i>Dirección
                        </label>
                        <select class="form-select modern-select" id="con_direccion" name="con_direccion">
                        <option value="">Todas</option>
                        <option value="si" {{ request('con_direccion') === 'si' ? 'selected' : '' }}>Con dirección</option>
                        <option value="no" {{ request('con_direccion') === 'no' ? 'selected' : '' }}>Sin dirección</option>
                    </select>
                </div>

                    <div class="col-lg-2">
                        <label for="orden" class="form-label">
                            <i class="fas fa-sort me-1"></i>Ordenar
                        </label>
                        <select class="form-select modern-select" id="orden" name="orden">
                            <option value="nombre" {{ request('orden', 'nombre') === 'nombre' ? 'selected' : '' }}>Por nombre</option>
                            <option value="fecha" {{ request('orden') === 'fecha' ? 'selected' : '' }}>Por fecha</option>
                            <option value="estado" {{ request('orden') === 'estado' ? 'selected' : '' }}>Por estado</option>
                        </select>
                    </div>

                    <div class="col-lg-2 d-flex align-items-end">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i>Filtrar
                    </button>
                    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                        </div>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Tabla de Clientes -->
    <div class="table-card">
        <div class="table-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list text-primary me-2"></i>Lista de Clientes
                <span class="badge bg-primary ms-2">{{ $clientes->total() }}</span>
                </h5>
                <div class="table-actions">
                    <button class="btn btn-sm btn-outline-primary" onclick="exportarClientes()">
                        <i class="fas fa-download me-1"></i>Exportar
                    </button>
                </div>
            </div>
        </div>
        <div class="table-card-body">
            @if($clientes->count() > 0)
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th width="60">Cliente</th>
                                <th>Información de Contacto</th>
                                <th>Ubicación</th>
                                <th width="120">Estado</th>
                                <th width="180">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientes as $cliente)
                            <tr class="client-row" data-client-id="{{ $cliente->id }}">
                                <td>
                                    <div class="client-avatar">
                                        <div class="avatar-circle">
                                            {{ $cliente->getIniciales() }}
                                        </div>
                                        <div class="client-info">
                                            <h6 class="client-name">{{ $cliente->nombre_completo }}</h6>
                                        @if($cliente->dpi)
                                                <small class="client-dpi">
                                                <i class="fas fa-id-card me-1"></i>{{ $cliente->dpi }}
                                            </small>
                                        @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="contact-info">
                                    @if($cliente->telefono)
                                            <div class="contact-item">
                                                <i class="fas fa-phone text-success"></i>
                                                <a href="tel:{{ $cliente->telefono }}" class="contact-link">
                                                {{ $cliente->telefono }}
                                            </a>
                                        </div>
                                    @endif
                                    @if($cliente->email)
                                            <div class="contact-item">
                                                <i class="fas fa-envelope text-info"></i>
                                                <a href="mailto:{{ $cliente->email }}" class="contact-link">
                                                {{ $cliente->email }}
                                            </a>
                                        </div>
                                    @endif
                                    @if(!$cliente->telefono && !$cliente->email)
                                            <span class="no-contact">Sin información de contacto</span>
                                    @endif
                                    </div>
                                </td>
                                <td>
                                    @if($cliente->direccion)
                                        <div class="location-info">
                                            <i class="fas fa-map-marker-alt text-warning me-2"></i>
                                            <span class="location-text">{{ Str::limit($cliente->direccion, 60) }}</span>
                                        </div>
                                    @else
                                        <span class="no-location">Sin dirección registrada</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $cliente->activo ? 'active' : 'inactive' }}">
                                        <i class="fas fa-{{ $cliente->activo ? 'check-circle' : 'times-circle' }} me-1"></i>
                                        {{ $cliente->estado_label }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('clientes.show', $cliente) }}" 
                                           class="btn btn-sm btn-action btn-info" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('clientes.edit', $cliente) }}" 
                                           class="btn btn-sm btn-action btn-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-action btn-{{ $cliente->activo ? 'secondary' : 'success' }}"
                                                onclick="toggleClienteStatus({{ $cliente->id }})"
                                                title="{{ $cliente->activo ? 'Desactivar' : 'Activar' }}">
                                            <i class="fas fa-{{ $cliente->activo ? 'times' : 'check' }}"></i>
                                        </button>
                                        @if($cliente->reparaciones->count() === 0 && $cliente->equipos->count() === 0)
                                        <button type="button" 
                                                class="btn btn-sm btn-action btn-danger" 
                                                onclick="showDeleteConfirmation({{ $cliente->id }}, '{{ $cliente->nombre_completo }}', 'Cliente', '{{ route('clientes.destroy', $cliente) }}')"
                                                title="Eliminar cliente">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @else
                                        <button type="button" 
                                                class="btn btn-sm btn-action btn-secondary disabled" 
                                                onclick="showDeleteWarning('{{ $cliente->nombre_completo }}', {{ $cliente->reparaciones->count() }}, {{ $cliente->equipos->count() }})"
                                                title="No se puede eliminar: tiene datos asociados">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación Mejorada -->
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        <span class="pagination-text">
                            Mostrando <strong>{{ $clientes->firstItem() }}</strong> a <strong>{{ $clientes->lastItem() }}</strong> 
                            de <strong>{{ $clientes->total() }}</strong> clientes
                        </span>
                    </div>
                    <div class="pagination-links">
                    {{ $clientes->links() }}
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5>No hay clientes registrados</h5>
                    <p>Comienza construyendo tu base de clientes para gestionar mejor tus reparaciones</p>
                    <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Agregar Primer Cliente
                    </a>
                </div>
            @endif
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
    --gradient-info: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
}

/* Module Header */
.module-header {
    background: var(--system-gradient);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: var(--shadow-lg);
}

.module-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.module-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0.5rem 0 0 0;
}

.btn-modern {
    border-radius: 25px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-md);
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
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

/* Filters Card */
.filters-card {
    background: white;
    border-radius: 15px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.filters-card-header {
    background: var(--light-color);
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.filters-card-header h5 {
    margin: 0;
    font-weight: 600;
    color: var(--dark-color);
}

.filters-card-body {
    padding: 1.5rem;
}

.search-input-group {
    position: relative;
}

.search-input {
    padding-right: 50px;
    border-radius: 25px;
    border: 2px solid var(--border-color);
    transition: all 0.3s ease;
}

.search-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
}

.search-btn {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.search-btn:hover {
    background: var(--primary-light);
    transform: translateY(-50%) scale(1.1);
}

.modern-select {
    border-radius: 10px;
    border: 2px solid var(--border-color);
    transition: all 0.3s ease;
}

.modern-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
}

/* Table Card */
.table-card {
    background: white;
    border-radius: 15px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.table-card-header {
    background: var(--light-color);
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.table-card-header h5 {
    margin: 0;
    font-weight: 600;
    color: var(--dark-color);
}

.table-card-body {
    padding: 1.5rem;
}

.table-actions {
    display: flex;
    gap: 0.5rem;
}

/* Modern Table */
.modern-table {
    margin: 0;
}

.modern-table thead th {
    background: var(--light-color);
    border: none;
    padding: 1rem;
    font-weight: 600;
    color: var(--dark-color);
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.modern-table tbody td {
    padding: 1rem;
    border: none;
    border-bottom: 1px solid var(--border-color);
    vertical-align: middle;
}

.modern-table tbody tr {
    transition: all 0.2s ease;
}

.modern-table tbody tr:hover {
    background: var(--light-color);
    transform: scale(1.01);
}

/* Client Avatar */
.client-avatar {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.avatar-circle {
    width: 50px;
    height: 50px;
    background: var(--gradient-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.client-info {
    flex: 1;
}

.client-name {
    margin: 0;
    font-weight: 600;
    color: var(--dark-color);
    font-size: 1rem;
}

.client-dpi {
    color: #6b7280;
    font-size: 0.75rem;
}

/* Contact Info */
.contact-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.contact-item i {
    width: 16px;
    text-align: center;
}

.contact-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.contact-link:hover {
    color: var(--primary-light);
    text-decoration: underline;
}

.no-contact {
    color: #9ca3af;
    font-style: italic;
    font-size: 0.875rem;
}

/* Location Info */
.location-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.location-text {
    color: var(--dark-color);
    font-size: 0.875rem;
}

.no-location {
    color: #9ca3af;
    font-style: italic;
    font-size: 0.875rem;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-active {
    background: #d1fae5;
    color: #059669;
}

.status-inactive {
    background: #fee2e2;
    color: #dc2626;
}

/* Action Buttons */
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
    box-shadow: var(--shadow-md);
}

.btn-info {
    background: var(--info-color);
    color: white;
}

.btn-warning {
    background: var(--warning-color);
    color: white;
}

.btn-success {
    background: var(--success-color);
    color: white;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-danger {
    background: var(--danger-color);
    color: white;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

.pagination-info {
    color: #6b7280;
    font-size: 0.875rem;
}

.pagination-text strong {
    color: var(--dark-color);
}

.pagination-links {
    display: flex;
    gap: 0.5rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #9ca3af;
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1.5rem;
    opacity: 0.5;
}

.empty-state h5 {
    margin: 0 0 1rem 0;
    color: #6b7280;
    font-weight: 600;
}

.empty-state p {
    margin: 0 0 2rem 0;
    font-size: 1rem;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

/* Responsive Design */
@media (max-width: 768px) {
    .module-header {
        padding: 1.5rem;
    }
    
    .module-title {
        font-size: 2rem;
    }
    
    .stat-card {
        padding: 1rem;
    }
    
    .stat-card-number {
        font-size: 2rem;
    }
    
    .filters-card-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .table-card-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .pagination-wrapper {
        flex-direction: column;
        gap: 1rem;
        align-items: center;
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

.stat-card, .filters-card, .table-card {
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

// Función para cambiar estado del cliente
function toggleClienteStatus(clienteId) {
    fetch(`/clientes/${clienteId}/toggle-status`, {
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
        alert('Error al cambiar el estado del cliente');
    });
}

// Las funciones de eliminación ahora están en el layout principal
// showDeleteConfirmation() - Para mostrar el modal de confirmación
// showDeleteWarning() - Para mostrar advertencias cuando no se puede eliminar

// Función para exportar clientes
function exportarClientes() {
    // Aquí puedes implementar la lógica de exportación
    alert('Función de exportación en desarrollo');
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    animateCounters();
    
    // Agregar efectos de hover a las tarjetas
    const cards = document.querySelectorAll('.stat-card, .filters-card, .table-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Efectos de hover para las filas de la tabla
    const rows = document.querySelectorAll('.client-row');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
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