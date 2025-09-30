/**
 * Sistema de Notificaciones Toast para HDC
 * Versión 1.0
 */

(function() {
    'use strict';

    // Configuración por defecto
    const defaultConfig = {
        duration: 5000,
        position: 'top-right',
        maxToasts: 5,
        showProgress: true,
        showClose: true,
        allowDuplicates: false,
        sound: false,
        animation: 'slide'
    };

    // Contador de toasts para IDs únicos
    let toastCounter = 0;

    // Array para almacenar toasts activos
    let activeToasts = [];

    // Crear contenedor de toasts si no existe
    function createToastContainer() {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container';
            document.body.appendChild(container);
        }
        return container;
    }

    // Limpiar toasts duplicados si está habilitado
    function clearDuplicateToasts(title, message) {
        if (!defaultConfig.allowDuplicates) {
            activeToasts.forEach(toast => {
                if (toast.title === title && toast.message === message) {
                    removeToast(toast.id);
                }
            });
        }
    }

    // Limitar número máximo de toasts
    function limitToasts() {
        if (activeToasts.length >= defaultConfig.maxToasts) {
            const oldestToast = activeToasts[0];
            removeToast(oldestToast.id);
        }
    }

    // Crear toast
    function createToast(config) {
        const toastId = `toast-${++toastCounter}`;
        const container = createToastContainer();
        
        // Limpiar duplicados si es necesario
        clearDuplicateToasts(config.title, config.message);
        
        // Limitar número de toasts
        limitToasts();

        // Crear elemento toast
        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className = `toast-notification toast-${config.type}`;
        
        // Configurar duración
        if (config.duration > 0) {
            toast.style.setProperty('--duration', `${config.duration}ms`);
        }

        // Crear estructura del toast
        toast.innerHTML = `
            <div class="toast-icon">
                <i class="${getIcon(config.type)}"></i>
            </div>
            <div class="toast-content">
                <div class="toast-title">${config.title || ''}</div>
                <div class="toast-message">${config.message || ''}</div>
                ${config.actions ? createActionButtons(config.actions) : ''}
            </div>
            ${config.showClose !== false ? '<button class="toast-close" onclick="window.toastSystem.remove(\'' + toastId + '\')"><i class="fas fa-times"></i></button>' : ''}
            ${config.showProgress !== false && config.duration > 0 ? '<div class="toast-progress"><div class="toast-progress-bar"></div></div>' : ''}
        `;

        // Agregar clases adicionales
        if (config.persistent) {
            toast.classList.add('toast-persistent');
        }
        if (config.sound) {
            toast.classList.add('toast-with-sound');
        }

        // Agregar al contenedor
        container.appendChild(toast);

        // Animar entrada
        requestAnimationFrame(() => {
            toast.classList.add('show');
        });

        // Auto-remover si no es persistente
        if (!config.persistent && config.duration > 0) {
            setTimeout(() => {
                removeToast(toastId);
            }, config.duration);
        }

        // Agregar a la lista de toasts activos
        const toastData = {
            id: toastId,
            title: config.title,
            message: config.message,
            type: config.type,
            element: toast
        };
        activeToasts.push(toastData);

        // Reproducir sonido si está habilitado
        if (config.sound) {
            playNotificationSound(config.type);
        }

        return toastId;
    }

    // Obtener icono según el tipo
    function getIcon(type) {
        const icons = {
            success: 'fas fa-check',
            error: 'fas fa-times',
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle',
            primary: 'fas fa-bell'
        };
        return icons[type] || icons.info;
    }

    // Crear botones de acción
    function createActionButtons(actions) {
        let buttonsHtml = '<div class="toast-action">';
        actions.forEach(action => {
            buttonsHtml += `<button class="toast-action-btn ${action.type || 'secondary'}" onclick="${action.onclick}">${action.text}</button>`;
        });
        buttonsHtml += '</div>';
        return buttonsHtml;
    }

    // Remover toast
    function removeToast(toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            toast.classList.remove('show');
            toast.classList.add('hide');
            
            // Remover del DOM después de la animación
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
                
                // Remover de la lista de toasts activos
                activeToasts = activeToasts.filter(t => t.id !== toastId);
            }, 400);
        }
    }

    // Reproducir sonido de notificación
    function playNotificationSound(type) {
        try {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            // Diferentes frecuencias según el tipo
            const frequencies = {
                success: 800,
                error: 400,
                warning: 600,
                info: 500,
                primary: 700
            };
            
            oscillator.frequency.setValueAtTime(frequencies[type] || 500, audioContext.currentTime);
            gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.2);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.2);
        } catch (error) {
            console.log('No se pudo reproducir sonido de notificación:', error);
        }
    }

    // API pública del sistema de toasts
    window.toastSystem = {
        // Configurar el sistema
        config: function(newConfig) {
            Object.assign(defaultConfig, newConfig);
        },

        // Métodos principales
        success: function(title, message, options = {}) {
            return createToast({
                type: 'success',
                title: title,
                message: message,
                ...defaultConfig,
                ...options
            });
        },

        error: function(title, message, options = {}) {
            return createToast({
                type: 'error',
                title: title,
                message: message,
                duration: 8000, // Errores duran más tiempo
                ...defaultConfig,
                ...options
            });
        },

        warning: function(title, message, options = {}) {
            return createToast({
                type: 'warning',
                title: title,
                message: message,
                duration: 6000,
                ...defaultConfig,
                ...options
            });
        },

        info: function(title, message, options = {}) {
            return createToast({
                type: 'info',
                title: title,
                message: message,
                ...defaultConfig,
                ...options
            });
        },

        primary: function(title, message, options = {}) {
            return createToast({
                type: 'primary',
                title: title,
                message: message,
                ...defaultConfig,
                ...options
            });
        },

        // Método genérico
        show: function(type, title, message, options = {}) {
            return createToast({
                type: type,
                title: title,
                message: message,
                ...defaultConfig,
                ...options
            });
        },

        // Remover toast específico
        remove: function(toastId) {
            removeToast(toastId);
        },

        // Limpiar todos los toasts
        clear: function() {
            activeToasts.forEach(toast => {
                removeToast(toast.id);
            });
        },

        // Obtener toasts activos
        getActive: function() {
            return activeToasts.map(toast => ({
                id: toast.id,
                title: toast.title,
                message: toast.message,
                type: toast.type
            }));
        }
    };

    // Métodos de conveniencia para uso común
    window.showToast = window.toastSystem.show;
    window.showSuccess = window.toastSystem.success;
    window.showError = window.toastSystem.error;
    window.showWarning = window.toastSystem.warning;
    window.showInfo = window.toastSystem.info;

    // Integración con eventos del sistema
    document.addEventListener('DOMContentLoaded', function() {
        // Configurar por defecto
        window.toastSystem.config({
            duration: 5000,
            maxToasts: 5,
            showProgress: true,
            showClose: true,
            allowDuplicates: false
        });
    });

    // Manejar errores globales (opcional)
    window.addEventListener('error', function(event) {
        if (window.toastSystem && event.error) {
            window.toastSystem.error(
                'Error del Sistema',
                event.error.message || 'Ha ocurrido un error inesperado',
                { persistent: true }
            );
        }
    });

    console.log('🚀 Sistema de Toasts HDC cargado correctamente');

})();

// Ejemplos de uso:
/*
// Básico
toastSystem.success('Éxito', 'Operación completada correctamente');
toastSystem.error('Error', 'No se pudo completar la operación');
toastSystem.warning('Advertencia', 'Verifica los datos ingresados');
toastSystem.info('Información', 'Nueva actualización disponible');

// Con opciones
toastSystem.success('Éxito', 'Datos guardados', {
    duration: 3000,
    sound: true,
    persistent: false
});

// Con acciones
toastSystem.info('Nueva Notificación', 'Tienes un mensaje nuevo', {
    actions: [
        {
            text: 'Ver',
            type: 'primary',
            onclick: 'window.location.href="/mensajes"'
        },
        {
            text: 'Cerrar',
            type: 'secondary',
            onclick: 'window.toastSystem.remove(this.closest(".toast-notification").id)'
        }
    ]
});

// Configuración global
toastSystem.config({
    duration: 4000,
    maxToasts: 3,
    sound: true
});
*/
