@extends('layouts.app')
@section('title', 'Crear Cuenta')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-8">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-doubletree-navy">Crear Cuenta</h1>
            <p class="text-gray-500 text-sm mt-1">DoubleTree by Hilton Trujillo</p>
        </div>

        <form method="POST" action="{{ route('registro') }}" class="space-y-4" autocomplete="off">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required
                           autocomplete="off"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                    <input type="text" name="apellido" value="{{ old('apellido') }}" required
                           autocomplete="off"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       autocomplete="new-password"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">DNI / Pasaporte</label>
                <input type="text" name="dni" value="{{ old('dni') }}" required
                       autocomplete="off"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nacionalidad</label>
                <select name="nacionalidad" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-white">
                    <option value="" disabled {{ old('nacionalidad') ? '' : 'selected' }}>
                        Selecciona tu nacionalidad
                    </option>
                    @php
                    $nacionalidades = [
                        'Peru','Argentina','Bolivia','Brasil','Chile',
                        'Colombia','Cuba','Ecuador','España','EEUU',
                        'Francesa','Guatemala','Honduras','Italiana','Japonesa',
                        'Mexicana','Nicaragua','Panama','Paraguay','Puerto Rico',
                        'Suiza','Uruguay','Venezuela','Alemana','Australiana',
                        'Belga','Canadiense','China','Corea','Portugues','Rusa',
                        'Turca','Otra',
                    ];
                    @endphp
                    @foreach($nacionalidades as $nac)
                        <option value="{{ $nac }}"
                            {{ old('nacionalidad') == $nac ? 'selected' : '' }}>
                            {{ $nac }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" name="password" required minlength="8"
                       autocomplete="new-password"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" required
                       autocomplete="new-password"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <button type="submit"
                    class="w-full bg-doubletree-navy text-white py-2.5 rounded-lg font-medium hover:bg-blue-900 transition mt-2">
                Crear cuenta
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="doubletree-gold font-medium hover:underline">
                Inicia sesión
            </a>
        </p>
    </div>
</div>
@endsection