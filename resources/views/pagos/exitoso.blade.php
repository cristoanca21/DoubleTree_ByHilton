@extends('layouts.app')
@section('title', 'Pago Exitoso')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-xl p-8 text-center">

        <div class="bg-green-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
            <i class="fa fa-check-circle text-4xl text-green-500"></i>
        </div>

        <h1 class="text-2xl font-bold text-doubletree-navy mb-2">¡Pago exitoso!</h1>
        <p class="text-gray-500 mb-6">Tu reserva ha sido confirmada correctamente.</p>

        <div class="bg-gray-50 rounded-xl p-5 mb-6 text-left space-y-3">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Reserva #</span>
                <span class="font-medium">{{ $reserva->id }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Habitación</span>
                <span class="font-medium">{{ $reserva->habitacion->numero }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Total pagado</span>
                <span class="font-bold text-doubletree-navy">
                    S/ {{ number_format($reserva->total, 2) }}
                </span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Estado</span>
                <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded-full">
                    Confirmada
                </span>
            </div>
        </div>

        <div class="space-y-3">
            <a href="{{ route('reservas.index') }}"
               class="w-full bg-doubletree-navy text-white py-3 rounded-xl font-medium block hover:bg-blue-900 transition">
                <i class="fa fa-list mr-2"></i>Ver mis reservas
            </a>
            <a href="{{ route('habitaciones.index') }}"
               class="w-full bg-gray-100 text-gray-600 py-3 rounded-xl text-sm block hover:bg-gray-200 transition">
                Volver al inicio
            </a>
        </div>
    </div>
</div>
@endsection