@extends('layouts.app')

@section('title', 'Logs del Sistema')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-file-alt text-secondary me-2"></i>
            Logs del Sistema
        </h1>
        <p class="text-muted">Visualiza y gestiona los logs del sistema para monitoreo y depuración</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('configuracion.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Lista de Logs -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list text-secondary me-2"></i>
                    Archivos de Log Disponibles
                </h5>
                <form method="POST" action="{{ route('configuracion.limpiar-logs') }}" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas limpiar todos los logs? Esta acción no se puede deshacer.')">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-custom">
                        <i class="fas fa-broom me-2"></i>Limpiar Logs
                    </button>
                </form>
            </div>
            <div class="card-body">
                @if(count($logs) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nombre del Archivo</th>
                                    <th>Tamaño</th>
                                    <th>Fecha de Modificación</th>
                                    <th width="150px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-alt text-secondary me-2"></i>
                                            <div>
                                                <strong>{{ $log['nombre'] }}</strong>
                                                <br>
                                                <small class="text-muted">Archivo de log del sistema</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $log['tamaño'] }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ \Carbon\Carbon::parse($log['fecha'])->format('d/m/Y') }}</strong>
                                            <br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($log['fecha'])->format('H:i:s') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" 
                                                    class="btn btn-outline-info btn-ver-log" 
                                                    data-log-nombre="{{ $log['nombre'] }}"
                                                    data-log-ruta="{{ $log['ruta'] }}"
                                                    title="Ver contenido">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <a href="{{ route('configuracion.descargar-log', $log['nombre']) }}" 
                                               class="btn btn-outline-success" 
                                               title="Descargar">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-outline-danger btn-eliminar-log" 
                                                    data-log-nombre="{{ $log['nombre'] }}"
                                                    data-log-url="{{ route('configuracion.eliminar-log', $log['nombre']) }}"
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
                        <i class="fas fa-file-alt display-1 text-muted mb-4"></i>
                        <h4 class="text-muted">No hay archivos de log disponibles</h4>
                        <p class="text-muted">Los logs aparecerán aquí cuando el sistema genere actividad.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Información de Logs -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle text-secondary me-2"></i>
                    Información de Logs
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">¿Qué registran los logs?</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Errores del sistema y excepciones
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Acciones de usuarios y autenticación
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Operaciones de base de datos
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Actividad del servidor web
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Niveles de Log</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="badge bg-danger me-2">ERROR</span>
                                Errores críticos que requieren atención inmediata
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-warning me-2">WARNING</span>
                                Advertencias que no son críticas pero importantes
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-info me-2">INFO</span>
                                Información general del sistema
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-secondary me-2">DEBUG</span>
                                Información detallada para depuración
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Estadísticas de Logs -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="mb-0">
                    <i class="fas fa-chart-bar text-primary me-2"></i>
                    Estadísticas
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="h4 text-primary">{{ count($logs) }}</div>
                    <small class="text-muted">Archivos de log</small>
                </div>
                <div class="text-center mb-3">
                    <div class="h4 text-success">
                        @if(count($logs) > 0)
                            {{ \Carbon\Carbon::parse($logs[0]['fecha'])->diffForHumans() }}
                        @else
                            Nunca
                        @endif
                    </div>
                    <small class="text-muted">Última actividad</small>
                </div>
                <div class="text-center mb-3">
                    <div class="h4 text-info">
                        @if(count($logs) > 0)
                            @php
                                $totalSize = 0;
                                foreach($logs as $log) {
                                    $size = str_replace([' KB', ' MB', ' GB'], '', $log['tamaño']);
                                    $unit = str_replace($size, '', $log['tamaño']);
                                    switch($unit) {
                                        case ' KB': $totalSize += $size * 1024; break;
                                        case ' MB': $totalSize += $size * 1024 * 1024; break;
                                        case ' GB': $totalSize += $size * 1024 * 1024 * 1024; break;
                                        default: $totalSize += $size; break;
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
                    <button type="button" class="btn btn-outline-info w-100" onclick="generarLogPrueba()">
                        <i class="fas fa-plus me-2"></i>Generar Log de Prueba
                    </button>
                    <button type="button" class="btn btn-outline-warning w-100" onclick="configurarLogs()">
                        <i class="fas fa-cog me-2"></i>Configurar Logs
                    </button>
                    <button type="button" class="btn btn-outline-secondary w-100" onclick="exportarLogs()">
                        <i class="fas fa-file-export me-2"></i>Exportar Logs
                    </button>
                </div>
            </div>
        </div>

        <!-- Configuración de Logs -->
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
                        <strong>Nivel de Log:</strong><br>
                        <span class="badge bg-info">INFO</span>
                    </li>
                    <li class="mb-2">
                        <strong>Retención:</strong><br>
                        <span class="text-muted">30 días</span>
                    </li>
                    <li class="mb-2">
                        <strong>Rotación:</strong><br>
                        <span class="badge bg-success">Diaria</span>
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

<!-- Modal para ver contenido del log -->
<div class="modal fade" id="logModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: #6c757d;">
                <h5 class="modal-title">
                    <i class="fas fa-file-alt me-2"></i>
                    Contenido del Log: <span id="logFileName"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" id="logSearch" placeholder="Buscar en el log...">
                    </div>
                </div>
                <div class="border rounded p-3" style="background: #f8f9fa; max-height: 500px; overflow-y: auto;">
                    <pre id="logContent" style="font-size: 0.875rem; margin: 0;"></pre>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cerrar
                </button>
                <button type="button" class="btn btn-info" onclick="descargarLogContenido()">
                    <i class="fas fa-download me-2"></i>Descargar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Ver contenido del log
document.querySelectorAll('.btn-ver-log').forEach(button => {
    button.addEventListener('click', function() {
        const nombre = this.getAttribute('data-log-nombre');
        const ruta = this.getAttribute('data-log-ruta');
        
        document.getElementById('logFileName').textContent = nombre;
        
        // Simular carga del contenido del log
        document.getElementById('logContent').innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>';
        
        // En una implementación real, harías una llamada AJAX para obtener el contenido
        // Por ahora, simulamos contenido
        setTimeout(() => {
            const contenidoSimulado = `[2024-01-15 10:30:15] local.INFO: Usuario autenticado exitosamente {"user_id":1,"email":"admin@example.com"}
[2024-01-15 10:30:20] local.INFO: Nueva reparación creada {"reparacion_id":123,"equipo_id":456}
[2024-01-15 10:35:45] local.WARNING: Equipo con garantía próxima a vencer {"equipo_id":789,"fecha_vencimiento":"2024-02-01"}
[2024-01-15 11:15:30] local.ERROR: Error al conectar con la base de datos {"error":"Connection timeout"}
[2024-01-15 11:16:00] local.INFO: Conexión a base de datos restaurada
[2024-01-15 12:00:00] local.INFO: Backup automático completado {"archivo":"backup_2024-01-15.sql","tamaño":"2.5 MB"}`;
            
            document.getElementById('logContent').textContent = contenidoSimulado;
        }, 1000);
        
        const modal = new bootstrap.Modal(document.getElementById('logModal'));
        modal.show();
    });
});

// Eliminar log
document.querySelectorAll('.btn-eliminar-log').forEach(button => {
    button.addEventListener('click', function() {
        const nombre = this.getAttribute('data-log-nombre');
        const url = this.getAttribute('data-log-url');
        
        if (confirm(`¿Estás seguro de que deseas eliminar el log "${nombre}"? Esta acción no se puede deshacer.`)) {
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

// Búsqueda en el log
document.getElementById('logSearch').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const logContent = document.getElementById('logContent');
    const lines = logContent.textContent.split('\n');
    
    if (searchTerm === '') {
        // Mostrar todas las líneas
        logContent.innerHTML = lines.map(line => `<div>${line}</div>`).join('');
    } else {
        // Resaltar líneas que coincidan
        const highlightedLines = lines.map(line => {
            if (line.toLowerCase().includes(searchTerm)) {
                return `<div style="background-color: yellow;">${line}</div>`;
            }
            return `<div>${line}</div>`;
        });
        logContent.innerHTML = highlightedLines.join('');
    }
});

function generarLogPrueba() {
    showToast('info', 'Generando log de prueba...');
    setTimeout(() => {
        showToast('success', 'Log de prueba generado correctamente');
    }, 2000);
}

function configurarLogs() {
    showToast('info', 'Funcionalidad de configuración próximamente disponible');
}

function exportarLogs() {
    showToast('info', 'Funcionalidad de exportación próximamente disponible');
}

function descargarLogContenido() {
    const contenido = document.getElementById('logContent').textContent;
    const nombre = document.getElementById('logFileName').textContent;
    
    const blob = new Blob([contenido], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = nombre;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
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

pre {
    white-space: pre-wrap;
    word-wrap: break-word;
    font-family: 'Courier New', monospace;
}
</style>
@endsection
