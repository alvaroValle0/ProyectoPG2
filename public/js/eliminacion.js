// Funcionalidad para eliminación de elementos del sistema
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando sistema de eliminación...');
    
    // Manejar eliminación de equipos
    document.querySelectorAll('.btn-eliminar-equipo').forEach(button => {
        console.log('Botón de eliminar equipo encontrado:', button);
        
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Botón de eliminar equipo clickeado');
            
            const equipoId = this.getAttribute('data-equipo-id');
            const equipoNombre = this.getAttribute('data-equipo-nombre');
            const equipoSerie = this.getAttribute('data-equipo-serie');
            
            console.log('Datos del equipo:', { equipoId, equipoNombre, equipoSerie });
            
            // Confirmación simple con confirm nativo
            if (confirm(`¿Está seguro de eliminar el equipo?\n\nEquipo: ${equipoNombre}\nSerie: ${equipoSerie}\n\nEsta acción no se puede deshacer.`)) {
                console.log('Confirmación aceptada, eliminando equipo...');
                eliminarEquipo(equipoId);
            } else {
                console.log('Eliminación cancelada por el usuario');
            }
        });
    });

    // Manejar eliminación de usuarios
    document.querySelectorAll('.btn-eliminar-item').forEach(button => {
        console.log('Botón de eliminar item encontrado:', button);
        
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Botón de eliminar item clickeado');
            
            const itemId = this.getAttribute('data-item-id');
            const itemNombre = this.getAttribute('data-item-nombre');
            const itemTipo = this.getAttribute('data-item-tipo');
            const deleteUrl = this.getAttribute('data-delete-url');
            
            console.log('Datos del item:', { itemId, itemNombre, itemTipo, deleteUrl });
            
            // Confirmación simple con confirm nativo
            if (confirm(`¿Está seguro de eliminar el ${itemTipo}?\n\n${itemTipo.charAt(0).toUpperCase() + itemTipo.slice(1)}: ${itemNombre}\n\nEsta acción no se puede deshacer.`)) {
                console.log('Confirmación aceptada, eliminando item...');
                eliminarItem(deleteUrl);
            } else {
                console.log('Eliminación cancelada por el usuario');
            }
        });
    });
});

function eliminarEquipo(equipoId) {
    console.log('Iniciando eliminación del equipo ID:', equipoId);
    
    // Obtener token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('Token CSRF no encontrado');
        alert('Error: Token de seguridad no encontrado. Recarga la página e intenta nuevamente.');
        return;
    }
    
    // Crear formulario para enviar la solicitud DELETE
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/equipos/${equipoId}`;
    form.style.display = 'none';
    
    // Agregar token CSRF
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken.content;
    form.appendChild(csrfInput);
    
    // Agregar método DELETE
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';
    form.appendChild(methodInput);
    
    // Agregar formulario al DOM
    document.body.appendChild(form);
    
    console.log('Enviando formulario de eliminación...');
    
    // Enviar el formulario
    try {
        form.submit();
    } catch (error) {
        console.error('Error al enviar formulario:', error);
        alert('Error al eliminar el equipo. Intenta nuevamente.');
    }
}

function eliminarItem(deleteUrl) {
    console.log('Iniciando eliminación del item URL:', deleteUrl);
    
    // Obtener token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('Token CSRF no encontrado');
        alert('Error: Token de seguridad no encontrado. Recarga la página e intenta nuevamente.');
        return;
    }
    
    // Crear formulario para enviar la solicitud DELETE
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = deleteUrl;
    form.style.display = 'none';
    
    // Agregar token CSRF
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken.content;
    form.appendChild(csrfInput);
    
    // Agregar método DELETE
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';
    form.appendChild(methodInput);
    
    // Agregar formulario al DOM
    document.body.appendChild(form);
    
    console.log('Enviando formulario de eliminación...');
    
    // Enviar el formulario
    try {
        form.submit();
    } catch (error) {
        console.error('Error al enviar formulario:', error);
        alert('Error al eliminar el elemento. Intenta nuevamente.');
    }
}

// Función para mostrar notificaciones
function mostrarNotificacion(mensaje, tipo = 'success') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${tipo} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px;';
    
    const iconClass = tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    notification.innerHTML = `
        <i class="fas ${iconClass} me-2"></i>
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Remover automáticamente después de 5 segundos
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
