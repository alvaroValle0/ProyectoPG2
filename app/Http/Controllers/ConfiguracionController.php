<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ConfiguracionController extends Controller
{
    public function index()
    {
        // Obtener configuraciones del sistema
        $configuraciones = $this->obtenerConfiguraciones();
        
        // Estadísticas del sistema
        $estadisticas = [
            'total_usuarios' => \App\Models\User::count(),
            'usuarios_activos' => \App\Models\User::where('activo', true)->count(),
            'total_equipos' => \App\Models\Equipo::count(),
            'reparaciones_pendientes' => \App\Models\Reparacion::where('estado', 'pendiente')->count(),
            'tecnicos_activos' => \App\Models\Tecnico::where('activo', true)->count(),
            'clientes_activos' => \App\Models\Cliente::where('activo', true)->count(),
        ];

        return view('configuracion.index', compact('configuraciones', 'estadisticas'));
    }

    public function general()
    {
        $configuraciones = $this->obtenerConfiguraciones();
        return view('configuracion.general', compact('configuraciones'));
    }

    public function actualizarGeneral(Request $request)
    {
        $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'direccion_empresa' => 'nullable|string|max:500',
            'telefono_empresa' => 'nullable|string|max:20',
            'email_empresa' => 'nullable|email|max:255',
            'sitio_web' => 'nullable|url|max:255',
            'moneda' => 'required|string|max:10',
            'zona_horaria' => 'required|string|max:50',
            'idioma' => 'required|string|max:10',
        ]);

        $configuraciones = [
            'nombre_empresa' => $request->nombre_empresa,
            'direccion_empresa' => $request->direccion_empresa,
            'telefono_empresa' => $request->telefono_empresa,
            'email_empresa' => $request->email_empresa,
            'sitio_web' => $request->sitio_web,
            'moneda' => $request->moneda,
            'zona_horaria' => $request->zona_horaria,
            'idioma' => $request->idioma,
        ];

        $this->guardarConfiguraciones($configuraciones);

        return redirect()->route('configuracion.general')
            ->with('success', 'Configuración general actualizada correctamente.');
    }

    public function sistema()
    {
        $configuraciones = $this->obtenerConfiguraciones();
        return view('configuracion.sistema', compact('configuraciones'));
    }

    public function actualizarSistema(Request $request)
    {
        $request->validate([
            'mantenimiento' => 'boolean',
            'registro_usuarios' => 'boolean',
            'verificacion_email' => 'boolean',
            'sesion_tiempo' => 'required|integer|min:15|max:480',
            'max_intentos_login' => 'required|integer|min:3|max:10',
            'backup_automatico' => 'boolean',
            'frecuencia_backup' => 'required_if:backup_automatico,1|string',
        ]);

        $configuraciones = [
            'mantenimiento' => $request->has('mantenimiento'),
            'registro_usuarios' => $request->has('registro_usuarios'),
            'verificacion_email' => $request->has('verificacion_email'),
            'sesion_tiempo' => $request->sesion_tiempo,
            'max_intentos_login' => $request->max_intentos_login,
            'backup_automatico' => $request->has('backup_automatico'),
            'frecuencia_backup' => $request->frecuencia_backup,
        ];

        $this->guardarConfiguraciones($configuraciones);

        return redirect()->route('configuracion.sistema')
            ->with('success', 'Configuración del sistema actualizada correctamente.');
    }

    public function notificaciones()
    {
        $configuraciones = $this->obtenerConfiguraciones();
        return view('configuracion.notificaciones', compact('configuraciones'));
    }

    public function actualizarNotificaciones(Request $request)
    {
        $request->validate([
            'email_notificaciones' => 'boolean',
            'notif_nuevas_reparaciones' => 'boolean',
            'notif_reparaciones_completadas' => 'boolean',
            'notif_equipos_vencidos' => 'boolean',
            'notif_backup' => 'boolean',
            'notif_errores' => 'boolean',
        ]);

        $configuraciones = [
            'email_notificaciones' => $request->has('email_notificaciones'),
            'notif_nuevas_reparaciones' => $request->has('notif_nuevas_reparaciones'),
            'notif_reparaciones_completadas' => $request->has('notif_reparaciones_completadas'),
            'notif_equipos_vencidos' => $request->has('notif_equipos_vencidos'),
            'notif_backup' => $request->has('notif_backup'),
            'notif_errores' => $request->has('notif_errores'),
        ];

        $this->guardarConfiguraciones($configuraciones);

        return redirect()->route('configuracion.notificaciones')
            ->with('success', 'Configuración de notificaciones actualizada correctamente.');
    }

    public function backup()
    {
        $backups = $this->obtenerBackups();
        return view('configuracion.backup', compact('backups'));
    }

    public function crearBackup()
    {
        try {
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $path = storage_path('app/backups/' . $filename);
            
            // Crear directorio si no existe
            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }

            // Comando para crear backup (requiere mysqldump)
            $command = sprintf(
                'mysqldump -h%s -P%s -u%s -p%s %s > %s',
                config('database.connections.mysql.host'),
                config('database.connections.mysql.port'),
                config('database.connections.mysql.username'),
                config('database.connections.mysql.password'),
                config('database.connections.mysql.database'),
                $path
            );

            exec($command, $output, $returnCode);

            if ($returnCode === 0) {
                return redirect()->route('configuracion.backup')
                    ->with('success', 'Backup creado correctamente: ' . $filename);
            } else {
                return redirect()->route('configuracion.backup')
                    ->with('error', 'Error al crear el backup. Verifica que mysqldump esté instalado.');
            }
        } catch (\Exception $e) {
            return redirect()->route('configuracion.backup')
                ->with('error', 'Error al crear el backup: ' . $e->getMessage());
        }
    }

    public function descargarBackup($filename)
    {
        $path = storage_path('app/backups/' . $filename);
        
        if (file_exists($path)) {
            return response()->download($path);
        }
        
        return redirect()->route('configuracion.backup')
            ->with('error', 'Archivo de backup no encontrado.');
    }

    public function eliminarBackup($filename)
    {
        $path = storage_path('app/backups/' . $filename);
        
        if (file_exists($path) && unlink($path)) {
            return redirect()->route('configuracion.backup')
                ->with('success', 'Backup eliminado correctamente.');
        }
        
        return redirect()->route('configuracion.backup')
            ->with('error', 'Error al eliminar el backup.');
    }

    public function logs()
    {
        $logs = $this->obtenerLogs();
        return view('configuracion.logs', compact('logs'));
    }

    public function limpiarLogs()
    {
        try {
            // Limpiar logs de Laravel
            $logPath = storage_path('logs');
            $files = glob($logPath . '/*.log');
            
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }

            return redirect()->route('configuracion.logs')
                ->with('success', 'Logs del sistema limpiados correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('configuracion.logs')
                ->with('error', 'Error al limpiar los logs: ' . $e->getMessage());
        }
    }

    public function descargarLog($filename)
    {
        $path = storage_path('logs/' . $filename);
        
        if (file_exists($path)) {
            return response()->download($path);
        }
        
        return redirect()->route('configuracion.logs')
            ->with('error', 'Archivo de log no encontrado.');
    }

    public function eliminarLog($filename)
    {
        $path = storage_path('logs/' . $filename);
        
        if (file_exists($path) && unlink($path)) {
            return redirect()->route('configuracion.logs')
                ->with('success', 'Log eliminado correctamente.');
        }
        
        return redirect()->route('configuracion.logs')
            ->with('error', 'Error al eliminar el log.');
    }

    public function guardarColores(Request $request)
    {
        $request->validate([
            'primary' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'secondary' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'success' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'warning' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'danger' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'info' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'scope' => 'nullable|in:global,module',
            'module' => 'nullable|string',
        ]);

        $colores = [
            'primary' => $request->primary,
            'secondary' => $request->secondary,
            'success' => $request->success,
            'warning' => $request->warning,
            'danger' => $request->danger,
            'info' => $request->info,
        ];

        // Guardar en cache, global o por módulo
        $scope = $request->input('scope', 'global');
        $module = $request->input('module');

        if ($scope === 'module' && !empty($module)) {
            Cache::put('sistema_colores_' . $module, $colores, now()->addYear());
        } else {
            Cache::put('sistema_colores', $colores, now()->addYear());
        }

        return response()->json([
            'success' => true,
            'message' => 'Colores guardados correctamente',
            'colores' => $colores,
            'scope' => $scope,
            'module' => $module,
        ]);
    }

    public function obtenerColores(Request $request)
    {
        $module = $request->query('module');

        if (!empty($module)) {
            $coloresModulo = Cache::get('sistema_colores_' . $module);
            if ($coloresModulo) {
                return response()->json($coloresModulo);
            }
        }

        $colores = Cache::get('sistema_colores', [
            'primary' => '#667eea',
            'secondary' => '#764ba2',
            'success' => '#28a745',
            'warning' => '#ffc107',
            'danger' => '#dc3545',
            'info' => '#17a2b8'
        ]);

        return response()->json($colores);
    }

    private function obtenerConfiguraciones()
    {
        // Configuraciones por defecto
        $defaults = [
            'nombre_empresa' => 'Gestión HDC',
            'direccion_empresa' => '',
            'telefono_empresa' => '',
            'email_empresa' => '',
            'sitio_web' => '',
            'moneda' => 'GTQ',
            'zona_horaria' => 'America/Guatemala',
            'idioma' => 'es',
            'mantenimiento' => false,
            'registro_usuarios' => true,
            'verificacion_email' => false,
            'sesion_tiempo' => 120,
            'max_intentos_login' => 5,
            'backup_automatico' => false,
            'frecuencia_backup' => 'daily',
            'email_notificaciones' => true,
            'notif_nuevas_reparaciones' => true,
            'notif_reparaciones_completadas' => true,
            'notif_equipos_vencidos' => true,
            'notif_backup' => true,
            'notif_errores' => true,
        ];

        // Obtener configuraciones guardadas (aquí podrías usar una tabla de configuraciones)
        // Por ahora usamos cache
        $saved = Cache::get('sistema_configuraciones', []);
        
        return array_merge($defaults, $saved);
    }

    private function guardarConfiguraciones($configuraciones)
    {
        // Guardar en cache (en producción deberías usar una tabla de base de datos)
        Cache::put('sistema_configuraciones', $configuraciones, now()->addYear());
    }

    private function obtenerBackups()
    {
        $backupPath = storage_path('app/backups');
        $backups = [];
        
        if (is_dir($backupPath)) {
            $files = glob($backupPath . '/*.sql');
            
            foreach ($files as $file) {
                $backups[] = [
                    'nombre' => basename($file),
                    'tamaño' => $this->formatearTamaño(filesize($file)),
                    'fecha' => date('Y-m-d H:i:s', filemtime($file)),
                    'ruta' => $file
                ];
            }
            
            // Ordenar por fecha más reciente
            usort($backups, function($a, $b) {
                return strtotime($b['fecha']) - strtotime($a['fecha']);
            });
        }
        
        return $backups;
    }

    private function obtenerLogs()
    {
        $logPath = storage_path('logs');
        $logs = [];
        
        if (is_dir($logPath)) {
            $files = glob($logPath . '/*.log');
            
            foreach ($files as $file) {
                $logs[] = [
                    'nombre' => basename($file),
                    'tamaño' => $this->formatearTamaño(filesize($file)),
                    'fecha' => date('Y-m-d H:i:s', filemtime($file)),
                    'ruta' => $file
                ];
            }
            
            // Ordenar por fecha más reciente
            usort($logs, function($a, $b) {
                return strtotime($b['fecha']) - strtotime($a['fecha']);
            });
        }
        
        return $logs;
    }

    private function formatearTamaño($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
