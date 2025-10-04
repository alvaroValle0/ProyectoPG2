/**
 * Sistema de Sidebar Móvil Mejorado
 * Garantiza que el sidebar funcione perfectamente en dispositivos móviles
 */

class MobileSidebar {
    constructor() {
        this.breakpoint = 768;
        this.isOpen = false;
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupDropdowns();
        this.setupOverlay();
        this.setupResizeHandler();
    }

    setupEventListeners() {
        // Botón toggle del sidebar
        const toggleBtn = document.getElementById('sidebarToggle');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.toggle();
            });
        }

        // Cerrar al hacer click en elementos del menú
        this.setupMenuClickHandlers();
    }

    setupMenuClickHandlers() {
        // Elementos principales del menú
        const menuItems = document.querySelectorAll('.sidebar-item');
        menuItems.forEach(item => {
            item.addEventListener('click', (e) => {
                // Solo cerrar en móvil
                if (window.innerWidth <= this.breakpoint) {
                    setTimeout(() => {
                        this.close();
                    }, 300);
                }
            });
        });

        // Elementos de dropdown
        const dropdownItems = document.querySelectorAll('.sidebar-dropdown-item');
        dropdownItems.forEach(item => {
            item.addEventListener('click', (e) => {
                // Solo cerrar en móvil
                if (window.innerWidth <= this.breakpoint) {
                    setTimeout(() => {
                        this.close();
                    }, 300);
                }
            });
        });
    }

    setupDropdowns() {
        // Manejar dropdowns del sidebar
        const dropdownToggles = document.querySelectorAll('.sidebar-dropdown-toggle');
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                const dropdown = toggle.nextElementSibling;
                if (dropdown) {
                    dropdown.classList.toggle('show');
                    
                    // Rotar flecha
                    const arrow = toggle.querySelector('.dropdown-arrow');
                    if (arrow) {
                        arrow.style.transform = dropdown.classList.contains('show') 
                            ? 'rotate(180deg)' 
                            : 'rotate(0deg)';
                    }
                }
            });
        });
    }

    setupOverlay() {
        const overlay = document.getElementById('sidebarOverlay');
        if (overlay) {
            overlay.addEventListener('click', () => {
                this.close();
            });
        }
    }

    setupResizeHandler() {
        window.addEventListener('resize', () => {
            if (window.innerWidth > this.breakpoint) {
                this.close();
            }
        });
    }

    toggle() {
        if (this.isOpen) {
            this.close();
        } else {
            this.open();
        }
    }

    open() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (sidebar && overlay) {
            sidebar.classList.add('show');
            overlay.classList.add('show');
            document.body.classList.add('sidebar-open');
            this.isOpen = true;
            
            // Prevenir scroll del body
            document.body.style.overflow = 'hidden';
            document.body.style.position = 'fixed';
            document.body.style.width = '100%';
        }
    }

    close() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (sidebar && overlay) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.classList.remove('sidebar-open');
            this.isOpen = false;
            
            // Restaurar scroll del body
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
        }
    }

    // Método público para cerrar desde otros scripts
    forceClose() {
        this.close();
    }

    // Método público para abrir desde otros scripts
    forceOpen() {
        this.open();
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    window.mobileSidebar = new MobileSidebar();
});

// Función global para cerrar sidebar
window.closeSidebar = function() {
    if (window.mobileSidebar) {
        window.mobileSidebar.forceClose();
    }
};

// Función global para abrir sidebar
window.openSidebar = function() {
    if (window.mobileSidebar) {
        window.mobileSidebar.forceOpen();
    }
};

// Función global para toggle sidebar
window.toggleSidebar = function() {
    if (window.mobileSidebar) {
        window.mobileSidebar.toggle();
    }
};

