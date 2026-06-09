@extends('layouts.app')
@section('title', 'Realizar Reserva')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-xl p-8">

        <h1 class="text-2xl font-bold text-doubletree-navy mb-6">
            <i class="fa fa-calendar-plus mr-2 doubletree-gold"></i>Confirmar Reserva
        </h1>

        {{-- Detalle habitación --}}
        <div class="bg-gray-50 rounded-xl p-4 mb-6 flex items-center gap-4">
            <div class="bg-doubletree-navy rounded-lg p-3">
                <i class="fa fa-bed text-2xl doubletree-gold"></i>
            </div>
            <div>
                <p class="font-bold text-doubletree-navy">
                    Habitación {{ $habitacion->numero }} — {{ $habitacion->tipo->nombre }}
                </p>
                <p class="text-gray-500 text-sm">Piso {{ $habitacion->piso }} · Hasta {{ $habitacion->tipo->capacidad }} personas</p>
                <p class="text-doubletree-navy font-semibold">
                    S/ {{ number_format($habitacion->tipo->precio_noche, 2) }} / noche
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('reservas.store') }}" class="space-y-5" id="formReserva">
            @csrf
            <input type="hidden" name="habitacion_id" value="{{ $habitacion->id }}">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha y hora de ingreso
                    </label>
                    <input type="datetime-local" name="fecha_ingreso"
                           value="{{ request('fecha_ingreso') }}" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           onchange="calcularTotal()">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha y hora de salida
                    </label>
                    <input type="datetime-local" name="fecha_salida"
                           value="{{ request('fecha_salida') }}" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           onchange="calcularTotal()">
                </div>
            </div>

            {{-- Total calculado --}}
            <div class="bg-doubletree-navy rounded-xl p-4 text-white" id="resumenTotal" style="display:none">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-300 text-sm" id="txtNoches"></p>
                        <p class="text-lg font-bold doubletree-gold" id="txtTotal"></p>
                    </div>
                    <i class="fa fa-receipt text-3xl doubletree-gold opacity-50"></i>
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-doubletree-gold text-white py-3 rounded-lg font-bold text-lg hover:bg-yellow-600 transition">
                <i class="fa fa-check mr-2"></i>Confirmar y continuar al pago
            </button>
        </form>

        <a href="{{ route('habitaciones.index') }}"
           class="block text-center text-sm text-gray-500 mt-4 hover:underline">
            ← Volver a habitaciones
        </a>
    </div>
</div>

<script>
const precioNoche = {{ $habitacion->tipo->precio_noche }};

function calcularTotal() {
    const ingreso = document.querySelector('[name="fecha_ingreso"]').value;
    const salida  = document.querySelector('[name="fecha_salida"]').value;
    if (!ingreso || !salida) return;

    const diff   = (new Date(salida) - new Date(ingreso)) / (1000 * 60 * 60 * 24);
    const noches = Math.max(1, Math.round(diff * 10) / 10);
    const total  = noches * precioNoche;

    document.getElementById('txtNoches').textContent = noches + ' noche(s) × S/ ' + precioNoche.toFixed(2);
    document.getElementById('txtTotal').textContent  = 'Total: S/ ' + total.toFixed(2);
    document.getElementById('resumenTotal').style.display = 'block';
}
</script>
@endsection