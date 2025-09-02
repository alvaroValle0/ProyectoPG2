<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Solo verificar que el usuario esté autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Permitir acceso a cualquier usuario autenticado
        return $next($request);
    }
}
