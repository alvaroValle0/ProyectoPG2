@extends('layouts.app')

@section('title', 'Gestión de Equipos')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-laptop text-primary me-2"></i>
            Gestión de Equipos
        </h1>
        <p class="text-muted">Lista completa de equipos registrados en el sistema</p>
    </div>
    <div class="col-md-4 text-end">
        @if(\App\Helpers\PermissionHelper::can('create_equipo'))
        <a href="{{ route('equipos.create') }}" class="btn btn-primary btn-custom">
            <i class="fas fa-plus me-2"></i>Nuevo Equipo
        </a>
        @endif
    </div>
</div>

<!-- Filtros -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('equipos.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select">
                    <option value="">Todos los estados</option>
                    <option value="recibido" {{ request('estado') == 'recibido' ? 'selected' : '' }}>Recibido</option>
                    <option value="en_reparacion" {{ request('estado') == 'en_reparacion' ? 'selected' : '' }}>En Reparación</option>
                    <option value="reparado" {{ request('estado') == 'reparado' ? 'selected' : '' }}>Reparado</option>
                    <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Cliente</label>
                <input type="text" name="cliente" class="form-control" placeholder="Nombre del cliente" value="{{ request('cliente') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Número de Serie</label>
                <input type="text" name="numero_serie" class="form-control" placeholder="Serie" value="{{ request('numero_serie') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Fecha Desde</label>
                <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search me-2"></i>Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Estadísticas Rápidas -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-primary text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-inbox display-6 mb-2"></i>
                <h4>{{ $equipos->total() }}</h4>
                <p class="mb-0">Total Equipos</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-warning text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-wrench display-6 mb-2"></i>
                <h4>{{ $equipos->where('estado', 'en_reparacion')->count() }}</h4>
                <p class="mb-0">En Reparación</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-success text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-check display-6 mb-2"></i>
                <h4>{{ $equipos->where('estado', 'reparado')->count() }}</h4>
                <p class="mb-0">Reparados</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 bg-info text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-handshake display-6 mb-2"></i>
                <h4>{{ $equipos->where('estado', 'entregado')->count() }}</h4>
                <p class="mb-0">Entregados</p>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Equipos -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($equipos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Número de Serie</th>
                            <th>Equipo</th>
                            <th>Cliente</th>
                            <th>Fecha Ingreso</th>
                            <th>Estado</th>
                            <th>Técnico Asignado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipos as $equipo)
                        <tr>
                            <td>
                                <strong>{{ $equipo->numero_serie }}</strong>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $equipo->marca }} {{ $equipo->modelo }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $equipo->tipo_equipo }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $equipo->cliente_nombre }}</strong>
                                    @if($equipo->cliente_telefono)
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-phone me-1"></i>{{ $equipo->cliente_telefono }}
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $equipo->fecha_ingreso->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $equipo->estado_color }} text-white">
                                    {{ ucfirst(str_replace('_', ' ', $equipo->estado)) }}
                                </span>
                            </td>
                            <td>
                                @if($equipo->tecnico_asignado)
                                    <div>
                                        <strong>{{ $equipo->tecnico_asignado->nombre_completo }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $equipo->tecnico_asignado->especialidad }}</small>
                                    </div>
                                @else
                                    <small class="text-muted">Sin asignar</small>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('equipos.show', $equipo) }}" class="btn btn-outline-primary" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(\App\Helpers\PermissionHelper::can('edit_equipo'))
                                    <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-outline-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    @if(\App\Helpers\PermissionHelper::can('create_reparacion') && in_array($equipo->estado, ['recibido', 'en_reparacion']))
                                        <a href="{{ route('reparaciones.create', ['equipo_id' => $equipo->id]) }}" class="btn btn-outline-success" title="Nueva reparación">
                                            <i class="fas fa-wrench"></i>
                                        </a>
                                    @endif
                                    @if(\App\Helpers\PermissionHelper::can('delete_equipo'))
                                    <form action="{{ route('equipos.destroy', $equipo) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar el equipo {{ $equipo->marca }} {{ $equipo->modelo }} ({{ $equipo->numero_serie }})?\n\nEsta acción no se puede deshacer.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Eliminar equipo">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                {{ $equipos->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-laptop display-1 text-muted mb-4"></i>
                <h4 class="text-muted">No se encontraron equipos</h4>
                <p class="text-muted">No hay equipos que coincidan con los filtros aplicados.</p>
                <a href="{{ route('equipos.create') }}" class="btn btn-primary btn-custom">
                    <i class="fas fa-plus me-2"></i>Registrar Primer Equipo
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
.btn-outline-danger {
    transition: all 0.3s ease;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
    transform: scale(1.05);
}

.btn-group-sm > .btn {
    padding: 0.375rem 0.5rem;
    font-size: 0.875rem;
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

@media (max-width: 768px) {
    .btn-group-sm > .btn {
        padding: 0.25rem 0.375rem;
        font-size: 0.8rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
// Script para cambio rápido de estado
function cambiarEstado(equipoId, nuevoEstado) {
    if (confirm('¿Está seguro de cambiar el estado del equipo?')) {
        fetch(`/equipos/${equipoId}/cambiar-estado`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                estado: nuevoEstado
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al cambiar el estado: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cambiar el estado del equipo');
        });
    }
}

// El botón de eliminar ahora usa un formulario inline con confirmación nativa
</script>
@endsection