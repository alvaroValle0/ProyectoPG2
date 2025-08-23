@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-user-plus text-primary me-2"></i>
            Crear Nuevo Usuario
        </h1>
        <p class="text-muted">Registra un nuevo usuario en el sistema</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver a la Lista
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('usuarios.store') }}" method="POST">
            @csrf
            
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
                               value="{{ old('name') }}" 
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
                               value="{{ old('username') }}" 
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
                               value="{{ old('email') }}" 
                               required
                               placeholder="usuario@empresa.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Correo electrónico para notificaciones y recuperación de cuenta</small>
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required
                                   minlength="8"
                                   placeholder="Mínimo 8 caracteres">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                <i class="fas fa-eye" id="password-icon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">La contraseña debe tener al menos 8 caracteres</small>
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required
                                   placeholder="Confirme la contraseña">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye" id="password_confirmation-icon"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Configuración del Usuario -->
                <div class="col-lg-6">
                    <h5 class="mb-3">
                        <i class="fas fa-cog text-info me-2"></i>
                        Configuración del Usuario
                    </h5>

                    <!-- Rol -->
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol del Usuario <span class="text-danger">*</span></label>
                        <select class="form-select @error('rol') is-invalid @enderror" 
                                id="rol" 
                                name="rol" 
                                required>
                            <option value="">Seleccione un rol</option>
                            <option value="admin" {{ old('rol') == 'admin' ? 'selected' : '' }}>
                                Administrador - Acceso completo al sistema
                            </option>
                            <option value="tecnico" {{ old('rol') == 'tecnico' ? 'selected' : '' }}>
                                Técnico - Gestión de reparaciones y equipos
                            </option>
                            <option value="usuario" {{ old('rol') == 'usuario' ? 'selected' : '' }}>
                                Usuario - Acceso limitado al sistema
                            </option>
                        </select>
                        @error('rol')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Estado Activo -->
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input @error('activo') is-invalid @enderror" 
                                   type="checkbox" 
                                   id="activo" 
                                   name="activo" 
                                   value="1" 
                                   {{ old('activo', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="activo">
                                <strong>Usuario Activo</strong>
                            </label>
                            @error('activo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block">El usuario podrá iniciar sesión en el sistema</small>
                        </div>
                    </div>

                    <!-- Información sobre roles -->
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Información sobre Roles</h6>
                        <ul class="mb-0 small">
                            <li><strong>Administrador:</strong> Acceso completo, gestión de usuarios y configuración</li>
                            <li><strong>Técnico:</strong> Gestión de reparaciones, equipos y sus tareas</li>
                            <li><strong>Usuario:</strong> Acceso de solo lectura a información básica</li>
                        </ul>
                    </div>

                    <!-- Información adicional para técnicos -->
                    <div class="alert alert-warning" id="info-tecnico" style="display: none;">
                        <h6><i class="fas fa-tools me-2"></i>Usuarios Técnicos</h6>
                        <p class="mb-2 small">
                            Si selecciona el rol "Técnico", después de crear el usuario podrá:
                        </p>
                        <ul class="mb-0 small">
                            <li>Crear un perfil técnico completo con información personal</li>
                            <li>Asignar especialidades y habilidades</li>
                            <li>Configurar información de contacto y emergencia</li>
                        </ul>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- Información de Seguridad -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">
                        <i class="fas fa-shield-alt text-success me-2"></i>
                        Configuración de Seguridad
                    </h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <i class="fas fa-key text-success display-6 mb-2"></i>
                                    <h6>Contraseña Segura</h6>
                                    <small class="text-muted">Mínimo 8 caracteres con combinación de letras y números</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-info">
                                <div class="card-body text-center">
                                    <i class="fas fa-envelope text-info display-6 mb-2"></i>
                                    <h6>Email Único</h6>
                                    <small class="text-muted">El email debe ser único en el sistema</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-warning">
                                <div class="card-body text-center">
                                    <i class="fas fa-user-shield text-warning display-6 mb-2"></i>
                                    <h6>Permisos por Rol</h6>
                                    <small class="text-muted">Los permisos se asignan automáticamente según el rol</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary btn-custom">
                            <i class="fas fa-save me-2"></i>Crear Usuario
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Mostrar/ocultar contraseña
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Validación en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const rolSelect = document.getElementById('rol');
    const infoTecnico = document.getElementById('info-tecnico');
    
    // Mostrar información para técnicos
    rolSelect.addEventListener('change', function() {
        if (this.value === 'tecnico') {
            infoTecnico.style.display = 'block';
        } else {
            infoTecnico.style.display = 'none';
        }
    });
    
    // Validación de confirmación de contraseña
    passwordConfirmation.addEventListener('input', function() {
        if (this.value !== passwordInput.value) {
            this.classList.add('is-invalid');
            if (!document.querySelector('#password-match-error')) {
                const errorDiv = document.createElement('div');
                errorDiv.id = 'password-match-error';
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = 'Las contraseñas no coinciden';
                this.parentNode.appendChild(errorDiv);
            }
        } else {
            this.classList.remove('is-invalid');
            const errorDiv = document.querySelector('#password-match-error');
            if (errorDiv) {
                errorDiv.remove();
            }
        }
    });
    
    // Validación del email en tiempo real
    emailInput.addEventListener('blur', function() {
        const email = this.value;
        if (email) {
            fetch(`/usuarios/check-email?email=${encodeURIComponent(email)}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.available) {
                        this.classList.add('is-invalid');
                        if (!document.querySelector('#email-exists-error')) {
                            const errorDiv = document.createElement('div');
                            errorDiv.id = 'email-exists-error';
                            errorDiv.className = 'invalid-feedback';
                            errorDiv.textContent = 'Este email ya está registrado en el sistema';
                            this.parentNode.appendChild(errorDiv);
                        }
                    } else {
                        this.classList.remove('is-invalid');
                        const errorDiv = document.querySelector('#email-exists-error');
                        if (errorDiv) {
                            errorDiv.remove();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking email:', error);
                });
        }
    });
    
    // Validación del formulario
    form.addEventListener('submit', function(e) {
        let valid = true;
        const requiredFields = [nameInput, emailInput, passwordInput, passwordConfirmation, rolSelect];
        
        // Validar campos obligatorios
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                valid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        // Validar que las contraseñas coincidan
        if (passwordInput.value !== passwordConfirmation.value) {
            passwordConfirmation.classList.add('is-invalid');
            valid = false;
        }
        
        // Validar longitud de contraseña
        if (passwordInput.value.length < 8) {
            passwordInput.classList.add('is-invalid');
            valid = false;
        }
        
        if (!valid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos obligatorios correctamente.');
            // Scroll al primer campo con error
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
    
    // Limpiar errores al escribir
    document.querySelectorAll('input, select').forEach(field => {
        field.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
});
</script>
@endsection

@section('styles')
<style>
.card {
    transition: all 0.3s ease;
}

.input-group .btn {
    border-color: #ced4da;
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.alert ul {
    padding-left: 1.2rem;
}

.alert li {
    margin-bottom: 0.2rem;
}

@media (max-width: 768px) {
    .row .col-lg-6 {
        margin-bottom: 1rem;
    }
}
</style>
@endsection