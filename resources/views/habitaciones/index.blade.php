@extends('layouts.app')
@section('title', 'Habitaciones Disponibles')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Buscador --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-8">
        <h2 class="text-xl font-bold text-doubletree-navy mb-4">
            <i class="fa fa-search mr-2 doubletree-gold"></i>Buscar Habitación
        </h2>
        <form method="GET" action="{{ route('habitaciones.index') }}"
              class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                <select name="tipo_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="">Todos</option>
                    @foreach($tipos as $tipo)
                        <option value="{{ $tipo->id }}"
                            {{ request('tipo_id') == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->nombre }} — S/ {{ number_format($tipo->precio_noche, 2) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha ingreso</label>
                <input type="datetime-local" name="fecha_ingreso"
                       value="{{ request('fecha_ingreso') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha salida</label>
                <input type="datetime-local" name="fecha_salida"
                       value="{{ request('fecha_salida') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Huéspedes</label>
                <input type="number" name="huespedes" min="1" max="4"
                       value="{{ request('huespedes', 1) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div class="md:col-span-4 flex gap-3">
                <button type="submit"
                        class="bg-doubletree-navy text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-blue-900 transition">
                    <i class="fa fa-search mr-2"></i>Buscar
                </button>
                <a href="{{ route('habitaciones.index') }}"
                   class="bg-gray-100 text-gray-600 px-6 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    {{-- Resultados --}}
    <h2 class="text-xl font-bold text-doubletree-navy mb-4">
        {{ $habitaciones->count() }} habitación(es) disponible(s)
    </h2>

    @if($habitaciones->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-xl p-6 text-center">
            <i class="fa fa-bed text-3xl mb-2"></i>
            <p class="font-medium">No hay habitaciones disponibles con esos filtros.</p>
            <a href="{{ route('habitaciones.index') }}" class="text-sm underline mt-2 inline-block">
                Ver todas las habitaciones
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($habitaciones as $hab)
                <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">
                    <div class="bg-doubletree-navy h-32 flex items-center justify-center">
                        <i class="fa fa-bed text-5xl doubletree-gold"></i>
                    </div>
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-bold text-doubletree-navy text-lg">
                                    Habitación {{ $hab->numero }}
                                </h3>
                                <p class="text-gray-500 text-sm">
                                    {{ $hab->tipo->nombre }} · Piso {{ $hab->piso }}
                                </p>
                            </div>
                            <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded-full">
                                Disponible
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mb-3">{{ $hab->tipo->descripcion }}</p>
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fa fa-users text-gray-400 text-sm"></i>
                            <span class="text-sm text-gray-500">Hasta {{ $hab->tipo->capacidad }} personas</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-2xl font-bold text-doubletree-navy">
                                    S/ {{ number_format($hab->tipo->precio_noche, 2) }}
                                </span>
                                <span class="text-gray-400 text-sm">/noche</span>
                            </div>
                            <a href="{{ route('reservas.create', ['habitacion_id' => $hab->id]) }}"
                               class="bg-doubletree-gold text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-yellow-600 transition">
                                Reservar
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection