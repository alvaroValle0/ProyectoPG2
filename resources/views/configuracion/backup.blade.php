@extends('layouts.app')

@section('title', 'Gestión de Backups')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-database text-info me-2"></i>
            Gestión de Backups
        </h1>
        <p class="text-muted">Gestiona los respaldos de la base de datos y configura backups automáticos</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('configuracion.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Lista de Backups -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list text-info me-2"></i>
                    Backups Disponibles
                </h5>
                <form method="POST" action="{{ route('configuracion.crear-backup') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-info btn-custom">
                        <i class="fas fa-plus me-2"></i>Crear Backup
                    </button>
                </form>
            </div>
            <div class="card-body">
                @if(count($backups) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nombre del Archivo</th>
                                    <th>Tamaño</th>
                                    <th>Fecha de Creación</th>
                                    <th width="150px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($backups as $backup)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-database text-info me-2"></i>
                                            <div>
                                                <strong>{{ $backup['nombre'] }}</strong>
                                                <br>
                                                <small class="text-muted">Backup de base de datos</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $backup['tamaño'] }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ \Carbon\Carbon::parse($backup['fecha'])->format('d/m/Y') }}</strong>
                                            <br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($backup['fecha'])->format('H:i:s') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('configuracion.descargar-backup', $backup['nombre']) }}" 
                                               class="btn btn-outline-success" 
                                               title="Descargar">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-outline-danger btn-eliminar-backup" 
                                                    data-backup-nombre="{{ $backup['nombre'] }}"
                                                    data-backup-url="{{ route('configuracion.eliminar-backup', $backup['nombre']) }}"
                                                    title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-database display-1 text-muted mb-4"></i>
                        <h4 class="text-muted">No hay backups disponibles</h4>
                        <p class="text-muted">Crea tu primer backup para proteger los datos del sistema.</p>
                        <form method="POST" action="{{ route('configuracion.crear-backup') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-info btn-custom">
                                <i class="fas fa-plus me-2"></i>Crear Primer Backup
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Información de Backup -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle text-info me-2"></i>
                    Información de Backup
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">¿Qué incluye el backup?</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Estructura completa de la base de datos
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Todos los datos de usuarios, equipos y reparaciones
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Configuraciones del sistema
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Historial de transacciones
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Recomendaciones</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-lightbulb text-warning me-2"></i>
                                Crea backups regularmente (diario o semanal)
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-lightbulb text-warning me-2"></i>
                                Guarda los backups en un lugar seguro
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-lightbulb text-warning me-2"></i>
                                Prueba la restauración periódicamente
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-lightbulb text-warning me-2"></i>
                                Mantén múltiples versiones de backup
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Estadísticas de Backup -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="mb-0">
                    <i class="fas fa-chart-bar text-primary me-2"></i>
                    Estadísticas
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="h4 text-primary">{{ count($backups) }}</div>
                    <small class="text-muted">Backups disponibles</small>
                </div>
                <div class="text-center mb-3">
                    <div class="h4 text-success">
                        @if(count($backups) > 0)
                            {{ \Carbon\Carbon::parse($backups[0]['fecha'])->diffForHumans() }}
                        @else
                            Nunca
                        @endif
                    </div>
                    <small class="text-muted">Último backup</small>
                </div>
                <div class="text-center mb-3">
                    <div class="h4 text-info">
                        @if(count($backups) > 0)
                            @php
                                $totalSize = 0;
                                foreach($backups as $backup) {
                                    $sizeString = $backup['tamaño'] ?? '0 KB';
                                    // Extraer número y unidad
                                    preg_match('/([0-9.]+)\s*(KB|MB|GB)/i', $sizeString, $matches);
                                    
                                    if (count($matches) >= 3) {
                                        $size = floatval($matches[1]);
                                        $unit = strtoupper(trim($matches[2]));
                                        
                                        switch($unit) {
                                            case 'KB': $totalSize += $size * 1024; break;
                                            case 'MB': $totalSize += $size * 1024 * 1024; break;
                                            case 'GB': $totalSize += $size * 1024 * 1024 * 1024; break;
                                            default: $totalSize += $size; break;
                                        }
                                    }
                                }
                                $totalSize = $totalSize / (1024 * 1024); // Convert to MB
                            @endphp
                            {{ round($totalSize, 2) }} MB
                        @else
                            0 MB
                        @endif
                    </div>
                    <small class="text-muted">Espacio total usado</small>
                </div>
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
                    <form method="POST" action="{{ route('configuracion.crear-backup') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-info w-100">
                            <i class="fas fa-plus me-2"></i>Crear Backup Manual
                        </button>
                    </form>
                    <button type="button" class="btn btn-outline-warning w-100" onclick="configurarBackupAutomatico()">
                        <i class="fas fa-cog me-2"></i>Configurar Automático
                    </button>
                    <button type="button" class="btn btn-outline-secondary w-100" onclick="restaurarBackup()">
                        <i class="fas fa-undo me-2"></i>Restaurar Backup
                    </button>
                </div>
            </div>
        </div>

        <!-- Configuración de Backup -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h6 class="mb-0">
                    <i class="fas fa-cogs text-dark me-2"></i>
                    Configuración
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <strong>Backup Automático:</strong><br>
                        <span class="badge bg-secondary">Desactivado</span>
                    </li>
                    <li class="mb-2">
                        <strong>Frecuencia:</strong><br>
                        <span class="text-muted">No configurado</span>
                    </li>
                    <li class="mb-2">
                        <strong>Retención:</strong><br>
                        <span class="text-muted">Sin límite</span>
                    </li>
                    <li class="mb-2">
                        <strong>Compresión:</strong><br>
                        <span class="badge bg-success">Activada</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Eliminar backup
document.querySelectorAll('.btn-eliminar-backup').forEach(button => {
    button.addEventListener('click', function() {
        const nombre = this.getAttribute('data-backup-nombre');
        const url = this.getAttribute('data-backup-url');
        
        if (confirm(`¿Estás seguro de que deseas eliminar el backup "${nombre}"? Esta acción no se puede deshacer.`)) {
            // Crear formulario dinámico para eliminar
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    });
});

function configurarBackupAutomatico() {
    showToast('info', 'Funcionalidad de backup automático próximamente disponible');
}

function restaurarBackup() {
    showToast('info', 'Funcionalidad de restauración próximamente disponible');
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

.table-responsive {
    border-radius: 15px;
    overflow: hidden;
}

.table th {
    border: none;
    padding: 1rem 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table td {
    padding: 1rem 0.75rem;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
}

.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35rem 0.65rem;
}

.btn-group-sm > .btn {
    padding: 0.375rem 0.5rem;
    font-size: 0.875rem;
}
</style>
@endsection
