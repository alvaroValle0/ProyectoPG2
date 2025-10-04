/**
 * Sistema de Tablas Responsive para Móviles
 * Convierte automáticamente tablas en cards en dispositivos móviles
 */

class MobileTableConverter {
    constructor() {
        this.breakpoint = 768;
        this.init();
    }

    init() {
        // Convertir tablas al cargar la página
        this.convertTables();
        
        // Reconvertir al cambiar tamaño de ventana
        window.addEventListener('resize', () => {
            this.convertTables();
        });
    }

    convertTables() {
        const tables = document.querySelectorAll('.modern-table, .table');
        
        tables.forEach(table => {
            if (window.innerWidth <= this.breakpoint) {
                this.convertToCards(table);
            } else {
                this.restoreTable(table);
            }
        });
    }

    convertToCards(table) {
        // Si ya está convertida, no hacer nada
        if (table.dataset.converted === 'true') return;

        const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        
        // Crear contenedor de cards
        const cardsContainer = document.createElement('div');
        cardsContainer.className = 'mobile-cards';
        cardsContainer.dataset.originalTable = 'true';

        rows.forEach((row, index) => {
            const cells = Array.from(row.querySelectorAll('td'));
            const card = this.createCard(headers, cells, index);
            cardsContainer.appendChild(card);
        });

        // Ocultar tabla original y mostrar cards
        table.style.display = 'none';
        table.dataset.converted = 'true';
        
        // Insertar cards después de la tabla
        table.parentNode.insertBefore(cardsContainer, table.nextSibling);
    }

    restoreTable(table) {
        // Si no está convertida, no hacer nada
        if (table.dataset.converted !== 'true') return;

        // Mostrar tabla original
        table.style.display = '';
        table.dataset.converted = 'false';

        // Remover cards
        const cardsContainer = table.parentNode.querySelector('.mobile-cards[data-original-table="true"]');
        if (cardsContainer) {
            cardsContainer.remove();
        }
    }

    createCard(headers, cells, index) {
        const card = document.createElement('div');
        card.className = 'mobile-card';
        card.dataset.index = index;

        // Header de la card
        const cardHeader = document.createElement('div');
        cardHeader.className = 'mobile-card-header';
        
        // Título principal (primera celda)
        const title = document.createElement('h6');
        title.className = 'mobile-card-title';
        title.textContent = cells[0]?.textContent.trim() || `Registro ${index + 1}`;
        cardHeader.appendChild(title);

        // Badge de estado si existe
        const statusCell = cells.find(cell => 
            cell.querySelector('.badge') || 
            cell.querySelector('.status-dot') ||
            cell.textContent.toLowerCase().includes('activo') ||
            cell.textContent.toLowerCase().includes('inactivo') ||
            cell.textContent.toLowerCase().includes('pendiente') ||
            cell.textContent.toLowerCase().includes('completado')
        );

        if (statusCell) {
            const statusBadge = statusCell.querySelector('.badge') || 
                               this.createStatusBadge(statusCell.textContent.trim());
            if (statusBadge) {
                cardHeader.appendChild(statusBadge.cloneNode(true));
            }
        }

        card.appendChild(cardHeader);

        // Body de la card
        const cardBody = document.createElement('div');
        cardBody.className = 'mobile-card-body';

        // Crear campos (saltar la primera celda que ya es el título)
        cells.slice(1).forEach((cell, cellIndex) => {
            const headerIndex = cellIndex + 1;
            if (headerIndex < headers.length && !this.isActionColumn(cell)) {
                const field = this.createField(headers[headerIndex], cell);
                cardBody.appendChild(field);
            }
        });

        card.appendChild(cardBody);

        // Acciones (botones)
        const actionCell = cells.find(cell => this.isActionColumn(cell));
        if (actionCell) {
            const cardActions = document.createElement('div');
            cardActions.className = 'mobile-card-actions';
            
            // Clonar botones de acción
            const buttons = actionCell.querySelectorAll('.btn, button, a[class*="btn"]');
            buttons.forEach(btn => {
                const clonedBtn = btn.cloneNode(true);
                clonedBtn.className = clonedBtn.className.replace(/btn-sm|btn-lg/g, '').trim();
                cardActions.appendChild(clonedBtn);
            });

            if (cardActions.children.length > 0) {
                card.appendChild(cardActions);
            }
        }

        return card;
    }

    createField(header, cell) {
        const field = document.createElement('div');
        field.className = 'mobile-card-field';

        const label = document.createElement('div');
        label.className = 'mobile-card-label';
        label.textContent = header;

        const value = document.createElement('div');
        value.className = 'mobile-card-value';
        
        // Preservar HTML interno (badges, iconos, etc.)
        value.innerHTML = cell.innerHTML;

        field.appendChild(label);
        field.appendChild(value);

        return field;
    }

    createStatusBadge(text) {
        const badge = document.createElement('span');
        badge.className = 'badge';
        
        // Determinar clase según el texto
        const lowerText = text.toLowerCase();
        if (lowerText.includes('activo') || lowerText.includes('completado')) {
            badge.className += ' bg-success';
        } else if (lowerText.includes('pendiente') || lowerText.includes('proceso')) {
            badge.className += ' bg-warning';
        } else if (lowerText.includes('inactivo') || lowerText.includes('cancelado')) {
            badge.className += ' bg-danger';
        } else {
            badge.className += ' bg-secondary';
        }
        
        badge.textContent = text;
        return badge;
    }

    isActionColumn(cell) {
        return cell.querySelector('.btn, button, .dropdown, a[class*="btn"]') !== null;
    }

    // Método para alternar entre vista de tabla y cards
    toggleView() {
        this.convertTables();
    }

    // Método para forzar conversión a cards
    forceCardView() {
        const tables = document.querySelectorAll('.modern-table, .table');
        tables.forEach(table => {
            this.convertToCards(table);
        });
    }

    // Método para forzar vista de tabla
    forceTableView() {
        const tables = document.querySelectorAll('.modern-table, .table');
        tables.forEach(table => {
            this.restoreTable(table);
        });
    }
}

// Variable global para la instancia
let mobileTableConverterInstance = null;

// Función para inicializar el convertidor
function initMobileTableConverter() {
    if (!mobileTableConverterInstance) {
        mobileTableConverterInstance = new MobileTableConverter();
        window.mobileTableConverter = mobileTableConverterInstance;
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    initMobileTableConverter();
});

// Función global para reconvertir tablas (útil para contenido dinámico)
window.reconvertMobileTables = function() {
    if (window.mobileTableConverter && typeof window.mobileTableConverter.convertTables === 'function') {
        window.mobileTableConverter.convertTables();
    } else {
        // Si no está disponible, inicializar
        initMobileTableConverter();
        if (window.mobileTableConverter) {
            window.mobileTableConverter.convertTables();
        }
    }
};

// Asegurar que la instancia esté disponible después de la carga
window.addEventListener('load', function() {
    if (!window.mobileTableConverter) {
        initMobileTableConverter();
    }
});

// Función de fallback global para toggleView
window.toggleMobileTable = function() {
    if (window.mobileTableConverter && typeof window.mobileTableConverter.toggleView === 'function') {
        window.mobileTableConverter.toggleView();
    } else if (window.reconvertMobileTables && typeof window.reconvertMobileTables === 'function') {
        window.reconvertMobileTables();
    }
};