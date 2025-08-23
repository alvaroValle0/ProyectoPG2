@extends('layouts.app')

@section('title', 'Configuración del Sistema')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-server text-success me-2"></i>
            Configuración del Sistema
        </h1>
        <p class="text-muted">Configura parámetros de seguridad, sesiones, mantenimiento y otros ajustes del sistema</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('configuracion.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-cogs text-success me-2"></i>
                    Configuración del Sistema
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('configuracion.actualizar-sistema') }}">
                    @csrf
                    
                    <!-- Modo Mantenimiento -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-tools me-2"></i>Modo Mantenimiento
                        </h6>
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="mantenimiento" 
                                   name="mantenimiento" 
                                   {{ old('mantenimiento', $configuraciones['mantenimiento'] ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="mantenimiento">
                                <strong>Activar modo mantenimiento</strong>
                                <br>
                                <small class="text-muted">Cuando esté activado, solo los administradores podrán acceder al sistema</small>
                            </label>
                        </div>
                    </div>

                    <hr>

                    <!-- Configuración de Usuarios -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-users me-2"></i>Configuración de Usuarios
                        </h6>
                        
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="registro_usuarios" 
                                   name="registro_usuarios" 
                                   {{ old('registro_usuarios', $configuraciones['registro_usuarios'] ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="registro_usuarios">
                                <strong>Permitir registro de nuevos usuarios</strong>
                                <br>
                                <small class="text-muted">Permite que los usuarios se registren automáticamente</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="verificacion_email" 
                                   name="verificacion_email" 
                                   {{ old('verificacion_email', $configuraciones['verificacion_email'] ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="verificacion_email">
                                <strong>Requerir verificación de email</strong>
                                <br>
                                <small class="text-muted">Los usuarios deben verificar su email antes de poder usar el sistema</small>
                            </label>
                        </div>
                    </div>

                    <hr>

                    <!-- Configuración de Seguridad -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-shield-alt me-2"></i>Configuración de Seguridad
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="sesion_tiempo" class="form-label">
                                    <i class="fas fa-clock me-1"></i>Tiempo de Sesión (minutos) *
                                </label>
                                <input type="number" 
                                       class="form-control @error('sesion_tiempo') is-invalid @enderror" 
                                       id="sesion_tiempo" 
                                       name="sesion_tiempo" 
                                       value="{{ old('sesion_tiempo', $configuraciones['sesion_tiempo'] ?? 120) }}" 
                                       min="15" 
                                       max="480" 
                                       required>
                                <div class="form-text">Tiempo máximo de inactividad antes de cerrar sesión (15-480 minutos)</div>
                                @error('sesion_tiempo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="max_intentos_login" class="form-label">
                                    <i class="fas fa-lock me-1"></i>Máximo Intentos de Login *
                                </label>
                                <input type="number" 
                                       class="form-control @error('max_intentos_login') is-invalid @enderror" 
                                       id="max_intentos_login" 
                                       name="max_intentos_login" 
                                       value="{{ old('max_intentos_login', $configuraciones['max_intentos_login'] ?? 5) }}" 
                                       min="3" 
                                       max="10" 
                                       required>
                                <div class="form-text">Número máximo de intentos fallidos antes de bloquear la cuenta</div>
                                @error('max_intentos_login')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Configuración de Backup -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-database me-2"></i>Configuración de Backup
                        </h6>
                        
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="backup_automatico" 
                                   name="backup_automatico" 
                                   {{ old('backup_automatico', $configuraciones['backup_automatico'] ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="backup_automatico">
                                <strong>Activar backup automático</strong>
                                <br>
                                <small class="text-muted">Crea respaldos automáticos de la base de datos</small>
                            </label>
                        </div>

                        <div class="mb-3" id="frecuencia_backup_container" style="display: {{ old('backup_automatico', $configuraciones['backup_automatico'] ?? false) ? 'block' : 'none' }};">
                            <label for="frecuencia_backup" class="form-label">
                                <i class="fas fa-calendar me-1"></i>Frecuencia de Backup
                            </label>
                            <select class="form-select @error('frecuencia_backup') is-invalid @enderror" 
                                    id="frecuencia_backup" 
                                    name="frecuencia_backup">
                                <option value="daily" {{ (old('frecuencia_backup', $configuraciones['frecuencia_backup'] ?? '') == 'daily') ? 'selected' : '' }}>Diario</option>
                                <option value="weekly" {{ (old('frecuencia_backup', $configuraciones['frecuencia_backup'] ?? '') == 'weekly') ? 'selected' : '' }}>Semanal</option>
                                <option value="monthly" {{ (old('frecuencia_backup', $configuraciones['frecuencia_backup'] ?? '') == 'monthly') ? 'selected' : '' }}>Mensual</option>
                            </select>
                            @error('frecuencia_backup')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success btn-custom">
                            <i class="fas fa-save me-2"></i>Guardar Configuración
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Estado Actual -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle text-info me-2"></i>
                    Estado Actual
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <strong>Modo Mantenimiento:</strong><br>
                        <span class="badge bg-{{ $configuraciones['mantenimiento'] ?? false ? 'danger' : 'success' }}">
                            {{ $configuraciones['mantenimiento'] ?? false ? 'Activado' : 'Desactivado' }}
                        </span>
                    </li>
                    <li class="mb-2">
                        <strong>Registro de Usuarios:</strong><br>
                        <span class="badge bg-{{ $configuraciones['registro_usuarios'] ?? true ? 'success' : 'danger' }}">
                            {{ $configuraciones['registro_usuarios'] ?? true ? 'Permitido' : 'Bloqueado' }}
                        </span>
                    </li>
                    <li class="mb-2">
                        <strong>Verificación Email:</strong><br>
                        <span class="badge bg-{{ $configuraciones['verificacion_email'] ?? false ? 'warning' : 'secondary' }}">
                            {{ $configuraciones['verificacion_email'] ?? false ? 'Requerida' : 'Opcional' }}
                        </span>
                    </li>
                    <li class="mb-2">
                        <strong>Tiempo de Sesión:</strong><br>
                        <span class="text-muted">{{ $configuraciones['sesion_tiempo'] ?? 120 }} minutos</span>
                    </li>
                    <li class="mb-2">
                        <strong>Máximo Intentos:</strong><br>
                        <span class="text-muted">{{ $configuraciones['max_intentos_login'] ?? 5 }} intentos</span>
                    </li>
                    <li class="mb-2">
                        <strong>Backup Automático:</strong><br>
                        <span class="badge bg-{{ $configuraciones['backup_automatico'] ?? false ? 'success' : 'secondary' }}">
                            {{ $configuraciones['backup_automatico'] ?? false ? 'Activado' : 'Desactivado' }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="mb-0">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    Acciones Rápidas
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('configuracion.backup') }}" class="btn btn-outline-info">
                        <i class="fas fa-database me-2"></i>Gestionar Backups
                    </a>
                    <a href="{{ route('configuracion.logs') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-file-alt me-2"></i>Ver Logs
                    </a>
                    <button type="button" class="btn btn-outline-warning" onclick="limpiarCache()">
                        <i class="fas fa-broom me-2"></i>Limpiar Cache
                    </button>
                </div>
            </div>
        </div>

        <!-- Información del Sistema -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h6 class="mb-0">
                    <i class="fas fa-server text-dark me-2"></i>
                    Información del Sistema
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <strong>Versión PHP:</strong><br>
                        <span class="text-muted">{{ phpversion() }}</span>
                    </li>
                    <li class="mb-2">
                        <strong>Versión Laravel:</strong><br>
                        <span class="text-muted">{{ app()->version() }}</span>
                    </li>
                    <li class="mb-2">
                        <strong>Entorno:</strong><br>
                        <span class="badge bg-{{ app()->environment() == 'production' ? 'success' : 'warning' }}">
                            {{ app()->environment() }}
                        </span>
                    </li>
                    <li class="mb-2">
                        <strong>Debug:</strong><br>
                        <span class="badge bg-{{ config('app.debug') ? 'danger' : 'success' }}">
                            {{ config('app.debug') ? 'Activado' : 'Desactivado' }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Mostrar/ocultar frecuencia de backup según el checkbox
document.getElementById('backup_automatico').addEventListener('change', function() {
    const container = document.getElementById('frecuencia_backup_container');
    if (this.checked) {
        container.style.display = 'block';
    } else {
        container.style.display = 'none';
    }
});

function limpiarCache() {
    if (confirm('¿Estás seguro de que deseas limpiar la cache del sistema? Esto puede mejorar el rendimiento.')) {
        // Aquí podrías hacer una llamada AJAX para limpiar la cache
        fetch('/configuracion/limpiar-cache', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'Cache limpiada correctamente');
            } else {
                showToast('error', 'Error al limpiar la cache');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'Error al limpiar la cache');
        });
    }
}

function showToast(type, message) {
    // Crear toast dinámico
    const toastContainer = document.getElementById('toast-container') || (() => {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
        return container;
    })();
    
    const toastHtml = `
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-${type === 'success' ? 'success' : 'danger'} text-white">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                <strong class="me-auto">${type === 'success' ? 'Éxito' : 'Error'}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    const toastElement = toastContainer.lastElementChild;
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
    
    // Eliminar el toast después de que se oculte
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
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

.btn-custom {
    border-radius: 25px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35rem 0.65rem;
}
</style>
@endsection
