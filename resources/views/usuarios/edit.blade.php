@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-user-edit text-primary me-2"></i>
            Editar Usuario
        </h1>
        <p class="text-muted">Modifica la información del usuario</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver a la Lista
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Información Básica -->
                <div class="col-lg-6">
                    <h5 class="mb-3">
                        <i class="fas fa-user text-primary me-2"></i>
                        Información Básica
                    </h5>
                    
                    <!-- Nombre -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $usuario->name) }}" 
                               required
                               placeholder="Ej: Juan Carlos Pérez">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de Usuario <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('username') is-invalid @enderror" 
                               id="username" 
                               name="username" 
                               value="{{ old('username', $usuario->username) }}" 
                               required
                               placeholder="Ej: juan.perez">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Este será el nombre de usuario para iniciar sesión</small>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $usuario->email) }}" 
                               required
                               placeholder="usuario@empresa.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Correo electrónico para notificaciones y recuperación de cuenta</small>
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   minlength="8"
                                   placeholder="Dejar en blanco para mantener la actual">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                <i class="fas fa-eye" id="password-icon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Dejar en blanco para mantener la contraseña actual</small>
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Confirme la nueva contraseña">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye" id="password_confirmation-icon"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Configuración del Sistema -->
                <div class="col-lg-6">
                    <h5 class="mb-3">
                        <i class="fas fa-cog text-primary me-2"></i>
                        Configuración del Sistema
                    </h5>
                    
                    <!-- Rol -->
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol <span class="text-danger">*</span></label>
                        <select class="form-select @error('rol') is-invalid @enderror" id="rol" name="rol" required>
                            <option value="">Seleccionar rol</option>
                            <option value="admin" {{ old('rol', $usuario->rol) == 'admin' ? 'selected' : '' }}>
                                <i class="fas fa-user-shield"></i> Administrador
                            </option>
                            <option value="tecnico" {{ old('rol', $usuario->rol) == 'tecnico' ? 'selected' : '' }}>
                                <i class="fas fa-user-cog"></i> Técnico
                            </option>
                            <option value="usuario" {{ old('rol', $usuario->rol) == 'usuario' ? 'selected' : '' }}>
                                <i class="fas fa-user"></i> Usuario
                            </option>
                        </select>
                        @error('rol')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="activo" name="activo" 
                                   {{ old('activo', $usuario->activo) ? 'checked' : '' }}>
                            <label class="form-check-label" for="activo">
                                <i class="fas fa-toggle-on text-success me-2"></i>Usuario Activo
                            </label>
                        </div>
                        <small class="text-muted">Los usuarios inactivos no pueden acceder al sistema</small>
                    </div>

                    <!-- Información del Usuario -->
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-info-circle text-info me-2"></i>
                                Información del Usuario
                            </h6>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">ID:</small><br>
                                    <strong>{{ $usuario->id }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Creado:</small><br>
                                    <strong>{{ $usuario->created_at->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <small class="text-muted">Última actualización:</small><br>
                                    <strong>{{ $usuario->updated_at->format('d/m/Y H:i') }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Estado actual:</small><br>
                                    <span class="badge bg-{{ $usuario->estado_color }}">
                                        {{ $usuario->estado_label }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="row mt-4">
                <div class="col-12">
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-outline-danger" onclick="confirmarEliminacion()">
                                <i class="fas fa-trash me-2"></i>Eliminar Usuario
                            </button>
                        </div>
                        <div>
                            <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Formulario oculto para eliminación -->
<form id="form-eliminar" method="POST" action="{{ route('usuarios.destroy', $usuario) }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        field.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

function confirmarEliminacion() {
    if (confirm('¿Estás seguro de que deseas eliminar este usuario?\n\nEsta acción no se puede deshacer.')) {
        document.getElementById('form-eliminar').submit();
    }
}
</script>
@endsection
