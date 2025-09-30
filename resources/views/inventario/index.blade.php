@extends('layouts.app')

@section('title', 'Gestión de Inventario')

@section('content')
<div class="container-fluid">
    <div class="module-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="module-title">
                    <i class="fas fa-boxes text-gradient me-3"></i>
                    Gestión de Inventario
                </h1>
                <p class="module-subtitle">Administra productos y componentes de manera eficiente</p>
            </div>
            <div class="col-lg-4 text-end">
                <a href="{{ route('inventario.create') }}" class="btn btn-primary btn-lg btn-modern">
                    <i class="fas fa-plus me-2"></i>Nuevo Item
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas Principales -->
<div class="row mb-4">
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-icon">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $estadisticas['total_items'] }}">0</h3>
                <p class="stat-card-label">Total Items</p>
                <div class="stat-card-trend">
                    <i class="fas fa-chart-line"></i>
                    <span>Base de datos completa</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card stat-card-success">
            <div class="stat-card-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $estadisticas['items_activos'] }}">0</h3>
                <p class="stat-card-label">Activos</p>
                <div class="stat-card-trend">
                    <i class="fas fa-percentage"></i>
                    <span>{{ $estadisticas['total_items'] > 0 ? round(($estadisticas['items_activos'] / $estadisticas['total_items']) * 100, 1) : 0 }}% del total</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $estadisticas['items_agotados'] }}">0</h3>
                <p class="stat-card-label">Agotados</p>
                <div class="stat-card-trend">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $estadisticas['total_items'] > 0 ? round(($estadisticas['items_agotados'] / $estadisticas['total_items']) * 100, 1) : 0 }}% agotados</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card stat-card-danger">
            <div class="stat-card-icon">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $estadisticas['items_stock_bajo'] }}">0</h3>
                <p class="stat-card-label">Stock Bajo</p>
                <div class="stat-card-trend">
                    <i class="fas fa-arrow-down"></i>
                    <span>{{ $estadisticas['total_items'] > 0 ? round(($estadisticas['items_stock_bajo'] / $estadisticas['total_items']) * 100, 1) : 0 }}% stock bajo</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card stat-card-info">
            <div class="stat-card-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $estadisticas['categorias'] }}">0</h3>
                <p class="stat-card-label">Categorías</p>
                <div class="stat-card-trend">
                    <i class="fas fa-folder"></i>
                    <span>Diversificación completa</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card stat-card-secondary">
            <div class="stat-card-icon">
                <i class="fas fa-coins"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-number" data-count="{{ $estadisticas['valor_total'] }}">0</h3>
                <p class="stat-card-label">Valor Total</p>
                <div class="stat-card-trend">
                    <i class="fas fa-chart-line"></i>
                    <span>Q{{ number_format($estadisticas['valor_total'], 2) }} en inventario</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtros y Búsqueda -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('inventario.index') }}" class="row g-3">
            <!-- Búsqueda -->
            <div class="col-md-3">
                <label for="buscar" class="form-label">Búsqueda</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           id="buscar" 
                           name="buscar" 
                           value="{{ request('buscar') }}" 
                           placeholder="Buscar por código, nombre...">
                </div>
            </div>

            <!-- Filtro por Categoría -->
            <div class="col-md-2">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-select" id="categoria" name="categoria">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria }}" {{ request('categoria') == $categoria ? 'selected' : '' }}>
                            {{ $categoria }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro por Estado -->
            <div class="col-md-2">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado">
                    <option value="">Todos los estados</option>
                    <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    <option value="agotado" {{ request('estado') == 'agotado' ? 'selected' : '' }}>Agotado</option>
                    <option value="discontinuado" {{ request('estado') == 'discontinuado' ? 'selected' : '' }}>Discontinuado</option>
                </select>
            </div>

            <!-- Filtro por Stock -->
            <div class="col-md-2">
                <label for="stock_status" class="form-label">Stock</label>
                <select class="form-select" id="stock_status" name="stock_status">
                    <option value="">Todos</option>
                    <option value="normal" {{ request('stock_status') == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="bajo" {{ request('stock_status') == 'bajo' ? 'selected' : '' }}>Bajo</option>
                    <option value="agotado" {{ request('stock_status') == 'agotado' ? 'selected' : '' }}>Agotado</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i>Filtrar
                    </button>
                    <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Limpiar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Lista de Inventario -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($inventario->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover modern-table">
                    <thead class="table-dark">
                        <tr>
                            <th>Código</th>
                            <th>Item</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                            <th>Precios</th>
                            <th>Estado</th>
                            <th>Ubicación</th>
                            <th width="200px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventario as $item)
                        <tr>
                            <!-- Código -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <i class="fas fa-barcode"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $item->codigo }}</strong>
                                        @if($item->serie)
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-microchip me-1"></i>{{ $item->serie }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Item -->
                            <td>
                                <div>
                                    <strong>{{ $item->nombre }}</strong>
                                    @if($item->marca || $item->modelo)
                                        <br>
                                        <small class="text-muted">
                                            @if($item->marca)
                                                <i class="fas fa-tag me-1"></i>{{ $item->marca }}
                                            @endif
                                            @if($item->modelo)
                                                <i class="fas fa-cog me-1"></i>{{ $item->modelo }}
                                            @endif
                                        </small>
                                    @endif
                                    @if($item->descripcion)
                                        <br>
                                        <small class="text-muted">{{ Str::limit($item->descripcion, 50) }}</small>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Categoría -->
                            <td>
                                <span class="badge bg-info text-white fs-6">
                                    <i class="fas fa-folder me-1"></i>
                                    {{ $item->categoria }}
                                </span>
                            </td>
                            
                            <!-- Stock -->
                            <td>
                                <div>
                                    <strong class="text-{{ $item->stock_status_color }}">
                                        {{ $item->stock_actual }}
                                    </strong>
                                    <br>
                                    <small class="text-muted">
                                        Mín: {{ $item->stock_minimo }}
                                    </small>
                                    <br>
                                    <span class="badge bg-{{ $item->stock_status_color }} text-white fs-6">
                                        <i class="fas fa-{{ $item->stock_status == 'agotado' ? 'times-circle' : ($item->stock_status == 'bajo' ? 'exclamation-triangle' : 'check-circle') }} me-1"></i>
                                        {{ $item->stock_status_label }}
                                    </span>
                                </div>
                            </td>
                            
                            <!-- Precios -->
                            <td>
                                <div>
                                    @if($item->precio_compra)
                                        <strong class="text-success">Q{{ number_format($item->precio_compra, 2) }}</strong>
                                        <br>
                                        <small class="text-muted">Compra</small>
                                    @endif
                                    @if($item->precio_venta)
                                        <br>
                                        <strong class="text-primary">Q{{ number_format($item->precio_venta, 2) }}</strong>
                                        <br>
                                        <small class="text-muted">Venta</small>
                                    @endif
                                    @if($item->precio_compra && $item->precio_venta)
                                        <br>
                                        <small class="text-info">
                                            +{{ number_format($item->margen_ganancia, 1) }}%
                                        </small>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Estado -->
                            <td>
                                <span class="badge bg-{{ $item->estado_color }} text-white fs-6" 
                                      id="estado-badge-{{ $item->id }}">
                                    <i class="fas fa-{{ $item->estado == 'activo' ? 'check-circle' : ($item->estado == 'inactivo' ? 'pause-circle' : ($item->estado == 'agotado' ? 'times-circle' : 'ban')) }} me-1"></i>
                                    {{ $item->estado_label }}
                                </span>
                            </td>
                            
                            <!-- Ubicación -->
                            <td>
                                @if($item->ubicacion)
                                    <div>
                                        <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                        {{ $item->ubicacion }}
                                    </div>
                                @else
                                    <span class="text-muted">No especificada</span>
                                @endif
                            </td>
                            
                            <!-- Acciones -->
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <!-- Ver -->
                                    <a href="{{ route('inventario.show', $item) }}" 
                                       class="btn btn-outline-primary" 
                                       title="Ver detalles" 
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <!-- Editar -->
                                    <a href="{{ route('inventario.edit', $item) }}" 
                                       class="btn btn-outline-warning" 
                                       title="Editar" 
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Ajustar Stock -->
                                    <button type="button" 
                                            class="btn btn-outline-info" 
                                            onclick="mostrarModalStock({{ $item->id }}, '{{ $item->nombre }}', {{ $item->stock_actual }})"
                                            title="Ajustar Stock" 
                                            data-bs-toggle="tooltip">
                                        <i class="fas fa-plus-minus"></i>
                                    </button>
                                    
                                    <!-- Eliminar -->
                                    <button type="button" 
                                            class="btn btn-outline-danger btn-eliminar-item" 
                                            data-item-id="{{ $item->id }}"
                                            data-item-nombre="{{ $item->nombre }}"
                                            data-item-tipo="item de inventario"
                                            data-delete-url="{{ route('inventario.destroy', $item) }}"
                                            title="Eliminar" 
                                            data-bs-toggle="tooltip">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="pagination-wrapper">
                <div class="pagination-info">
                    <span class="pagination-text">
                        Mostrando <strong>{{ $inventario->firstItem() }}</strong> a <strong>{{ $inventario->lastItem() }}</strong> 
                        de <strong>{{ $inventario->total() }}</strong> productos
                    </span>
                </div>
                <div class="pagination-links">
                    @if ($inventario->hasPages())
                        <nav aria-label="Navegación de páginas">
                            <ul class="pagination pagination-sm">
                                {{-- Botón Anterior --}}
                                @if ($inventario->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="fas fa-chevron-left"></i>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $inventario->previousPageUrl() }}" aria-label="Anterior">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Números de página --}}
                                @foreach ($inventario->getUrlRange(1, $inventario->lastPage()) as $page => $url)
                                    @if ($page == $inventario->currentPage())
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
                                @if ($inventario->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $inventario->nextPageUrl() }}" aria-label="Siguiente">
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
            <div class="text-center py-5">
                <i class="fas fa-boxes display-1 text-muted mb-4"></i>
                <h4 class="text-muted">No se encontraron items en el inventario</h4>
                @if(request()->hasAny(['buscar', 'categoria', 'estado', 'stock_status']))
                    <p class="text-muted">Intenta ajustar los filtros de búsqueda.</p>
                    <a href="{{ route('inventario.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-times me-2"></i>Limpiar Filtros
                    </a>
                @else
                    <p class="text-muted">Registra el primer item del inventario.</p>
                    <a href="{{ route('inventario.create') }}" class="btn btn-primary btn-custom">
                        <i class="fas fa-plus me-2"></i>Crear Primer Item
                    </a>
                @endif
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
                        <a href="{{ route('inventario.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>Nuevo Item
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('inventario.reportes') }}" class="btn btn-info w-100">
                            <i class="fas fa-chart-bar me-2"></i>Reportes
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('inventario.exportar', request()->query()) }}" class="btn btn-success w-100" title="Exportar inventario actual (con filtros aplicados)" onclick="exportarInventario(this)">
                            <i class="fas fa-download me-2"></i>Exportar
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="button" class="btn btn-outline-secondary w-100" onclick="mostrarProximamente('Importar Inventario')">
                            <i class="fas fa-upload me-2"></i>Importar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Ajustar Stock -->
<div class="modal fade" id="modalStock" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-minus me-2"></i>
                    Ajustar Stock
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong id="item-nombre-stock"></strong>
                    <br>
                    <small class="text-muted">Stock actual: <span id="stock-actual-display"></span></small>
                </div>
                
                <form id="formAjustarStock">
                    <input type="hidden" id="item-id-stock">
                    
                    <div class="mb-3">
                        <label for="tipo-ajuste" class="form-label">Tipo de Ajuste</label>
                        <select class="form-select" id="tipo-ajuste" name="tipo" required>
                            <option value="entrada">Entrada de Stock</option>
                            <option value="salida">Salida de Stock</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="cantidad-ajuste" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad-ajuste" name="cantidad" min="1" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="motivo-ajuste" class="form-label">Motivo</label>
                        <textarea class="form-control" id="motivo-ajuste" name="motivo" rows="2" required maxlength="255"
                                  placeholder="Ej: Compra de proveedor, Venta a cliente, Ajuste de inventario..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-info" onclick="ajustarStock()">
                    <i class="fas fa-save me-2"></i>Guardar Ajuste
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function mostrarModalStock(itemId, nombre, stockActual) {
    document.getElementById('item-id-stock').value = itemId;
    document.getElementById('item-nombre-stock').textContent = nombre;
    document.getElementById('stock-actual-display').textContent = stockActual;
    document.getElementById('cantidad-ajuste').value = '';
    document.getElementById('motivo-ajuste').value = '';
    
    const modal = new bootstrap.Modal(document.getElementById('modalStock'));
    modal.show();
}

function ajustarStock() {
    const itemId = document.getElementById('item-id-stock').value;
    const formData = new FormData(document.getElementById('formAjustarStock'));
    
    fetch(`/inventario/${itemId}/ajustar-stock`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            _method: 'PATCH',
            tipo: formData.get('tipo'),
            cantidad: parseInt(formData.get('cantidad')),
            motivo: formData.get('motivo')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar modal
            bootstrap.Modal.getInstance(document.getElementById('modalStock')).hide();
            
            // Recargar página para mostrar cambios
            location.reload();
            
            showToast('success', data.message);
        } else {
            showToast('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'Error al ajustar el stock');
    });
}

function showToast(type, message) {
    // Crear toast dinámico
    const toastContainer = document.getElementById('toast-container') || (() => {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
        return container;
    })();
    
    const toastHtml = `
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-${type === 'success' ? 'success' : 'danger'} text-white">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                <strong class="me-auto">${type === 'success' ? 'Éxito' : 'Error'}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    const toastElement = toastContainer.lastElementChild;
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
    
    // Eliminar el toast después de que se oculte
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}

function exportarInventario(linkElement) {
    // Mostrar mensaje de procesamiento
    showToast('success', 'Preparando exportación...');
    
    // Deshabilitar el botón temporalmente
    const originalText = linkElement.innerHTML;
    linkElement.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Exportando...';
    linkElement.style.pointerEvents = 'none';
    
    // Restaurar el botón después de 2 segundos
    setTimeout(() => {
        linkElement.innerHTML = originalText;
        linkElement.style.pointerEvents = 'auto';
    }, 2000);
    
    // Permitir que el enlace continúe normalmente
    return true;
}

function mostrarProximamente(feature) {
    showToast('info', `${feature} estará disponible próximamente`);
}
// Inicializar tooltips Bootstrap
document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});

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

@section('fab-button')
<a href="{{ route('inventario.create') }}" class="fab success" title="Nuevo Item">
    <i class="fas fa-plus"></i>
    <div class="fab-tooltip">Nuevo Item</div>
</a>
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

.badge {
    font-size: 0.75rem;
    padding: 0.35rem 0.65rem;
}

.btn-group-sm > .btn {
    padding: 0.375rem 0.5rem;
    font-size: 0.875rem;
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
.stat-card:nth-child(5) { animation-delay: 0.5s; }
.stat-card:nth-child(6) { animation-delay: 0.6s; }

/* Corregir flechas de navegación en campos number */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield;
}

/* Ocultar flechas de incremento/decremento en campos number */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield;
    appearance: textfield;
}

/* Asegurar que los campos de entrada no tengan flechas grandes */
.form-control[type="number"],
.form-control[type="number"]:focus {
    -webkit-appearance: none;
    -moz-appearance: textfield;
    appearance: textfield;
}

.form-control[type="number"]::-webkit-outer-spin-button,
.form-control[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    appearance: none;
    margin: 0;
}

/* Estilos para la paginación - Igual que clientes */
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
}

.pagination {
    justify-content: center;
    margin: 0;
}

.pagination .page-link {
    border: 1px solid #dee2e6;
    color: #007bff;
    padding: 0.5rem 0.75rem;
    margin: 0 0.125rem;
    border-radius: 0.375rem;
    transition: all 0.15s ease-in-out;
}

.pagination .page-link:hover {
    color: #0056b3;
    background-color: #e9ecef;
    border-color: #dee2e6;
    transform: translateY(-1px);
}

.pagination .page-item.active .page-link {
    background-color: var(--system-primary, #007bff);
    border-color: var(--system-primary, #007bff);
    color: white;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
}

/* Asegurar que no haya flechas grandes en los controles de paginación */
.pagination .page-link:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Responsive */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group-sm > .btn {
        padding: 0.25rem 0.375rem;
        font-size: 0.8rem;
    }
    
    .stat-card {
        padding: 1rem;
    }
    
    .stat-card-number {
        font-size: 2rem;
    }
    
    .pagination-wrapper {
        flex-direction: column;
        gap: 1rem;
        align-items: center;
    }
}
</style>
@endsection
