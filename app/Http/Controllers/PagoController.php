<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Pago;
use App\Models\Comprobante;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

class PagoController extends Controller
{
    public function __construct()
    {
        MercadoPagoConfig::setAccessToken(env('MP_ACCESS_TOKEN'));
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
    }

    public function iniciar(Reserva $reserva)
    {
        // Verificar que la reserva pertenece al cliente autenticado
        if ($reserva->cliente_id !== auth('cliente')->id()) {
            abort(403);
        }

        // Si ya tiene pago pendiente, redirigir al checkout existente
        if ($reserva->pago && $reserva->pago->mp_preference_id) {
            return redirect("https://sandbox.mercadopago.com.pe/checkout/v1/redirect?pref_id={$reserva->pago->mp_preference_id}");
        }

        try {
            $client = new PreferenceClient();

            $preference = $client->create([
                'items' => [[
                    'id'          => 'HAB-' . $reserva->habitacion->numero,
                    'title'       => 'Reserva — ' . $reserva->habitacion->tipo->nombre
                                     . ' Nº ' . $reserva->habitacion->numero,
                    'description' => 'Check-in: ' . $reserva->fecha_ingreso
                                     . ' | Check-out: ' . $reserva->fecha_salida,
                    'quantity'    => 1,
                    'unit_price'  => (float) $reserva->total,
                    'currency_id' => 'PEN',
                ]],
                'payer' => [
                    'name'    => $reserva->cliente->nombre,
                    'surname' => $reserva->cliente->apellido,
                    'email'   => $reserva->cliente->email,
                ],
                'external_reference' => (string) $reserva->id,
                'back_urls' => [
                    'success' => route('pagos.exitoso'),
                    'failure' => route('pagos.fallido'),
                    'pending' => route('pagos.fallido'),
                ],
                'auto_approve' => true,
                'notification_url' => url('/webhook/mp'),
                'statement_descriptor' => 'DoubleTree Trujillo',
                'expires' => false,
            ]);

            // Guardar o actualizar el pago
            Pago::updateOrCreate(
                ['reserva_id' => $reserva->id],
                [
                    'mp_preference_id' => $preference->id,
                    'monto'            => $reserva->total,
                    'estado'           => 'pendiente',
                    'metodo'           => 'mercadopago',
                ]
            );

            // Redirigir al sandbox de MP
            return redirect($preference->sandbox_init_point);

        } catch (\Exception $e) {
            Log::error('MercadoPago error: ' . $e->getMessage());
            return redirect()->route('reservas.show', $reserva)
                ->withErrors(['error' => 'Error al conectar con MercadoPago. Intenta nuevamente.']);
        }
    }

    public function webhook(Request $request)
    {
        Log::info('Webhook MP recibido', $request->all());

        $tipo      = $request->input('type');
        $paymentId = $request->input('data.id');

        if ($tipo !== 'payment' || !$paymentId) {
            return response()->json(['ok' => true]);
        }

        try {
            MercadoPagoConfig::setAccessToken(env('MP_ACCESS_TOKEN'));
            $client  = new PaymentClient();
            $payment = $client->get((int) $paymentId);

            $preferenceId = $payment->preference_id ?? null;
            $status       = $payment->status ?? 'rejected';

            $pago = Pago::where('mp_preference_id', $preferenceId)->first();

            if (!$pago) {
                Log::warning('Webhook MP: pago no encontrado para preference_id ' . $preferenceId);
                return response()->json(['ok' => true]);
            }

            $estadoPago = match($status) {
                'approved' => 'aprobado',
                'rejected' => 'rechazado',
                default    => 'pendiente',
            };

            $pago->update([
                'mp_payment_id' => $paymentId,
                'estado'        => $estadoPago,
            ]);

            if ($estadoPago === 'aprobado') {
                $pago->reserva->update(['estado' => 'confirmada']);
                $this->generarComprobante($pago);
            } elseif ($estadoPago === 'rechazado') {
                $pago->reserva->update(['estado' => 'pendiente']);
            }

        } catch (\Exception $e) {
            Log::error('Webhook MP error: ' . $e->getMessage());
        }

        return response()->json(['ok' => true]);
    }

    public function exitoso(Request $request)
    {
        $reservaId = $request->input('external_reference');

        if (!$reservaId) {
            return redirect()->route('reservas.index')
                ->with('info', 'Pago procesado. Verificando estado...');
        }

        $reserva = Reserva::with(['comprobante','habitacion.tipo','pago'])
                    ->findOrFail($reservaId);

        return view('pagos.exitoso', compact('reserva'));
    }

    public function fallido(Request $request)
    {
        $reservaId = $request->input('external_reference');
        $reserva   = $reservaId
                        ? Reserva::find($reservaId)
                        : null;

        return view('pagos.fallido', compact('reserva'));
    }

    private function generarComprobante(Pago $pago): void
    {
        // Evitar duplicados
        if (Comprobante::where('pago_id', $pago->id)->exists()) {
            return;
        }

        $anio   = now()->format('Y');
        $ultimo = Comprobante::whereYear('created_at', $anio)->count();
        $numero = 'BOL-' . $anio . '-' . str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);

        Comprobante::create([
            'pago_id'       => $pago->id,
            'reserva_id'    => $pago->reserva_id,
            'numero_boleta' => $numero,
            'estado'        => 'emitido',
            'emitido_at'    => now(),
        ]);
    }
}