<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Habitacion;
use App\Models\TipoHabitacion;

class HabitacionAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Habitacion::with('tipo');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        if ($request->filled('tipo_id')) {
            $query->where('tipo_id', $request->tipo_id);
        }

        $habitaciones = $query->orderBy('numero')->paginate(20);
        $tipos        = TipoHabitacion::all();

        return view('admin.habitaciones.index', compact('habitaciones', 'tipos'));
    }

    public function cambiarEstado(Request $request, Habitacion $habitacion)
    {
        $request->validate([
            'estado' => 'required|in:disponible,ocupada,mantenimiento',
        ]);

        if ($request->estado === 'mantenimiento') {
            $tieneReservas = $habitacion->reservas()
                ->whereIn('estado', ['confirmada', 'en_curso'])
                ->exists();

            if ($tieneReservas) {
                return back()->withErrors(['error' => 'La habitación tiene reservas activas.']);
            }
        }

        $habitacion->update(['estado' => $request->estado]);

        return back()->with('success', 'Estado actualizado correctamente.');
    }
}