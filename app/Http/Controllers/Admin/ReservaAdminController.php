<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;

class ReservaAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Reserva::with(['cliente', 'habitacion.tipo']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        if ($request->filled('fecha')) {
            $query->whereDate('fecha_ingreso', $request->fecha);
        }

        $reservas = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.reservas.index', compact('reservas'));
    }

    public function checkIn(Reserva $reserva)
    {
        if ($reserva->estado !== 'confirmada') {
            return back()->withErrors(['error' => 'Solo se puede hacer check-in a reservas confirmadas.']);
        }

        $reserva->update([
            'estado'        => 'en_curso',
            'check_in_real' => now(),
        ]);

        $reserva->habitacion->update(['estado' => 'ocupada']);

        return back()->with('success', 'Check-in registrado correctamente.');
    }

    public function checkOut(Reserva $reserva)
    {
        if ($reserva->estado !== 'en_curso') {
            return back()->withErrors(['error' => 'Solo se puede hacer check-out a reservas en curso.']);
        }

        $reserva->update([
            'estado'         => 'completada',
            'check_out_real' => now(),
        ]);

        $reserva->habitacion->update(['estado' => 'disponible']);

        return back()->with('success', 'Check-out registrado correctamente.');
    }

    public function cancelar(Request $request, Reserva $reserva)
    {
        $request->validate([
            'motivo' => 'required|string|max:255',
        ]);

        $reserva->update([
            'estado'             => 'cancelada',
            'motivo_cancelacion' => $request->motivo,
        ]);

        return back()->with('success', 'Reserva cancelada.');
    }
}