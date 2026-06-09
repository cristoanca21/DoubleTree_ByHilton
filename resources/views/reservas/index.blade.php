@extends('layouts.app')
@section('title', 'Mis Reservas')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-doubletree-navy mb-6">
        <i class="fa fa-list mr-2 doubletree-gold"></i>Mis Reservas
    </h1>

    @if($reservas->isEmpty())
        <div class="bg-white rounded-2xl shadow p-10 text-center">
            <i class="fa fa-calendar-xmark text-5xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 font-medium">No tienes reservas aún.</p>
            <a href="{{ route('habitaciones.index') }}"
               class="inline-block mt-4 bg-doubletree-gold text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-yellow-600 transition">
                Buscar habitaciones
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($reservas as $reserva)
                <div class="bg-white rounded-2xl shadow p-6 flex flex-col md:flex-row md:items-center gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="font-bold text-doubletree-navy text-lg">
                                Habitación {{ $reserva->habitacion->numero }}
                            </span>
                            <span class="text-sm text-gray-500">
                                {{ $reserva->habitacion->tipo->nombre }}
                            </span>
                            @php
                                $colores = [
                                    'pendiente'  => 'bg-yellow-100 text-yellow-700',
                                    'confirmada' => 'bg-green-100 text-green-700',
                                    'en_curso'   => 'bg-blue-100 text-blue-700',
                                    'completada' => 'bg-gray-100 text-gray-600',
                                    'cancelada'  => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span class="text-xs font-medium px-2 py-1 rounded-full {{ $colores[$reserva->estado] ?? 'bg-gray-100' }}">
                                {{ ucfirst($reserva->estado) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500">
                            <i class="fa fa-calendar mr-1"></i>
                            {{ \Carbon\Carbon::parse($reserva->fecha_ingreso)->format('d/m/Y H:i') }}
                            →
                            {{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('d/m/Y H:i') }}
                        </p>
                        <p class="text-sm font-semibold text-doubletree-navy mt-1">
                            Total: S/ {{ number_format($reserva->total, 2) }}
                        </p>
                    </div>
                    <div class="flex gap-2">
                        @if($reserva->comprobante)
                            <a href="{{ route('comprobantes.show', $reserva->comprobante->id) }}"
                               class="bg-doubletree-navy text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-900 transition">
                                <i class="fa fa-file-pdf mr-1"></i>Comprobante
                            </a>
                        @endif
                        @if(in_array($reserva->estado, ['pendiente', 'confirmada']))
                            <form method="POST"
                                  action="{{ route('reservas.cancelar', $reserva->id) }}"
                                  onsubmit="return confirm('¿Seguro que deseas cancelar esta reserva?')">
                                @csrf
                                <button type="submit"
                                        class="bg-red-100 text-red-700 px-4 py-2 rounded-lg text-sm hover:bg-red-200 transition">
                                    <i class="fa fa-times mr-1"></i>Cancelar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection