@extends('layouts.app')

@section('title', 'Gestión de Permisos - ' . $user->name)

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-user-shield text-primary me-2"></i>
            Gestión de Permisos
        </h1>
        <p class="text-muted">Configurar módulos de acceso para {{ $user->name }}</p>
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
                    <!-- Mensaje informativo sobre el sistema de checkboxes -->
                    <div class="alert alert-primary mb-3">
                        <h6><i class="fas fa-info-circle me-2"></i>Sistema de Selección de Módulos</h6>
                        <p class="mb-0 small">
                            <strong>Importante:</strong> Seleccione mediante checkboxes los módulos a los que desea dar acceso al usuario.
                        </p>
                    </div>
                    
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
            
            <!-- Botones de Acción -->
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <button type="submit" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-save me-2"></i>Guardar Módulos
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
