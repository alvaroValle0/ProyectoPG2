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
                                Administrador
                            </option>
                            <option value="tecnico" {{ old('rol') == 'tecnico' ? 'selected' : '' }}>
                                Técnico
                            </option>
                            <option value="usuario" {{ old('rol') == 'usuario' ? 'selected' : '' }}>
                                Usuario
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
                        <p class="mb-0 small">
                            <strong>Nota:</strong> Los permisos se asignan automáticamente según el rol seleccionado. Los checkboxes permiten modificar permisos adicionales.
                        </p>
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

                    <!-- Información de permisos por rol -->
                    <div class="alert alert-success" id="info-permisos" style="display: none;">
                        <h6><i class="fas fa-shield-alt me-2"></i>Permisos por Rol</h6>
                        <div id="permisos-detalle" class="small">
                            <!-- Se llenará dinámicamente -->
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- Acceso a Módulos (Opcional) -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="mb-1">
                                <i class="fas fa-th-large text-primary me-2"></i>
                                Acceso a Módulos
                            </h5>
                            <p class="text-muted mb-0">Selecciona los módulos a los que tendrá acceso el usuario</p>
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="selectAllModules()">
                                <i class="fas fa-check-square me-1"></i>Seleccionar Todos
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="deselectAllModules()">
                                <i class="fas fa-square me-1"></i>Deseleccionar Todos
                            </button>
                        </div>
                    </div>
                    
                    <!-- Mensaje informativo sobre el sistema de permisos -->
                    <div class="alert alert-primary mb-3">
                        <h6><i class="fas fa-info-circle me-2"></i>Sistema de Permisos por Rol y Módulos</h6>
                        <p class="mb-0 small">
                            <strong>Importante:</strong> Selecciona el rol del usuario y luego los módulos específicos a los que tendrá acceso. Los permisos específicos (crear, editar, eliminar) se asignan según el rol seleccionado.
                        </p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_dashboard" id="access_dashboard" 
                                       {{ old('access_dashboard') ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_dashboard">
                                    <i class="fas fa-tachometer-alt text-primary me-2"></i>
                                    <strong>Dashboard</strong>
                                    <br><small class="text-muted">Panel principal y estadísticas</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_clientes" id="access_clientes" 
                                       {{ old('access_clientes') ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_clientes">
                                    <i class="fas fa-users text-info me-2"></i>
                                    <strong>Clientes</strong>
                                    <br><small class="text-muted">Gestión de clientes</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_equipos" id="access_equipos" 
                                       {{ old('access_equipos') ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_equipos">
                                    <i class="fas fa-laptop text-warning me-2"></i>
                                    <strong>Equipos</strong>
                                    <br><small class="text-muted">Gestión de equipos</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_reparaciones" id="access_reparaciones" 
                                       {{ old('access_reparaciones') ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_reparaciones">
                                    <i class="fas fa-wrench text-success me-2"></i>
                                    <strong>Reparaciones</strong>
                                    <br><small class="text-muted">Gestión de reparaciones</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_inventario" id="access_inventario" 
                                       {{ old('access_inventario') ? 'checked' : '' }}>
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
                                       {{ old('access_tickets') ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_tickets">
                                    <i class="fas fa-ticket-alt text-danger me-2"></i>
                                    <strong>Tickets</strong>
                                    <br><small class="text-muted">Gestión de tickets</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_tecnicos" id="access_tecnicos" 
                                       {{ old('access_tecnicos') ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_tecnicos">
                                    <i class="fas fa-users-cog text-dark me-2"></i>
                                    <strong>Técnicos</strong>
                                    <br><small class="text-muted">Gestión de técnicos</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_usuarios" id="access_usuarios" 
                                       {{ old('access_usuarios') ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_usuarios">
                                    <i class="fas fa-users text-primary me-2"></i>
                                    <strong>Usuarios</strong>
                                    <br><small class="text-muted">Gestión de usuarios</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_configuracion" id="access_configuracion" 
                                       {{ old('access_configuracion') ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_configuracion">
                                    <i class="fas fa-cog text-secondary me-2"></i>
                                    <strong>Configuración</strong>
                                    <br><small class="text-muted">Configuración del sistema</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_reportes" id="access_reportes" 
                                       {{ old('access_reportes') ? 'checked' : '' }}>
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
                                    <i class="fas fa-check-square text-warning display-6 mb-2"></i>
                                    <h6>Módulos por Checkboxes</h6>
                                    <small class="text-muted">Acceso mediante checkboxes</small>
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
    const infoPermisos = document.getElementById('info-permisos');
    const permisosDetalle = document.getElementById('permisos-detalle');
    
    // Mostrar información según el rol seleccionado
    rolSelect.addEventListener('change', function() {
        const rol = this.value;
        
        // Ocultar todas las alertas primero
        infoTecnico.style.display = 'none';
        infoPermisos.style.display = 'none';
        
        if (rol === 'tecnico') {
            infoTecnico.style.display = 'block';
        } else if (rol) {
            // Mostrar información de permisos automáticos
            mostrarPermisosAutomaticos(rol);
        }
    });
    
    // Función para mostrar permisos por rol y sugerir módulos
    function mostrarPermisosAutomaticos(rol) {
        const permisosPorRol = {
            'admin': {
                titulo: '👑 Administrador',
                descripcion: 'Permisos completos en todos los módulos',
                permisos: [
                    '✅ Crear, editar y eliminar en todos los módulos',
                    '✅ Gestionar usuarios y técnicos',
                    '✅ Acceso completo a configuración y reportes',
                    '📋 Selecciona los módulos que tendrá acceso'
                ],
                modulos: ['access_dashboard', 'access_clientes', 'access_equipos', 'access_reparaciones', 'access_inventario', 'access_tickets', 'access_tecnicos', 'access_usuarios', 'access_configuracion', 'access_reportes']
            },
            'tecnico': {
                titulo: '🔧 Técnico',
                descripcion: 'Permisos de trabajo técnico en módulos seleccionados',
                permisos: [
                    '✅ Crear y editar (sin eliminar) en módulos de trabajo',
                    '❌ No puede gestionar usuarios o técnicos',
                    '❌ No puede acceder a configuración',
                    '📋 Selecciona los módulos que tendrá acceso'
                ],
                modulos: ['access_dashboard', 'access_clientes', 'access_equipos', 'access_reparaciones', 'access_inventario', 'access_tickets', 'access_reportes']
            },
            'usuario': {
                titulo: '👤 Usuario',
                descripcion: 'Permisos limitados en módulos seleccionados',
                permisos: [
                    '✅ Ver equipos e inventario (sin crear, editar o eliminar)',
                    '✅ Crear y editar clientes (sin eliminar)',
                    '✅ Crear tickets (sin editar o eliminar)',
                    '❌ No puede gestionar usuarios o técnicos',
                    '📋 Selecciona los módulos que tendrá acceso'
                ],
                modulos: ['access_dashboard', 'access_clientes', 'access_equipos', 'access_inventario', 'access_tickets']
            }
        };
        
        const info = permisosPorRol[rol];
        if (info) {
            permisosDetalle.innerHTML = `
                <div class="mb-2">
                    <strong>${info.titulo}</strong><br>
                    <small class="text-muted">${info.descripcion}</small>
                </div>
                <div class="mt-2">
                    ${info.permisos.map(permiso => `<div>${permiso}</div>`).join('')}
                </div>
            `;
            infoPermisos.style.display = 'block';
            
            // Sugerir módulos según el rol (marcar automáticamente)
            const allCheckboxes = [
                'access_dashboard', 'access_clientes', 'access_equipos', 'access_reparaciones',
                'access_inventario', 'access_tickets', 'access_tecnicos', 'access_usuarios',
                'access_configuracion', 'access_reportes'
            ];
            
            // Desmarcar todos los checkboxes primero
            allCheckboxes.forEach(id => {
                const checkbox = document.getElementById(id);
                if (checkbox) {
                    checkbox.checked = false;
                }
            });
            
            // Marcar los módulos sugeridos para el rol
            info.modulos.forEach(id => {
                const checkbox = document.getElementById(id);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        }
    }
    
    // Función para seleccionar todos los módulos
    window.selectAllModules = function() {
        const moduleCheckboxes = [
            'access_dashboard', 'access_clientes', 'access_equipos', 'access_reparaciones',
            'access_inventario', 'access_tickets', 'access_tecnicos', 'access_usuarios',
            'access_configuracion', 'access_reportes'
        ];
        
        moduleCheckboxes.forEach(id => {
            const checkbox = document.getElementById(id);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
    };
    
    // Función para deseleccionar todos los módulos
    window.deselectAllModules = function() {
        const moduleCheckboxes = [
            'access_dashboard', 'access_clientes', 'access_equipos', 'access_reparaciones',
            'access_inventario', 'access_tickets', 'access_tecnicos', 'access_usuarios',
            'access_configuracion', 'access_reportes'
        ];
        
        moduleCheckboxes.forEach(id => {
            const checkbox = document.getElementById(id);
            if (checkbox) {
                checkbox.checked = false;
            }
        });
    };
    
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
        
        // Validar que al menos un módulo haya sido seleccionado
        const moduleCheckboxes = [
            'access_dashboard', 'access_clientes', 'access_equipos', 'access_reparaciones',
            'access_inventario', 'access_tickets', 'access_tecnicos', 'access_usuarios',
            'access_configuracion', 'access_reportes'
        ];
        
        let moduleSelected = false;
        moduleCheckboxes.forEach(id => {
            const checkbox = document.getElementById(id);
            if (checkbox && checkbox.checked) {
                moduleSelected = true;
            }
        });
        
        if (!moduleSelected) {
            valid = false;
            alert('Debe seleccionar al menos un módulo de acceso para el usuario.');
            // Scroll a la sección de módulos
            const modulesSection = document.querySelector('.row.mb-4');
            if (modulesSection) {
                modulesSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
        
        if (!valid) {
            e.preventDefault();
            if (!moduleSelected) {
                return; // Ya se mostró el mensaje específico para módulos
            }
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
    background-color: #27DB9F;
    border-color: #27DB9F;
}

.form-check-input:focus {
    border-color: #27DB9F;
    box-shadow: 0 0 0 0.2rem rgba(39, 219, 159, 0.25);
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