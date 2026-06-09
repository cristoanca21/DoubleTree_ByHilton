@extends('layouts.app')
@section('title', 'Reportes')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Título y botón exportar --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-doubletree-navy">
            <i class="fa fa-chart-bar mr-2 doubletree-gold"></i>Reportes
        </h1>
        <div class="flex gap-3">
            <a href="{{ route('admin.reportes.pdf', ['desde' => $desde, 'hasta' => $hasta]) }}"
               target="_blank"
               class="bg-red-500 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-red-600 transition">
                <i class="fa fa-file-pdf mr-2"></i>Exportar PDF
            </a>
            <a href="{{ route('admin.dashboard') }}"
               class="text-sm text-gray-500 hover:underline flex items-center">
                ← Volver al panel
            </a>
        </div>
    </div>

    {{-- Filtro de período --}}
    <div class="bg-white rounded-2xl shadow p-5 mb-6">
        <form method="GET" class="flex gap-4 flex-wrap items-end">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">
                    Desde
                </label>
                <input type="date" name="desde" value="{{ $desde }}"
                       class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">
                    Hasta
                </label>
                <input type="date" name="hasta" value="{{ $hasta }}"
                       class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <button type="submit"
                    class="bg-doubletree-navy text-white px-5 py-2 rounded-lg text-sm hover:bg-blue-900 transition">
                <i class="fa fa-filter mr-1"></i>Aplicar
            </button>
        </form>
    </div>

    {{-- Métricas --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <p class="text-gray-500 text-sm">Ingresos del período</p>
                <i class="fa fa-money-bill-wave doubletree-gold"></i>
            </div>
            <p class="text-3xl font-bold text-doubletree-navy">
                S/ {{ number_format($totalIngresos, 2) }}
            </p>
        </div>
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <p class="text-gray-500 text-sm">Total reservas</p>
                <i class="fa fa-calendar-check doubletree-gold"></i>
            </div>
            <p class="text-3xl font-bold text-doubletree-navy">{{ $totalReservas }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <p class="text-gray-500 text-sm">Hab. ocupadas ahora</p>
                <i class="fa fa-bed doubletree-gold"></i>
            </div>
            <p class="text-3xl font-bold text-doubletree-navy">
                {{ $habitacionesOcupadas }} / {{ $totalHabitaciones }}
            </p>
        </div>
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <p class="text-gray-500 text-sm">Ocupación actual</p>
                <i class="fa fa-chart-pie doubletree-gold"></i>
            </div>
            <p class="text-3xl font-bold text-doubletree-navy">{{ $ocupacion }}%</p>
        </div>
    </div>

    {{-- Fila: estados + tabla --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Reservas por estado --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="font-bold text-doubletree-navy text-lg mb-4">
                Reservas por estado
            </h2>
            <div class="space-y-3">
                @php
                    $estados = [
                        'pendiente'  => ['color' => 'bg-yellow-400', 'label' => 'Pendiente'],
                        'confirmada' => ['color' => 'bg-green-400',  'label' => 'Confirmada'],
                        'en_curso'   => ['color' => 'bg-blue-400',   'label' => 'En curso'],
                        'completada' => ['color' => 'bg-gray-400',   'label' => 'Completada'],
                        'cancelada'  => ['color' => 'bg-red-400',    'label' => 'Cancelada'],
                    ];
                @endphp
                @foreach($estados as $key => $info)
                    @php $cantidad = $reservasPorEstado[$key] ?? 0; @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">{{ $info['label'] }}</span>
                            <span class="font-bold text-doubletree-navy">{{ $cantidad }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5">
                            <div class="{{ $info['color'] }} h-2.5 rounded-full transition-all"
                                 style="width: {{ $totalReservas > 0 ? ($cantidad / $totalReservas * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Resumen rápido --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">
            <h2 class="font-bold text-doubletree-navy text-lg mb-4">
                Últimas reservas del período
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-400 text-xs uppercase border-b">
                            <th class="pb-3">#</th>
                            <th class="pb-3">Cliente</th>
                            <th class="pb-3">Habitación</th>
                            <th class="pb-3">Total</th>
                            <th class="pb-3">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($reservas->take(8) as $r)
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
                                <td class="py-2.5 font-bold text-doubletree-navy">{{ $r->id }}</td>
                                <td class="py-2.5">
                                    {{ $r->cliente->nombre }} {{ $r->cliente->apellido }}
                                </td>
                                <td class="py-2.5">
                                    {{ $r->habitacion->numero }}
                                    <span class="text-gray-400 text-xs">
                                        {{ $r->habitacion->tipo->nombre }}
                                    </span>
                                </td>
                                <td class="py-2.5 font-semibold">
                                    S/ {{ number_format($r->total, 2) }}
                                </td>
                                <td class="py-2.5">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $colores[$r->estado] }}">
                                        {{ ucfirst($r->estado) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-400">
                                    Sin reservas en este período
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection