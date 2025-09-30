/**
 * Utilidades Móviles para el Sistema HDC
 * Funciones de ayuda para mejorar la experiencia móvil
 */

class MobileUtils {
    constructor() {
        this.init();
    }

    init() {
        this.setupViewportMeta();
        this.setupTouchOptimizations();
        this.setupScrollOptimizations();
        this.setupKeyboardHandling();
        this.setupOrientationHandling();
    }

    /**
     * Configurar meta viewport para mejor experiencia móvil
     */
    setupViewportMeta() {
        let viewport = document.querySelector('meta[name="viewport"]');
        if (!viewport) {
            viewport = document.createElement('meta');
            viewport.name = 'viewport';
            document.head.appendChild(viewport);
        }
        
        // Configuración optimizada para móviles
        viewport.content = 'width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover';
    }

    /**
     * Optimizaciones táctiles
     */
    setupTouchOptimizations() {
        // Prevenir zoom en inputs en iOS
        const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="url"], input[type="password"], textarea, select');
        inputs.forEach(input => {
            if (input.style.fontSize === '') {
                input.style.fontSize = '16px'; // Previene zoom en iOS
            }
        });

        // Mejorar área de toque para elementos pequeños
        const smallButtons = document.querySelectorAll('.btn-sm, .btn-action, .dropdown-toggle');
        smallButtons.forEach(button => {
            button.style.minHeight = '44px';
            button.style.minWidth = '44px';
        });

        // Agregar efecto ripple a botones
        this.addRippleEffect();
    }

    /**
     * Efecto ripple para botones
     */
    addRippleEffect() {
        document.addEventListener('click', (e) => {
            const button = e.target.closest('.btn, .fab, .touchable');
            if (!button) return;

            const ripple = document.createElement('span');
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
                z-index: 1;
            `;

            button.style.position = 'relative';
            button.style.overflow = 'hidden';
            button.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    }

    /**
     * Optimizaciones de scroll
     */
    setupScrollOptimizations() {
        // Scroll suave en móviles
        if (window.innerWidth <= 768) {
            document.documentElement.style.scrollBehavior = 'smooth';
        }

        // Mejorar scroll horizontal en tablas
        const tableContainers = document.querySelectorAll('.table-responsive');
        tableContainers.forEach(container => {
            container.style.webkitOverflowScrolling = 'touch';
        });

        // Scroll infinito para listas largas
        this.setupInfiniteScroll();
    }

    /**
     * Configurar scroll infinito
     */
    setupInfiniteScroll() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const loadMoreBtn = entry.target.querySelector('.load-more-btn');
                    if (loadMoreBtn) {
                        loadMoreBtn.click();
                    }
                }
            });
        });

        const paginationContainers = document.querySelectorAll('.pagination-wrapper');
        paginationContainers.forEach(container => {
            observer.observe(container);
        });
    }

    /**
     * Manejo del teclado virtual
     */
    setupKeyboardHandling() {
        // Ajustar viewport cuando aparece el teclado
        let initialViewportHeight = window.innerHeight;
        
        window.addEventListener('resize', () => {
            const currentHeight = window.innerHeight;
            const heightDifference = initialViewportHeight - currentHeight;
            
            // Si la diferencia es significativa, probablemente es el teclado
            if (heightDifference > 150) {
                document.body.classList.add('keyboard-open');
            } else {
                document.body.classList.remove('keyboard-open');
            }
        });

        // Enfocar inputs cuando son visibles
        const inputs = document.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                // Scroll suave al input
                setTimeout(() => {
                    input.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                }, 300);
            });
        });
    }

    /**
     * Manejo de cambios de orientación
     */
    setupOrientationHandling() {
        window.addEventListener('orientationchange', () => {
            // Redimensionar tablas después de cambio de orientación
            setTimeout(() => {
                if (window.mobileTableConverter) {
                    window.mobileTableConverter.toggleView();
                }
            }, 500);
        });
    }

    /**
     * Detectar si es dispositivo móvil
     */
    isMobile() {
        return window.innerWidth <= 768 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }

    /**
     * Detectar si es iOS
     */
    isIOS() {
        return /iPad|iPhone|iPod/.test(navigator.userAgent);
    }

    /**
     * Detectar si es Android
     */
    isAndroid() {
        return /Android/.test(navigator.userAgent);
    }

    /**
     * Mostrar notificación móvil
     */
    showNotification(message, type = 'info', duration = 3000) {
        const notification = document.createElement('div');
        notification.className = `mobile-notification mobile-notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${this.getNotificationIcon(type)}"></i>
                <span>${message}</span>
            </div>
        `;

        // Estilos inline para la notificación
        notification.style.cssText = `
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: ${this.getNotificationColor(type)};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 9999;
            max-width: 90%;
            opacity: 0;
            transition: all 0.3s ease;
        `;

        document.body.appendChild(notification);

        // Animar entrada
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateX(-50%) translateY(0)';
        }, 100);

        // Auto-remover
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(-50%) translateY(-20px)';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, duration);
    }

    getNotificationIcon(type) {
        const icons = {
            success: 'check-circle',
            error: 'exclamation-circle',
            warning: 'exclamation-triangle',
            info: 'info-circle'
        };
        return icons[type] || 'info-circle';
    }

    getNotificationColor(type) {
        const colors = {
            success: '#28a745',
            error: '#dc3545',
            warning: '#ffc107',
            info: '#17a2b8'
        };
        return colors[type] || '#17a2b8';
    }

    /**
     * Optimizar imágenes para móviles
     */
    optimizeImages() {
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            // Lazy loading para imágenes
            if (!img.loading) {
                img.loading = 'lazy';
            }

            // Ajustar tamaño en móviles
            if (window.innerWidth <= 768) {
                img.style.maxWidth = '100%';
                img.style.height = 'auto';
            }
        });
    }

    /**
     * Prevenir zoom en inputs doble tap
     */
    preventDoubleTapZoom() {
        let lastTouchEnd = 0;
        document.addEventListener('touchend', (e) => {
            const now = (new Date()).getTime();
            if (now - lastTouchEnd <= 300) {
                e.preventDefault();
            }
            lastTouchEnd = now;
        }, false);
    }
}

// CSS para animaciones
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .keyboard-open {
        height: 100vh;
        overflow: hidden;
    }
    
    .mobile-notification {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .notification-content {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
`;
document.head.appendChild(style);

// Inicializar automáticamente
window.mobileUtils = new MobileUtils();

// Exportar para uso global
window.showMobileNotification = (message, type, duration) => {
    window.mobileUtils.showNotification(message, type, duration);
};
