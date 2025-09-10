@extends('layouts.app')

@section('title', 'Nuevo Equipo')

@section('styles')
<style>

.neomorphic-header {
    background: var(--secondary-bg);
    border-radius: var(--border-radius);
    padding: 3rem 2rem;
    margin-bottom: 2rem;
    box-shadow: 
        8px 8px 16px var(--shadow-dark),
        -8px -8px 16px var(--shadow-light);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.neomorphic-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
    border-radius: var(--border-radius) var(--border-radius) 0 0;
}

.header-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 2rem;
    border-radius: 50%;
    background: var(--secondary-bg);
    box-shadow: 
        inset 4px 4px 8px var(--shadow-dark),
        inset -4px -4px 8px var(--shadow-light);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.header-icon::after {
    content: '';
    position: absolute;
    inset: 10px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--accent-color), #8b5cf6);
    display: flex;
    align-items: center;
    justify-content: center;
}

.header-icon i {
    font-size: 2.5rem;
    color: white;
    position: relative;
    z-index: 2;
}

.header-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, var(--accent-color), #8b5cf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.header-subtitle {
    font-size: 1.2rem;
    color: var(--text-secondary);
    font-weight: 500;
    margin-bottom: 0;
}

.neomorphic-progress {
    background: var(--secondary-bg);
    border-radius: var(--border-radius);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 
        8px 8px 16px var(--shadow-dark),
        -8px -8px 16px var(--shadow-light);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2rem;
}

.progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    color: var(--text-secondary);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.progress-step.active {
    color: var(--accent-color);
    transform: translateY(-4px);
}

.progress-step.completed {
    color: var(--success-color);
}

.step-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--secondary-bg);
    box-shadow: 
        inset 3px 3px 6px var(--shadow-dark),
        inset -3px -3px 6px var(--shadow-light);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.2rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.progress-step.active .step-circle {
    background: linear-gradient(135deg, var(--accent-color), #8b5cf6);
    color: white;
    box-shadow: 
        6px 6px 12px var(--shadow-dark),
        -6px -6px 12px var(--shadow-light);
    transform: scale(1.1);
}

.progress-step.completed .step-circle {
    background: linear-gradient(135deg, var(--success-color), #059669);
    color: white;
    box-shadow: 
        6px 6px 12px var(--shadow-dark),
        -6px -6px 12px var(--shadow-light);
}

.progress-step.completed .step-circle::before {
    content: '✓';
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 900;
}

.step-label {
    font-weight: 600;
    font-size: 0.9rem;
    text-align: center;
    white-space: nowrap;
}

.step-divider {
    flex: 1;
    height: 4px;
    background: var(--secondary-bg);
    border-radius: 2px;
    box-shadow: 
        inset 2px 2px 4px var(--shadow-dark),
        inset -2px -2px 4px var(--shadow-light);
    position: relative;
    overflow: hidden;
}

.step-divider.active::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, var(--accent-color), #8b5cf6);
    border-radius: 2px;
    animation: progressFill 0.6s ease-out;
}

@keyframes progressFill {
    from { transform: translateX(-100%); }
    to { transform: translateX(0); }
}

.neomorphic-section {
    background: var(--secondary-bg);
    border-radius: var(--border-radius);
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 
        8px 8px 16px var(--shadow-dark),
        -8px -8px 16px var(--shadow-light);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.neomorphic-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 6px;
    background: linear-gradient(90deg, var(--accent-color), #8b5cf6, #ec4899);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.neomorphic-section:hover::before {
    opacity: 1;
}

.neomorphic-section:hover {
    transform: translateY(-4px);
    box-shadow: 
        12px 12px 24px var(--shadow-dark),
        -12px -12px 24px var(--shadow-light);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 2.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid rgba(148, 163, 184, 0.1);
    position: relative;
}

.section-icon {
    width: 64px;
    height: 64px;
    background: var(--secondary-bg);
    border-radius: 16px;
    box-shadow: 
        inset 4px 4px 8px var(--shadow-dark),
        inset -4px -4px 8px var(--shadow-light);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.section-icon::after {
    content: '';
    position: absolute;
    inset: 8px;
    border-radius: 8px;
    background: linear-gradient(135deg, var(--accent-color), #8b5cf6);
    opacity: 0.9;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.section-icon:hover::after {
    opacity: 1;
    inset: 4px;
}

.section-icon i {
    font-size: 1.8rem;
    color: white;
    position: relative;
    z-index: 2;
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.section-icon:hover i {
    transform: scale(1.1);
}

.section-title {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
    background: linear-gradient(135deg, var(--text-primary), var(--accent-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.section-description {
    color: var(--text-secondary);
    font-size: 1rem;
    font-weight: 500;
    margin: 0;
    opacity: 0.8;
}

.neomorphic-input-group {
    position: relative;
    margin-bottom: 2rem;
}

.neomorphic-label {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
    padding-left: 0.5rem;
}

.neomorphic-label .required {
    color: var(--error-color);
    margin-left: 0.25rem;
}

.neomorphic-input {
    width: 100%;
    padding: 1.2rem 1.5rem 1.2rem 4rem;
    background: var(--secondary-bg);
    border: none;
    border-radius: 16px;
    box-shadow: 
        inset 4px 4px 8px var(--shadow-dark),
        inset -4px -4px 8px var(--shadow-light);
    font-size: 1rem;
    font-weight: 500;
    color: var(--text-primary);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.neomorphic-input:focus {
    outline: none;
    box-shadow: 
        inset 6px 6px 12px var(--shadow-dark),
        inset -6px -6px 12px var(--shadow-light),
        0 0 20px rgba(79, 70, 229, 0.15);
    transform: scale(1.02);
}

.neomorphic-input:valid:not(:placeholder-shown) {
    box-shadow: 
        inset 4px 4px 8px var(--shadow-dark),
        inset -4px -4px 8px var(--shadow-light),
        0 0 20px rgba(16, 185, 129, 0.15);
}

.neomorphic-input:invalid:not(:placeholder-shown) {
    box-shadow: 
        inset 4px 4px 8px var(--shadow-dark),
        inset -4px -4px 8px var(--shadow-light),
        0 0 20px rgba(239, 68, 68, 0.15);
}

.input-icon {
    position: absolute;
    top: 50%;
    left: 1.5rem;
    transform: translateY(-50%);
    color: var(--text-secondary);
    font-size: 1.2rem;
    z-index: 2;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    pointer-events: none;
}

.neomorphic-input-group:focus-within .input-icon {
    color: var(--accent-color);
    transform: translateY(-50%) scale(1.1);
}

.neomorphic-select {
    width: 100%;
    padding: 1.2rem 1.5rem 1.2rem 4rem;
    background: var(--secondary-bg);
    border: none;
    border-radius: 16px;
    box-shadow: 
        inset 4px 4px 8px var(--shadow-dark),
        inset -4px -4px 8px var(--shadow-light);
    font-size: 1rem;
    font-weight: 500;
    color: var(--text-primary);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    appearance: none;
    cursor: pointer;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%234f46e5' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 1.5rem center;
    background-repeat: no-repeat;
    background-size: 20px;
}

.neomorphic-select:focus {
    outline: none;
    box-shadow: 
        inset 6px 6px 12px var(--shadow-dark),
        inset -6px -6px 12px var(--shadow-light),
        0 0 20px rgba(79, 70, 229, 0.15);
    transform: scale(1.02);
}

.neomorphic-textarea {
    width: 100%;
    padding: 1.2rem 1.5rem 1.2rem 4rem;
    background: var(--secondary-bg);
    border: none;
    border-radius: 16px;
    box-shadow: 
        inset 4px 4px 8px var(--shadow-dark),
        inset -4px -4px 8px var(--shadow-light);
    font-size: 1rem;
    font-weight: 500;
    color: var(--text-primary);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    resize: vertical;
    min-height: 140px;
    font-family: inherit;
}

.neomorphic-textarea:focus {
    outline: none;
    box-shadow: 
        inset 6px 6px 12px var(--shadow-dark),
        inset -6px -6px 12px var(--shadow-light),
        0 0 20px rgba(79, 70, 229, 0.15);
    transform: scale(1.02);
}

.validation-message {
    display: block;
    margin-top: 0.75rem;
    font-size: 0.85rem;
    color: var(--error-color);
    font-weight: 500;
    opacity: 0;
    transform: translateY(-8px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    padding-left: 0.5rem;
}

.validation-message.show {
    opacity: 1;
    transform: translateY(0);
}

.success-message {
    color: var(--success-color);
}

.neomorphic-actions {
    background: var(--secondary-bg);
    border-radius: var(--border-radius);
    padding: 2.5rem;
    margin-top: 2rem;
    box-shadow: 
        8px 8px 16px var(--shadow-dark),
        -8px -8px 16px var(--shadow-light);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
}

.neomorphic-btn {
    padding: 1.2rem 2.5rem;
    border: none;
    border-radius: 16px;
    font-size: 1.1rem;
    font-weight: 700;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
    position: relative;
    cursor: pointer;
    background: var(--secondary-bg);
    color: var(--text-primary);
    box-shadow: 
        6px 6px 12px var(--shadow-dark),
        -6px -6px 12px var(--shadow-light);
    overflow: hidden;
}

.neomorphic-btn::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, var(--accent-color), #8b5cf6);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1;
}

.neomorphic-btn:hover::before {
    opacity: 1;
}

.neomorphic-btn:hover {
    transform: translateY(-2px);
    box-shadow: 
        8px 8px 16px var(--shadow-dark),
        -8px -8px 16px var(--shadow-light);
    color: white;
}

.neomorphic-btn:active {
    transform: translateY(0);
    box-shadow: 
        inset 4px 4px 8px var(--shadow-dark),
        inset -4px -4px 8px var(--shadow-light);
}

.neomorphic-btn span,
.neomorphic-btn i {
    position: relative;
    z-index: 2;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-secondary {
    background: var(--secondary-bg);
    color: var(--text-secondary);
}

.btn-secondary:hover {
    color: white;
}

.btn-secondary::before {
    background: linear-gradient(135deg, var(--text-secondary), #6b7280);
}

.neomorphic-summary {
    background: var(--secondary-bg);
    border-radius: var(--border-radius);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 
        inset 4px 4px 8px var(--shadow-dark),
        inset -4px -4px 8px var(--shadow-light);
    border-left: 6px solid var(--accent-color);
}

.summary-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.summary-title i {
    color: var(--accent-color);
    font-size: 1.5rem;
}

.character-counter {
    display: block;
    text-align: right;
    font-size: 0.8rem;
    color: var(--text-secondary);
    margin-top: 0.5rem;
    font-weight: 500;
}

.input-help {
    font-size: 0.85rem;
    color: var(--text-secondary);
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding-left: 0.5rem;
    font-weight: 500;
}

.input-help i {
    color: var(--accent-color);
    font-size: 0.9rem;
}

.theme-toggle {
    position: fixed;
    top: 2rem;
    right: 2rem;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--secondary-bg);
    box-shadow: 
        6px 6px 12px var(--shadow-dark),
        -6px -6px 12px var(--shadow-light);
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--accent-color);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1000;
}

.theme-toggle:hover {
    transform: scale(1.1);
    box-shadow: 
        8px 8px 16px var(--shadow-dark),
        -8px -8px 16px var(--shadow-light);
}

/* Dark Mode Support */
.dark-mode {
    --primary-bg: #1a202c;
    --secondary-bg: #2d3748;
    --accent-color: #667eea;
    --text-primary: #f7fafc;
    --text-secondary: #a0aec0;
    --shadow-light: rgba(255, 255, 255, 0.1);
    --shadow-dark: rgba(0, 0, 0, 0.5);
}

/* Form Container Centering */
.main-form-container {
    max-width: 960px;
    width: 100%;
    margin: 0 auto;
}

/* Eliminar pequeño borde/gutter lateral en esta vista */
.container-fluid.py-4 {
    padding-left: 0 !important;
    padding-right: 0 !important;
}

/* Evitar desalineación por márgenes negativos del .row */
.container-fluid.py-4 > .row {
    margin-left: 0 !important;
    margin-right: 0 !important;
}

.card {
    border-radius: 20px !important;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1) !important;
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white !important;
    padding: 2rem !important;
    border-radius: 20px 20px 0 0 !important;
    text-align: center;
}

.card-header h5 {
    color: white !important;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.card-header small {
    color: rgba(255,255,255,0.9) !important;
    font-size: 1rem;
}

.card-body {
    padding: 3rem 2.5rem !important;
}

.section-header {
    border-bottom: 2px solid #e5e7eb;
    padding-bottom: 1rem;
    margin-bottom: 2rem !important;
}

.section-header h6 {
    font-size: 1.2rem;
    font-weight: 700;
    margin: 0;
}

.section-header small {
    display: block;
    margin-top: 0.25rem;
    font-size: 0.9rem;
}

.btn-lg {
    padding: 0.75rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 12px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .main-form-container {
        max-width: 100%;
        padding: 0 1rem;
    }
}

@media (max-width: 768px) {
    .neomorphic-container {
        padding: 1rem;
    }
    
    .neomorphic-header {
        padding: 2rem 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .header-title {
        font-size: 2rem;
    }
    
    .header-subtitle {
        font-size: 1rem;
    }
    
    .neomorphic-progress {
        flex-direction: column;
        gap: 1.5rem;
        padding: 1.5rem;
    }
    
    .step-divider {
        width: 4px;
        height: 20px;
        flex: none;
    }
    
    .progress-step {
        width: 100%;
        flex-direction: row;
        justify-content: flex-start;
    }
    
    .step-circle {
        width: 50px;
        height: 50px;
        font-size: 1rem;
    }
    
    .neomorphic-section {
        padding: 1.5rem;
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
        text-align: left;
    }
    
    .section-icon {
        width: 56px;
        height: 56px;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .neomorphic-input,
    .neomorphic-select,
    .neomorphic-textarea {
        padding: 1rem 1.2rem 1rem 3.5rem;
    }
    
    .input-icon {
        left: 1.2rem;
        font-size: 1.1rem;
    }
    
    .neomorphic-actions {
        flex-direction: column;
        gap: 1rem;
        padding: 1.5rem;
    }
    
    .neomorphic-btn {
        width: 100%;
        justify-content: center;
        padding: 1rem 2rem;
        font-size: 1rem;
    }
    
    .theme-toggle {
        top: 1rem;
        right: 1rem;
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
}

@media (max-width: 480px) {
    .neomorphic-container::before {
        height: 200px;
    }
    
    .neomorphic-header {
        padding: 1.5rem 1rem;
    }
    
    .header-title {
        font-size: 1.75rem;
    }
    
    .header-icon {
        width: 80px;
        height: 80px;
    }
    
    .section-title {
        font-size: 1.3rem;
    }
    
    .neomorphic-input-group {
        margin-bottom: 1.5rem;
    }
}

/* Animaciones mejoradas */
@keyframes softSlideIn {
    from {
        opacity: 0;
        transform: translateY(40px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes pulseGlow {
    0%, 100% { box-shadow: 0 0 20px rgba(79, 70, 229, 0.1); }
    50% { box-shadow: 0 0 40px rgba(79, 70, 229, 0.2); }
}

.neomorphic-section {
    animation: softSlideIn 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    opacity: 0;
}

.neomorphic-section:nth-child(1) { animation-delay: 0.1s; }
.neomorphic-section:nth-child(2) { animation-delay: 0.2s; }
.neomorphic-section:nth-child(3) { animation-delay: 0.3s; }
.neomorphic-section:nth-child(4) { animation-delay: 0.4s; }

.neomorphic-input:focus {
    animation: pulseGlow 2s ease-in-out infinite;
}

/* Loading states */
.loading {
    pointer-events: none;
    opacity: 0.7;
}

.loading::after {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--secondary-bg);
    border-radius: inherit;
    opacity: 0.8;
    z-index: 10;
}

/* Success states */
.success-glow {
    box-shadow: 
        inset 4px 4px 8px var(--shadow-dark),
        inset -4px -4px 8px var(--shadow-light),
        0 0 30px rgba(16, 185, 129, 0.3) !important;
}

/* Error states */
.error-glow {
    box-shadow: 
        inset 4px 4px 8px var(--shadow-dark),
        inset -4px -4px 8px var(--shadow-light),
        0 0 30px rgba(239, 68, 68, 0.3) !important;
}

/* === Estilos del módulo Clientes aplicados para unificar forma y colores === */
/* Variables CSS */
:root {
    --primary-color: #4f46e5;
    --primary-light: #6366f1;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --info-color: #06b6d4;
    --dark-color: #1f2937;
    --light-color: #f8fafc;
    --border-color: #e5e7eb;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Form Header (minimal, coherente con Nueva Reparación) */
.form-header {
    background: white;
    color: var(--dark-color);
    padding: 1.25rem 1.5rem;
    border-radius: 15px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.form-title { font-size: 1.5rem; font-weight: 600; margin: 0; }

.form-subtitle { font-size: .95rem; color: #64748b; margin: .25rem 0 0 0; }

/* Header superior estilo banner (profesional) */
.hero-banner { background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%); color: #fff; border-radius: 16px; padding: 1.25rem 1.5rem; display:flex; justify-content: space-between; align-items:center; box-shadow: var(--shadow-lg); }
.hero-left { display:flex; align-items:center; gap: 1rem; }
.hero-icon { width: 52px; height: 52px; border-radius: 50%; background: rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; font-size: 1.25rem; }
.hero-title { margin: 0; font-size: 1.6rem; font-weight: 700; }
.hero-subtitle { margin: .25rem 0 0 0; font-size: .95rem; opacity: .9; }
.hero-actions { display:flex; gap:.75rem; }
.btn-hero { background: transparent; border: 1px solid rgba(255,255,255,.65); color: #fff; border-radius: 10px; padding:.55rem .9rem; display:flex; align-items:center; gap:.5rem; transition: all .2s ease; text-decoration: none; }
.btn-hero:hover { background: rgba(255,255,255,.15); border-color: #fff; }

@media (max-width: 768px) {
  .hero-banner { flex-direction: column; gap: .75rem; text-align: center; }
  .hero-actions { width: 100%; justify-content: center; }
}

/* Header superior minimalista */
.minimal-header { background: white; border: 1px solid var(--border-color); border-radius: 15px; padding: 1.25rem 1.5rem; display:flex; justify-content: space-between; align-items: center; box-shadow: var(--shadow-sm); }
.minimal-header .header-content { display:flex; align-items:center; gap:1rem; }
.minimal-header .header-icon { width: 48px; height: 48px; border-radius: 50%; background: var(--light-color); color: var(--primary-color); display:flex; align-items:center; justify-content:center; }
.minimal-header .header-title { margin: 0; font-size: 1.5rem; font-weight: 600; color: var(--dark-color); }
.minimal-header .header-subtitle { margin: .25rem 0 0 0; color: #64748b; font-size: .95rem; }
.minimal-header .header-actions { display:flex; gap:.75rem; }
.btn-minimal { background: white; border: 1px solid var(--border-color); color:#64748b; border-radius: 8px; padding:.6rem 1rem; display:flex; align-items:center; gap:.5rem; transition: all .2s ease; }
.btn-minimal:hover { background: var(--light-color); color: var(--primary-color); border-color: var(--primary-color); }

@media (max-width: 768px) { .minimal-header { flex-direction: column; gap: .75rem; text-align:center; } .minimal-header .header-actions { width:100%; justify-content:center; } }

.btn-modern {
    border-radius: 25px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-md);
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

/* Form Card */
.form-card {
    background: white;
    border-radius: 15px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.form-card-header {
    background: var(--light-color);
    padding: 2rem;
    border-bottom: 1px solid var(--border-color);
    text-align: center;
}

.form-card-header h5 {
    margin: 0 0 0.5rem 0;
    font-weight: 600;
    color: var(--dark-color);
    font-size: 1.25rem;
}

.form-card-body {
    padding: 2rem;
}

/* Form Sections */
.form-section {
    margin-bottom: 2.5rem;
    padding: 1.5rem;
    background: var(--light-color);
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.form-section:last-of-type {
    margin-bottom: 2rem;
}

.section-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--primary-color);
}

.section-header h6 {
    margin: 0;
    font-weight: 600;
    color: var(--dark-color);
    font-size: 1.1rem;
}

.section-header i {
    font-size: 1.2rem;
}

/* Form Groups */
.form-group { margin-bottom: 1rem; }
.form-label {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}
.form-label i { margin-right: 0.5rem; color: var(--primary-color); }
.text-danger { color: var(--danger-color) !important; }

/* Modern Inputs */
.modern-input, .modern-select, .modern-textarea {
    border: 2px solid var(--border-color);
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}
.modern-input:focus, .modern-select:focus, .modern-textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
    outline: none;
}
.modern-textarea { resize: vertical; min-height: 100px; }

/* Input Groups */
.input-group-text {
    background: var(--light-color);
    border: 2px solid var(--border-color);
    border-right: none;
    color: var(--primary-color);
    font-weight: 500;
}
.input-group .modern-input {
    border-left: none;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}
.input-group .input-group-text {
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
}

/* Form Actions */
.form-actions { margin-top: 2rem; padding-top: 2rem; border-top: 2px solid var(--border-color); }
.form-info { color: #6b7280; font-size: 0.875rem; }
.action-buttons { display: flex; gap: 1rem; }

/* Animaciones */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
.form-card { animation: fadeInUp 0.6s ease-out; }
.form-section { animation: fadeInUp 0.8s ease-out; }
.form-section:nth-child(1) { animation-delay: 0.1s; }
.form-section:nth-child(2) { animation-delay: 0.2s; }
.form-section:nth-child(3) { animation-delay: 0.3s; }
.form-section:nth-child(4) { animation-delay: 0.4s; }

/* Diseño alternativo (toggle) */
#equipoCreateWrapper.alt-design .form-header {
    background: linear-gradient(135deg, #0ea5e9 0%, #22c55e 100%);
    border-radius: 12px;
}
#equipoCreateWrapper.alt-design .form-card {
    border-left: 4px solid var(--primary-color);
    box-shadow: var(--shadow-lg);
}
#equipoCreateWrapper.alt-design .form-card-body { padding: 1.5rem; }
#equipoCreateWrapper.alt-design .form-section {
    background: #ffffff;
    border-left: 3px solid var(--primary-color);
    padding: 1rem;
}
#equipoCreateWrapper.alt-design .section-header { border-bottom-color: #22c55e; }
#equipoCreateWrapper.alt-design .modern-input:focus,
#equipoCreateWrapper.alt-design .modern-select:focus,
#equipoCreateWrapper.alt-design .modern-textarea:focus {
    border-color: #22c55e;
    box-shadow: 0 0 0 0.2rem rgba(34, 197, 94, 0.25);
}
#equipoCreateWrapper.alt-design .btn-modern { border-radius: 30px; }

/* Responsive */
@media (max-width: 768px) {
    .form-header { padding: 1.5rem; }
    .form-title { font-size: 2rem; }
    .form-card-header, .form-card-body { padding: 1.5rem; }
    .form-section { padding: 1rem; margin-bottom: 1.5rem; }
    .action-buttons { flex-direction: column; gap: 0.5rem; }
    .form-actions { text-align: center; }
    .form-info { margin-bottom: 1rem; }
    
    .card-body {
        padding: 2rem 1.5rem !important;
    }
    
    .card-header {
        padding: 1.5rem !important;
    }
    
    .card-header h5 {
        font-size: 1.3rem;
    }
    
    .main-form-container {
        padding: 0 0.5rem;
    }
    
    .section-header h6 {
        font-size: 1.1rem;
    }
    
    .btn-lg {
        padding: 0.6rem 1.5rem;
        font-size: 0.95rem;
    }
    
    .d-flex.gap-3 {
        gap: 1rem !important;
    }
}

/* ===== Estilos profesionales del módulo (refinamiento general) ===== */
/* Tarjeta contenedora */
.card.border-0.shadow-sm {
    border: 1px solid var(--border-color) !important;
    background: #fff !important;
}

/* Encabezados de sección con acento a la izquierda */
.section-header {
    display: flex;
    align-items: center;
    gap: .5rem;
    border-bottom: 1px solid #e9edf5;
    margin-bottom: 1.25rem !important;
    padding-bottom: .75rem;
    position: relative;
}
.section-header::before {
    content: '';
    width: 6px;
    height: 18px;
    background: var(--primary-color);
    border-radius: 6px;
    position: relative;
}
.section-header h6 { font-weight: 700; color: var(--dark-color); }

/* Campos modernos (inputs/select/textarea) */
.modern-input, .modern-select, .modern-textarea {
    border-color: #d7dce6;
    border-radius: 12px;
    background: #fff;
    transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
}
.modern-input:hover, .modern-select:hover, .modern-textarea:hover { border-color: #c3c9d8; }
.modern-input:focus, .modern-select:focus, .modern-textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 .25rem rgba(79, 70, 229, .18);
    background: #fff;
}

/* Select flecha coherente */
.modern-select { background-image: none; padding-right: .85rem; }

/* Botones principales grandes */
.btn.btn-primary.btn-lg {
    background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
    border-color: var(--primary-color);
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(79, 70, 229, .15);
}
.btn.btn-primary.btn-lg:hover { filter: brightness(1.06); }
.btn.btn-outline-secondary.btn-lg { border-radius: 12px; }

/* Inputs dentro de grupos (íconos a la izquierda) */
.input-group .input-group-text {
    background: #f6f8fb;
    border-color: #d7dce6;
}

/* Panel cabecera morado - sutil sombra y borde */
.module-gradient-header, .purple-header {
    border-radius: 14px 14px 0 0;
    box-shadow: 0 8px 18px rgba(80, 72, 229, .12);
    border: 1px solid rgba(80, 72, 229, .15);
}

/* Pista de ayuda */
.text-muted, .form-info { color: #7b8499 !important; }

/* Área de observaciones/descripcion */
.modern-textarea { min-height: 110px; }

/* Ajustes de espaciado vertical entre bloques */
.row.g-4 > [class^='col-'] .mb-3 { margin-bottom: 1rem !important; }

/* Divider fino debajo del título principal morado */
.equipos-divider { height: 1px; background: #e9edf5; margin: .75rem 0 1.25rem; }

/* Meta bar (estado/progreso) */
.meta-bar { background: #f8fafc; border: 1px solid var(--border-color); border-radius: 12px; padding: .6rem .9rem; margin-bottom: 1rem; }
.meta-badge { padding: .25rem .6rem; border-radius: 999px; font-weight: 600; font-size: .8rem; display: inline-flex; align-items: center; }
.meta-pending { background: #fff7ed; color: #b45309; border: 1px solid #fdba74; }
.meta-done { background: #ecfdf5; color: #059669; border: 1px solid #6ee7b7; }
.meta-progress { height: 6px; background: #e9edf5; border-radius: 999px; overflow: hidden; min-width: 180px; }
.meta-progress-fill { height: 100%; background: linear-gradient(90deg, #4f46e5, #06b6d4); border-radius: 999px; transition: width .25s ease; }

/* === Estilos del formulario tipo Inventario === */
.module-header { background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%); color: #fff; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.08); }
.module-title { font-size: 2.0rem; font-weight: 700; margin: 0; }
.module-subtitle { opacity: .9; margin-top: .25rem; }
.btn-modern { border-radius: 25px; padding: .6rem 1.2rem; font-weight: 600; }

.form-card { background: white; border-radius: 15px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); border: 1px solid #e5e7eb; overflow: hidden; }
.form-card-header { background: #f8fafc; padding: 1.5rem; border-bottom: 1px solid #e5e7eb; }
.form-card-header h5 { margin: 0 0 .5rem 0; font-weight: 600; color: #1f2937; font-size: 1.25rem; }
.form-card-header small { color: #6b7280; }
.form-card-body { padding: 1.5rem; }

.help-panel { background: white; border: 1px solid #e5e7eb; border-radius: 15px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); overflow: hidden; }
.panel-header { background: #f8fafc; padding: 1.25rem; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 1rem; }
.panel-icon { width: 32px; height: 32px; background: #4f46e5; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; }
.panel-title { margin: 0; font-size: 1rem; font-weight: 600; color: #1f2937; }
.panel-body { padding: 1.25rem; }

.help-section { margin-bottom: 1.5rem; }
.help-title { font-size: .9rem; font-weight: 600; color: #1f2937; margin-bottom: .75rem; }
.checklist, .tips-list { display: flex; flex-direction: column; gap: .5rem; }
.checklist-item, .tip-item { display: flex; align-items: center; gap: .75rem; padding: .5rem; background: #f8fafc; border-radius: 8px; }
.checklist-item span, .tip-item span { font-size: .875rem; color: #1f2937; }
.help-tip { background: rgba(79, 70, 229, 0.1); border: 1px solid rgba(79, 70, 229, 0.2); border-radius: 8px; padding: 1rem; color: #4f46e5; font-size: .875rem; display: flex; align-items: flex-start; gap: .5rem; }

/* Etiquetas y ayudas coherentes */
.form-label { font-weight: 600; color: #334155; }
.form-text, .text-muted { color: #64748b !important; }

/* Controles con misma personalidad visual del resto de módulos */
.modern-input, .modern-select, .modern-textarea {
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  background: #ffffff;
}
.modern-input:focus, .modern-select:focus, .modern-textarea:focus {
  border-color: #4f46e5;
  box-shadow: 0 0 0 .25rem rgba(79,70,229,.18);
}

/* Separadores y espaciado entre filas */
.section-header { border-bottom: 2px solid #e9edf5; margin-bottom: 1rem !important; }
.row.g-4 { row-gap: 1rem; }

/* === Responsive del formulario de Nuevo Equipo === */
@media (max-width: 1200px) {
  .card.border-0.shadow-sm .card-body { padding: 1.25rem !important; }
}
@media (max-width: 992px) {
  /* Forzar columnas al 100% dentro de filas del formulario */
  .card.border-0.shadow-sm .card-body .row> [class^='col-'],
  .card.border-0.shadow-sm .card-body .row> [class*=' col-'] {
    flex: 0 0 100% !important;
    max-width: 100% !important;
  }
  /* Botones en bloque y espaciado vertical */
  .d-flex.justify-content-end.gap-3 { flex-direction: column !important; align-items: stretch !important; gap: .75rem !important; }
  .btn.btn-primary.btn-lg, .btn.btn-outline-secondary.btn-lg { width: 100%; }
  /* Meta bar y acciones del header en columna */
  .meta-bar { flex-direction: column; align-items: stretch; gap: .5rem; }
  .hero-actions { width: 100%; justify-content: center; }
}
@media (max-width: 576px) {
  .hero-banner { padding: 1rem 1rem; }
  .card.border-0.shadow-sm .card-body { padding: 1rem !important; }
  .form-label { font-size: .95rem; }
  .modern-input, .modern-select, .modern-textarea { font-size: .95rem; }
}

</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header del Módulo -->
    <div class="module-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="module-title">
                    <i class="fas fa-laptop text-gradient me-3"></i>
                    Nuevo Equipo
                </h1>
                <p class="module-subtitle">Registra un nuevo equipo en el sistema de gestión</p>
            </div>
            <div class="col-lg-4 text-end">
                <a href="{{ route('equipos.index') }}" class="btn btn-light btn-modern">
                    <i class="fas fa-arrow-left me-2"></i>Volver a Equipos
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Formulario Principal -->
        <div class="col-xl-8">
            <div class="form-card">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 16px; border: none; background: var(--secondary-bg); color: var(--error-color); box-shadow: inset 4px 4px 8px var(--shadow-dark), inset -4px -4px 8px var(--shadow-light);">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Se encontraron {{ $errors->count() }} errores:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="hero-banner mb-4">
    <div class="hero-left">
        <div class="hero-icon">
            <i class="fas fa-laptop"></i>
        </div>
        <div>
            <h1 class="hero-title">Nuevo Equipo</h1>
            <p class="hero-subtitle">Registra un nuevo equipo en el sistema de gestión</p>
        </div>
    </div>
    <div class="hero-actions">
        <a href="{{ route('equipos.index') }}" class="btn-hero">
            <i class="fas fa-arrow-left"></i>
            <span>Volver a Equipos</span>
        </a>
    </div>
</div>

                <div class="form-card-header">
                    <h5><i class="fas fa-laptop me-2"></i>Información del Equipo</h5>
                    <small>Completa todos los campos requeridos para registrar el equipo</small>
                </div>
                <div class="form-card-body">
        <form action="{{ route('equipos.store') }}" method="POST" id="equipoForm" class="needs-validation" novalidate>
            @csrf
            <div class="meta-bar d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span id="metaBadge" class="meta-badge meta-pending">
                        <i class="fas fa-clock me-1"></i> Por completar
                    </span>
                </div>
                <div class="meta-progress ms-3 flex-grow-1">
                    <div id="metaProgressFill" class="meta-progress-fill" style="width: 0%;"></div>
                </div>
            </div>
            
            <!-- Sección 1: Información del Equipo -->
            <div class="mb-5">
                <div class="section-header mb-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-microchip text-primary me-2"></i>Información del Equipo</h6>
                    <small class="text-muted">Datos técnicos del equipo</small>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="numero_serie" class="form-label">
                                <i class="fas fa-barcode me-1"></i>Número de Serie <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control modern-input @error('numero_serie') is-invalid @enderror" 
                                   id="numero_serie" 
                                   name="numero_serie" 
                                   value="{{ old('numero_serie') }}" 
                                   placeholder="Ej: SN12345ABC"
                                   required>
                            @error('numero_serie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                        
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="marca" class="form-label">
                                <i class="fas fa-tag me-1"></i>Marca <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control modern-input @error('marca') is-invalid @enderror" 
                                   id="marca" 
                                   name="marca" 
                                   value="{{ old('marca') }}" 
                                   placeholder="HP, Dell, Lenovo..."
                                   list="marcas-sugeridas"
                                   required>
                            <datalist id="marcas-sugeridas">
                                <option value="HP">
                                <option value="Dell">
                                <option value="Lenovo">
                                <option value="Acer">
                                <option value="ASUS">
                                <option value="MSI">
                                <option value="Apple">
                                <option value="Samsung">
                                <option value="LG">
                                <option value="Canon">
                                <option value="Epson">
                            </datalist>
                            @error('marca')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modelo" class="form-label">
                                <i class="fas fa-layer-group me-1"></i>Modelo <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control modern-input @error('modelo') is-invalid @enderror" 
                                   id="modelo" 
                                   name="modelo" 
                                   value="{{ old('modelo') }}" 
                                   placeholder="Ej: Pavilion 15, Latitude 5400..."
                                   required>
                            @error('modelo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tipo_equipo" class="form-label">
                                <i class="fas fa-shapes me-1"></i>Tipo de Equipo <span class="text-danger">*</span>
                            </label>
                            <select class="form-select modern-select @error('tipo_equipo') is-invalid @enderror" 
                                    id="tipo_equipo" 
                                    name="tipo_equipo" 
                                    required>
                                <option value="">Seleccione el tipo</option>
                                <option value="Laptop" {{ old('tipo_equipo') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                                <option value="Computadora de Escritorio" {{ old('tipo_equipo') == 'Computadora de Escritorio' ? 'selected' : '' }}>Computadora de Escritorio</option>
                                <option value="Impresora" {{ old('tipo_equipo') == 'Impresora' ? 'selected' : '' }}>Impresora</option>
                                <option value="Monitor" {{ old('tipo_equipo') == 'Monitor' ? 'selected' : '' }}>Monitor</option>
                                <option value="Servidor" {{ old('tipo_equipo') == 'Servidor' ? 'selected' : '' }}>Servidor</option>
                                <option value="Tablet" {{ old('tipo_equipo') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                                <option value="Smartphone" {{ old('tipo_equipo') == 'Smartphone' ? 'selected' : '' }}>Smartphone</option>
                                <option value="Otro" {{ old('tipo_equipo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('tipo_equipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="fecha_ingreso" class="form-label">
                                <i class="fas fa-calendar-alt me-1"></i>Fecha de Ingreso <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control modern-input @error('fecha_ingreso') is-invalid @enderror" 
                                   id="fecha_ingreso" 
                                   name="fecha_ingreso" 
                                   value="{{ old('fecha_ingreso', date('Y-m-d')) }}" 
                                   required>
                            @error('fecha_ingreso')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="descripcion" class="form-label">
                                <i class="fas fa-align-left me-1"></i>Descripción del Equipo
                            </label>
                            <textarea class="form-control modern-textarea @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" 
                                      name="descripcion" 
                                      rows="3" 
                                      placeholder="Estado físico, características, accesorios incluidos..." maxlength="500">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <span class="form-text"><span id="descripcion-counter">0 / 500</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección 2: Información del Cliente -->
            <div class="mb-5">
                <div class="section-header mb-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-user text-success me-2"></i>Información del Cliente</h6>
                    <small class="text-muted">Datos del propietario del equipo</small>
                </div>
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="cliente_nombre" class="form-label">
                                <i class="fas fa-user me-1"></i>Nombre del Cliente <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control modern-input @error('cliente_nombre') is-invalid @enderror" id="cliente_nombre" name="cliente_nombre" value="{{ old('cliente_nombre') }}" placeholder="Nombre completo del propietario" required>
                            @error('cliente_nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cliente_telefono" class="form-label">
                                <i class="fas fa-phone me-1"></i>Teléfono
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="tel" class="form-control modern-input @error('cliente_telefono') is-invalid @enderror" id="cliente_telefono" name="cliente_telefono" value="{{ old('cliente_telefono') }}" placeholder="0000-0000" maxlength="20">
                            </div>
                            @error('cliente_telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cliente_email" class="form-label">
                                <i class="fas fa-envelope me-1"></i>Correo Electrónico
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control modern-input @error('cliente_email') is-invalid @enderror" id="cliente_email" name="cliente_email" value="{{ old('cliente_email') }}" placeholder="cliente@email.com">
                            </div>
                            @error('cliente_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="costo_estimado" class="form-label">
                                <i class="fas fa-coins me-1"></i>Costo Estimado (Q)
                            </label>
                            <input type="number" class="form-control modern-input @error('costo_estimado') is-invalid @enderror" id="costo_estimado" name="costo_estimado" value="{{ old('costo_estimado') }}" step="0.01" min="0" placeholder="0.00">
                            @error('costo_estimado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="observaciones" class="form-label">
                                <i class="fas fa-comment me-1"></i>Observaciones
                            </label>
                            <textarea class="form-control modern-textarea @error('observaciones') is-invalid @enderror" id="observaciones" name="observaciones" rows="3" placeholder="Problemas reportados, condiciones especiales, notas importantes..." maxlength="1000">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <small class="text-muted">Información adicional relevante</small>
                                <small class="form-text" id="observaciones-counter">0 / 1000</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sección de vista previa eliminada para unificar con clientes -->
            
            <!-- Acciones del formulario -->
            <div class="pt-4 border-top mt-5">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Los campos marcados con <span class="text-danger">*</span> son obligatorios
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('equipos.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Registrar Equipo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
                </div>
            </div>
        </div>

        <!-- Panel Lateral de Ayuda -->
        <div class="col-xl-4">
            <div class="help-panel">
                <div class="panel-header">
                    <div class="panel-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h6 class="panel-title">Ayuda</h6>
                </div>
                <div class="panel-body">
                    <div class="help-section mb-4">
                        <h6 class="help-title">Campos Obligatorios</h6>
                        <div class="checklist">
                            <div class="checklist-item">
                                <i class="fas fa-check text-success"></i>
                                <span>Número de Serie (único)</span>
                            </div>
                            <div class="checklist-item">
                                <i class="fas fa-check text-success"></i>
                                <span>Marca del equipo</span>
                            </div>
                            <div class="checklist-item">
                                <i class="fas fa-check text-success"></i>
                                <span>Modelo específico</span>
                            </div>
                            <div class="checklist-item">
                                <i class="fas fa-check text-success"></i>
                                <span>Tipo de equipo</span>
                            </div>
                            <div class="checklist-item">
                                <i class="fas fa-check text-success"></i>
                                <span>Fecha de ingreso</span>
                            </div>
                            <div class="checklist-item">
                                <i class="fas fa-check text-success"></i>
                                <span>Nombre del cliente</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="help-section mb-4">
                        <h6 class="help-title">Consejos</h6>
                        <div class="tips-list">
                            <div class="tip-item">
                                <i class="fas fa-lightbulb text-warning"></i>
                                <span>Usa códigos descriptivos</span>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-lightbulb text-warning"></i>
                                <span>Incluye marca y modelo</span>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-lightbulb text-warning"></i>
                                <span>Establece stock mínimo realista</span>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-lightbulb text-warning"></i>
                                <span>Especifica ubicación clara</span>
                            </div>
                        </div>
                    </div>

                    <div class="help-tip">
                        <i class="fas fa-info-circle"></i>
                        <strong>Tip:</strong> Puedes generar un código automático dejando el campo código vacío.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Validaciones ligeras y contadores, alineado con Clientes
document.addEventListener('DOMContentLoaded', function() {
    // Toggle de diseño alternativo
    const wrapper = document.getElementById('equipoCreateWrapper');
    const toggleBtn = document.getElementById('altDesignToggle');
    const saved = localStorage.getItem('equipos_alt_design');
    if (saved === '1') {
        wrapper && wrapper.classList.add('alt-design');
    }
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            if (!wrapper) return;
            wrapper.classList.toggle('alt-design');
            localStorage.setItem('equipos_alt_design', wrapper.classList.contains('alt-design') ? '1' : '0');
        });
    }
    
    handleFocus(e) {
        const field = e.target;
        field.parentElement.classList.add('focused');
        this.addGlowEffect(field, 'focus');
    }
    
    handleBlur(e) {
        const field = e.target;
        field.parentElement.classList.remove('focused');
        this.validateField(field);
        this.updateProgressIndicator();
    }
    
    handleInput(e) {
        const field = e.target;
        this.addGlowEffect(field, 'typing');
        
        // Debounced validation
        clearTimeout(field.validationTimeout);
        field.validationTimeout = setTimeout(() => {
            this.validateField(field, true);
        }, 500);
    }
    
    setupCharacterCounters() {
        const counters = [
            { field: 'descripcion', counter: 'descripcion-counter', max: 500 },
            { field: 'observaciones', counter: 'observaciones-counter', max: 1000 }
        ];
        
        counters.forEach(({ field, counter, max }) => {
            const fieldElement = document.getElementById(field);
            const counterElement = document.getElementById(counter);
            
            if (fieldElement && counterElement) {
                fieldElement.addEventListener('input', () => {
                    const count = fieldElement.value.length;
                    counterElement.textContent = `${count} / ${max}`;
                    
                    // Color dinámico basado en el progreso
                    if (count > max * 0.9) {
                        counterElement.style.color = 'var(--error-color)';
                    } else if (count > max * 0.7) {
                        counterElement.style.color = 'var(--warning-color)';
                    } else {
                        counterElement.style.color = 'var(--text-secondary)';
                    }
                    
                    // Animación de pulso cuando se acerca al límite
                    if (count > max * 0.95) {
                        counterElement.style.animation = 'pulse 1s infinite';
                    } else {
                        counterElement.style.animation = 'none';
                    }
                });
                
                // Trigger inicial
                fieldElement.dispatchEvent(new Event('input'));
            }
        });
    }
    
    setupValidation() {
        this.validationRules = {
            numero_serie: { required: true, minLength: 3, pattern: /^[A-Z0-9\-_]+$/ },
            marca: { required: true, minLength: 2 },
            modelo: { required: true, minLength: 2 },
            tipo_equipo: { required: true },
            fecha_ingreso: { required: true },
            cliente_nombre: { required: true, minLength: 3, pattern: /^[a-záéíóúñü\s]+$/i },
            cliente_telefono: { pattern: /^[\+]?[0-9\s\-\(\)]{7,}$/ },
            cliente_email: { pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/ }
        };
    }
    
    validateField(field, isRealTime = false) {
        const fieldName = field.name || field.id;
        const rules = this.validationRules[fieldName];
        if (!rules) return true;
        
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';
        
        // Validaciones
        if (rules.required && !value) {
            isValid = false;
            errorMessage = 'Este campo es obligatorio';
        } else if (value) {
            if (rules.minLength && value.length < rules.minLength) {
                isValid = false;
                errorMessage = `Mínimo ${rules.minLength} caracteres`;
            }
            
            if (rules.pattern && !rules.pattern.test(value)) {
                isValid = false;
                switch (fieldName) {
                    case 'numero_serie':
                        errorMessage = 'Solo letras, números, guiones y guiones bajos';
                        break;
                    case 'cliente_nombre':
                        errorMessage = 'Solo letras y espacios';
                        break;
                    case 'cliente_telefono':
                        errorMessage = 'Formato de teléfono inválido';
                        break;
                    case 'cliente_email':
                        errorMessage = 'Formato de email inválido';
                        break;
                    default:
                        errorMessage = 'Formato inválido';
                }
            }
        }
        
        // Aplicar estilos de validación
        this.applyValidationStyles(field, isValid, errorMessage, isRealTime);
        
        return isValid;
    }
    
    applyValidationStyles(field, isValid, errorMessage, isRealTime) {
        const fieldName = field.name || field.id;
        const errorElement = document.getElementById(`${fieldName}_error`);
        
        // Remover clases anteriores
        field.classList.remove('success-glow', 'error-glow');
        
        if (field.value.trim()) {
            if (isValid) {
                field.classList.add('success-glow');
                if (errorElement) {
                    errorElement.textContent = '';
                    errorElement.classList.remove('show');
                }
            } else {
                field.classList.add('error-glow');
                if (errorElement && (!isRealTime || field.value.length > 2)) {
                    errorElement.textContent = errorMessage;
                    errorElement.classList.add('show');
                }
            }
        } else {
            if (errorElement) {
                errorElement.classList.remove('show');
            }
        }
    }
    
    setupFormSummary() {
        const summaryFields = {
            'summary-equipo': () => {
                const marca = document.getElementById('marca').value;
                const modelo = document.getElementById('modelo').value;
                const tipo = document.getElementById('tipo_equipo').value;
                return marca || modelo || tipo ? `${marca} ${modelo} ${tipo}`.trim() : '-';
            },
            'summary-serie': () => document.getElementById('numero_serie').value || '-',
            'summary-cliente': () => document.getElementById('cliente_nombre').value || '-',
            'summary-fecha': () => {
                const fecha = document.getElementById('fecha_ingreso').value;
                return fecha ? new Date(fecha).toLocaleDateString('es-GT') : '-';
            },
            'summary-telefono': () => document.getElementById('cliente_telefono').value || 'No proporcionado',
            'summary-costo': () => {
                const costo = document.getElementById('costo_estimado').value;
                return costo ? `Q ${parseFloat(costo).toFixed(2)}` : 'Q 0.00';
            }
        };
        
        const updateSummary = () => {
            Object.entries(summaryFields).forEach(([elementId, getValue]) => {
                const element = document.getElementById(elementId);
                if (element) {
                    const value = getValue();
                    element.textContent = value;
                    
                    // Animación sutil cuando el valor cambia
                    element.style.transform = 'scale(1.05)';
                    element.style.transition = 'transform 0.2s ease';
                    setTimeout(() => {
                        element.style.transform = 'scale(1)';
                    }, 200);
                }
            });
        };
        
        this.form.addEventListener('input', () => {
            clearTimeout(this.summaryTimeout);
            this.summaryTimeout = setTimeout(updateSummary, 300);
        });
        
        // Update inicial
        updateSummary();
    }
    
    setupAutoSuggestions() {
        const tipoField = document.getElementById('tipo_equipo');
        const descripcionField = document.getElementById('descripcion');
        
        tipoField.addEventListener('change', () => {
            if (!descripcionField.value.trim()) {
                const descripciones = {
                    'Laptop': 'Computadora portátil en revisión - verificar batería, pantalla y teclado',
                    'Computadora de Escritorio': 'Equipo de escritorio para diagnóstico completo',
                    'Impresora': 'Impresora para mantenimiento y revisión de calidad',
                    'Monitor': 'Monitor para reparación - revisar imagen y conectividad',
                    'Tablet': 'Tablet en servicio - verificar pantalla táctil y batería',
                    'Smartphone': 'Dispositivo móvil para reparación integral'
                };
                
                const descripcion = descripciones[tipoField.value];
                if (descripcion) {
                    this.animateTextInput(descripcionField, descripcion);
                }
            }
        });
    }
    
    animateTextInput(element, text) {
        element.value = '';
        let i = 0;
        const interval = setInterval(() => {
            if (i < text.length) {
                element.value += text.charAt(i);
                element.dispatchEvent(new Event('input'));
                i++;
            } else {
                clearInterval(interval);
            }
        }, 30);
    }
    
    setupProgressIndicator() {
        this.updateProgressIndicator();
    }
    
    updateProgressIndicator() {
        const section1Fields = ['numero_serie', 'marca', 'modelo', 'tipo_equipo', 'fecha_ingreso'];
        const section2Fields = ['cliente_nombre'];
        
        const section1Complete = this.checkSectionComplete(section1Fields);
        const section2Complete = this.checkSectionComplete(section2Fields);
        
        this.updateStepIndicator(1, section1Complete);
        this.updateStepIndicator(2, section2Complete && section1Complete);
        this.updateStepIndicator(3, section1Complete && section2Complete);
    }
    
    checkSectionComplete(fields) {
        return fields.every(fieldName => {
            const field = document.getElementById(fieldName);
            return field && field.value.trim() !== '';
        });
    }
    
    updateStepIndicator(step, completed) {
        const stepElement = document.querySelector(`[data-step="${step}"]`);
        if (stepElement) {
            stepElement.classList.remove('active', 'completed');
            if (completed) {
                stepElement.classList.add('completed');
                
                // Animación de éxito
                const circle = stepElement.querySelector('.step-circle');
                if (circle) {
                    circle.style.animation = 'successPulse 0.6s ease-out';
                    setTimeout(() => {
                        circle.style.animation = '';
                    }, 600);
                }
            } else {
                stepElement.classList.add('active');
            }
        }
    }
    
    setupNeomorphicEffects() {
        // Efectos hover mejorados para secciones
        document.querySelectorAll('.neomorphic-section').forEach(section => {
            section.addEventListener('mouseenter', () => {
                section.style.transform = 'translateY(-2px)';
            });
            
            section.addEventListener('mouseleave', () => {
                section.style.transform = 'translateY(0)';
            });
        });
        
        // Efectos de focus para inputs
        const style = document.createElement('style');
        style.textContent = `
            @keyframes successPulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.1); background: var(--success-color); }
                100% { transform: scale(1); }
            }
            
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.7; }
            }
            
            .focused .input-icon {
                color: var(--accent-color) !important;
                transform: translateY(-50%) scale(1.1) !important;
            }
        `;
        document.head.appendChild(style);
    }
    
    addGlowEffect(element, type) {
        element.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
        
        switch (type) {
            case 'focus':
                element.style.transform = 'scale(1.02)';
                break;
            case 'typing':
                element.style.boxShadow = 'inset 6px 6px 12px var(--shadow-dark), inset -6px -6px 12px var(--shadow-light), 0 0 20px rgba(79, 70, 229, 0.15)';
                break;
        }
        
        setTimeout(() => {
            if (type === 'focus') {
                element.style.transform = '';
            }
        }, 300);
    }
    
    handleSubmit(e) {
        e.preventDefault();
        
        // Validar todos los campos
        let isValid = true;
        const requiredFields = this.form.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            this.showNotification('Por favor, corrige los errores en el formulario', 'error');
            
            // Scroll al primer error con animación suave
            const firstError = this.form.querySelector('.error-glow');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Efecto de atención
                firstError.style.animation = 'shake 0.6s ease-in-out';
                setTimeout(() => {
                    firstError.style.animation = '';
                }, 600);
            }
            return;
        }
        
        // Animación de envío
        const submitBtn = document.getElementById('submitBtn');
        const spinner = document.getElementById('submitSpinner');
        
        submitBtn.disabled = true;
        submitBtn.classList.add('loading');
        spinner.classList.remove('d-none');
        
        // Mensaje de éxito
        this.showNotification('Registrando equipo...', 'success');
        
        // Enviar después de un breve delay para mostrar la animación
        setTimeout(() => {
            this.form.submit();
        }, 1000);
    }
    
    showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i>
            <span>${message}</span>
        `;
        
        notification.style.cssText = `
            position: fixed;
            top: 2rem;
            right: 2rem;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: ${type === 'error' ? 'var(--error-color)' : 'var(--success-color)'};
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        `;
        
        document.body.appendChild(notification);
        
        // Animación de entrada
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Auto-remove
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 400);
        }, 4000);
    }
}

// Estilos adicionales para animaciones
const additionalStyles = document.createElement('style');
additionalStyles.textContent = `
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.notification {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.notification i {
    font-size: 1.2rem;
}
`;
document.head.appendChild(additionalStyles);

// Inicializar sistema cuando DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    new NeomorphicEquipoSystem();
});

<script>
(function(){
  document.addEventListener('DOMContentLoaded', function(){
    const requiredFields = [
      'numero_serie','marca','modelo','tipo_equipo','fecha_ingreso'
    ];
    const badge = document.getElementById('metaBadge');
    const fill = document.getElementById('metaProgressFill');

    function updateProgress(){
      let filled = 0;
      requiredFields.forEach(id => {
        const el = document.getElementById(id) || document.querySelector(`[name="${id}"]`);
        if(el && String(el.value || '').trim().length > 0){ filled++; }
      });
      const pct = Math.round((filled / requiredFields.length) * 100);
      if(fill) fill.style.width = pct + '%';
      if(badge){
        if(pct === 100){
          badge.classList.remove('meta-pending');
          badge.classList.add('meta-done');
          badge.innerHTML = '<i class="fas fa-check me-1"></i> Completo';
        } else {
          badge.classList.remove('meta-done');
          badge.classList.add('meta-pending');
          badge.innerHTML = '<i class="fas fa-clock me-1"></i> Por completar';
        }
      }
    }

    // listeners
    requiredFields.forEach(id => {
      const el = document.getElementById(id) || document.querySelector(`[name="${id}"]`);
      if(el){ el.addEventListener('input', updateProgress); el.addEventListener('change', updateProgress); }
    });
    updateProgress();
  });
})();
</script>
@endsection
