<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Reparacion;
use App\Models\Tecnico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $estadisticas = [
            'equipos' => [
                'total' => Equipo::count(),
                'recibidos' => Equipo::recibidos()->count(),
                'en_reparacion' => Equipo::enReparacion()->count(),
                'reparados' => Equipo::reparados()->count(),
                'entregados' => Equipo::entregados()->count(),
            ],
            'reparaciones' => [
                'total' => Reparacion::count(),
                'pendientes' => Reparacion::pendientes()->count(),
                'en_proceso' => Reparacion::enProceso()->count(),
                'completadas' => Reparacion::completadas()->count(),
                'vencidas' => Reparacion::whereIn('estado', ['pendiente', 'en_proceso'])
                    ->where('fecha_inicio', '<', now()->subDays(7))
                    ->count(),
            ],
            'tecnicos' => [
                'total' => Tecnico::count(),
                'activos' => Tecnico::activos()->count(),
            ]
        ];

        // Equipos recientes (últimos 10)
        $equiposRecientes = Equipo::with(['reparacionActual.tecnico.user'])
            ->orderBy('fecha_ingreso', 'desc')
            ->limit(10)
            ->get();

        // Reparaciones urgentes (vencidas o próximas a vencer)
        $reparacionesUrgentes = Reparacion::with(['equipo', 'tecnico.user'])
            ->whereIn('estado', ['pendiente', 'en_proceso'])
            ->where('fecha_inicio', '<', now()->subDays(5))
            ->orderBy('fecha_inicio')
            ->limit(10)
            ->get();



        // Actividad reciente (últimas reparaciones completadas)
        $actividadReciente = Reparacion::with(['equipo', 'tecnico.user'])
            ->where('estado', 'completada')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        // Gráfico de equipos por estado (para el dashboard)
        $equiposPorEstado = Equipo::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->estado => $item->total];
            });

        // Gráfico de reparaciones por mes (últimos 6 meses)
        $reparacionesPorMes = Reparacion::select(
                DB::raw('DATE_FORMAT(fecha_inicio, "%Y-%m") as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->where('fecha_inicio', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->mes => $item->total];
            });

        return view('dashboard', compact(
            'estadisticas',
            'equiposRecientes',
            'reparacionesUrgentes',
            'actividadReciente',
            'equiposPorEstado',
            'reparacionesPorMes'
        ));
    }

    public function busquedaRapida(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json(['resultados' => []]);
        }

        $resultados = [];

        // Buscar equipos
        $equipos = Equipo::where('numero_serie', 'like', "%{$query}%")
            ->orWhere('cliente_nombre', 'like', "%{$query}%")
            ->orWhere('marca', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'numero_serie', 'marca', 'modelo', 'cliente_nombre', 'estado']);

        foreach ($equipos as $equipo) {
            $resultados[] = [
                'tipo' => 'equipo',
                'id' => $equipo->id,
                'titulo' => $equipo->numero_serie,
                'subtitulo' => "{$equipo->marca} {$equipo->modelo} - {$equipo->cliente_nombre}",
                'estado' => $equipo->estado,
                'url' => route('equipos.show', $equipo)
            ];
        }

        // Buscar reparaciones por ID o descripción
        $reparaciones = Reparacion::with(['equipo', 'tecnico.user'])
            ->where('id', 'like', "%{$query}%")
            ->orWhere('descripcion_problema', 'like', "%{$query}%")
            ->orWhereHas('equipo', function($q) use ($query) {
                $q->where('numero_serie', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get();

        foreach ($reparaciones as $reparacion) {
            $resultados[] = [
                'tipo' => 'reparacion',
                'id' => $reparacion->id,
                'titulo' => "Reparación #{$reparacion->id}",
                'subtitulo' => $reparacion->equipo->numero_serie . " - " . substr($reparacion->descripcion_problema, 0, 50),
                'estado' => $reparacion->estado,
                'url' => route('reparaciones.show', $reparacion)
            ];
        }

        return response()->json(['resultados' => $resultados]);
    }

    public function estadisticasApi()
    {
        $equiposPorMes = Equipo::select(
                DB::raw('DATE_FORMAT(fecha_ingreso, "%Y-%m") as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->where('fecha_ingreso', '>=', now()->subMonths(12))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $reparacionesPorEstado = Reparacion::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get();

        $tecnicosRendimiento = Tecnico::with('user')
            ->withCount(['reparacionesCompletadas'])
            ->having('reparaciones_completadas_count', '>', 0)
            ->orderBy('reparaciones_completadas_count', 'desc')
            ->get();

        return response()->json([
            'equipos_por_mes' => $equiposPorMes,
            'reparaciones_por_estado' => $reparacionesPorEstado,
            'tecnicos_rendimiento' => $tecnicosRendimiento
        ]);
    }
}