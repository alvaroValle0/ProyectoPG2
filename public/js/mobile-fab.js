/**
 * Sistema de Botones Flotantes (FAB) para Móviles
 * Agrega automáticamente botones de acción flotantes en dispositivos móviles
 */

class MobileFAB {
    constructor() {
        this.breakpoint = 768;
        this.init();
    }

    init() {
        // Solo en dispositivos móviles
        if (window.innerWidth <= this.breakpoint) {
            this.createFAB();
        }

        // Recrear FAB al cambiar tamaño de ventana
        window.addEventListener('resize', () => {
            this.handleResize();
        });
    }

    handleResize() {
        const existingFAB = document.querySelector('.fab-main');
        
        if (window.innerWidth <= this.breakpoint && !existingFAB) {
            this.createFAB();
        } else if (window.innerWidth > this.breakpoint && existingFAB) {
            existingFAB.remove();
        }
    }

    createFAB() {
        // Determinar acción principal según la página actual
        const fabConfig = this.getFABConfig();
        
        if (!fabConfig) return;

        // Crear botón FAB
        const fab = document.createElement('a');
        fab.className = 'fab-main';
        fab.href = fabConfig.href;
        fab.innerHTML = `<i class="${fabConfig.icon}"></i>`;
        fab.title = fabConfig.title;
        fab.setAttribute('aria-label', fabConfig.title);

        // Agregar al DOM
        document.body.appendChild(fab);

        // Agregar funcionalidad adicional
        this.addFABBehavior(fab);
    }

    getFABConfig() {
        const path = window.location.pathname;
        const configs = {
            // Dashboard
            '/dashboard': {
                href: '/reparaciones/create',
                icon: 'fas fa-plus',
                title: 'Nueva Reparación'
            },
            
            // Reparaciones
            '/reparaciones': {
                href: '/reparaciones/create',
                icon: 'fas fa-plus',
                title: 'Nueva Reparación'
            },
            
            // Equipos
            '/equipos': {
                href: '/equipos/create',
                icon: 'fas fa-plus',
                title: 'Nuevo Equipo'
            },
            
            // Clientes
            '/clientes': {
                href: '/clientes/create',
                icon: 'fas fa-user-plus',
                title: 'Nuevo Cliente'
            },
            
            // Inventario
            '/inventario': {
                href: '/inventario/create',
                icon: 'fas fa-box',
                title: 'Nuevo Producto'
            },
            
            // Tickets
            '/tickets': {
                href: '/tickets/create',
                icon: 'fas fa-ticket-alt',
                title: 'Nuevo Ticket'
            },
            
            // Técnicos
            '/tecnicos': {
                href: '/tecnicos/create',
                icon: 'fas fa-user-cog',
                title: 'Nuevo Técnico'
            },
            
            // Usuarios
            '/usuarios': {
                href: '/usuarios/create',
                icon: 'fas fa-user-plus',
                title: 'Nuevo Usuario'
            }
        };

        // Buscar configuración exacta o por prefijo
        for (const [route, config] of Object.entries(configs)) {
            if (path === route || path.startsWith(route + '/')) {
                return config;
            }
        }

        return null;
    }

    addFABBehavior(fab) {
        // Ocultar FAB cuando se abre un modal
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    const body = mutation.target;
                    if (body.classList.contains('modal-open')) {
                        fab.style.display = 'none';
                    } else {
                        fab.style.display = 'flex';
                    }
                }
            });
        });

        observer.observe(document.body, {
            attributes: true,
            attributeFilter: ['class']
        });

        // Ocultar FAB al hacer scroll hacia abajo, mostrar al hacer scroll hacia arriba
        let lastScrollTop = 0;
        let scrollTimeout;

        window.addEventListener('scroll', () => {
            clearTimeout(scrollTimeout);
            
            scrollTimeout = setTimeout(() => {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    // Scrolling hacia abajo
                    fab.style.transform = 'translateY(100px)';
                    fab.style.opacity = '0';
                } else {
                    // Scrolling hacia arriba o en la parte superior
                    fab.style.transform = 'translateY(0)';
                    fab.style.opacity = '1';
                }
                
                lastScrollTop = scrollTop;
            }, 100);
        });

        // Efecto ripple al hacer click
        fab.addEventListener('click', (e) => {
            const ripple = document.createElement('span');
            ripple.className = 'fab-ripple';
            
            const rect = fab.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            fab.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    new MobileFAB();
});

// CSS para el efecto ripple
const fabStyles = document.createElement('style');
fabStyles.textContent = `
    .fab-main {
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .fab-ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: fab-ripple-animation 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes fab-ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .fab-main:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }
    
    .fab-main:active {
        transform: scale(0.95);
    }
`;
document.head.appendChild(fabStyles);
