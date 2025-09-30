/**
 * Sistema de Tablas Móviles Automático
 * Convierte tablas en tarjetas responsive para dispositivos móviles
 */

class MobileTableConverter {
    constructor() {
        this.init();
    }

    init() {
        // Esperar a que el DOM esté listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.convertTables());
        } else {
            this.convertTables();
        }

        // Reconectar al redimensionar ventana
        window.addEventListener('resize', () => {
            this.toggleView();
        });
    }

    convertTables() {
    const tables = document.querySelectorAll('.modern-table');
    
    tables.forEach(table => {
    const tableContainer = table.closest('.table-responsive');
    if (!tableContainer) return;
    
            // Crear contenedor de tarjetas móviles
            let mobileContainer = tableContainer.querySelector('.mobile-cards');
            if (!mobileContainer) {
                mobileContainer = document.createElement('div');
                mobileContainer.className = 'mobile-cards';
                mobileContainer.style.display = 'none';
                tableContainer.appendChild(mobileContainer);
            }

            // Generar tarjetas móviles
            this.generateMobileCards(table, mobileContainer);
        });

        this.toggleView();
    }

    generateMobileCards(table, container) {
        const headers = Array.from(table.querySelectorAll('thead th')).map(th => ({
            text: th.textContent.trim(),
            className: th.className,
            dataAttribute: th.getAttribute('data-mobile-label') || th.textContent.trim()
        }));

        const rows = Array.from(table.querySelectorAll('tbody tr'));
        
        container.innerHTML = '';

        rows.forEach((row, index) => {
            const card = this.createMobileCard(row, headers, index);
            container.appendChild(card);
        });
    }

    createMobileCard(row, headers, index) {
        const cells = Array.from(row.querySelectorAll('td'));
        const card = document.createElement('div');
        card.className = 'mobile-card';

        // Determinar estado para el borde de color
        const statusCell = cells.find(cell => cell.querySelector('.badge'));
        if (statusCell) {
            const badge = statusCell.querySelector('.badge');
            if (badge.classList.contains('bg-success')) {
                card.classList.add('status-active');
            } else if (badge.classList.contains('bg-warning')) {
                card.classList.add('status-pending');
            } else if (badge.classList.contains('bg-danger')) {
                card.classList.add('status-inactive');
            }
        }

        // Crear header de la tarjeta
        const header = this.createCardHeader(row, cells, headers);
        card.appendChild(header);

        // Crear body de la tarjeta
        const body = this.createCardBody(row, cells, headers);
        card.appendChild(body);

        // Crear acciones de la tarjeta
        const actions = this.createCardActions(row, cells);
        if (actions) {
            card.appendChild(actions);
        }

        return card;
    }

    createCardHeader(row, cells, headers) {
        const header = document.createElement('div');
        header.className = 'mobile-card-header';

        // Título principal (primera columna o columna con más peso visual)
        const titleCell = cells[0];
        const title = document.createElement('h6');
        title.className = 'mobile-card-title';
        title.textContent = this.extractTextContent(titleCell);

        // Subtítulo (segunda columna si existe)
        let subtitle = null;
        if (cells.length > 1) {
            subtitle = document.createElement('div');
            subtitle.className = 'mobile-card-subtitle';
            subtitle.textContent = this.extractTextContent(cells[1]);
        }

        const titleContainer = document.createElement('div');
        titleContainer.appendChild(title);
        if (subtitle) {
            titleContainer.appendChild(subtitle);
        }

        // Estado/Badge en el header
        const statusContainer = document.createElement('div');
        const statusBadge = row.querySelector('.badge');
        if (statusBadge) {
            statusContainer.appendChild(statusBadge.cloneNode(true));
        }

        header.appendChild(titleContainer);
        header.appendChild(statusContainer);

        return header;
    }

    createCardBody(row, cells, headers) {
        const body = document.createElement('div');
        body.className = 'mobile-card-body';

        // Mostrar columnas importantes en el body
        for (let i = 2; i < Math.min(cells.length, headers.length); i++) {
            const cell = cells[i];
            const header = headers[i];

            // Saltar columnas de acciones
            if (cell.querySelector('.btn') || cell.querySelector('.btn-group')) {
                continue;
            }
            
            const field = document.createElement('div');
            field.className = 'mobile-card-field';
            
            const label = document.createElement('div');
            label.className = 'mobile-card-label';
            label.textContent = header.dataAttribute;
            
            const value = document.createElement('div');
            value.className = 'mobile-card-value';
            
            // Copiar contenido de la celda
            if (cell.innerHTML.trim()) {
            value.innerHTML = cell.innerHTML;
            } else {
                value.textContent = this.extractTextContent(cell);
            }
            
            field.appendChild(label);
            field.appendChild(value);
            body.appendChild(field);
        }

        return body;
    }

    createCardActions(row, cells) {
        const actionCell = cells.find(cell => 
            cell.querySelector('.btn') || cell.querySelector('.btn-group')
        );

        if (!actionCell) return null;

        const actions = document.createElement('div');
        actions.className = 'mobile-card-actions';

        // Copiar botones de la celda de acciones
        const buttons = actionCell.querySelectorAll('.btn');
        buttons.forEach(button => {
            const clonedButton = button.cloneNode(true);
            clonedButton.className = button.className;
            actions.appendChild(clonedButton);
        });

        return actions;
    }

    extractTextContent(element) {
        // Remover contenido de botones y elementos interactivos
        const clone = element.cloneNode(true);
        clone.querySelectorAll('.btn, .btn-group, .dropdown').forEach(el => el.remove());
        return clone.textContent.trim();
    }

    toggleView() {
        const isMobile = window.innerWidth <= 768;
    
    document.querySelectorAll('.table-responsive').forEach(container => {
            const table = container.querySelector('.modern-table');
            const mobileCards = container.querySelector('.mobile-cards');
            
            if (table && mobileCards) {
                if (isMobile) {
                    table.style.display = 'none';
                    mobileCards.style.display = 'block';
                } else {
                    table.style.display = 'table';
                    mobileCards.style.display = 'none';
                }
            }
        });
    }

    // Método público para reconvertir tablas (útil después de actualizaciones AJAX)
    reconvert() {
        this.convertTables();
    }
}

// Inicializar automáticamente
window.mobileTableConverter = new MobileTableConverter();

// Función global para reconvertir tablas
window.reconvertMobileTables = () => {
    if (window.mobileTableConverter) {
        window.mobileTableConverter.reconvert();
    }
};

// Auto-reconvertir después de actualizaciones AJAX
document.addEventListener('DOMContentLoaded', () => {
    // Observer para detectar cambios en el DOM
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === 1 && node.querySelector && node.querySelector('.modern-table')) {
                        setTimeout(() => {
                            window.reconvertMobileTables();
                        }, 100);
                    }
                });
            }
        });
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});