@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-user-circle text-primary me-2"></i>
            Mi Perfil
        </h1>
        <p class="text-muted">Información de tu cuenta y configuración personal</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
        </a>
    </div>
</div>

<div class="row">
    <!-- Información Personal -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="mb-0">
                    <i class="fas fa-user text-primary me-2"></i>
                    Información Personal
                </h5>
            </div>
            <div class="card-body">
                <form action="#" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nombre Completo</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="name" 
                                   name="name" 
                                   value="{{ $usuario->name }}" 
                                   readonly>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   value="{{ $usuario->email }}" 
                                   readonly>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="rol" class="form-label">Rol del Sistema</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="rol" 
                                   value="{{ ucfirst($usuario->rol ?? 'Usuario') }}" 
                                   readonly>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="estado" class="form-label">Estado de la Cuenta</label>
                            <div class="input-group">
                                <input type="text" 
                                       class="form-control" 
                                       value="{{ $usuario->activo ? 'Activo' : 'Inactivo' }}" 
                                       readonly>
                                <span class="input-group-text">
                                    <i class="fas fa-{{ $usuario->activo ? 'check-circle text-success' : 'times-circle text-danger' }}"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="fas fa-info-circle me-2"></i>Información de la Cuenta
                        </h6>
                        <p class="mb-2"><strong>Fecha de registro:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                        <p class="mb-2"><strong>Última actualización:</strong> {{ $usuario->updated_at->format('d/m/Y H:i') }}</p>
                        @if($usuario->email_verified_at)
                            <p class="mb-0"><strong>Email verificado:</strong> {{ $usuario->email_verified_at->format('d/m/Y H:i') }}</p>
                        @else
                            <p class="mb-0 text-warning"><strong>Email:</strong> Pendiente de verificación</p>
                        @endif
                    </div>
                    
                    <!-- Nota informativa -->
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Para modificar tu información personal, contacta con el administrador del sistema.
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Panel Lateral -->
    <div class="col-lg-4">
        <!-- Avatar y Información Rápida -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px; font-size: 2rem;">
                    <i class="fas fa-user"></i>
                </div>
                <h5 class="mb-1">{{ $usuario->name }}</h5>
                <p class="text-muted mb-3">{{ ucfirst($usuario->rol ?? 'Usuario') }}</p>
                
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h6 class="mb-1">Activo desde</h6>
                            <small class="text-muted">{{ $usuario->created_at->format('M Y') }}</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h6 class="mb-1">Estado</h6>
                        <span class="badge bg-{{ $usuario->activo ? 'success' : 'danger' }}">
                            {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Estadísticas del Usuario (si es técnico) -->
        @if($usuario->tecnico)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0 pb-0">
                <h6 class="mb-0">
                    <i class="fas fa-chart-bar text-info me-2"></i>
                    Estadísticas como Técnico
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 text-center">
                        <h4 class="text-primary mb-0">{{ $usuario->tecnico->reparaciones()->count() }}</h4>
                        <small class="text-muted">Reparaciones</small>
                    </div>
                    <div class="col-6 text-center">
                        <h4 class="text-success mb-0">{{ $usuario->tecnico->reparaciones()->where('estado', 'completada')->count() }}</h4>
                        <small class="text-muted">Completadas</small>
                    </div>
                </div>
                <hr class="my-3">
                <div class="text-center">
                    <h5 class="text-warning mb-0">{{ $usuario->tecnico->reparaciones()->whereIn('estado', ['pendiente', 'en_proceso'])->count() }}</h5>
                    <small class="text-muted">Tareas Pendientes</small>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Acciones Rápidas -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pb-0">
                <h6 class="mb-0">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    Acciones Rápidas
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    
                    @if($usuario->tecnico)
                    <a href="{{ route('reparaciones.mis-tareas') }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-tasks me-2"></i>Mis Tareas
                    </a>
                    @endif
                    
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="mostrarProximamente('Cambiar Contraseña')">
                        <i class="fas fa-key me-2"></i>Cambiar Contraseña
                    </button>
                    
                    <hr class="my-2">
                    
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('¿Estás seguro de que deseas cerrar sesión?')">
                            <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Función para mostrar mensaje de funcionalidad próximamente
function mostrarProximamente(funcionalidad) {
    alert('La funcionalidad "' + funcionalidad + '" estará disponible próximamente.');
}

// Confirmar cierre de sesión
document.addEventListener('DOMContentLoaded', function() {
    const logoutForm = document.querySelector('form[action*="logout"]');
    if (logoutForm) {
        logoutForm.addEventListener('submit', function(e) {
            if (!confirm('¿Estás seguro de que deseas cerrar sesión?')) {
                e.preventDefault();
            }
        });
    }
});
</script>
@endsection

@section('styles')
<style>
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.alert {
    border-radius: 15px;
}

.btn-custom {
    border-radius: 25px;
    padding: 0.5rem 1.5rem;
}

@media (max-width: 768px) {
    .card {
        margin-bottom: 1rem;
    }
    
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
}
</style>
@endsection
