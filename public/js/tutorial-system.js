/**
 * Sistema de Tutoriales Interactivos
 * Sistema de Gestión HDC
 * 
 * Permite crear tutoriales paso a paso para cada módulo del sistema
 */

class TutorialSystem {
    constructor() {
        this.currentStep = 0;
        this.tutorialData = null;
        this.isActive = false;
        this.overlay = null;
        this.tooltip = null;
        this.init();
    }

    init() {
        this.createOverlay();
        this.createTooltip();
        this.bindEvents();
    }

    /**
     * Crear overlay de fondo
     */
    createOverlay() {
        this.overlay = document.createElement('div');
        this.overlay.className = 'tutorial-overlay';
        this.overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(2px);
        `;
        document.body.appendChild(this.overlay);
    }

    /**
     * Crear tooltip del tutorial
     */
    createTooltip() {
        this.tooltip = document.createElement('div');
        this.tooltip.className = 'tutorial-tooltip';
        this.tooltip.style.cssText = `
            position: fixed;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transform: scale(0.8);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            max-width: 400px;
            min-width: 300px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        `;
        document.body.appendChild(this.tooltip);
    }

    /**
     * Vincular eventos
     */
    bindEvents() {
        // Cerrar tutorial con ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isActive) {
                this.close();
            }
        });

        // Cerrar tutorial al hacer clic en el overlay
        this.overlay.addEventListener('click', () => {
            this.close();
        });
    }

    /**
     * Iniciar tutorial
     */
    start(tutorialData) {
        this.tutorialData = tutorialData;
        this.currentStep = 0;
        this.isActive = true;
        
        // Mostrar overlay
        this.overlay.style.opacity = '1';
        this.overlay.style.visibility = 'visible';
        
        // Mostrar primer paso
        this.showStep(0);
        
        // Bloquear scroll
        document.body.style.overflow = 'hidden';
    }

    /**
     * Mostrar paso específico
     */
    showStep(stepIndex) {
        if (!this.tutorialData || !this.tutorialData.steps[stepIndex]) {
            this.close();
            return;
        }

        const step = this.tutorialData.steps[stepIndex];
        const targetElement = document.querySelector(step.target);

        if (!targetElement) {
            console.warn(`Elemento no encontrado: ${step.target}`);
            this.nextStep();
            return;
        }

        // Destacar elemento
        this.highlightElement(targetElement);
        
        // Posicionar tooltip
        this.positionTooltip(targetElement, step);
        
        // Actualizar contenido del tooltip
        this.updateTooltipContent(step, stepIndex);
        
        // Mostrar tooltip
        this.tooltip.style.opacity = '1';
        this.tooltip.style.visibility = 'visible';
        this.tooltip.style.transform = 'scale(1)';
    }

    /**
     * Destacar elemento con efecto spotlight
     */
    highlightElement(element) {
        // Remover highlight anterior
        document.querySelectorAll('.tutorial-highlight').forEach(el => {
            el.classList.remove('tutorial-highlight');
        });

        // Agregar highlight al elemento actual
        element.classList.add('tutorial-highlight');
        
        // Crear efecto spotlight dinámico
        this.createSpotlight(element);
        
        // Agregar indicador visual adicional
        this.addVisualIndicator(element);
        
        // Scroll al elemento si es necesario
        element.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'center',
            inline: 'center'
        });
        
        // Agregar efecto de zoom suave
        setTimeout(() => {
            element.style.transition = 'transform 0.3s ease';
        }, 100);
    }

    /**
     * Crear efecto spotlight dinámico
     */
    createSpotlight(element) {
        const rect = element.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        
        // Convertir a porcentajes para el CSS
        const xPercent = (centerX / window.innerWidth) * 100;
        const yPercent = (centerY / window.innerHeight) * 100;
        
        // Actualizar variables CSS para el spotlight
        this.overlay.style.setProperty('--spotlight-x', xPercent + '%');
        this.overlay.style.setProperty('--spotlight-y', yPercent + '%');
        
        // Ajustar el tamaño del spotlight según el elemento
        const size = Math.max(rect.width, rect.height);
        const spotlightSize = Math.max(200, size * 1.5);
        
        // Actualizar el gradiente con el nuevo tamaño
        const gradient = `
            radial-gradient(circle at ${xPercent}% ${yPercent}%, 
                transparent 0px, 
                transparent ${spotlightSize/2}px, 
                rgba(0, 0, 0, 0.4) ${spotlightSize}px, 
                rgba(0, 0, 0, 0.8) 100%)
        `;
        
        this.overlay.style.background = gradient;
    }

    /**
     * Agregar indicador visual adicional
     */
    addVisualIndicator(element) {
        // Remover indicadores anteriores
        document.querySelectorAll('.tutorial-indicator').forEach(indicator => {
            indicator.remove();
        });

        // Crear indicador visual
        const indicator = document.createElement('div');
        indicator.className = 'tutorial-indicator';
        indicator.innerHTML = `
            <div class="tutorial-indicator-content">
                <i class="fas fa-hand-point-up"></i>
                <span>¡Mira aquí!</span>
            </div>
        `;
        
        // Posicionar el indicador
        const rect = element.getBoundingClientRect();
        indicator.style.cssText = `
            position: fixed;
            top: ${rect.top - 60}px;
            left: ${rect.left}px;
            z-index: 10000;
            pointer-events: none;
            animation: tutorial-indicator-bounce 1s infinite;
        `;
        
        document.body.appendChild(indicator);
        
        // Remover después de 3 segundos
        setTimeout(() => {
            if (indicator.parentNode) {
                indicator.remove();
            }
        }, 3000);
    }

    /**
     * Posicionar tooltip con mejor visibilidad
     */
    positionTooltip(targetElement, step) {
        const rect = targetElement.getBoundingClientRect();
        const padding = 30;
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight;
        
        // Calcular el centro del elemento
        const elementCenterX = rect.left + rect.width / 2;
        const elementCenterY = rect.top + rect.height / 2;
        
        // Dimensiones del tooltip (estimadas)
        const tooltipWidth = 400;
        const tooltipHeight = 300;
        
        let top, left, arrowClass;
        
        // Estrategia de posicionamiento mejorada
        const spaceAbove = rect.top;
        const spaceBelow = viewportHeight - rect.bottom;
        const spaceLeft = rect.left;
        const spaceRight = viewportWidth - rect.right;
        
        // Determinar la mejor posición
        if (spaceBelow > tooltipHeight + padding) {
            // Posición abajo
            top = rect.bottom + padding;
            left = Math.max(padding, Math.min(elementCenterX - tooltipWidth / 2, viewportWidth - tooltipWidth - padding));
            arrowClass = 'tutorial-arrow-top';
        } else if (spaceAbove > tooltipHeight + padding) {
            // Posición arriba
            top = rect.top - tooltipHeight - padding;
            left = Math.max(padding, Math.min(elementCenterX - tooltipWidth / 2, viewportWidth - tooltipWidth - padding));
            arrowClass = 'tutorial-arrow-bottom';
        } else {
            // Posición al lado (derecha o izquierda)
            if (spaceRight > tooltipWidth + padding) {
                // Lado derecho
                left = rect.right + padding;
                top = Math.max(padding, Math.min(elementCenterY - tooltipHeight / 2, viewportHeight - tooltipHeight - padding));
                arrowClass = 'tutorial-arrow-left';
            } else {
                // Lado izquierdo
                left = rect.left - tooltipWidth - padding;
                top = Math.max(padding, Math.min(elementCenterY - tooltipHeight / 2, viewportHeight - tooltipHeight - padding));
                arrowClass = 'tutorial-arrow-right';
            }
        }
        
        // Asegurar que esté dentro de la ventana
        left = Math.max(padding, Math.min(left, viewportWidth - tooltipWidth - padding));
        top = Math.max(padding, Math.min(top, viewportHeight - tooltipHeight - padding));
        
        // Aplicar posición con animación
        this.tooltip.style.top = `${top}px`;
        this.tooltip.style.left = `${left}px`;
        this.tooltip.className = `tutorial-tooltip ${arrowClass}`;
        
        // Agregar clase para animación de entrada
        this.tooltip.classList.add('tutorial-tooltip-entering');
        setTimeout(() => {
            this.tooltip.classList.remove('tutorial-tooltip-entering');
        }, 300);
    }

    /**
     * Actualizar contenido del tooltip con funcionalidad interactiva
     */
    updateTooltipContent(step, stepIndex) {
        const totalSteps = this.tutorialData.steps.length;
        const progress = ((stepIndex + 1) / totalSteps) * 100;
        const estimatedTime = this.tutorialData.estimatedTime || '5 minutos';
        const difficulty = this.tutorialData.difficulty || 'Fácil';

        this.tooltip.innerHTML = `
            <div class="tutorial-header">
                <div class="tutorial-title">
                    <i class="fas fa-${step.icon || 'info-circle'}"></i>
                    ${step.title}
                </div>
                <div class="tutorial-meta">
                    <span class="tutorial-time">
                        <i class="fas fa-clock"></i> ${estimatedTime}
                    </span>
                    <span class="tutorial-difficulty">
                        <i class="fas fa-signal"></i> ${difficulty}
                    </span>
                </div>
                <div class="tutorial-progress">
                    <span class="tutorial-step-counter">${stepIndex + 1} de ${totalSteps}</span>
                    <div class="tutorial-progress-bar">
                        <div class="tutorial-progress-fill" style="width: ${progress}%"></div>
                    </div>
                </div>
            </div>
            <div class="tutorial-content">
                ${step.content}
            </div>
            <div class="tutorial-actions">
                <button class="tutorial-btn tutorial-btn-skip" onclick="tutorialSystem.skip()" title="Saltar tutorial completo">
                    <i class="fas fa-times"></i> Saltar
                </button>
                ${stepIndex > 0 ? `
                    <button class="tutorial-btn tutorial-btn-prev" onclick="tutorialSystem.prevStep()" title="Paso anterior">
                        <i class="fas fa-chevron-left"></i> Anterior
                    </button>
                ` : ''}
                <button class="tutorial-btn tutorial-btn-next" onclick="tutorialSystem.nextStep()" title="${stepIndex === totalSteps - 1 ? 'Completar tutorial' : 'Siguiente paso'}">
                    ${stepIndex === totalSteps - 1 ? '<i class="fas fa-check"></i> Finalizar' : '<i class="fas fa-chevron-right"></i> Siguiente'}
                </button>
            </div>
        `;
        
        // Agregar funcionalidad interactiva a botones dentro del contenido
        this.addInteractiveFeatures(stepIndex);
    }

    /**
     * Agregar características interactivas al contenido del tutorial
     */
    addInteractiveFeatures(stepIndex) {
        const content = this.tooltip.querySelector('.tutorial-content');
        
        // Hacer que los botones demo sean funcionales
        const demoButtons = content.querySelectorAll('.demo-btn, .alert-actions .btn, .completion-actions .btn');
        demoButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                // Efecto visual al hacer clic
                button.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    button.style.transform = '';
                }, 150);
                
                // Mostrar mensaje informativo
                this.showInteractiveMessage(button.textContent.trim());
            });
        });
        
        // Agregar efectos hover a elementos interactivos
        const interactiveElements = content.querySelectorAll('.nav-module, .step-card, .action-demo-item');
        interactiveElements.forEach(element => {
            element.style.cursor = 'pointer';
            element.style.transition = 'transform 0.2s ease';
            
            element.addEventListener('mouseenter', () => {
                element.style.transform = 'translateY(-2px)';
            });
            
            element.addEventListener('mouseleave', () => {
                element.style.transform = '';
            });
        });
    }

    /**
     * Mostrar mensaje interactivo
     */
    showInteractiveMessage(message) {
        if (window.mobileUtils) {
            window.mobileUtils.showNotification(`Demo: ${message}`, 'info', 2000);
        }
    }

    /**
     * Siguiente paso
     */
    nextStep() {
        if (this.currentStep < this.tutorialData.steps.length - 1) {
            this.currentStep++;
            this.showStep(this.currentStep);
        } else {
            this.complete();
        }
    }

    /**
     * Paso anterior
     */
    prevStep() {
        if (this.currentStep > 0) {
            this.currentStep--;
            this.showStep(this.currentStep);
        }
    }

    /**
     * Saltar tutorial
     */
    skip() {
        this.close();
    }

    /**
     * Completar tutorial
     */
    complete() {
        // Marcar como completado en localStorage
        if (this.tutorialData.id) {
            localStorage.setItem(`tutorial_completed_${this.tutorialData.id}`, 'true');
        }
        
        this.close();
        
        // Mostrar mensaje de completado
        if (window.mobileUtils) {
            window.mobileUtils.showNotification('¡Tutorial completado! 🎉', 'success', 3000);
        }
    }

    /**
     * Cerrar tutorial
     */
    close() {
        this.isActive = false;
        
        // Ocultar overlay
        this.overlay.style.opacity = '0';
        this.overlay.style.visibility = 'hidden';
        
        // Ocultar tooltip
        this.tooltip.style.opacity = '0';
        this.tooltip.style.visibility = 'hidden';
        this.tooltip.style.transform = 'scale(0.8)';
        
        // Remover highlights
        document.querySelectorAll('.tutorial-highlight').forEach(el => {
            el.classList.remove('tutorial-highlight');
        });
        
        // Remover indicadores visuales
        document.querySelectorAll('.tutorial-indicator').forEach(indicator => {
            indicator.remove();
        });
        
        // Restaurar overlay background
        this.overlay.style.background = 'rgba(0, 0, 0, 0.8)';
        
        // Restaurar scroll
        document.body.style.overflow = '';
    }

    /**
     * Verificar si tutorial fue completado
     */
    isCompleted(tutorialId) {
        return localStorage.getItem(`tutorial_completed_${tutorialId}`) === 'true';
    }

    /**
     * Resetear tutorial completado
     */
    resetCompleted(tutorialId) {
        localStorage.removeItem(`tutorial_completed_${tutorialId}`);
    }
}

// Datos del tutorial del Dashboard mejorado
const dashboardTutorial = {
    id: 'dashboard',
    title: 'Tutorial Completo del Dashboard',
    description: 'Guía completa para dominar el dashboard del sistema HDC',
    estimatedTime: '5 minutos',
    difficulty: 'Fácil',
    steps: [
        {
            target: '.dashboard-title',
            title: '🏠 Centro de Control Principal',
            icon: 'tachometer-alt',
            content: `
                <div class="tutorial-welcome">
                    <h4>¡Bienvenido al Sistema HDC! 👋</h4>
                    <p>Este es tu <strong>centro de control principal</strong> donde tienes acceso a toda la información importante del sistema.</p>
                    
                    <div class="tutorial-highlights">
                        <div class="highlight-item">
                            <i class="fas fa-chart-line text-primary"></i>
                            <span><strong>Estadísticas en tiempo real</strong></span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-tasks text-success"></i>
                            <span><strong>Gestión de equipos y reparaciones</strong></span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-users text-info"></i>
                            <span><strong>Control de clientes y técnicos</strong></span>
                        </div>
                    </div>
                    
                    <div class="tutorial-tip">
                        <i class="fas fa-lightbulb"></i>
                        <strong>Tip:</strong> El dashboard se actualiza automáticamente con la información más reciente del sistema.
                    </div>
                </div>
            `
        },
        {
            target: '#current-time',
            title: '⏰ Información en Tiempo Real',
            icon: 'clock',
            content: `
                <div class="tutorial-info-section">
                    <h5>Información del Sistema en Vivo</h5>
                    <p>Aquí tienes acceso a información crítica que se actualiza constantemente:</p>
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <i class="fas fa-clock text-info"></i>
                            <div>
                                <strong>Reloj en Tiempo Real</strong>
                                <small>Hora actual del sistema que se actualiza cada segundo</small>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-user text-primary"></i>
                            <div>
                                <strong>Sesión Activa</strong>
                                <small>Tu usuario actualmente conectado al sistema</small>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar text-success"></i>
                            <div>
                                <strong>Fecha del Sistema</strong>
                                <small>Fecha actual para referencia en reportes</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tutorial-tip">
                        <i class="fas fa-info-circle"></i>
                        <strong>Importante:</strong> La hora del sistema está sincronizada con la zona horaria de Guatemala (UTC-6).
                    </div>
                </div>
            `
        },
        {
            target: '.action-buttons',
            title: '🚀 Acciones Rápidas',
            icon: 'rocket',
            content: `
                <div class="tutorial-actions-section">
                    <h5>Accesos Directos para Mayor Eficiencia</h5>
                    <p>Estos botones te permiten realizar las acciones más comunes sin navegar por menús:</p>
                    
                    <div class="action-buttons-demo">
                        <div class="action-demo-item">
                            <button class="btn btn-primary demo-btn">
                                <i class="fas fa-wrench"></i> Reparaciones
                            </button>
                            <div class="action-explanation">
                                <strong>Ir a Reparaciones</strong>
                                <p>Acceso directo al módulo principal de gestión de reparaciones. Aquí podrás ver, crear y gestionar todas las reparaciones del sistema.</p>
                                <small>💡 <strong>Uso:</strong> Ideal cuando necesitas revisar el estado de equipos en reparación.</small>
                            </div>
                        </div>
                        
                        <div class="action-demo-item">
                            <button class="btn btn-success demo-btn">
                                <i class="fas fa-plus"></i> Nuevo
                            </button>
                            <div class="action-explanation">
                                <strong>Crear Nuevo Equipo</strong>
                                <p>Inicia rápidamente el proceso de registro de un nuevo equipo en el sistema.</p>
                                <small>💡 <strong>Uso:</strong> Perfecto para cuando llega un equipo nuevo al taller.</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tutorial-tip">
                        <i class="fas fa-mouse-pointer"></i>
                        <strong>Pro Tip:</strong> Estos botones cambian según el módulo en el que te encuentres para mostrar las acciones más relevantes.
                    </div>
                </div>
            `
        },
        {
            target: '.stat-card-primary',
            title: '📊 Estadísticas de Equipos',
            icon: 'laptop',
            content: `
                <div class="tutorial-stats-section">
                    <h5>Panel de Control de Equipos</h5>
                    <p>Esta tarjeta te proporciona una vista completa del estado de todos los equipos en el sistema:</p>
                    
                    <div class="stats-explanation">
                        <div class="stat-item-explanation">
                            <div class="stat-number-demo">21</div>
                            <div class="stat-details">
                                <strong>Total de Equipos</strong>
                                <p>Número total de equipos registrados en el sistema. Incluye todos los equipos, sin importar su estado actual.</p>
                                <small>📈 <strong>Monitoreo:</strong> Este número te ayuda a tener una visión general del inventario.</small>
                            </div>
                        </div>
                        
                        <div class="stat-item-explanation">
                            <div class="stat-number-demo">3</div>
                            <div class="stat-details">
                                <strong>En Reparación</strong>
                                <p>Equipos que están actualmente siendo reparados o en proceso de diagnóstico.</p>
                                <small>⚠️ <strong>Atención:</strong> Revisa estos equipos regularmente para mantener tiempos de entrega.</small>
                            </div>
                        </div>
                        
                        <div class="stat-item-explanation">
                            <div class="stat-number-demo">17</div>
                            <div class="stat-details">
                                <strong>Completadas</strong>
                                <p>Reparaciones exitosamente finalizadas y listas para entrega.</p>
                                <small>✅ <strong>Éxito:</strong> Muestra tu tasa de efectividad en las reparaciones.</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tutorial-tip">
                        <i class="fas fa-chart-pie"></i>
                        <strong>Insight:</strong> El porcentaje de éxito (89%) indica la calidad y eficiencia de tu servicio técnico.
                    </div>
                </div>
            `
        },
        {
            target: '.stat-card-warning',
            title: '🚨 Alertas Críticas',
            icon: 'exclamation-triangle',
            content: `
                <div class="tutorial-alerts-section">
                    <h5>Sistema de Alertas Inteligente</h5>
                    <p>Esta tarjeta es tu <strong>centro de alertas críticas</strong> que requiere atención inmediata:</p>
                    
                    <div class="alert-types">
                        <div class="alert-item critical">
                            <i class="fas fa-exclamation-triangle text-danger"></i>
                            <div>
                                <strong>Reparaciones Vencidas</strong>
                                <p>Equipos que han superado la fecha de entrega prometida al cliente.</p>
                                <small>🔴 <strong>Prioridad Alta:</strong> Contacta al cliente inmediatamente.</small>
                            </div>
                        </div>
                        
                        <div class="alert-item warning">
                            <i class="fas fa-clock text-warning"></i>
                            <div>
                                <strong>Próximas a Vencer</strong>
                                <p>Reparaciones que están cerca de su fecha límite de entrega.</p>
                                <small>🟡 <strong>Prevención:</strong> Acelera el proceso para evitar retrasos.</small>
                            </div>
                        </div>
                        
                        <div class="alert-item info">
                            <i class="fas fa-user-clock text-info"></i>
                            <div>
                                <strong>Cliente Esperando</strong>
                                <p>Clientes que están esperando actualización sobre el estado de su equipo.</p>
                                <small>🔵 <strong>Comunicación:</strong> Mantén informados a tus clientes.</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tutorial-tip">
                        <i class="fas fa-bell"></i>
                        <strong>Estrategia:</strong> Revisa estas alertas al inicio de cada día para priorizar tu trabajo y mantener clientes satisfechos.
                    </div>
                    
                    <div class="alert-actions">
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-list"></i> Ver Todas las Alertas
                        </button>
                        <button class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-phone"></i> Contactar Clientes
                        </button>
                    </div>
                </div>
            `
        },
        {
            target: '.modern-card:first-of-type',
            title: '📋 Equipos Recientes',
            icon: 'history',
            content: `
                <div class="tutorial-recent-section">
                    <h5>Historial de Actividad Reciente</h5>
                    <p>Esta sección te muestra las <strong>últimas reparaciones</strong> registradas en el sistema:</p>
                    
                    <div class="recent-items-explanation">
                        <div class="recent-item-demo">
                            <div class="recent-item-header">
                                <i class="fas fa-laptop text-primary"></i>
                                <div class="recent-item-info">
                                    <strong>Laptop Dell Inspiron 15</strong>
                                    <small>Cliente: Juan Pérez</small>
                                </div>
                                <span class="badge bg-warning">En Proceso</span>
                            </div>
                            <div class="recent-item-details">
                                <small>📅 Creado: 28 Sep 2025</small>
                                <small>👨‍🔧 Técnico: Carlos López</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="recent-features">
                        <h6>Información Disponible:</h6>
                        <div class="feature-grid">
                            <div class="feature-item">
                                <i class="fas fa-info-circle text-info"></i>
                                <span><strong>Detalles del Equipo:</strong> Marca, modelo, problema reportado</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-user text-primary"></i>
                                <span><strong>Cliente:</strong> Nombre y información de contacto</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-cogs text-warning"></i>
                                <span><strong>Estado Actual:</strong> En proceso, completado, entregado</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-clock text-success"></i>
                                <span><strong>Fechas:</strong> Creación, estimada de entrega</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tutorial-tip">
                        <i class="fas fa-mouse-pointer"></i>
                        <strong>Interacción:</strong> Haz clic en cualquier reparación para ver todos los detalles, historial y actualizar el estado.
                    </div>
                </div>
            `
        },
        {
            target: '.chart-card:first-of-type',
            title: '📈 Gráfico de Reparaciones',
            icon: 'chart-line',
            content: `
                <div class="tutorial-chart-section">
                    <h5>Análisis Visual de Reparaciones</h5>
                    <p>Este gráfico te muestra la <strong>tendencia de reparaciones por mes</strong> para ayudarte a:</p>
                    
                    <div class="chart-benefits">
                        <div class="benefit-item">
                            <i class="fas fa-chart-line text-primary"></i>
                            <div>
                                <strong>Identificar Patrones</strong>
                                <small>Ver qué meses son más ocupados para planificar recursos</small>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <i class="fas fa-trending-up text-success"></i>
                            <div>
                                <strong>Medir Crecimiento</strong>
                                <small>Evaluar el crecimiento de tu negocio mes a mes</small>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <i class="fas fa-calendar-alt text-info"></i>
                            <div>
                                <strong>Planificar Capacidad</strong>
                                <small>Preparar tu equipo para períodos de alta demanda</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tutorial-tip">
                        <i class="fas fa-eye"></i>
                        <strong>Observación:</strong> Los picos en el gráfico indican períodos de alta demanda que puedes usar para ajustar tu estrategia.
                    </div>
                </div>
            `
        },
        {
            target: '.sidebar-item:first-child',
            title: '🧭 Navegación del Sistema',
            icon: 'compass',
            content: `
                <div class="tutorial-navigation-section">
                    <h5>Centro de Navegación Principal</h5>
                    <p>El <strong>menú lateral</strong> es tu punto de acceso a todos los módulos del sistema:</p>
                    
                    <div class="navigation-modules">
                        <div class="nav-module active">
                            <i class="fas fa-tachometer-alt text-success"></i>
                            <div>
                                <strong>Dashboard</strong>
                                <small>Vista general del sistema (actual)</small>
                            </div>
                        </div>
                        
                        <div class="nav-module">
                            <i class="fas fa-users text-primary"></i>
                            <div>
                                <strong>Clientes</strong>
                                <small>Gestión de base de datos de clientes</small>
                            </div>
                        </div>
                        
                        <div class="nav-module">
                            <i class="fas fa-laptop text-info"></i>
                            <div>
                                <strong>Equipos</strong>
                                <small>Inventario y registro de equipos</small>
                            </div>
                        </div>
                        
                        <div class="nav-module">
                            <i class="fas fa-wrench text-warning"></i>
                            <div>
                                <strong>Reparaciones</strong>
                                <small>Gestión completa de servicios técnicos</small>
                            </div>
                        </div>
                        
                        <div class="nav-module">
                            <i class="fas fa-user-cog text-secondary"></i>
                            <div>
                                <strong>Técnicos</strong>
                                <small>Administración del personal técnico</small>
                            </div>
                        </div>
                        
                        <div class="nav-module">
                            <i class="fas fa-boxes text-success"></i>
                            <div>
                                <strong>Inventario</strong>
                                <small>Control de stock y repuestos</small>
                            </div>
                        </div>
                        
                        <div class="nav-module">
                            <i class="fas fa-chart-bar text-danger"></i>
                            <div>
                                <strong>Reportes</strong>
                                <small>Análisis y estadísticas avanzadas</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tutorial-tip">
                        <i class="fas fa-keyboard"></i>
                        <strong>Atajos:</strong> Usa Ctrl + número para acceder rápidamente a cada módulo (Ctrl+1 = Dashboard, Ctrl+2 = Clientes, etc.).
                    </div>
                </div>
            `
        },
        {
            target: '.tutorial-btn',
            title: '🎓 ¡Tutorial Completado!',
            icon: 'graduation-cap',
            content: `
                <div class="tutorial-completion-section">
                    <div class="completion-celebration">
                        <h4>¡Felicidades! 🎉</h4>
                        <p>Has completado exitosamente el <strong>Tutorial del Dashboard HDC</strong></p>
                    </div>
                    
                    <div class="completion-summary">
                        <h5>Lo que has aprendido:</h5>
                        <div class="learned-items">
                            <div class="learned-item">
                                <i class="fas fa-check-circle text-success"></i>
                                <span>Navegar por el dashboard principal</span>
                            </div>
                            <div class="learned-item">
                                <i class="fas fa-check-circle text-success"></i>
                                <span>Interpretar estadísticas en tiempo real</span>
                            </div>
                            <div class="learned-item">
                                <i class="fas fa-check-circle text-success"></i>
                                <span>Usar acciones rápidas eficientemente</span>
                            </div>
                            <div class="learned-item">
                                <i class="fas fa-check-circle text-success"></i>
                                <span>Gestionar alertas críticas</span>
                            </div>
                            <div class="learned-item">
                                <i class="fas fa-check-circle text-success"></i>
                                <span>Acceder a todos los módulos del sistema</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="next-steps">
                        <h5>Próximos pasos recomendados:</h5>
                        <div class="step-cards">
                            <div class="step-card">
                                <i class="fas fa-users text-primary"></i>
                                <strong>Explorar Clientes</strong>
                                <p>Aprende a gestionar tu base de datos de clientes</p>
                            </div>
                            <div class="step-card">
                                <i class="fas fa-wrench text-warning"></i>
                                <strong>Gestionar Reparaciones</strong>
                                <p>Domina el flujo completo de reparaciones</p>
                            </div>
                            <div class="step-card">
                                <i class="fas fa-chart-bar text-info"></i>
                                <strong>Ver Reportes</strong>
                                <p>Analiza el rendimiento de tu negocio</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tutorial-tip final-tip">
                        <i class="fas fa-rocket"></i>
                        <strong>¡Estás listo!</strong> Ahora puedes usar el Sistema HDC con confianza. Recuerda que siempre puedes volver a este tutorial desde el botón de reinicio (solo administradores).
                    </div>
                    
                    <div class="completion-actions">
                        <button class="btn btn-success" onclick="window.location.href='{{ route('clientes.index') }}'">
                            <i class="fas fa-arrow-right"></i> Explorar Clientes
                        </button>
                        <button class="btn btn-primary" onclick="window.location.href='{{ route('reparaciones.index') }}'">
                            <i class="fas fa-wrench"></i> Ver Reparaciones
                        </button>
                    </div>
                </div>
            `
        }
    ]
};

// Inicializar sistema globalmente
window.tutorialSystem = new TutorialSystem();

// Función para iniciar tutorial del dashboard
window.startDashboardTutorial = () => {
    window.tutorialSystem.start(dashboardTutorial);
};

// Función para verificar si mostrar botón de tutorial
window.shouldShowTutorialButton = (tutorialId) => {
    return !window.tutorialSystem.isCompleted(tutorialId);
};
