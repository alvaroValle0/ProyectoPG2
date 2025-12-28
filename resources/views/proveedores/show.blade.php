@extends('layouts.app')

@section('title', 'Detalles del Proveedor')

@section('content')
<div class="container-fluid">
    <!-- Header del Proveedor -->
    <div class="provider-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="provider-info-header">
                    <div class="provider-avatar-large">
                        <div class="avatar-circle-large">
                            {{ $proveedor->getIniciales() }}
                        </div>
                        <div class="provider-details">
                            <h1 class="provider-name">{{ $proveedor->nombre_empresa }}</h1>
                            @if($proveedor->nombre_contacto)
                                <p class="provider-contact-name">
                                    <i class="fas fa-user me-2"></i>{{ $proveedor->nombre_contacto }}
                                </p>
                            @endif
                            <div class="provider-badges">
                                <span class="service-badge service-{{ $proveedor->tipo_servicio }}">
                                    <i class="fas fa-{{ $proveedor->tipo_servicio === 'reparacion' ? 'tools' : ($proveedor->tipo_servicio === 'mantenimiento' ? 'wrench' : ($proveedor->tipo_servicio === 'suministros' ? 'box' : ($proveedor->tipo_servicio === 'software' ? 'code' : ($proveedor->tipo_servicio === 'hardware' ? 'microchip' : ($proveedor->tipo_servicio === 'consultoria' ? 'lightbulb' : 'ellipsis-h')))) }} me-1"></i>
                                    {{ $proveedor->tipo_servicio_label }}
                                </span>
                                <span class="status-badge status-{{ $proveedor->activo ? 'active' : 'inactive' }}">
                                    <i class="fas fa-{{ $proveedor->activo ? 'check-circle' : 'times-circle' }} me-1"></i>
                                    {{ $proveedor->estado_label }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-end">
                <div class="provider-actions">
                    <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-warning btn-modern">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    <a href="{{ route('proveedores.index') }}" class="btn btn-outline-secondary btn-modern">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas del Proveedor -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-card-primary">
                <div class="stat-card-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-number" data-count="{{ $estadisticas['total_inventarios'] }}">0</h3>
                    <p class="stat-card-label">Inventarios</p>
                    <div class="stat-card-trend">
                        <i class="fas fa-chart-line"></i>
                        <span>Productos suministrados</span>
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
                    <h3 class="stat-card-number" data-count="{{ $estadisticas['inventarios_activos'] }}">0</h3>
                    <p class="stat-card-label">Inventarios Activos</p>
                    <div class="stat-card-trend">
                        <i class="fas fa-percentage"></i>
                        <span>En stock</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-card-info">
                <div class="stat-card-icon">
                    <i class="fas fa-wrench"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-number" data-count="{{ $estadisticas['total_reparaciones'] }}">0</h3>
                    <p class="stat-card-label">Reparaciones</p>
                    <div class="stat-card-trend">
                        <i class="fas fa-tools"></i>
                        <span>Servicios realizados</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-card-warning">
                <div class="stat-card-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-number">{{ $proveedor->calificacion ? number_format($proveedor->calificacion, 1) : 'N/A' }}</h3>
                    <p class="stat-card-label">Calificación</p>
                    <div class="stat-card-trend">
                        <i class="fas fa-star"></i>
                        <span>{{ $proveedor->calificacion_estrellas }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Detallada -->
    <div class="row">
        <!-- Información General -->
        <div class="col-lg-8">
            <div class="info-card mb-4">
                <div class="info-card-header">
                    <h5><i class="fas fa-info-circle text-primary me-2"></i>Información General</h5>
                </div>
                <div class="info-card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-building me-2"></i>Empresa:</label>
                                <span>{{ $proveedor->nombre_empresa }}</span>
                            </div>
                            @if($proveedor->nombre_contacto)
                            <div class="info-item">
                                <label><i class="fas fa-user me-2"></i>Contacto:</label>
                                <span>{{ $proveedor->nombre_contacto }}</span>
                            </div>
                            @endif
                            <div class="info-item">
                                <label><i class="fas fa-cogs me-2"></i>Tipo de Servicio:</label>
                                <span class="service-badge service-{{ $proveedor->tipo_servicio }}">
                                    {{ $proveedor->tipo_servicio_label }}
                                </span>
                            </div>
                            @if($proveedor->nit)
                            <div class="info-item">
                                <label><i class="fas fa-id-card me-2"></i>NIT:</label>
                                <span>{{ $proveedor->nit }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($proveedor->telefono)
                            <div class="info-item">
                                <label><i class="fas fa-phone me-2"></i>Teléfono:</label>
                                <a href="tel:{{ $proveedor->telefono }}" class="info-link">{{ $proveedor->telefono }}</a>
                            </div>
                            @endif
                            @if($proveedor->email)
                            <div class="info-item">
                                <label><i class="fas fa-envelope me-2"></i>Email:</label>
                                <a href="mailto:{{ $proveedor->email }}" class="info-link">{{ $proveedor->email }}</a>
                            </div>
                            @endif
                            @if($proveedor->tiempo_respuesta)
                            <div class="info-item">
                                <label><i class="fas fa-clock me-2"></i>Tiempo de Respuesta:</label>
                                <span>{{ $proveedor->tiempo_respuesta }}</span>
                            </div>
                            @endif
                            <div class="info-item">
                                <label><i class="fas fa-calendar me-2"></i>Registrado:</label>
                                <span>{{ $proveedor->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($proveedor->direccion)
            <div class="info-card mb-4">
                <div class="info-card-header">
                    <h5><i class="fas fa-map-marker-alt text-primary me-2"></i>Ubicación</h5>
                </div>
                <div class="info-card-body">
                    <div class="info-item">
                        <label><i class="fas fa-map-marker-alt me-2"></i>Dirección:</label>
                        <span>{{ $proveedor->direccion }}</span>
                    </div>
                </div>
            </div>
            @endif

            @if($proveedor->descripcion_servicios)
            <div class="info-card mb-4">
                <div class="info-card-header">
                    <h5><i class="fas fa-list text-primary me-2"></i>Descripción de Servicios</h5>
                </div>
                <div class="info-card-body">
                    <div class="info-description">
                        {{ $proveedor->descripcion_servicios }}
                    </div>
                </div>
            </div>
            @endif

            @if($proveedor->observaciones)
            <div class="info-card mb-4">
                <div class="info-card-header">
                    <h5><i class="fas fa-sticky-note text-primary me-2"></i>Observaciones</h5>
                </div>
                <div class="info-card-body">
                    <div class="info-description">
                        {{ $proveedor->observaciones }}
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Panel Lateral -->
        <div class="col-lg-4">
            <!-- Calificación -->
            <div class="info-card mb-4">
                <div class="info-card-header">
                    <h5><i class="fas fa-star text-warning me-2"></i>Calificación</h5>
                </div>
                <div class="info-card-body text-center">
                    @if($proveedor->calificacion)
                        <div class="rating-display-large">
                            <div class="stars-large">
                                {{ $proveedor->calificacion_estrellas }}
                            </div>
                            <h3 class="rating-number">{{ number_format($proveedor->calificacion, 1) }}/5</h3>
                        </div>
                        <button class="btn btn-outline-primary btn-sm" onclick="updateRating({{ $proveedor->id }})">
                            <i class="fas fa-edit me-1"></i>Actualizar Calificación
                        </button>
                    @else
                        <div class="no-rating-large">
                            <i class="fas fa-star"></i>
                            <p>Sin calificar</p>
                            <button class="btn btn-primary btn-sm" onclick="updateRating({{ $proveedor->id }})">
                                <i class="fas fa-star me-1"></i>Calificar
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="info-card mb-4">
                <div class="info-card-header">
                    <h5><i class="fas fa-bolt text-primary me-2"></i>Acciones Rápidas</h5>
                </div>
                <div class="info-card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Editar Proveedor
                        </a>
                        <button type="button" 
                                class="btn btn-{{ $proveedor->activo ? 'secondary' : 'success' }}"
                                onclick="toggleProveedorStatus({{ $proveedor->id }})">
                            <i class="fas fa-{{ $proveedor->activo ? 'times' : 'check' }} me-2"></i>
                            {{ $proveedor->activo ? 'Desactivar' : 'Activar' }}
                        </button>
                        @if($proveedor->telefono)
                        <a href="tel:{{ $proveedor->telefono }}" class="btn btn-outline-success">
                            <i class="fas fa-phone me-2"></i>Llamar
                        </a>
                        @endif
                        @if($proveedor->email)
                        <a href="mailto:{{ $proveedor->email }}" class="btn btn-outline-info">
                            <i class="fas fa-envelope me-2"></i>Enviar Email
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Última Compra -->
            @if($estadisticas['ultima_compra'])
            <div class="info-card">
                <div class="info-card-header">
                    <h5><i class="fas fa-shopping-cart text-primary me-2"></i>Última Compra</h5>
                </div>
                <div class="info-card-body">
                    <div class="info-item">
                        <label>Producto:</label>
                        <span>{{ $estadisticas['ultima_compra']->nombre }}</span>
                    </div>
                    <div class="info-item">
                        <label>Fecha:</label>
                        <span>{{ $estadisticas['ultima_compra']->fecha_compra->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-item">
                        <label>Precio:</label>
                        <span>Q{{ number_format($estadisticas['ultima_compra']->precio_compra, 2) }}</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para actualizar calificación -->
<div class="modal fade" id="ratingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualizar Calificación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="ratingForm">
                    @csrf
                    <div class="mb-3">
                        <label for="calificacion" class="form-label">Calificación</label>
                        <select class="form-select" id="calificacion" name="calificacion" required>
                            <option value="">Selecciona una calificación</option>
                            <option value="5">5 - Excelente</option>
                            <option value="4">4 - Muy bueno</option>
                            <option value="3">3 - Bueno</option>
                            <option value="2">2 - Regular</option>
                            <option value="1">1 - Malo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="saveRating({{ $proveedor->id }})">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Estilos específicos para la vista de detalles del proveedor */
.provider-header {
    background: var(--system-gradient);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: var(--shadow-lg);
    margin-bottom: 2rem;
}

.provider-avatar-large {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.avatar-circle-large {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 2rem;
    flex-shrink: 0;
    border: 3px solid rgba(255, 255, 255, 0.3);
}

.provider-details {
    flex: 1;
}

.provider-name {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.provider-contact-name {
    font-size: 1.2rem;
    opacity: 0.9;
    margin: 0.5rem 0;
}

.provider-badges {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.service-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

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
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.status-inactive {
    background: rgba(239, 68, 68, 0.2);
    color: #ef4444;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.provider-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    justify-content: flex-end;
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

/* Info Cards */
.info-card {
    background: white;
    border-radius: 15px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.info-card-header {
    background: var(--light-color);
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.info-card-header h5 {
    margin: 0;
    font-weight: 600;
    color: var(--dark-color);
}

.info-card-body {
    padding: 1.5rem;
}

.info-item {
    display: flex;
    margin-bottom: 1rem;
    align-items: flex-start;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-item label {
    font-weight: 600;
    color: var(--dark-color);
    min-width: 150px;
    margin-bottom: 0;
}

.info-item span {
    flex: 1;
    color: #6b7280;
}

.info-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

.info-link:hover {
    color: var(--primary-light);
    text-decoration: underline;
}

.info-description {
    color: #6b7280;
    line-height: 1.6;
    white-space: pre-line;
}

/* Rating Display */
.rating-display-large {
    margin-bottom: 1.5rem;
}

.stars-large {
    font-size: 2rem;
    color: #fbbf24;
    margin-bottom: 0.5rem;
}

.rating-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark-color);
    margin: 0;
}

.no-rating-large {
    padding: 2rem;
    color: #9ca3af;
}

.no-rating-large i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.no-rating-large p {
    margin: 1rem 0;
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 768px) {
    .provider-header {
        padding: 1.5rem;
    }
    
    .provider-avatar-large {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .provider-name {
        font-size: 2rem;
    }
    
    .provider-badges {
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .provider-actions {
        justify-content: center;
        margin-top: 1rem;
    }
    
    .info-item {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .info-item label {
        min-width: auto;
    }
}
</style>
@endsection

@section('scripts')
<script>
// Función para actualizar calificación
function updateRating(proveedorId) {
    const modal = new bootstrap.Modal(document.getElementById('ratingModal'));
    modal.show();
}

// Función para guardar calificación
function saveRating(proveedorId) {
    const calificacion = document.getElementById('calificacion').value;
    
    if (!calificacion) {
        alert('Por favor selecciona una calificación');
        return;
    }
    
    fetch(`/proveedores/${proveedorId}/update-rating`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            calificacion: parseFloat(calificacion)
        })
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
        alert('Error al actualizar la calificación');
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

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    animateCounters();
});
</script>
@endsection
