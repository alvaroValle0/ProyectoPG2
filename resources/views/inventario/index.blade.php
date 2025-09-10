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

<!-- Estadísticas Rápidas -->
<div class="row mb-4">
    <div class="col-lg-2 col-md-4 col-6 mb-3">
        <div class="card border-0 bg-primary text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-boxes display-6 mb-2"></i>
                <h4>{{ $estadisticas['total_items'] }}</h4>
                <p class="mb-0">Total Items</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6 mb-3">
        <div class="card border-0 bg-success text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-check-circle display-6 mb-2"></i>
                <h4>{{ $estadisticas['items_activos'] }}</h4>
                <p class="mb-0">Activos</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6 mb-3">
        <div class="card border-0 bg-warning text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle display-6 mb-2"></i>
                <h4>{{ $estadisticas['items_agotados'] }}</h4>
                <p class="mb-0">Agotados</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6 mb-3">
        <div class="card border-0 bg-danger text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-arrow-down display-6 mb-2"></i>
                <h4>{{ $estadisticas['items_stock_bajo'] }}</h4>
                <p class="mb-0">Stock Bajo</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6 mb-3">
        <div class="card border-0 bg-info text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-tags display-6 mb-2"></i>
                <h4>{{ $estadisticas['categorias'] }}</h4>
                <p class="mb-0">Categorías</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6 mb-3">
        <div class="card border-0 bg-secondary text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-coins display-6 mb-2"></i>
                <h4>Q{{ number_format($estadisticas['valor_total'], 2) }}</h4>
                <p class="mb-0">Valor Total</p>
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
            <div class="d-flex justify-content-center mt-4">
                {{ $inventario->withQueryString()->links() }}
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
                        <a href="{{ route('inventario.exportar') }}" class="btn btn-success w-100">
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
// Inicializar tooltips Bootstrap
document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>
@endsection

@section('styles')
<style>
.module-header {
    background: var(--system-gradient);
    color: #fff;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
}
.module-title { font-size: 2.25rem; font-weight: 700; margin: 0; }
.module-subtitle { opacity: .9; margin-top: .25rem; }
.btn-modern { border-radius: 25px; padding: .75rem 1.5rem; font-weight: 600; }
.modern-table thead th { background: #f8fafc; border: none; text-transform: uppercase; letter-spacing: .5px; }
.modern-table tbody tr:hover { background: rgba(0,0,0,0.02); transform: scale(1.005); }
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
