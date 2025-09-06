@extends('layouts.app')

@section('title', 'Editar Equipo - ' . $equipo->numero_serie)

@section('styles')
<style>
/* Glassmorphism + Material Design 3 Advanced System */
:root {
    --glass-primary: rgba(79, 70, 229, 0.8);
    --glass-secondary: rgba(139, 92, 246, 0.8);
    --glass-success: rgba(34, 197, 94, 0.8);
    --glass-warning: rgba(245, 158, 11, 0.8);
    --glass-danger: rgba(239, 68, 68, 0.8);
    --glass-surface: rgba(255, 255, 255, 0.1);
    --glass-surface-variant: rgba(255, 255, 255, 0.05);
    --glass-outline: rgba(255, 255, 255, 0.2);
    --text-on-glass: #ffffff;
    --text-on-glass-variant: rgba(255, 255, 255, 0.87);
    --text-on-glass-secondary: rgba(255, 255, 255, 0.6);
    --backdrop-blur: 20px;
    --surface-elevation-1: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    --surface-elevation-2: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    --surface-elevation-3: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
    --surface-elevation-4: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
}

.glassmorphism-container {
    background: linear-gradient(135deg, 
        #667eea 0%, 
        #764ba2 25%, 
        #f093fb 50%, 
        #f5576c 75%, 
        #4facfe 100%);
    background-size: 400% 400%;
    animation: gradientShift 15s ease infinite;
    min-height: 100vh;
    padding: 2rem;
    position: relative;
    overflow-x: hidden;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    25% { background-position: 100% 50%; }
    50% { background-position: 100% 100%; }
    75% { background-position: 0% 100%; }
    100% { background-position: 0% 50%; }
}

.glassmorphism-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 50% 50%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
    pointer-events: none;
    z-index: 0;
}

.main-glass-container {
    position: relative;
    z-index: 1;
    max-width: 1400px;
    margin: 0 auto;
}

.glass-header {
    background: var(--glass-surface);
    backdrop-filter: blur(var(--backdrop-blur));
    border: 1px solid var(--glass-outline);
    border-radius: 24px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: var(--surface-elevation-2);
    position: relative;
    overflow: hidden;
}

.glass-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 6px;
    background: linear-gradient(90deg, 
        var(--glass-primary), 
        var(--glass-secondary), 
        var(--glass-warning));
    animation: headerGlow 3s ease-in-out infinite alternate;
}

@keyframes headerGlow {
    0% { opacity: 0.6; }
    100% { opacity: 1; }
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 2rem;
}

.header-info {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.equipment-avatar {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--glass-primary), var(--glass-secondary));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: var(--text-on-glass);
    box-shadow: var(--surface-elevation-3);
    position: relative;
    overflow: hidden;
}

.equipment-avatar::before {
    content: '';
    position: absolute;
    inset: 2px;
    border-radius: 50%;
    background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.2));
    z-index: 1;
}

.equipment-avatar i {
    position: relative;
    z-index: 2;
}

.header-text h1 {
    color: var(--text-on-glass);
    font-size: 2.25rem;
    font-weight: 800;
    margin: 0 0 0.5rem 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.header-subtitle {
    color: var(--text-on-glass-secondary);
    font-size: 1.1rem;
    font-weight: 500;
    margin: 0;
}

.equipment-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.status-recibido { background: var(--glass-primary); }
.status-en_reparacion { background: var(--glass-warning); }
.status-reparado { background: var(--glass-success); }
.status-entregado { background: rgba(156, 163, 175, 0.8); }

.glass-tabs {
    background: var(--glass-surface);
    backdrop-filter: blur(var(--backdrop-blur));
    border: 1px solid var(--glass-outline);
    border-radius: 16px;
    margin-bottom: 2rem;
    padding: 0.5rem;
    box-shadow: var(--surface-elevation-1);
    display: flex;
    gap: 0.5rem;
    position: relative;
}

.glass-tab {
    flex: 1;
    padding: 1rem 2rem;
    border: none;
    background: transparent;
    color: var(--text-on-glass-secondary);
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.glass-tab.active {
    background: var(--glass-surface);
    color: var(--text-on-glass);
    box-shadow: var(--surface-elevation-2);
    transform: translateY(-2px);
}

.glass-tab:hover:not(.active) {
    background: var(--glass-surface-variant);
    color: var(--text-on-glass-variant);
}

.tab-indicator {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--glass-primary), var(--glass-secondary));
    border-radius: 3px 3px 0 0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
}

.glass-tab.active .tab-indicator {
    opacity: 1;
    width: 100%;
}

.glass-panel {
    background: var(--glass-surface);
    backdrop-filter: blur(var(--backdrop-blur));
    border: 1px solid var(--glass-outline);
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: var(--surface-elevation-2);
    display: none;
    animation: panelSlideIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.glass-panel.active {
    display: block;
}

@keyframes panelSlideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.glass-input-group {
    margin-bottom: 2rem;
    position: relative;
}

.glass-label {
    display: block;
    color: var(--text-on-glass);
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.glass-label .required {
    color: var(--glass-danger);
    margin-left: 0.25rem;
}

.glass-input,
.glass-select,
.glass-textarea {
    width: 100%;
    padding: 1.25rem 1.5rem;
    background: var(--glass-surface-variant);
    backdrop-filter: blur(10px);
    border: 2px solid transparent;
    border-radius: 16px;
    color: var(--text-on-glass);
    font-size: 1rem;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: var(--surface-elevation-1);
    position: relative;
}

.glass-input:focus,
.glass-select:focus,
.glass-textarea:focus {
    outline: none;
    border-color: var(--glass-primary);
    background: var(--glass-surface);
    box-shadow: var(--surface-elevation-2), 0 0 20px rgba(79, 70, 229, 0.3);
    transform: scale(1.02);
}

.glass-input:valid:not(:placeholder-shown) {
    border-color: var(--glass-success);
    box-shadow: var(--surface-elevation-1), 0 0 15px rgba(34, 197, 94, 0.2);
}

.glass-input:invalid:not(:placeholder-shown) {
    border-color: var(--glass-danger);
    box-shadow: var(--surface-elevation-1), 0 0 15px rgba(239, 68, 68, 0.2);
}

.glass-input::placeholder,
.glass-textarea::placeholder {
    color: var(--text-on-glass-secondary);
    font-style: italic;
}

.glass-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23ffffff'%3e%3cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3e%3c/path%3e%3c/svg%3e");
    background-position: right 1.5rem center;
    background-repeat: no-repeat;
    background-size: 20px;
    cursor: pointer;
}

.glass-textarea {
    resize: vertical;
    min-height: 120px;
    font-family: inherit;
}

.input-icon {
    position: absolute;
    top: 50%;
    right: 1.5rem;
    transform: translateY(-50%);
    color: var(--text-on-glass-secondary);
    font-size: 1.2rem;
    transition: all 0.3s ease;
    pointer-events: none;
}

.glass-input-group:focus-within .input-icon {
    color: var(--glass-primary);
    transform: translateY(-50%) scale(1.1);
}

.validation-feedback {
    margin-top: 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.validation-feedback.show {
    opacity: 1;
    transform: translateY(0);
}

.validation-feedback.valid {
    color: var(--glass-success);
}

.validation-feedback.invalid {
    color: var(--glass-danger);
}

.floating-actions {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    z-index: 1000;
    display: flex;
    flex-direction: column-reverse;
    gap: 1rem;
}

.fab {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    border: none;
    background: linear-gradient(135deg, var(--glass-primary), var(--glass-secondary));
    color: var(--text-on-glass);
    font-size: 1.5rem;
    cursor: pointer;
    box-shadow: var(--surface-elevation-3);
    backdrop-filter: blur(var(--backdrop-blur));
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.fab:hover {
    transform: scale(1.1);
    box-shadow: var(--surface-elevation-4);
}

.fab:active {
    transform: scale(0.95);
}

.fab-primary {
    background: linear-gradient(135deg, var(--glass-success), rgba(34, 197, 94, 0.9));
}

.fab-secondary {
    background: linear-gradient(135deg, var(--glass-warning), rgba(245, 158, 11, 0.9));
    width: 56px;
    height: 56px;
    font-size: 1.25rem;
}

.fab-danger {
    background: linear-gradient(135deg, var(--glass-danger), rgba(239, 68, 68, 0.9));
    width: 48px;
    height: 48px;
    font-size: 1rem;
}

.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    transform: scale(0);
    animation: rippleEffect 0.6s linear;
}

@keyframes rippleEffect {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

.audit-info {
    background: var(--glass-surface-variant);
    backdrop-filter: blur(10px);
    border: 1px solid var(--glass-outline);
    border-radius: 16px;
    padding: 1.5rem;
    margin-top: 2rem;
    border-left: 4px solid var(--glass-primary);
}

.audit-info h6 {
    color: var(--text-on-glass);
    font-weight: 700;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.audit-info p {
    color: var(--text-on-glass-secondary);
    margin-bottom: 0.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.audit-info strong {
    color: var(--text-on-glass-variant);
}

.glass-alert {
    background: var(--glass-surface);
    backdrop-filter: blur(var(--backdrop-blur));
    border: 1px solid var(--glass-outline);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: var(--surface-elevation-1);
}

.glass-alert.error {
    border-color: var(--glass-danger);
    background: rgba(239, 68, 68, 0.1);
}

.glass-alert.success {
    border-color: var(--glass-success);
    background: rgba(34, 197, 94, 0.1);
}

.glass-alert i {
    font-size: 1.5rem;
    flex-shrink: 0;
}

.glass-alert.error i {
    color: var(--glass-danger);
}

.glass-alert.success i {
    color: var(--glass-success);
}

.preview-card {
    background: var(--glass-surface);
    backdrop-filter: blur(var(--backdrop-blur));
    border: 1px solid var(--glass-outline);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: var(--surface-elevation-2);
    margin-bottom: 2rem;
    position: sticky;
    top: 2rem;
}

.preview-title {
    color: var(--text-on-glass);
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.preview-title i {
    color: var(--glass-primary);
    font-size: 1.5rem;
}

.preview-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--glass-outline);
}

.preview-item:last-child {
    border-bottom: none;
}

.preview-label {
    color: var(--text-on-glass-secondary);
    font-weight: 500;
}

.preview-value {
    color: var(--text-on-glass);
    font-weight: 600;
    text-align: right;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .main-glass-container {
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .glassmorphism-container {
        padding: 1rem;
    }
    
    .glass-header {
        padding: 2rem 1.5rem;
    }
    
    .header-content {
        flex-direction: column;
        text-align: center;
    }
    
    .header-info {
        flex-direction: column;
        gap: 1rem;
    }
    
    .equipment-avatar {
        width: 64px;
        height: 64px;
        font-size: 1.5rem;
    }
    
    .header-text h1 {
        font-size: 1.75rem;
    }
    
    .glass-tabs {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .glass-panel {
        padding: 1.5rem;
    }
    
    .floating-actions {
        bottom: 1rem;
        right: 1rem;
    }
    
    .fab {
        width: 56px;
        height: 56px;
        font-size: 1.25rem;
    }
    
    .preview-card {
        position: static;
        margin-bottom: 2rem;
    }
}

/* Loading and Transition States */
.loading-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.loading-overlay.show {
    opacity: 1;
    visibility: visible;
}

.loading-spinner {
    width: 60px;
    height: 60px;
    border: 4px solid var(--glass-surface);
    border-top: 4px solid var(--glass-primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endsection

@section('content')
<div class="glassmorphism-container">
    <div class="main-glass-container">
        @if ($errors->any())
            <div class="glass-alert error">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>Se encontraron {{ $errors->count() }} errores:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        
        @if (session('success'))
            <div class="glass-alert success">
                <i class="fas fa-check-circle"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <!-- Glass Header -->
        <div class="glass-header">
            <div class="header-content">
                <div class="header-info">
                    <div class="equipment-avatar">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="header-text">
                        <h1>Editar Equipo</h1>
                        <p class="header-subtitle">Modificar información de {{ $equipo->numero_serie }}</p>
                    </div>
                </div>
                <div class="equipment-status status-{{ $equipo->estado }}">
                    <i class="fas fa-circle"></i>
                    <span>{{ ucfirst(str_replace('_', ' ', $equipo->estado)) }}</span>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Glass Tabs -->
                <div class="glass-tabs">
                    <button type="button" class="glass-tab active" data-tab="equipment">
                        <i class="fas fa-laptop me-2"></i>Equipo
                        <div class="tab-indicator"></div>
                    </button>
                    <button type="button" class="glass-tab" data-tab="client">
                        <i class="fas fa-user me-2"></i>Cliente
                        <div class="tab-indicator"></div>
                    </button>
                    <button type="button" class="glass-tab" data-tab="status">
                        <i class="fas fa-cog me-2"></i>Estado
                        <div class="tab-indicator"></div>
                    </button>
                </div>

                <form action="{{ route('equipos.update', $equipo) }}" method="POST" id="equipoEditForm">
                    @csrf
                    @method('PUT')

                    <!-- Panel: Información del Equipo -->
                    <div class="glass-panel active" data-panel="equipment">
                        <div class="row g-4">
                            <div class="col-md-12">
                                <div class="glass-input-group">
                                    <label for="numero_serie" class="glass-label">
                                        Número de Serie<span class="required">*</span>
                                    </label>
                                    <input type="text"
                                           class="glass-input @error('numero_serie') is-invalid @enderror"
                                           id="numero_serie"
                                           name="numero_serie"
                                           value="{{ old('numero_serie', $equipo->numero_serie) }}"
                                           placeholder="Ingrese el número de serie"
                                           required>
                                    <div class="validation-feedback" id="numero_serie_feedback">
                                        @error('numero_serie') {{ $message }} @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="glass-input-group">
                                    <label for="marca" class="glass-label">
                                        Marca<span class="required">*</span>
                                    </label>
                                    <input type="text"
                                           class="glass-input @error('marca') is-invalid @enderror"
                                           id="marca"
                                           name="marca"
                                           value="{{ old('marca', $equipo->marca) }}"
                                           placeholder="Marca del equipo"
                                           list="marcas-list"
                                           required>
                                    <datalist id="marcas-list">
                                        <option value="HP">
                                        <option value="Dell">
                                        <option value="Lenovo">
                                        <option value="ASUS">
                                        <option value="Acer">
                                        <option value="Apple">
                                        <option value="Samsung">
                                        <option value="MSI">
                                        <option value="LG">
                                        <option value="Sony">
                                    </datalist>
                                    <div class="validation-feedback" id="marca_feedback">
                                        @error('marca') {{ $message }} @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="glass-input-group">
                                    <label for="modelo" class="glass-label">
                                        Modelo<span class="required">*</span>
                                    </label>
                                    <input type="text"
                                           class="glass-input @error('modelo') is-invalid @enderror"
                                           id="modelo"
                                           name="modelo"
                                           value="{{ old('modelo', $equipo->modelo) }}"
                                           placeholder="Modelo específico"
                                           required>
                                    <div class="validation-feedback" id="modelo_feedback">
                                        @error('modelo') {{ $message }} @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="glass-input-group">
                                    <label for="tipo_equipo" class="glass-label">
                                        Tipo de Equipo<span class="required">*</span>
                                    </label>
                                    <select class="glass-select @error('tipo_equipo') is-invalid @enderror"
                                            id="tipo_equipo"
                                            name="tipo_equipo"
                                            required>
                                        <option value="">Seleccione el tipo de equipo</option>
                                        <option value="Laptop" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Laptop' ? 'selected' : '' }}>💻 Laptop</option>
                                        <option value="Computadora de Escritorio" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Computadora de Escritorio' ? 'selected' : '' }}>🖥️ Computadora de Escritorio</option>
                                        <option value="Impresora" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Impresora' ? 'selected' : '' }}>🖨️ Impresora</option>
                                        <option value="Monitor" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Monitor' ? 'selected' : '' }}>🖥️ Monitor</option>
                                        <option value="Servidor" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Servidor' ? 'selected' : '' }}>🗄️ Servidor</option>
                                        <option value="Tablet" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Tablet' ? 'selected' : '' }}>📱 Tablet</option>
                                        <option value="Smartphone" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Smartphone' ? 'selected' : '' }}>📱 Smartphone</option>
                                        <option value="Otro" {{ old('tipo_equipo', $equipo->tipo_equipo) == 'Otro' ? 'selected' : '' }}>⚙️ Otro</option>
                                    </select>
                                    <div class="validation-feedback" id="tipo_equipo_feedback">
                                        @error('tipo_equipo') {{ $message }} @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="glass-input-group">
                                    <label for="descripcion" class="glass-label">
                                        Descripción del Equipo
                                    </label>
                                    <textarea class="glass-textarea @error('descripcion') is-invalid @enderror"
                                              id="descripcion"
                                              name="descripcion"
                                              placeholder="Características, estado físico, accesorios incluidos..."
                                              maxlength="500">{{ old('descripcion', $equipo->descripcion) }}</textarea>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <small style="color: var(--text-on-glass-secondary);">Detalles técnicos del equipo</small>
                                        <span class="character-counter" id="descripcion-counter">0 / 500</span>
                                    </div>
                                    <div class="validation-feedback" id="descripcion_feedback">
                                        @error('descripcion') {{ $message }} @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel: Información del Cliente -->
                    <div class="glass-panel" data-panel="client">
                        <div class="row g-4">
                            <div class="col-md-12">
                                <div class="glass-input-group">
                                    <label for="cliente_nombre" class="glass-label">
                                        Nombre del Cliente<span class="required">*</span>
                                    </label>
                                    <input type="text"
                                           class="glass-input @error('cliente_nombre') is-invalid @enderror"
                                           id="cliente_nombre"
                                           name="cliente_nombre"
                                           value="{{ old('cliente_nombre', $equipo->cliente_nombre) }}"
                                           placeholder="Nombre completo del cliente"
                                           required>
                                    <div class="validation-feedback" id="cliente_nombre_feedback">
                                        @error('cliente_nombre') {{ $message }} @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="glass-input-group">
                                    <label for="cliente_telefono" class="glass-label">
                                        Teléfono
                                    </label>
                                    <input type="tel"
                                           class="glass-input @error('cliente_telefono') is-invalid @enderror"
                                           id="cliente_telefono"
                                           name="cliente_telefono"
                                           value="{{ old('cliente_telefono', $equipo->cliente_telefono) }}"
                                           placeholder="+502 1234 5678">
                                    <div class="validation-feedback" id="cliente_telefono_feedback">
                                        @error('cliente_telefono') {{ $message }} @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="glass-input-group">
                                    <label for="cliente_email" class="glass-label">
                                        Correo Electrónico
                                    </label>
                                    <input type="email"
                                           class="glass-input @error('cliente_email') is-invalid @enderror"
                                           id="cliente_email"
                                           name="cliente_email"
                                           value="{{ old('cliente_email', $equipo->cliente_email) }}"
                                           placeholder="cliente@correo.com">
                                    <div class="validation-feedback" id="cliente_email_feedback">
                                        @error('cliente_email') {{ $message }} @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="glass-input-group">
                                    <label for="costo_estimado" class="glass-label">
                                        Costo Estimado (Q)
                                    </label>
                                    <input type="number"
                                           class="glass-input @error('costo_estimado') is-invalid @enderror"
                                           id="costo_estimado"
                                           name="costo_estimado"
                                           value="{{ old('costo_estimado', $equipo->costo_estimado) }}"
                                           step="0.01"
                                           min="0"
                                           placeholder="0.00">
                                    <div class="validation-feedback" id="costo_estimado_feedback">
                                        @error('costo_estimado') {{ $message }} @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="glass-input-group">
                                    <label for="observaciones" class="glass-label">
                                        Observaciones
                                    </label>
                                    <textarea class="glass-textarea @error('observaciones') is-invalid @enderror"
                                              id="observaciones"
                                              name="observaciones"
                                              placeholder="Problemas reportados, condiciones especiales, notas importantes..."
                                              maxlength="1000">{{ old('observaciones', $equipo->observaciones) }}</textarea>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <small style="color: var(--text-on-glass-secondary);">Información adicional del servicio</small>
                                        <span class="character-counter" id="observaciones-counter">0 / 1000</span>
                                    </div>
                                    <div class="validation-feedback" id="observaciones_feedback">
                                        @error('observaciones') {{ $message }} @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Panel: Estado y Configuración -->
                    <div class="glass-panel" data-panel="status">
                        <div class="row g-4">
                            <div class="col-md-12">
                                <div class="glass-input-group">
                                    <label for="estado" class="glass-label">
                                        Estado del Equipo<span class="required">*</span>
                                    </label>
                                    <select class="glass-select @error('estado') is-invalid @enderror"
                                            id="estado"
                                            name="estado"
                                            required>
                                        <option value="recibido" {{ old('estado', $equipo->estado) == 'recibido' ? 'selected' : '' }}>🔴 Recibido</option>
                                        <option value="en_reparacion" {{ old('estado', $equipo->estado) == 'en_reparacion' ? 'selected' : '' }}>🟡 En Reparación</option>
                                        <option value="reparado" {{ old('estado', $equipo->estado) == 'reparado' ? 'selected' : '' }}>🟢 Reparado</option>
                                        <option value="entregado" {{ old('estado', $equipo->estado) == 'entregado' ? 'selected' : '' }}>⚪ Entregado</option>
                                    </select>
                                    <div class="validation-feedback" id="estado_feedback">
                                        @error('estado') {{ $message }} @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="audit-info">
                                    <h6>
                                        <i class="fas fa-info-circle"></i>
                                        Información del Registro
                                    </h6>
                                    <p>
                                        <span>Fecha de Ingreso:</span>
                                        <strong>{{ $equipo->fecha_ingreso->format('d/m/Y') }}</strong>
                                    </p>
                                    <p>
                                        <span>Registrado:</span>
                                        <strong>{{ $equipo->created_at->format('d/m/Y H:i') }}</strong>
                                    </p>
                                    <p>
                                        <span>Última Actualización:</span>
                                        <strong>{{ $equipo->updated_at->format('d/m/Y H:i') }}</strong>
                                    </p>
                                    @if($equipo->reparaciones->count() > 0)
                                    <p>
                                        <span>Reparaciones:</span>
                                        <strong>{{ $equipo->reparaciones->count() }} registro(s)</strong>
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Preview Card -->
            <div class="col-lg-4">
                <div class="preview-card">
                    <div class="preview-title">
                        <i class="fas fa-eye"></i>
                        Vista Previa
                    </div>
                    
                    <div class="preview-item">
                        <span class="preview-label">Equipo:</span>
                        <span class="preview-value" id="preview-equipo">{{ $equipo->marca }} {{ $equipo->modelo }}</span>
                    </div>
                    
                    <div class="preview-item">
                        <span class="preview-label">Serie:</span>
                        <span class="preview-value" id="preview-serie">{{ $equipo->numero_serie }}</span>
                    </div>
                    
                    <div class="preview-item">
                        <span class="preview-label">Tipo:</span>
                        <span class="preview-value" id="preview-tipo">{{ $equipo->tipo_equipo }}</span>
                    </div>
                    
                    <div class="preview-item">
                        <span class="preview-label">Cliente:</span>
                        <span class="preview-value" id="preview-cliente">{{ $equipo->cliente_nombre }}</span>
                    </div>
                    
                    <div class="preview-item">
                        <span class="preview-label">Estado:</span>
                        <span class="preview-value equipment-status status-{{ $equipo->estado }}" id="preview-estado">
                            <i class="fas fa-circle"></i>
                            {{ ucfirst(str_replace('_', ' ', $equipo->estado)) }}
                        </span>
                    </div>
                    
                    <div class="preview-item">
                        <span class="preview-label">Costo:</span>
                        <span class="preview-value" id="preview-costo">Q {{ number_format($equipo->costo_estimado ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating Action Buttons -->
        <div class="floating-actions">
            <button type="submit" form="equipoEditForm" class="fab fab-primary" title="Guardar Cambios">
                <i class="fas fa-save"></i>
            </button>
            <a href="{{ route('equipos.show', $equipo) }}" class="fab fab-secondary" title="Ver Detalles">
                <i class="fas fa-eye"></i>
            </a>
            @if($equipo->reparaciones()->whereIn('estado', ['pendiente', 'en_proceso'])->doesntExist())
            <button type="button" class="fab fab-danger" onclick="confirmarEliminacion()" title="Eliminar Equipo">
                <i class="fas fa-trash"></i>
            </button>
            @endif
        </div>

        <!-- Formulario oculto para eliminar -->
        @if($equipo->reparaciones()->whereIn('estado', ['pendiente', 'en_proceso'])->doesntExist())
        <form id="eliminarForm" action="{{ route('equipos.destroy', $equipo) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        @endif
        
        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Sistema Glassmorphism Avanzado para Edición de Equipos
class GlassmorphismEquipmentEditor {
    constructor() {
        this.form = document.getElementById('equipoEditForm');
        this.currentTab = 'equipment';
        this.hasUnsavedChanges = false;
        this.init();
    }
    
    init() {
        this.setupTabs();
        this.setupValidation();
        this.setupRippleEffects();
        this.setupCharacterCounters();
        this.setupRealTimePreview();
        this.setupFormInteractions();
        this.setupLoadingStates();
        console.log('🔮 Sistema Glassmorphism de Edición Iniciado');
    }
    
    setupTabs() {
        const tabs = document.querySelectorAll('.glass-tab');
        const panels = document.querySelectorAll('.glass-panel');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                const targetTab = tab.dataset.tab;
                this.switchTab(targetTab);
            });
        });
        
        // Navegación por teclado
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey || e.metaKey) {
                if (e.key === '1') {
                    e.preventDefault();
                    this.switchTab('equipment');
                } else if (e.key === '2') {
                    e.preventDefault();
                    this.switchTab('client');
                } else if (e.key === '3') {
                    e.preventDefault();
                    this.switchTab('status');
                }
            }
        });
    }
    
    switchTab(tabName) {
        // Actualizar tabs
        document.querySelectorAll('.glass-tab').forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
        
        // Actualizar paneles
        document.querySelectorAll('.glass-panel').forEach(panel => {
            panel.classList.remove('active');
        });
        document.querySelector(`[data-panel="${tabName}"]`).classList.add('active');
        
        this.currentTab = tabName;
        
        // Enfocar primer input del panel activo
        setTimeout(() => {
            const activePanel = document.querySelector('.glass-panel.active');
            const firstInput = activePanel.querySelector('.glass-input, .glass-select');
            if (firstInput) {
                firstInput.focus();
            }
        }, 300);
    }
    
    setupValidation() {
        const validationRules = {
            numero_serie: { 
                required: true, 
                minLength: 3,
                transform: 'uppercase',
                pattern: /^[A-Z0-9\-_]+$/
            },
            marca: { required: true, minLength: 2 },
            modelo: { required: true, minLength: 2 },
            tipo_equipo: { required: true },
            cliente_nombre: { 
                required: true, 
                minLength: 3,
                pattern: /^[a-záéíóúñü\s]+$/i
            },
            estado: { required: true },
            cliente_email: { pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/ },
            cliente_telefono: { pattern: /^[\+]?[0-9\s\-\(\)]{7,}$/ },
            costo_estimado: { min: 0, max: 999999.99 }
        };
        
        Object.keys(validationRules).forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field) {
                // Transformaciones en tiempo real
                field.addEventListener('input', (e) => {
                    const rules = validationRules[fieldName];
                    if (rules.transform === 'uppercase') {
                        e.target.value = e.target.value.toUpperCase();
                    }
                    
                    this.hasUnsavedChanges = true;
                    this.addInputGlow(e.target);
                    
                    // Validación debounced
                    clearTimeout(e.target.validationTimeout);
                    e.target.validationTimeout = setTimeout(() => {
                        this.validateField(field, rules, true);
                    }, 500);
                });
                
                field.addEventListener('blur', () => {
                    this.validateField(field, validationRules[fieldName]);
                });
            }
        });
    }
    
    validateField(field, rules, isRealTime = false) {
        if (!rules) return true;
        
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';
        
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
                const fieldName = field.name || field.id;
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
            
            if (rules.min !== undefined && parseFloat(value) < rules.min) {
                isValid = false;
                errorMessage = `Valor mínimo: ${rules.min}`;
            }
            
            if (rules.max !== undefined && parseFloat(value) > rules.max) {
                isValid = false;
                errorMessage = `Valor máximo: ${rules.max}`;
            }
        }
        
        this.applyValidationFeedback(field, isValid, errorMessage, isRealTime);
        return isValid;
    }
    
    applyValidationFeedback(field, isValid, errorMessage, isRealTime) {
        const fieldName = field.name || field.id;
        const feedbackElement = document.getElementById(`${fieldName}_feedback`);
        
        field.classList.remove('is-invalid', 'is-valid');
        
        if (field.value.trim()) {
            if (isValid) {
                field.classList.add('is-valid');
                if (feedbackElement) {
                    feedbackElement.textContent = '';
                    feedbackElement.classList.remove('show', 'invalid');
                    feedbackElement.classList.add('valid');
                }
            } else {
                field.classList.add('is-invalid');
                if (feedbackElement && (!isRealTime || field.value.length > 2)) {
                    feedbackElement.textContent = errorMessage;
                    feedbackElement.classList.remove('valid');
                    feedbackElement.classList.add('show', 'invalid');
                }
            }
        } else if (feedbackElement) {
            feedbackElement.classList.remove('show');
        }
    }
    
    setupRippleEffects() {
        const createRipple = (event, element) => {
            const rect = element.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = event.clientX - rect.left - size / 2;
            const y = event.clientY - rect.top - size / 2;
            
            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            ripple.style.cssText = `
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
            `;
            
            element.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        };
        
        // Agregar ripple a FABs y botones
        document.querySelectorAll('.fab, .glass-tab').forEach(button => {
            button.addEventListener('click', (e) => {
                createRipple(e, button);
            });
        });
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
                const updateCounter = () => {
                    const count = fieldElement.value.length;
                    counterElement.textContent = `${count} / ${max}`;
                    
                    // Color dinámico
                    if (count > max * 0.9) {
                        counterElement.style.color = 'var(--glass-danger)';
                    } else if (count > max * 0.7) {
                        counterElement.style.color = 'var(--glass-warning)';
                    } else {
                        counterElement.style.color = 'var(--text-on-glass-secondary)';
                    }
                    
                    // Animación de advertencia
                    if (count > max * 0.95) {
                        counterElement.style.animation = 'pulse 1s infinite';
                    } else {
                        counterElement.style.animation = 'none';
                    }
                };
                
                fieldElement.addEventListener('input', updateCounter);
                updateCounter(); // Inicial
            }
        });
    }
    
    setupRealTimePreview() {
        const previewFields = {
            'preview-equipo': () => {
                const marca = document.getElementById('marca').value;
                const modelo = document.getElementById('modelo').value;
                return `${marca} ${modelo}`.trim() || '{{ $equipo->marca }} {{ $equipo->modelo }}';
            },
            'preview-serie': () => document.getElementById('numero_serie').value || '{{ $equipo->numero_serie }}',
            'preview-tipo': () => document.getElementById('tipo_equipo').value || '{{ $equipo->tipo_equipo }}',
            'preview-cliente': () => document.getElementById('cliente_nombre').value || '{{ $equipo->cliente_nombre }}',
            'preview-estado': () => {
                const estado = document.getElementById('estado').value || '{{ $equipo->estado }}';
                const estadoTexto = estado.replace('_', ' ');
                return `<i class="fas fa-circle"></i> ${estadoTexto.charAt(0).toUpperCase() + estadoTexto.slice(1)}`;
            },
            'preview-costo': () => {
                const costo = document.getElementById('costo_estimado').value || '{{ $equipo->costo_estimado ?? 0 }}';
                return `Q ${parseFloat(costo || 0).toFixed(2)}`;
            }
        };
        
        const updatePreview = () => {
            Object.entries(previewFields).forEach(([elementId, getValue]) => {
                const element = document.getElementById(elementId);
                if (element) {
                    const value = getValue();
                    if (elementId === 'preview-estado') {
                        element.innerHTML = value;
                        // Actualizar clase de estado
                        element.className = element.className.replace(/status-\w+/, '');
                        const estado = document.getElementById('estado').value || '{{ $equipo->estado }}';
                        element.classList.add(`status-${estado}`);
                    } else {
                        element.textContent = value;
                    }
                    
                    // Animación de actualización
                    element.style.transform = 'scale(1.05)';
                    element.style.transition = 'transform 0.2s ease';
                    setTimeout(() => {
                        element.style.transform = 'scale(1)';
                    }, 200);
                }
            });
        };
        
        // Escuchar cambios en todos los campos
        this.form.addEventListener('input', () => {
            clearTimeout(this.previewTimeout);
            this.previewTimeout = setTimeout(updatePreview, 200);
        });
        
        this.form.addEventListener('change', updatePreview);
    }
    
    setupFormInteractions() {
        // Detectar cambios no guardados
        window.addEventListener('beforeunload', (e) => {
            if (this.hasUnsavedChanges) {
                e.preventDefault();
                e.returnValue = '¿Estás seguro de que quieres salir? Los cambios no guardados se perderán.';
            }
        });
        
        // Manejo de envío del formulario
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            if (!this.validateForm()) {
                this.showNotification('Por favor, corrige los errores en el formulario', 'error');
                return;
            }
            
            this.showLoadingState();
            this.hasUnsavedChanges = false;
            
            // Enviar después de mostrar la animación
            setTimeout(() => {
                this.form.submit();
            }, 800);
        });
        
        // Auto-guardado draft (opcional)
        setInterval(() => {
            if (this.hasUnsavedChanges) {
                this.saveDraft();
            }
        }, 30000); // Cada 30 segundos
    }
    
    validateForm() {
        let isValid = true;
        const requiredFields = this.form.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            const fieldName = field.name || field.id;
            const rules = {
                numero_serie: { required: true, minLength: 3, pattern: /^[A-Z0-9\-_]+$/ },
                marca: { required: true, minLength: 2 },
                modelo: { required: true, minLength: 2 },
                tipo_equipo: { required: true },
                cliente_nombre: { required: true, minLength: 3 },
                estado: { required: true }
            }[fieldName] || { required: true };
            
            if (!this.validateField(field, rules)) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            // Ir al primer error
            const firstError = this.form.querySelector('.is-invalid');
            if (firstError) {
                // Encontrar en qué tab está el error
                const errorPanel = firstError.closest('.glass-panel');
                if (errorPanel) {
                    const tabName = errorPanel.dataset.panel;
                    this.switchTab(tabName);
                }
                
                setTimeout(() => {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                    
                    // Efecto de shake
                    firstError.style.animation = 'shake 0.6s ease-in-out';
                    setTimeout(() => {
                        firstError.style.animation = '';
                    }, 600);
                }, 400);
            }
        }
        
        return isValid;
    }
    
    setupLoadingStates() {
        const loadingOverlay = document.getElementById('loadingOverlay');
        
        this.showLoadingState = () => {
            loadingOverlay.classList.add('show');
            
            // Deshabilitar FABs
            document.querySelectorAll('.fab').forEach(fab => {
                fab.style.opacity = '0.5';
                fab.style.pointerEvents = 'none';
            });
        };
        
        this.hideLoadingState = () => {
            loadingOverlay.classList.remove('show');
            
            // Rehabilitar FABs
            document.querySelectorAll('.fab').forEach(fab => {
                fab.style.opacity = '1';
                fab.style.pointerEvents = 'auto';
            });
        };
    }
    
    addInputGlow(field) {
        field.style.boxShadow = 'var(--surface-elevation-2), 0 0 25px rgba(79, 70, 229, 0.4)';
        field.style.transform = 'scale(1.02)';
        
        setTimeout(() => {
            field.style.boxShadow = '';
            field.style.transform = '';
        }, 300);
    }
    
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = 'glass-notification';
        notification.innerHTML = `
            <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i>
            <span>${message}</span>
        `;
        
        const colors = {
            error: 'var(--glass-danger)',
            success: 'var(--glass-success)',
            info: 'var(--glass-primary)'
        };
        
        notification.style.cssText = `
            position: fixed;
            top: 2rem;
            left: 50%;
            transform: translateX(-50%) translateY(-100px);
            background: ${colors[type]};
            color: white;
            padding: 1rem 2rem;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            box-shadow: var(--surface-elevation-3);
            z-index: 10001;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        `;
        
        document.body.appendChild(notification);
        
        // Animación de entrada
        setTimeout(() => {
            notification.style.transform = 'translateX(-50%) translateY(0)';
        }, 100);
        
        // Auto-remove
        setTimeout(() => {
            notification.style.transform = 'translateX(-50%) translateY(-100px)';
            setTimeout(() => notification.remove(), 400);
        }, 4000);
    }
    
    saveDraft() {
        const formData = new FormData(this.form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        
        localStorage.setItem('equipo_edit_draft_{{ $equipo->id }}', JSON.stringify({
            data,
            timestamp: Date.now()
        }));
        
        console.log('📄 Draft guardado automáticamente');
    }
}

// Función de confirmación de eliminación
function confirmarEliminacion() {
    if (confirm('¿Está seguro de que desea eliminar este equipo?\n\nEsta acción no se puede deshacer y eliminará todo el historial relacionado.')) {
        if (confirm('Confirme nuevamente: ¿Realmente desea eliminar el equipo {{ $equipo->numero_serie }}?')) {
            document.getElementById('eliminarForm').submit();
        }
    }
}

// Estilos adicionales para notificaciones y efectos
const additionalStyles = document.createElement('style');
additionalStyles.textContent = `
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-8px); }
    75% { transform: translateX(8px); }
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

.glass-notification {
    font-family: inherit;
    letter-spacing: 0.3px;
}

.glass-notification i {
    font-size: 1.2rem;
}

/* Mejoras visuales adicionales */
.glass-input:focus,
.glass-select:focus,
.glass-textarea:focus {
    outline: none !important;
    box-shadow: var(--surface-elevation-2), 0 0 20px rgba(79, 70, 229, 0.3) !important;
}

.glass-input.is-valid {
    border-color: var(--glass-success) !important;
    box-shadow: var(--surface-elevation-1), 0 0 15px rgba(34, 197, 94, 0.2) !important;
}

.glass-input.is-invalid {
    border-color: var(--glass-danger) !important;
    box-shadow: var(--surface-elevation-1), 0 0 15px rgba(239, 68, 68, 0.2) !important;
}
`;
document.head.appendChild(additionalStyles);

// Inicializar sistema
document.addEventListener('DOMContentLoaded', () => {
    new GlassmorphismEquipmentEditor();
});
</script>
@endsection