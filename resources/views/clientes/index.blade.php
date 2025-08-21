@extends('layouts.app')

@section('title', 'Gestión de Clientes')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-users text-primary me-2"></i>
                Gestión de Clientes
            </h1>
            <p class="text-muted mb-0">Administra la información de tus clientes</p>
        </div>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus me-2"></i>Nuevo Cliente
        </a>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Clientes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($estadisticas['total_clientes']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Clientes Activos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($estadisticas['clientes_activos']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Con Email
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($estadisticas['clientes_con_email']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Con Teléfono
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($estadisticas['clientes_con_telefono']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-phone fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('clientes.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="buscar" class="form-label">Búsqueda Rápida</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               id="buscar" 
                               name="buscar" 
                               value="{{ request('buscar') }}"
                               placeholder="Nombre, teléfono, email, DPI...">
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select" id="estado" name="estado">
                        <option value="">Todos los estados</option>
                        <option value="activo" {{ request('estado') === 'activo' ? 'selected' : '' }}>Activos</option>
                        <option value="inactivo" {{ request('estado') === 'inactivo' ? 'selected' : '' }}>Inactivos</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="con_direccion" class="form-label">Dirección</label>
                    <select class="form-select" id="con_direccion" name="con_direccion">
                        <option value="">Todas</option>
                        <option value="si" {{ request('con_direccion') === 'si' ? 'selected' : '' }}>Con dirección</option>
                        <option value="no" {{ request('con_direccion') === 'no' ? 'selected' : '' }}>Sin dirección</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-filter me-1"></i>Filtrar
                    </button>
                    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de Clientes -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Lista de Clientes
                <span class="badge bg-primary ms-2">{{ $clientes->total() }}</span>
            </h6>
        </div>
        <div class="card-body">
            @if($clientes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Cliente</th>
                                <th>Contacto</th>
                                <th>Ubicación</th>
                                <th width="100">Estado</th>
                                <th width="150">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientes as $cliente)
                            <tr>
                                <td class="text-center">
                                    <div class="avatar-sm d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white fw-bold">
                                        {{ $cliente->getIniciales() }}
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-0">{{ $cliente->nombre_completo }}</h6>
                                        @if($cliente->dpi)
                                            <small class="text-muted">
                                                <i class="fas fa-id-card me-1"></i>{{ $cliente->dpi }}
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($cliente->telefono)
                                        <div class="mb-1">
                                            <i class="fas fa-phone text-success me-1"></i>
                                            <a href="tel:{{ $cliente->telefono }}" class="text-decoration-none">
                                                {{ $cliente->telefono }}
                                            </a>
                                        </div>
                                    @endif
                                    @if($cliente->email)
                                        <div>
                                            <i class="fas fa-envelope text-info me-1"></i>
                                            <a href="mailto:{{ $cliente->email }}" class="text-decoration-none">
                                                {{ $cliente->email }}
                                            </a>
                                        </div>
                                    @endif
                                    @if(!$cliente->telefono && !$cliente->email)
                                        <span class="text-muted">Sin contacto</span>
                                    @endif
                                </td>
                                <td>
                                    @if($cliente->direccion)
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ Str::limit($cliente->direccion, 50) }}
                                        </small>
                                    @else
                                        <span class="text-muted">Sin dirección</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $cliente->estado_color }}">
                                        {{ $cliente->estado_label }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('clientes.show', $cliente) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('clientes.edit', $cliente) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-{{ $cliente->activo ? 'secondary' : 'success' }}"
                                                onclick="toggleClienteStatus({{ $cliente->id }})"
                                                title="{{ $cliente->activo ? 'Desactivar' : 'Activar' }}">
                                            <i class="fas fa-{{ $cliente->activo ? 'times' : 'check' }}"></i>
                                        </button>
                                        @if($cliente->reparaciones->count() === 0 && $cliente->equipos->count() === 0)
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="eliminarCliente({{ $cliente->id }}, '{{ $cliente->nombre_completo }}')"
                                                title="Eliminar cliente">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @else
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-secondary disabled" 
                                                onclick="mostrarAdvertenciaEliminacion('{{ $cliente->nombre_completo }}', {{ $cliente->reparaciones->count() }}, {{ $cliente->equipos->count() }})"
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

                <!-- Paginación -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Mostrando {{ $clientes->firstItem() }} a {{ $clientes->lastItem() }} 
                        de {{ $clientes->total() }} resultados
                    </div>
                    {{ $clientes->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No hay clientes registrados</h5>
                    <p class="text-muted">Comienza agregando tu primer cliente</p>
                    <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Agregar Cliente
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true" style="z-index: 1055;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="eliminarModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <h6>¿Estás seguro de que deseas eliminar al cliente?</h6>
                    <p class="fw-bold text-danger" id="clienteNombre"></p>
                </div>
                <div class="alert alert-warning border-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Advertencia:</strong> Esta acción no se puede deshacer y eliminará permanentemente toda la información del cliente.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <form id="eliminarForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="btnEliminar">
                        <i class="fas fa-trash me-2"></i>Eliminar Cliente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
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

function eliminarCliente(clienteId, clienteNombre) {
    console.log('Ejecutando eliminarCliente para ID:', clienteId, 'Nombre:', clienteNombre);
    
    try {
        // Verificar que los elementos existan
        const nombreElement = document.getElementById('clienteNombre');
        const formElement = document.getElementById('eliminarForm');
        const modalElement = document.getElementById('eliminarModal');
        
        if (!nombreElement || !formElement || !modalElement) {
            console.error('Elementos del modal no encontrados');
            throw new Error('Elementos del modal no encontrados');
        }
        
        // Asignar el nombre del cliente al modal
        nombreElement.textContent = clienteNombre;
        
        // Configurar la acción del formulario con la URL correcta
        const deleteUrl = `/clientes/${clienteId}`;
        console.log('Configurando formulario con URL:', deleteUrl);
        formElement.action = deleteUrl;
        
        // Verificar que el token CSRF esté disponible
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('Token CSRF no encontrado');
            throw new Error('Token CSRF no encontrado');
        }
        
        // Limpiar cualquier modal previo
        const existingModal = bootstrap.Modal.getInstance(modalElement);
        if (existingModal) {
            existingModal.dispose();
        }
        
        // Crear y mostrar el modal
        const modal = new bootstrap.Modal(modalElement, {
            backdrop: 'static',
            keyboard: false
        });
        
        console.log('Mostrando modal de confirmación');
        modal.show();
        
    } catch (error) {
        console.error('Error al abrir modal de eliminación:', error);
        
        // Fallback mejorado con confirm
        if (confirm(`¿Estás seguro de que deseas eliminar al cliente "${clienteNombre}"?\n\nEsta acción no se puede deshacer.`)) {
            console.log('Usuario confirmó eliminación, enviando formulario');
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/clientes/${clienteId}`;
            form.style.display = 'none';
            
            // Agregar token CSRF
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            if (csrfMeta) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfMeta.getAttribute('content');
                form.appendChild(csrfInput);
            }
            
            // Agregar método DELETE
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    }
}

// Función para mostrar advertencia cuando no se puede eliminar
function mostrarAdvertenciaEliminacion(clienteNombre, totalReparaciones, totalEquipos) {
    let mensaje = `No se puede eliminar el cliente "${clienteNombre}" porque tiene:\n`;
    if (totalReparaciones > 0) {
        mensaje += `• ${totalReparaciones} reparación(es) asociada(s)\n`;
    }
    if (totalEquipos > 0) {
        mensaje += `• ${totalEquipos} equipo(s) registrado(s)\n`;
    }
    mensaje += `\nPuede desactivar el cliente en su lugar.`;
    
    alert(mensaje);
}

// Mejorar el manejo del formulario de eliminación
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando funciones de eliminación');
    
    const eliminarForm = document.getElementById('eliminarForm');
    if (eliminarForm) {
        console.log('Formulario de eliminación encontrado, agregando listener');
        
        eliminarForm.addEventListener('submit', function(e) {
            console.log('Formulario enviado, URL de acción:', this.action);
            
            // Validar que el formulario tenga una acción válida
            if (!this.action || this.action.includes('undefined')) {
                console.error('URL de acción inválida:', this.action);
                e.preventDefault();
                alert('Error: No se puede eliminar el cliente. URL inválida.');
                return;
            }
            
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Eliminando...';
                
                // Prevenir doble click
                setTimeout(() => {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-trash me-2"></i>Eliminar Cliente';
                    }
                }, 5000);
            }
        });
    } else {
        console.warn('Formulario de eliminación no encontrado en el DOM');
    }
    
    // Limpiar modales al cargar la página
    const modalElement = document.getElementById('eliminarModal');
    if (modalElement) {
        console.log('Modal de eliminación encontrado, agregando listeners');
        
        modalElement.addEventListener('hidden.bs.modal', function () {
            console.log('Modal cerrado, limpiando datos');
            
            // Limpiar el contenido del modal cuando se cierre
            const nombreElement = document.getElementById('clienteNombre');
            if (nombreElement) {
                nombreElement.textContent = '';
            }
            
            const formElement = document.getElementById('eliminarForm');
            if (formElement) {
                formElement.action = '';
            }
        });
        
        // Agregar evento para cuando se muestre el modal
        modalElement.addEventListener('shown.bs.modal', function () {
            console.log('Modal mostrado correctamente');
        });
    } else {
        console.warn('Modal de eliminación no encontrado en el DOM');
    }
});
</script>
@endsection

@section('styles')
<style>
.avatar-sm {
    width: 35px;
    height: 35px;
    font-size: 0.875rem;
}

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

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.075) !important;
}

/* Estilos específicos para el modal de eliminación */
#eliminarModal {
    z-index: 1055 !important;
}

#eliminarModal .modal-backdrop {
    z-index: 1054 !important;
    background-color: rgba(0, 0, 0, 0.5) !important;
}

#eliminarModal .modal-dialog {
    z-index: 1056 !important;
}

/* Asegurar que el modal esté por encima de todo */
.modal-open {
    padding-right: 0 !important;
}

.modal-backdrop.show {
    opacity: 0.5 !important;
}

/* Animación mejorada para el modal */
#eliminarModal.fade.show .modal-dialog {
    transform: translate(0, 0) scale(1);
}

#eliminarModal.fade .modal-dialog {
    transform: translate(0, -50px) scale(0.95);
    transition: transform 0.3s ease-out;
}

/* Botón de eliminar con estado de carga */
#btnEliminar:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}
</style>
@endsection