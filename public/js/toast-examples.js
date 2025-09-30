/**
 * Ejemplos de uso del Sistema de Notificaciones Toast HDC
 * Este archivo contiene ejemplos de cómo usar las notificaciones
 */

// Ejemplos básicos
function showBasicToasts() {
    // Toast de éxito
    toastSystem.success('Operación Exitosa', 'Los datos se han guardado correctamente');
    
    // Toast de error
    toastSystem.error('Error de Validación', 'Por favor, verifica los campos requeridos');
    
    // Toast de advertencia
    toastSystem.warning('Advertencia', 'El archivo será eliminado permanentemente');
    
    // Toast de información
    toastSystem.info('Información', 'Nueva actualización disponible para el sistema');
    
    // Toast personalizado (usando colores del sistema)
    toastSystem.primary('Notificación HDC', 'Sistema actualizado correctamente');
}

// Ejemplos con opciones personalizadas
function showCustomToasts() {
    // Toast con duración personalizada
    toastSystem.success('Guardado', 'Datos guardados exitosamente', {
        duration: 3000
    });
    
    // Toast persistente (no se cierra automáticamente)
    toastSystem.error('Error Crítico', 'No se puede conectar con el servidor', {
        persistent: true
    });
    
    // Toast con sonido
    toastSystem.info('Nueva Notificación', 'Tienes un mensaje nuevo', {
        sound: true
    });
    
    // Toast sin botón de cerrar
    toastSystem.warning('Procesando', 'Por favor espera...', {
        showClose: false
    });
    
    // Toast sin barra de progreso
    toastSystem.info('Información', 'Esta notificación no muestra progreso', {
        showProgress: false
    });
}

// Ejemplos con acciones
function showToastsWithActions() {
    // Toast con botones de acción
    toastSystem.info('Confirmación Requerida', '¿Deseas eliminar este elemento?', {
        actions: [
            {
                text: 'Eliminar',
                type: 'primary',
                onclick: 'confirmDelete()'
            },
            {
                text: 'Cancelar',
                type: 'secondary',
                onclick: 'window.toastSystem.clear()'
            }
        ]
    });
    
    // Toast con enlace a página
    toastSystem.success('Registro Completado', 'Tu cuenta ha sido creada exitosamente', {
        actions: [
            {
                text: 'Ir al Dashboard',
                type: 'primary',
                onclick: 'window.location.href="/dashboard"'
            }
        ]
    });
}

// Ejemplos para diferentes módulos del sistema
function showModuleToasts() {
    // Para el módulo de clientes
    toastSystem.success('Cliente Agregado', 'El cliente se ha registrado correctamente');
    
    // Para el módulo de equipos
    toastSystem.warning('Equipo en Reparación', 'Este equipo requiere atención inmediata');
    
    // Para el módulo de reparaciones
    toastSystem.info('Reparación Actualizada', 'El estado de la reparación ha cambiado');
    
    // Para el módulo de inventario
    toastSystem.error('Stock Bajo', 'El producto está agotándose');
    
    // Para el módulo de usuarios
    toastSystem.primary('Usuario Creado', 'Nuevo usuario agregado al sistema');
}

// Ejemplos de configuración global
function configureToastSystem() {
    // Configurar duración por defecto
    toastSystem.config({
        duration: 4000
    });
    
    // Configurar máximo de toasts
    toastSystem.config({
        maxToasts: 3
    });
    
    // Configurar con sonido
    toastSystem.config({
        sound: true
    });
    
    // Configurar sin duplicados
    toastSystem.config({
        allowDuplicates: false
    });
}

// Funciones de utilidad para el sistema
function showLoginToasts() {
    toastSystem.success('Bienvenido', 'Has iniciado sesión correctamente');
}

function showLogoutToasts() {
    toastSystem.info('Sesión Cerrada', 'Has cerrado sesión correctamente');
}

function showSaveToasts() {
    toastSystem.success('Guardado', 'Los cambios se han guardado exitosamente');
}

function showDeleteToasts() {
    toastSystem.warning('Eliminado', 'El elemento ha sido eliminado');
}

function showErrorToasts() {
    toastSystem.error('Error', 'Ha ocurrido un error inesperado');
}

// Ejemplos de uso en formularios
function showFormToasts() {
    // Validación de formulario
    toastSystem.error('Formulario Incompleto', 'Por favor, completa todos los campos requeridos');
    
    // Envío exitoso
    toastSystem.success('Formulario Enviado', 'Tu solicitud ha sido procesada correctamente');
    
    // Error de validación
    toastSystem.warning('Datos Inválidos', 'Verifica que los datos ingresados sean correctos');
}

// Ejemplos para operaciones AJAX
function showAjaxToasts() {
    // Cargando datos
    const loadingToast = toastSystem.info('Cargando', 'Obteniendo datos del servidor...', {
        persistent: true
    });
    
    // Simular operación AJAX
    setTimeout(() => {
        toastSystem.remove(loadingToast);
        toastSystem.success('Datos Cargados', 'La información se ha actualizado correctamente');
    }, 2000);
}

// Función para demostrar todos los ejemplos
function runAllExamples() {
    setTimeout(() => showBasicToasts(), 1000);
    setTimeout(() => showCustomToasts(), 6000);
    setTimeout(() => showToastsWithActions(), 12000);
    setTimeout(() => showModuleToasts(), 18000);
}

// Función para limpiar todos los toasts
function clearAllToasts() {
    toastSystem.clear();
}

// Integración con eventos del sistema
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar notificación de bienvenida
    setTimeout(() => {
        toastSystem.primary('Sistema HDC', 'Bienvenido al sistema de gestión integral');
    }, 1000);
});

// Exportar funciones para uso global
window.showBasicToasts = showBasicToasts;
window.showCustomToasts = showCustomToasts;
window.showToastsWithActions = showToastsWithActions;
window.showModuleToasts = showModuleToasts;
window.configureToastSystem = configureToastSystem;
window.showLoginToasts = showLoginToasts;
window.showLogoutToasts = showLogoutToasts;
window.showSaveToasts = showSaveToasts;
window.showDeleteToasts = showDeleteToasts;
window.showErrorToasts = showErrorToasts;
window.showFormToasts = showFormToasts;
window.showAjaxToasts = showAjaxToasts;
window.runAllExamples = runAllExamples;
window.clearAllToasts = clearAllToasts;
