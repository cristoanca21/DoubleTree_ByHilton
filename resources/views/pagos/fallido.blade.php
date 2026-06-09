@extends('layouts.app')
@section('title', 'Pago Fallido')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-xl p-8 text-center">

        <div class="bg-red-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
            <i class="fa fa-times-circle text-4xl text-red-500"></i>
        </div>

        <h1 class="text-2xl font-bold text-doubletree-navy mb-2">Pago no completado</h1>
        <p class="text-gray-500 mb-6">
            El pago no pudo procesarse. Tu reserva sigue en estado pendiente.
        </p>

        <div class="space-y-3">
            <a href="{{ route('reservas.index') }}"
               class="w-full bg-doubletree-navy text-white py-3 rounded-xl font-medium block hover:bg-blue-900 transition">
                <i class="fa fa-rotate-right mr-2"></i>Intentar de nuevo
            </a>
            <a href="{{ route('habitaciones.index') }}"
               class="w-full bg-gray-100 text-gray-600 py-3 rounded-xl text-sm block hover:bg-gray-200 transition">
                Volver al inicio
            </a>
        </div>
    </div>
</div>
@endsection