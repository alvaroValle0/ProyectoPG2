@extends('layouts.app')

@section('title', 'Nuevo Item de Inventario')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-plus text-primary me-2"></i>
            Nuevo Item de Inventario
        </h1>
        <p class="text-muted">Registra un nuevo producto o componente en el inventario</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver al Inventario
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-edit text-primary me-2"></i>
                    Información del Item
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('inventario.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- Código -->
                        <div class="col-md-6 mb-3">
                            <label for="codigo" class="form-label">
                                <i class="fas fa-barcode me-1"></i>Código <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('codigo') is-invalid @enderror" 
                                   id="codigo" 
                                   name="codigo" 
                                   value="{{ old('codigo') }}" 
                                   placeholder="Ej: INV-001, COMP-2024-001">
                            @error('codigo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Código único para identificar el item</small>
                        </div>

                        <!-- Nombre -->
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-tag me-1"></i>Nombre <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   placeholder="Ej: Disco Duro SSD 500GB">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">
                            <i class="fas fa-align-left me-1"></i>Descripción
                        </label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" 
                                  name="descripcion" 
                                  rows="3" 
                                  placeholder="Descripción detallada del producto...">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Categoría -->
                        <div class="col-md-6 mb-3">
                            <label for="categoria" class="form-label">
                                <i class="fas fa-folder me-1"></i>Categoría <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('categoria') is-invalid @enderror" id="categoria" name="categoria">
                                <option value="">Seleccionar categoría</option>
                                @foreach($categorias as $key => $categoria)
                                    <option value="{{ $categoria }}" {{ old('categoria') == $categoria ? 'selected' : '' }}>
                                        {{ $categoria }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div class="col-md-6 mb-3">
                            <label for="estado" class="form-label">
                                <i class="fas fa-toggle-on me-1"></i>Estado <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado">
                                <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                <option value="agotado" {{ old('estado') == 'agotado' ? 'selected' : '' }}>Agotado</option>
                                <option value="discontinuado" {{ old('estado') == 'discontinuado' ? 'selected' : '' }}>Discontinuado</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Marca -->
                        <div class="col-md-4 mb-3">
                            <label for="marca" class="form-label">
                                <i class="fas fa-tag me-1"></i>Marca
                            </label>
                            <input type="text" 
                                   class="form-control @error('marca') is-invalid @enderror" 
                                   id="marca" 
                                   name="marca" 
                                   value="{{ old('marca') }}" 
                                   placeholder="Ej: Samsung, HP, Dell">
                            @error('marca')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Modelo -->
                        <div class="col-md-4 mb-3">
                            <label for="modelo" class="form-label">
                                <i class="fas fa-cog me-1"></i>Modelo
                            </label>
                            <input type="text" 
                                   class="form-control @error('modelo') is-invalid @enderror" 
                                   id="modelo" 
                                   name="modelo" 
                                   value="{{ old('modelo') }}" 
                                   placeholder="Ej: 870 EVO, Pavilion">
                            @error('modelo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Serie -->
                        <div class="col-md-4 mb-3">
                            <label for="serie" class="form-label">
                                <i class="fas fa-microchip me-1"></i>Número de Serie
                            </label>
                            <input type="text" 
                                   class="form-control @error('serie') is-invalid @enderror" 
                                   id="serie" 
                                   name="serie" 
                                   value="{{ old('serie') }}" 
                                   placeholder="Ej: SN123456789">
                            @error('serie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Stock Mínimo -->
                        <div class="col-md-6 mb-3">
                            <label for="stock_minimo" class="form-label">
                                <i class="fas fa-exclamation-triangle me-1"></i>Stock Mínimo <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('stock_minimo') is-invalid @enderror" 
                                   id="stock_minimo" 
                                   name="stock_minimo" 
                                   value="{{ old('stock_minimo', 0) }}" 
                                   min="0">
                            @error('stock_minimo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Cantidad mínima antes de alertar</small>
                        </div>

                        <!-- Stock Actual -->
                        <div class="col-md-6 mb-3">
                            <label for="stock_actual" class="form-label">
                                <i class="fas fa-boxes me-1"></i>Stock Actual <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('stock_actual') is-invalid @enderror" 
                                   id="stock_actual" 
                                   name="stock_actual" 
                                   value="{{ old('stock_actual', 0) }}" 
                                   min="0">
                            @error('stock_actual')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Precio de Compra -->
                        <div class="col-md-6 mb-3">
                            <label for="precio_compra" class="form-label">
                                <i class="fas fa-dollar-sign me-1"></i>Precio de Compra
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       class="form-control @error('precio_compra') is-invalid @enderror" 
                                       id="precio_compra" 
                                       name="precio_compra" 
                                       value="{{ old('precio_compra') }}" 
                                       step="0.01" 
                                       min="0">
                            </div>
                            @error('precio_compra')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Precio de Venta -->
                        <div class="col-md-6 mb-3">
                            <label for="precio_venta" class="form-label">
                                <i class="fas fa-tags me-1"></i>Precio de Venta
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       class="form-control @error('precio_venta') is-invalid @enderror" 
                                       id="precio_venta" 
                                       name="precio_venta" 
                                       value="{{ old('precio_venta') }}" 
                                       step="0.01" 
                                       min="0">
                            </div>
                            @error('precio_venta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Proveedor -->
                        <div class="col-md-6 mb-3">
                            <label for="proveedor" class="form-label">
                                <i class="fas fa-truck me-1"></i>Proveedor
                            </label>
                            <input type="text" 
                                   class="form-control @error('proveedor') is-invalid @enderror" 
                                   id="proveedor" 
                                   name="proveedor" 
                                   value="{{ old('proveedor') }}" 
                                   placeholder="Ej: Distribuidora ABC">
                            @error('proveedor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Ubicación -->
                        <div class="col-md-6 mb-3">
                            <label for="ubicacion" class="form-label">
                                <i class="fas fa-map-marker-alt me-1"></i>Ubicación
                            </label>
                            <input type="text" 
                                   class="form-control @error('ubicacion') is-invalid @enderror" 
                                   id="ubicacion" 
                                   name="ubicacion" 
                                   value="{{ old('ubicacion') }}" 
                                   placeholder="Ej: Almacén A, Estante 3">
                            @error('ubicacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Fecha de Compra -->
                        <div class="col-md-6 mb-3">
                            <label for="fecha_compra" class="form-label">
                                <i class="fas fa-calendar me-1"></i>Fecha de Compra
                            </label>
                            <input type="date" 
                                   class="form-control @error('fecha_compra') is-invalid @enderror" 
                                   id="fecha_compra" 
                                   name="fecha_compra" 
                                   value="{{ old('fecha_compra') }}">
                            @error('fecha_compra')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Fecha de Vencimiento -->
                        <div class="col-md-6 mb-3">
                            <label for="fecha_vencimiento" class="form-label">
                                <i class="fas fa-calendar-times me-1"></i>Fecha de Vencimiento
                            </label>
                            <input type="date" 
                                   class="form-control @error('fecha_vencimiento') is-invalid @enderror" 
                                   id="fecha_vencimiento" 
                                   name="fecha_vencimiento" 
                                   value="{{ old('fecha_vencimiento') }}">
                            @error('fecha_vencimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Imagen -->
                    <div class="mb-3">
                        <label for="imagen" class="form-label">
                            <i class="fas fa-image me-1"></i>Imagen del Producto
                        </label>
                        <input type="file" 
                               class="form-control @error('imagen') is-invalid @enderror" 
                               id="imagen" 
                               name="imagen" 
                               accept="image/*">
                        @error('imagen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Formatos permitidos: JPG, PNG, GIF. Máximo 2MB</small>
                    </div>

                    <!-- Notas -->
                    <div class="mb-3">
                        <label for="notas" class="form-label">
                            <i class="fas fa-sticky-note me-1"></i>Notas Adicionales
                        </label>
                        <textarea class="form-control @error('notas') is-invalid @enderror" 
                                  id="notas" 
                                  name="notas" 
                                  rows="3" 
                                  placeholder="Información adicional, observaciones...">{{ old('notas') }}</textarea>
                        @error('notas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Guardar Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Panel de Ayuda -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-question-circle text-info me-2"></i>
                    Ayuda
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6><i class="fas fa-info-circle text-primary me-1"></i>Campos Obligatorios</h6>
                    <ul class="list-unstyled small">
                        <li><i class="fas fa-check text-success me-1"></i>Código (único)</li>
                        <li><i class="fas fa-check text-success me-1"></i>Nombre del producto</li>
                        <li><i class="fas fa-check text-success me-1"></i>Categoría</li>
                        <li><i class="fas fa-check text-success me-1"></i>Stock mínimo y actual</li>
                        <li><i class="fas fa-check text-success me-1"></i>Estado</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6><i class="fas fa-lightbulb text-warning me-1"></i>Consejos</h6>
                    <ul class="list-unstyled small">
                        <li><i class="fas fa-arrow-right text-muted me-1"></i>Usa códigos descriptivos</li>
                        <li><i class="fas fa-arrow-right text-muted me-1"></i>Incluye marca y modelo</li>
                        <li><i class="fas fa-arrow-right text-muted me-1"></i>Establece stock mínimo realista</li>
                        <li><i class="fas fa-arrow-right text-muted me-1"></i>Especifica ubicación clara</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6><i class="fas fa-exclamation-triangle text-warning me-1"></i>Estados</h6>
                    <ul class="list-unstyled small">
                        <li><span class="badge bg-success me-1">Activo</span>Disponible para uso</li>
                        <li><span class="badge bg-secondary me-1">Inactivo</span>Temporalmente no disponible</li>
                        <li><span class="badge bg-warning me-1">Agotado</span>Sin stock disponible</li>
                        <li><span class="badge bg-danger me-1">Discontinuado</span>Ya no se vende</li>
                    </ul>
                </div>

                <div class="alert alert-info border-0">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Tip:</strong> Puedes generar un código automático dejando el campo código vacío.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Generar código automático si el campo está vacío
document.getElementById('nombre').addEventListener('input', function() {
    const codigoField = document.getElementById('codigo');
    if (!codigoField.value) {
        const nombre = this.value;
        if (nombre.length > 0) {
            // Generar código basado en el nombre
            const codigo = 'INV-' + nombre.substring(0, 3).toUpperCase() + '-' + Date.now().toString().substring(-4);
            codigoField.value = codigo;
        }
    }
});

// Validación de fechas
document.getElementById('fecha_vencimiento').addEventListener('change', function() {
    const fechaCompra = document.getElementById('fecha_compra').value;
    const fechaVencimiento = this.value;
    
    if (fechaCompra && fechaVencimiento && fechaVencimiento < fechaCompra) {
        alert('La fecha de vencimiento no puede ser anterior a la fecha de compra');
        this.value = '';
    }
});

// Calcular margen de ganancia automáticamente
function calcularMargen() {
    const precioCompra = parseFloat(document.getElementById('precio_compra').value) || 0;
    const precioVenta = parseFloat(document.getElementById('precio_venta').value) || 0;
    
    if (precioCompra > 0 && precioVenta > 0) {
        const margen = ((precioVenta - precioCompra) / precioCompra) * 100;
        console.log(`Margen de ganancia: ${margen.toFixed(1)}%`);
    }
}

document.getElementById('precio_compra').addEventListener('input', calcularMargen);
document.getElementById('precio_venta').addEventListener('input', calcularMargen);
</script>
@endsection

@section('styles')
<style>
.form-label {
    font-weight: 500;
    color: #495057;
}

.form-control:focus, .form-select:focus {
    border-color: #27DB9F;
    box-shadow: 0 0 0 0.2rem rgba(39, 219, 159, 0.25);
}

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

.btn-primary {
    background: #27DB9F;
    border: none;
}

.btn-primary:hover {
    background: #22c495;
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(39, 219, 159, 0.3);
}
</style>
@endsection
