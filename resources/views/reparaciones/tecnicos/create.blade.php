@extends('layouts.app')

@section('title', 'Nuevo Técnico')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-user-plus text-primary me-2"></i>
            Registrar Nuevo Técnico
        </h1>
        <p class="text-muted">Agrega un nuevo técnico especializado al equipo</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('tecnicos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver a la Lista
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($usuarios->count() == 0)
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>No hay usuarios disponibles.</strong> 
                Todos los usuarios ya tienen un perfil de técnico asignado o no hay usuarios registrados.
                <hr>
                <a href="#" onclick="mostrarProximamente('Crear Usuario')" class="btn btn-warning btn-sm">
                    <i class="fas fa-user-plus me-1"></i>Crear Nuevo Usuario
                </a>
            </div>
        @else
            <form action="{{ route('tecnicos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <!-- Información Personal -->
                    <div class="col-lg-6">
                        <h5 class="mb-3">
                            <i class="fas fa-user text-primary me-2"></i>
                            Información Personal
                        </h5>
                        
                        <!-- Selección de Usuario -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Usuario del Sistema <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select class="form-select @error('user_id') is-invalid @enderror" 
                                        id="user_id" 
                                        name="user_id" 
                                        required>
                                    <option value="">Seleccione un usuario</option>
                                    @foreach($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" {{ old('user_id') == $usuario->id ? 'selected' : '' }}>
                                            {{ $usuario->name }} ({{ $usuario->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" 
                                        class="btn btn-success btn-lg px-3" 
                                        onclick="abrirModalCrearUsuario()"
                                        title="Crear nuevo usuario del sistema"
                                        style="min-width: 50px;">
                                    <i class="fas fa-user-plus fa-lg"></i>
                                </button>
                            </div>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Mensaje informativo mejorado -->
                            <div class="alert alert-info border-0 mt-2 mb-0" style="background-color: rgba(13, 202, 240, 0.1);">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-lightbulb text-info me-2 mt-1"></i>
                                    </div>
                                    <div>
                                        <strong>¿No tienes un usuario?</strong> 
                                        Haz clic en el botón <i class="fas fa-user-plus text-success"></i> para crear uno nuevo directamente desde aquí.
                                        <br><small class="text-muted">El usuario se creará automáticamente con rol de "Técnico" y se seleccionará en el formulario.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nombres -->
                        <div class="mb-3">
                            <label for="nombres" class="form-label">Nombres <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nombres') is-invalid @enderror" 
                                   id="nombres" 
                                   name="nombres" 
                                   value="{{ old('nombres') }}" 
                                   required
                                   placeholder="Nombres del técnico">
                            @error('nombres')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Apellidos -->
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('apellidos') is-invalid @enderror" 
                                   id="apellidos" 
                                   name="apellidos" 
                                   value="{{ old('apellidos') }}" 
                                   required
                                   placeholder="Apellidos del técnico">
                            @error('apellidos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Teléfono -->
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" 
                                   class="form-control @error('telefono') is-invalid @enderror" 
                                   id="telefono" 
                                   name="telefono" 
                                   value="{{ old('telefono') }}" 
                                   placeholder="Ej: +502 1234-5678">
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Personal -->
                        <div class="mb-3">
                            <label for="email_personal" class="form-label">Email Personal</label>
                            <input type="email" 
                                   class="form-control @error('email_personal') is-invalid @enderror" 
                                   id="email_personal" 
                                   name="email_personal" 
                                   value="{{ old('email_personal') }}" 
                                   placeholder="email@ejemplo.com">
                            @error('email_personal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Opcional: Email personal diferente al del sistema</small>
                        </div>

                        <!-- DPI -->
                        <div class="mb-3">
                            <label for="dpi" class="form-label">DPI <small class="text-muted">(Opcional)</small></label>
                            <input type="text" 
                                   class="form-control @error('dpi') is-invalid @enderror" 
                                   id="dpi" 
                                   name="dpi" 
                                   value="{{ old('dpi') }}" 
                                   placeholder="Ej: 1234567890101">
                            @error('dpi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Documento Personal de Identificación</small>
                        </div>
                    </div>

                    <!-- Información Adicional y Técnica -->
                    <div class="col-lg-6">
                        <h5 class="mb-3">
                            <i class="fas fa-cog text-info me-2"></i>
                            Información Técnica y Adicional
                        </h5>

                        <!-- Fotografía -->
                        <div class="mb-3">
                            <label for="foto" class="form-label">Fotografía</label>
                            <input type="file" 
                                   class="form-control @error('foto') is-invalid @enderror" 
                                   id="foto" 
                                   name="foto" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Formatos: JPG, PNG, GIF. Máximo 2MB.</small>
                            
                            <!-- Preview de la imagen -->
                            <div class="mt-2" id="preview-container" style="display: none;">
                                <img id="preview-image" src="" alt="Preview" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                      id="direccion" 
                                      name="direccion" 
                                      rows="3" 
                                      placeholder="Dirección completa de residencia">{{ old('direccion') }}</textarea>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Fecha de Nacimiento -->
                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" 
                                   class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                   id="fecha_nacimiento" 
                                   name="fecha_nacimiento" 
                                   value="{{ old('fecha_nacimiento') }}" 
                                   max="{{ date('Y-m-d') }}">
                            @error('fecha_nacimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Género -->
                        <div class="mb-3">
                            <label for="genero" class="form-label">Género</label>
                            <select class="form-select @error('genero') is-invalid @enderror" 
                                    id="genero" 
                                    name="genero">
                                <option value="">Seleccione género</option>
                                <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="otro" {{ old('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('genero')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Estado Civil -->
                        <div class="mb-3">
                            <label for="estado_civil" class="form-label">Estado Civil</label>
                            <select class="form-select @error('estado_civil') is-invalid @enderror" 
                                    id="estado_civil" 
                                    name="estado_civil">
                                <option value="">Seleccione estado civil</option>
                                <option value="Soltero(a)" {{ old('estado_civil') == 'Soltero(a)' ? 'selected' : '' }}>Soltero(a)</option>
                                <option value="Casado(a)" {{ old('estado_civil') == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                <option value="Divorciado(a)" {{ old('estado_civil') == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                                <option value="Viudo(a)" {{ old('estado_civil') == 'Viudo(a)' ? 'selected' : '' }}>Viudo(a)</option>
                                <option value="Unión Libre" {{ old('estado_civil') == 'Unión Libre' ? 'selected' : '' }}>Unión Libre</option>
                            </select>
                            @error('estado_civil')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Especialidad -->
                        <div class="mb-3">
                            <label for="especialidad" class="form-label">Especialidad <span class="text-danger">*</span></label>
                            <select class="form-select @error('especialidad') is-invalid @enderror" 
                                    id="especialidad" 
                                    name="especialidad" 
                                    required>
                                <option value="">Seleccione una especialidad</option>
                                <option value="Hardware y Componentes" {{ old('especialidad') == 'Hardware y Componentes' ? 'selected' : '' }}>Hardware y Componentes</option>
                                <option value="Software y Sistemas Operativos" {{ old('especialidad') == 'Software y Sistemas Operativos' ? 'selected' : '' }}>Software y Sistemas Operativos</option>
                                <option value="Redes y Conectividad" {{ old('especialidad') == 'Redes y Conectividad' ? 'selected' : '' }}>Redes y Conectividad</option>
                                <option value="Equipos Móviles" {{ old('especialidad') == 'Equipos Móviles' ? 'selected' : '' }}>Equipos Móviles</option>
                                <option value="Servidores y Infraestructura" {{ old('especialidad') == 'Servidores y Infraestructura' ? 'selected' : '' }}>Servidores y Infraestructura</option>
                                <option value="Impresoras y Periféricos" {{ old('especialidad') == 'Impresoras y Periféricos' ? 'selected' : '' }}>Impresoras y Periféricos</option>
                                <option value="Seguridad Informática" {{ old('especialidad') == 'Seguridad Informática' ? 'selected' : '' }}>Seguridad Informática</option>
                                <option value="Diagnóstico General" {{ old('especialidad') == 'Diagnóstico General' ? 'selected' : '' }}>Diagnóstico General</option>
                                <option value="Recuperación de Datos" {{ old('especialidad') == 'Recuperación de Datos' ? 'selected' : '' }}>Recuperación de Datos</option>
                            </select>
                            @error('especialidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Estado Activo -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input @error('activo') is-invalid @enderror" 
                                       type="checkbox" 
                                       id="activo" 
                                       name="activo" 
                                       value="1" 
                                       {{ old('activo', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">
                                    <strong>Técnico Activo</strong>
                                </label>
                                @error('activo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block">El técnico podrá recibir asignaciones de reparaciones</small>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Contacto de Emergencia -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3">
                            <i class="fas fa-phone text-warning me-2"></i>
                            Contacto de Emergencia
                        </h5>
                        
                        <div class="mb-3">
                            <label for="contacto_emergencia" class="form-label">Información de Contacto de Emergencia</label>
                            <textarea class="form-control @error('contacto_emergencia') is-invalid @enderror" 
                                      id="contacto_emergencia" 
                                      name="contacto_emergencia" 
                                      rows="3" 
                                      placeholder="Nombre, parentesco, teléfono y dirección del contacto de emergencia">{{ old('contacto_emergencia') }}</textarea>
                            @error('contacto_emergencia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Ej: María López (Madre) - Tel: 1234-5678 - Dirección: Zona 1, Ciudad</small>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Descripción de Habilidades -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3">
                            <i class="fas fa-star text-success me-2"></i>
                            Habilidades y Experiencia
                        </h5>
                        
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción de Habilidades y Experiencia</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" 
                                      name="descripcion" 
                                      rows="4" 
                                      placeholder="Describe las habilidades específicas, certificaciones, experiencia laboral, cursos, etc.">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Opcional: Detalla las habilidades, certificaciones y experiencia del técnico</small>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Información Adicional -->
                <div class="row mb-3">
                    <div class="col-12">
                        <h5 class="mb-3">
                            <i class="fas fa-info-circle text-warning me-2"></i>
                            Información Importante
                        </h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="alert alert-primary">
                                    <i class="fas fa-shield-alt me-2"></i>
                                    <strong>Permisos</strong><br>
                                    <small>El técnico podrá acceder a sus tareas asignadas y actualizar el estado de las reparaciones.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="alert alert-info">
                                    <i class="fas fa-tasks me-2"></i>
                                    <strong>Asignaciones</strong><br>
                                    <small>Se pueden asignar reparaciones basadas en la especialidad del técnico.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="alert alert-success">
                                    <i class="fas fa-chart-line me-2"></i>
                                    <strong>Seguimiento</strong><br>
                                    <small>Se registrarán estadísticas de rendimiento.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tecnicos.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary btn-custom">
                                <i class="fas fa-save me-2"></i>Registrar Técnico
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>

<!-- Modal para Crear Usuario - SIMPLIFICADO Y CENTRADO -->
<div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Header del Modal -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalLabel">
                    <i class="fas fa-user-plus me-2"></i>
                    Crear Nuevo Usuario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <form id="formCrearUsuario">
                    <!-- Nombre Completo -->
                    <div class="mb-3">
                        <label for="modal_name" class="form-label fw-bold">Nombre Completo <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control form-control-lg" 
                               id="modal_name" 
                               name="name" 
                               placeholder="Ingrese el nombre completo"
                               required>
                    </div>

                    <!-- Correo Electrónico -->
                    <div class="mb-3">
                        <label for="modal_email" class="form-label fw-bold">Correo Electrónico <span class="text-danger">*</span></label>
                        <input type="email" 
                               class="form-control form-control-lg" 
                               id="modal_email" 
                               name="email" 
                               placeholder="correo@empresa.com"
                               required>
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label for="modal_password" class="form-label fw-bold">Contraseña <span class="text-danger">*</span></label>
                        <input type="password" 
                               class="form-control form-control-lg" 
                               id="modal_password" 
                               name="password" 
                               placeholder="Mínimo 8 caracteres"
                               minlength="8"
                               required>
                        <div class="form-text">Mínimo 8 caracteres</div>
                    </div>

                    <!-- Rol del Usuario -->
                    <div class="mb-3">
                        <label for="modal_rol" class="form-label fw-bold">Rol del Usuario <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg" id="modal_rol" name="rol" required>
                            <option value="">Seleccione un rol</option>
                            <option value="admin">👑 Administrador</option>
                            <option value="tecnico" selected>🔧 Técnico</option>
                            <option value="usuario">👤 Usuario</option>
                        </select>
                    </div>

                    <!-- Área de Mensajes -->
                    <div id="mensaje-area"></div>
                </form>
            </div>
            
            <!-- Footer del Modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success btn-lg" onclick="crearUsuarioSimple()" id="btnCrearUsuario">
                    <i class="fas fa-user-plus me-1"></i>Crear Usuario
                </button>
                
                <!-- Botón de prueba -->
                <button type="button" class="btn btn-info btn-sm" onclick="probarModal()" title="Probar modal">
                    <i class="fas fa-bug"></i>
                </button>
                
                <!-- Botón de prueba de campos -->
                <button type="button" class="btn btn-warning btn-sm" onclick="probarCampos()" title="Probar campos">
                    <i class="fas fa-keyboard"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Validación del formulario y preview de imagen
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const userSelect = document.getElementById('user_id');
    const especialidadSelect = document.getElementById('especialidad');
    const nombresInput = document.getElementById('nombres');
    const apellidosInput = document.getElementById('apellidos');
    const dpiInput = document.getElementById('dpi');
    const fotoInput = document.getElementById('foto');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    
    // Preview de la foto seleccionada
    fotoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Validar tamaño (2MB máximo)
            if (file.size > 2 * 1024 * 1024) {
                alert('La imagen no puede ser mayor a 2MB');
                this.value = '';
                previewContainer.style.display = 'none';
                return;
            }
            
            // Validar tipo de archivo
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                alert('Solo se permiten archivos JPG, PNG o GIF');
                this.value = '';
                previewContainer.style.display = 'none';
                return;
            }
            
            // Mostrar preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    });
    
    // Formateo automático del DPI
    dpiInput.addEventListener('input', function(e) {
        // Remover todo excepto números
        let value = e.target.value.replace(/\D/g, '');
        
        // Limitar a 13 dígitos (formato DPI Guatemala)
        if (value.length > 13) {
            value = value.substring(0, 13);
        }
        
        e.target.value = value;
    });
    
    // Formateo automático del teléfono
    const telefonoInput = document.getElementById('telefono');
    telefonoInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        // Formato para Guatemala: +502 1234-5678
        if (value.length > 0) {
            if (value.startsWith('502')) {
                value = value.substring(3);
            }
            
            if (value.length <= 4) {
                value = '+502 ' + value;
            } else {
                value = '+502 ' + value.substring(0, 4) + '-' + value.substring(4, 8);
            }
        }
        
        e.target.value = value;
    });
    
            // Validación del formulario
        form.addEventListener('submit', function(e) {
            let valid = true;
            const requiredFields = [userSelect, nombresInput, apellidosInput, especialidadSelect];
            
            // Validar campos obligatorios
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    valid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
        
        // Validar DPI (debe tener 13 dígitos si se proporciona)
        if (dpiInput.value.trim() && dpiInput.value.length !== 13) {
            dpiInput.classList.add('is-invalid');
            valid = false;
            if (!document.querySelector('#dpi-error')) {
                const errorDiv = document.createElement('div');
                errorDiv.id = 'dpi-error';
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = 'El DPI debe tener exactamente 13 dígitos';
                dpiInput.parentNode.appendChild(errorDiv);
            }
        } else {
            const errorDiv = document.querySelector('#dpi-error');
            if (errorDiv) {
                errorDiv.remove();
            }
        }
        
        // Validar email personal si se proporciona
        const emailPersonal = document.getElementById('email_personal');
        if (emailPersonal.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailPersonal.value)) {
                emailPersonal.classList.add('is-invalid');
                valid = false;
            } else {
                emailPersonal.classList.remove('is-invalid');
            }
        }
        
        if (!valid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos obligatorios correctamente.');
            // Scroll al primer campo con error
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
    
    // Limpiar errores al escribir
    document.querySelectorAll('input, select, textarea').forEach(field => {
        field.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
});

// ===== FUNCIONES MEJORADAS PARA EL MODAL DE CREAR USUARIO =====

function abrirModalCrearUsuario() {
    console.log('🚀 Abriendo modal de crear usuario...');
    
    try {
        // Verificar que Bootstrap esté disponible
        if (typeof bootstrap === 'undefined') {
            console.error('❌ Bootstrap no está disponible');
            alert('Error: Bootstrap no está disponible. Por favor, recarga la página.');
            return;
        }
        
        // Limpiar formulario
        document.getElementById('formCrearUsuario').reset();
        document.getElementById('modal_rol').value = 'tecnico';
        document.getElementById('mensaje-area').innerHTML = '';
        
        // Restaurar botón
        restaurarBotonCrear();
        
        // Mostrar modal de forma simple
        const modalElement = document.getElementById('crearUsuarioModal');
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
            
            // Enfocar primer campo después de mostrar
            setTimeout(() => {
                const nombreField = document.getElementById('modal_name');
                if (nombreField) {
                    nombreField.focus();
                    console.log('✅ Campo nombre enfocado');
                }
            }, 200);
            
            console.log('✅ Modal abierto exitosamente');
        } else {
            console.error('❌ No se encontró el modal');
            alert('Error: No se pudo abrir el modal.');
        }
        
    } catch (error) {
        console.error('❌ Error al abrir modal:', error);
        alert('Error al abrir el modal. Por favor, recarga la página.');
    }
}

// Función simple para limpiar validaciones
function limpiarValidaciones() {
    document.querySelectorAll('#crearUsuarioModal .is-invalid').forEach(field => {
        field.classList.remove('is-invalid');
    });
}

// Función simplificada para limpiar formulario
function limpiarFormulario() {
    document.getElementById('formCrearUsuario').reset();
    document.getElementById('modal_rol').value = 'tecnico';
    document.getElementById('mensaje-area').innerHTML = '';
}

function restaurarBotonCrear() {
    const btnCrear = document.getElementById('btnCrearUsuario');
    if (btnCrear) {
        btnCrear.innerHTML = '<i class="fas fa-user-plus me-2"></i>Crear Usuario';
        btnCrear.disabled = false;
        btnCrear.classList.remove('loading');
    }
}

function toggleModalPassword() {
    const field = document.getElementById('modal_password');
    const icon = document.getElementById('modal-password-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function crearUsuarioSimple() {
    console.log('🚀 Iniciando creación de usuario...');
    
    try {
        // Obtener campos del formulario
        const nombre = document.getElementById('modal_name').value.trim();
        const email = document.getElementById('modal_email').value.trim();
        const password = document.getElementById('modal_password').value;
        const rol = document.getElementById('modal_rol').value;
        
        // Validación simple
        if (!nombre || !email || !password || !rol) {
            alert('Por favor, complete todos los campos obligatorios.');
            return;
        }
        
        if (password.length < 8) {
            alert('La contraseña debe tener al menos 8 caracteres.');
            return;
        }
        
        // Confirmación simple
        if (!confirm(`¿Crear usuario "${nombre}" con email "${email}" y rol "${rol}"?`)) {
            return;
        }
        
        // Mostrar estado de carga
        const btnCrear = document.getElementById('btnCrearUsuario');
        btnCrear.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Creando...';
        btnCrear.disabled = true;
        
        // Preparar datos
        const datos = {
            name: nombre,
            email: email,
            password: password,
            rol: rol
        };
        
        // Enviar datos
        enviarDatosUsuarioSimple(datos);
        
    } catch (error) {
        console.error('❌ Error:', error);
        alert('Error inesperado. Por favor, recarga la página.');
        restaurarBotonCrear();
    }
}

// Función simple para preparar datos
function prepararDatos(nombre, email, password, rol) {
    return {
        name: nombre.trim(),
        email: email.trim().toLowerCase(),
        password: password,
        rol: rol
    };
}

function enviarDatosUsuarioSimple(datos) {
    console.log('📤 Enviando datos:', { ...datos, password: '[OCULTA]' });
    
    // Verificar token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('❌ Token CSRF no encontrado');
        alert('Error de seguridad: Token CSRF no encontrado');
        restaurarBotonCrear();
        return;
    }
    
    // Mostrar mensaje de envío
    const mensajeArea = document.getElementById('mensaje-area');
    mensajeArea.innerHTML = '<div class="alert alert-info">Creando usuario...</div>';
    
    fetch('{{ route("usuarios.store-modal") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.content,
            'Accept': 'application/json'
        },
        body: JSON.stringify(datos)
    })
    .then(response => response.json())
    .then(data => {
        console.log('📋 Respuesta:', data);
        
        if (data.success) {
            // Éxito
            mensajeArea.innerHTML = '<div class="alert alert-success">¡Usuario creado exitosamente!</div>';
            
            // Agregar al select
            agregarUsuarioAlSelect(data.user);
            
            // Cerrar modal después de 2 segundos
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('crearUsuarioModal'));
                if (modal) modal.hide();
            }, 2000);
            
        } else {
            // Error
            mensajeArea.innerHTML = `<div class="alert alert-danger">Error: ${data.message}</div>`;
        }
    })
    .catch(error => {
        console.error('❌ Error:', error);
        mensajeArea.innerHTML = '<div class="alert alert-danger">Error de conexión</div>';
    })
    .finally(() => {
        restaurarBotonCrear();
    });
}

function manejarRespuestaServidor(data) {
    if (data.success) {
        console.log('✅ Usuario creado exitosamente:', data.user);
        
        // Agregar usuario al select
        agregarUsuarioAlSelect(data.user);
        
        // Mostrar mensaje de éxito en el modal antes de cerrarlo
        const mensajeArea = document.getElementById('mensaje-area');
        if (mensajeArea) {
            mensajeArea.innerHTML = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>¡Éxito!</strong> ${data.user.name} ha sido registrado exitosamente.
                    <br><small class="text-muted">Ahora completa su información como técnico en el formulario principal.</small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        }
        
        // Limpiar formulario del modal
        limpiarFormularioModal();
        
        // Esperar un momento para que el usuario vea el mensaje
        setTimeout(() => {
            // Cerrar modal
            cerrarModal();
            
            // Mostrar mensaje de éxito global
            mostrarMensajeExito(
                '¡Usuario creado exitosamente!',
                `${data.user.name} ha sido registrado. Ahora completa su información como técnico.`
            );
        }, 2000);
        
        // Enfocar campo siguiente
        enfocarCampoSiguiente();
        
    } else {
        console.error('❌ Error del servidor:', data.message);
        mostrarMensajeError(data.message || 'Error al crear el usuario');
    }
}

function agregarUsuarioAlSelect(usuario) {
    const userSelect = document.getElementById('user_id');
    if (userSelect) {
        // Crear nueva opción
        const newOption = document.createElement('option');
        newOption.value = usuario.id;
        newOption.textContent = `${usuario.name} (${usuario.email})`;
        newOption.selected = true;
        
        // Agregar al select
        userSelect.appendChild(newOption);
        
        // Trigger change event
        userSelect.dispatchEvent(new Event('change'));
        
        // Efecto visual de selección
        userSelect.style.transition = 'all 0.3s ease';
        userSelect.style.borderColor = '#28a745';
        userSelect.style.boxShadow = '0 0 10px rgba(40, 167, 69, 0.3)';
        
        setTimeout(() => {
            userSelect.style.borderColor = '';
            userSelect.style.boxShadow = '';
        }, 3000);
        
        console.log('✅ Usuario agregado al select:', usuario.name);
    } else {
        console.error('❌ Select de usuarios no encontrado');
    }
}

function cerrarModal() {
    const modalElement = document.getElementById('crearUsuarioModal');
    if (modalElement) {
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) {
            modal.hide();
            console.log('✅ Modal cerrado exitosamente');
        } else {
            console.log('⚠️ Modal no encontrado, usando método alternativo');
            $(modalElement).modal('hide');
        }
    }
}

function enfocarCampoSiguiente() {
    setTimeout(() => {
        const nombresField = document.getElementById('nombres');
        if (nombresField) {
            nombresField.focus();
            nombresField.select();
            
            // Efecto visual
            nombresField.style.transition = 'all 0.3s ease';
            nombresField.style.borderColor = '#28a745';
            nombresField.style.boxShadow = '0 0 10px rgba(40, 167, 69, 0.3)';
            
            setTimeout(() => {
                nombresField.style.borderColor = '';
                nombresField.style.boxShadow = '';
            }, 3000);
        }
    }, 500);
}

// ===== FUNCIÓN DE PRUEBA PARA DEBUGGING =====

function probarModal() {
    console.log('🧪 Probando funcionalidad del modal...');
    
    // Verificar elementos del modal
    const elementos = {
        modal: document.getElementById('crearUsuarioModal'),
        form: document.getElementById('formCrearUsuario'),
        nombre: document.getElementById('modal_name'),
        email: document.getElementById('modal_email'),
        password: document.getElementById('modal_password'),
        rol: document.getElementById('modal_rol'),
        mensajeArea: document.getElementById('mensaje-area')
    };
    
    console.log('🔍 Elementos encontrados:', elementos);
    
    // Verificar token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    console.log('🔑 Token CSRF:', csrfToken ? 'Encontrado' : 'No encontrado');
    
    // Verificar Bootstrap
    if (typeof bootstrap !== 'undefined') {
        console.log('✅ Bootstrap disponible');
    } else {
        console.log('❌ Bootstrap no disponible');
    }
    
    // Mostrar mensaje de prueba
    const mensajeArea = document.getElementById('mensaje-area');
    if (mensajeArea) {
        mensajeArea.innerHTML = `
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Prueba del Modal</strong> - Todos los elementos están funcionando correctamente.
                <br><small class="text-muted">Revisa la consola del navegador para más detalles.</small>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
    }
}

// Función para probar campos específicamente
function probarCampos() {
    console.log('⌨️ Probando campos del modal...');
    
    const campos = ['modal_name', 'modal_email', 'modal_password', 'modal_rol'];
    
    campos.forEach(campoId => {
        const campo = document.getElementById(campoId);
        if (campo) {
            const computedStyle = window.getComputedStyle(campo);
            console.log(`📊 Campo ${campoId}:`, {
                disabled: campo.disabled,
                readOnly: campo.readOnly,
                background: computedStyle.background,
                color: computedStyle.color,
                border: computedStyle.border,
                zIndex: computedStyle.zIndex,
                pointerEvents: computedStyle.pointerEvents,
                userSelect: computedStyle.userSelect,
                opacity: computedStyle.opacity,
                filter: computedStyle.filter,
                transform: computedStyle.transform,
                backdropFilter: computedStyle.backdropFilter
            });
            
            // Intentar escribir en el campo
            try {
                campo.focus();
                campo.value = 'PRUEBA';
                console.log(`✅ Campo ${campoId} es editable`);
            } catch (error) {
                console.error(`❌ Error con campo ${campoId}:`, error);
            }
        } else {
            console.error(`❌ Campo ${campoId} no encontrado`);
        }
    });
    
    alert('Revisa la consola para ver el estado de los campos');
}

// Función simplificada para verificar campos
// Función simple para verificar campos
function verificarCampos() {
    const campos = ['modal_name', 'modal_email', 'modal_password', 'modal_rol'];
    campos.forEach(id => {
        const campo = document.getElementById(id);
        if (campo) {
            campo.disabled = false;
            campo.readOnly = false;
        }
    });
}

function probarCreacionDirecta() {
    console.log('🚀 Probando creación directa...');
    
    // Llenar campos de prueba
    const campos = {
        nombre: document.getElementById('modal_name'),
        email: document.getElementById('modal_email'),
        password: document.getElementById('modal_password'),
        rol: document.getElementById('modal_rol')
    };
    
    if (campos.nombre && campos.email && campos.password && campos.rol) {
        // Llenar con datos de prueba
        campos.nombre.value = 'Usuario Prueba';
        campos.email.value = 'prueba@test.com';
        campos.password.value = '12345678';
        campos.rol.value = 'tecnico';
        
        console.log('✅ Campos llenados con datos de prueba');
        
        // Intentar crear usuario directamente
        crearUsuarioMejorado();
    } else {
        console.error('❌ No se pudieron encontrar todos los campos');
        alert('Error: No se pudieron encontrar todos los campos del formulario');
    }
}

// ===== FUNCIONES HELPER PARA MENSAJES =====

function mostrarMensajeError(mensaje) {
    const mensajeArea = document.getElementById('mensaje-area');
    if (mensajeArea) {
        mensajeArea.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Error:</strong> ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Auto-remover después de 8 segundos
        setTimeout(() => {
            const alert = mensajeArea.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 8000);
    }
}

function mostrarMensajeExito(titulo, mensaje) {
    // Mostrar toast de éxito
    showSuccessToast(`${titulo}: ${mensaje}`);
}

function showSuccessToast(message) {
    // Crear o obtener contenedor de toasts
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // Crear toast
    const toastId = 'toast-' + Date.now();
    const toastHtml = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto">Éxito</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body bg-light">
                ${message}
            </div>
        </div>
    `;

    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    
    // Mostrar toast
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        autohide: true,
        delay: 5000
    });
    
    toast.show();
    
    // Eliminar el toast después de que se oculte
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}

// ===== FIN DE FUNCIONES MEJORADAS =====
</script>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/modal-fix.css') }}">
<style>
/* ===== ESTILOS MEJORADOS PARA EL MODAL DE CREAR USUARIO ===== */

/* Modal Principal */
#crearUsuarioModal {
    z-index: 9999 !important;
}

#crearUsuarioModal .modal-dialog {
    max-width: 800px !important;
    margin: 2rem auto !important;
}

#crearUsuarioModal .modal-content {
    border-radius: 20px !important;
    border: none !important;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15) !important;
    overflow: hidden !important;
}

/* Header del Modal */
#crearUsuarioModal .modal-header {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    border-bottom: none !important;
    padding: 2rem !important;
}

#crearUsuarioModal .modal-title {
    font-size: 1.5rem !important;
    font-weight: 700 !important;
    margin: 0 !important;
}

/* Cuerpo del Modal */
#crearUsuarioModal .modal-body {
    padding: 2.5rem !important;
    background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%) !important;
}

/* Icono de Usuario */
.user-icon-container {
    position: relative !important;
}

.user-icon {
    width: 80px !important;
    height: 80px !important;
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    margin: 0 auto !important;
    box-shadow: 0 10px 25px rgba(0, 123, 255, 0.3) !important;
    animation: pulse 2s infinite !important;
}

.user-icon i {
    font-size: 2rem !important;
    color: white !important;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* Formulario y Campos */
#crearUsuarioModal .form-floating {
    margin-bottom: 1.5rem !important;
}

#crearUsuarioModal .form-control,
#crearUsuarioModal .form-select {
    border: 3px solid #e9ecef !important;
    border-radius: 15px !important;
    padding: 1rem 1.25rem !important;
    font-size: 1.1rem !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    background: rgba(255, 255, 255, 0.8) !important;
    backdrop-filter: blur(10px) !important;
}

#crearUsuarioModal .form-control:focus,
#crearUsuarioModal .form-select:focus {
    border-color: #007bff !important;
    box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25) !important;
    background: rgba(255, 255, 255, 1) !important;
    transform: translateY(-2px) !important;
}

#crearUsuarioModal .form-control.is-invalid,
#crearUsuarioModal .form-select.is-invalid {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
    animation: shake 0.5s ease-in-out !important;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* Labels flotantes */
#crearUsuarioModal .form-floating > label {
    font-weight: 600 !important;
    color: #495057 !important;
    font-size: 1rem !important;
}

#crearUsuarioModal .form-floating > label i {
    margin-right: 0.5rem !important;
}

/* Botón de mostrar/ocultar contraseña */
#crearUsuarioModal .input-group .btn {
    border: 3px solid #e9ecef !important;
    border-left: none !important;
    border-radius: 0 15px 15px 0 !important;
    padding: 1rem 1.25rem !important;
    transition: all 0.3s ease !important;
}

#crearUsuarioModal .input-group .btn:hover {
    background-color: #f8f9fa !important;
    border-color: #007bff !important;
}

/* Footer del Modal */
#crearUsuarioModal .modal-footer {
    background: #f8f9fa !important;
    border-top: none !important;
    padding: 2rem !important;
}

/* Botones */
#crearUsuarioModal .btn {
    border-radius: 15px !important;
    padding: 1rem 2.5rem !important;
    font-weight: 600 !important;
    font-size: 1.1rem !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    text-transform: none !important;
    letter-spacing: 0.5px !important;
}

#crearUsuarioModal .btn:hover {
    transform: translateY(-3px) !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2) !important;
}

#crearUsuarioModal .btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    border: none !important;
}

#crearUsuarioModal .btn-success:hover {
    background: linear-gradient(135deg, #218838 0%, #1ea085 100%) !important;
}

/* ===== CORRECCIONES PARA EL MODAL BORROSO ===== */

/* Asegurar que el modal esté por encima de todo */
#crearUsuarioModal {
    z-index: 9999 !important;
}

#crearUsuarioModal .modal-dialog {
    z-index: 10000 !important;
}

#crearUsuarioModal .modal-content {
    z-index: 10001 !important;
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
}

/* Corregir problemas de foco y campos borrosos */
#crearUsuarioModal .form-control,
#crearUsuarioModal .form-select {
    z-index: 10002 !important;
    position: relative;
    background: white !important;
    color: #333 !important;
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
}

#crearUsuarioModal .form-control:focus,
#crearUsuarioModal .form-select:focus {
    z-index: 10003 !important;
    background: white !important;
    color: #333 !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
}

/* Corregir problemas de foco */
#crearUsuarioModal .form-floating {
    position: relative;
    z-index: 10002;
}

#crearUsuarioModal .form-floating > label {
    z-index: 10003;
    background: white;
    padding: 0 0.5rem;
}

/* Asegurar que el modal esté por encima de todo */
.modal-backdrop {
    z-index: 9998 !important;
}

/* Corregir problemas de blur en campos */
#crearUsuarioModal input,
#crearUsuarioModal select {
    filter: none !important;
    -webkit-filter: none !important;
    transform: none !important;
    -webkit-transform: none !important;
}

/* Asegurar que los campos sean interactivos */
#crearUsuarioModal .form-control:not(:disabled),
#crearUsuarioModal .form-select:not(:disabled) {
    pointer-events: auto !important;
    user-select: text !important;
    -webkit-user-select: text !important;
}

#crearUsuarioModal .btn-success.loading {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    cursor: not-allowed !important;
    transform: none !important;
}

/* Alertas y Mensajes */
#crearUsuarioModal .alert {
    border-radius: 15px !important;
    border: none !important;
    padding: 1.5rem !important;
    backdrop-filter: blur(10px) !important;
    margin-bottom: 1.5rem !important;
}

#crearUsuarioModal .alert-info {
    background: rgba(13, 202, 240, 0.1) !important;
    border-left: 4px solid #0dcaf0 !important;
}

#crearUsuarioModal .alert-danger {
    background: rgba(220, 53, 69, 0.1) !important;
    border-left: 4px solid #dc3545 !important;
}

/* Retroalimentación de Validación */
#crearUsuarioModal .invalid-feedback {
    display: block !important;
    width: 100% !important;
    margin-top: 0.5rem !important;
    font-size: 0.95rem !important;
    font-weight: 500 !important;
    color: #dc3545 !important;
    background: rgba(220, 53, 69, 0.1) !important;
    padding: 0.5rem 0.75rem !important;
    border-radius: 10px !important;
    border-left: 3px solid #dc3545 !important;
}

/* Textos de ayuda */
#crearUsuarioModal .text-muted {
    font-size: 0.9rem !important;
    color: #6c757d !important;
    margin-top: 0.5rem !important;
}

/* Animaciones del Modal */
#crearUsuarioModal.fade .modal-dialog {
    transform: translate(0, -50px) scale(0.95) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

#crearUsuarioModal.show .modal-dialog {
    transform: translate(0, 0) scale(1) !important;
}

/* Responsive */
@media (max-width: 768px) {
    #crearUsuarioModal .modal-dialog {
        margin: 1rem !important;
        max-width: calc(100vw - 2rem) !important;
    }
    
    #crearUsuarioModal .modal-body {
        padding: 1.5rem !important;
    }
    
    #crearUsuarioModal .modal-header,
    #crearUsuarioModal .modal-footer {
        padding: 1.5rem !important;
    }
    
    #crearUsuarioModal .form-control,
    #crearUsuarioModal .form-select {
        font-size: 16px !important; /* Previene zoom en iOS */
    }
    
    .user-icon {
        width: 60px !important;
        height: 60px !important;
    }
    
    .user-icon i {
        font-size: 1.5rem !important;
    }
}

/* Estados de Carga */
.loading {
    opacity: 0.7 !important;
    pointer-events: none !important;
}

/* Overlay personalizado */
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.5) !important;
    backdrop-filter: blur(5px) !important;
}

/* Focus visible mejorado */
#crearUsuarioModal *:focus-visible {
    outline: 2px solid #007bff !important;
    outline-offset: 2px !important;
}
</style>
@endsection