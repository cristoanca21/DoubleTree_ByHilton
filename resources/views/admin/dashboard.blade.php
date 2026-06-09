@extends('layouts.app')
@section('title', 'Panel Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Bienvenida --}}
    <div class="bg-doubletree-navy rounded-2xl p-8 mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white mb-1">
                Panel de Administración
            </h1>
            <p class="text-gray-300 text-sm">
                Bienvenido, {{ Auth::guard('cliente')->user()->nombre }}
            </p>
        </div>
        <i class="fa fa-gear text-6xl doubletree-gold opacity-60"></i>
    </div>

    {{-- Accesos rápidos --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.habitaciones.index') }}"
           class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition group">
            <div class="bg-doubletree-navy rounded-xl p-4 inline-block mb-4 group-hover:bg-blue-900 transition">
                <i class="fa fa-bed text-2xl doubletree-gold"></i>
            </div>
            <h3 class="font-bold text-doubletree-navy text-lg">Habitaciones</h3>
            <p class="text-gray-500 text-sm mt-1">Gestionar estados y disponibilidad</p>
        </a>

        <a href="{{ route('admin.reservas.index') }}"
           class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition group">
            <div class="bg-doubletree-navy rounded-xl p-4 inline-block mb-4 group-hover:bg-blue-900 transition">
                <i class="fa fa-calendar-check text-2xl doubletree-gold"></i>
            </div>
            <h3 class="font-bold text-doubletree-navy text-lg">Reservas</h3>
            <p class="text-gray-500 text-sm mt-1">Check-in, check-out y cancelaciones</p>
        </a>

        <a href="{{ route('admin.reportes.index') }}"
           class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition group">
            <div class="bg-doubletree-navy rounded-xl p-4 inline-block mb-4 group-hover:bg-blue-900 transition">
                <i class="fa fa-chart-bar text-2xl doubletree-gold"></i>
            </div>
            <h3 class="font-bold text-doubletree-navy text-lg">Reportes</h3>
            <p class="text-gray-500 text-sm mt-1">Ingresos y ocupación del hotel</p>
        </a>
    </div>

</div>
@endsection