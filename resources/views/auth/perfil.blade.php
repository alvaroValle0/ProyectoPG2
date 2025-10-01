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
                <form action="{{ route('perfil.update') }}" method="POST" id="profileForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $usuario->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   value="{{ $usuario->email }}" 
                                   readonly>
                            <div class="form-text">El correo electrónico no se puede modificar</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Nombre de Usuario</label>
                            <input type="text" 
                                   class="form-control @error('username') is-invalid @enderror" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username', $usuario->username) }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Opcional. Si no se especifica, se usará el email.</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" 
                                   class="form-control @error('telefono') is-invalid @enderror" 
                                   id="telefono" 
                                   name="telefono" 
                                   value="{{ old('telefono', $usuario->telefono) }}">
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                  id="direccion" 
                                  name="direccion" 
                                  rows="3">{{ old('direccion', $usuario->direccion) }}</textarea>
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Información del sistema (solo lectura) -->
                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="fas fa-info-circle me-2"></i>Información del Sistema
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Rol:</strong> {{ ucfirst($usuario->rol ?? 'Usuario') }}</p>
                                <p class="mb-0"><strong>Estado:</strong> 
                                    <span class="badge bg-{{ $usuario->activo ? 'success' : 'danger' }}">
                                        {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Registrado:</strong> {{ $usuario->created_at->format('d/m/Y') }}</p>
                                <p class="mb-0"><strong>Última actualización:</strong> {{ $usuario->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Botón de guardar -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" id="saveButton">
                            <i class="fas fa-save me-2"></i>Guardar Cambios
                        </button>
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
                <!-- Avatar con funcionalidad de cambio -->
                <div class="avatar-container position-relative mb-3">
                    @if($usuario->avatar_url && $usuario->avatar_url !== asset('images/default-avatar.svg'))
                        <img src="{{ $usuario->avatar_url }}" 
                             alt="Avatar de {{ $usuario->name }}" 
                             class="avatar-image rounded-circle"
                             style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                             style="width: 80px; height: 80px; font-size: 2rem;">
                            {{ $usuario->iniciales }}
                        </div>
                    @endif
                    
                    <!-- Botón de cambio de avatar -->
                    <button type="button" 
                            class="btn btn-sm btn-primary avatar-change-btn" 
                            data-bs-toggle="modal" 
                            data-bs-target="#avatarModal"
                            title="Cambiar foto de perfil">
                        <i class="fas fa-camera"></i>
                    </button>
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

<!-- Modal para cambiar avatar -->
<div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avatarModalLabel">
                    <i class="fas fa-camera me-2"></i>
                    Cambiar Foto de Perfil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Preview de la imagen actual -->
                <div class="text-center mb-4">
                    <div class="current-avatar-container">
                        @if($usuario->avatar_url && $usuario->avatar_url !== asset('images/default-avatar.svg'))
                            <img src="{{ $usuario->avatar_url }}" 
                                 alt="Avatar actual" 
                                 class="current-avatar rounded-circle mb-2"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="current-avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" 
                                 style="width: 100px; height: 100px; font-size: 2.5rem;">
                                {{ $usuario->iniciales }}
                            </div>
                        @endif
                        <p class="text-muted small">Foto actual</p>
                    </div>
                </div>

                <!-- Formulario para subir nueva imagen -->
                <form id="avatarForm" action="{{ route('perfil.avatar.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Seleccionar nueva imagen</label>
                        <input type="file" 
                               class="form-control" 
                               id="avatar" 
                               name="avatar" 
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               required>
                        <div class="form-text">
                            Formatos permitidos: JPEG, PNG, JPG, GIF. Tamaño máximo: 2MB
                        </div>
                        @error('avatar')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Preview de la nueva imagen -->
                    <div id="imagePreview" class="text-center mb-3" style="display: none;">
                        <img id="previewImg" src="" alt="Vista previa" 
                             class="rounded-circle mb-2" 
                             style="width: 100px; height: 100px; object-fit: cover;">
                        <p class="text-muted small">Vista previa</p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                @if($usuario->avatar)
                <form action="{{ route('perfil.avatar.delete') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="btn btn-outline-danger" 
                            onclick="return confirm('¿Estás seguro de que deseas eliminar tu foto de perfil?')">
                        <i class="fas fa-trash me-2"></i>Eliminar
                    </button>
                </form>
                @endif
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="avatarForm" class="btn btn-primary" id="submitAvatarBtn">
                    <i class="fas fa-upload me-2"></i>Actualizar
                </button>
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

// Preview de imagen para el avatar
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const avatarForm = document.getElementById('avatarForm');
    const avatarModal = document.getElementById('avatarModal');

    // Asegurar que el modal funcione correctamente
    if (avatarModal) {
        // Forzar inicialización del modal con configuración mejorada
        const modalInstance = new bootstrap.Modal(avatarModal, {
            backdrop: 'static', // Cambiar a 'static' para evitar problemas de backdrop
            keyboard: true,
            focus: true
        });

        // Asegurar que el modal sea completamente interactivo
        avatarModal.addEventListener('shown.bs.modal', function() {
            console.log('Modal abierto correctamente');
            
            // Remover cualquier backdrop problemático
            const existingBackdrop = document.querySelector('.modal-backdrop');
            if (existingBackdrop) {
                existingBackdrop.style.display = 'none';
            }
            
            // Asegurar que todos los elementos sean clickeables
            const modalContent = avatarModal.querySelector('.modal-content');
            if (modalContent) {
                modalContent.style.pointerEvents = 'auto';
                modalContent.style.position = 'relative';
                modalContent.style.zIndex = '99999';
                modalContent.style.backgroundColor = 'white';
                modalContent.style.opacity = '1';
            }
            
            // Asegurar que todos los botones sean clickeables
            const buttons = avatarModal.querySelectorAll('button, input, .btn');
            buttons.forEach(btn => {
                btn.style.pointerEvents = 'auto';
                btn.style.zIndex = '100000';
                btn.style.position = 'relative';
            });
        });

        // Manejar el cierre del modal y limpiar formulario
        avatarModal.addEventListener('hidden.bs.modal', function() {
            console.log('Modal cerrado');
            // Limpiar el formulario
            if (avatarInput) {
                avatarInput.value = '';
            }
            if (imagePreview) {
                imagePreview.style.display = 'none';
            }
        });
    }

    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Validar tipo de archivo
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    alert('Por favor selecciona una imagen válida (JPEG, PNG, JPG, GIF)');
                    this.value = '';
                    return;
                }

                // Validar tamaño (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('La imagen no puede ser mayor a 2MB');
                    this.value = '';
                    return;
                }

                // Mostrar preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        });

        // Asegurar que el input de archivo funcione
        avatarInput.addEventListener('click', function(e) {
            e.stopPropagation();
            console.log('Input de archivo clickeado');
        });
    }

    // Manejar el envío del formulario
    if (avatarForm) {
        avatarForm.addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitAvatarBtn');
            const avatarInput = document.getElementById('avatar');
            
            // Verificar que se haya seleccionado un archivo
            if (!avatarInput.files || avatarInput.files.length === 0) {
                e.preventDefault();
                alert('Por favor selecciona una imagen antes de continuar.');
                return false;
            }
            
            // Deshabilitar el botón para evitar múltiples envíos
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Subiendo...';
                submitBtn.style.pointerEvents = 'none';
            }
            
            // Permitir que el formulario se envíe normalmente
            return true;
        });
    }

        // Manejar clics en los botones del modal para asegurar que funcionen
        const modalButtons = document.querySelectorAll('#avatarModal .btn');
        modalButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                e.preventDefault();
                console.log('Botón clickeado:', this.textContent.trim());
                
                // Manejar cada tipo de botón específicamente
                if (this.textContent.includes('Actualizar')) {
                    // Lógica para actualizar avatar
                    const form = document.getElementById('avatarForm');
                    if (form) {
                        form.submit();
                    }
                } else if (this.textContent.includes('Eliminar')) {
                    // Lógica para eliminar avatar
                    if (confirm('¿Estás seguro de que deseas eliminar tu foto de perfil?')) {
                        // Aquí iría la lógica para eliminar
                        console.log('Eliminar avatar');
                    }
                } else if (this.textContent.includes('Cancelar')) {
                    // Cerrar modal
                    modalInstance.hide();
                }
            });
        });

    // Confirmar cierre de sesión
    const logoutForm = document.querySelector('form[action*="logout"]');
    if (logoutForm) {
        logoutForm.addEventListener('submit', function(e) {
            if (!confirm('¿Estás seguro de que deseas cerrar sesión?')) {
                e.preventDefault();
            }
        });
    }

    // Manejar el formulario de perfil
    const profileForm = document.getElementById('profileForm');
    const saveButton = document.getElementById('saveButton');

    if (profileForm && saveButton) {
        // Validación en tiempo real
        const nameField = document.getElementById('name');
        const usernameField = document.getElementById('username');
        const telefonoField = document.getElementById('telefono');

        if (nameField) {
            nameField.addEventListener('blur', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });
        }

        if (usernameField) {
            usernameField.addEventListener('blur', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid', 'is-invalid');
                }
            });
        }

        // Manejar envío del formulario
        profileForm.addEventListener('submit', function(e) {
            // Validar campo requerido
            if (!nameField.value.trim()) {
                e.preventDefault();
                nameField.classList.add('is-invalid');
                alert('El nombre completo es requerido.');
                return false;
            }

            // Deshabilitar botón para evitar múltiples envíos
            saveButton.disabled = true;
            saveButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
            
            // Mostrar mensaje de procesamiento
            console.log('Enviando datos del perfil...');
        });

        // Restaurar botón si hay errores de validación
        profileForm.addEventListener('invalid', function() {
            saveButton.disabled = false;
            saveButton.innerHTML = '<i class="fas fa-save me-2"></i>Guardar Cambios';
        });

        // Restaurar botón después de 10 segundos si no hay respuesta
        profileForm.addEventListener('submit', function() {
            setTimeout(function() {
                if (saveButton.disabled) {
                    saveButton.disabled = false;
                    saveButton.innerHTML = '<i class="fas fa-save me-2"></i>Guardar Cambios';
                    console.log('Botón restaurado por timeout');
                }
            }, 10000);
        });
    }

});

// Mostrar mensajes de éxito/error
@if(session('success'))
    // Mostrar toast de éxito
    const successToast = document.createElement('div');
    successToast.className = 'toast-notification toast-success';
    successToast.innerHTML = `
        <div class="toast-content">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    `;
    document.body.appendChild(successToast);
    
    setTimeout(() => {
        successToast.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        successToast.classList.remove('show');
        setTimeout(() => {
            if (document.body.contains(successToast)) {
                document.body.removeChild(successToast);
            }
        }, 300);
    }, 3000);
@endif

@if(session('error'))
    // Mostrar toast de error
    const errorToast = document.createElement('div');
    errorToast.className = 'toast-notification toast-error';
    errorToast.innerHTML = `
        <div class="toast-content">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
    `;
    document.body.appendChild(errorToast);
    
    setTimeout(() => {
        errorToast.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        errorToast.classList.remove('show');
        setTimeout(() => {
            if (document.body.contains(errorToast)) {
                document.body.removeChild(errorToast);
            }
        }, 300);
    }, 4000);
@endif
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

/* Estilos para el avatar */
.avatar-container {
    display: inline-block;
}

.avatar-change-btn {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    border: 2px solid #fff;
    transition: all 0.3s ease;
}

.avatar-change-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.avatar-image {
    border: 3px solid #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.avatar-placeholder {
    border: 3px solid #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Estilos para el modal */
.modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    z-index: 9999 !important;
    position: relative;
    background: white !important;
    pointer-events: auto !important;
}

.modal {
    z-index: 9998 !important;
    background: rgba(0,0,0,0.5) !important;
}

.modal-backdrop {
    z-index: 9997 !important;
    background: rgba(0,0,0,0.5) !important;
}

.modal-dialog {
    z-index: 9999 !important;
    position: relative;
}

/* Estilos específicos para el modal de editar perfil */
#editProfileModal {
    z-index: 99999 !important;
}

#editProfileModal .modal-dialog {
    z-index: 100000 !important;
    position: relative;
    pointer-events: auto !important;
}

#editProfileModal .modal-content {
    z-index: 100001 !important;
    position: relative;
    background: white !important;
    pointer-events: auto !important;
    opacity: 1 !important;
}

#editProfileModal .modal-body {
    z-index: 100002 !important;
    position: relative;
    pointer-events: auto !important;
    background: white !important;
}

#editProfileModal .modal-footer {
    z-index: 100003 !important;
    position: relative;
    pointer-events: auto !important;
    background: white !important;
}

#editProfileModal .btn {
    z-index: 100004 !important;
    position: relative;
    pointer-events: auto !important;
    cursor: pointer !important;
    opacity: 1 !important;
}

#editProfileModal input, #editProfileModal textarea {
    z-index: 100005 !important;
    position: relative;
    pointer-events: auto !important;
    cursor: text !important;
    opacity: 1 !important;
}

/* Asegurar que el modal sea interactivo */
.modal.show {
    display: block !important;
}

.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
    transform: translate(0, -50px);
}

.modal.show .modal-dialog {
    transform: none;
}

/* Asegurar que los botones sean clickeables */
.modal-footer .btn {
    pointer-events: auto !important;
    z-index: 10000 !important;
    position: relative;
}

.modal-body {
    pointer-events: auto !important;
}

.modal-header {
    pointer-events: auto !important;
}

.modal-header {
    border-bottom: 1px solid #e9ecef;
    border-radius: 15px 15px 0 0;
}

.modal-footer {
    border-top: 1px solid #e9ecef;
    border-radius: 0 0 15px 15px;
}

.current-avatar, .current-avatar-placeholder {
    border: 3px solid #e9ecef;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Estilos adicionales para asegurar funcionalidad del modal */
#avatarModal {
    z-index: 99999 !important;
}

#avatarModal .modal-dialog {
    z-index: 100000 !important;
    position: relative;
}

#avatarModal .modal-content {
    z-index: 100001 !important;
    position: relative;
    background: white !important;
    pointer-events: auto !important;
    opacity: 1 !important;
}

#avatarModal .modal-body {
    z-index: 100002 !important;
    position: relative;
    pointer-events: auto !important;
    background: white !important;
}

#avatarModal .modal-footer {
    z-index: 100003 !important;
    position: relative;
    pointer-events: auto !important;
    background: white !important;
}

#avatarModal .btn {
    z-index: 100004 !important;
    position: relative;
    pointer-events: auto !important;
    cursor: pointer !important;
    opacity: 1 !important;
}

#avatarModal input[type="file"] {
    z-index: 100005 !important;
    position: relative;
    pointer-events: auto !important;
    cursor: pointer !important;
    opacity: 1 !important;
}

/* Forzar que el backdrop no interfiera */
.modal-backdrop {
    z-index: 99998 !important;
}

/* Asegurar que el modal esté por encima de todo */
#avatarModal.show {
    display: block !important;
    z-index: 99999 !important;
}

/* Estilos adicionales para el modal de editar perfil */
#editProfileModal.show {
    display: block !important;
    z-index: 99999 !important;
}

#editProfileModal.show .modal-dialog {
    transform: none !important;
    transition: none !important;
}

/* Forzar que el backdrop no interfiera con el modal de editar perfil */
#editProfileModal + .modal-backdrop {
    z-index: 99998 !important;
    background: rgba(0,0,0,0.5) !important;
}

/* Asegurar que el modal de editar perfil sea completamente funcional */
#editProfileModal .modal-header,
#editProfileModal .modal-body,
#editProfileModal .modal-footer {
    background: white !important;
    border: none !important;
    pointer-events: auto !important;
}

#editProfileModal .form-control {
    background: white !important;
    border: 1px solid #ced4da !important;
    pointer-events: auto !important;
}

#editProfileModal .form-control:focus {
    border-color: #80bdff !important;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25) !important;
}


/* Prevenir que otros elementos interfieran */
body.modal-open {
    overflow: hidden;
}

/* Estilos específicos para los botones del modal */
#avatarModal .modal-footer .btn {
    margin: 0 5px;
    min-width: 80px;
}

#avatarModal .btn-danger {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
}

#avatarModal .btn-secondary {
    background-color: #6c757d !important;
    border-color: #6c757d !important;
}

#avatarModal .btn-primary {
    background-color: #007bff !important;
    border-color: #007bff !important;
}

/* Estilos para las notificaciones toast */
.toast-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    min-width: 300px;
    padding: 1rem 1.5rem;
    border-radius: 10px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    transform: translateX(400px);
    opacity: 0;
    transition: all 0.3s ease;
}

.toast-notification.show {
    transform: translateX(0);
    opacity: 1;
}

.toast-success {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.toast-error {
    background: linear-gradient(135deg, #dc3545, #e74c3c);
    color: white;
}

.toast-content {
    display: flex;
    align-items: center;
    font-weight: 500;
}

/* Estilos para el input de archivo */
.form-control[type="file"] {
    padding: 0.5rem;
}

.form-control[type="file"]::-webkit-file-upload-button {
    background: #007bff;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    margin-right: 1rem;
    cursor: pointer;
    transition: background 0.3s ease;
}

.form-control[type="file"]::-webkit-file-upload-button:hover {
    background: #0056b3;
}

/* Animaciones */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.avatar-container {
    animation: fadeInUp 0.6s ease;
}

/* Estilos para el formulario de perfil */
.form-control:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.25);
}

.form-control.is-valid {
    border-color: #198754;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='m2.3 6.73.94-.94 1.88-1.88-1.88-1.88-.94-.94L0 4.7l.94.94L2.3 6.73z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.form-control.is-invalid {
    border-color: #dc3545;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 1.4 1.4 1.4-1.4'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

/* Estilos para el botón de guardar */
#saveButton {
    transition: all 0.3s ease;
    min-width: 150px;
}

#saveButton:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

#saveButton:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

/* Estilos para campos de solo lectura */
.form-control[readonly] {
    background-color: #f8f9fa;
    border-color: #e9ecef;
    color: #6c757d;
}

/* Estilos para el formulario */
#profileForm .form-label {
    font-weight: 600;
    color: #495057;
}

#profileForm .form-text {
    font-size: 0.875rem;
    color: #6c757d;
}

/* Animaciones para validación */
.form-control.is-valid,
.form-control.is-invalid {
    transition: all 0.3s ease;
}

/* Responsive */
@media (max-width: 768px) {
    .card {
        margin-bottom: 1rem;
    }
    
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .toast-notification {
        right: 10px;
        left: 10px;
        min-width: auto;
        transform: translateY(-100px);
    }
    
    .toast-notification.show {
        transform: translateY(0);
    }
    
    .avatar-change-btn {
        width: 24px;
        height: 24px;
        font-size: 0.7rem;
    }
    
    .modal-dialog {
        margin: 1rem;
    }
    
    #saveButton {
        width: 100%;
        margin-top: 1rem;
    }
}
</style>
@endsection
