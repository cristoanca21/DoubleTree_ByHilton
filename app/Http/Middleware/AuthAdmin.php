<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('cliente')->check()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Debes iniciar sesión para continuar.',
            ]);
        }

        if (!Auth::guard('cliente')->user()->esAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}