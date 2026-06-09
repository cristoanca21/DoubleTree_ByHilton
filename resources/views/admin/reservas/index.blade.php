@extends('layouts.app')
@section('title', 'Gestión de Reservas')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-doubletree-navy">
            <i class="fa fa-calendar-check mr-2 doubletree-gold"></i>Gestión de Reservas
        </h1>
        <a href="{{ route('admin.dashboard') }}"
           class="text-sm text-gray-500 hover:underline">
            ← Volver al panel
        </a>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-2xl shadow p-5 mb-6">
        <form method="GET" class="flex gap-4 flex-wrap">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select name="estado"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none">
                    <option value="">Todos</option>
                    <option value="pendiente"  {{ request('estado') == 'pendiente'  ? 'selected' : '' }}>Pendiente</option>
                    <option value="confirmada" {{ request('estado') == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                    <option value="en_curso"   {{ request('estado') == 'en_curso'   ? 'selected' : '' }}>En curso</option>
                    <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                    <option value="cancelada"  {{ request('estado') == 'cancelada'  ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                <input type="date" name="fecha" value="{{ request('fecha') }}"
                       class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none">
            </div>
            <div class="flex items-end">
                <button type="submit"
                        class="bg-doubletree-navy text-white px-5 py-2 rounded-lg text-sm hover:bg-blue-900 transition">
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    {{-- Tabla --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-doubletree-navy text-white">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Cliente</th>
                    <th class="px-4 py-3 text-left">Habitación</th>
                    <th class="px-4 py-3 text-left">Ingreso</th>
                    <th class="px-4 py-3 text-left">Salida</th>
                    <th class="px-4 py-3 text-left">Total</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($reservas as $reserva)
                    @php
                        $colores = [
                            'pendiente'  => 'bg-yellow-100 text-yellow-700',
                            'confirmada' => 'bg-green-100 text-green-700',
                            'en_curso'   => 'bg-blue-100 text-blue-700',
                            'completada' => 'bg-gray-100 text-gray-600',
                            'cancelada'  => 'bg-red-100 text-red-700',
                        ];
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-bold text-doubletree-navy">{{ $reserva->id }}</td>
                        <td class="px-4 py-3">
                            <p class="font-medium">{{ $reserva->cliente->nombre }} {{ $reserva->cliente->apellido }}</p>
                            <p class="text-gray-400 text-xs">{{ $reserva->cliente->email }}</p>
                        </td>
                        <td class="px-4 py-3">
                            {{ $reserva->habitacion->numero }}
                            <span class="text-gray-400 text-xs">{{ $reserva->habitacion->tipo->nombre }}</span>
                        </td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($reserva->fecha_ingreso)->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 font-bold">S/ {{ number_format($reserva->total, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $colores[$reserva->estado] }}">
                                {{ ucfirst($reserva->estado) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2 flex-wrap">
                                @if($reserva->estado === 'confirmada')
                                    <form method="POST" action="{{ route('admin.reservas.checkin', $reserva->id) }}">
                                        @csrf
                                        <button type="submit"
                                                class="bg-blue-500 text-white px-3 py-1 rounded-lg text-xs hover:bg-blue-600 transition">
                                            Check-in
                                        </button>
                                    </form>
                                @endif
                                @if($reserva->estado === 'en_curso')
                                    <form method="POST" action="{{ route('admin.reservas.checkout', $reserva->id) }}">
                                        @csrf
                                        <button type="submit"
                                                class="bg-green-500 text-white px-3 py-1 rounded-lg text-xs hover:bg-green-600 transition">
                                            Check-out
                                        </button>
                                    </form>
                                @endif
                                @if(in_array($reserva->estado, ['pendiente', 'confirmada', 'en_curso']))
                                    <form method="POST" action="{{ route('admin.reservas.cancelar', $reserva->id) }}"
                                          onsubmit="return confirm('¿Cancelar esta reserva?')">
                                        @csrf
                                        <input type="hidden" name="motivo" value="Cancelada por administrador">
                                        <button type="submit"
                                                class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-xs hover:bg-red-200 transition">
                                            Cancelar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-5 py-4">
            {{ $reservas->links() }}
        </div>
    </div>
</div>
@endsection