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
        <form action="{{ route('usuarios.update', $usuario) }}" method="POST" enctype="multipart/form-data">
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
                        <small class="text-muted">Confirme la nueva contraseña si la cambió</small>
                    </div>

                    <!-- Avatar del Usuario -->
                    <div class="mb-3">
                        <label for="avatar" class="form-label">
                            <i class="fas fa-camera me-1"></i>Foto de Perfil
                        </label>
                        
                        <div class="text-center mb-3">
                            <img src="{{ $usuario->avatar_url }}" alt="Avatar actual" 
                                 class="rounded-circle border border-3 border-primary"
                                 style="width: 100px; height: 100px; object-fit: cover;"
                                 id="avatar-preview">
                        </div>
                        
                        <div class="input-group">
                            <input type="file" 
                                   class="form-control @error('avatar') is-invalid @enderror" 
                                   id="avatar" 
                                   name="avatar" 
                                   accept="image/*"
                                   onchange="previewAvatar(this)">
                            <label class="input-group-text" for="avatar">
                                <i class="fas fa-upload"></i>
                            </label>
                        </div>
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">JPG, PNG, GIF hasta 2MB. Opcional.</small>
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

            <hr class="my-4">

            <!-- Acceso a Módulos -->
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
                    <div class="alert alert-info mb-3">
                        <h6><i class="fas fa-info-circle me-2"></i>Sistema de Permisos por Módulos</h6>
                        <p class="mb-0 small">
                            <strong>Importante:</strong> Selecciona los módulos específicos a los que tendrá acceso este usuario. Los permisos específicos (crear, editar, eliminar) se asignan según el rol del usuario.
                        </p>
                        @if(!$usuario->permissions)
                            <div class="mt-2 text-warning">
                                <strong>Nota:</strong> Este usuario no tiene permisos configurados. Se crearán automáticamente al guardar.
                            </div>
                        @endif
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_dashboard" id="access_dashboard" 
                                       {{ old('access_dashboard', $usuario->permissions->access_dashboard ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_dashboard">
                                    <i class="fas fa-tachometer-alt text-primary me-2"></i>
                                    <strong>Dashboard</strong>
                                    <br><small class="text-muted">Panel principal y estadísticas</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_clientes" id="access_clientes" 
                                       {{ old('access_clientes', $usuario->permissions->access_clientes ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_clientes">
                                    <i class="fas fa-users text-info me-2"></i>
                                    <strong>Clientes</strong>
                                    <br><small class="text-muted">Gestión de clientes</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_equipos" id="access_equipos" 
                                       {{ old('access_equipos', $usuario->permissions->access_equipos ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_equipos">
                                    <i class="fas fa-laptop text-warning me-2"></i>
                                    <strong>Equipos</strong>
                                    <br><small class="text-muted">Gestión de equipos</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_reparaciones" id="access_reparaciones" 
                                       {{ old('access_reparaciones', $usuario->permissions->access_reparaciones ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_reparaciones">
                                    <i class="fas fa-wrench text-success me-2"></i>
                                    <strong>Reparaciones</strong>
                                    <br><small class="text-muted">Gestión de reparaciones</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_inventario" id="access_inventario" 
                                       {{ old('access_inventario', $usuario->permissions->access_inventario ?? false) ? 'checked' : '' }}>
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
                                       {{ old('access_tickets', $usuario->permissions->access_tickets ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_tickets">
                                    <i class="fas fa-ticket-alt text-danger me-2"></i>
                                    <strong>Tickets</strong>
                                    <br><small class="text-muted">Gestión de tickets</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_tecnicos" id="access_tecnicos" 
                                       {{ old('access_tecnicos', $usuario->permissions->access_tecnicos ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_tecnicos">
                                    <i class="fas fa-users-cog text-dark me-2"></i>
                                    <strong>Técnicos</strong>
                                    <br><small class="text-muted">Gestión de técnicos</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_usuarios" id="access_usuarios" 
                                       {{ old('access_usuarios', $usuario->permissions->access_usuarios ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_usuarios">
                                    <i class="fas fa-users text-primary me-2"></i>
                                    <strong>Usuarios</strong>
                                    <br><small class="text-muted">Gestión de usuarios</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_configuracion" id="access_configuracion" 
                                       {{ old('access_configuracion', $usuario->permissions->access_configuracion ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="access_configuracion">
                                    <i class="fas fa-cog text-secondary me-2"></i>
                                    <strong>Configuración</strong>
                                    <br><small class="text-muted">Configuración del sistema</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="access_reportes" id="access_reportes" 
                                       {{ old('access_reportes', $usuario->permissions->access_reportes ?? false) ? 'checked' : '' }}>
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

// Función para seleccionar todos los módulos
function selectAllModules() {
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
}

// Función para deseleccionar todos los módulos
function deselectAllModules() {
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
}

// Validación del formulario
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[method="POST"]');
    const rolSelect = document.getElementById('rol');
    
    // Debug: Mostrar información sobre permisos
    console.log('Usuario cargado:', {!! json_encode($usuario->toArray()) !!});
    console.log('Permisos cargados:', {!! json_encode($usuario->permissions ? $usuario->permissions->toArray() : null) !!});
    
    // Asegurar que los checkboxes sean visibles
    const moduleSection = document.querySelector('.row.mb-4');
    if (moduleSection) {
        moduleSection.style.display = 'block';
        console.log('Sección de módulos encontrada y mostrada');
    } else {
        console.error('Sección de módulos no encontrada');
    }
    
    // Sugerir módulos según el rol seleccionado
    rolSelect.addEventListener('change', function() {
        const rol = this.value;
        
        const permisosPorRol = {
            'admin': ['access_dashboard', 'access_clientes', 'access_equipos', 'access_reparaciones', 'access_inventario', 'access_tickets', 'access_tecnicos', 'access_usuarios', 'access_configuracion', 'access_reportes'],
            'tecnico': ['access_dashboard', 'access_clientes', 'access_equipos', 'access_reparaciones', 'access_inventario', 'access_tickets', 'access_reportes'],
            'usuario': ['access_dashboard', 'access_clientes', 'access_equipos', 'access_inventario', 'access_tickets']
        };
        
        if (permisosPorRol[rol]) {
            // Desmarcar todos primero
            deselectAllModules();
            
            // Marcar los sugeridos para el rol
            permisosPorRol[rol].forEach(id => {
                const checkbox = document.getElementById(id);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        }
    });
    
    // Validación simplificada al enviar
    form.addEventListener('submit', function(e) {
        console.log('=== ENVIANDO FORMULARIO ===');
        
        // Verificar campos básicos
        const nameField = document.getElementById('name');
        const emailField = document.getElementById('email');
        const rolField = document.getElementById('rol');
        
        if (!nameField.value.trim() || !emailField.value.trim() || !rolField.value) {
            e.preventDefault();
            alert('Por favor, complete todos los campos obligatorios.');
            return;
        }
        
        console.log('✓ Enviando formulario...');
    });
});

// Función para preview del avatar
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
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

.form-check-label {
    cursor: pointer;
    transition: all 0.3s ease;
}

.form-check-label:hover {
    transform: translateX(5px);
}

.form-check {
    transition: all 0.3s ease;
    padding: 0.5rem;
    border-radius: 8px;
}

.form-check:hover {
    background-color: rgba(39, 219, 159, 0.05);
}

.alert {
    border: none;
    border-radius: 12px;
}

.card {
    border-radius: 12px;
    transition: all 0.3s ease;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
}

.btn:hover {
    transform: translateY(-1px);
}

/* Asegurar que los checkboxes sean visibles */
.form-check {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    min-height: 60px !important;
}

.form-check-input {
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
    width: 20px !important;
    height: 20px !important;
}

.form-check-label {
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
    margin-left: 0.5rem !important;
    width: calc(100% - 30px) !important;
}

/* Asegurar que la sección de módulos sea visible */
.row.mb-4 {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}
</style>
@endsection
