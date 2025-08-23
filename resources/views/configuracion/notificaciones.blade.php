@extends('layouts.app')

@section('title', 'Configuración de Notificaciones')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-bell text-warning me-2"></i>
            Configuración de Notificaciones
        </h1>
        <p class="text-muted">Configura las notificaciones por email y alertas del sistema</p>
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
                    <i class="fas fa-envelope text-warning me-2"></i>
                    Configuración de Notificaciones
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('configuracion.actualizar-notificaciones') }}">
                    @csrf
                    
                    <!-- Notificaciones Generales -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-cog me-2"></i>Notificaciones Generales
                        </h6>
                        
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="email_notificaciones" 
                                   name="email_notificaciones" 
                                   {{ old('email_notificaciones', $configuraciones['email_notificaciones'] ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="email_notificaciones">
                                <strong>Activar notificaciones por email</strong>
                                <br>
                                <small class="text-muted">Permite el envío de notificaciones por correo electrónico</small>
                            </label>
                        </div>
                    </div>

                    <hr>

                    <!-- Notificaciones de Reparaciones -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-wrench me-2"></i>Notificaciones de Reparaciones
                        </h6>
                        
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="notif_nuevas_reparaciones" 
                                   name="notif_nuevas_reparaciones" 
                                   {{ old('notif_nuevas_reparaciones', $configuraciones['notif_nuevas_reparaciones'] ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="notif_nuevas_reparaciones">
                                <strong>Nuevas reparaciones</strong>
                                <br>
                                <small class="text-muted">Notificar cuando se registre una nueva reparación</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="notif_reparaciones_completadas" 
                                   name="notif_reparaciones_completadas" 
                                   {{ old('notif_reparaciones_completadas', $configuraciones['notif_reparaciones_completadas'] ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="notif_reparaciones_completadas">
                                <strong>Reparaciones completadas</strong>
                                <br>
                                <small class="text-muted">Notificar cuando una reparación sea marcada como completada</small>
                            </label>
                        </div>
                    </div>

                    <hr>

                    <!-- Notificaciones de Equipos -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-laptop me-2"></i>Notificaciones de Equipos
                        </h6>
                        
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="notif_equipos_vencidos" 
                                   name="notif_equipos_vencidos" 
                                   {{ old('notif_equipos_vencidos', $configuraciones['notif_equipos_vencidos'] ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="notif_equipos_vencidos">
                                <strong>Equipos con garantía vencida</strong>
                                <br>
                                <small class="text-muted">Notificar cuando un equipo tenga la garantía próxima a vencer</small>
                            </label>
                        </div>
                    </div>

                    <hr>

                    <!-- Notificaciones del Sistema -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-server me-2"></i>Notificaciones del Sistema
                        </h6>
                        
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="notif_backup" 
                                   name="notif_backup" 
                                   {{ old('notif_backup', $configuraciones['notif_backup'] ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="notif_backup">
                                <strong>Backups del sistema</strong>
                                <br>
                                <small class="text-muted">Notificar cuando se complete un backup automático</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="notif_errores" 
                                   name="notif_errores" 
                                   {{ old('notif_errores', $configuraciones['notif_errores'] ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="notif_errores">
                                <strong>Errores del sistema</strong>
                                <br>
                                <small class="text-muted">Notificar cuando ocurran errores críticos en el sistema</small>
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-warning btn-custom">
                            <i class="fas fa-save me-2"></i>Guardar Configuración
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Vista Previa de Notificaciones -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-eye text-info me-2"></i>
                    Vista Previa de Notificaciones
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i class="fas fa-wrench me-2"></i>Nueva Reparación
                            </h6>
                            <p class="mb-0">Se ha registrado una nueva reparación para el equipo #12345</p>
                            <small class="text-muted">Hace 5 minutos</small>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="alert alert-success">
                            <h6 class="alert-heading">
                                <i class="fas fa-check-circle me-2"></i>Reparación Completada
                            </h6>
                            <p class="mb-0">La reparación #789 ha sido marcada como completada</p>
                            <small class="text-muted">Hace 2 horas</small>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="alert alert-warning">
                            <h6 class="alert-heading">
                                <i class="fas fa-exclamation-triangle me-2"></i>Garantía Vencida
                            </h6>
                            <p class="mb-0">El equipo #67890 tiene la garantía próxima a vencer</p>
                            <small class="text-muted">Hace 1 día</small>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="alert alert-secondary">
                            <h6 class="alert-heading">
                                <i class="fas fa-database me-2"></i>Backup Completado
                            </h6>
                            <p class="mb-0">Se ha completado el backup automático del sistema</p>
                            <small class="text-muted">Hace 6 horas</small>
                        </div>
                    </div>
                </div>
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
                        <strong>Email Notificaciones:</strong><br>
                        <span class="badge bg-{{ $configuraciones['email_notificaciones'] ?? true ? 'success' : 'danger' }}">
                            {{ $configuraciones['email_notificaciones'] ?? true ? 'Activado' : 'Desactivado' }}
                        </span>
                    </li>
                    <li class="mb-2">
                        <strong>Nuevas Reparaciones:</strong><br>
                        <span class="badge bg-{{ $configuraciones['notif_nuevas_reparaciones'] ?? true ? 'success' : 'secondary' }}">
                            {{ $configuraciones['notif_nuevas_reparaciones'] ?? true ? 'Activado' : 'Desactivado' }}
                        </span>
                    </li>
                    <li class="mb-2">
                        <strong>Reparaciones Completadas:</strong><br>
                        <span class="badge bg-{{ $configuraciones['notif_reparaciones_completadas'] ?? true ? 'success' : 'secondary' }}">
                            {{ $configuraciones['notif_reparaciones_completadas'] ?? true ? 'Activado' : 'Desactivado' }}
                        </span>
                    </li>
                    <li class="mb-2">
                        <strong>Equipos Vencidos:</strong><br>
                        <span class="badge bg-{{ $configuraciones['notif_equipos_vencidos'] ?? true ? 'success' : 'secondary' }}">
                            {{ $configuraciones['notif_equipos_vencidos'] ?? true ? 'Activado' : 'Desactivado' }}
                        </span>
                    </li>
                    <li class="mb-2">
                        <strong>Backups:</strong><br>
                        <span class="badge bg-{{ $configuraciones['notif_backup'] ?? true ? 'success' : 'secondary' }}">
                            {{ $configuraciones['notif_backup'] ?? true ? 'Activado' : 'Desactivado' }}
                        </span>
                    </li>
                    <li class="mb-2">
                        <strong>Errores del Sistema:</strong><br>
                        <span class="badge bg-{{ $configuraciones['notif_errores'] ?? true ? 'success' : 'secondary' }}">
                            {{ $configuraciones['notif_errores'] ?? true ? 'Activado' : 'Desactivado' }}
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
                    <button type="button" class="btn btn-outline-info" onclick="enviarNotificacionPrueba()">
                        <i class="fas fa-paper-plane me-2"></i>Enviar Notificación de Prueba
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="verHistorialNotificaciones()">
                        <i class="fas fa-history me-2"></i>Ver Historial
                    </button>
                    <button type="button" class="btn btn-outline-warning" onclick="configurarPlantillas()">
                        <i class="fas fa-edit me-2"></i>Configurar Plantillas
                    </button>
                </div>
            </div>
        </div>

        <!-- Estadísticas de Notificaciones -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h6 class="mb-0">
                    <i class="fas fa-chart-bar text-primary me-2"></i>
                    Estadísticas
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="h4 text-primary">156</div>
                    <small class="text-muted">Notificaciones enviadas hoy</small>
                </div>
                <div class="text-center mb-3">
                    <div class="h4 text-success">98%</div>
                    <small class="text-muted">Tasa de entrega exitosa</small>
                </div>
                <div class="text-center">
                    <div class="h4 text-info">2.3s</div>
                    <small class="text-muted">Tiempo promedio de envío</small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function enviarNotificacionPrueba() {
    if (confirm('¿Deseas enviar una notificación de prueba a tu email?')) {
        // Simular envío de notificación
        showToast('info', 'Enviando notificación de prueba...');
        
        setTimeout(() => {
            showToast('success', 'Notificación de prueba enviada correctamente');
        }, 2000);
    }
}

function verHistorialNotificaciones() {
    showToast('info', 'Funcionalidad de historial próximamente disponible');
}

function configurarPlantillas() {
    showToast('info', 'Funcionalidad de plantillas próximamente disponible');
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
            <div class="toast-header bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : type === 'info' ? 'info' : 'warning'} text-white">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'info' ? 'info-circle' : 'exclamation-triangle'} me-2"></i>
                <strong class="me-auto">${type === 'success' ? 'Éxito' : type === 'error' ? 'Error' : type === 'info' ? 'Información' : 'Advertencia'}</strong>
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

.alert {
    border: none;
    border-radius: 10px;
}

.alert-heading {
    font-size: 0.9rem;
    font-weight: 600;
}
</style>
@endsection
