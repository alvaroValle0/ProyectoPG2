@extends('layouts.app')

@section('title', 'Detalles del Item - ' . $inventario->nombre)

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-box text-primary me-2"></i>
            Detalles del Item
        </h1>
        <p class="text-muted">{{ $inventario->nombre }}</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
        <a href="{{ route('inventario.edit', $inventario) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Editar
        </a>
    </div>
</div>

<div class="row">
    <!-- Información Principal -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle text-primary me-2"></i>
                    Información General
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Código</label>
                        <p class="mb-0">{{ $inventario->codigo }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Nombre</label>
                        <p class="mb-0">{{ $inventario->nombre }}</p>
                    </div>
                </div>

                @if($inventario->descripcion)
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted">Descripción</label>
                    <p class="mb-0">{{ $inventario->descripcion }}</p>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Categoría</label>
                        <p class="mb-0">
                            <span class="badge bg-info text-white">
                                <i class="fas fa-folder me-1"></i>{{ $inventario->categoria }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Estado</label>
                        <p class="mb-0">
                            <span class="badge bg-{{ $inventario->estado_color }} text-white">
                                <i class="fas fa-{{ $inventario->estado == 'activo' ? 'check-circle' : ($inventario->estado == 'inactivo' ? 'pause-circle' : ($inventario->estado == 'agotado' ? 'times-circle' : 'ban')) }} me-1"></i>
                                {{ $inventario->estado_label }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Especificaciones -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-cogs text-primary me-2"></i>
                    Especificaciones
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @if($inventario->marca)
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold text-muted">Marca</label>
                        <p class="mb-0">{{ $inventario->marca }}</p>
                    </div>
                    @endif
                    @if($inventario->modelo)
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold text-muted">Modelo</label>
                        <p class="mb-0">{{ $inventario->modelo }}</p>
                    </div>
                    @endif
                    @if($inventario->serie)
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold text-muted">Número de Serie</label>
                        <p class="mb-0">{{ $inventario->serie }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stock y Precios -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line text-primary me-2"></i>
                    Stock y Precios
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold text-muted">Stock Actual</label>
                        <h4 class="text-{{ $inventario->stock_status_color }} mb-1">{{ $inventario->stock_actual }}</h4>
                        <small class="text-muted">Mínimo: {{ $inventario->stock_minimo }}</small>
                        <br>
                        <span class="badge bg-{{ $inventario->stock_status_color }} text-white">
                            <i class="fas fa-{{ $inventario->stock_status == 'agotado' ? 'times-circle' : ($inventario->stock_status == 'bajo' ? 'exclamation-triangle' : 'check-circle') }} me-1"></i>
                            {{ $inventario->stock_status_label }}
                        </span>
                    </div>
                    @if($inventario->precio_compra)
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold text-muted">Precio de Compra</label>
                        <h4 class="text-success mb-1">Q{{ number_format($inventario->precio_compra, 2) }}</h4>
                    </div>
                    @endif
                    @if($inventario->precio_venta)
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold text-muted">Precio de Venta</label>
                        <h4 class="text-primary mb-1">Q{{ number_format($inventario->precio_venta, 2) }}</h4>
                        @if($inventario->precio_compra)
                        <small class="text-info">+{{ number_format($inventario->margen_ganancia, 1) }}% margen</small>
                        @endif
                    </div>
                    @endif
                </div>
                @if($inventario->precio_compra)
                <div class="mt-3">
                    <label class="form-label fw-bold text-muted">Valor Total en Inventario</label>
                    <h4 class="text-secondary">Q{{ number_format($inventario->valor_total, 2) }}</h4>
                </div>
                @endif
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle text-primary me-2"></i>
                    Información Adicional
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @if($inventario->proveedor)
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Proveedor</label>
                        <p class="mb-0">{{ $inventario->proveedor }}</p>
                    </div>
                    @endif
                    @if($inventario->ubicacion)
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Ubicación</label>
                        <p class="mb-0">
                            <i class="fas fa-map-marker-alt text-primary me-1"></i>
                            {{ $inventario->ubicacion }}
                        </p>
                    </div>
                    @endif
                    @if($inventario->fecha_compra)
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Fecha de Compra</label>
                        <p class="mb-0">{{ $inventario->fecha_compra->format('d/m/Y') }}</p>
                    </div>
                    @endif
                    @if($inventario->fecha_vencimiento)
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Fecha de Vencimiento</label>
                        <p class="mb-0">{{ $inventario->fecha_vencimiento->format('d/m/Y') }}</p>
                    </div>
                    @endif
                </div>
                @if($inventario->notas)
                <div class="mt-3">
                    <label class="form-label fw-bold text-muted">Notas</label>
                    <p class="mb-0">{{ $inventario->notas }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Panel Lateral -->
    <div class="col-lg-4">
        <!-- Imagen del Producto -->
        @if($inventario->imagen)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-image text-primary me-2"></i>
                    Imagen del Producto
                </h5>
            </div>
            <div class="card-body text-center">
                <img src="{{ asset('storage/inventario/' . $inventario->imagen) }}" 
                     alt="{{ $inventario->nombre }}" 
                     class="img-fluid rounded" 
                     style="max-height: 200px;">
            </div>
        </div>
        @endif

        <!-- Acciones Rápidas -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" 
                            class="btn btn-info" 
                            onclick="mostrarModalStock({{ $inventario->id }}, '{{ $inventario->nombre }}', {{ $inventario->stock_actual }})">
                        <i class="fas fa-plus-minus me-2"></i>Ajustar Stock
                    </button>
                    <a href="{{ route('inventario.edit', $inventario) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Editar Item
                    </a>
                    <button type="button" 
                            class="btn btn-outline-danger btn-eliminar-item" 
                            data-item-id="{{ $inventario->id }}"
                            data-item-nombre="{{ $inventario->nombre }}"
                            data-item-tipo="item de inventario"
                            data-delete-url="{{ route('inventario.destroy', $inventario) }}">
                        <i class="fas fa-trash me-2"></i>Eliminar
                    </button>
                </div>
            </div>
        </div>

        <!-- Información del Sistema -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-database text-secondary me-2"></i>
                    Información del Sistema
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted">ID del Item</label>
                    <p class="mb-0">{{ $inventario->id }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted">Fecha de Creación</label>
                    <p class="mb-0">{{ $inventario->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted">Última Actualización</label>
                    <p class="mb-0">{{ $inventario->updated_at->format('d/m/Y H:i') }}</p>
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
</script>
@endsection

@section('styles')
<style>
.card {
    border-radius: 15px;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px 15px 0 0 !important;
}

.btn {
    border-radius: 25px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35rem 0.65rem;
}

.form-label {
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}
</style>
@endsection
