@extends('layouts.app')

@section('title', 'Gestión de Permisos - ' . $user->name)

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-user-shield text-primary me-2"></i>
            Gestión de Permisos
        </h1>
        <p class="text-muted">Configurar permisos específicos para {{ $user->name }}</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <!-- Información del Usuario -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                         style="width: 80px; height: 80px; font-size: 2rem; background: #27DB9F;">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <h5 class="card-title">{{ $user->name }}</h5>
                <p class="text-muted mb-2">{{ $user->email }}</p>
                <span class="badge bg-{{ $user->estado_color }}">{{ $user->estado_label }}</span>
                <hr>
                <div class="text-start">
                    <small class="text-muted">
                        <strong>Usuario:</strong> {{ $user->username }}<br>
                        <strong>Rol:</strong> {{ $user->rol_label }}<br>
                        <strong>Registrado:</strong> {{ $user->created_at->format('d/m/Y') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <form action="{{ route('usuarios.permissions.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Módulos Principales -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-th-large me-2"></i>
                        Acceso a Módulos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_dashboard" id="access_dashboard" 
                                       {{ $permissions->access_dashboard ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_dashboard">
                                    <i class="fas fa-tachometer-alt text-primary me-2"></i>
                                    <strong>Dashboard</strong>
                                    <br><small class="text-muted">Panel principal y estadísticas</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_clientes" id="access_clientes" 
                                       {{ $permissions->access_clientes ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_clientes">
                                    <i class="fas fa-users text-info me-2"></i>
                                    <strong>Clientes</strong>
                                    <br><small class="text-muted">Gestión de clientes</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_equipos" id="access_equipos" 
                                       {{ $permissions->access_equipos ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_equipos">
                                    <i class="fas fa-laptop text-warning me-2"></i>
                                    <strong>Equipos</strong>
                                    <br><small class="text-muted">Gestión de equipos</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_reparaciones" id="access_reparaciones" 
                                       {{ $permissions->access_reparaciones ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_reparaciones">
                                    <i class="fas fa-wrench text-success me-2"></i>
                                    <strong>Reparaciones</strong>
                                    <br><small class="text-muted">Gestión de reparaciones</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_inventario" id="access_inventario" 
                                       {{ $permissions->access_inventario ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_inventario">
                                    <i class="fas fa-boxes text-secondary me-2"></i>
                                    <strong>Inventario</strong>
                                    <br><small class="text-muted">Gestión de inventario</small>
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_tickets" id="access_tickets" 
                                       {{ $permissions->access_tickets ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_tickets">
                                    <i class="fas fa-ticket-alt text-danger me-2"></i>
                                    <strong>Tickets</strong>
                                    <br><small class="text-muted">Gestión de tickets</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_tecnicos" id="access_tecnicos" 
                                       {{ $permissions->access_tecnicos ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_tecnicos">
                                    <i class="fas fa-users-cog text-dark me-2"></i>
                                    <strong>Técnicos</strong>
                                    <br><small class="text-muted">Gestión de técnicos</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_usuarios" id="access_usuarios" 
                                       {{ $permissions->access_usuarios ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_usuarios">
                                    <i class="fas fa-users text-primary me-2"></i>
                                    <strong>Usuarios</strong>
                                    <br><small class="text-muted">Gestión de usuarios</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_configuracion" id="access_configuracion" 
                                       {{ $permissions->access_configuracion ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_configuracion">
                                    <i class="fas fa-cog text-secondary me-2"></i>
                                    <strong>Configuración</strong>
                                    <br><small class="text-muted">Configuración del sistema</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_reportes" id="access_reportes" 
                                       {{ $permissions->access_reportes ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_reportes">
                                    <i class="fas fa-chart-line text-info me-2"></i>
                                    <strong>Reportes</strong>
                                    <br><small class="text-muted">Acceso a reportes</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Permisos Específicos -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-tasks me-2"></i>
                        Permisos Específicos
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Equipos -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-laptop me-2"></i>Equipos
                            </h6>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="view_equipo" id="view_equipo" 
                                       {{ $permissions->view_equipo ? 'checked' : '' }}>
                                <label class="form-check-label" for="view_equipo">
                                    <i class="fas fa-eye text-info me-1"></i>Ver
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="create_equipo" id="create_equipo" 
                                       {{ $permissions->create_equipo ? 'checked' : '' }}>
                                <label class="form-check-label" for="create_equipo">
                                    <i class="fas fa-plus text-success me-1"></i>Crear
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="edit_equipo" id="edit_equipo" 
                                       {{ $permissions->edit_equipo ? 'checked' : '' }}>
                                <label class="form-check-label" for="edit_equipo">
                                    <i class="fas fa-edit text-warning me-1"></i>Editar
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="delete_equipo" id="delete_equipo" 
                                       {{ $permissions->delete_equipo ? 'checked' : '' }}>
                                <label class="form-check-label" for="delete_equipo">
                                    <i class="fas fa-trash text-danger me-1"></i>Eliminar
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Reparaciones -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-success mb-3">
                                <i class="fas fa-wrench me-2"></i>Reparaciones
                            </h6>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="view_reparacion" id="view_reparacion" 
                                       {{ $permissions->view_reparacion ? 'checked' : '' }}>
                                <label class="form-check-label" for="view_reparacion">
                                    <i class="fas fa-eye text-info me-1"></i>Ver
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="create_reparacion" id="create_reparacion" 
                                       {{ $permissions->create_reparacion ? 'checked' : '' }}>
                                <label class="form-check-label" for="create_reparacion">
                                    <i class="fas fa-plus text-success me-1"></i>Crear
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="edit_reparacion" id="edit_reparacion" 
                                       {{ $permissions->edit_reparacion ? 'checked' : '' }}>
                                <label class="form-check-label" for="edit_reparacion">
                                    <i class="fas fa-edit text-warning me-1"></i>Editar
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="delete_reparacion" id="delete_reparacion" 
                                       {{ $permissions->delete_reparacion ? 'checked' : '' }}>
                                <label class="form-check-label" for="delete_reparacion">
                                    <i class="fas fa-trash text-danger me-1"></i>Eliminar
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Clientes -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-info mb-3">
                                <i class="fas fa-users me-2"></i>Clientes
                            </h6>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="view_cliente" id="view_cliente" 
                                       {{ $permissions->view_cliente ? 'checked' : '' }}>
                                <label class="form-check-label" for="view_cliente">
                                    <i class="fas fa-eye text-info me-1"></i>Ver
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="create_cliente" id="create_cliente" 
                                       {{ $permissions->create_cliente ? 'checked' : '' }}>
                                <label class="form-check-label" for="create_cliente">
                                    <i class="fas fa-plus text-success me-1"></i>Crear
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="edit_cliente" id="edit_cliente" 
                                       {{ $permissions->edit_cliente ? 'checked' : '' }}>
                                <label class="form-check-label" for="edit_cliente">
                                    <i class="fas fa-edit text-warning me-1"></i>Editar
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="delete_cliente" id="delete_cliente" 
                                       {{ $permissions->delete_cliente ? 'checked' : '' }}>
                                <label class="form-check-label" for="delete_cliente">
                                    <i class="fas fa-trash text-danger me-1"></i>Eliminar
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Inventario -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-secondary mb-3">
                                <i class="fas fa-boxes me-2"></i>Inventario
                            </h6>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="view_inventario" id="view_inventario" 
                                       {{ $permissions->view_inventario ? 'checked' : '' }}>
                                <label class="form-check-label" for="view_inventario">
                                    <i class="fas fa-eye text-info me-1"></i>Ver
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="create_inventario" id="create_inventario" 
                                       {{ $permissions->create_inventario ? 'checked' : '' }}>
                                <label class="form-check-label" for="create_inventario">
                                    <i class="fas fa-plus text-success me-1"></i>Crear
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="edit_inventario" id="edit_inventario" 
                                       {{ $permissions->edit_inventario ? 'checked' : '' }}>
                                <label class="form-check-label" for="edit_inventario">
                                    <i class="fas fa-edit text-warning me-1"></i>Editar
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="delete_inventario" id="delete_inventario" 
                                       {{ $permissions->delete_inventario ? 'checked' : '' }}>
                                <label class="form-check-label" for="delete_inventario">
                                    <i class="fas fa-trash text-danger me-1"></i>Eliminar
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tickets -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-danger mb-3">
                                <i class="fas fa-ticket-alt me-2"></i>Tickets
                            </h6>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="view_ticket" id="view_ticket" 
                                       {{ $permissions->view_ticket ? 'checked' : '' }}>
                                <label class="form-check-label" for="view_ticket">
                                    <i class="fas fa-eye text-info me-1"></i>Ver
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="create_ticket" id="create_ticket" 
                                       {{ $permissions->create_ticket ? 'checked' : '' }}>
                                <label class="form-check-label" for="create_ticket">
                                    <i class="fas fa-plus text-success me-1"></i>Crear
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="edit_ticket" id="edit_ticket" 
                                       {{ $permissions->edit_ticket ? 'checked' : '' }}>
                                <label class="form-check-label" for="edit_ticket">
                                    <i class="fas fa-edit text-warning me-1"></i>Editar
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="delete_ticket" id="delete_ticket" 
                                       {{ $permissions->delete_ticket ? 'checked' : '' }}>
                                <label class="form-check-label" for="delete_ticket">
                                    <i class="fas fa-trash text-danger me-1"></i>Eliminar
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Gestión -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-dark mb-3">
                                <i class="fas fa-cogs me-2"></i>Gestión del Sistema
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="manage_users" id="manage_users" 
                                       {{ $permissions->manage_users ? 'checked' : '' }}>
                                <label class="form-check-label" for="manage_users">
                                    <i class="fas fa-users-cog text-primary me-1"></i>
                                    <strong>Gestionar Usuarios</strong>
                                    <br><small class="text-muted">Crear, editar y eliminar usuarios</small>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="manage_tecnicos" id="manage_tecnicos" 
                                       {{ $permissions->manage_tecnicos ? 'checked' : '' }}>
                                <label class="form-check-label" for="manage_tecnicos">
                                    <i class="fas fa-user-cog text-secondary me-1"></i>
                                    <strong>Gestionar Técnicos</strong>
                                    <br><small class="text-muted">Crear, editar y eliminar técnicos</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Botones de Acción -->
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <button type="submit" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-save me-2"></i>Guardar Permisos
                    </button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
.form-check-input:checked {
    background-color: #27DB9F;
    border-color: #27DB9F;
}

.form-check-input:focus {
    border-color: #27DB9F;
    box-shadow: 0 0 0 0.2rem rgba(39, 219, 159, 0.25);
}

.card-header {
    border-bottom: none;
}

.form-check-label {
    cursor: pointer;
    transition: all 0.3s ease;
}

.form-check-label:hover {
    transform: translateX(5px);
}

.form-check {
    transition: all 0.3s ease;
}

.form-check:hover {
    background-color: rgba(39, 219, 159, 0.05);
    border-radius: 8px;
    padding: 8px;
    margin: -8px;
}
</style>
@endsection
