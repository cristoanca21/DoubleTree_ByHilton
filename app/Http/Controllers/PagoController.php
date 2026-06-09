<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Pago;
use App\Models\Comprobante;
use Illuminate\Support\Facades\Log;

class PagoController extends Controller
{
    public function iniciar(Reserva $reserva)
    {
        return view('pagos.iniciar', compact('reserva'));
    }

    public function webhook(Request $request)
    {
        Log::info('Webhook MP recibido', $request->all());

        $paymentId = $request->input('data.id');
        if (!$paymentId) {
            return response()->json(['ok' => true]);
        }

        $pago = Pago::where('mp_payment_id', $paymentId)->first();
        if (!$pago) {
            return response()->json(['ok' => true]);
        }

        $status = $request->input('type') === 'payment' ? 'aprobado' : 'rechazado';

        $pago->update([
            'mp_payment_id' => $paymentId,
            'estado'        => $status,
        ]);

        if ($status === 'aprobado') {
            $pago->reserva->update(['estado' => 'confirmada']);
            $this->generarComprobante($pago);
        } else {
            $pago->reserva->update(['estado' => 'cancelada']);
        }

        return response()->json(['ok' => true]);
    }

    public function exitoso(Request $request)
    {
        $reservaId = $request->input('external_reference');
        $reserva   = Reserva::with('comprobante')->findOrFail($reservaId);
        return view('pagos.exitoso', compact('reserva'));
    }

    public function fallido()
    {
        return view('pagos.fallido');
    }

    private function generarComprobante(Pago $pago): void
    {
        $anio      = now()->format('Y');
        $ultimo    = Comprobante::whereYear('created_at', $anio)->count();
        $numero    = 'BOL-' . $anio . '-' . str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);

        Comprobante::create([
            'pago_id'       => $pago->id,
            'reserva_id'    => $pago->reserva_id,
            'numero_boleta' => $numero,
            'estado'        => 'emitido',
        ]);
    }
}