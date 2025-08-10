@extends('layouts.app')

@section('title', 'Gestión de Inventario')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-boxes text-primary me-2"></i>
            Gestión de Inventario
        </h1>
        <p class="text-muted">Control completo de productos y repuestos</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('inventario.create') }}" class="btn btn-primary btn-custom">
            <i class="fas fa-plus me-2"></i>Nuevo Producto
        </a>
    </div>
</div>

<!-- Estadísticas Rápidas -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-primary text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-cubes display-6 mb-2"></i>
                <h4>{{ number_format($estadisticas['total_productos']) }}</h4>
                <p class="mb-0">Total Productos</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-success text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-check-circle display-6 mb-2"></i>
                <h4>{{ number_format($estadisticas['productos_activos']) }}</h4>
                <p class="mb-0">Productos Activos</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-warning text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle display-6 mb-2"></i>
                <h4>{{ number_format($estadisticas['productos_bajo_stock']) }}</h4>
                <p class="mb-0">Bajo Stock</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-info text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-euro-sign display-6 mb-2"></i>
                <h4>€{{ number_format($estadisticas['valor_total_inventario'], 2) }}</h4>
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
                           placeholder="Buscar por nombre o código...">
                </div>
            </div>

            <!-- Filtro por Categoría -->
            <div class="col-md-2">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-select" id="categoria" name="categoria">
                    <option value="">Todas</option>
                    @foreach($estadisticas['categorias'] as $categoria)
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
                    <option value="">Todos</option>
                    <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    <option value="descontinuado" {{ request('estado') == 'descontinuado' ? 'selected' : '' }}>Descontinuado</option>
                    <option value="agotado" {{ request('estado') == 'agotado' ? 'selected' : '' }}>Agotado</option>
                </select>
            </div>

            <!-- Filtro por Stock -->
            <div class="col-md-2">
                <label for="stock_estado" class="form-label">Stock</label>
                <select class="form-select" id="stock_estado" name="stock_estado">
                    <option value="">Todos</option>
                    <option value="bajo" {{ request('stock_estado') == 'bajo' ? 'selected' : '' }}>Bajo Stock</option>
                    <option value="agotado" {{ request('stock_estado') == 'agotado' ? 'selected' : '' }}>Agotados</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-primary flex-fill">
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

<!-- Lista de Productos -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($inventario->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                            <th>Precios</th>
                            <th>Estado</th>
                            <th>Proveedor</th>
                            <th width="150px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventario as $producto)
                        <tr>
                            <!-- Producto -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <i class="fas fa-cube"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $producto->nombre }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $producto->codigo_producto }}</small>
                                        @if($producto->marca)
                                            <br>
                                            <small class="text-info">{{ $producto->marca }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Categoría -->
                            <td>
                                <span class="badge bg-secondary">{{ $producto->categoria }}</span>
                            </td>
                            
                            <!-- Stock -->
                            <td>
                                <div class="text-center">
                                    <h5 class="mb-1">
                                        <span class="badge bg-{{ $producto->stock_color }} fs-6">
                                            {{ $producto->stock_actual }}
                                        </span>
                                    </h5>
                                    <small class="text-muted">Mín: {{ $producto->stock_minimo }}</small>
                                    @if($producto->esBajoStock())
                                        <br>
                                        <small class="text-warning">
                                            <i class="fas fa-exclamation-triangle"></i> Bajo stock
                                        </small>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Precios -->
                            <td>
                                @if($producto->precio_venta)
                                    <strong>€{{ number_format($producto->precio_venta, 2) }}</strong>
                                    <br>
                                @endif
                                @if($producto->precio_compra)
                                    <small class="text-muted">Costo: €{{ number_format($producto->precio_compra, 2) }}</small>
                                @endif
                            </td>
                            
                            <!-- Estado -->
                            <td>
                                <span class="badge bg-{{ $producto->estado_color }} text-white">
                                    {{ $producto->estado_label }}
                                </span>
                            </td>
                            
                            <!-- Proveedor -->
                            <td>
                                <span class="text-muted">{{ $producto->proveedor ?? 'N/A' }}</span>
                            </td>
                            
                            <!-- Acciones -->
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('inventario.show', $producto) }}" 
                                       class="btn btn-outline-primary" 
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('inventario.edit', $producto) }}" 
                                       class="btn btn-outline-warning" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-outline-info" 
                                            onclick="ajustarStock({{ $producto->id }})"
                                            title="Ajustar stock">
                                        <i class="fas fa-balance-scale"></i>
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
                <h4 class="text-muted">No se encontraron productos</h4>
                @if(request()->hasAny(['buscar', 'categoria', 'estado', 'stock_estado']))
                    <p class="text-muted">Intenta ajustar los filtros de búsqueda.</p>
                    <a href="{{ route('inventario.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-times me-2"></i>Limpiar Filtros
                    </a>
                @else
                    <p class="text-muted">Agrega el primer producto al inventario.</p>
                    <a href="{{ route('inventario.create') }}" class="btn btn-primary btn-custom">
                        <i class="fas fa-plus me-2"></i>Crear Primer Producto
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
                            <i class="fas fa-plus me-2"></i>Nuevo Producto
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('inventario.reportes.bajo-stock') }}" class="btn btn-warning w-100">
                            <i class="fas fa-exclamation-triangle me-2"></i>Bajo Stock
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('inventario.reportes.vencimientos') }}" class="btn btn-info w-100">
                            <i class="fas fa-calendar-times me-2"></i>Vencimientos
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

<!-- Modal para ajustar stock -->
<div class="modal fade" id="ajustarStockModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-balance-scale me-2"></i>
                    Ajustar Stock
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-ajustar-stock">
                    <div class="mb-3">
                        <label class="form-label">Operación</label>
                        <select class="form-select" name="operacion" required>
                            <option value="suma">Agregar stock (entrada)</option>
                            <option value="resta">Reducir stock (salida)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control" name="cantidad" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Motivo</label>
                        <input type="text" class="form-control" name="motivo" 
                               placeholder="Razón del ajuste de stock..." required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-info" onclick="ejecutarAjusteStock()">
                    <i class="fas fa-save me-2"></i>Ajustar Stock
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let productoIdAjuste = null;

function ajustarStock(productoId) {
    productoIdAjuste = productoId;
    const modal = new bootstrap.Modal(document.getElementById('ajustarStockModal'));
    modal.show();
}

function ejecutarAjusteStock() {
    const form = document.getElementById('form-ajustar-stock');
    const formData = new FormData(form);
    
    fetch(`/inventario/${productoIdAjuste}/ajustar-stock`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('success', data.message);
            location.reload(); // Recargar para mostrar el stock actualizado
        } else {
            showToast('error', data.message);
        }
        
        bootstrap.Modal.getInstance(document.getElementById('ajustarStockModal')).hide();
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'Error al ajustar el stock');
    });
}

function showToast(type, message) {
    // Crear toast dinámico (reutilizando el código de usuarios)
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
</script>
@endsection

@section('styles')
<style>
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
    background-color: rgba(18, 147, 252, 0.05);
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
}
</style>
@endsection
