@extends('layouts.app')
@section('title', 'Iniciar Sesión')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-doubletree-navy">Iniciar Sesión</h1>
            <p class="text-gray-500 text-sm mt-1">DoubleTree by Hilton Trujillo</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5" autocomplete="off">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Correo electrónico
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       autocomplete="new-password"
                       placeholder="Ingresa tu correo"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Contraseña
                </label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                           autocomplete="new-password"
                           placeholder="Ingresa tu contraseña"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 pr-12">
                    <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                        <i class="fa fa-eye" id="eye-icon"></i>
                    </button>
                </div>
                <label class="flex items-center gap-2 mt-2 cursor-pointer w-fit">
                    <input type="checkbox" onchange="togglePassword()"
                           class="rounded accent-yellow-500">
                    <span class="text-sm text-gray-500">Mostrar contraseña</span>
                </label>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="rounded">
                <label for="remember" class="text-sm text-gray-600">Recordarme</label>
            </div>

            <button type="submit"
                    class="w-full bg-doubletree-navy text-white py-2.5 rounded-lg font-medium hover:bg-blue-900 transition">
                Ingresar
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            ¿No tienes cuenta?
            <a href="{{ route('registro') }}" class="doubletree-gold font-medium hover:underline">
                Regístrate aquí
            </a>
        </p>
    </div>
</div>

<script>
function togglePassword() {
    const input   = document.getElementById('password');
    const icon    = document.getElementById('eye-icon');
    const visible = input.type === 'text';
    input.type    = visible ? 'password' : 'text';
    icon.className = visible ? 'fa fa-eye' : 'fa fa-eye-slash';
}
</script>
@endsection