/**
 * Sistema de tablas móviles optimizadas
 * Gestión HDC - Responsive Tables
 */

document.addEventListener('DOMContentLoaded', function() {
    initMobileTables();
    initColumnToggle();
    initMobileCards();
});

/**
 * Inicializar mejoras para tablas móviles
 */
function initMobileTables() {
    const tables = document.querySelectorAll('.modern-table');
    
    tables.forEach(table => {
        addScrollIndicators(table);
        improveTouchAccessibility(table);
        addSwipeGestures(table);
    });
}

/**
 * Agregar indicadores de scroll horizontal
 */
function addScrollIndicators(table) {
    const tableContainer = table.closest('.table-responsive');
    if (!tableContainer) return;
    
    // Crear indicadores
    const leftIndicator = document.createElement('div');
    leftIndicator.className = 'scroll-indicator scroll-indicator-left';
    leftIndicator.innerHTML = '<i class="fas fa-chevron-left"></i>';
    
    const rightIndicator = document.createElement('div');
    rightIndicator.className = 'scroll-indicator scroll-indicator-right';
    rightIndicator.innerHTML = '<i class="fas fa-chevron-right"></i>';
    
    // Agregar estilos
    if (!document.querySelector('#mobile-table-styles')) {
        const style = document.createElement('style');
        style.id = 'mobile-table-styles';
        style.textContent = `
            .table-responsive { position: relative; }
            .scroll-indicator {
                position: absolute; top: 50%; transform: translateY(-50%);
                background: rgba(0, 0, 0, 0.7); color: white;
                width: 32px; height: 32px; border-radius: 50%;
                display: flex; align-items: center; justify-content: center;
                z-index: 10; opacity: 0; transition: opacity 0.3s ease;
                pointer-events: none;
            }
            .scroll-indicator-left { left: 10px; }
            .scroll-indicator-right { right: 10px; }
            .scroll-indicator.show { opacity: 1; }
            @media (min-width: 769px) { .scroll-indicator { display: none; } }
        `;
        document.head.appendChild(style);
    }
    
    tableContainer.appendChild(leftIndicator);
    tableContainer.appendChild(rightIndicator);
    
    // Manejar scroll
    tableContainer.addEventListener('scroll', function() {
        const { scrollLeft, scrollWidth, clientWidth } = this;
        leftIndicator.classList.toggle('show', scrollLeft > 0);
        rightIndicator.classList.toggle('show', scrollLeft < scrollWidth - clientWidth);
    });
}

/**
 * Mejorar accesibilidad táctil
 */
function improveTouchAccessibility(table) {
    // Hacer filas clickeables más fáciles de tocar
    const rows = table.querySelectorAll('tbody tr[onclick], tbody tr[data-href]');
    
    rows.forEach(row => {
        row.style.minHeight = '56px';
        row.style.cursor = 'pointer';
        
        row.addEventListener('touchstart', function() {
            this.style.backgroundColor = 'rgba(0, 123, 255, 0.1)';
        });
        
        row.addEventListener('touchend', function() {
            setTimeout(() => { this.style.backgroundColor = ''; }, 150);
        });
    });
    
    // Mejorar botones de acción
    const actionButtons = table.querySelectorAll('.btn-action');
    actionButtons.forEach(btn => {
        if (btn.offsetWidth < 44 || btn.offsetHeight < 44) {
            btn.style.minWidth = '44px';
            btn.style.minHeight = '44px';
            btn.style.display = 'inline-flex';
            btn.style.alignItems = 'center';
            btn.style.justifyContent = 'center';
        }
    });
}

/**
 * Agregar gestos de swipe
 */
function addSwipeGestures(table) {
    if (window.innerWidth > 768) return;
    
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        let startX = 0;
        let startTime = 0;
        
        row.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            startTime = Date.now();
        });
        
        row.addEventListener('touchmove', function(e) {
            const currentX = e.touches[0].clientX;
            const diffX = startX - currentX;
            const diffTime = Date.now() - startTime;
            
            if (diffX > 50 && diffTime < 300) {
                showRowActions(row);
            }
        });
    });
}

/**
 * Mostrar acciones de fila en móvil
 */
function showRowActions(row) {
    const actionsCell = row.querySelector('td:last-child');
    if (!actionsCell) return;
    
    const overlay = document.createElement('div');
    overlay.className = 'row-actions-overlay';
    overlay.innerHTML = actionsCell.innerHTML;
    
    overlay.style.cssText = `
        position: fixed; bottom: 0; left: 0; right: 0;
        background: white; padding: 1rem;
        border-top: 1px solid #e5e7eb;
        box-shadow: 0 -4px 6px -1px rgb(0 0 0 / 0.1);
        z-index: 9999; display: flex; gap: 0.5rem; flex-wrap: wrap;
    `;
    
    const buttons = overlay.querySelectorAll('.btn');
    buttons.forEach(btn => {
        btn.style.flex = '1';
        btn.style.minHeight = '48px';
    });
    
    const closeBtn = document.createElement('button');
    closeBtn.className = 'btn btn-secondary';
    closeBtn.innerHTML = '<i class="fas fa-times"></i> Cerrar';
    closeBtn.style.flex = '1';
    closeBtn.style.minHeight = '48px';
    
    closeBtn.addEventListener('click', () => overlay.remove());
    overlay.appendChild(closeBtn);
    document.body.appendChild(overlay);
    
    setTimeout(() => {
        document.addEventListener('click', function closeOverlay(e) {
            if (!overlay.contains(e.target)) {
                overlay.remove();
                document.removeEventListener('click', closeOverlay);
            }
        });
    }, 100);
}

/**
 * Inicializar toggle de columnas
 */
function initColumnToggle() {
    // Implementación básica para toggle de columnas
    const toggleButtons = document.querySelectorAll('.column-toggle-btn');
    toggleButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Toggle básico de columnas menos importantes
            const table = this.closest('.card, .form-card')?.querySelector('.modern-table');
            if (table) {
                const nonEssentialColumns = table.querySelectorAll('th.d-none-mobile, td.d-none-mobile');
                nonEssentialColumns.forEach(col => {
                    col.classList.toggle('d-none');
                });
            }
        });
    });
}

/**
 * Vista de tarjetas para móviles muy pequeños
 */
function initMobileCards() {
    if (window.innerWidth > 576) return;
    
    const tables = document.querySelectorAll('.modern-table[data-mobile-cards="true"]');
    
    tables.forEach(table => {
        const container = table.closest('.table-responsive');
        if (!container) return;
        
        const cardsContainer = createMobileCards(table);
        container.parentNode.appendChild(cardsContainer);
        container.style.display = 'none';
    });
}

/**
 * Crear vista de tarjetas móviles
 */
function createMobileCards(table) {
    const container = document.createElement('div');
    container.className = 'mobile-cards d-block d-sm-none';
    
    const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const card = document.createElement('div');
        card.className = 'mobile-card';
        
        const cardHeader = document.createElement('div');
        cardHeader.className = 'mobile-card-header';
        
        const cardTitle = document.createElement('h6');
        cardTitle.className = 'mobile-card-title';
        cardTitle.textContent = row.children[0]?.textContent.trim() || 'Elemento';
        
        cardHeader.appendChild(cardTitle);
        card.appendChild(cardHeader);
        
        const cardBody = document.createElement('div');
        cardBody.className = 'mobile-card-body';
        
        Array.from(row.children).forEach((cell, index) => {
            if (index === 0 || !headers[index]) return;
            
            const field = document.createElement('div');
            field.className = 'mobile-card-field';
            
            const label = document.createElement('div');
            label.className = 'mobile-card-label';
            label.textContent = headers[index];
            
            const value = document.createElement('div');
            value.className = 'mobile-card-value';
            value.innerHTML = cell.innerHTML;
            
            field.appendChild(label);
            field.appendChild(value);
            cardBody.appendChild(field);
        });
        
        card.appendChild(cardBody);
        
        // Agregar acciones
        const actionsCell = row.querySelector('td:last-child');
        if (actionsCell?.innerHTML.trim()) {
            const cardActions = document.createElement('div');
            cardActions.className = 'mobile-card-actions';
            cardActions.innerHTML = actionsCell.innerHTML;
            card.appendChild(cardActions);
        }
        
        container.appendChild(card);
    });
    
    return container;
}

// Reinicializar en resize
window.addEventListener('resize', function() {
    const isMobile = window.innerWidth <= 576;
    
    document.querySelectorAll('.mobile-cards').forEach(cards => {
        cards.style.display = isMobile ? 'block' : 'none';
    });
    
    document.querySelectorAll('.table-responsive').forEach(container => {
        if (container.parentNode.querySelector('.mobile-cards')) {
            container.style.display = isMobile ? 'none' : 'block';
        }
    });
});