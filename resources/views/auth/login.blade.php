@extends('layouts.app')
@section('title', 'Iniciar Sesión')

@section('content')
<div class="min-h-screen flex">

    {{-- ══ PANEL IZQUIERDO ══ --}}
    <div class="hidden lg:flex lg:w-5/12 relative flex-col justify-between p-10"
         style="background:#1A3A5C">

        {{-- Fondo decorativo --}}
        <div class="absolute inset-0" style="opacity:.07;background-image:repeating-linear-gradient(0deg,#C9AA71 0,#C9AA71 1px,transparent 0,transparent 40px),repeating-linear-gradient(90deg,#C9AA71 0,#C9AA71 1px,transparent 0,transparent 40px)"></div>
        <div class="absolute rounded-full" style="width:320px;height:320px;border:1px solid rgba(201,170,113,.12);top:-80px;right:-80px"></div>
        <div class="absolute rounded-full" style="width:220px;height:220px;border:1px solid rgba(201,170,113,.08);bottom:60px;left:-60px"></div>

        {{-- Contenido --}}
        <div class="relative z-10 flex flex-col justify-between h-full">

            {{-- Logo --}}
            <div>
                <p class="text-xs tracking-widest uppercase mb-1" style="color:#C9AA71">DoubleTree by</p>
                <h1 class="text-3xl font-light text-white tracking-wide">Hilton Trujillo</h1>
                <p class="text-xs tracking-widest uppercase mt-1" style="color:#6a8fa0">Hotel & Suites</p>
                <div class="mt-5 w-10 h-px" style="background:#C9AA71"></div>
            </div>

            {{-- Frase + badge --}}
            <div>
                <div class="rounded-xl p-6 text-center mb-6"
                     style="background:rgba(255,255,255,.04);border:1px solid rgba(201,170,113,.18)">
                    <div class="text-5xl mb-4" style="color:rgba(201,170,113,.35)">🏨</div>
                    <span class="block text-3xl mb-2" style="color:#C9AA71;line-height:1">"</span>
                    <p class="text-lg font-light text-white italic leading-relaxed mb-3">
                        Donde cada estancia se convierte en un recuerdo inolvidable
                    </p>
                    <p class="text-xs tracking-widest uppercase" style="color:#6a8fa0">
                        Av. El Golf 591, Trujillo, Perú
                    </p>
                </div>

                <div class="flex items-center gap-3 rounded-lg px-4 py-3"
                     style="background:rgba(201,170,113,.08);border:1px solid rgba(201,170,113,.15)">
                    <span class="text-xl" style="color:#C9AA71">★</span>
                    <div>
                        <p class="text-sm font-medium" style="color:#C9AA71">Hotel 4 Estrellas</p>
                        <p class="text-xs" style="color:#8aabb5">Valoración 9.1 · Trujillo, La Libertad</p>
                    </div>
                </div>
            </div>

            <p class="text-xs" style="color:#4a6a7a">© {{ date('Y') }} DoubleTree by Hilton Trujillo</p>
        </div>
    </div>

    {{-- ══ PANEL DERECHO: FORMULARIO ══ --}}
    <div class="w-full lg:w-7/12 flex items-center justify-center px-6 py-12 bg-gray-50">
        <div class="w-full max-w-sm">

            <h2 class="text-2xl font-bold mb-1" style="color:#1A3A5C">Iniciar sesión</h2>
            <p class="text-sm text-gray-400 mb-8">Ingresa tus credenciales para continuar</p>

            @if($errors->any())
                <div class="rounded-xl px-4 py-3 mb-6 text-sm"
                     style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" autocomplete="off" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide mb-1.5"
                           style="color:#4b5563">
                        Correo electrónico
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           autocomplete="new-password" placeholder="correo@ejemplo.com"
                           class="w-full px-4 py-3 rounded-xl text-sm bg-white focus:outline-none focus:ring-2"
                           style="border:1.5px solid #e5e7eb;color:#1f2937"
                           onfocus="this.style.borderColor='#1A3A5C'"
                           onblur="this.style.borderColor='#e5e7eb'">
                </div>

                {{-- Contraseña --}}
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide mb-1.5"
                           style="color:#4b5563">
                        Contraseña
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                               autocomplete="new-password" placeholder="Tu contraseña"
                               class="w-full px-4 py-3 pr-12 rounded-xl text-sm bg-white focus:outline-none"
                               style="border:1.5px solid #e5e7eb;color:#1f2937"
                               onfocus="this.style.borderColor='#1A3A5C'"
                               onblur="this.style.borderColor='#e5e7eb'">
                        <button type="button" onclick="togglePw()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fa fa-eye text-sm" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                {{-- Recordarme / Olvidé --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-500 cursor-pointer">
                        <input type="checkbox" name="remember"
                               class="rounded" style="accent-color:#1A3A5C">
                        Recordarme
                    </label>
                    <a href="#" class="text-sm font-medium hover:underline"
                       style="color:#C9AA71">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>

                {{-- Botón ingresar --}}
                <button type="submit"
                        class="w-full py-3 rounded-xl text-sm font-semibold text-white tracking-wide transition hover:opacity-90"
                        style="background:#1A3A5C">
                    Ingresar
                </button>

                {{-- Separador --}}
                <div class="flex items-center gap-3 my-1">
                    <div class="flex-1 h-px bg-gray-200"></div>
                    <span class="text-xs text-gray-400">o continúa con</span>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>

                {{-- Google --}}
                <a href="#" {{-- route('auth.google') ?? '#' --}}
                   class="w-full py-3 rounded-xl text-sm font-medium flex items-center justify-center gap-3 transition hover:border-yellow-400 bg-white"
                   style="border:1.5px solid #e5e7eb;color:#374151;text-decoration:none">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908C16.658 14.251 17.64 11.943 17.64 9.2z" fill="#4285F4"/>
                        <path d="M9 18c2.43 0 4.467-.806 5.956-2.184l-2.908-2.258c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332A8.997 8.997 0 0 0 9 18z" fill="#34A853"/>
                        <path d="M3.964 10.707A5.41 5.41 0 0 1 3.682 9c0-.593.102-1.17.282-1.707V4.961H.957A8.996 8.996 0 0 0 0 9c0 1.452.348 2.827.957 4.039l3.007-2.332z" fill="#FBBC05"/>
                        <path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0A8.997 8.997 0 0 0 .957 4.96L3.964 7.293C4.672 5.163 6.656 3.58 9 3.58z" fill="#EA4335"/>
                    </svg>
                    Continuar con Google
                </a>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                ¿No tienes cuenta?
                <a href="{{ route('registro') }}" class="font-semibold hover:underline"
                   style="color:#1A3A5C">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </div>
</div>

<script>
function togglePw() {
    const inp  = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    const show = inp.type === 'password';
    inp.type       = show ? 'text' : 'password';
    icon.className = show ? 'fa fa-eye-slash text-sm' : 'fa fa-eye text-sm';
}
</script>
@endsection