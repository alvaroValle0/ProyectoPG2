<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\ReparacionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ConfiguracionController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes (auth required)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/busqueda-rapida', [DashboardController::class, 'busquedaRapida'])->name('dashboard.busqueda-rapida');
    Route::get('/dashboard/estadisticas-api', [DashboardController::class, 'estadisticasApi'])->name('dashboard.estadisticas-api');
    
    // Authentication
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/perfil', [AuthController::class, 'perfil'])->name('perfil');

    // === MÓDULO DE REPARACIONES ===
    
    // Equipos
    Route::prefix('equipos')->name('equipos.')->group(function () {
        Route::get('/', [EquipoController::class, 'index'])->name('index');
        Route::get('/create', [EquipoController::class, 'create'])->name('create');
        Route::post('/', [EquipoController::class, 'store'])->name('store');
        Route::get('/{equipo}', [EquipoController::class, 'show'])->name('show');
        Route::get('/{equipo}/edit', [EquipoController::class, 'edit'])->name('edit');
        Route::put('/{equipo}', [EquipoController::class, 'update'])->name('update');
        Route::delete('/{equipo}', [EquipoController::class, 'destroy'])->name('destroy');
        
        // Acciones especiales
        Route::patch('/{equipo}/cambiar-estado', [EquipoController::class, 'cambiarEstado'])->name('cambiar-estado');
        Route::get('/buscar/equipos', [EquipoController::class, 'buscar'])->name('buscar');
        Route::get('/reportes/general', [EquipoController::class, 'reportes'])->name('reportes');
    });

    // Técnicos
    Route::prefix('tecnicos')->name('tecnicos.')->group(function () {
        Route::get('/', [TecnicoController::class, 'index'])->name('index');
        Route::get('/create', [TecnicoController::class, 'create'])->name('create');
        Route::post('/', [TecnicoController::class, 'store'])->name('store');
        Route::get('/{tecnico}', [TecnicoController::class, 'show'])->name('show');
        Route::get('/{tecnico}/edit', [TecnicoController::class, 'edit'])->name('edit');
        Route::put('/{tecnico}', [TecnicoController::class, 'update'])->name('update');
        Route::delete('/{tecnico}', [TecnicoController::class, 'destroy'])->name('destroy');
        
        // Acciones especiales
        Route::patch('/{tecnico}/activar', [TecnicoController::class, 'activar'])->name('activar');
        Route::patch('/{tecnico}/desactivar', [TecnicoController::class, 'desactivar'])->name('desactivar');
        Route::get('/carga/trabajo', [TecnicoController::class, 'cargaTrabajo'])->name('carga-trabajo');
        Route::get('/{tecnico}/rendimiento', [TecnicoController::class, 'rendimiento'])->name('rendimiento');
    });

    // Reparaciones
    Route::prefix('reparaciones')->name('reparaciones.')->group(function () {
        Route::get('/', [ReparacionController::class, 'index'])->name('index');
        Route::get('/create', [ReparacionController::class, 'create'])->name('create');
        Route::post('/', [ReparacionController::class, 'store'])->name('store');
        Route::get('/{reparacion}', [ReparacionController::class, 'show'])->name('show');
        Route::get('/{reparacion}/edit', [ReparacionController::class, 'edit'])->name('edit');
        Route::put('/{reparacion}', [ReparacionController::class, 'update'])->name('update');
        Route::delete('/{reparacion}', [ReparacionController::class, 'destroy'])->name('destroy');
        
        // Acciones especiales
        Route::patch('/{reparacion}/cambiar-estado', [ReparacionController::class, 'cambiarEstado'])->name('cambiar-estado');
        Route::patch('/{reparacion}/asignar-tecnico', [ReparacionController::class, 'asignarTecnico'])->name('asignar-tecnico');
        Route::get('/mis/tareas', [ReparacionController::class, 'misTareas'])->name('mis-tareas');
        Route::get('/buscar/equipos', [ReparacionController::class, 'buscarEquipos'])->name('buscar-equipos');
        Route::get('/reportes/general', [ReparacionController::class, 'reportes'])->name('reportes');
        Route::get('/{reparacion}/ticket', [ReparacionController::class, 'imprimirTicket'])->name('ticket');
    });

    // Usuarios (Gestión de Usuarios)
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{usuario}', [UserController::class, 'show'])->name('show');
        Route::get('/{usuario}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{usuario}', [UserController::class, 'update'])->name('update');
        Route::delete('/{usuario}', [UserController::class, 'destroy'])->name('destroy');
        
        // Acciones especiales
        Route::patch('/{usuario}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
        
        // API para modal de creación desde otros módulos
        Route::post('/store-modal', [UserController::class, 'storeFromModal'])->name('store-modal');
    });

    // Clientes (Gestión de Clientes)
    Route::prefix('clientes')->name('clientes.')->group(function () {
        Route::get('/', [ClienteController::class, 'index'])->name('index');
        Route::get('/create', [ClienteController::class, 'create'])->name('create');
        Route::post('/', [ClienteController::class, 'store'])->name('store');
        Route::get('/{cliente}', [ClienteController::class, 'show'])->name('show');
        Route::get('/{cliente}/edit', [ClienteController::class, 'edit'])->name('edit');
        Route::put('/{cliente}', [ClienteController::class, 'update'])->name('update');
        Route::delete('/{cliente}', [ClienteController::class, 'destroy'])->name('destroy');
        
        // Acciones especiales
        Route::patch('/{cliente}/toggle-status', [ClienteController::class, 'toggleStatus'])->name('toggle-status');
        
        // API para búsquedas AJAX
        Route::get('/api/search', [ClienteController::class, 'api'])->name('api');
    });

    // Tickets (Gestión de Tickets)
    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('index');
        Route::get('/create', [TicketController::class, 'create'])->name('create');
        Route::post('/', [TicketController::class, 'store'])->name('store');
        Route::get('/{ticket}', [TicketController::class, 'show'])->name('show');
        Route::get('/{ticket}/edit', [TicketController::class, 'edit'])->name('edit');
        Route::put('/{ticket}', [TicketController::class, 'update'])->name('update');
        Route::delete('/{ticket}', [TicketController::class, 'destroy'])->name('destroy');
        
        // Acciones especiales para tickets
        Route::get('/{ticket}/imprimir', [TicketController::class, 'imprimir'])->name('imprimir');
        Route::get('/{ticket}/firmar', [TicketController::class, 'firmar'])->name('firmar');
        Route::post('/{ticket}/procesar-firma', [TicketController::class, 'procesarFirma'])->name('procesar-firma');
        Route::patch('/{ticket}/marcar-entregado', [TicketController::class, 'marcarEntregado'])->name('marcar-entregado');
        Route::patch('/{ticket}/anular', [TicketController::class, 'anular'])->name('anular');
        
        // Generar ticket desde reparación
        Route::post('/generar-desde-reparacion/{reparacion}', [TicketController::class, 'generarDesdeReparacion'])->name('generar-desde-reparacion');
        
        // API para búsquedas AJAX
        Route::get('/api/search', [TicketController::class, 'api'])->name('api');
    });

    // === MÓDULO DE CONFIGURACIÓN ===
    Route::prefix('configuracion')->name('configuracion.')->group(function () {
        Route::get('/', [ConfiguracionController::class, 'index'])->name('index');
        Route::get('/general', [ConfiguracionController::class, 'general'])->name('general');
        Route::post('/general', [ConfiguracionController::class, 'actualizarGeneral'])->name('actualizar-general');
        Route::get('/sistema', [ConfiguracionController::class, 'sistema'])->name('sistema');
        Route::post('/sistema', [ConfiguracionController::class, 'actualizarSistema'])->name('actualizar-sistema');
        Route::get('/notificaciones', [ConfiguracionController::class, 'notificaciones'])->name('notificaciones');
        Route::post('/notificaciones', [ConfiguracionController::class, 'actualizarNotificaciones'])->name('actualizar-notificaciones');
        Route::get('/backup', [ConfiguracionController::class, 'backup'])->name('backup');
        Route::post('/backup/crear', [ConfiguracionController::class, 'crearBackup'])->name('crear-backup');
        Route::get('/backup/descargar/{filename}', [ConfiguracionController::class, 'descargarBackup'])->name('descargar-backup');
        Route::delete('/backup/{filename}', [ConfiguracionController::class, 'eliminarBackup'])->name('eliminar-backup');
        Route::get('/logs', [ConfiguracionController::class, 'logs'])->name('logs');
        Route::post('/logs/limpiar', [ConfiguracionController::class, 'limpiarLogs'])->name('limpiar-logs');
                       Route::get('/logs/descargar/{filename}', [ConfiguracionController::class, 'descargarLog'])->name('descargar-log');
               Route::delete('/logs/{filename}', [ConfiguracionController::class, 'eliminarLog'])->name('eliminar-log');
               Route::post('/colores', [ConfiguracionController::class, 'guardarColores'])->name('guardar-colores');
               Route::get('/colores', [ConfiguracionController::class, 'obtenerColores'])->name('obtener-colores');
    });
});
