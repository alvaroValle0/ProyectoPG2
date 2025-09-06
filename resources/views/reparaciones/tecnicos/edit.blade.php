@extends('layouts.app')

@section('title', 'Editar Técnico - ' . $tecnico->nombre_completo)

@section('styles')
<style>
    .modern-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }
    .form-section {
        background: rgba(248, 249, 250, 0.8);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(0, 0, 0, 0.08);
    }
    .section-title {
        color: #495057;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
    }
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #27DB9F;
        box-shadow: 0 0 0 0.2rem rgba(39, 219, 159, 0.25);
    }
    .photo-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .photo-upload-area:hover {
        border-color: #27DB9F;
        background: rgba(39, 219, 159, 0.05);
    }
    .current-photo {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }
    /* Ajustes para evitar cortes de textos/campos */
    .modern-card .card-body { overflow: visible; }
    .form-control, .form-select { width: 100%; min-height: 44px; padding: 0.6rem 0.9rem; }
    .form-select { padding-right: 2.25rem; }
    textarea.form-control { min-height: 120px; }
    .photo-upload-area { min-height: 140px; display: flex; align-items: center; justify-content: center; }
    .section-title i { color: #27DB9F; }
    label.form-label { margin-bottom: 0.35rem; }
    h1.h3 { line-height: 1.3; }
</style>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-user-edit text-warning me-2"></i>
            Editar Perfil de Técnico
        </h1>
        <p class="text-muted">Modifica la información completa de {{ $tecnico->nombre_completo }}</p>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <a href="{{ route('tecnicos.show', $tecnico) }}" class="btn btn-outline-primary">
                <i class="fas fa-eye me-2"></i>Ver Perfil
            </a>
            <a href="{{ route('tecnicos.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Se encontraron errores:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('tecnicos.update', $tecnico) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
    <div class="row g-4">
        <!-- Información Personal -->
                <div class="col-lg-6">
            <div class="modern-card">
                <div class="card-body">
                    <h5 class="section-title">
                        <i class="fas fa-user text-primary me-2"></i>
                        Información Personal
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombres" class="form-label">Nombres <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nombres') is-invalid @enderror" 
                                   id="nombres" 
                                   name="nombres" 
                                   value="{{ old('nombres', $tecnico->nombres) }}" 
                                   required>
                            @error('nombres')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('apellidos') is-invalid @enderror" 
                                   id="apellidos" 
                                   name="apellidos" 
                                   value="{{ old('apellidos', $tecnico->apellidos) }}" 
                                   required>
                            @error('apellidos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" 
                                   class="form-control @error('telefono') is-invalid @enderror" 
                                   id="telefono" 
                                   name="telefono" 
                                   value="{{ old('telefono', $tecnico->telefono) }}"
                                   placeholder="+502 1234 5678">
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email_personal" class="form-label">Email Personal</label>
                            <input type="email" 
                                   class="form-control @error('email_personal') is-invalid @enderror" 
                                   id="email_personal" 
                                   name="email_personal" 
                                   value="{{ old('email_personal', $tecnico->email_personal) }}"
                                   placeholder="email@ejemplo.com">
                            @error('email_personal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="dpi" class="form-label">DPI</label>
                            <input type="text" 
                                   class="form-control @error('dpi') is-invalid @enderror" 
                                   id="dpi" 
                                   name="dpi" 
                                   value="{{ old('dpi', $tecnico->dpi) }}"
                                   placeholder="1234567890123">
                            @error('dpi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" 
                                   class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                   id="fecha_nacimiento" 
                                   name="fecha_nacimiento" 
                                   value="{{ old('fecha_nacimiento', $tecnico->fecha_nacimiento?->format('Y-m-d')) }}">
                            @error('fecha_nacimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="genero" class="form-label">Género</label>
                            <select class="form-select @error('genero') is-invalid @enderror" 
                                    id="genero" 
                                    name="genero">
                                <option value="">Seleccione...</option>
                                <option value="masculino" {{ old('genero', $tecnico->genero) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ old('genero', $tecnico->genero) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="otro" {{ old('genero', $tecnico->genero) == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('genero')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>

                        <div class="col-md-6">
                            <label for="estado_civil" class="form-label">Estado Civil</label>
                            <select class="form-select @error('estado_civil') is-invalid @enderror" 
                                    id="estado_civil" 
                                    name="estado_civil">
                                <option value="">Seleccione...</option>
                                <option value="Soltero/a" {{ old('estado_civil', $tecnico->estado_civil) == 'Soltero/a' ? 'selected' : '' }}>Soltero/a</option>
                                <option value="Casado/a" {{ old('estado_civil', $tecnico->estado_civil) == 'Casado/a' ? 'selected' : '' }}>Casado/a</option>
                                <option value="Divorciado/a" {{ old('estado_civil', $tecnico->estado_civil) == 'Divorciado/a' ? 'selected' : '' }}>Divorciado/a</option>
                                <option value="Viudo/a" {{ old('estado_civil', $tecnico->estado_civil) == 'Viudo/a' ? 'selected' : '' }}>Viudo/a</option>
                                <option value="Unión Libre" {{ old('estado_civil', $tecnico->estado_civil) == 'Unión Libre' ? 'selected' : '' }}>Unión Libre</option>
                            </select>
                            @error('estado_civil')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                                </div>
                        
                        <div class="col-12">
                            <label for="direccion" class="form-label">Dirección</label>
                            <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                      id="direccion" 
                                      name="direccion" 
                                      rows="3"
                                      placeholder="Dirección completa...">{{ old('direccion', $tecnico->direccion) }}</textarea>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <label for="contacto_emergencia" class="form-label">Contacto de Emergencia</label>
                            <input type="text" 
                                   class="form-control @error('contacto_emergencia') is-invalid @enderror" 
                                   id="contacto_emergencia" 
                                   name="contacto_emergencia" 
                                   value="{{ old('contacto_emergencia', $tecnico->contacto_emergencia) }}"
                                   placeholder="Nombre y teléfono de contacto de emergencia">
                            @error('contacto_emergencia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                            </div>
                        </div>
                    </div>
                </div>

        <!-- Información Profesional y Foto -->
                <div class="col-lg-6">
            <!-- Foto de Perfil -->
            <div class="modern-card mb-4">
                <div class="card-body">
                    <h5 class="section-title">
                        <i class="fas fa-camera text-info me-2"></i>
                        Foto de Perfil
                    </h5>

                    <div class="text-center mb-3">
                        @if($tecnico->foto)
                            <img src="{{ $tecnico->foto_url }}" alt="Foto actual" class="current-photo mb-3">
                        @else
                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 120px; height: 120px; font-size: 3rem; color: white;">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="photo-upload-area" onclick="document.getElementById('foto').click()">
                        <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                        <p class="mb-0">Haz clic para seleccionar una nueva foto</p>
                        <small class="text-muted">JPG, PNG, GIF hasta 2MB</small>
                    </div>
                    
                    <input type="file" 
                           class="form-control d-none @error('foto') is-invalid @enderror" 
                           id="foto" 
                           name="foto" 
                           accept="image/*">
                    @error('foto')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Información Profesional -->
            <div class="modern-card">
                <div class="card-body">
                    <h5 class="section-title">
                        <i class="fas fa-briefcase text-success me-2"></i>
                        Información Profesional
                    </h5>

                    <div class="row g-3">
                        <div class="col-12">
                        <label for="especialidad" class="form-label">Especialidad <span class="text-danger">*</span></label>
                        <select class="form-select @error('especialidad') is-invalid @enderror" 
                                id="especialidad" 
                                name="especialidad" 
                                required>
                            <option value="">Seleccione una especialidad</option>
                            <option value="Hardware y Componentes" {{ old('especialidad', $tecnico->especialidad) == 'Hardware y Componentes' ? 'selected' : '' }}>
                                Hardware y Componentes
                            </option>
                            <option value="Software y Sistemas Operativos" {{ old('especialidad', $tecnico->especialidad) == 'Software y Sistemas Operativos' ? 'selected' : '' }}>
                                Software y Sistemas Operativos
                            </option>
                            <option value="Redes y Conectividad" {{ old('especialidad', $tecnico->especialidad) == 'Redes y Conectividad' ? 'selected' : '' }}>
                                Redes y Conectividad
                            </option>
                            <option value="Equipos Móviles" {{ old('especialidad', $tecnico->especialidad) == 'Equipos Móviles' ? 'selected' : '' }}>
                                Equipos Móviles
                            </option>
                            <option value="Servidores y Infraestructura" {{ old('especialidad', $tecnico->especialidad) == 'Servidores y Infraestructura' ? 'selected' : '' }}>
                                Servidores y Infraestructura
                            </option>
                            <option value="Impresoras y Periféricos" {{ old('especialidad', $tecnico->especialidad) == 'Impresoras y Periféricos' ? 'selected' : '' }}>
                                Impresoras y Periféricos
                            </option>
                            <option value="Seguridad Informática" {{ old('especialidad', $tecnico->especialidad) == 'Seguridad Informática' ? 'selected' : '' }}>
                                Seguridad Informática
                            </option>
                            <option value="Diagnóstico General" {{ old('especialidad', $tecnico->especialidad) == 'Diagnóstico General' ? 'selected' : '' }}>
                                Diagnóstico General
                            </option>
                            <option value="Recuperación de Datos" {{ old('especialidad', $tecnico->especialidad) == 'Recuperación de Datos' ? 'selected' : '' }}>
                                Recuperación de Datos
                            </option>
                        </select>
                        @error('especialidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                        <div class="col-md-6">
                            <label for="nivel_experiencia" class="form-label">Nivel de Experiencia</label>
                            <select class="form-select @error('nivel_experiencia') is-invalid @enderror" 
                                    id="nivel_experiencia" 
                                    name="nivel_experiencia">
                                <option value="">Seleccione...</option>
                                <option value="principiante" {{ old('nivel_experiencia', $tecnico->nivel_experiencia) == 'principiante' ? 'selected' : '' }}>Principiante</option>
                                <option value="intermedio" {{ old('nivel_experiencia', $tecnico->nivel_experiencia) == 'intermedio' ? 'selected' : '' }}>Intermedio</option>
                                <option value="avanzado" {{ old('nivel_experiencia', $tecnico->nivel_experiencia) == 'avanzado' ? 'selected' : '' }}>Avanzado</option>
                                <option value="experto" {{ old('nivel_experiencia', $tecnico->nivel_experiencia) == 'experto' ? 'selected' : '' }}>Experto</option>
                            </select>
                            @error('nivel_experiencia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="fecha_contratacion" class="form-label">Fecha de Contratación</label>
                            <input type="date" 
                                   class="form-control @error('fecha_contratacion') is-invalid @enderror" 
                                   id="fecha_contratacion" 
                                   name="fecha_contratacion" 
                                   value="{{ old('fecha_contratacion', $tecnico->fecha_contratacion?->format('Y-m-d')) }}">
                            @error('fecha_contratacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                        <label for="descripcion" class="form-label">Descripción de Habilidades</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" 
                                  name="descripcion" 
                                  rows="4" 
                                  placeholder="Describe las habilidades específicas, certificaciones, experiencia, etc.">{{ old('descripcion', $tecnico->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                            <small class="text-muted">Detalla las habilidades, certificaciones y experiencia del técnico</small>
                    </div>

                        <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input @error('activo') is-invalid @enderror" 
                                   type="checkbox" 
                                   id="activo" 
                                   name="activo" 
                                   value="1" 
                                   {{ old('activo', $tecnico->activo) ? 'checked' : '' }}>
                            <label class="form-check-label" for="activo">
                                <strong>Técnico Activo</strong>
                            </label>
                            @error('activo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block">
                                @if($tecnico->activo)
                                    El técnico está activo y puede recibir asignaciones
                                @else
                                    El técnico está inactivo y no recibirá nuevas asignaciones
                                @endif
                            </small>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Información del Usuario Asociado -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-body">
                    <h5 class="section-title">
                        <i class="fas fa-user-tie text-info me-2"></i>
                        Usuario del Sistema Asociado
                    </h5>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Usuario asociado:</strong> {{ $tecnico->user->name }}<br>
                        <strong>Email del sistema:</strong> {{ $tecnico->user->email }}<br>
                        <strong>Rol:</strong> {{ ucfirst($tecnico->user->rol) }}<br>
                        <small class="text-muted">La información del usuario del sistema (nombre, email, contraseña) se gestiona desde la administración de usuarios.</small>
                    </div>

                    @if($tecnico->reparacionesActivas && $tecnico->reparacionesActivas->count() > 0)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Atención:</strong> Este técnico tiene {{ $tecnico->reparacionesActivas->count() }} reparaciones activas.
                        Si lo desactivas, no podrá recibir nuevas asignaciones, pero debe completar las pendientes.
                    </div>
                    @endif
                </div>
            </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- Estadísticas Actuales -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">
                        <i class="fas fa-chart-bar text-success me-2"></i>
                        Estadísticas Actuales
                    </h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card border-primary text-center">
                                <div class="card-body">
                                    <i class="fas fa-tasks text-primary display-6 mb-2"></i>
                                    <h4 class="text-primary">{{ $tecnico->total_reparaciones ?? 0 }}</h4>
                                    <p class="text-muted mb-0">Total Reparaciones</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-success text-center">
                                <div class="card-body">
                                    <i class="fas fa-check-circle text-success display-6 mb-2"></i>
                                    <h4 class="text-success">{{ $tecnico->reparaciones_completadas_count ?? 0 }}</h4>
                                    <p class="text-muted mb-0">Completadas</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-warning text-center">
                                <div class="card-body">
                                    <i class="fas fa-clock text-warning display-6 mb-2"></i>
                                    <h4 class="text-warning">{{ $tecnico->carga_trabajo ?? 0 }}</h4>
                                    <p class="text-muted mb-0">Carga Actual</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-info text-center">
                                <div class="card-body">
                                    <i class="fas fa-stopwatch text-info display-6 mb-2"></i>
                                    <h4 class="text-info">
                                        @if($tecnico->promedio_tiempo_reparacion)
                                            {{ round($tecnico->promedio_tiempo_reparacion, 1) }}h
                                        @else
                                            N/A
                                        @endif
                                    </h4>
                                    <p class="text-muted mb-0">Promedio Tiempo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reparaciones Activas -->
            @if($tecnico->reparacionesActivas && $tecnico->reparacionesActivas->count() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">
                        <i class="fas fa-tasks text-warning me-2"></i>
                        Reparaciones Activas ({{ $tecnico->reparacionesActivas->count() }})
                    </h5>
                    <div class="row">
                        @foreach($tecnico->reparacionesActivas->take(4) as $reparacion)
                        <div class="col-md-6 mb-3">
                            <div class="card border-left-{{ $reparacion->estado_color }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">Reparación #{{ $reparacion->id }}</h6>
                                            <p class="mb-1 text-muted">{{ $reparacion->equipo->cliente_nombre }}</p>
                                            <span class="badge bg-{{ $reparacion->estado_color }} text-white">
                                                {{ ucfirst($reparacion->estado) }}
                                            </span>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted">{{ $reparacion->fecha_inicio->diffForHumans() }}</small>
                                            <br>
                                            <a href="{{ route('reparaciones.show', $reparacion) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($tecnico->reparacionesActivas->count() > 4)
                    <div class="text-center">
                        <a href="{{ route('reparaciones.index', ['tecnico_id' => $tecnico->id]) }}" 
                           class="btn btn-outline-info">
                            <i class="fas fa-list me-2"></i>Ver todas las reparaciones ({{ $tecnico->reparacionesActivas->count() }})
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif

    <!-- Botones de Acción -->
    <div class="row mt-4">
                <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('tecnicos.show', $tecnico) }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            @if($tecnico->reparacionesActivas->count() == 0)
                                <button type="button" class="btn btn-outline-danger" onclick="confirmarEliminacion()">
                                    <i class="fas fa-trash me-2"></i>Eliminar Técnico
                                </button>
                            @endif
                        </div>
                <button type="submit" class="btn btn-warning btn-lg">
                    <i class="fas fa-save me-2"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Formulario oculto para eliminar -->
        @if($tecnico->reparacionesActivas->count() == 0)
        <form id="eliminarForm" action="{{ route('tecnicos.destroy', $tecnico) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="update"]');
    const fotoInput = document.getElementById('foto');
    const uploadArea = document.querySelector('.photo-upload-area');
    
    // Manejo de carga de foto
    if (fotoInput && uploadArea) {
        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validar tipo de archivo
                if (!file.type.startsWith('image/')) {
                    alert('Por favor, seleccione solo archivos de imagen.');
                    fotoInput.value = '';
                    return;
                }
                
                // Validar tamaño (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('La imagen debe ser menor a 2MB.');
                    fotoInput.value = '';
                    return;
                }
                
                // Mostrar preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const currentPhoto = document.querySelector('.current-photo');
                    if (currentPhoto) {
                        currentPhoto.src = e.target.result;
                    } else {
                        // Crear nuevo elemento de imagen
                        const imgContainer = document.querySelector('.text-center.mb-3');
                        imgContainer.innerHTML = `<img src="${e.target.result}" alt="Nueva foto" class="current-photo mb-3">`;
                    }
                    
                    // Actualizar texto del área de carga
                    uploadArea.innerHTML = `
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <p class="mb-0 text-success">Nueva foto seleccionada</p>
                        <small class="text-muted">Haz clic para cambiar</small>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Drag and drop
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.style.borderColor = '#27DB9F';
            uploadArea.style.background = 'rgba(39, 219, 159, 0.1)';
        });
        
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.style.borderColor = '#dee2e6';
            uploadArea.style.background = 'transparent';
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.style.borderColor = '#dee2e6';
            uploadArea.style.background = 'transparent';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fotoInput.files = files;
                fotoInput.dispatchEvent(new Event('change'));
            }
        });
    }
    
    // Validación del formulario
    form.addEventListener('submit', function(e) {
        let valid = true;
        const requiredFields = ['nombres', 'apellidos', 'especialidad'];
        
        requiredFields.forEach(function(fieldName) {
            const field = document.getElementById(fieldName);
            if (field && !field.value.trim()) {
                field.classList.add('is-invalid');
            valid = false;
            } else if (field) {
                field.classList.remove('is-invalid');
        }
        });
        
        if (!valid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos obligatorios marcados con *');
            
            // Scroll al primer campo con error
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });
    
    // Validación en tiempo real
    const requiredInputs = document.querySelectorAll('input[required], select[required]');
    requiredInputs.forEach(function(input) {
        input.addEventListener('blur', function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
    });
});

function confirmarEliminacion() {
    if (confirm('¿Está seguro de que desea eliminar este técnico?\n\nEsta acción no se puede deshacer y eliminará todo el historial relacionado.')) {
        if (confirm('Confirme nuevamente: ¿Realmente desea eliminar el técnico {{ $tecnico->nombre_completo }}?')) {
            document.getElementById('eliminarForm').submit();
        }
    }
}
</script>
@endsection

@section('styles')
<style>
.border-left-primary { border-left: 4px solid #007bff !important; }
.border-left-warning { border-left: 4px solid #ffc107 !important; }
.border-left-success { border-left: 4px solid #28a745 !important; }
.border-left-danger { border-left: 4px solid #dc3545 !important; }
.border-left-info { border-left: 4px solid #17a2b8 !important; }
</style>
@endsection