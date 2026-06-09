<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitacion;
use App\Models\TipoHabitacion;

class HabitacionController extends Controller
{
    public function index(Request $request)
    {
        $tipos = TipoHabitacion::all();

        $query = Habitacion::with('tipo')->where('estado', 'disponible');

        if ($request->filled('tipo_id')) {
            $query->where('tipo_id', $request->tipo_id);
        }

        if ($request->filled('fecha_ingreso') && $request->filled('fecha_salida')) {
            $ingreso = $request->fecha_ingreso;
            $salida  = $request->fecha_salida;

            $query->whereDoesntHave('reservas', function ($q) use ($ingreso, $salida) {
                $q->whereIn('estado', ['pendiente', 'confirmada', 'en_curso'])
                  ->where('fecha_ingreso', '<', $salida)
                  ->where('fecha_salida',  '>', $ingreso);
            });
        }

        if ($request->filled('huespedes')) {
            $query->whereHas('tipo', function ($q) use ($request) {
                $q->where('capacidad', '>=', $request->huespedes);
            });
        }

        $habitaciones = $query->get();

        return view('habitaciones.index', compact('habitaciones', 'tipos'));
    }

    public function show(Habitacion $habitacion)
    {
        return view('habitaciones.show', compact('habitacion'));
    }
}