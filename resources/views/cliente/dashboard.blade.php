@extends('layouts.app')
@section('title', 'Mi Dashboard')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">

    {{-- Bienvenida --}}
    <div class="bg-doubletree-navy rounded-2xl p-8 mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white mb-1">
                Bienvenido, {{ Auth::guard('cliente')->user()->nombre }}
            </h1>
            <p class="text-gray-300 text-sm">
                DoubleTree by Hilton Trujillo — Panel de cliente
            </p>
        </div>
        <i class="fa fa-user-circle text-6xl doubletree-gold opacity-60"></i>
    </div>

    {{-- Accesos rápidos --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('habitaciones.index') }}"
           class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition group">
            <div class="bg-doubletree-navy rounded-xl p-4 inline-block mb-4 group-hover:bg-blue-900 transition">
                <i class="fa fa-bed text-2xl doubletree-gold"></i>
            </div>
            <h3 class="font-bold text-doubletree-navy text-lg">Buscar habitación</h3>
            <p class="text-gray-500 text-sm mt-1">Ver disponibilidad y reservar</p>
        </a>

        <a href="{{ route('reservas.index') }}"
           class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition group">
            <div class="bg-doubletree-navy rounded-xl p-4 inline-block mb-4 group-hover:bg-blue-900 transition">
                <i class="fa fa-calendar text-2xl doubletree-gold"></i>
            </div>
            <h3 class="font-bold text-doubletree-navy text-lg">Mis reservas</h3>
            <p class="text-gray-500 text-sm mt-1">Ver historial y estado</p>
        </a>

        <div class="bg-white rounded-2xl shadow p-6">
            <div class="bg-doubletree-navy rounded-xl p-4 inline-block mb-4">
                <i class="fa fa-file-invoice text-2xl doubletree-gold"></i>
            </div>
            <h3 class="font-bold text-doubletree-navy text-lg">Mis comprobantes</h3>
            <p class="text-gray-500 text-sm mt-1">Descargar boletas de pago</p>
        </div>
    </div>

    {{-- Info del hotel --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="font-bold text-doubletree-navy text-lg mb-4">
            <i class="fa fa-circle-info mr-2 doubletree-gold"></i>Información del hotel
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
            <div class="flex items-center gap-3">
                <i class="fa fa-location-dot doubletree-gold text-lg"></i>
                <span>Av. El Golf 591, Trujillo, Perú</span>
            </div>
            <div class="flex items-center gap-3">
                <i class="fa fa-star doubletree-gold text-lg"></i>
                <span>4 estrellas · Valoración 9.1/10</span>
            </div>
            <div class="flex items-center gap-3">
                <i class="fa fa-plane doubletree-gold text-lg"></i>
                <span>11 km del aeropuerto</span>
            </div>
        </div>
    </div>
</div>
@endsection