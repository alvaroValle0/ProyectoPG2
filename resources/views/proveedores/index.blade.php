@extends('layouts.app')

@section('title', 'Gestión de Proveedores')

@section('content')
<div class="container-fluid">
    <!-- Header del Módulo -->
    <div class="module-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="module-title">
                    <i class="fas fa-truck text-gradient me-3"></i>
                    Gestión de Proveedores
                </h1>
                <p class="module-subtitle">Administra y organiza la información de tus proveedores de manera eficiente</p>
            </div>
            <div class="col-lg-4 text-end">
                <a href="{{ route('proveedores.create') }}" class="btn btn-primary btn-lg btn-modern">
                    <i class="fas fa-plus me-2"></i>Nuevo Proveedor
                </a>
            </div>
        </div>
    </div>

    <!-- Estadísticas Principales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-card-primary">
                <div class="stat-card-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-number" data-count="{{ $estadisticas['total_proveedores'] }}">0</h3>
                    <p class="stat-card-label">Total Proveedores</p>
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
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-number" data-count="{{ $estadisticas['proveedores_activos'] }}">0</h3>
                    <p class="stat-card-label">Proveedores Activos</p>
                    <div class="stat-card-trend">
                        <i class="fas fa-percentage"></i>
                        <span>{{ $estadisticas['total_proveedores'] > 0 ? round(($estadisticas['proveedores_activos'] / $estadisticas['total_proveedores']) * 100, 1) : 0 }}% del total</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-card-info">
                <div class="stat-card-icon">
                    <i class="fas fa-industry"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-number" data-count="{{ $estadisticas['proveedores_fabricantes'] }}">0</h3>
                    <p class="stat-card-label">Fabricantes</p>
                    <div class="stat-card-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>{{ $estadisticas['total_proveedores'] > 0 ? round(($estadisticas['proveedores_fabricantes'] / $estadisticas['total_proveedores']) * 100, 1) : 0 }}% del total</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-card-warning">
                <div class="stat-card-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-number" data-count="{{ $estadisticas['proveedores_distribuidores'] }}">0</h3>
                    <p class="stat-card-label">Distribuidores</p>
                    <div class="stat-card-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>{{ $estadisticas['total_proveedores'] > 0 ? round(($estadisticas['proveedores_distribuidores'] / $estadisticas['total_proveedores']) * 100, 1) : 0 }}% del total</span>
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
                <form method="GET" action="{{ route('proveedores.index') }}" class="row g-3">
                    <div class="col-lg-3">
                        <label for="buscar" class="form-label">
                            <i class="fas fa-search me-1"></i>Búsqueda Rápida
                        </label>
                        <div class="search-input-group">
                            <input type="text" 
                                   class="form-control search-input" 
                                   id="buscar" 
                                   name="buscar" 
                                   value="{{ request('buscar') }}"
                                   placeholder="Empresa, contacto, email, teléfono...">
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
                        <label for="tipo_proveedor" class="form-label">
                            <i class="fas fa-industry me-1"></i>Tipo Proveedor
                        </label>
                        <select class="form-select modern-select" id="tipo_proveedor" name="tipo_proveedor">
                            <option value="">Todos</option>
                            @foreach($tiposProveedor as $valor => $etiqueta)
                                <option value="{{ $valor }}" {{ request('tipo_proveedor') === $valor ? 'selected' : '' }}>{{ $etiqueta }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <label for="categoria" class="form-label">
                            <i class="fas fa-tags me-1"></i>Categoría
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="categoria" 
                               name="categoria"
                               value="{{ request('categoria') }}"
                               placeholder="Buscar por categoría">
                    </div>

                    <div class="col-lg-3 d-flex align-items-end">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i>Filtrar
                            </button>
                            <a href="{{ route('proveedores.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabla de Proveedores -->
    <div class="table-card">
        <div class="table-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list text-primary me-2"></i>Lista de Proveedores
                    <span class="badge bg-primary ms-2">{{ $proveedores->total() }}</span>
                </h5>
                <div class="table-actions">
                    <button class="btn btn-sm btn-outline-primary" onclick="exportarProveedores()">
                        <i class="fas fa-download me-1"></i>Exportar
                    </button>
                </div>
            </div>
        </div>
        <div class="table-card-body">
            @if($proveedores->count() > 0)
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th width="60">Proveedor</th>
                                <th>Tipo de Proveedor</th>
                                <th>Información de Contacto</th>
                                <th width="120">Categoría</th>
                                <th width="120">Estado</th>
                                <th width="180">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proveedores as $proveedor)
                            <tr class="provider-row" data-provider-id="{{ $proveedor->id }}">
                                <td>
                                    <div class="provider-avatar">
                                        <div class="avatar-circle">
                                            {{ $proveedor->getIniciales() }}
                                        </div>
                                        <div class="provider-info">
                                            <h6 class="provider-name">{{ $proveedor->nombre_empresa }}</h6>
                                            @if($proveedor->nombre_contacto)
                                                <small class="provider-contact">
                                                    <i class="fas fa-user me-1"></i>{{ $proveedor->nombre_contacto }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="service-badge service-{{ $proveedor->tipo_proveedor }}">
                                        <i class="fas fa-{{ $proveedor->tipo_proveedor === 'fabricante' ? 'industry' : ($proveedor->tipo_proveedor === 'distribuidor' ? 'truck' : ($proveedor->tipo_proveedor === 'mayorista' ? 'warehouse' : ($proveedor->tipo_proveedor === 'minorista' ? 'store' : 'ellipsis-h'))) }} me-1"></i>
                                        {{ $proveedor->tipo_proveedor_label }}
                                    </span>
                                </td>
                                <td>
                                    <div class="contact-info">
                                        @if($proveedor->telefono)
                                            <div class="contact-item">
                                                <i class="fas fa-phone text-success"></i>
                                                <a href="tel:{{ $proveedor->telefono }}" class="contact-link">
                                                    {{ $proveedor->telefono }}
                                                </a>
                                            </div>
                                        @endif
                                        @if($proveedor->email)
                                            <div class="contact-item">
                                                <i class="fas fa-envelope text-info"></i>
                                                <a href="mailto:{{ $proveedor->email }}" class="contact-link">
                                                    {{ $proveedor->email }}
                                                </a>
                                            </div>
                                        @endif
                                        @if($proveedor->tiempo_entrega_promedio)
                                            <div class="contact-item">
                                                <i class="fas fa-clock text-warning"></i>
                                                <span class="contact-text">{{ $proveedor->tiempo_entrega_promedio }}</span>
                                            </div>
                                        @endif
                                        @if(!$proveedor->telefono && !$proveedor->email)
                                            <span class="no-contact">Sin información de contacto</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($proveedor->categoria_productos)
                                        <div class="category-display">
                                            <div class="category-text">
                                                {{ $proveedor->categoria_productos }}
                                            </div>
                                        </div>
                                    @else
                                        <span class="no-category">Sin categoría</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $proveedor->activo ? 'active' : 'inactive' }}">
                                        <i class="fas fa-{{ $proveedor->activo ? 'check-circle' : 'times-circle' }} me-1"></i>
                                        {{ $proveedor->estado_label }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('proveedores.show', $proveedor) }}" 
                                           class="btn btn-sm btn-action btn-info" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('proveedores.edit', $proveedor) }}" 
                                           class="btn btn-sm btn-action btn-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-action btn-{{ $proveedor->activo ? 'secondary' : 'success' }}"
                                                onclick="toggleProveedorStatus({{ $proveedor->id }})"
                                                title="{{ $proveedor->activo ? 'Desactivar' : 'Activar' }}">
                                            <i class="fas fa-{{ $proveedor->activo ? 'times' : 'check' }}"></i>
                                        </button>
                                        @if($proveedor->inventarios->count() === 0 && $proveedor->reparaciones->count() === 0)
                                        <button type="button" 
                                                class="btn btn-sm btn-action btn-danger" 
                                                onclick="showDeleteConfirmation({{ $proveedor->id }}, '{{ $proveedor->nombre_empresa }}', 'Proveedor', '{{ route('proveedores.destroy', $proveedor) }}')"
                                                title="Eliminar proveedor">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @else
                                        <button type="button" 
                                                class="btn btn-sm btn-action btn-secondary disabled" 
                                                onclick="showDeleteWarning('{{ $proveedor->nombre_empresa }}', {{ $proveedor->inventarios->count() }}, {{ $proveedor->reparaciones->count() }})"
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
                            Mostrando <strong>{{ $proveedores->firstItem() }}</strong> a <strong>{{ $proveedores->lastItem() }}</strong> 
                            de <strong>{{ $proveedores->total() }}</strong> proveedores
                        </span>
                    </div>
                    <div class="pagination-links">
                        @if ($proveedores->hasPages())
                            <nav aria-label="Navegación de páginas">
                                <ul class="pagination pagination-sm">
                                    {{-- Botón Anterior --}}
                                    @if ($proveedores->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $proveedores->previousPageUrl() }}" aria-label="Anterior">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Números de página --}}
                                    @foreach ($proveedores->getUrlRange(1, $proveedores->lastPage()) as $page => $url)
                                        @if ($page == $proveedores->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Botón Siguiente --}}
                                    @if ($proveedores->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $proveedores->nextPageUrl() }}" aria-label="Siguiente">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h5>No hay proveedores registrados</h5>
                    <p>Comienza construyendo tu red de proveedores para gestionar mejor tus compras y servicios</p>
                    <a href="{{ route('proveedores.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Agregar Primer Proveedor
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Variables CSS específicas para proveedores */
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

/* Provider Avatar */
.provider-avatar {
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

.provider-info {
    flex: 1;
}

.provider-name {
    margin: 0;
    font-weight: 600;
    color: var(--dark-color);
    font-size: 1rem;
}

.provider-contact {
    color: #6b7280;
    font-size: 0.75rem;
}

/* Service Badge */
.service-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.service-fabricante {
    background: #dbeafe;
    color: #2563eb;
}

.service-distribuidor {
    background: #d1fae5;
    color: #059669;
}

.service-mayorista {
    background: #fef3c7;
    color: #d97706;
}

.service-minorista {
    background: #e0e7ff;
    color: #7c3aed;
}

.service-otro {
    background: #f3f4f6;
    color: #6b7280;
}

/* Category Display */
.category-display {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
}

.category-text {
    color: var(--primary-color);
    font-weight: 600;
    font-size: 0.875rem;
    text-align: center;
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.no-category {
    color: #9ca3af;
    font-style: italic;
    font-size: 0.875rem;
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

.contact-text {
    color: var(--dark-color);
    font-size: 0.875rem;
}

.no-contact {
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

/* Responsive Design */
@media (max-width: 768px) {
    .provider-avatar {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .avatar-circle {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .service-badge {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
    }
    
    .action-buttons {
        flex-wrap: wrap;
        gap: 0.25rem;
    }
    
    .btn-action {
        width: 30px;
        height: 30px;
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
        const target = parseFloat(counter.getAttribute('data-count'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = target < 1 ? current.toFixed(1) : Math.floor(current).toLocaleString();
        }, 16);
    });
}

// Función para cambiar estado del proveedor
function toggleProveedorStatus(proveedorId) {
    fetch(`/proveedores/${proveedorId}/toggle-status`, {
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
        alert('Error al cambiar el estado del proveedor');
    });
}

// Función para exportar proveedores
function exportarProveedores() {
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
    const rows = document.querySelectorAll('.provider-row');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});
</script>
@endsection
