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

// Función universal para mostrar confirmación de eliminación
function showDeleteConfirmation(itemId, itemNombre, itemTipo, deleteUrl) {
    console.log('Mostrando confirmación de eliminación:', { itemId, itemNombre, itemTipo, deleteUrl });
    
    // Confirmación doble para mayor seguridad
    if (confirm(`¿Está seguro de que desea eliminar este ${itemTipo.toLowerCase()}?\n\n${itemTipo}: ${itemNombre}\n\nEsta acción no se puede deshacer.`)) {
        if (confirm(`Confirme nuevamente: ¿Realmente desea eliminar "${itemNombre}"?\n\nEsta acción eliminará permanentemente toda la información relacionada.`)) {
            console.log('Confirmación doble aceptada, procediendo con eliminación...');
            eliminarItem(deleteUrl);
        } else {
            console.log('Segunda confirmación cancelada');
        }
    } else {
        console.log('Primera confirmación cancelada');
    }
}

// Función para cambiar estado de usuario (activar/desactivar)
function toggleStatus(userId, newStatus) {
    console.log('Cambiando estado del usuario:', { userId, newStatus });
    
    // Obtener token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('Token CSRF no encontrado');
        alert('Error: Token de seguridad no encontrado. Recarga la página e intenta nuevamente.');
        return;
    }
    
    // Hacer petición AJAX
    fetch(`/usuarios/${userId}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ activo: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarNotificacion(data.message, 'success');
            
            // Actualizar el botón y el badge
            const button = document.getElementById(`toggle-btn-${userId}`);
            const badge = document.querySelector(`[data-user-id="${userId}"] .badge`);
            
            if (button && badge) {
                if (data.estado) {
                    // Usuario activado
                    button.className = 'btn btn-outline-danger';
                    button.onclick = () => toggleStatus(userId, false);
                    button.title = 'Desactivar';
                    button.innerHTML = '<i class="fas fa-user-times"></i>';
                    
                    badge.className = 'badge bg-success';
                    badge.textContent = 'Activo';
                } else {
                    // Usuario desactivado
                    button.className = 'btn btn-outline-success';
                    button.onclick = () => toggleStatus(userId, true);
                    button.title = 'Activar';
                    button.innerHTML = '<i class="fas fa-user-check"></i>';
                    
                    badge.className = 'badge bg-danger';
                    badge.textContent = 'Inactivo';
                }
            }
        } else {
            mostrarNotificacion(data.message, 'danger');
        }
    })
    .catch(error => {
        console.error('Error al cambiar estado:', error);
        mostrarNotificacion('Error al cambiar el estado del usuario', 'danger');
    });
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
