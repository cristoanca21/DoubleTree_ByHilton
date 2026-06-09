<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Pago;
use App\Models\Habitacion;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $desde = $request->input('desde', now()->startOfMonth()->toDateString());
        $hasta = $request->input('hasta', now()->toDateString());

        $totalIngresos = Pago::where('estado', 'aprobado')
            ->whereBetween('created_at', [$desde, $hasta . ' 23:59:59'])
            ->sum('monto');

        $totalReservas = Reserva::whereBetween('created_at', [$desde, $hasta . ' 23:59:59'])
            ->count();

        $reservasPorEstado = Reserva::selectRaw('estado, count(*) as total')
            ->whereBetween('created_at', [$desde, $hasta . ' 23:59:59'])
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $habitacionesOcupadas = Habitacion::where('estado', 'ocupada')->count();
        $totalHabitaciones    = Habitacion::count();
        $ocupacion            = $totalHabitaciones > 0
            ? round(($habitacionesOcupadas / $totalHabitaciones) * 100, 1)
            : 0;

        $reservas = Reserva::with(['cliente', 'habitacion.tipo', 'pago'])
            ->whereBetween('created_at', [$desde, $hasta . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.reportes.index', compact(
            'totalIngresos', 'totalReservas', 'reservasPorEstado',
            'habitacionesOcupadas', 'totalHabitaciones', 'ocupacion',
            'desde', 'hasta', 'reservas'
        ));
    }

    public function exportarPDF(Request $request)
    {
        $desde = $request->input('desde', now()->startOfMonth()->toDateString());
        $hasta = $request->input('hasta', now()->toDateString());

        $totalIngresos = Pago::where('estado', 'aprobado')
            ->whereBetween('created_at', [$desde, $hasta . ' 23:59:59'])
            ->sum('monto');

        $totalReservas = Reserva::whereBetween('created_at', [$desde, $hasta . ' 23:59:59'])
            ->count();

        $reservasPorEstado = Reserva::selectRaw('estado, count(*) as total')
            ->whereBetween('created_at', [$desde, $hasta . ' 23:59:59'])
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $habitacionesOcupadas = Habitacion::where('estado', 'ocupada')->count();
        $totalHabitaciones    = Habitacion::count();
        $ocupacion            = $totalHabitaciones > 0
            ? round(($habitacionesOcupadas / $totalHabitaciones) * 100, 1)
            : 0;

        $reservas = Reserva::with(['cliente', 'habitacion.tipo', 'pago'])
            ->whereBetween('created_at', [$desde, $hasta . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.reportes.pdf', compact(
            'totalIngresos', 'totalReservas', 'reservasPorEstado',
            'habitacionesOcupadas', 'totalHabitaciones', 'ocupacion',
            'desde', 'hasta', 'reservas'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('reporte-' . $desde . '-al-' . $hasta . '.pdf');
    }
}