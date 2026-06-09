<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Habitacion;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function create(Request $request)
    {
        $habitacion = Habitacion::with('tipo')->findOrFail($request->habitacion_id);
        return view('reservas.create', compact('habitacion'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'habitacion_id'  => 'required|exists:habitaciones,id',
            'fecha_ingreso'  => 'required|date|after:now',
            'fecha_salida'   => 'required|date|after:fecha_ingreso',
        ]);

        $habitacion = Habitacion::findOrFail($request->habitacion_id);

        // Verificar disponibilidad
        $solapada = Reserva::where('habitacion_id', $request->habitacion_id)
            ->whereIn('estado', ['pendiente', 'confirmada', 'en_curso'])
            ->where('fecha_ingreso', '<', $request->fecha_salida)
            ->where('fecha_salida',  '>', $request->fecha_ingreso)
            ->exists();

        if ($solapada) {
            return back()->withErrors(['habitacion_id' => 'La habitación no está disponible en esas fechas.']);
        }

        // Calcular total
        $ingreso = \Carbon\Carbon::parse($request->fecha_ingreso);
        $salida  = \Carbon\Carbon::parse($request->fecha_salida);
        $noches  = max(1, $ingreso->diffInDays($salida));
        $total   = $noches * $habitacion->tipo->precio_noche;

        $reserva = Reserva::create([
            'cliente_id'            => Auth::guard('cliente')->id(),
            'habitacion_id'         => $habitacion->id,
            'fecha_ingreso'         => $request->fecha_ingreso,
            'fecha_salida'          => $request->fecha_salida,
            'precio_noche_aplicado' => $habitacion->tipo->precio_noche,
            'total'                 => $total,
            'estado'                => 'pendiente',
        ]);

        return redirect()->route('pagos.iniciar', $reserva->id);
    }

    public function index()
    {
        $reservas = Reserva::with(['habitacion.tipo'])
            ->where('cliente_id', Auth::guard('cliente')->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reservas.index', compact('reservas'));
    }

    public function show(Reserva $reserva)
{
    // Verificar que la reserva pertenece al cliente autenticado
    if ($reserva->cliente_id !== Auth::guard('cliente')->id()) {
        abort(403, 'No tienes permiso para ver esta reserva.');
    }

    return view('reservas.show', compact('reserva'));
}

public function cancelar(Request $request, Reserva $reserva)
{
    // Verificar que la reserva pertenece al cliente autenticado
    if ($reserva->cliente_id !== Auth::guard('cliente')->id()) {
        abort(403, 'No tienes permiso para cancelar esta reserva.');
    }

    if (!in_array($reserva->estado, ['pendiente', 'confirmada'])) {
        return back()->withErrors(['error' => 'Esta reserva no puede cancelarse.']);
    }

    $reserva->update([
        'estado'             => 'cancelada',
        'motivo_cancelacion' => $request->motivo ?? 'Cancelada por el cliente',
    ]);

    return redirect()->route('reservas.index')
        ->with('success', 'Reserva cancelada correctamente.');
    }
}